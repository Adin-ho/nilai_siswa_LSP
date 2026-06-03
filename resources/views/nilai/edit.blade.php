@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-black">Edit Data Nilai</h1>
    <p class="mt-1 text-slate-500">Perbarui nilai siswa.</p>
</div>

<div class="max-w-3xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ route('nilai.update', $nilai) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-2 block text-sm font-bold">Siswa</label>
            <select name="siswa_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}" @selected(old('siswa_id', $nilai->siswa_id) == $siswa->id)>
                        {{ $siswa->nis }} - {{ $siswa->nama_siswa }} - {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                @foreach ($mataPelajarans as $mapel)
                    <option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id', $nilai->mata_pelajaran_id) == $mapel->id)>
                        {{ $mapel->kode_mapel }} - {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold">Semester</label>
                <select name="semester" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                    <option value="Ganjil" @selected(old('semester', $nilai->semester) == 'Ganjil')>Ganjil</option>
                    <option value="Genap" @selected(old('semester', $nilai->semester) == 'Genap')>Genap</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $nilai->tahun_ajaran) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-bold">Nilai Tugas</label>
                <input type="number" step="0.01" min="0" max="100" name="nilai_tugas" value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold">Nilai UTS</label>
                <input type="number" step="0.01" min="0" max="100" name="nilai_uts" value="{{ old('nilai_uts', $nilai->nilai_uts) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold">Nilai UAS</label>
                <input type="number" step="0.01" min="0" max="100" name="nilai_uas" value="{{ old('nilai_uas', $nilai->nilai_uas) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4 text-sm">
            Nilai akhir saat ini: <strong>{{ $nilai->nilai_akhir }}</strong>, predikat: <strong>{{ $nilai->predikat }}</strong>.
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button class="rounded-2xl bg-blue-600 px-5 py-3 font-black text-white shadow-lg shadow-blue-100 hover:bg-blue-700">Update Data</button>
            <a href="{{ route('nilai.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 font-black text-slate-700 hover:bg-slate-200">Kembali</a>
        </div>
    </form>
</div>
@endsection
