<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showDaftar()
    {
        return view('daftar');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::connection('mysql')->table('users')
            ->where('username', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user_id' => $user->id, 'username' => $user->username]);
            return redirect()->route('index');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function daftar(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required|min:6',
                'nama_lengkap' => 'required',
                'umur' => 'required|numeric',
                'jenis_kelamin' => 'required',
                'alamat' => 'required',
                'no_telepon' => 'required',
            ]);

            // Cek apakah username sudah ada
            $exists = DB::connection('mysql')->table('users')
                ->where('username', $request->username)
                ->exists();

            if ($exists) {
                return back()->with('error', 'Username sudah digunakan!');
            }

            // Convert jenis_kelamin to lowercase untuk match dengan enum di database
            $jenisKelamin = strtolower($request->jenis_kelamin);

            DB::connection('mysql')->table('users')->insert([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'umur' => $request->umur,
                'jenis_kelamin' => $jenisKelamin,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
