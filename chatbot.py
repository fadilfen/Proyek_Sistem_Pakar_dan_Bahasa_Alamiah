import re
import random
from mesin import GEJALA, RULES, PENYAKIT, diagnosa

# Kamus Sinonim Kata Kunci Gejala Lambung (Diperluas untuk Akurasi & Bahasa Sehari-hari)
KAMUS_GEJALA = {
    'G01': ['ulu hati', 'uluhati', 'nyeri ulu', 'sakit ulu', 'perih ulu', 'pedih ulu', 'perut atas tengah', 'nyeri uluhati', 'ulu hati terasa ditusuk', 'sakit uluhati', 'perih di ulu hati', 'nyeri perut atas'],
    'G02': ['mual', 'enek', 'eneg', 'lambung bergejolak', 'mau muntah', 'pengen muntah', 'mual-mual', 'mual2', 'rasa pengen muntah', 'perut mual', 'perut enek'],
    'G03': ['muntah', 'muntah-muntah', 'keluar makanan', 'memuntahkan', 'muntah2', 'muntah muntah', 'muntahin makanan', 'memuntahkan kembali'],
    'G04': ['kembung', 'begah', 'perut penuh gas', 'banyak gas', 'perut kembung', 'perut begah', 'begah banget', 'perut sebah', 'sebah', 'perut membesar', 'perut bergas', 'kembung perut'],
    'G05': ['cepat kenyang', 'gampang kenyang', 'makan sedikit kenyang', 'makan dikit kenyang', 'mudah kenyang', 'baru makan dikit udah kenyang', 'makan sedikit langsung kenyang', 'cepat merasa penuh', 'makan dikit langsung begah'],
    'G06': ['sendawa', 'sering sendawa', 'nyendawa', 'banyak sendawa', 'sendawa terus', 'bersendawa', 'sering bersendawa', 'sendawa terus menerus', 'gampang sendawa', 'nyendawa terus'],
    # G07 hanya mencocokkan frasa nyeri/sakit/perih setelah makan untuk menghindari false positive (misal mual setelah makan)
    'G07': ['nyeri setelah makan', 'sakit sehabis makan', 'perih setelah makan', 'sakit setelah makan', 'nyeri sehabis makan', 'perih sehabis makan', 'sakit perut setelah makan', 'nyeri perut setelah makan', 'perut sakit habis makan', 'perut perih habis makan', 'perut perih setelah makan', 'nyeri perut sehabis makan', 'perut saya perih habis makan', 'perut saya perih setelah makan', 'perut saya sakit habis makan', 'perut saya sakit setelah makan', 'perut terasa perih habis makan', 'perut terasa perih setelah makan', 'perut terasa sakit habis makan', 'perut terasa sakit setelah makan'],
    'G08': ['heartburn', 'panas di dada', 'dada terasa terbakar', 'panas dada', 'dada terbakar', 'dada panas', 'dada terasa panas', 'sensasi terbakar di dada', 'dada seperti terbakar', 'panas menjalar ke dada', 'panas di ulu hati sampai dada', 'nyeri panas di dada'],
    'G09': ['bab berdarah', 'berak hitam', 'bab hitam', 'tinja berdarah', 'tinja hitam', 'berak berdarah', 'buang air besar hitam', 'buang air besar berdarah', 'pup hitam', 'pup berdarah', 'berak darah', 'tinja berwarna gelap', 'buang air besar darah'],
    'G10': ['berat badan turun', 'kurusan', 'bb turun', 'berat badan berkurang', 'berat badan susut', 'bb berkurang', 'berat badan merosot', 'bb menurun', 'makin kurus', 'timbangan turun'],
    'G11': ['nafsu makan menurun', 'tidak nafsu makan', 'malas makan', 'kurang nafsu makan', 'nafsu makan berkurang', 'hilang nafsu makan', 'ga napsu makan', 'tidak selera makan', 'selera makan turun', 'ga pengen makan'],
    'G12': ['mulut terasa asam', 'mulut terasa pahit', 'mulut asam', 'mulut pahit', 'lidah pahit', 'lidah asam', 'rasa asam di mulut', 'rasa pahit di mulut', 'lidah kelat', 'rasa kecut di mulut', 'cairan asam naik ke mulut', 'mulut kecut', 'tenggorokan terasa asam'],
    'G13': ['nyeri dada', 'dada sakit', 'sakit dada', 'nyesek di dada', 'dada nyeri', 'dada terasa sesak', 'dada nyesek', 'sakit di dada', 'nyeri di bagian dada', 'dada seperti ditekan', 'nyeri dada berat', 'nyesek', 'sesak dada', 'sesak'],
    'G14': ['kesulitan menelan', 'sulit menelan', 'sakit menelan', 'nyeri menelan', 'susah menelan', 'mengganjal di tenggorokan', 'sakit saat menelan', 'sulit nelan', 'susah nelan', 'tenggorokan mengganjal saat makan', 'sakit pas menelan', 'nyeri saat menelan'],
    'G15': ['suara serak', 'serak', 'tenggorokan serak', 'suara hilang', 'suara parau', 'suara serak basah', 'suara menjadi serak', 'tenggorokan gatal suara serak'],
    'G16': ['bau mulut', 'nafas bau', 'mulut bau', 'halitosis', 'napas berbau', 'bau naga', 'aroma mulut tidak sedap', 'mulut berbau kurang sedap'],
    'G17': ['batuk kering', 'batuk gatal', 'batuk tanpa dahak', 'batuk tidak berdahak', 'batuk-batuk kering', 'batuk gatel', 'batuk kering terus'],
    'G18': ['diare', 'mencret', 'mencret-mencret', 'bab terus', 'bab cair', 'mencret2', 'berak cair', 'buang air besar cair', 'mencret parah', 'diare terus'],
    'G19': ['kram perut', 'melilit', 'perut melilit', 'kejang perut', 'perut kram', 'perut seperti diplintir', 'perut melilit sakit sekali', 'kejang di perut', 'kram di perut'],
    'G20': ['demam', 'panas badan', 'meriang', 'suhu tinggi', 'panas dingin', 'badannya panas', 'suhu tubuh naik', 'badan panas', 'meriang panas dingin', 'badan anget', 'tubuh terasa panas', 'demam tinggi'],
    'G21': ['muntah darah', 'keluar darah saat muntah', 'muntah hitam', 'muntah kecokelatan', 'memuntahkan darah', 'muntah ada darahnya', 'muntah cairan merah gelap', 'muntah darah segar']
}

