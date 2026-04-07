<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator',
            'umur' => 30,
            'jenis_kelamin' => 'pria',
            'alamat' => 'Sistem',
            'no_telepon' => '08123456789',
            'role' => 'admin'
        ]);
    }
}
