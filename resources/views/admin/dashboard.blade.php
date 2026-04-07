@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            🔍
        </div>
        <div class="stat-info">
            <h3>Total Gejala</h3>
            <p>{{ $stats['total_gejala'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            🦠
        </div>
        <div class="stat-info">
            <h3>Total Penyakit</h3>
            <p>{{ $stats['total_penyakit'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            📋
        </div>
        <div class="stat-info">
            <h3>Total Rules</h3>
            <p>{{ $stats['total_rules'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            👥
        </div>
        <div class="stat-info">
            <h3>Total Users</h3>
            <p>{{ $stats['total_users'] }}</p>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-header">
        <h2>📊 Statistik Konsultasi</h2>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            📈
        </div>
        <div class="stat-info">
            <h3>Total Konsultasi</h3>
            <p>{{ $stats['total_konsultasi'] }}</p>
        </div>
    </div>
</div>

<div class="content-card" style="margin-top: 20px;">
    <div class="content-header">
        <h2>🚀 Quick Actions</h2>
    </div>
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('admin.gejala.create') }}" class="btn-primary">➕ Tambah Gejala</a>
        <a href="{{ route('admin.penyakit.create') }}" class="btn-primary">➕ Tambah Penyakit</a>
        <a href="{{ route('admin.rules.create') }}" class="btn-primary">➕ Tambah Rule</a>
    </div>
</div>
@endsection
