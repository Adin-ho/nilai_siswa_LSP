<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru', 'siswa'])
                    ->default('admin')
                    ->after('password');
            }

            if (!Schema::hasColumn('users', 'guru_id')) {
                $table->foreignId('guru_id')
                    ->nullable()
                    ->after('role')
                    ->constrained('gurus')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            }

            if (!Schema::hasColumn('users', 'siswa_id')) {
                $table->foreignId('siswa_id')
                    ->nullable()
                    ->after('guru_id')
                    ->constrained('siswas')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'siswa_id')) {
                $table->dropConstrainedForeignId('siswa_id');
            }

            if (Schema::hasColumn('users', 'guru_id')) {
                $table->dropConstrainedForeignId('guru_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};