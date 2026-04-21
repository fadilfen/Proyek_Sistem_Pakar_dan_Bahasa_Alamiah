// ===== DATA GEJALA =====
const dataGejala = [
    { kode: 'G01', nama: 'Nyeri ulu hati' },
    { kode: 'G02', nama: 'Mual' },
    { kode: 'G03', nama: 'Muntah' },
    { kode: 'G04', nama: 'Perut kembung' },
    { kode: 'G05', nama: 'Cepat kenyang' },
    { kode: 'G06', nama: 'Sendawa berlebihan' },
    { kode: 'G07', nama: 'Nyeri perut setelah makan' },
    { kode: 'G08', nama: 'Heartburn (rasa panas di dada)' },
    { kode: 'G09', nama: 'BAB berdarah atau hitam' },
    { kode: 'G10', nama: 'Penurunan berat badan' }
];

// ===== STATE MANAGEMENT =====
let currentQuestionIndex = 0;
let userAnswers = {};

// ===== NAVIGATION FUNCTIONS =====
function mulaiDiagnosa() {
    document.getElementById('landingPage').style.display = 'none';
    document.getElementById('diagnosaPage').style.display = 'block';
    currentQuestionIndex = 0;
    userAnswers = {};
    tampilkanPertanyaan();
}

function kembaliKeHome() {
    document.getElementById('diagnosaPage').style.display = 'none';
    document.getElementById('landingPage').style.display = 'block';
    currentQuestionIndex = 0;
    userAnswers = {};
}

function scrollToAbout() {
    document.getElementById('about').scrollIntoView({ behavior: 'smooth' });
}

// ===== QUESTION DISPLAY =====
function tampilkanPertanyaan() {
    const gejala = dataGejala[currentQuestionIndex];
    document.getElementById('gejalaNama').textContent = gejala.nama;
    document.getElementById('currentNumber').textContent = currentQuestionIndex + 1;
    
    // Update progress bar biru
    const progress = ((currentQuestionIndex + 1) / dataGejala.length) * 100;
    const progressLine = document.querySelector('.progress-info::after');
    document.querySelector('.progress-info').style.setProperty('--progress-width', progress + '%');
    
    // Reset likert options
    document.querySelectorAll('.likert-option').forEach(option => {
        option.classList.remove('selected');
    });
}

// ===== ANSWER SELECTION =====
function pilihKeyakinan(nilai) {
    const gejala = dataGejala[currentQuestionIndex];
    
    // Simpan jawaban (hanya jika nilai > 0)
    if (nilai > 0) {
        userAnswers[gejala.kode] = nilai;
    }
    
    // Visual feedback
    const selectedOption = document.querySelector(`[data-value="${nilai}"]`);
    if (selectedOption) {
        selectedOption.classList.add('selected');
    }
    
    // Delay untuk animasi
    setTimeout(() => {
        currentQuestionIndex++;
        
        if (currentQuestionIndex < dataGejala.length) {
            tampilkanPertanyaan();
        } else {
            prosesHasil();
        }
    }, 300);
}

// ===== PROCESS RESULTS =====
function prosesHasil() {
    // Tampilkan loading
    document.getElementById('diagnosaPage').style.display = 'none';
    document.getElementById('loadingSection').style.display = 'flex';
    
    // Cek apakah ada gejala yang dipilih
    if (Object.keys(userAnswers).length === 0) {
        alert('Anda belum memilih gejala apapun. Silakan ulangi diagnosa.');
        kembaliKeHome();
        return;
    }
    
    // Kirim data ke backend
    fetch('/proses-diagnosa', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ gejala: userAnswers })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        setTimeout(() => {
            tampilkanHasil(data);
        }, 1500);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loadingSection').style.display = 'none';
        alert('Terjadi kesalahan saat memproses diagnosa. Silakan coba lagi.');
        kembaliKeHome();
    });
}

