# Data Gejala
GEJALA = [
    {'kode': 'G01', 'nama': 'Nyeri ulu hati'},
    {'kode': 'G02', 'nama': 'Mual'},
    {'kode': 'G03', 'nama': 'Muntah'},
    {'kode': 'G04', 'nama': 'Perut kembung'},
    {'kode': 'G05', 'nama': 'Cepat kenyang'},
    {'kode': 'G06', 'nama': 'Sendawa berlebihan'},
    {'kode': 'G07', 'nama': 'Nyeri perut setelah makan'},
    {'kode': 'G08', 'nama': 'Heartburn (rasa panas di dada)'},
    {'kode': 'G09', 'nama': 'BAB berdarah atau hitam'},
    {'kode': 'G10', 'nama': 'Penurunan berat badan'}
]

# Data Penyakit
PENYAKIT = [
    {
        'kode': 'P01',
        'nama': 'Gastritis (Maag)',
        'deskripsi': 'Gastritis adalah peradangan pada lapisan lambung yang dapat menyebabkan nyeri dan ketidaknyamanan. Kondisi ini dapat bersifat akut atau kronis.',
        'solusi': 'Hindari makanan pedas dan asam, makan teratur, kurangi stres, hindari alkohol dan rokok. Konsultasi dengan dokter untuk pengobatan yang tepat.'
    },
    {
        'kode': 'P02',
        'nama': 'GERD (Gastroesophageal Reflux Disease)',
        'deskripsi': 'GERD adalah kondisi dimana asam lambung naik ke kerongkongan, menyebabkan sensasi terbakar di dada (heartburn) dan gejala lainnya.',
        'solusi': 'Hindari makanan berlemak dan pedas, jangan langsung berbaring setelah makan, tinggikan kepala saat tidur, kurangi porsi makan. Konsultasi dengan dokter untuk terapi yang sesuai.'
    },
    {
        'kode': 'P03',
        'nama': 'Tukak Lambung (Ulkus Peptikum)',
        'deskripsi': 'Tukak lambung adalah luka terbuka pada lapisan dalam lambung yang dapat menyebabkan nyeri dan komplikasi serius jika tidak diobati.',
        'solusi': 'Hindari NSAID, kurangi stres, hindari alkohol dan rokok, makan makanan yang mudah dicerna. SEGERA konsultasi dengan dokter karena memerlukan pengobatan medis.'
    },
    {
        'kode': 'P04',
        'nama': 'Dispepsia Fungsional',
        'deskripsi': 'Dispepsia fungsional adalah gangguan pencernaan kronis tanpa penyebab organik yang jelas, ditandai dengan rasa tidak nyaman di perut bagian atas.',
        'solusi': 'Makan porsi kecil tapi sering, hindari makanan pemicu, kelola stres dengan baik, olahraga teratur. Konsultasi dengan dokter untuk evaluasi lebih lanjut.'
    }
]

# Rules (Basis Pengetahuan) - Format: kode_gejala, kode_penyakit, MB, MD
RULES = [
    # Gastritis (P01)
    {'gejala': 'G01', 'penyakit': 'P01', 'mb': 0.7, 'md': 0.1},
    {'gejala': 'G02', 'penyakit': 'P01', 'mb': 0.6, 'md': 0.2},
    {'gejala': 'G03', 'penyakit': 'P01', 'mb': 0.5, 'md': 0.1},
    {'gejala': 'G04', 'penyakit': 'P01', 'mb': 0.6, 'md': 0.15},
    {'gejala': 'G05', 'penyakit': 'P01', 'mb': 0.4, 'md': 0.1},
    {'gejala': 'G07', 'penyakit': 'P01', 'mb': 0.7, 'md': 0.2},
    
    # GERD (P02)
    {'gejala': 'G06', 'penyakit': 'P02', 'mb': 0.8, 'md': 0.1},
    {'gejala': 'G08', 'penyakit': 'P02', 'mb': 0.9, 'md': 0.05},
    {'gejala': 'G01', 'penyakit': 'P02', 'mb': 0.5, 'md': 0.2},
    {'gejala': 'G02', 'penyakit': 'P02', 'mb': 0.4, 'md': 0.15},
    {'gejala': 'G03', 'penyakit': 'P02', 'mb': 0.3, 'md': 0.1},
    
    # Tukak Lambung (P03)
    {'gejala': 'G01', 'penyakit': 'P03', 'mb': 0.8, 'md': 0.1},
    {'gejala': 'G07', 'penyakit': 'P03', 'mb': 0.8, 'md': 0.1},
    {'gejala': 'G09', 'penyakit': 'P03', 'mb': 0.9, 'md': 0.05},
    {'gejala': 'G02', 'penyakit': 'P03', 'mb': 0.6, 'md': 0.15},
    {'gejala': 'G03', 'penyakit': 'P03', 'mb': 0.5, 'md': 0.1},
    {'gejala': 'G10', 'penyakit': 'P03', 'mb': 0.6, 'md': 0.2},
    
    # Dispepsia Fungsional (P04)
    {'gejala': 'G04', 'penyakit': 'P04', 'mb': 0.7, 'md': 0.1},
    {'gejala': 'G05', 'penyakit': 'P04', 'mb': 0.8, 'md': 0.1},
    {'gejala': 'G01', 'penyakit': 'P04', 'mb': 0.5, 'md': 0.2},
    {'gejala': 'G02', 'penyakit': 'P04', 'mb': 0.5, 'md': 0.2},
    {'gejala': 'G06', 'penyakit': 'P04', 'mb': 0.4, 'md': 0.15}
]

