<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });

        Schema::create('konsultasi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_konsultasi')->constrained('konsultasi')->cascadeOnDelete();
            $table->foreignId('id_gejala')->constrained('gejala', 'id_gejala')->cascadeOnDelete();
            $table->decimal('nilai_user', 3, 2); // keyakinan user: 0.00 - 1.00
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi_detail');
        Schema::dropIfExists('konsultasi');
    }
};
