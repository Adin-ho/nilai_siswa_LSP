@extends('layouts.app')

@section('content')
<div class="mb-8 overflow-hidden rounded-[2rem] bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 p-8 text-white shadow-xl shadow-blue-200">
    <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
        <div>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-blue-100">Dashboard Admin</p>
            <h1 class="text-3xl font-black md:text-4xl">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="mt-3 max-w-2xl text-blue-100">Pantau data kelas, siswa, guru, mata pelajaran, dan nilai siswa dari satu halaman.</p>
        </div>
        <div class="rounded-3xl border border-white/20 bg-white/10 p-5 backdrop-blur">
            <p class="text-sm text-blue-100">Total Data Nilai</p>
            <p class="mt-1 text-4xl font-black">{{ $totalNilai }}</p>
        </div>
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"><p class="text-sm font-semibold text-slate-500">Total Kelas</p><h2 class="mt-2 text-4xl font-black">{{ $totalKelas }}</h2></div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"><p class="text-sm font-semibold text-slate-500">Total Siswa</p><h2 class="mt-2 text-4xl font-black">{{ $totalSiswa }}</h2></div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"><p class="text-sm font-semibold text-slate-500">Total Guru</p><h2 class="mt-2 text-4xl font-black">{{ $totalGuru }}</h2></div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"><p class="text-sm font-semibold text-slate-500">Mata Pelajaran</p><h2 class="mt-2 text-4xl font-black">{{ $totalMapel }}</h2></div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"><p class="text-sm font-semibold text-slate-500">Data Nilai</p><h2 class="mt-2 text-4xl font-black">{{ $totalNilai }}</h2></div>
</div>

<div class="mt-8 grid gap-6 xl:grid-cols-3">
    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-black">Nilai Terbaru</h2>
                <p class="text-sm text-slate-500">Daftar input nilai terakhir.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-black text-slate-700 hover:bg-slate-200">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead><tr class="border-y bg-slate-50 text-slate-600"><th class="px-4 py-3 font-black">Siswa</th><th class="px-4 py-3 font-black">Mata Pelajaran</th><th class="px-4 py-3 font-black">Nilai Akhir</th><th class="px-4 py-3 font-black">Predikat</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($nilaiTerbaru as $nilai)
                        <tr class="hover:bg-slate-50"><td class="px-4 py-4 font-semibold">{{ $nilai->siswa->nama_siswa ?? '-' }}</td><td class="px-4 py-4">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td><td class="px-4 py-4 font-black text-blue-600">{{ $nilai->nilai_akhir }}</td><td class="px-4 py-4"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">{{ $nilai->predikat }}</span></td></tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada data nilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-black">Menu Cepat</h2>
        <p class="mb-5 text-sm text-slate-500">Akses fitur utama.</p>
        <div class="grid gap-3">
            <a href="{{ route('siswa.create') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">+ Tambah Siswa</a>
            <a href="{{ route('guru.create') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">+ Tambah Guru</a>
            <a href="{{ route('mata-pelajaran.create') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">+ Tambah Mata Pelajaran</a>
            <a href="{{ route('nilai.create') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">+ Input Nilai</a>
        </div>
    </div>
</div>
@endsection
