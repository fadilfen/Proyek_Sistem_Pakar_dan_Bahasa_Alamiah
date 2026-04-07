@extends('admin.layout')

@section('title', 'Tambah Gejala')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>➕ Tambah Gejala Baru</h2>
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

    <form action="{{ route('admin.gejala.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Kode Gejala *</label>
            <input type="text" name="kode_gejala" class="form-control" placeholder="Contoh: G01" value="{{ old('kode_gejala') }}" required>
        </div>

        <div class="form-group">
            <label>Nama Gejala *</label>
            <input type="text" name="nama_gejala" class="form-control" placeholder="Contoh: Nyeri ulu hati" value="{{ old('nama_gejala') }}" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Simpan</button>
            <a href="{{ route('admin.gejala.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
