<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();
        return view('admin.penyakit.index', compact('penyakit'));
    }

    public function create()
    {
        return view('admin.penyakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|unique:penyakit,kode_penyakit|max:10',
            'nama_penyakit' => 'required|max:255',
            'deskripsi' => 'nullable',
            'solusi' => 'nullable'
        ]);

        Penyakit::create($request->all());

        return redirect()->route('admin.penyakit.index')
            ->with('success', 'Penyakit berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penyakit = Penyakit::findOrFail($id);
        return view('admin.penyakit.edit', compact('penyakit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_penyakit' => 'required|max:10|unique:penyakit,kode_penyakit,' . $id . ',id_penyakit',
            'nama_penyakit' => 'required|max:255',
            'deskripsi' => 'nullable',
            'solusi' => 'nullable'
        ]);

        $penyakit = Penyakit::findOrFail($id);
        $penyakit->update($request->all());

        return redirect()->route('admin.penyakit.index')
            ->with('success', 'Penyakit berhasil diupdate');
    }

    public function destroy($id)
    {
        $penyakit = Penyakit::findOrFail($id);
        $penyakit->delete();

        return redirect()->route('admin.penyakit.index')
            ->with('success', 'Penyakit berhasil dihapus');
    }
}
