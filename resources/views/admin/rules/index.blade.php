@extends('admin.layout')

@section('title', 'Kelola Rules')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>📋 Daftar Rules (Basis Pengetahuan)</h2>
        <a href="{{ route('admin.rules.create') }}" class="btn-primary">➕ Tambah Rule</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">⚠️ {{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Penyakit</th>
                    <th>Gejala</th>
                    <th>MB</th>
                    <th>MD</th>
                    <th>CF</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rules as $index => $rule)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-success">{{ $rule->kode_penyakit }}</span>
                            {{ $rule->nama_penyakit }}
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $rule->kode_gejala }}</span>
                            {{ $rule->nama_gejala }}
                        </td>
                        <td><strong style="color: #43e97b;">{{ number_format($rule->mb, 2) }}</strong></td>
                        <td><strong style="color: #ff6b6b;">{{ number_format($rule->md, 2) }}</strong></td>
                        <td><strong style="color: #667eea;">{{ number_format($rule->mb - $rule->md, 2) }}</strong></td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.rules.edit', $rule->id_rule) }}" class="btn-warning">✏️ Edit</a>
                                <form action="{{ route('admin.rules.destroy', $rule->id_rule) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus rule ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            Belum ada data rules
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
        <strong>ℹ️ Keterangan:</strong>
        <ul style="margin: 10px 0 0 20px;">
            <li><strong>MB (Measure of Belief)</strong> = Tingkat kepercayaan (0.00 - 1.00)</li>
            <li><strong>MD (Measure of Disbelief)</strong> = Tingkat ketidakpercayaan (0.00 - 1.00)</li>
            <li><strong>CF (Certainty Factor)</strong> = MB - MD</li>
        </ul>
    </div>
</div>
@endsection
