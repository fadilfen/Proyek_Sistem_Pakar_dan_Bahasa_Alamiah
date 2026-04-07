<!DOCTYPE html>
<html>
<head>
    <title>Detail Riwayat Diagnosa</title>
    <link rel="stylesheet" href="{{ asset('css/diagnosa.css') }}">
</head>
<body>
    <div class="animated-background"></div>
    
    <!-- Header dengan info user -->
    <div class="top-header">
        <div class="user-info">
            <span class="welcome-text">👋 <strong>{{ $username }}</strong></span>
        </div>
        <div class="header-actions">
            <a href="{{ route('riwayat') }}" class="btn-back">📋 Kembali ke Riwayat</a>
            <a href="{{ route('logout') }}" class="btn-logout">🚪 Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="hasil-card">
            <div class="header">
                <h1>📋 Detail Riwayat Diagnosa</h1>
                <p class="timestamp">{{ \Carbon\Carbon::parse($konsultasi->tanggal)->format('d F Y, H:i') }} WIB</p>
            </div>

            <!-- Hasil Diagnosa -->
            <div class="hasil-utama">
                <div class="badge-utama">Hasil Diagnosa</div>
                <h2 class="penyakit-nama">{{ $konsultasi->hasil_diagnosa }}</h2>
                @if($konsultasi->nilai_cf)
                    <div class="cf-score">
                        <div class="cf-label">Nilai Certainty Factor</div>
                        <div class="cf-value">{{ number_format($konsultasi->nilai_cf * 100, 1) }}%</div>
                        <div class="cf-bar">
                            <div class="cf-fill" style="width: {{ $konsultasi->nilai_cf * 100 }}%"></div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Penyakit -->
            @if($penyakit)
                <div class="detail-penyakit">
                    <div class="detail-section">
                        <h3>📋 Deskripsi Penyakit</h3>
                        <p>{{ $penyakit->deskripsi }}</p>
                    </div>
                    
                    <div class="detail-section solusi-section">
                        <h3>💊 Solusi & Pengobatan</h3>
                        <p>{{ $penyakit->solusi }}</p>
                    </div>
                </div>
            @endif

            <!-- Gejala yang Dipilih -->
            @if($gejalaDetail->count() > 0)
                <div class="gejala-terpilih-section">
                    <h3>🔍 Gejala yang Dipilih</h3>
                    <div class="gejala-terpilih-list">
                        @foreach($gejalaDetail as $gejala)
                            <div class="gejala-terpilih-item">
                                <div class="gejala-info">
                                    <span class="gejala-kode">{{ $gejala->kode_gejala }}</span>
                                    <span class="gejala-nama">{{ $gejala->nama_gejala }}</span>
                                </div>
                                <div class="gejala-nilai">
                                    Keyakinan: <strong>{{ number_format($gejala->nilai_user * 100, 0) }}%</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="button-group">
                <a href="{{ route('riwayat') }}" class="btn-secondary">📋 Kembali ke Riwayat</a>
                <a href="{{ route('diagnosa') }}" class="btn-primary">🔍 Diagnosa Baru</a>
            </div>
        </div>
    </div>
</body>
</html>
