<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $gejala = [
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Nyeri ulu hati'],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Mual'],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Muntah'],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Perut kembung'],
            ['kode_gejala' => 'G05', 'nama_gejala' => 'Cepat kenyang'],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Sendawa berlebihan'],
            ['kode_gejala' => 'G07', 'nama_gejala' => 'Nyeri perut setelah makan'],
            ['kode_gejala' => 'G08', 'nama_gejala' => 'Heartburn (sensasi terbakar di dada)'],
            ['kode_gejala' => 'G09', 'nama_gejala' => 'BAB berdarah atau hitam'],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Penurunan berat badan'],
        ];

        DB::table('gejala')->insert($gejala);
    }
}
