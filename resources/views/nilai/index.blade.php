@extends('layouts.app')

@section('content')
@php
    $role = auth()->user()->role;
    $canManageNilai = in_array($role, ['admin', 'guru'], true);
@endphp

<div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
    <div>
        <h1 class="text-3xl font-black">{{ $role === 'siswa' ? 'Nilai Saya' : 'Data Nilai' }}</h1>
        <p class="mt-1 text-slate-500">
            @if ($role === 'admin')
                Admin dapat melihat dan mengelola semua nilai.
            @elseif ($role === 'guru')
                Guru hanya mengelola nilai pada mata pelajaran yang diampu.
            @else
                Siswa hanya dapat melihat nilai miliknya sendiri.
            @endif
        </p>
    </div>

    @if ($canManageNilai)
        <a href="{{ route('nilai.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 font-bold text-white shadow-lg shadow-blue-100 transition hover:-translate-y-0.5 hover:bg-blue-700">
            + Tambah Nilai
        </a>
    @endif
</div>

<div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b p-5">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari siswa atau mata pelajaran"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            <button class="rounded-2xl bg-slate-900 px-5 py-3 font-bold text-white">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b bg-slate-50 text-slate-600">
                    <th class="px-6 py-4 font-black">No</th>
                    <th class="px-6 py-4 font-black">Siswa</th>
                    <th class="px-6 py-4 font-black">Kelas</th>
                    <th class="px-6 py-4 font-black">Mapel</th>
                    <th class="px-6 py-4 font-black">Semester</th>
                    <th class="px-6 py-4 font-black">Tugas</th>
                    <th class="px-6 py-4 font-black">UTS</th>
                    <th class="px-6 py-4 font-black">UAS</th>
                    <th class="px-6 py-4 font-black">Akhir</th>
                    <th class="px-6 py-4 font-black">Predikat</th>
                    @if ($canManageNilai)
                        <th class="px-6 py-4 text-right font-black">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($nilais as $item)
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $loop->iteration + ($nilais->currentPage() - 1) * $nilais->perPage() }}</td>
                        <td class="px-6 py-4 font-bold">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->semester }} {{ $item->tahun_ajaran }}</td>
                        <td class="px-6 py-4">{{ $item->nilai_tugas }}</td>
                        <td class="px-6 py-4">{{ $item->nilai_uts }}</td>
                        <td class="px-6 py-4">{{ $item->nilai_uas }}</td>
                        <td class="px-6 py-4 font-black text-blue-600">{{ $item->nilai_akhir }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">{{ $item->predikat }}</span>
                        </td>
                        @if ($canManageNilai)
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('nilai.edit', $item) }}" class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-black text-amber-700 hover:bg-amber-100">Edit</a>
                                    <form action="{{ route('nilai.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-red-50 px-3 py-2 text-xs font-black text-red-700 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $canManageNilai ? 11 : 10 }}" class="px-6 py-10 text-center text-slate-500">Belum ada data nilai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t px-6 py-4">{{ $nilais->links() }}</div>
</div>
@endsection
