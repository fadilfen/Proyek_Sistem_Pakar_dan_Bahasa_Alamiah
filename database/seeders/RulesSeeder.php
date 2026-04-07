<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulesSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            // Gastritis (P01)
            ['id_penyakit' => 1, 'id_gejala' => 1, 'mb' => 0.80, 'md' => 0.10], // Nyeri ulu hati
            ['id_penyakit' => 1, 'id_gejala' => 2, 'mb' => 0.70, 'md' => 0.15], // Mual
            ['id_penyakit' => 1, 'id_gejala' => 3, 'mb' => 0.60, 'md' => 0.20], // Muntah
            ['id_penyakit' => 1, 'id_gejala' => 4, 'mb' => 0.65, 'md' => 0.15], // Perut kembung
            ['id_penyakit' => 1, 'id_gejala' => 7, 'mb' => 0.75, 'md' => 0.10], // Nyeri perut setelah makan

            // GERD (P02)
            ['id_penyakit' => 2, 'id_gejala' => 1, 'mb' => 0.70, 'md' => 0.15], // Nyeri ulu hati
            ['id_penyakit' => 2, 'id_gejala' => 2, 'mb' => 0.60, 'md' => 0.20], // Mual
            ['id_penyakit' => 2, 'id_gejala' => 6, 'mb' => 0.65, 'md' => 0.15], // Sendawa berlebihan
            ['id_penyakit' => 2, 'id_gejala' => 8, 'mb' => 0.85, 'md' => 0.05], // Heartburn

            // Tukak Lambung (P03)
            ['id_penyakit' => 3, 'id_gejala' => 1, 'mb' => 0.90, 'md' => 0.05], // Nyeri ulu hati
            ['id_penyakit' => 3, 'id_gejala' => 2, 'mb' => 0.65, 'md' => 0.15], // Mual
            ['id_penyakit' => 3, 'id_gejala' => 3, 'mb' => 0.70, 'md' => 0.10], // Muntah
            ['id_penyakit' => 3, 'id_gejala' => 7, 'mb' => 0.80, 'md' => 0.10], // Nyeri perut setelah makan
            ['id_penyakit' => 3, 'id_gejala' => 9, 'mb' => 0.75, 'md' => 0.10], // BAB berdarah
            ['id_penyakit' => 3, 'id_gejala' => 10, 'mb' => 0.60, 'md' => 0.20], // Penurunan berat badan

            // Dispepsia Fungsional (P04)
            ['id_penyakit' => 4, 'id_gejala' => 1, 'mb' => 0.60, 'md' => 0.20], // Nyeri ulu hati
            ['id_penyakit' => 4, 'id_gejala' => 2, 'mb' => 0.70, 'md' => 0.15], // Mual
            ['id_penyakit' => 4, 'id_gejala' => 4, 'mb' => 0.75, 'md' => 0.10], // Perut kembung
            ['id_penyakit' => 4, 'id_gejala' => 5, 'mb' => 0.80, 'md' => 0.10], // Cepat kenyang
            ['id_penyakit' => 4, 'id_gejala' => 6, 'mb' => 0.70, 'md' => 0.15], // Sendawa berlebihan
        ];

        DB::table('rules')->insert($rules);
    }
}
