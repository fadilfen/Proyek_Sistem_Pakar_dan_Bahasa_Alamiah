@extends('admin.layout')

@section('title', 'Edit Penyakit')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>✏️ Edit Penyakit</h2>
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

    <form action="{{ route('admin.penyakit.update', $penyakit->id_penyakit) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Kode Penyakit *</label>
            <input type="text" name="kode_penyakit" class="form-control" value="{{ old('kode_penyakit', $penyakit->kode_penyakit) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Penyakit *</label>
            <input type="text" name="nama_penyakit" class="form-control" value="{{ old('nama_penyakit', $penyakit->nama_penyakit) }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $penyakit->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Solusi & Pengobatan</label>
            <textarea name="solusi" class="form-control" rows="4">{{ old('solusi', $penyakit->solusi) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Update</button>
            <a href="{{ route('admin.penyakit.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
