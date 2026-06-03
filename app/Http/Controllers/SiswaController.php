<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $siswas = Siswa::with(['kelas', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nis', 'like', "%{$search}%")
                        ->orWhere('nama_siswa', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('siswa.index', compact('siswas', 'search'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:30', 'unique:siswas,nis'],
            'nama_siswa' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],

            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'email.required' => 'Email login siswa wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email login siswa sudah digunakan.',
            'password.required' => 'Password login siswa wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($data) {
            $siswa = Siswa::create([
                'nis' => $data['nis'],
                'nama_siswa' => $data['nama_siswa'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'kelas_id' => $data['kelas_id'],
            ]);

            User::create([
                'name' => $siswa->nama_siswa,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'siswa',
                'guru_id' => null,
                'siswa_id' => $siswa->id,
            ]);
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa dan akun login siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        return redirect()->route('siswa.edit', $siswa);
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $siswa->load('user');

        $userId = optional($siswa->user)->id;

        $data = $request->validate([
            'nis' => ['required', 'string', 'max:30', Rule::unique('siswas', 'nis')->ignore($siswa->id)],
            'nama_siswa' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],

            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'email.required' => 'Email login siswa wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email login siswa sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($data, $siswa) {
            $siswa->update([
                'nis' => $data['nis'],
                'nama_siswa' => $data['nama_siswa'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'kelas_id' => $data['kelas_id'],
            ]);

            $userData = [
                'name' => $siswa->nama_siswa,
                'email' => $data['email'],
                'role' => 'siswa',
                'guru_id' => null,
                'siswa_id' => $siswa->id,
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            if ($siswa->user) {
                $siswa->user->update($userData);
            } else {
                $userData['password'] = Hash::make($data['password'] ?: 'password');
                User::create($userData);
            }
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa dan akun login siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->nilais()->exists()) {
            return back()->with('error', 'Siswa tidak dapat dihapus karena masih memiliki data nilai.');
        }

        DB::transaction(function () use ($siswa) {
            $siswa->user()->delete();
            $siswa->delete();
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa dan akun login siswa berhasil dihapus.');
    }
}