# Kamus Modifier Keyakinan dengan Dukungan Percakapan & Slang
MODIFIER_KEYAKINAN = {
    1.0: ['sangat sering', 'sering banget', 'selalu', 'sangat parah', 'parah banget', 'terus-terusan', 'sangat', 'yakin banget', 'sangat yakin', 'paling sering', 'sakit banget', 'hebat banget', 'luar biasa sakit', 'parah sekali', 'banget', 'sekali'],
    0.8: ['sering', 'teratur', 'parah', 'yakin', 'biasanya', 'terasa sekali', 'terasa banget', 'iya', 'ya', 'betul', 'benar', 'mengalami', 'merasakan', 'ada', 'ada sih', 'iyasih', 'betul juga', 'betul sekali'],
    0.6: ['cukup sering', 'cukup', 'lumayan sering', 'lumayan', 'sedang', 'biasa saja', 'cukup parah', 'lumayan parah', 'bisa dikatakan'],
    0.4: ['kadang-kadang', 'kadang', 'sesekali', 'ragu-ragu', 'ragu', 'mungkin', 'kayaknya', 'sepertinya', 'agak', 'kurang yakin', 'kadang aja', 'jarang sih'],
    0.2: ['jarang', 'jarang sekali', 'hampir tidak pernah', 'dikit', 'sedikit'],
    0.0: ['tidak', 'gak', 'nggak', 'tidak ada', 'bukan', 'tidak pernah', 'tanpa', 'engga', 'enggak', 'gak ada', 'nggak ada', 'belum']
}

