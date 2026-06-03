@extends('layouts.app')

@section('content')
<h1 class="mb-6 text-2xl font-black text-slate-900">Tambah Mata Pelajaran</h1>

<div class="max-w-2xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ route('mata-pelajaran.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Kode Mapel</label>
            <input type="text" name="kode_mapel" value="{{ old('kode_mapel') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Guru Pengampu</label>
            <select name="guru_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                <option value="">Tidak ada</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" @selected(old('guru_id') == $guru->id)>{{ $guru->nama_guru }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-slate-700">Keterangan</label>
            <textarea name="keterangan" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button class="rounded-2xl bg-slate-900 px-5 py-3 font-black text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('mata-pelajaran.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 font-black text-slate-700 hover:bg-slate-200">Kembali</a>
        </div>
    </form>
</div>
@endsection
