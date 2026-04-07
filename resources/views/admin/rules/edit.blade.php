@extends('admin.layout')

@section('title', 'Edit Rule')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>✏️ Edit Rule</h2>
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

    <form action="{{ route('admin.rules.update', $rule->id_rule) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Penyakit *</label>
            <select name="id_penyakit" class="form-control" required>
                <option value="">-- Pilih Penyakit --</option>
                @foreach($penyakit as $p)
                    <option value="{{ $p->id_penyakit }}" {{ old('id_penyakit', $rule->id_penyakit) == $p->id_penyakit ? 'selected' : '' }}>
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
                    <option value="{{ $g->id_gejala }}" {{ old('id_gejala', $rule->id_gejala) == $g->id_gejala ? 'selected' : '' }}>
                        {{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>MB (Measure of Belief) *</label>
                <input type="number" name="mb" class="form-control" step="0.01" min="0" max="1" value="{{ old('mb', $rule->mb) }}" required>
                <small style="color: #666;">Tingkat kepercayaan (0.00 - 1.00)</small>
            </div>

            <div class="form-group">
                <label>MD (Measure of Disbelief) *</label>
                <input type="number" name="md" class="form-control" step="0.01" min="0" max="1" value="{{ old('md', $rule->md) }}" required>
                <small style="color: #666;">Tingkat ketidakpercayaan (0.00 - 1.00)</small>
            </div>
        </div>

        <div style="padding: 15px; background: #fff3cd; border-radius: 8px; margin-bottom: 20px;">
            <strong>📊 Preview CF:</strong>
            <p style="margin: 10px 0 0 0; font-size: 18px;">
                CF = <strong style="color: #43e97b;">{{ number_format($rule->mb, 2) }}</strong> - 
                <strong style="color: #ff6b6b;">{{ number_format($rule->md, 2) }}</strong> = 
                <strong style="color: #667eea;">{{ number_format($rule->mb - $rule->md, 2) }}</strong>
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">💾 Update</button>
            <a href="{{ route('admin.rules.index') }}" class="btn-danger">❌ Batal</a>
        </div>
    </form>
</div>
@endsection
