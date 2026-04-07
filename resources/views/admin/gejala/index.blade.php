@extends('admin.layout')

@section('title', 'Kelola Gejala')

@section('content')
<div class="content-card">
    <div class="content-header">
        <h2>📋 Daftar Gejala</h2>
        <a href="{{ route('admin.gejala.create') }}" class="btn-primary">➕ Tambah Gejala</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Gejala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gejala as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge-primary">{{ $item->kode_gejala }}</span></td>
                        <td>{{ $item->nama_gejala }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.gejala.edit', $item->id_gejala) }}" class="btn-warning">✏️ Edit</a>
                                <form action="{{ route('admin.gejala.destroy', $item->id_gejala) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px;">
                            Belum ada data gejala
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
