// ===== DATA GEJALA =====
const dataGejala = [
    { kode: 'G01', nama: 'Sakit ulu hati', pertanyaan: 'Apakah Anda merasa sakit atau perih di bagian tengah atas perut?' },
    { kode: 'G02', nama: 'Mual', pertanyaan: 'Apakah Anda merasa mual atau ingin muntah?' },
    { kode: 'G03', nama: 'Muntah', pertanyaan: 'Apakah Anda muntah?' },
    { kode: 'G04', nama: 'Perut kembung', pertanyaan: 'Apakah perut Anda terasa kembung atau begah?' },
    { kode: 'G05', nama: 'Cepat kenyang', pertanyaan: 'Apakah Anda cepat kenyang meskipun makan hanya sedikit?' },
    { kode: 'G06', nama: 'Sering bersendawa', pertanyaan: 'Apakah Anda sering bersendawa lebih dari biasanya?' },
    { kode: 'G07', nama: 'Sakit perut setelah makan', pertanyaan: 'Apakah perut Anda terasa sakit atau perih setelah makan?' },
    { kode: 'G08', nama: 'Dada terasa panas', pertanyaan: 'Apakah dada atau tenggorokan Anda terasa panas seperti terbakar?' },
    { kode: 'G09', nama: 'BAB berdarah atau hitam', pertanyaan: 'Apakah saat buang air besar terdapat darah atau warna tinja menjadi hitam pekat?' },
    { kode: 'G10', nama: 'Berat badan turun drastis', pertanyaan: 'Apakah berat badan Anda turun tanpa sebab yang jelas?' },
    { kode: 'G11', nama: 'Tidak nafsu makan', pertanyaan: 'Apakah nafsu makan Anda berkurang atau tidak selera makan?' },
    { kode: 'G12', nama: 'Mulut terasa asam atau pahit', pertanyaan: 'Apakah mulut terasa asam atau pahit?' },
    { kode: 'G13', nama: 'Nyeri dada', pertanyaan: 'Apakah Anda merasa sakit atau nyeri di dada?' },
    { kode: 'G14', nama: 'Susah menelan', pertanyaan: 'Apakah Anda kesulitan atau merasa sakit saat menelan?' },
    { kode: 'G15', nama: 'Suara serak', pertanyaan: 'Apakah suara Anda menjadi serak atau parau?' },
    { kode: 'G16', nama: 'Bau mulut', pertanyaan: 'Apakah Anda mengalami bau mulut yang tidak biasa?' },
    { kode: 'G17', nama: 'Batuk kering', pertanyaan: 'Apakah Anda mengalami batuk kering tanpa dahak?' },
    { kode: 'G18', nama: 'Mencret atau diare', pertanyaan: 'Apakah Anda mengalami mencret atau buang air besar lebih sering dari biasanya?' },
    { kode: 'G19', nama: 'Perut melilit atau kram', pertanyaan: 'Apakah perut Anda terasa melilit atau mulas?' },
    { kode: 'G20', nama: 'Demam', pertanyaan: 'Apakah Anda mengalami demam atau badan terasa panas dan meriang?' },
    { kode: 'G21', nama: 'Muntah darah', pertanyaan: 'Apakah Anda muntah disertai darah?' }
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
    document.getElementById('chatbotPage').style.display = 'none';
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
    document.getElementById('gejalaNama').textContent = gejala.pertanyaan || gejala.nama;
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
    
    // Animasi keluar
    const questionCard = document.querySelector('.question-card');
    if (questionCard) {
        questionCard.classList.add('fade-out');
    }
    
    // Delay untuk animasi
    setTimeout(() => {
        currentQuestionIndex++;
        
        if (currentQuestionIndex < dataGejala.length) {
            tampilkanPertanyaan();
            if (questionCard) questionCard.classList.remove('fade-out');
        } else {
            prosesHasil();
            if (questionCard) questionCard.classList.remove('fade-out');
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
            <!-- Header compact -->
            <div class="hasil-header">
                <div class="hasil-icon-large">
                    <img src="/static/js/lambung.png" alt="Lambung Icon">
                </div>
                <div class="hasil-header-text">
                    <h2>Hasil Diagnosa</h2>
                    <p class="hasil-subtitle">Berdasarkan gejala yang Anda alami</p>
                </div>
            </div>

            <!-- Diagnosa Utama -->
            <div class="diagnosa-utama">
                <div class="diagnosa-top-row">
                    <div class="diagnosa-badge">Diagnosa Utama</div>
                    <div class="cf-value">${(hasilUtama.cf * 100).toFixed(1)}%</div>
                </div>
                <h3 class="diagnosa-nama">${hasilUtama.penyakit}</h3>
                <div class="cf-bar-container">
                    <div class="cf-bar-fill" style="width: 0%;" data-width="${hasilUtama.cf * 100}"></div>
                </div>
                <div class="cf-interpretation">${interpretasiCF(hasilUtama.cf)}</div>
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
                                    <span class="kemungkinan-cf">${(p.cf * 100).toFixed(1)}%</span>
                                </div>
                                <div class="kemungkinan-bar">
                                    <div class="kemungkinan-bar-fill" style="width: 0%;" data-width="${p.cf * 100}"></div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}

            <!-- Warning -->
            <div class="medical-warning">
                <div class="warning-icon">⚠️</div>
                <div class="warning-content">
                    <strong>Perhatian:</strong> Hasil diagnosa ini bersifat prediktif dan tidak menggantikan konsultasi medis profesional. Segera hubungi dokter untuk pemeriksaan lebih lanjut.
                </div>
            </div>

            <!-- Actions -->
            <div class="hasil-actions">
                <button onclick="diagnosaBaru()" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
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

// ===== CHATBOT FUNCTIONS =====
let chatSessionId = null;
let chatIsTyping = false;

function mulaiChatbot() {
    document.getElementById('landingPage').style.display = 'none';
    document.getElementById('chatbotPage').style.display = 'block';
    resetChatbot();
}

function resetChatbot() {
    const chatHistory = document.getElementById('chatHistory');
    chatHistory.innerHTML = '';
    
    // Tampilkan kembali input & suggestions jika sebelumnya disembunyikan
    document.getElementById('chatSuggestions').style.display = 'flex';
    document.querySelector('.chat-input-container').style.display = 'block';
    
    const chatInput = document.getElementById('chatInput');
    chatInput.value = '';
    chatInput.style.height = 'auto';
    
    showTypingIndicator();
    
    fetch('/chatbot/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        hideTypingIndicator();
        chatSessionId = data.session_id;
        tampilkanPesanChat('bot', data.message);
    })
    .catch(err => {
        console.error(err);
        hideTypingIndicator();
        tampilkanPesanChat('bot', 'Gagal memuat sesi chatbot. Silakan klik reset atau kembali ke halaman utama.');
    });
}

function tampilkanPesanChat(pengirim, pesan, hasilDiagnosa = null) {
    const chatHistory = document.getElementById('chatHistory');
    
    const bubble = document.createElement('div');
    bubble.className = `chat-bubble ${pengirim}`;
    bubble.innerHTML = parseMarkdown(pesan);
    
    if (hasilDiagnosa && pengirim === 'bot') {
        const hasilUtama = hasilDiagnosa.hasil_utama;
        
        const cardResult = document.createElement('div');
        cardResult.className = 'chat-result-card';
        cardResult.style.marginTop = '16px';
        cardResult.style.padding = '16px';
        cardResult.style.borderRadius = '12px';
        cardResult.style.background = 'linear-gradient(135deg, rgba(0, 102, 255, 0.08), rgba(0, 200, 83, 0.08))';
        cardResult.style.border = '2px solid var(--primary-blue)';
        
        cardResult.innerHTML = `
            <div style="font-size: 13px; font-weight: 700; color: var(--primary-blue); text-transform: uppercase; margin-bottom: 8px;">Kecocokan Tertinggi</div>
            <h4 style="font-size: 18px; margin: 0 0 12px 0; color: var(--neutral-900); font-family: var(--font-secondary);">${hasilUtama.penyakit}</h4>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 14px; font-weight: 600; color: var(--neutral-700);">Certainty Factor:</span>
                <span style="font-size: 22px; font-weight: 800; color: var(--primary-blue); font-family: var(--font-secondary);">${(hasilUtama.cf * 100).toFixed(1)}%</span>
            </div>
            <div class="cf-bar-container" style="background: var(--white); height: 12px; margin-bottom: 16px;">
                <div class="cf-bar-fill" style="width: 0%;" data-width="${hasilUtama.cf * 100}"></div>
            </div>
            <button id="btnBukaLaporan" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 10px; font-size: 14px; border-radius: var(--radius-sm);">
                Lihat Detail & Solusi Lengkap 📋
            </button>
        `;
        bubble.appendChild(cardResult);
        
        cardResult.querySelector('#btnBukaLaporan').onclick = function() {
            bukaLaporanLengkap(hasilDiagnosa);
        };
        
        setTimeout(() => {
            cardResult.querySelector('.cf-bar-fill').style.width = (hasilUtama.cf * 100) + '%';
        }, 200);
        
        document.getElementById('chatSuggestions').style.display = 'none';
        document.querySelector('.chat-input-container').style.display = 'none';
    }
    
    chatHistory.appendChild(bubble);
    chatHistory.scrollTop = chatHistory.scrollHeight;
}

function bukaLaporanLengkap(hasilDiagnosa) {
    tampilkanHasil(hasilDiagnosa);
}

function showTypingIndicator() {
    const chatHistory = document.getElementById('chatHistory');
    
    const indicator = document.createElement('div');
    indicator.className = 'typing-indicator';
    indicator.id = 'chatTypingIndicator';
    indicator.innerHTML = `
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
    `;
    
    chatHistory.appendChild(indicator);
    chatHistory.scrollTop = chatHistory.scrollHeight;
    chatIsTyping = true;
}

function hideTypingIndicator() {
    const indicator = document.getElementById('chatTypingIndicator');
    if (indicator) {
        indicator.remove();
    }
    chatIsTyping = false;
}

function kirimPesanChat(pesanKustom = null) {
    if (chatIsTyping) return;
    
    const input = document.getElementById('chatInput');
    const pesan = pesanKustom || input.value.trim();
    
    if (!pesan) return;
    
    tampilkanPesanChat('user', pesan);
    
    if (!pesanKustom) {
        input.value = '';
        input.style.height = 'auto';
    }
    
    showTypingIndicator();
    
    fetch('/chatbot/message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            session_id: chatSessionId,
            message: pesan
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('Respon server bermasalah');
        return res.json();
    })
    .then(data => {
        hideTypingIndicator();
        tampilkanPesanChat('bot', data.jawaban_bot, data.hasil_diagnosa);
    })
    .catch(err => {
        console.error(err);
        hideTypingIndicator();
        tampilkanPesanChat('bot', 'Maaf, terjadi kesalahan saat menghubungi server. Mohon coba mengirim ulang pesan Anda.');
    });
}

function kirimSaran(teks) {
    kirimPesanChat(teks);
}

function handleChatKeydown(e) {
    const textarea = e.target;
    
    setTimeout(() => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }, 0);
    
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        kirimPesanChat();
    }
}

