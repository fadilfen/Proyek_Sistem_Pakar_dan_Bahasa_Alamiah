from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from database import get_connection
from cf import hitung_cf, get_hasil_terbaik, get_top_hasil

app = FastAPI()

# CORS untuk Laravel
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def root():
    return {"message": "API Sistem Pakar Penyakit Lambung"}

@app.post("/diagnosa")
def diagnosa(data: dict):
    """
    Format input dari Laravel:
    {
        "gejala": {
            "G01": 1.0,
            "G02": 0.8
        }
    }
    """

    # koneksi database
    conn = get_connection()
    if not conn:
        return {"error": "Koneksi database gagal"}
    
    cursor = conn.cursor(dictionary=True)

    # ambil input user (kode_gejala)
    gejala_user = data.get("gejala", {})

    if not gejala_user:
        conn.close()
        return {"message": "Gejala kosong"}

    # konversi kode_gejala ke id_gejala
    kode_list = list(gejala_user.keys())
    placeholders = ','.join(['%s'] * len(kode_list))
    
    cursor.execute(f"SELECT id_gejala, kode_gejala FROM gejala WHERE kode_gejala IN ({placeholders})", kode_list)
    gejala_map = {row['kode_gejala']: row['id_gejala'] for row in cursor.fetchall()}

    # ubah input user dari kode ke id
    gejala_user_id = {}
    for kode, nilai in gejala_user.items():
        if kode in gejala_map:
            gejala_user_id[gejala_map[kode]] = nilai

    # ambil rules dengan join ke penyakit
    cursor.execute("""
        SELECT r.*, p.nama_penyakit, p.kode_penyakit 
        FROM rules r
        JOIN penyakit p ON r.id_penyakit = p.id_penyakit
    """)
    rules = cursor.fetchall()

    conn.close()

    if not rules:
        return {"message": "Belum ada data rules di database"}

    # hitung CF
    hasil_cf = hitung_cf(gejala_user_id, rules)

    if not hasil_cf:
        return {"message": "Tidak ada hasil diagnosa"}

    # ambil hasil terbaik
    terbaik = get_hasil_terbaik(hasil_cf)

    # ambil top 3
    top = get_top_hasil(hasil_cf)

    return {
        "hasil_utama": terbaik,
        "top_hasil": top
    }