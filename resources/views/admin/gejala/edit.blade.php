@extends('admin.layout')

@section('title', 'Edit Gejala')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>✏️ Edit Gejala</h2>
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

    <form action="{{ route('admin.gejala.update', $gejala->id_gejala) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Kode Gejala *</label>
            <input type="text" name="kode_gejala" class="form-control" value="{{ old('kode_gejala', $gejala->kode_gejala) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Gejala *</label>
            <input type="text" name="nama_gejala" class="form-control" value="{{ old('nama_gejala', $gejala->nama_gejala) }}" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Update</button>
            <a href="{{ route('admin.gejala.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
