<!DOCTYPE html>
<html>

<head>
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="animated-background"></div>
    <div class="main-container">
        <div class="welcome-card">
            <h1>🏥 Sistem Pakar Diagnosa Penyakit Lambung</h1>
            <p>Selamat datang, <strong>{{ session('username') ?? 'User' }}</strong>!</p>
            
            <div class="menu-grid">
                <a href="{{ route('diagnosa') }}" class="menu-item">
                    <div class="menu-icon">🔍</div>
                    <h3>Mulai Diagnosa</h3>
                    <p>Diagnosa penyakit berdasarkan gejala</p>
                </a>
                
                <a href="#" class="menu-item">
                    <div class="menu-icon">📊</div>
                    <h3>Riwayat</h3>
                    <p>Lihat riwayat diagnosa Anda</p>
                </a>
                
                <a href="#" class="menu-item">
                    <div class="menu-icon">📚</div>
                    <h3>Info Penyakit</h3>
                    <p>Pelajari tentang penyakit lambung</p>
                </a>
                
                <a href="{{ route('logout') }}" class="menu-item logout">
                    <div class="menu-icon">🚪</div>
                    <h3>Logout</h3>
                    <p>Keluar dari sistem</p>
                </a>
            </div>
        </div>
    </div>

</body>

</html>