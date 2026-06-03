@extends('layouts.app')

@section('content')
<h1 class="mb-6 text-2xl font-black text-slate-900">Edit Data Siswa</h1>

<div class="max-w-2xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ route('siswa.update', $siswa) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Nama Siswa</label>
            <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'L')>Laki-laki</option>
                <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'P')>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Kelas</label>
            <select name="kelas_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}" @selected(old('kelas_id', $siswa->kelas_id) == $item->id)>{{ $item->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('alamat', $siswa->alamat) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button class="rounded-2xl bg-slate-900 px-5 py-3 font-black text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-blue-700">Update</button>
            <a href="{{ route('siswa.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 font-black text-slate-700 hover:bg-slate-200">Kembali</a>
        </div>
    </form>
</div>
@endsection
