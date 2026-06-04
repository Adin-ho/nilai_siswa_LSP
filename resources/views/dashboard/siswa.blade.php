@extends('layouts.app')

@section('content')
<div class="mb-8 rounded-[2rem] bg-gradient-to-r from-violet-600 via-purple-700 to-slate-800 p-8 text-white shadow-xl shadow-purple-100">
    <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-purple-100">Dashboard Siswa</p>
    <h1 class="text-3xl font-black md:text-4xl">
        Halo, {{ $siswa->nama_siswa ?? auth()->user()->name }}
    </h1>
    <p class="mt-3 max-w-2xl text-purple-100">
        Siswa dapat melihat nilai akademiknya sendiri.
    </p>
</div>

<div class="grid gap-5 md:grid-cols-3">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-semibold text-slate-500">Total Nilai</p>
        <h2 class="mt-2 text-4xl font-black">{{ $totalNilai }}</h2>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-semibold text-slate-500">Rata-rata Nilai</p>
        <h2 class="mt-2 text-4xl font-black">{{ $rataRata }}</h2>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-semibold text-slate-500">Status Umum</p>

        <h2 class="mt-2 text-3xl font-black">
            @if ($rataRata >= 75)
                <span class="text-green-600">Lulus</span>
            @else
                <span class="text-red-600">Tidak Lulus</span>
            @endif
        </h2>
    </div>
</div>

<div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-xl font-black">Nilai Pribadi</h2>
    <p class="mb-5 text-sm text-slate-500">
        Daftar nilai berdasarkan mata pelajaran.
    </p>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-y bg-slate-50 text-slate-600">
                    <th class="px-4 py-3 font-bold">Mata Pelajaran</th>
                    <th class="px-4 py-3 font-bold">Semester</th>
                    <th class="px-4 py-3 font-bold">Tugas</th>
                    <th class="px-4 py-3 font-bold">UTS</th>
                    <th class="px-4 py-3 font-bold">UAS</th>
                    <th class="px-4 py-3 font-bold">Nilai Akhir</th>
                    <th class="px-4 py-3 font-bold">Predikat</th>
                    <th class="px-4 py-3 font-bold">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($nilaiSaya as $nilai)
                    <tr>
                        <td class="px-4 py-4 font-semibold">
                            {{ $nilai->mataPelajaran->nama_mapel ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $nilai->semester }} {{ $nilai->tahun_ajaran }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $nilai->nilai_tugas }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $nilai->nilai_uts }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $nilai->nilai_uas }}
                        </td>

                        <td class="px-4 py-4 font-black text-blue-600">
                            {{ $nilai->nilai_akhir }}
                        </td>

                        <td class="px-4 py-4">
                            <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-black text-violet-700">
                                {{ $nilai->predikat }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            @if ($nilai->nilai_akhir >= 75)
                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700">
                                    Lulus
                                </span>
                            @else
                                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-black text-red-700">
                                    Tidak Lulus
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                            Belum ada data nilai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection