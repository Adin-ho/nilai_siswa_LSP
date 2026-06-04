@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
    <div>
        <h1 class="text-3xl font-black">Laporan Nilai</h1>
        <p class="mt-1 text-slate-500">
            Rekap nilai siswa berdasarkan kelas, mata pelajaran, semester, dan status kelulusan.
        </p>
    </div>

    <a href="{{ route('laporan.export-csv', request()->query()) }}"
        class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-5 py-3 font-bold text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700">
        Export CSV / Excel
    </a>
</div>

<div class="mb-6 grid gap-4 md:grid-cols-4">
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-bold text-slate-500">Total Data</p>
        <h2 class="mt-2 text-3xl font-black">{{ $totalData }}</h2>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-bold text-slate-500">Rata-rata</p>
        <h2 class="mt-2 text-3xl font-black">{{ $rataRata }}</h2>
    </div>

    <div class="rounded-3xl border border-green-200 bg-green-50 p-5 shadow-sm">
        <p class="text-sm font-bold text-green-700">Lulus</p>
        <h2 class="mt-2 text-3xl font-black text-green-700">{{ $jumlahLulus }}</h2>
    </div>

    <div class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
        <p class="text-sm font-bold text-red-700">Tidak Lulus</p>
        <h2 class="mt-2 text-3xl font-black text-red-700">{{ $jumlahTidakLulus }}</h2>
    </div>
</div>

<div class="mb-6 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
    <form method="GET" action="{{ route('laporan.index') }}" class="grid gap-4 md:grid-cols-5">
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">Kelas</label>
            <select name="kelas_id"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}" @selected($kelasId == $item->id)>
                        {{ $item->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">Mata Pelajaran</label>
            <select name="mata_pelajaran_id"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                <option value="">Semua Mapel</option>
                @foreach ($mataPelajarans as $mapel)
                    <option value="{{ $mapel->id }}" @selected($mapelId == $mapel->id)>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">Semester</label>
            <select name="semester"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                <option value="">Semua Semester</option>
                <option value="Ganjil" @selected($semester === 'Ganjil')>Ganjil</option>
                <option value="Genap" @selected($semester === 'Genap')>Genap</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700">Cari Siswa</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Nama/NIS"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                class="w-full rounded-2xl bg-slate-900 px-4 py-3 font-black text-white hover:bg-blue-700">
                Tampilkan
            </button>

            <a href="{{ route('laporan.index') }}"
                class="rounded-2xl bg-slate-100 px-4 py-3 font-black text-slate-700 hover:bg-slate-200">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b bg-slate-50 text-slate-600">
                    <th class="px-6 py-4 font-black">No</th>
                    <th class="px-6 py-4 font-black">NIS</th>
                    <th class="px-6 py-4 font-black">Nama Siswa</th>
                    <th class="px-6 py-4 font-black">Kelas</th>
                    <th class="px-6 py-4 font-black">Mata Pelajaran</th>
                    <th class="px-6 py-4 font-black">Guru</th>
                    <th class="px-6 py-4 font-black">Semester</th>
                    <th class="px-6 py-4 font-black">Tugas</th>
                    <th class="px-6 py-4 font-black">UTS</th>
                    <th class="px-6 py-4 font-black">UAS</th>
                    <th class="px-6 py-4 font-black">Nilai Akhir</th>
                    <th class="px-6 py-4 font-black">Predikat</th>
                    <th class="px-6 py-4 font-black">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($nilais as $nilai)
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-6 py-4">
                            {{ $loop->iteration + ($nilais->currentPage() - 1) * $nilais->perPage() }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->siswa->nis ?? '-' }}
                        </td>

                        <td class="px-6 py-4 font-bold">
                            {{ $nilai->siswa->nama_siswa ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->siswa->kelas->nama_kelas ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->mataPelajaran->nama_mapel ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->mataPelajaran->guru->nama_guru ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->semester }} {{ $nilai->tahun_ajaran }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->nilai_tugas }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->nilai_uts }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $nilai->nilai_uas }}
                        </td>

                        <td class="px-6 py-4 font-black text-blue-600">
                            {{ $nilai->nilai_akhir }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">
                                {{ $nilai->predikat }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
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
                        <td colspan="13" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada data laporan sesuai filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t px-6 py-4">
        {{ $nilais->links() }}
    </div>
</div>
@endsection