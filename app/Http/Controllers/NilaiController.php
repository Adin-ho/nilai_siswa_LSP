<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->get('search');

        $nilais = Nilai::with(['siswa.kelas', 'mataPelajaran'])
            ->when($user->role === 'guru', function ($query) use ($user) {
                $query->whereHas('mataPelajaran', function ($q) use ($user) {
                    $q->where('guru_id', $user->guru_id);
                });
            })
            ->when($user->role === 'siswa', function ($query) use ($user) {
                $query->where('siswa_id', $user->siswa_id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('siswa', function ($sub) use ($search) {
                        $sub->where('nama_siswa', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                    })->orWhereHas('mataPelajaran', function ($sub) use ($search) {
                        $sub->where('nama_mapel', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('nilai.index', compact('nilais', 'search'));
    }

    public function create()
    {
        $this->pastikanBolehKelolaNilai();

        $user = auth()->user();

        $siswas = Siswa::with('kelas')->orderBy('nama_siswa')->get();

        $mataPelajarans = MataPelajaran::when($user->role === 'guru', function ($query) use ($user) {
                $query->where('guru_id', $user->guru_id);
            })
            ->orderBy('nama_mapel')
            ->get();

        return view('nilai.create', compact('siswas', 'mataPelajarans'));
    }

    public function store(Request $request)
    {
        $this->pastikanBolehKelolaNilai();

        $data = $this->validateData($request);
        $this->pastikanGuruMengajarMapel($data['mata_pelajaran_id']);

        $data = $this->hitungNilai($data);

        Nilai::create($data);

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai)
    {
        return redirect()->route('nilai.edit', $nilai);
    }

    public function edit(Nilai $nilai)
    {
        $this->pastikanBolehKelolaNilai();
        $this->pastikanBolehAksesNilai($nilai);

        $user = auth()->user();

        $siswas = Siswa::with('kelas')->orderBy('nama_siswa')->get();

        $mataPelajarans = MataPelajaran::when($user->role === 'guru', function ($query) use ($user) {
                $query->where('guru_id', $user->guru_id);
            })
            ->orderBy('nama_mapel')
            ->get();

        return view('nilai.edit', compact('nilai', 'siswas', 'mataPelajarans'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $this->pastikanBolehKelolaNilai();
        $this->pastikanBolehAksesNilai($nilai);

        $data = $this->validateData($request);
        $this->pastikanGuruMengajarMapel($data['mata_pelajaran_id']);

        $data = $this->hitungNilai($data);

        $nilai->update($data);

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $this->pastikanBolehKelolaNilai();
        $this->pastikanBolehAksesNilai($nilai);

        $nilai->delete();

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'semester' => ['required', 'in:Ganjil,Genap'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);
    }

    private function hitungNilai(array $data): array
    {
        $nilaiAkhir = ($data['nilai_tugas'] * 0.30)
            + ($data['nilai_uts'] * 0.30)
            + ($data['nilai_uas'] * 0.40);

        $data['nilai_akhir'] = round($nilaiAkhir, 2);
        $data['predikat'] = $this->tentukanPredikat($data['nilai_akhir']);

        return $data;
    }

    private function tentukanPredikat(float $nilai): string
    {
        if ($nilai >= 85) {
            return 'A';
        }

        if ($nilai >= 75) {
            return 'B';
        }

        if ($nilai >= 65) {
            return 'C';
        }

        if ($nilai >= 50) {
            return 'D';
        }

        return 'E';
    }

    private function pastikanBolehKelolaNilai(): void
    {
        if (!in_array(auth()->user()->role, ['admin', 'guru'], true)) {
            abort(403, 'Siswa hanya dapat melihat nilai.');
        }
    }

    private function pastikanBolehAksesNilai(Nilai $nilai): void
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return;
        }

        if ($user->role === 'guru' && optional($nilai->mataPelajaran)->guru_id === $user->guru_id) {
            return;
        }

        if ($user->role === 'siswa' && $nilai->siswa_id === $user->siswa_id) {
            return;
        }

        abort(403, 'Anda tidak memiliki akses ke data nilai ini.');
    }

    private function pastikanGuruMengajarMapel(int $mataPelajaranId): void
    {
        $user = auth()->user();

        if ($user->role !== 'guru') {
            return;
        }

        $mengajar = MataPelajaran::where('id', $mataPelajaranId)
            ->where('guru_id', $user->guru_id)
            ->exists();

        if (!$mengajar) {
            abort(403, 'Guru hanya boleh menginput nilai untuk mata pelajaran yang diampu.');
        }
    }
}
