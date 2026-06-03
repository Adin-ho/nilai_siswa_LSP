@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-2xl font-black text-slate-900">Data Mata Pelajaran</h1>
        <p class="text-slate-500">Kelola data mata pelajaran.</p>
    </div>
    <a href="{{ route('mata-pelajaran.create') }}" class="rounded-2xl bg-slate-900 px-5 py-3 font-black text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-blue-700">
        Tambah Mapel
    </a>
</div>

<div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
    <form method="GET" class="mb-5 flex flex-col gap-2 sm:flex-row">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama mapel"
            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        <button class="rounded-2xl bg-slate-900 px-5 py-3 font-black text-white hover:bg-blue-700">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead>
                <tr class="bg-slate-50 text-left text-slate-600">
                    <th class="border-b border-slate-100 px-4 py-3">No</th>
                    <th class="border-b border-slate-100 px-4 py-3">Kode</th>
                    <th class="border-b border-slate-100 px-4 py-3">Nama Mapel</th>
                    <th class="border-b border-slate-100 px-4 py-3">Guru</th>
                    <th class="border-b border-slate-100 px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mataPelajarans as $item)
                    <tr>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $loop->iteration + ($mataPelajarans->currentPage() - 1) * $mataPelajarans->perPage() }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->kode_mapel }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->nama_mapel }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->guru->nama_guru ?? '-' }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">
                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="{{ route('mata-pelajaran.edit', $item) }}" class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-black text-amber-700 hover:bg-amber-100">Edit</a>
                                <form action="{{ route('mata-pelajaran.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-red-50 px-3 py-2 text-xs font-black text-red-700 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-3 py-4 text-center text-slate-500">Belum ada data mata pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $mataPelajarans->links() }}</div>
</div>
@endsection
