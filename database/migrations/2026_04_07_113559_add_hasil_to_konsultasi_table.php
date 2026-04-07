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
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->string('hasil_diagnosa')->nullable()->after('tanggal');
            $table->decimal('nilai_cf', 5, 4)->nullable()->after('hasil_diagnosa');
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn(['hasil_diagnosa', 'nilai_cf']);
        });
    }
};
