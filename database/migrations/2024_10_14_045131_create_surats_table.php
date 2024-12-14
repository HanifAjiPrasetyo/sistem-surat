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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('userData_id')->nullable();
            $table->string('keperluan');
            $table->string('lampiran_ktp');
            $table->json('lampiran_lain');
            $table->enum('status', ['diajukan', 'disetujui_admin', 'ditolak_admin', 'disetujui_rt', 'ditolak_rt', 'disetujui_rw', 'ditolak_rw', 'selesai'])->default('diajukan');
            $table->string('catatan_admin')->default('');
            $table->string('catatan_rt')->default('');
            $table->string('catatan_rw')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