# Gejala Darurat Medis
GEJALA_DARURAT = ['G09', 'G21'] # G09: BAB berdarah/hitam, G21: Muntah darah
# Catatan: G13 (nyeri dada berat) juga patut diwaspadai jika disebutkan sebagai berat.

class GastroChatbot:
    def __init__(self):
        pass

    def _bersihkan_teks(self, teks):
        teks = teks.lower()
        # Hapus tanda baca kecuali spasi
        teks = re.sub(r'[^\w\s]', ' ', teks)
        # Hapus spasi berlebih
        teks = re.sub(r'\s+', ' ', teks).strip()
        return teks

    def _deteksi_negasi(self, teks, keyword_pos):
        """
        Mendeteksi apakah terdapat kata negasi dalam jangkauan sebelum keyword.
        Misalnya: "saya tidak merasakan mual" -> keyword 'mual' memiliki negasi 'tidak'.
        """
        kata_negasi = ['ngga','ga', 'tidak', 'gak', 'nggak', 'engga', 'enggak', 'tanpa', 'bukan', 'tidak pernah', 'belum', 'tidak ada', 'gak ada', 'nggak ada']
        words = teks.split()
        
        # Temukan index kata kunci dalam list kata
        kw_words = keyword_pos.split()
        kw_first_word = kw_words[0]
        
        try:
            kw_idx = words.index(kw_first_word)
        except ValueError:
            return False
            
        # Periksa 3 kata sebelum kata kunci
        start_idx = max(0, kw_idx - 3)
        for i in range(start_idx, kw_idx):
            if words[i] in kata_negasi:
                return True
        return False

    def _ekstrak_keyakinan(self, teks, keyword_pos, has_negation=False):
        """
        Mengekstrak tingkat keyakinan berdasarkan kata keterangan di sekitar kata kunci gejala.
        Menggunakan pencocokan kata utuh (\b) agar tidak terjebak tumpang tindih substring.
        """
        if has_negation:
            return 0.0
            
        teks_clean = teks
        # Cari modifier keyakinan dalam teks
        for nilai, daftar_kata in sorted(MODIFIER_KEYAKINAN.items(), reverse=True):
            if nilai == 0.0:
                continue # Negasi sudah dihandle terpisah
            for kata in daftar_kata:
                # Gunakan batas kata (\b) agar tidak mencocokkan substring (misal "ya" di dalam "saya")
                pattern = r'\b' + re.escape(kata) + r'\b'
                if re.search(pattern, teks_clean):
                    return nilai
                    
        # Nilai default jika gejala disebutkan tanpa keterangan intensitas
        return 0.8

    def analisis_pesan(self, pesan_user, gejala_teridentifikasi, gejala_ditanyakan):
        """
        Menganalisis pesan user, mencocokkan gejala, dan menentukan respon chatbot selanjutnya.
        
        Args:
            pesan_user (str): pesan input dari pengguna
            gejala_teridentifikasi (dict): format {kode_gejala: nilai_keyakinan}
            gejala_ditanyakan (list): daftar kode gejala yang sudah ditanyakan oleh bot
            
        Returns:
            dict: {
                'gejala_baru': dict,
                'jawaban_bot': str,
                'diagnosa_siap': bool,
                'gejala_teridentifikasi': dict,
                'gejala_ditanyakan': list
            }
        """
        teks_clean = self._bersihkan_teks(pesan_user)
        gejala_baru = {}
        ada_gejala_darurat = False
        nama_gejala_darurat = []

        # 1. Deteksi Gejala Eksplisit dari Pesan User
        for kode_gejala, sinonim_list in KAMUS_GEJALA.items():
            for sinonim in sinonim_list:
                # Gunakan regex untuk pencocokan kata yang fleksibel
                pattern = r'\b' + re.escape(sinonim) + r'\b'
                if re.search(pattern, teks_clean):
                    # Deteksi apakah dinegasikan
                    is_negated = self._deteksi_negasi(teks_clean, sinonim)
                    
                    # Tentukan tingkat keyakinan
                    nilai_cf = self._ekstrak_keyakinan(teks_clean, sinonim, is_negated)
                    
                    # Tambahkan ke gejala baru (atau update jika nilainya lebih tinggi)
                    if kode_gejala not in gejala_baru or nilai_cf > gejala_baru[kode_gejala]:
                        gejala_baru[kode_gejala] = nilai_cf
                        
                    # Deteksi gejala darurat
                    if kode_gejala in GEJALA_DARURAT and nilai_cf > 0.0:
                        ada_gejala_darurat = True
                        # Cari nama gejala asli
                        nama = next((g['nama'] for g in GEJALA if g['kode'] == kode_gejala), sinonim)
                        if nama not in nama_gejala_darurat:
                            nama_gejala_darurat.append(nama)
                    break # Lanjut ke gejala berikutnya jika sinonim sudah cocok

        # 1.5. Logika Kontekstual (Afirmasi & Negasi Singkat untuk pertanyaan bot terakhir)
        if not gejala_baru and gejala_ditanyakan:
            gejala_terakhir = gejala_ditanyakan[-1]
            
            # Deteksi apakah pesan user mengandung kata negasi
            kata_negasi_singkat = ['ga','tidak', 'gak', 'nggak', 'engga', 'enggak', 'tidak ada', 'gak ada', 'nggak ada', 'belum', 'bukan']
            is_negated_context = False
            for neg in kata_negasi_singkat:
                if re.search(r'\b' + re.escape(neg) + r'\b', teks_clean):
                    is_negated_context = True
                    break
            
            # Deteksi apakah pesan user mengandung afirmasi atau modifier keyakinan
            kata_afirmasi = ['iya', 'ya', 'betul', 'benar', 'ada', 'mengalami', 'merasakan', 'pernah', 'yup', 'oke', 'ok', 'sih', 'biasanya', 'sering', 'kadang', 'lumayan', 'jarang', 'parah', 'sangat', 'mungkin', 'kayaknya', 'sepertinya']
            is_affirmed_context = False
            for afi in kata_afirmasi:
                if re.search(r'\b' + re.escape(afi) + r'\b', teks_clean):
                    is_affirmed_context = True
                    break
                    
            if is_negated_context:
                gejala_baru[gejala_terakhir] = 0.0
            elif is_affirmed_context:
                # Tentukan nilai CF dari modifier, jika tidak ada modifier khusus maka default 0.8
                nilai_cf = self._ekstrak_keyakinan(teks_clean, "")
                gejala_baru[gejala_terakhir] = nilai_cf
                
                # Deteksi gejala darurat dari jawaban kontekstual ini
                if gejala_terakhir in GEJALA_DARURAT and nilai_cf > 0.0:
                    ada_gejala_darurat = True
                    nama = next((g['nama'] for g in GEJALA if g['kode'] == gejala_terakhir), "gejala serius")
                    if nama not in nama_gejala_darurat:
                        nama_gejala_darurat.append(nama)

        # 2. Update state gejala_teridentifikasi
        for kode, nilai in gejala_baru.items():
            gejala_teridentifikasi[kode] = nilai

        # 3. Tangani Gejala Darurat terlebih dahulu
        if ada_gejala_darurat:
            peringatan = (
                f"⚠️ **PERINGATAN DARURAT MEDIS!**\n\n"
                f"Anda menyebutkan mengalami gejala **{', '.join(nama_gejala_darurat)}**. "
                f"Kondisi ini merupakan gejala berpotensi serius pada saluran pencernaan yang memerlukan "
                f"penanganan medis segera. \n\n"
                f"Kami sangat menyarankan Anda untuk **segera pergi ke Unit Gawat Darurat (UGD) rumah sakit** "
                f"atau fasilitas kesehatan terdekat untuk mendapatkan pemeriksaan dokter secara langsung. "
                f"Mohon jangan menunda pengobatan."
            )
            # Karena darurat, kita langsung hentikan dan tawarkan diagnosa parsial jika tetap ingin diproses
            return {
                'gejala_baru': gejala_baru,
                'jawaban_bot': peringatan,
                'diagnosa_siap': True, # Paksa selesaikan agar CF bisa melihat keadaan darurat
                'gejala_teridentifikasi': gejala_teridentifikasi,
                'gejala_ditanyakan': gejala_ditanyakan
            }

        # 4. Deteksi apakah user menjawab "tidak ada" atau "cukup" untuk mengakhiri chat
        user_selesai = False
        kata_selesai = ['cukup', 'selesai', 'tidak ada lagi', 'nggak ada lagi', 'sudah cukup', 'dah cukup', 'aman', 'tidak ada keluhan lain']
        for kata in kata_selesai:
            if kata in teks_clean:
                user_selesai = True
                break

        # 5. Tentukan Kesiapan Diagnosa
        # Kriteria siap: User menyatakan cukup ATAU telah teridentifikasi minimal 3 gejala aktif (>0.0) 
        # AND kita sudah menanyakan setidaknya 2 pertanyaan lanjutan (agar chatbot terasa interaktif).
        gejala_aktif_count = sum(1 for v in gejala_teridentifikasi.values() if v > 0.0)
        
        # Jika user menyatakan selesai, atau sudah teridentifikasi minimal 3 gejala dan minimal 2 kali bertanya
        # atau jika semua gejala (21 gejala) sudah ditanyakan
        diagnosa_siap = False
        if user_selesai:
            diagnosa_siap = True
        elif gejala_aktif_count >= 3 and len(gejala_ditanyakan) >= 2:
            diagnosa_siap = True
        elif len(gejala_ditanyakan) >= 5: # Batasi maksimal bertanya 5 kali agar user tidak bosan
            diagnosa_siap = True
        elif len(gejala_teridentifikasi) + len(gejala_ditanyakan) >= 21:
            diagnosa_siap = True

        # Jika diagnosa siap dan ada minimal 1 gejala aktif, kembalikan bendera siap
        if diagnosa_siap and gejala_aktif_count > 0:
            return {
                'gejala_baru': gejala_baru,
                'jawaban_bot': "Baik, saya rasa informasi gejala Anda sudah cukup. Saya akan segera memproses data ini dengan mesin Certainty Factor untuk menganalisis kondisi lambung Anda. Mohon tunggu sebentar...",
                'diagnosa_siap': True,
                'gejala_teridentifikasi': gejala_teridentifikasi,
                'gejala_ditanyakan': gejala_ditanyakan
            }
        elif user_selesai and gejala_aktif_count == 0:
            # Jika user bilang selesai tapi belum ada gejala terdeteksi sama sekali
            return {
                'gejala_baru': gejala_baru,
                'jawaban_bot': "Saya belum berhasil mencatat gejala spesifik yang Anda alami. Silakan ceritakan keluhan lambung Anda secara detail (misalnya: perut kembung, perih ulu hati, mual, dll.) agar saya bisa membantu menganalisis.",
                'diagnosa_siap': False,
                'gejala_teridentifikasi': gejala_teridentifikasi,
                'gejala_ditanyakan': gejala_ditanyakan
            }

        # 6. Strategi Differential Diagnosis (Menentukan Pertanyaan Lanjutan)
        # Cari penyakit kandidat berdasarkan gejala saat ini
        penyakit_skor = {}
        for rule in RULES:
            kode_gejala = rule['gejala']
            kode_penyakit = rule['penyakit']
            mb = rule['mb']
            md = rule['md']
            
            if kode_gejala in gejala_teridentifikasi and gejala_teridentifikasi[kode_gejala] > 0.0:
                cf_pakar = mb - md
                cf_user = gejala_teridentifikasi[kode_gejala]
                skor = cf_pakar * cf_user
                
                if kode_penyakit not in penyakit_skor:
                    penyakit_skor[kode_penyakit] = skor
                else:
                    # Kombinasi CF sederhana untuk ranking kandidat
                    penyakit_skor[kode_penyakit] += skor * (1 - penyakit_skor[kode_penyakit])

        # Urutkan kandidat penyakit berdasarkan skor tertinggi
        kandidat_penyakit = sorted(penyakit_skor.items(), key=lambda x: x[1], reverse=True)
        
        # Pilih gejala berikutnya yang belum ditanyakan/diketahui dari penyakit kandidat teratas
        gejala_lanjutan_terpilih = None
        penyakit_target_nama = "gangguan lambung"
        
        if kandidat_penyakit:
            for kode_penyakit, _ in kandidat_penyakit:
                # Ambil nama penyakit
                p_detail = next((p for p in PENYAKIT if p['kode'] == kode_penyakit), None)
                if p_detail:
                    penyakit_target_nama = p_detail['nama']
                    
                # Cari rules untuk penyakit ini
                rules_penyakit = [r for r in RULES if r['penyakit'] == kode_penyakit]
                # Urutkan rules berdasarkan MB tertinggi (gejala paling representatif)
                rules_penyakit = sorted(rules_penyakit, key=lambda x: x['mb'], reverse=True)
                
                for r in rules_penyakit:
                    g_kode = r['gejala']
                    # Cari gejala yang belum diidentifikasi dan belum ditanyakan
                    if g_kode not in gejala_teridentifikasi and g_kode not in gejala_ditanyakan:
                        gejala_lanjutan_terpilih = g_kode
                        break
                if gejala_lanjutan_terpilih:
                    break

        # Jika tidak ada gejala pembeda dari penyakit kandidat, cari gejala acak yang belum ditanyakan/diketahui
        if not gejala_lanjutan_terpilih:
            for g in GEJALA:
                g_kode = g['kode']
                if g_kode not in gejala_teridentifikasi and g_kode not in gejala_ditanyakan:
                    gejala_lanjutan_terpilih = g_kode
                    break

        # Jika sudah tidak ada gejala yang tersisa untuk ditanyakan
        if not gejala_lanjutan_terpilih:
            if gejala_aktif_count > 0:
                return {
                    'gejala_baru': gejala_baru,
                    'jawaban_bot': "Seluruh gejala yang tersedia di database kami sudah dievaluasi. Saya akan segera merumuskan hasil diagnosa Certainty Factor untuk Anda...",
                    'diagnosa_siap': True,
                    'gejala_teridentifikasi': gejala_teridentifikasi,
                    'gejala_ditanyakan': gejala_ditanyakan
                }
            else:
                return {
                    'gejala_baru': gejala_baru,
                    'jawaban_bot': "Saya tidak mendeteksi adanya gejala penyakit lambung dari keluhan yang Anda sampaikan. Apakah Anda merasakan keluhan lain seperti nyeri ulu hati, mual, atau perut kembung?",
                    'diagnosa_siap': False,
                    'gejala_teridentifikasi': gejala_teridentifikasi,
                    'gejala_ditanyakan': gejala_ditanyakan
                }

        # Dapatkan detail gejala lanjutan yang akan ditanyakan
        g_detail = next((g for g in GEJALA if g['kode'] == gejala_lanjutan_terpilih), None)
        gejala_ditanyakan.append(gejala_lanjutan_terpilih)

        # Variasi template pertanyaan agar lebih natural, hangat, dan profesional
        template_pertanyaan = [
            f"Saya telah mencatat keluhan Anda. Untuk membantu mengidentifikasi kemungkinan **{penyakit_target_nama}**, apakah Anda juga merasakan **{g_detail['nama']}**? Bagaimana frekuensinya?",
            f"Catatan gejala Anda sudah diperbarui. Sebagai langkah analisis lebih lanjut, apakah Anda mengalami **{g_detail['nama']}** akhir-akhir ini?",
            f"Untuk mengerucutkan analisis Certainty Factor dengan akurat, saya perlu tahu: apakah keluhan **{g_detail['nama']}** juga turut Anda rasakan?",
            f"Apakah Anda juga merasakan gejala **{g_detail['nama']}**? (Anda bisa menjawab dengan kata keterangan seperti: sering, kadang-kadang, jarang, atau tidak pernah)",
            f"Untuk memastikan diagnosis awal yang akurat, apakah Anda juga mengalami keluhan **{g_detail['nama']}**?",
            f"Sangat penting bagi kami untuk mengevaluasi keluhan ini secara mendalam. Apakah Anda juga merasakan **{g_detail['nama']}**? Seberapa sering hal itu terjadi?"
        ]
        
        jawaban_bot = random.choice(template_pertanyaan)
        
        # Tambahkan informasi gejala yang sudah berhasil dideteksi di awal percakapan pertama kali agar user tahu bot mengerti
        if len(gejala_teridentifikasi) == len(gejala_baru) and len(gejala_baru) > 0:
            nama_gejala_dideteksi = []
            for k, v in gejala_baru.items():
                if v > 0:
                    g_nama = next((g['nama'] for g in GEJALA if g['kode'] == k), k)
                    nama_gejala_dideteksi.append(g_nama)
            if nama_gejala_dideteksi:
                jawaban_bot = (
                    f"Saya berhasil mencatat gejala Anda: **{', '.join(nama_gejala_dideteksi)}**.\n\n"
                    f"{jawaban_bot}"
                )

        return {
            'gejala_baru': gejala_baru,
            'jawaban_bot': jawaban_bot,
            'diagnosa_siap': False,
            'gejala_teridentifikasi': gejala_teridentifikasi,
            'gejala_ditanyakan': gejala_ditanyakan
        }

    def jelaskan_diagnosa(self, hasil_diagnosa):
        """
        Menjelaskan hasil diagnosa Certainty Factor menggunakan bahasa yang mudah dipahami.
        
        Args:
            hasil_diagnosa (dict): hasil kembalian dari fungsi `diagnosa()` di mesin.py
            
        Returns:
            str: penjelasan deskriptif hasil diagnosa
        """
        if not hasil_diagnosa:
            return "Berdasarkan gejala yang Anda sebutkan, sistem kami tidak mendeteksi kecocokan penyakit lambung yang ada di database Certainty Factor kami."

        hasil_utama = hasil_diagnosa['hasil_utama']
        top_hasil = hasil_diagnosa['top_hasil']
        persentase = hasil_utama['cf'] * 100

        penjelasan = (
            f"### 📋 Hasil Analisis Diagnosa Awal\n\n"
            f"Berdasarkan gejala-gejala yang Anda sampaikan selama percakapan, penyakit dengan tingkat kecocokan tertinggi adalah:\n\n"
            f"#### 🩺 **{hasil_utama['penyakit']}**\n"
            f"- **Tingkat Keyakinan (Certainty Factor):** **{persentase:.1f}%**\n\n"
            f"**Deskripsi Penyakit:**\n"
            f"{hasil_utama['deskripsi']}\n\n"
            f"**💊 Rekomendasi Penanganan:**\n"
            f"{hasil_utama['solusi']}\n\n"
        )

        # Jika ada kemungkinan penyakit lain (top 2 dan 3)
        kemungkinan_lain = top_hasil[1:]
        if kemungkinan_lain:
            penjelasan += "**🔍 Kemungkinan Penyakit Lain:**\n"
            for p in kemungkinan_lain:
                penjelasan += f"- **{p['penyakit']}** (Kecocokan: {p['cf']*100:.1f}%)\n"
            penjelasan += "\n"

        penjelasan += (
            f"---\n"
            f"⚠️ **Pernyataan Penyangkalan (Disclaimer Medis):**\n"
            f"Hasil di atas merupakan diagnosis awal prediktif berbasis sistem pakar dengan metode Certainty Factor, "
            f"dan **bukan merupakan diagnosis medis definitif**. Kami sangat menyarankan Anda tetap berkonsultasi "
            f"langsung dengan dokter atau spesialis penyakit dalam untuk pemeriksaan fisik lebih mendalam."
        )

        return penjelasan
