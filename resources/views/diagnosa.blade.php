<!DOCTYPE html>
<html>
<head>
    <title>Diagnosa Penyakit Lambung</title>
    <link rel="stylesheet" href="{{ asset('css/diagnosa.css') }}">
</head>
<body>
    <div class="animated-background"></div>
    
    <!-- Header dengan info user -->
    <div class="top-header">
        <div class="user-info">
            <span class="welcome-text">👋 Selamat datang, <strong>{{ $username ?? 'User' }}</strong></span>
        </div>
        <div class="header-actions">
            <a href="{{ route('riwayat') }}" class="btn-back">📋 Riwayat</a>
            <a href="{{ route('logout') }}" class="btn-logout">🚪 Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="diagnosa-card">
            <div class="header">
                <h1>🏥 Sistem Diagnosa Penyakit Lambung</h1>
                <p>Pilih gejala yang Anda alami dan tentukan tingkat keyakinan Anda</p>
            </div>

            @if(session('error'))
                <div class="error-message">
                    <strong>⚠️ Error:</strong> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('diagnosa.proses') }}" method="POST" id="diagnosaForm">
                @csrf
                
                <div class="gejala-container">
                    @forelse($gejala as $item)
                        <div class="gejala-item">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" 
                                       name="gejala[]" 
                                       value="{{ $item->kode_gejala }}" 
                                       id="gejala_{{ $item->id_gejala }}"
                                       class="gejala-checkbox"
                                       onchange="toggleSlider(this, 'slider_{{ $item->id_gejala }}')">
                                <label for="gejala_{{ $item->id_gejala }}" class="gejala-label">
                                    <span class="kode">{{ $item->kode_gejala }}</span>
                                    <span class="nama">{{ $item->nama_gejala }}</span>
                                </label>
                            </div>
                            
                            <div class="slider-wrapper" id="slider_{{ $item->id_gejala }}" style="display: none;">
                                <label class="slider-label">Tingkat Keyakinan: <span id="nilai_{{ $item->id_gejala }}">0.8</span></label>
                                <input type="range" 
                                       name="nilai[{{ $item->kode_gejala }}]" 
                                       min="0" 
                                       max="1" 
                                       step="0.1" 
                                       value="0.8" 
                                       class="slider"
                                       oninput="updateNilai(this, 'nilai_{{ $item->id_gejala }}')">
                                <div class="slider-info">
                                    <span>Tidak Yakin (0.0)</span>
                                    <span>Sangat Yakin (1.0)</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <p>⚠️ Belum ada data gejala. Silakan jalankan migration dan seeder terlebih dahulu.</p>
                        </div>
                    @endforelse
                </div>

                @if($gejala->count() > 0)
                    <div class="button-group">
                        <button type="submit" class="btn-submit">
                            🔍 Diagnosa Sekarang
                        </button>
                        <button type="reset" class="btn-reset" onclick="resetForm()">
                            ↻ Reset
                        </button>
                    </div>
                @endif
            </form>

            <div class="footer-info">
                <p>💡 <strong>Tips:</strong> Pilih gejala yang Anda rasakan, lalu atur tingkat keyakinan menggunakan slider (0.0 = tidak yakin, 1.0 = sangat yakin)</p>
            </div>
        </div>
    </div>

    <script>
        function toggleSlider(checkbox, sliderId) {
            const slider = document.getElementById(sliderId);
            slider.style.display = checkbox.checked ? 'block' : 'none';
        }

        function updateNilai(slider, spanId) {
            document.getElementById(spanId).textContent = slider.value;
        }

        function resetForm() {
            document.querySelectorAll('.slider-wrapper').forEach(el => {
                el.style.display = 'none';
            });
            document.querySelectorAll('.slider').forEach(slider => {
                slider.value = 0.8;
            });
            document.querySelectorAll('[id^="nilai_"]').forEach(span => {
                span.textContent = '0.8';
            });
        }

        document.getElementById('diagnosaForm').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.gejala-checkbox:checked');
            if (checked.length === 0) {
                e.preventDefault();
                alert('⚠️ Pilih minimal 1 gejala untuk melakukan diagnosa!');
                return false;
            }
            
            // Tampilkan loading
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '⏳ Sedang memproses...';
        });
    </script>
</body>
</html>
