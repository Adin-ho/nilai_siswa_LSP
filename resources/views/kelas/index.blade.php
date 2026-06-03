@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-2xl font-black text-slate-900">Data Kelas</h1>
        <p class="text-slate-500">Kelola data kelas siswa.</p>
    </div>
    <a href="{{ route('kelas.create') }}" class="rounded-2xl bg-slate-900 px-5 py-3 font-black text-white shadow-lg shadow-slate-200 transition hover:-translate-y-0.5 hover:bg-blue-700">
        Tambah Kelas
    </a>
</div>

<div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead>
                <tr class="bg-slate-50 text-left text-slate-600">
                    <th class="border-b border-slate-100 px-4 py-3">No</th>
                    <th class="border-b border-slate-100 px-4 py-3">Nama Kelas</th>
                    <th class="border-b border-slate-100 px-4 py-3">Wali Kelas</th>
                    <th class="border-b border-slate-100 px-4 py-3">Keterangan</th>
                    <th class="border-b border-slate-100 px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $item)
                    <tr>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->nama_kelas }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->wali_kelas ?? '-' }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">{{ $item->keterangan ?? '-' }}</td>
                        <td class="border-b border-slate-100 px-4 py-3">
                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="{{ route('kelas.edit', $item) }}" class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-black text-amber-700 hover:bg-amber-100">Edit</a>
                                <form action="{{ route('kelas.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-red-50 px-3 py-2 text-xs font-black text-red-700 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-3 py-4 text-center text-slate-500">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $kelas->links() }}
    </div>
</div>
@endsection
