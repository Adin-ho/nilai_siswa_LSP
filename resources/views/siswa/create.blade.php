@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-black">Tambah Data Siswa</h1>
    <p class="mt-1 text-slate-500">Admin mengisi data siswa sekaligus akun login siswa.</p>
</div>

<div class="max-w-3xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ route('siswa.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <h2 class="mb-4 text-lg font-black">Data Siswa</h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold">Nama Siswa</label>
                    <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        required>
                </div>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        required>
                        <option value="">Pilih</option>
                        <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                        <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                </div>
            </div>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-bold">Kelas</label>
                <select name="kelas_id"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" @selected(old('kelas_id') == $item->id)>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-bold">Alamat</label>
                <textarea name="alamat" rows="4"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('alamat') }}</textarea>
            </div>
        </div>

        <div class="rounded-3xl border border-blue-100 bg-blue-50 p-5">
            <h2 class="mb-4 text-lg font-black text-blue-900">Akun Login Siswa</h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-blue-900">Email Login</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@siswa.test"
                        class="w-full rounded-2xl border border-blue-200 bg-white px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-blue-900">Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                        class="w-full rounded-2xl border border-blue-200 bg-white px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        required>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button class="rounded-2xl bg-blue-600 px-5 py-3 font-black text-white shadow-lg shadow-blue-100 hover:bg-blue-700">
                Simpan Data
            </button>

            <a href="{{ route('siswa.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 font-black text-slate-700 hover:bg-slate-200">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection