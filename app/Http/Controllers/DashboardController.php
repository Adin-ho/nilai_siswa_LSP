<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            return $this->guruDashboard();
        }

        if ($user->role === 'siswa') {
            return $this->siswaDashboard();
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        return view('dashboard.admin', [
            'totalKelas' => Kelas::count(),
            'totalSiswa' => Siswa::count(),
            'totalGuru' => Guru::count(),
            'totalMapel' => MataPelajaran::count(),
            'totalNilai' => Nilai::count(),
            'nilaiTerbaru' => Nilai::with(['siswa', 'mataPelajaran'])
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }

    private function guruDashboard()
    {
        $user = auth()->user();

        $mapelDiampu = MataPelajaran::where('guru_id', $user->guru_id)->get();

        $nilaiTerbaru = Nilai::with(['siswa.kelas', 'mataPelajaran'])
            ->whereHas('mataPelajaran', function ($query) use ($user) {
                $query->where('guru_id', $user->guru_id);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.guru', [
            'guru' => $user->guru,
            'mapelDiampu' => $mapelDiampu,
            'totalMapelDiampu' => $mapelDiampu->count(),
            'totalNilaiDiinput' => Nilai::whereHas('mataPelajaran', function ($query) use ($user) {
                $query->where('guru_id', $user->guru_id);
            })->count(),
            'nilaiTerbaru' => $nilaiTerbaru,
        ]);
    }

    private function siswaDashboard()
    {
        $user = auth()->user();

        $nilaiSaya = Nilai::with(['mataPelajaran', 'siswa.kelas'])
            ->where('siswa_id', $user->siswa_id)
            ->latest()
            ->get();

        return view('dashboard.siswa', [
            'siswa' => $user->siswa,
            'totalNilai' => $nilaiSaya->count(),
            'rataRata' => round($nilaiSaya->avg('nilai_akhir') ?? 0, 2),
            'nilaiSaya' => $nilaiSaya,
        ]);
    }
}
