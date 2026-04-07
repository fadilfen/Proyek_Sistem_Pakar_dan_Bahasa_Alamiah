@extends('admin.layout')

@section('title', 'Kelola Penyakit')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>🦠 Daftar Penyakit</h2>
        <a href="{{ route('admin.penyakit.create') }}" class="btn-primary">➕ Tambah Penyakit</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Penyakit</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penyakit as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge-success">{{ $item->kode_penyakit }}</span></td>
                        <td>{{ $item->nama_penyakit }}</td>
                        <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.penyakit.edit', $item->id_penyakit) }}" class="btn-warning">✏️ Edit</a>
                                <form action="{{ route('admin.penyakit.destroy', $item->id_penyakit) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px;">Belum ada data penyakit</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
