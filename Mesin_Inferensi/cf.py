# ================================
# CERTAINTY FACTOR MODULE
# ================================

# Hitung CF dari MB dan MD (dari pakar)
def hitung_cf_per_gejala(mb, md):
    return mb - md


# Fungsi untuk menggabungkan CF
def combine_cf(cf1, cf2):
    return cf1 + cf2 * (1 - cf1)


# Fungsi utama menghitung CF semua penyakit
def hitung_cf(gejala_user, rules):
    """
    gejala_user: dict → {1: 0.8, 2: 0.6} (id_gejala: nilai_user)
    rules: list of dict dari database
    """

    hasil = {}  # {id_penyakit: cf_value}
    penyakit_names = {}  # {id_penyakit: nama_penyakit}

    for rule in rules:
        id_penyakit = rule['id_penyakit']
        id_gejala = rule['id_gejala']
        nama_penyakit = rule['nama_penyakit']

        mb = float(rule['mb'])
        md = float(rule['md'])

        # simpan nama penyakit
        if id_penyakit not in penyakit_names:
            penyakit_names[id_penyakit] = nama_penyakit

        # cek apakah gejala dipilih user
        if id_gejala in gejala_user:
            # CF dari pakar
            cf_pakar = hitung_cf_per_gejala(mb, md)

            # CF dari user
            cf_user = float(gejala_user[id_gejala])

            # CF akhir
            cf = cf_user * cf_pakar

            # Gabungkan CF jika penyakit sama
            if id_penyakit not in hasil:
                hasil[id_penyakit] = cf
            else:
                hasil[id_penyakit] = combine_cf(hasil[id_penyakit], cf)

    # ubah id_penyakit ke nama_penyakit
    hasil_final = {}
    for id_penyakit, cf_value in hasil.items():
        nama = penyakit_names.get(id_penyakit, f"Penyakit {id_penyakit}")
        hasil_final[nama] = cf_value

    return hasil_final


# Ambil hasil terbaik (CF tertinggi)
def get_hasil_terbaik(hasil_cf):
    if not hasil_cf:
        return None

    penyakit_terbaik = max(hasil_cf, key=hasil_cf.get)

    return {
        "penyakit": penyakit_terbaik,
        "cf": round(hasil_cf[penyakit_terbaik], 4)
    }


# Ambil top N hasil
def get_top_hasil(hasil_cf, limit=3):
    sorted_hasil = sorted(hasil_cf.items(), key=lambda x: x[1], reverse=True)

    return [
        {"penyakit": p, "cf": round(cf, 4)}
        for p, cf in sorted_hasil[:limit]
    ]


if __name__ == "__main__":

    # Input user (nilai keyakinan user)
    gejala_user = {
        1: 1.0,   # id_gejala 1
        2: 1.0    # id_gejala 2
    }

    # Data rules (simulasi dari database)
    rules = [
        {"id_penyakit": 1, "id_gejala": 1, "mb": 0.7, "md": 0.1, "nama_penyakit": "Gastritis"},
        {"id_penyakit": 1, "id_gejala": 2, "mb": 0.6, "md": 0.2, "nama_penyakit": "Gastritis"},
        {"id_penyakit": 2, "id_gejala": 1, "mb": 0.5, "md": 0.2, "nama_penyakit": "GERD"},
    ]

    hasil = hitung_cf(gejala_user, rules)

    print("Hasil CF semua penyakit:")
    print(hasil)

    print("\nHasil terbaik:")
    print(get_hasil_terbaik(hasil))

    print("\nTop 3 hasil:")
    print(get_top_hasil(hasil))