# Fungsi Certainty Factor
def hitung_cf_per_gejala(mb, md):
    """Menghitung CF dari MB dan MD"""
    return mb - md

def combine_cf(cf1, cf2):
    """Menggabungkan dua nilai CF"""
    return cf1 + cf2 * (1 - cf1)

def hitung_cf(gejala_user):
    """
    Menghitung CF untuk semua penyakit berdasarkan gejala user
    
    Args:
        gejala_user: dict dengan format {kode_gejala: nilai_keyakinan}
        Contoh: {'G01': 1.0, 'G02': 0.8}
    
    Returns:
        dict dengan format {kode_penyakit: cf_value}
    """
    hasil = {}
    
    # Iterasi semua rules
    for rule in RULES:
        kode_gejala = rule['gejala']
        kode_penyakit = rule['penyakit']
        mb = rule['mb']
        md = rule['md']
        
        # Cek apakah gejala dipilih user
        if kode_gejala in gejala_user:
            # CF dari pakar
            cf_pakar = hitung_cf_per_gejala(mb, md)
            
            # CF dari user
            cf_user = float(gejala_user[kode_gejala])
            
            # CF akhir
            cf = cf_user * cf_pakar
            
            # Gabungkan CF jika penyakit sudah ada
            if kode_penyakit not in hasil:
                hasil[kode_penyakit] = cf
            else:
                hasil[kode_penyakit] = combine_cf(hasil[kode_penyakit], cf)
    
    return hasil

def get_penyakit_by_kode(kode):
    """Mendapatkan detail penyakit berdasarkan kode"""
    for p in PENYAKIT:
        if p['kode'] == kode:
            return p
    return None

def diagnosa(gejala_user):
    """
    Melakukan diagnosa lengkap
    
    Args:
        gejala_user: dict dengan format {kode_gejala: nilai_keyakinan}
    
    Returns:
        dict dengan hasil diagnosa lengkap
    """
    # Hitung CF semua penyakit
    hasil_cf = hitung_cf(gejala_user)
    
    if not hasil_cf:
        return None
    
    # Urutkan berdasarkan CF tertinggi
    sorted_hasil = sorted(hasil_cf.items(), key=lambda x: x[1], reverse=True)
    
    # Ambil top 3
    top_hasil = []
    for kode_penyakit, cf_value in sorted_hasil[:3]:
        penyakit = get_penyakit_by_kode(kode_penyakit)
        if penyakit:
            top_hasil.append({
                'penyakit': penyakit['nama'],
                'cf': round(cf_value, 4),
                'deskripsi': penyakit['deskripsi'],
                'solusi': penyakit['solusi']
            })
    
    # Hasil utama (CF tertinggi)
    if top_hasil:
        return {
            'hasil_utama': top_hasil[0],
            'top_hasil': top_hasil
        }
    
    return None

# Test jika file dijalankan langsung
if __name__ == '__main__':
    # Test dengan gejala contoh
    gejala_test = {
        'G01': 1.0,  # Nyeri ulu hati
        'G02': 0.8,  # Mual
        'G04': 0.7   # Perut kembung
    }
    
    hasil = diagnosa(gejala_test)
    
    if hasil:
        print("=== HASIL DIAGNOSA ===")
        print(f"\nPenyakit: {hasil['hasil_utama']['penyakit']}")
        print(f"CF: {hasil['hasil_utama']['cf']} ({hasil['hasil_utama']['cf']*100:.1f}%)")
        print(f"\nDeskripsi: {hasil['hasil_utama']['deskripsi']}")
        print(f"\nSolusi: {hasil['hasil_utama']['solusi']}")
        
        print("\n=== TOP 3 HASIL ===")
        for i, item in enumerate(hasil['top_hasil'], 1):
            print(f"\n{i}. {item['penyakit']} - CF: {item['cf']} ({item['cf']*100:.1f}%)")
    else:
        print("Tidak ada hasil diagnosa")
