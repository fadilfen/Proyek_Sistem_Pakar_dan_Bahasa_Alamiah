import uuid
from flask import Flask, render_template, request, jsonify
from mesin import diagnosa
from chatbot import GastroChatbot

app = Flask(__name__, template_folder='ui', static_folder='static')
app.secret_key = 'gastrocare_secret_key_for_session_token'

# Inisialisasi Chatbot NLP
bot = GastroChatbot()

# State chatbot in-memory untuk menyimpan data sesi konsultasi
# Format: { session_id: { 'gejala_teridentifikasi': {}, 'gejala_ditanyakan': [] } }
SISI_CHATBOT = {}

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/proses-diagnosa', methods=['POST'])
def proses_diagnosa():
    data = request.json
    gejala_user = data.get('gejala', {})
    
    if not gejala_user:
        return jsonify({'error': 'Pilih minimal 1 gejala'}), 400
    
    hasil = diagnosa(gejala_user)
    
    if not hasil:
        return jsonify({'error': 'Tidak ada hasil diagnosa'}), 400
    
    return jsonify(hasil)

@app.route('/chatbot/session', methods=['POST'])
def init_chatbot_session():
    """Menginisialisasi sesi percakapan chatbot baru"""
    session_id = str(uuid.uuid4())
    SISI_CHATBOT[session_id] = {
        'gejala_teridentifikasi': {},
        'gejala_ditanyakan': []
    }
    
    sambutan = (
        "Halo! Saya **GastroCare AI Chatbot** 🩺\n\n"
        "Saya adalah asisten virtual yang akan membantu Anda mengidentifikasi gejala penyakit lambung secara interaktif. "
        "Silakan **ceritakan keluhan yang Anda rasakan** secara bebas (misalnya: *'perut saya terasa mual dan kembung sejak kemarin'*), "
        "atau Anda bisa menggunakan saran keluhan di bawah ini untuk memulai percakapan."
    )
    
    return jsonify({
        'session_id': session_id,
        'message': sambutan
    })

@app.route('/chatbot/message', methods=['POST'])
def chatbot_message():
    """Memproses pesan dari user dan mengembalikan balasan chatbot"""
    data = request.json or {}
    session_id = data.get('session_id')
    user_message = data.get('message', '').strip()
    
    if not session_id:
        return jsonify({'error': 'Session ID wajib disertakan'}), 400
        
    if not user_message:
        return jsonify({'error': 'Pesan tidak boleh kosong'}), 400
        
    # Buat sesi baru jika session_id belum terdaftar (misalnya setelah server restart)
    if session_id not in SISI_CHATBOT:
        SISI_CHATBOT[session_id] = {
            'gejala_teridentifikasi': {},
            'gejala_ditanyakan': []
        }
        
    state_sesi = SISI_CHATBOT[session_id]
    gejala_teridentifikasi = state_sesi['gejala_teridentifikasi']
    gejala_ditanyakan = state_sesi['gejala_ditanyakan']
    
    # Jalankan analisis pesan dengan modul NLP
    hasil_analisis = bot.analisis_pesan(user_message, gejala_teridentifikasi, gejala_ditanyakan)
    
    # Update state sesi
    SISI_CHATBOT[session_id]['gejala_teridentifikasi'] = hasil_analisis['gejala_teridentifikasi']
    SISI_CHATBOT[session_id]['gejala_ditanyakan'] = hasil_analisis['gejala_ditanyakan']
    
    response_data = {
        'session_id': session_id,
        'jawaban_bot': hasil_analisis['jawaban_bot'],
        'diagnosa_siap': hasil_analisis['diagnosa_siap'],
        'gejala_teridentifikasi': hasil_analisis['gejala_teridentifikasi']
    }
    
    # Jika chatbot memutuskan gejala sudah cukup untuk didiagnosa
    if hasil_analisis['diagnosa_siap']:
        # Hitung Certainty Factor
        hasil_cf = diagnosa(hasil_analisis['gejala_teridentifikasi'])
        
        if hasil_cf:
            # Generate penjelasan ramah dari chatbot mengenai hasil diagnosis
            penjelasan = bot.jelaskan_diagnosa(hasil_cf)
            response_data['jawaban_bot'] = penjelasan
            response_data['hasil_diagnosa'] = hasil_cf
        else:
            response_data['jawaban_bot'] = (
                "Berdasarkan gejala yang kami kumpulkan, kami tidak mendeteksi gejala penyakit lambung yang spesifik. "
                "Silakan konsultasikan dengan dokter jika Anda terus merasa tidak nyaman."
            )
            response_data['hasil_diagnosa'] = None
            response_data['diagnosa_siap'] = False
            
    return jsonify(response_data)

if __name__ == '__main__':
    app.run(debug=True, port=5000)
