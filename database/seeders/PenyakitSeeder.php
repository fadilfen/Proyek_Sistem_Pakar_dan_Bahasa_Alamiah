<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        $penyakit = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Gastritis (Maag)',
                'deskripsi' => 'Peradangan pada dinding lambung yang menyebabkan nyeri dan ketidaknyamanan.',
                'solusi' => 'Hindari makanan pedas, asam, dan berlemak. Makan teratur, konsumsi obat maag, dan kurangi stres.'
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'GERD (Gastroesophageal Reflux Disease)',
                'deskripsi' => 'Kondisi dimana asam lambung naik ke kerongkongan menyebabkan sensasi terbakar di dada.',
                'solusi' => 'Hindari makanan pemicu (cokelat, kopi, alkohol), jangan langsung tidur setelah makan, tinggikan bantal saat tidur.'
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Tukak Lambung (Ulkus Peptikum)',
                'deskripsi' => 'Luka terbuka pada dinding lambung yang menyebabkan nyeri hebat.',
                'solusi' => 'Konsultasi dokter untuk antibiotik (jika ada H. pylori), hindari NSAID, berhenti merokok, makan teratur.'
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Dispepsia Fungsional',
                'deskripsi' => 'Gangguan pencernaan tanpa penyebab organik yang jelas, sering dipicu stres.',
                'solusi' => 'Kelola stres, makan porsi kecil tapi sering, hindari makanan bergas, olahraga teratur.'
            ],
        ];

        DB::table('penyakit')->insert($penyakit);
    }
}
