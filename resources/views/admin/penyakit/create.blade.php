@extends('admin.layout')

@section('title', 'Tambah Penyakit')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>➕ Tambah Penyakit Baru</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.penyakit.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Kode Penyakit *</label>
            <input type="text" name="kode_penyakit" class="form-control" placeholder="Contoh: P01" value="{{ old('kode_penyakit') }}" required>
        </div>

        <div class="form-group">
            <label>Nama Penyakit *</label>
            <input type="text" name="nama_penyakit" class="form-control" placeholder="Contoh: Gastritis (Maag)" value="{{ old('nama_penyakit') }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi penyakit...">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Solusi & Pengobatan</label>
            <textarea name="solusi" class="form-control" rows="4" placeholder="Solusi dan cara pengobatan...">{{ old('solusi') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Simpan</button>
            <a href="{{ route('admin.penyakit.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
