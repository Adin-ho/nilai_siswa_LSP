@extends('layouts.app')

@section('content')
<div class="mb-8 rounded-[2rem] bg-gradient-to-r from-blue-600 via-indigo-700 to-slate-900 p-8 text-white shadow-xl shadow-blue-100">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="mb-2 text-sm font-black uppercase tracking-wide text-blue-100">Dashboard Admin</p>
            <h1 class="text-3xl font-black md:text-4xl">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="mt-3 max-w-2xl text-blue-100">Kelola data kelas, siswa, guru, mata pelajaran, nilai, dan laporan dari satu panel.</p>
        </div>
        <a href="{{ route('nilai.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-black text-blue-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-50">
            + Input Nilai
        </a>
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
    @foreach ([
        ['label' => 'Total Kelas', 'value' => $totalKelas, 'icon' => '🏫'],
        ['label' => 'Total Siswa', 'value' => $totalSiswa, 'icon' => '🎓'],
        ['label' => 'Total Guru', 'value' => $totalGuru, 'icon' => '👨‍🏫'],
        ['label' => 'Mata Pelajaran', 'value' => $totalMapel, 'icon' => '📚'],
        ['label' => 'Data Nilai', 'value' => $totalNilai, 'icon' => '📝'],
    ] as $card)
        <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-2xl">{{ $card['icon'] }}</div>
            <p class="text-sm font-bold text-slate-500">{{ $card['label'] }}</p>
            <h2 class="mt-1 text-4xl font-black text-slate-900">{{ $card['value'] }}</h2>
        </div>
    @endforeach
</div>

<div class="mt-8 grid gap-6 xl:grid-cols-[1.4fr_.6fr]">
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 p-6">
            <div>
                <h2 class="text-xl font-black">Nilai Terbaru</h2>
                <p class="text-sm text-slate-500">Daftar nilai yang terakhir diinput.</p>
            </div>
            <a href="{{ route('nilai.index') }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-black text-slate-700 hover:bg-slate-200">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Nilai Akhir</th>
                        <th class="px-6 py-4">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($nilaiTerbaru as $nilai)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $nilai->siswa->nama_siswa ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td>
                            <td class="px-6 py-4 font-black text-blue-600">{{ $nilai->nilai_akhir }}</td>
                            <td class="px-6 py-4"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">{{ $nilai->predikat }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-slate-500">Belum ada data nilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-black">Akses Cepat</h2>
        <p class="mb-4 text-sm text-slate-500">Menu utama sesuai wireframe.</p>
        <div class="grid gap-3">
            <a href="{{ route('siswa.index') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Data Siswa</a>
            <a href="{{ route('guru.index') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Data Guru</a>
            <a href="{{ route('mata-pelajaran.index') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Mata Pelajaran</a>
            <a href="{{ route('nilai.index') }}" class="rounded-2xl border border-slate-200 p-4 font-black transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Rekap Nilai</a>
        </div>
    </section>
</div>
@endsection
