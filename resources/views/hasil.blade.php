<!DOCTYPE html>
<html>
<head>
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" href="{{ asset('css/diagnosa.css') }}">
</head>
<body>
    <div class="animated-background"></div>
    
    <!-- Header dengan info user -->
    <div class="top-header">
        <div class="user-info">
            <span class="welcome-text">👋 <strong>{{ session('username', 'User') }}</strong></span>
        </div>
        <div class="header-actions">
            <a href="{{ route('riwayat') }}" class="btn-back">Riwayat</a>
            <a href="{{ route('diagnosa') }}" class="btn-back">↻ Diagnosa Lagi</a>
            <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="hasil-card">
            <div class="header">
                <h1>Hasil Diagnosa</h1>
                <p class="timestamp">{{ now()->format('d F Y, H:i') }} WIB</p>
            </div>

            @if(isset($hasil['hasil_utama']))
                <div class="hasil-utama">
                    <div class="badge-utama">Diagnosa Utama</div>
                    <h2 class="penyakit-nama">{{ $hasil['hasil_utama']['penyakit'] ?? 'Tidak Terdeteksi' }}</h2>
                    <div class="cf-score">
                        <div class="cf-label">Nilai Certainty Factor</div>
                        <div class="cf-value">{{ number_format(($hasil['hasil_utama']['cf'] ?? 0) * 100, 1) }}%</div>
                        <div class="cf-bar">
                            <div class="cf-fill" style="width: {{ ($hasil['hasil_utama']['cf'] ?? 0) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                @if(isset($penyakitUtama))
                    <div class="detail-penyakit">
                        <div class="detail-section">
                            <h3>Deskripsi Penyakit</h3>
                            <p>{{ $penyakitUtama->deskripsi ?? 'Deskripsi tidak tersedia' }}</p>
                        </div>
                        
                        <div class="detail-section solusi-section">
                            <h3>Solusi</h3>
                            <p>{{ $penyakitUtama->solusi ?? 'Solusi tidak tersedia' }}</p>
                        </div>
                    </div>
                @endif

                @if(isset($topHasilDetail) && count($topHasilDetail) > 0)
                    <div class="top-hasil-section">
                        <h3>Kemungkinan Penyakit Lainnya</h3>
                        <div class="top-hasil-list">
                            @foreach($topHasilDetail as $index => $item)
                                <div class="hasil-item">
                                    <div class="hasil-rank">#{{ $index + 1 }}</div>
                                    <div class="hasil-content">
                                        <div class="hasil-nama">{{ $item['penyakit'] ?? 'Unknown' }}</div>
                                        <div class="hasil-cf-bar">
                                            <div class="hasil-cf-fill" style="width: {{ ($item['cf'] ?? 0) * 100 }}%"></div>
                                        </div>
                                        <div class="hasil-cf-text">CF: {{ number_format(($item['cf'] ?? 0) * 100, 1) }}%</div>
                                        
                                        @if(isset($item['detail']))
                                            <div class="hasil-detail">
                                                <p class="hasil-deskripsi"><strong>Deskripsi:</strong> {{ $item['detail']->deskripsi }}</p>
                                                <p class="hasil-solusi"><strong>Solusi:</strong> {{ $item['detail']->solusi }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="info-box">
                    <h4> Informasi Penting</h4>
                    <ul>
                        <li>Hasil diagnosa ini bersifat <strong>prediksi awal</strong> berdasarkan gejala yang Anda pilih</li>
                        <li>Nilai CF (Certainty Factor) menunjukkan tingkat keyakinan sistem: <strong>{{ number_format(($hasil['hasil_utama']['cf'] ?? 0) * 100, 1) }}%</strong></li>
                        <li>Deskripsi dan solusi di atas adalah <strong>rekomendasi umum</strong></li>
                        <li>Untuk diagnosa yang akurat dan pengobatan yang tepat, <strong>segera konsultasikan dengan dokter</strong></li>
                    </ul>
                </div>
            @else
                <div class="error-state">
                    <div class="error-icon">⚠️</div>
                    <h3>Tidak Ada Hasil</h3>
                    <p>Sistem tidak dapat menentukan diagnosa berdasarkan gejala yang dipilih.</p>
                </div>
            @endif

            <div class="button-group">
                <a href="{{ route('diagnosa') }}" class="btn-primary">↻ Diagnosa Ulang</a>
                <a href="{{ route('riwayat') }}" class="btn-secondary">Riwayat</a>
            </div>
        </div>
    </div>
</body>
</html>