// ===== DISPLAY RESULTS =====
function tampilkanHasil(data) {
    document.getElementById('loadingSection').style.display = 'none';
    
    // Ambil data hasil
    const hasilUtama = data.hasil_utama;
    const topHasil = data.top_hasil || [];
    const kemungkinanLain = topHasil.slice(1); // Ambil selain yang utama
    
    const hasilHTML = `
        <div class="hasil-container">
            <!-- Header Hasil -->
            <div class="hasil-header">
                <div class="hasil-icon-large">
                    <img src="/static/js/lambung.png" alt="Lambung Icon">
                </div>
                <h2>Hasil Diagnosa</h2>
                <p class="hasil-subtitle">Berdasarkan gejala yang Anda alami</p>
            </div>

            <!-- Diagnosa Utama -->
            <div class="diagnosa-utama">
                <div class="diagnosa-badge">Diagnosa Utama</div>
                <h3 class="diagnosa-nama">${hasilUtama.penyakit}</h3>
                
                <div class="cf-display">
                    <div class="cf-label">Tingkat Keyakinan (CF)</div>
                    <div class="cf-value">${(hasilUtama.cf * 100).toFixed(1)}%</div>
                </div>
                
                <div class="cf-bar-container">
                    <div class="cf-bar-fill" style="width: 0%;" data-width="${hasilUtama.cf * 100}"></div>
                </div>
                
                <div class="cf-interpretation">
                    ${interpretasiCF(hasilUtama.cf)}
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="hasil-section">
                <div class="section-header">
                    <div class="section-icon">📋</div>
                    <h4>Deskripsi Penyakit</h4>
                </div>
                <p>${hasilUtama.deskripsi}</p>
            </div>

            <!-- Solusi -->
            <div class="hasil-section">
                <div class="section-header">
                    <div class="section-icon">💊</div>
                    <h4>Solusi & Penanganan</h4>
                </div>
                <p>${hasilUtama.solusi}</p>
            </div>

            <!-- Kemungkinan Lain -->
            ${kemungkinanLain.length > 0 ? `
                <div class="hasil-section">
                    <div class="section-header">
                        <div class="section-icon">🔍</div>
                        <h4>Kemungkinan Penyakit Lain</h4>
                    </div>
                    <div class="kemungkinan-list">
                        ${kemungkinanLain.map(p => `
                            <div class="kemungkinan-item">
                                <div class="kemungkinan-info">
                                    <span class="kemungkinan-nama">${p.penyakit}</span>
                                    <span class="kemungkinan-cf">CF: ${(p.cf * 100).toFixed(1)}%</span>
                                </div>
                                <div class="kemungkinan-bar">
                                    <div class="kemungkinan-bar-fill" style="width: 0%;" data-width="${p.cf * 100}"></div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}

            <!-- Warning Medis -->
            <div class="medical-warning">
                <div class="warning-icon">⚠️</div>
                <div class="warning-content">
                    <strong>Perhatian:</strong> Hasil diagnosa ini bersifat prediktif dan tidak menggantikan konsultasi medis profesional. Segera hubungi dokter untuk pemeriksaan lebih lanjut.
                </div>
            </div>

            <!-- Actions -->
            <div class="hasil-actions">
                <button onclick="diagnosaBaru()" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" fill="currentColor"/>
                    </svg>
                    Diagnosa Baru
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('hasilContent').innerHTML = hasilHTML;
    document.getElementById('hasilModal').style.display = 'flex';
    
    // Animasi progress bar
    setTimeout(() => {
        document.querySelectorAll('.cf-bar-fill, .kemungkinan-bar-fill').forEach(bar => {
            const targetWidth = bar.getAttribute('data-width');
            bar.style.width = targetWidth + '%';
        });
    }, 100);
}

// ===== HELPER FUNCTIONS =====
function interpretasiCF(cf) {
    if (cf >= 0.8) return '<span class="cf-high">Keyakinan Sangat Tinggi</span>';
    if (cf >= 0.6) return '<span class="cf-medium">Keyakinan Tinggi</span>';
    if (cf >= 0.4) return '<span class="cf-medium">Keyakinan Sedang</span>';
    return '<span class="cf-low">Keyakinan Rendah</span>';
}

function closeModal() {
    document.getElementById('hasilModal').style.display = 'none';
    kembaliKeHome();
}

function diagnosaBaru() {
    closeModal();
    setTimeout(() => mulaiDiagnosa(), 300);
}

// ===== SMOOTH SCROLL =====
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
