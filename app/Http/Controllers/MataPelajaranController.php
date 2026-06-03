<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $mataPelajarans = MataPelajaran::with('guru')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_mapel', 'like', "%{$search}%")
                    ->orWhere('nama_mapel', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mata-pelajaran.index', compact('mataPelajarans', 'search'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('mata-pelajaran.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:30', 'unique:mata_pelajarans,kode_mapel'],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'guru_id' => ['nullable', 'exists:gurus,id'],
            'keterangan' => ['nullable', 'string'],
        ]);

        MataPelajaran::create($data);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Data mata pelajaran berhasil ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        return redirect()->route('mata-pelajaran.edit', $mataPelajaran);
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('mata-pelajaran.edit', compact('mataPelajaran', 'gurus'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $data = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:30', 'unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'guru_id' => ['nullable', 'exists:gurus,id'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $mataPelajaran->update($data);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->nilais()->exists()) {
            return back()->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki data nilai.');
        }

        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Data mata pelajaran berhasil dihapus.');
    }
}
