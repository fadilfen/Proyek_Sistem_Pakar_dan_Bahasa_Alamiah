# 🚀 PANDUAN LENGKAP - Sistem Pakar Diagnosa Penyakit Lambung

## 📋 Daftar Isi
1. [Persiapan Awal](#persiapan-awal)
2. [Setup Database](#setup-database)
3. [Setup Python API](#setup-python-api)
4. [Jalankan Aplikasi](#jalankan-aplikasi)
5. [Testing](#testing)
6. [Troubleshooting](#troubleshooting)

---

## 🔧 Persiapan Awal

### Requirements:
- ✅ PHP 8.1+
- ✅ Composer
- ✅ MySQL/MariaDB
- ✅ Python 3.8+
- ✅ Laragon (atau XAMPP/WAMP)

---

## 🗄️ Setup Database

### 1. Buat Database
```sql
CREATE DATABASE proyek_sispak;
```

### 2. Konfigurasi .env Laravel
Pastikan file `.env` sudah benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyek_sispak
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Jalankan Migration
```bash
php artisan migrate:fresh
```

Output yang benar:
```
✓ 0001_01_01_000000_create_users_table
✓ 2025_01_01_000001_create_gejala_table
✓ 2025_01_01_000002_create_penyakit_table
✓ 2025_01_01_000003_create_rules_table
✓ 2025_01_01_000004_create_konsultasi_tables
```

### 4. Jalankan Seeder
```bash
# Seeder gejala (10 gejala)
php artisan db:seed --class=GejalaSeeder

# Seeder penyakit (4 penyakit)
php artisan db:seed --class=PenyakitSeeder

# Seeder rules (basis pengetahuan)
php artisan db:seed --class=RulesSeeder
```

### 5. Verifikasi Data
```sql
SELECT COUNT(*) FROM gejala;      -- Harus 10
SELECT COUNT(*) FROM penyakit;    -- Harus 4
SELECT COUNT(*) FROM rules;       -- Harus 22
```

---

## 🐍 Setup Python API

### 1. Masuk ke Folder Mesin_Inferensi
```bash
cd Mesin_Inferensi
```

### 2. Buat Virtual Environment (Opsional tapi Recommended)
```bash
# Windows
python -m venv venv
venv\Scripts\activate

# Linux/Mac
python3 -m venv venv
source venv/bin/activate
```

### 3. Install Dependencies
```bash
pip install -r requirements.txt
```

Dependencies yang diinstall:
- `fastapi` - Framework API
- `uvicorn` - ASGI server
- `mysql-connector-python` - Koneksi MySQL
- `pydantic` - Validasi data

### 4. Test Koneksi Database
```bash
python database.py
```

Output yang benar:
```
Koneksi ke database berhasil!
Koneksi berhasil!
```

### 5. Test Algoritma CF
```bash
python cf.py
```

Output yang benar:
```
Hasil CF semua penyakit:
{'Gastritis': 0.88, 'GERD': 0.3}

Hasil terbaik:
{'penyakit': 'Gastritis', 'cf': 0.88}

Top 3 hasil:
[{'penyakit': 'Gastritis', 'cf': 0.88}, {'penyakit': 'GERD', 'cf': 0.3}]
```

---

## 🚀 Jalankan Aplikasi

### Terminal 1: Laravel Server
```bash
# Di root project
php artisan serve
```

Output:
```
INFO  Server running on [http://127.0.0.1:8000]
```

### Terminal 2: FastAPI Python
```bash
# Di folder Mesin_Inferensi
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

⚠️ **PENTING**: FastAPI harus di port **8001** (bukan 8000)

Output:
```
INFO:     Uvicorn running on http://127.0.0.1:8001
INFO:     Application startup complete.
```

### Update DiagnosaController
Ubah URL API di `DiagnosaController.php`:
```php
$response = Http::timeout(10)->post('http://127.0.0.1:8001/diagnosa', [
    'gejala' => $data
]);
```

---

## 🧪 Testing

### 1. Test API Python Langsung
Buka browser: `http://127.0.0.1:8001/docs`

Atau test dengan curl:
```bash
curl -X POST "http://127.0.0.1:8001/diagnosa" \
  -H "Content-Type: application/json" \
  -d "{\"gejala\": {\"G01\": 1.0, \"G02\": 0.8}}"
```

Response yang benar:
```json
{
  "hasil_utama": {
    "penyakit": "Gastritis (Maag)",
    "cf": 0.8
  },
  "top_hasil": [
    {"penyakit": "Gastritis (Maag)", "cf": 0.8},
    {"penyakit": "GERD", "cf": 0.56}
  ]
}
```

### 2. Test Laravel
1. Buka: `http://127.0.0.1:8000`
2. Login (atau daftar akun baru)
3. Klik "Mulai Diagnosa"
4. Pilih beberapa gejala
5. Atur slider keyakinan
6. Klik "Diagnosa Sekarang"
7. Lihat hasil

---

## 🔥 Flow Lengkap Aplikasi

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ 1. Buka http://127.0.0.1:8000
       ▼
┌─────────────┐
│    Login    │ ← Halaman utama
└──────┬──────┘
       │ 2. Login berhasil
       ▼
┌─────────────┐
│  Dashboard  │ ← Menu navigasi
└──────┬──────┘
       │ 3. Klik "Mulai Diagnosa"
       ▼
┌─────────────┐
│Form Diagnosa│ ← Pilih gejala + slider
└──────┬──────┘
       │ 4. Submit form
       ▼
┌─────────────────────┐
│ DiagnosaController  │
│  (Laravel Backend)  │
└──────┬──────────────┘
       │ 5. POST ke API Python
       │    Data: {"gejala": {"G01": 0.8}}
       ▼
┌─────────────────────┐
│   FastAPI Python    │
│  (Port 8001)        │
│  - Konversi kode    │
│  - Ambil rules      │
│  - Hitung CF        │
└──────┬──────────────┘
       │ 6. Return hasil
       │    {"hasil_utama": {...}}
       ▼
┌─────────────────────┐
│ DiagnosaController  │
│  (Terima response)  │
└──────┬──────────────┘
       │ 7. Render view
       ▼
┌─────────────┐
│Halaman Hasil│ ← Tampilkan diagnosa
└─────────────┘
```

---

## ⚠️ Troubleshooting

### Error: "Koneksi database gagal"
**Penyebab**: MySQL belum jalan atau konfigurasi salah

**Solusi**:
1. Pastikan MySQL/MariaDB sudah running
2. Cek kredensial di `.env` Laravel
3. Cek kredensial di `Mesin_Inferensi/database.py`

### Error: "Tidak dapat terhubung ke API Python"
**Penyebab**: FastAPI belum jalan atau port salah

**Solusi**:
1. Pastikan FastAPI running di port 8001
2. Test API: `http://127.0.0.1:8001/docs`
3. Update URL di `DiagnosaController.php`

### Error: "Belum ada data gejala"
**Penyebab**: Seeder belum dijalankan

**Solusi**:
```bash
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
```

### Error: "ModuleNotFoundError: No module named 'fastapi'"
**Penyebab**: Dependencies Python belum diinstall

**Solusi**:
```bash
cd Mesin_Inferensi
pip install -r requirements.txt
```

### Error: Port 8000 sudah digunakan
**Solusi**:
```bash
# Laravel - ganti port
php artisan serve --port=8080

# FastAPI - ganti port
uvicorn main:app --reload --port=8001
```

---

## 📊 Data yang Sudah Ada

### Gejala (10):
1. G01 - Nyeri ulu hati
2. G02 - Mual
3. G03 - Muntah
4. G04 - Perut kembung
5. G05 - Cepat kenyang
6. G06 - Sendawa berlebihan
7. G07 - Nyeri perut setelah makan
8. G08 - Heartburn
9. G09 - BAB berdarah atau hitam
10. G10 - Penurunan berat badan

### Penyakit (4):
1. P01 - Gastritis (Maag)
2. P02 - GERD
3. P03 - Tukak Lambung
4. P04 - Dispepsia Fungsional

### Rules (22):
Basis pengetahuan dengan nilai MB dan MD untuk setiap kombinasi gejala-penyakit

---

## 🎯 Checklist Sebelum Demo

- [ ] Database sudah dibuat
- [ ] Migration berhasil (5 tabel)
- [ ] Seeder berhasil (gejala, penyakit, rules)
- [ ] Python dependencies terinstall
- [ ] Test koneksi database Python berhasil
- [ ] Laravel server running (port 8000)
- [ ] FastAPI running (port 8001)
- [ ] Bisa login ke aplikasi
- [ ] Form diagnosa muncul dengan 10 gejala
- [ ] Submit form berhasil dan tampil hasil

---

## 📝 Catatan Penting

1. **Port Configuration**:
   - Laravel: `http://127.0.0.1:8000`
   - FastAPI: `http://127.0.0.1:8001`

2. **Database**:
   - Nama: `proyek_sispak`
   - User: `root`
   - Password: (kosong)

3. **Algoritma CF**:
   - CF = MB - MD
   - CF_final = CF_pakar × nilai_user
   - CF_combine = CF1 + CF2 × (1 - CF1)

4. **Nilai Default**:
   - Slider keyakinan: 0.8 (80%)
   - Range: 0.0 - 1.0

---

**Sistem siap digunakan! 🎉**

Jika ada error, cek bagian Troubleshooting atau hubungi developer.
