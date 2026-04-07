<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Middleware untuk cek admin
    public function __construct()
    {
        if (session('role') !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function dashboard()
    {
        $stats = [
            'total_gejala' => DB::table('gejala')->count(),
            'total_penyakit' => DB::table('penyakit')->count(),
            'total_rules' => DB::table('rules')->count(),
            'total_users' => DB::table('users')->where('role', 'pengguna')->count(),
            'total_konsultasi' => DB::table('konsultasi')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
