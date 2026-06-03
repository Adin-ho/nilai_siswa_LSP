@extends('layouts.app')

@section('content')
<div class="mb-8 rounded-[2rem] bg-gradient-to-r from-violet-600 via-purple-700 to-slate-900 p-8 text-white shadow-xl shadow-purple-100">
    <p class="mb-2 text-sm font-black uppercase tracking-wide text-purple-100">Dashboard Siswa</p>
    <h1 class="text-3xl font-black md:text-4xl">Halo, {{ $siswa->nama_siswa ?? auth()->user()->name }}</h1>
    <p class="mt-3 max-w-2xl text-purple-100">Lihat nilai pribadi, nilai akhir, dan predikat hasil belajar.</p>
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 grid h-12 w-12 place-items-center rounded-2xl bg-violet-50 text-2xl">📝</div>
        <p class="text-sm font-bold text-slate-500">Total Nilai</p>
        <h2 class="mt-1 text-4xl font-black text-slate-900">{{ $totalNilai }}</h2>
    </div>
    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 grid h-12 w-12 place-items-center rounded-2xl bg-violet-50 text-2xl">⭐</div>
        <p class="text-sm font-bold text-slate-500">Rata-rata Nilai</p>
        <h2 class="mt-1 text-4xl font-black text-slate-900">{{ $rataRata }}</h2>
    </div>
</div>

<section class="mt-8 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-6">
        <h2 class="text-xl font-black">Nilai Saya</h2>
        <p class="text-sm text-slate-500">Daftar nilai berdasarkan mata pelajaran.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-600">
                    <th class="px-6 py-4">Mata Pelajaran</th>
                    <th class="px-6 py-4">Semester</th>
                    <th class="px-6 py-4">Tugas</th>
                    <th class="px-6 py-4">UTS</th>
                    <th class="px-6 py-4">UAS</th>
                    <th class="px-6 py-4">Akhir</th>
                    <th class="px-6 py-4">Predikat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($nilaiSaya as $nilai)
                    <tr>
                        <td class="px-6 py-4 font-bold">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $nilai->semester }} {{ $nilai->tahun_ajaran }}</td>
                        <td class="px-6 py-4">{{ $nilai->nilai_tugas }}</td>
                        <td class="px-6 py-4">{{ $nilai->nilai_uts }}</td>
                        <td class="px-6 py-4">{{ $nilai->nilai_uas }}</td>
                        <td class="px-6 py-4 font-black text-violet-600">{{ $nilai->nilai_akhir }}</td>
                        <td class="px-6 py-4"><span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-black text-violet-700">{{ $nilai->predikat }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-10 text-center text-slate-500">Belum ada data nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
