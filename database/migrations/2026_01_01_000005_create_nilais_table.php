<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran', 20);
            $table->decimal('nilai_tugas', 5, 2);
            $table->decimal('nilai_uts', 5, 2);
            $table->decimal('nilai_uas', 5, 2);
            $table->decimal('nilai_akhir', 5, 2);
            $table->string('predikat', 2);
            $table->timestamps();

            $table->unique(
                ['siswa_id', 'mata_pelajaran_id', 'semester', 'tahun_ajaran'],
                'unique_nilai_siswa_mapel_semester_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
