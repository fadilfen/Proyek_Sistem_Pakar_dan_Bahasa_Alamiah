# 🔥 STEP 6 - Integrasi Laravel ke API Python

## ✅ Yang Sudah Dibuat

### 1. **Controller**
- `DiagnosaController.php` - Handle form diagnosa dan kirim ke API Python

### 2. **Routes**
```php
Route::get('/diagnosa', [DiagnosaController::class, 'index']);
Route::post('/diagnosa', [DiagnosaController::class, 'proses']);
```

### 3. **Views**
- `diagnosa.blade.php` - Form input gejala dengan slider keyakinan
- `hasil.blade.php` - Tampilan hasil diagnosa dengan visualisasi CF
- `index.blade.php` - Dashboard utama dengan menu navigasi

### 4. **CSS**
- `diagnosa.css` - Styling modern untuk halaman diagnosa & hasil

### 5. **Model & Seeder**
- `Gejala.php` - Model untuk tabel gejala
- `GejalaSeeder.php` - Data 10 gejala penyakit lambung

---

## 🚀 Cara Menjalankan

### STEP 1: Jalankan Migration & Seeder
```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder gejala
php artisan db:seed --class=GejalaSeeder
```

### STEP 2: Jalankan Laravel Server
```bash
php artisan serve
```
Laravel akan berjalan di: `http://127.0.0.1:8000`

### STEP 3: Jalankan FastAPI Python
Buka terminal baru, masuk ke folder Python, lalu:
```bash
# Aktifkan virtual environment (jika ada)
# Windows:
venv\Scripts\activate

# Linux/Mac:
source venv/bin/activate

# Jalankan FastAPI
uvicorn main:app --reload
```
FastAPI akan berjalan di: `http://127.0.0.1:8000`

⚠️ **PENTING**: Pastikan FastAPI berjalan di port 8000, karena Laravel akan mengirim request ke `http://127.0.0.1:8000/diagnosa`

---

## 📋 Flow Aplikasi

1. User login → masuk ke dashboard (`/index`)
2. Klik "Mulai Diagnosa" → form gejala (`/diagnosa`)
3. Pilih gejala + atur tingkat keyakinan (slider 0.0 - 1.0)
4. Submit → Laravel kirim data ke FastAPI Python
5. FastAPI proses dengan algoritma CF
6. Laravel terima hasil → tampilkan di halaman hasil

---

## 🎨 Fitur UI

### Halaman Diagnosa
- ✅ Checkbox untuk pilih gejala
- ✅ Slider untuk atur tingkat keyakinan (0.0 - 1.0)
- ✅ Validasi minimal 1 gejala harus dipilih
- ✅ Button reset untuk clear form
- ✅ Responsive design

### Halaman Hasil
- ✅ Diagnosa utama dengan badge
- ✅ Nilai CF dalam bentuk persentase
- ✅ Progress bar visual untuk CF
- ✅ Top 3 kemungkinan penyakit lainnya
- ✅ Info box dengan disclaimer
- ✅ Button untuk diagnosa ulang

---

## 🔧 Troubleshooting

### Error: "Tidak dapat terhubung ke API Python"
**Solusi:**
1. Pastikan FastAPI sudah berjalan di `http://127.0.0.1:8000`
2. Test API dengan browser: buka `http://127.0.0.1:8000/docs`
3. Cek firewall tidak memblokir port 8000

### Error: "Belum ada data gejala"
**Solusi:**
```bash
php artisan db:seed --class=GejalaSeeder
```

### Error: Migration gagal
**Solusi:**
```bash
# Reset database
php artisan migrate:fresh

# Jalankan ulang seeder
php artisan db:seed --class=GejalaSeeder
```

---

## 📊 Format Data yang Dikirim ke API Python

```json
{
  "gejala": {
    "G01": 0.8,
    "G02": 1.0,
    "G03": 0.6
  }
}
```

## 📊 Format Response dari API Python

```json
{
  "hasil_utama": {
    "penyakit": "Gastritis",
    "cf": 0.85
  },
  "top_hasil": [
    {"penyakit": "Gastritis", "cf": 0.85},
    {"penyakit": "GERD", "cf": 0.72},
    {"penyakit": "Tukak Lambung", "cf": 0.65}
  ]
}
```

---

## 🎯 Next Steps

1. ✅ Buat API Python dengan FastAPI
2. ✅ Implementasi algoritma Certainty Factor
3. ✅ Tambahkan data penyakit & rules (MB, MD)
4. ✅ Test integrasi Laravel ↔ Python
5. 🔜 Simpan riwayat konsultasi ke database
6. 🔜 Tambahkan halaman info penyakit
7. 🔜 Export hasil diagnosa ke PDF

---

## 📝 Catatan Penting

- Nilai keyakinan user (slider) default: **0.8**
- Range nilai: **0.0** (tidak yakin) - **1.0** (sangat yakin)
- CF dihitung dengan rumus: **CF = MB - MD**
- Hasil diurutkan dari CF tertinggi ke terendah
- Minimal 1 gejala harus dipilih untuk diagnosa

---

## 🎨 Color Scheme

- Primary: `#36d6e5` (Cyan)
- Secondary: `#3697dd` (Blue)
- Accent: `#e96cc4` (Pink)
- Success: `#2e7d32` (Green)
- Error: `#ff6b6b` (Red)

---

**Happy Coding! 🚀**
