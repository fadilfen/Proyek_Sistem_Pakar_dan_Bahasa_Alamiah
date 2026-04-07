@extends('admin.layout')

@section('title', 'Tambah Rule')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>➕ Tambah Rule Baru</h2>
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

    @if(session('error'))
        <div class="alert alert-error">⚠️ {{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.rules.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Penyakit *</label>
            <select name="id_penyakit" class="form-control" required>
                <option value="">-- Pilih Penyakit --</option>
                @foreach($penyakit as $p)
                    <option value="{{ $p->id_penyakit }}" {{ old('id_penyakit') == $p->id_penyakit ? 'selected' : '' }}>
                        {{ $p->kode_penyakit }} - {{ $p->nama_penyakit }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Gejala *</label>
            <select name="id_gejala" class="form-control" required>
                <option value="">-- Pilih Gejala --</option>
                @foreach($gejala as $g)
                    <option value="{{ $g->id_gejala }}" {{ old('id_gejala') == $g->id_gejala ? 'selected' : '' }}>
                        {{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>MB (Measure of Belief) *</label>
                <input type="number" name="mb" class="form-control" step="0.01" min="0" max="1" placeholder="0.00 - 1.00" value="{{ old('mb', '0.80') }}" required>
                <small style="color: #666;">Tingkat kepercayaan bahwa gejala menunjukkan penyakit</small>
            </div>

            <div class="form-group">
                <label>MD (Measure of Disbelief) *</label>
                <input type="number" name="md" class="form-control" step="0.01" min="0" max="1" placeholder="0.00 - 1.00" value="{{ old('md', '0.10') }}" required>
                <small style="color: #666;">Tingkat ketidakpercayaan bahwa gejala menunjukkan penyakit</small>
            </div>
        </div>

        <div style="padding: 15px; background: #e8f5e9; border-radius: 8px; margin-bottom: 20px;">
            <strong>💡 Tips:</strong>
            <ul style="margin: 10px 0 0 20px;">
                <li>MB tinggi (0.7-1.0) = Gejala sangat kuat menunjukkan penyakit</li>
                <li>MB sedang (0.4-0.6) = Gejala cukup menunjukkan penyakit</li>
                <li>MB rendah (0.1-0.3) = Gejala lemah menunjukkan penyakit</li>
                <li>MD biasanya lebih kecil dari MB</li>
                <li>CF = MB - MD (akan dihitung otomatis)</li>
            </ul>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Simpan</button>
            <a href="{{ route('admin.rules.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
