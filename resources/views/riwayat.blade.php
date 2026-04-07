<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Diagnosa</title>
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
            <a href="{{ route('diagnosa') }}" class="btn-back">🔍 Diagnosa Baru</a>
            <a href="{{ route('logout') }}" class="btn-logout">🚪 Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="diagnosa-card">
            <div class="header">
                <h1>📋 Riwayat Diagnosa</h1>
                <p>Lihat semua riwayat diagnosa Anda</p>
            </div>

            @if(session('error'))
                <div class="error-message">
                    <strong>⚠️ Error:</strong> {{ session('error') }}
                </div>
            @endif

            @if($riwayat->count() > 0)
                <div class="riwayat-list">
                    @foreach($riwayat as $item)
                        <div class="riwayat-item">
                            <div class="riwayat-header">
                                <div class="riwayat-date">
                                    📅 {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y, H:i') }} WIB
                                </div>
                                @if($item->nilai_cf)
                                    <div class="riwayat-cf">
                                        CF: {{ number_format($item->nilai_cf * 100, 1) }}%
                                    </div>
                                @endif
                            </div>
                            
                            <div class="riwayat-content">
                                <h3>{{ $item->hasil_diagnosa ?? 'Diagnosa tidak tersedia' }}</h3>
                                <div class="riwayat-actions">
                                    <a href="{{ route('riwayat.detail', $item->id) }}" class="btn-detail">
                                         Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>Belum Ada Riwayat</h3>
                    <p>Anda belum pernah melakukan diagnosa</p>
                    <a href="{{ route('diagnosa') }}" class="btn-primary">🔍 Mulai Diagnosa</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
