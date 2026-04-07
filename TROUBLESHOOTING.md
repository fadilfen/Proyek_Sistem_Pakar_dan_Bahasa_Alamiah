# 🔧 TROUBLESHOOTING - Error "message: API Sistem Pakar Penyakit Lambung"

## 🚨 Masalah

Ketika klik "Diagnosa Sekarang", muncul pesan:
```json
{"message":"API Sistem Pakar Penyakit Lambung"}
```

---

## 🔍 Penyebab

Pesan ini muncul dari **endpoint root** FastAPI (`/`), bukan dari endpoint `/diagnosa`.

Artinya:
- ✅ FastAPI **SUDAH JALAN**
- ❌ Tapi Laravel **SALAH KIRIM REQUEST** atau **CORS ISSUE**

---

## ✅ Solusi

### STEP 1: Pastikan FastAPI Jalan di Port 8001

Buka terminal baru, jalankan:

```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

Harus muncul:
```
INFO:     Uvicorn running on http://127.0.0.1:8001 (Press CTRL+C to quit)
INFO:     Started reloader process
INFO:     Started server process
INFO:     Waiting for application startup.
INFO:     Application startup complete.
```

### STEP 2: Test API Langsung

Buka browser, akses:
```
http://127.0.0.1:8001/docs
```

Harus muncul **Swagger UI** dengan 2 endpoint:
- `GET /` - Root
- `POST /diagnosa` - Diagnosa

### STEP 3: Test Endpoint Diagnosa

Di Swagger UI:
1. Klik endpoint `POST /diagnosa`
2. Klik "Try it out"
3. Masukkan data:
   ```json
   {
     "gejala": {
       "G01": 1.0,
       "G02": 0.8
     }
   }
   ```
4. Klik "Execute"

**Hasil yang benar:**
```json
{
  "hasil_utama": {
    "penyakit": "Tukak Lambung (Ulkus Peptikum)",
    "cf": 0.91
  },
  "top_hasil": [
    {
      "penyakit": "Tukak Lambung (Ulkus Peptikum)",
      "cf": 0.91
    },
    {
      "penyakit": "Gastritis (Maag)",
      "cf": 0.832
    }
  ]
}
```

### STEP 4: Test dari Laravel

Buka browser:
```
http://127.0.0.1:8000/test-api
```

Klik semua tombol test:
1. **Test Root Endpoint** → Harus muncul `{"message":"API Sistem Pakar Penyakit Lambung"}`
2. **Test Diagnosa Endpoint** → Harus muncul hasil diagnosa
3. **Test Submit Form** → Harus redirect ke halaman hasil

### STEP 5: Cek Log Laravel

Buka file log:
```
storage/logs/laravel.log
```

Cari baris terakhir, harus ada:
```
[timestamp] local.INFO: Data yang dikirim ke API: {"gejala":{"G01":1,"G02":0.8}}
[timestamp] local.INFO: Response dari API: {"status":200,"body":"..."}
```

Kalau ada error, akan muncul di sini.

---

## 🐛 Kemungkinan Error Lain

### Error 1: CORS Issue

**Gejala**: Browser console muncul error CORS

**Solusi**: Pastikan `main.py` sudah ada CORS middleware:

```python
from fastapi.middleware.cors import CORSMiddleware

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)
```

### Error 2: Port Salah

**Gejala**: Error "Connection refused"

**Solusi**: 
1. Cek FastAPI jalan di port **8001** (bukan 8000)
2. Cek `DiagnosaController.php` kirim ke `http://127.0.0.1:8001/diagnosa`

### Error 3: Data Tidak Lengkap

**Gejala**: Response `{"message": "Tidak ada hasil diagnosa"}`

**Solusi**: Pastikan seeder sudah dijalankan:
```bash
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
```

Cek database:
```sql
SELECT COUNT(*) FROM gejala;   -- Harus 10
SELECT COUNT(*) FROM penyakit; -- Harus 4
SELECT COUNT(*) FROM rules;    -- Harus 22
```

---

## 🧪 Test Manual dengan CURL

### Test 1: Root Endpoint
```bash
curl http://127.0.0.1:8001/
```

**Output:**
```json
{"message":"API Sistem Pakar Penyakit Lambung"}
```

### Test 2: Diagnosa Endpoint
```bash
curl -X POST "http://127.0.0.1:8001/diagnosa" ^
  -H "Content-Type: application/json" ^
  -d "{\"gejala\": {\"G01\": 1.0, \"G02\": 0.8}}"
```

**Output:**
```json
{
  "hasil_utama": {
    "penyakit": "Tukak Lambung (Ulkus Peptikum)",
    "cf": 0.91
  },
  "top_hasil": [...]
}
```

---

## 📋 Checklist Debug

- [ ] FastAPI jalan di port 8001
- [ ] Buka http://127.0.0.1:8001/docs → muncul Swagger UI
- [ ] Test endpoint `/diagnosa` di Swagger → return hasil
- [ ] Buka http://127.0.0.1:8000/test-api → semua test berhasil
- [ ] Cek `storage/logs/laravel.log` → tidak ada error
- [ ] Database ada data (gejala, penyakit, rules)
- [ ] Laravel kirim ke port 8001 (bukan 8000)

---

## 🎯 Langkah Terakhir

Kalau semua sudah OK tapi masih error:

1. **Restart semua server**:
   - Stop Laravel (CTRL+C)
   - Stop FastAPI (CTRL+C)
   - Jalankan ulang keduanya

2. **Clear cache Laravel**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

3. **Test lagi dari awal**:
   - Buka http://127.0.0.1:8000
   - Login
   - Klik "Mulai Diagnosa"
   - Pilih gejala
   - Submit

---

## 💡 Tips

Kalau masih muncul `{"message":"API Sistem Pakar Penyakit Lambung"}`:

1. **Buka Developer Tools** (F12) di browser
2. Klik tab **Network**
3. Submit form diagnosa
4. Lihat request yang dikirim:
   - URL harus: `http://127.0.0.1:8001/diagnosa`
   - Method harus: `POST`
   - Body harus ada: `{"gejala": {...}}`

Kalau URL-nya ke `http://127.0.0.1:8001/` (tanpa `/diagnosa`), berarti ada bug di controller.

---

**Semoga berhasil! 🚀**
