@extends('layouts.app')

@section('content')
<div class="mb-8 rounded-[2rem] bg-gradient-to-r from-emerald-600 via-teal-700 to-slate-900 p-8 text-white shadow-xl shadow-emerald-100">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="mb-2 text-sm font-black uppercase tracking-wide text-emerald-100">Dashboard Guru</p>
            <h1 class="text-3xl font-black md:text-4xl">Halo, {{ $guru->nama_guru ?? auth()->user()->name }}</h1>
            <p class="mt-3 max-w-2xl text-emerald-100">Kelola nilai sesuai mata pelajaran yang diampu.</p>
        </div>
        <a href="{{ route('nilai.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-black text-emerald-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-emerald-50">
            + Input Nilai
        </a>
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-2xl">📚</div>
        <p class="text-sm font-bold text-slate-500">Mata Pelajaran Diampu</p>
        <h2 class="mt-1 text-4xl font-black text-slate-900">{{ $totalMapelDiampu }}</h2>
    </div>
    <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-2xl">📝</div>
        <p class="text-sm font-bold text-slate-500">Nilai Diinput</p>
        <h2 class="mt-1 text-4xl font-black text-slate-900">{{ $totalNilaiDiinput }}</h2>
    </div>
</div>

<div class="mt-8 grid gap-6 xl:grid-cols-2">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-black">Mata Pelajaran Saya</h2>
        <p class="mb-4 text-sm text-slate-500">Mapel yang boleh dikelola oleh guru.</p>
        <div class="space-y-3">
            @forelse ($mapelDiampu as $mapel)
                <div class="rounded-2xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50">
                    <p class="font-black text-slate-900">{{ $mapel->nama_mapel }}</p>
                    <p class="text-sm text-slate-500">Kode: {{ $mapel->kode_mapel }}</p>
                </div>
            @empty
                <p class="rounded-2xl bg-slate-50 p-4 text-slate-500">Belum ada mata pelajaran yang diampu.</p>
            @endforelse
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black">Nilai Terbaru</h2>
                <p class="text-sm text-slate-500">Input nilai terakhir.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-black text-slate-700 hover:bg-slate-200">Rekap</a>
        </div>
        <div class="mt-4 space-y-3">
            @forelse ($nilaiTerbaru as $nilai)
                <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4">
                    <div>
                        <p class="font-black">{{ $nilai->siswa->nama_siswa ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-black text-emerald-700">{{ $nilai->nilai_akhir }}</span>
                </div>
            @empty
                <p class="rounded-2xl bg-slate-50 p-4 text-slate-500">Belum ada nilai yang diinput.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
