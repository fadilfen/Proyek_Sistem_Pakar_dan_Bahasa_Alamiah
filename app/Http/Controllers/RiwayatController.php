<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit;

class RiwayatController extends Controller
{
    public function index()
    {
        // Cek login
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = session('user_id');
        $username = session('username', 'User');

        // Ambil riwayat konsultasi user
        $riwayat = DB::table('konsultasi')
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('riwayat', compact('riwayat', 'username'));
    }

    public function detail($id)
    {
        // Cek login
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = session('user_id');
        $username = session('username', 'User');

        // Ambil data konsultasi
        $konsultasi = DB::table('konsultasi')
            ->where('id', $id)
            ->where('user_id', $userId) // Pastikan hanya user yang bersangkutan
            ->first();

        if (!$konsultasi) {
            return redirect()->route('riwayat')->with('error', 'Data tidak ditemukan');
        }

        // Ambil detail gejala yang dipilih
        $gejalaDetail = DB::table('konsultasi_detail')
            ->join('gejala', 'konsultasi_detail.id_gejala', '=', 'gejala.id_gejala')
            ->where('konsultasi_detail.id_konsultasi', $id)
            ->select('gejala.kode_gejala', 'gejala.nama_gejala', 'konsultasi_detail.nilai_user')
            ->get();

        // Ambil detail penyakit
        $penyakit = Penyakit::where('nama_penyakit', $konsultasi->hasil_diagnosa)->first();

        return view('riwayat-detail', compact('konsultasi', 'gejalaDetail', 'penyakit', 'username'));
    }
}
