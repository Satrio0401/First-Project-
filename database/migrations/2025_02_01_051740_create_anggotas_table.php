<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_wa')->nullable();
            $table->year('tahun_masuk_kuliah')->nullable();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->year('tahun_lk1')->nullable();
            $table->foreignId('komisariat_id')->nullable()->constrained('komisariats')->nullOnDelete();
            $table->year('tahun_lk2')->nullable();
            $table->string('cabang_lk2')->nullable();
            $table->year('tahun_lk3')->nullable();
            $table->string('badko_lk3')->nullable();
            $table->year('tahun_lkk')->nullable();
            $table->string('cabang_lkk')->nullable();
            $table->text('prestasi')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
