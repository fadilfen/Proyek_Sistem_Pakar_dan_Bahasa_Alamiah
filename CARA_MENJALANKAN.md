# ⚡ CARA MENJALANKAN SISTEM (WAJIB BACA!)

## 🚨 PENTING: Harus Jalankan 2 Server!

Sistem ini butuh **2 server berjalan bersamaan**:
1. **Laravel** (port 8000) - Frontend & Backend
2. **FastAPI** (port 8001) - Mesin Inferensi Python

---

## 📋 Langkah-Langkah

### STEP 1: Setup Database (Sekali Aja)

Buka terminal di root project, jalankan:

```bash
php artisan migrate:fresh
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
```

✅ **Cek berhasil**: Buka phpMyAdmin, lihat tabel `gejala`, `penyakit`, `rules` sudah ada data

---

### STEP 2: Install Python Dependencies (Sekali Aja)

```bash
cd Mesin_Inferensi
pip install -r requirements.txt
cd ..
```

✅ **Cek berhasil**: Jalankan `pip list`, harus ada `fastapi`, `uvicorn`, `mysql-connector-python`

---

### STEP 3: Jalankan Laravel Server

**Buka Terminal 1:**

```bash
php artisan serve
```

✅ **Cek berhasil**: 
- Muncul: `Server running on [http://127.0.0.1:8000]`
- Buka browser: http://127.0.0.1:8000 → muncul halaman login

⚠️ **JANGAN TUTUP TERMINAL INI!**

---

### STEP 4: Jalankan FastAPI Server

**Buka Terminal 2 (terminal baru):**

```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

✅ **Cek berhasil**: 
- Muncul: `Uvicorn running on http://127.0.0.1:8001`
- Buka browser: http://127.0.0.1:8001/docs → muncul Swagger UI

⚠️ **JANGAN TUTUP TERMINAL INI!**

---

### STEP 5: Test Aplikasi

1. Buka: http://127.0.0.1:8000
2. Login (atau daftar akun baru)
3. Klik "Mulai Diagnosa"
4. Pilih beberapa gejala
5. Atur slider keyakinan
6. Klik "Diagnosa Sekarang"
7. **Tunggu beberapa detik** (Laravel kirim ke Python)
8. Lihat hasil diagnosa

---

## 🔥 Cara Cepat (Pakai Batch File)

### Windows:

1. **Double click**: `start-laravel.bat`
2. **Double click**: `start-fastapi.bat` (di terminal baru)
3. Buka browser: http://127.0.0.1:8000

---

## ⚠️ Troubleshooting

### Error: "Tidak dapat terhubung ke API Python"

**Penyebab**: FastAPI belum jalan

**Solusi**:
1. Buka terminal baru
2. Jalankan:
   ```bash
   cd Mesin_Inferensi
   uvicorn main:app --reload --port 8001
   ```
3. Tunggu sampai muncul: `Uvicorn running on http://127.0.0.1:8001`
4. Test di browser: http://127.0.0.1:8001/docs
5. Kalau muncul Swagger UI → FastAPI sudah jalan ✅

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

### Error: "Koneksi database gagal"

**Penyebab**: MySQL belum jalan atau database belum dibuat

**Solusi**:
1. Buka Laragon/XAMPP
2. Start MySQL
3. Buat database: `proyek_sispak`
4. Jalankan migration lagi

---

## 📊 Checklist Sebelum Demo

- [ ] MySQL/MariaDB sudah running
- [ ] Database `proyek_sispak` sudah dibuat
- [ ] Migration berhasil (5 tabel)
- [ ] Seeder berhasil (gejala, penyakit, rules)
- [ ] Python dependencies terinstall
- [ ] **Terminal 1**: Laravel running di port 8000
- [ ] **Terminal 2**: FastAPI running di port 8001
- [ ] Browser bisa buka http://127.0.0.1:8000
- [ ] Browser bisa buka http://127.0.0.1:8001/docs

---

## 🎯 Yang Harus Jalan Bersamaan

```
┌─────────────────────────────────────┐
│  Terminal 1: Laravel (Port 8000)   │
│  php artisan serve                  │
└─────────────────────────────────────┘
              +
┌─────────────────────────────────────┐
│  Terminal 2: FastAPI (Port 8001)   │
│  uvicorn main:app --reload --port  │
│  8001                               │
└─────────────────────────────────────┘
              ↓
        SISTEM JALAN! ✅
```

---

## 💡 Tips

1. **Jangan tutup terminal** yang menjalankan server
2. **Kalau mau stop**, tekan `CTRL+C` di terminal
3. **Kalau error**, cek kedua terminal ada error message apa
4. **Test API Python dulu** sebelum test dari Laravel:
   - Buka: http://127.0.0.1:8001/docs
   - Klik endpoint `/diagnosa`
   - Klik "Try it out"
   - Input:
     ```json
     {
       "gejala": {
         "G01": 1.0,
         "G02": 0.8
       }
     }
     ```
   - Klik "Execute"
   - Kalau muncul hasil → API Python OK ✅

---

**Selamat mencoba! 🚀**

Kalau masih error, screenshot error message dan tanya lagi.
