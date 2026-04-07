<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{
    public function index()
    {
        $rules = DB::table('rules')
            ->join('penyakit', 'rules.id_penyakit', '=', 'penyakit.id_penyakit')
            ->join('gejala', 'rules.id_gejala', '=', 'gejala.id_gejala')
            ->select('rules.*', 'penyakit.nama_penyakit', 'penyakit.kode_penyakit', 
                     'gejala.nama_gejala', 'gejala.kode_gejala')
            ->orderBy('penyakit.kode_penyakit')
            ->orderBy('gejala.kode_gejala')
            ->get();

        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();
        $gejala = Gejala::orderBy('kode_gejala')->get();
        return view('admin.rules.create', compact('penyakit', 'gejala'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penyakit' => 'required|exists:penyakit,id_penyakit',
            'id_gejala' => 'required|exists:gejala,id_gejala',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1'
        ]);

        // Cek duplikasi
        $exists = DB::table('rules')
            ->where('id_penyakit', $request->id_penyakit)
            ->where('id_gejala', $request->id_gejala)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Rule untuk kombinasi penyakit dan gejala ini sudah ada');
        }

        DB::table('rules')->insert([
            'id_penyakit' => $request->id_penyakit,
            'id_gejala' => $request->id_gejala,
            'mb' => $request->mb,
            'md' => $request->md,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil ditambahkan');
    }

    public function edit($id)
    {
        $rule = DB::table('rules')->where('id_rule', $id)->first();
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();
        $gejala = Gejala::orderBy('kode_gejala')->get();
        return view('admin.rules.edit', compact('rule', 'penyakit', 'gejala'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penyakit' => 'required|exists:penyakit,id_penyakit',
            'id_gejala' => 'required|exists:gejala,id_gejala',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1'
        ]);

        // Cek duplikasi (kecuali rule yang sedang diedit)
        $exists = DB::table('rules')
            ->where('id_penyakit', $request->id_penyakit)
            ->where('id_gejala', $request->id_gejala)
            ->where('id_rule', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Rule untuk kombinasi penyakit dan gejala ini sudah ada');
        }

        DB::table('rules')->where('id_rule', $id)->update([
            'id_penyakit' => $request->id_penyakit,
            'id_gejala' => $request->id_gejala,
            'mb' => $request->mb,
            'md' => $request->md,
            'updated_at' => now()
        ]);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('rules')->where('id_rule', $id)->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil dihapus');
    }
}
