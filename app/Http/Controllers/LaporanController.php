<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $kelasId = $request->get('kelas_id');
        $mapelId = $request->get('mata_pelajaran_id');
        $semester = $request->get('semester');
        $search = $request->get('search');

        $query = Nilai::with(['siswa.kelas', 'mataPelajaran.guru'])
            ->when($user->role === 'guru', function ($query) use ($user) {
                $query->whereHas('mataPelajaran', function ($q) use ($user) {
                    $q->where('guru_id', $user->guru_id);
                });
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->when($mapelId, function ($query) use ($mapelId) {
                $query->where('mata_pelajaran_id', $mapelId);
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            })
            ->latest();

        $nilais = $query->paginate(10)->withQueryString();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $mataPelajarans = MataPelajaran::with('guru')
            ->when($user->role === 'guru', function ($query) use ($user) {
                $query->where('guru_id', $user->guru_id);
            })
            ->orderBy('nama_mapel')
            ->get();

        $summaryQuery = Nilai::with(['siswa.kelas', 'mataPelajaran'])
            ->when($user->role === 'guru', function ($query) use ($user) {
                $query->whereHas('mataPelajaran', function ($q) use ($user) {
                    $q->where('guru_id', $user->guru_id);
                });
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->when($mapelId, function ($query) use ($mapelId) {
                $query->where('mata_pelajaran_id', $mapelId);
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            });

        $totalData = (clone $summaryQuery)->count();
        $rataRata = round((clone $summaryQuery)->avg('nilai_akhir') ?? 0, 2);
        $jumlahLulus = (clone $summaryQuery)->where('nilai_akhir', '>=', 75)->count();
        $jumlahTidakLulus = (clone $summaryQuery)->where('nilai_akhir', '<', 75)->count();

        return view('laporan.index', compact(
            'nilais',
            'kelas',
            'mataPelajarans',
            'kelasId',
            'mapelId',
            'semester',
            'search',
            'totalData',
            'rataRata',
            'jumlahLulus',
            'jumlahTidakLulus'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $user = auth()->user();

        $kelasId = $request->get('kelas_id');
        $mapelId = $request->get('mata_pelajaran_id');
        $semester = $request->get('semester');
        $search = $request->get('search');

        $nilais = Nilai::with(['siswa.kelas', 'mataPelajaran.guru'])
            ->when($user->role === 'guru', function ($query) use ($user) {
                $query->whereHas('mataPelajaran', function ($q) use ($user) {
                    $q->where('guru_id', $user->guru_id);
                });
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->when($mapelId, function ($query) use ($mapelId) {
                $query->where('mata_pelajaran_id', $mapelId);
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->get();

        $filename = 'laporan_nilai_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($nilais) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'NIS',
                'Nama Siswa',
                'Kelas',
                'Mata Pelajaran',
                'Guru',
                'Semester',
                'Tahun Ajaran',
                'Nilai Tugas',
                'Nilai UTS',
                'Nilai UAS',
                'Nilai Akhir',
                'Predikat',
                'Status',
            ]);

            foreach ($nilais as $nilai) {
                fputcsv($handle, [
                    $nilai->siswa->nis ?? '-',
                    $nilai->siswa->nama_siswa ?? '-',
                    $nilai->siswa->kelas->nama_kelas ?? '-',
                    $nilai->mataPelajaran->nama_mapel ?? '-',
                    $nilai->mataPelajaran->guru->nama_guru ?? '-',
                    $nilai->semester,
                    $nilai->tahun_ajaran,
                    $nilai->nilai_tugas,
                    $nilai->nilai_uts,
                    $nilai->nilai_uas,
                    $nilai->nilai_akhir,
                    $nilai->predikat,
                    $nilai->nilai_akhir >= 75 ? 'Lulus' : 'Tidak Lulus',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}