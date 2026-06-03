<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kelasX = Kelas::firstOrCreate(
            ['nama_kelas' => 'X RPL 1'],
            [
                'wali_kelas' => 'Budi Santoso',
                'keterangan' => 'Kelas contoh untuk pengujian sistem.',
            ]
        );

        $guru = Guru::firstOrCreate(
            ['nip' => '198001012010011001'],
            [
                'nama_guru' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'no_hp' => '081234567890',
                'alamat' => 'Tangerang',
            ]
        );

        $siswa = Siswa::firstOrCreate(
            ['nis' => '2026001'],
            [
                'nama_siswa' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2009-05-10',
                'alamat' => 'Tangerang',
                'kelas_id' => $kelasX->id,
            ]
        );

        $mapel = MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'MTK'],
            [
                'nama_mapel' => 'Matematika',
                'guru_id' => $guru->id,
                'keterangan' => 'Mata pelajaran Matematika.',
            ]
        );

        Nilai::firstOrCreate(
            [
                'siswa_id' => $siswa->id,
                'mata_pelajaran_id' => $mapel->id,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2025/2026',
            ],
            [
                'nilai_tugas' => 85,
                'nilai_uts' => 80,
                'nilai_uas' => 90,
                'nilai_akhir' => 85.50,
                'predikat' => 'A',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@admin.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'guru_id' => null,
                'siswa_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@guru.test'],
            [
                'name' => $guru->nama_guru,
                'password' => Hash::make('password'),
                'role' => 'guru',
                'guru_id' => $guru->id,
                'siswa_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'andi@siswa.test'],
            [
                'name' => $siswa->nama_siswa,
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'guru_id' => null,
                'siswa_id' => $siswa->id,
            ]
        );
    }
}