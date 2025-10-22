<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sejarah_penguruses', function (Blueprint $table) {
            $table->id();
            $table->integer('order_column')->default(0);
            $table->year('periode_mulai');
            $table->year('periode_berakhir');
            $table->string('ketua');
            $table->string('wakil_ketua');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sejarah_penguruses');
    }
};
