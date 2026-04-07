<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id('id_rule');
            $table->foreignId('id_penyakit')->constrained('penyakit', 'id_penyakit')->cascadeOnDelete();
            $table->foreignId('id_gejala')->constrained('gejala', 'id_gejala')->cascadeOnDelete();
            $table->decimal('mb', 3, 2);
            $table->decimal('md', 3, 2); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
