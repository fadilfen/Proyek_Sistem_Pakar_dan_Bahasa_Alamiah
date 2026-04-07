<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index()
    {
        $gejala = Gejala::orderBy('kode_gejala')->get();
        return view('admin.gejala.index', compact('gejala'));
    }

    public function create()
    {
        return view('admin.gejala.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:gejala,kode_gejala|max:10',
            'nama_gejala' => 'required|max:255'
        ]);

        Gejala::create($request->all());

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan');
    }

    public function edit($id)
    {
        $gejala = Gejala::findOrFail($id);
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gejala' => 'required|max:10|unique:gejala,kode_gejala,' . $id . ',id_gejala',
            'nama_gejala' => 'required|max:255'
        ]);

        $gejala = Gejala::findOrFail($id);
        $gejala->update($request->all());

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil diupdate');
    }

    public function destroy($id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil dihapus');
    }
}
