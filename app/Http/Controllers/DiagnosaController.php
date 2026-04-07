<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Gejala;
use App\Models\Penyakit;

class DiagnosaController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $gejala = Gejala::all();
        $username = session('username', 'User');
        return view('diagnosa', compact('gejala', 'username'));
    }

    public function proses(Request $request)
    {
        // Cek login
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Validasi input
        $gejalaInput = $request->input('gejala', []);
        $nilaiUser = $request->input('nilai', []);

        if (empty($gejalaInput)) {
            return back()->with('error', 'Pilih minimal 1 gejala!');
        }

        // Format data untuk API
        $data = [];
        foreach ($gejalaInput as $kode) {
            $data[$kode] = isset($nilaiUser[$kode]) ? (float)$nilaiUser[$kode] : 1.0;
        }

        try {
            // Kirim ke API Python
            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('http://127.0.0.1:8001/diagnosa', [
                    'gejala' => $data
                ]);

            if (!$response->successful()) {
                return back()->with('error', 'API Python error. Pastikan FastAPI berjalan di port 8001');
            }

            $hasil = $response->json();
            
            // Validasi response
            if (!isset($hasil['hasil_utama']) || !isset($hasil['top_hasil'])) {
                return back()->with('error', 'Format response tidak valid dari API Python');
            }

            // Ambil detail penyakit dari database
            $penyakitUtama = Penyakit::where('nama_penyakit', $hasil['hasil_utama']['penyakit'])->first();
            
            // Simpan ke database (riwayat konsultasi)
            $konsultasiId = \DB::table('konsultasi')->insertGetId([
                'user_id' => session('user_id'),
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Simpan detail gejala yang dipilih
            foreach ($gejalaInput as $kode) {
                $gejala = Gejala::where('kode_gejala', $kode)->first();
                if ($gejala) {
                    \DB::table('konsultasi_detail')->insert([
                        'id_konsultasi' => $konsultasiId,
                        'id_gejala' => $gejala->id_gejala,
                        'nilai_user' => $data[$kode],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Simpan hasil diagnosa
            \DB::table('konsultasi')->where('id', $konsultasiId)->update([
                'hasil_diagnosa' => $hasil['hasil_utama']['penyakit'],
                'nilai_cf' => $hasil['hasil_utama']['cf']
            ]);
            
            // Ambil detail untuk top hasil
            $topHasilDetail = [];
            foreach ($hasil['top_hasil'] as $item) {
                $penyakit = Penyakit::where('nama_penyakit', $item['penyakit'])->first();
                $topHasilDetail[] = [
                    'penyakit' => $item['penyakit'],
                    'cf' => $item['cf'],
                    'detail' => $penyakit
                ];
            }

            return view('hasil', compact('hasil', 'penyakitUtama', 'topHasilDetail'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Tidak dapat terhubung ke API Python. Pastikan FastAPI berjalan di http://127.0.0.1:8001');
        }
    }
}