function parseMarkdown(teks) {
    if (!teks) return '';
    
    let lines = teks.split('\n');
    let inList = false;
    let result = [];
    
    for (let line of lines) {
        let trimmed = line.trim();
        
        if (trimmed.startsWith('- ')) {
            if (!inList) {
                result.push('<ul>');
                inList = true;
            }
            let itemText = trimmed.substring(2);
            itemText = formatInlineMarkdown(itemText);
            result.push(`<li>${itemText}</li>`);
            continue;
        } else {
            if (inList) {
                result.push('</ul>');
                inList = false;
            }
        }
        
        if (trimmed.startsWith('### ')) {
            result.push(`<h3>${formatInlineMarkdown(trimmed.substring(4))}</h3>`);
        } else if (trimmed.startsWith('#### ')) {
            result.push(`<h4>${formatInlineMarkdown(trimmed.substring(5))}</h4>`);
        } else if (trimmed === '---') {
            result.push('<hr>');
        } else if (trimmed.length > 0) {
            result.push(`<p>${formatInlineMarkdown(trimmed)}</p>`);
        } else {
            result.push('<br>');
        }
    }
    
    if (inList) {
        result.push('</ul>');
    }
    
    return result.join('\n');
}

function formatInlineMarkdown(text) {
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
    return text;
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
