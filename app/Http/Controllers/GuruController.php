<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $gurus = Guru::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                        ->orWhere('nama_guru', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('guru.index', compact('gurus', 'search'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required', 'string', 'max:30', 'unique:gurus,nip'],
            'nama_guru' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],

            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'email.required' => 'Email login guru wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email login guru sudah digunakan.',
            'password.required' => 'Password login guru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($data) {
            $guru = Guru::create([
                'nip' => $data['nip'],
                'nama_guru' => $data['nama_guru'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_hp' => $data['no_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            User::create([
                'name' => $guru->nama_guru,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'guru',
                'guru_id' => $guru->id,
                'siswa_id' => null,
            ]);
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru dan akun login guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return redirect()->route('guru.edit', $guru);
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');

        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $guru->load('user');

        $userId = optional($guru->user)->id;

        $data = $request->validate([
            'nip' => ['required', 'string', 'max:30', Rule::unique('gurus', 'nip')->ignore($guru->id)],
            'nama_guru' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],

            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'email.required' => 'Email login guru wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email login guru sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($data, $guru) {
            $guru->update([
                'nip' => $data['nip'],
                'nama_guru' => $data['nama_guru'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_hp' => $data['no_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            $userData = [
                'name' => $guru->nama_guru,
                'email' => $data['email'],
                'role' => 'guru',
                'guru_id' => $guru->id,
                'siswa_id' => null,
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            if ($guru->user) {
                $guru->user->update($userData);
            } else {
                $userData['password'] = Hash::make($data['password'] ?: 'password');
                User::create($userData);
            }
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru dan akun login guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->mataPelajarans()->exists()) {
            return back()->with('error', 'Guru tidak dapat dihapus karena masih digunakan pada data mata pelajaran.');
        }

        DB::transaction(function () use ($guru) {
            $guru->user()->delete();
            $guru->delete();
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru dan akun login guru berhasil dihapus.');
    }
}