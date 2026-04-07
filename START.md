# ⚡ CARA MENJALANKAN - SUPER SIMPLE

## 🚀 3 Langkah Saja!

### LANGKAH 1: Jalankan Laravel
**Double click file:** `start-laravel.bat`

Atau buka CMD dan ketik:
```bash
php artisan serve
```

✅ Jangan tutup window ini!

---

### LANGKAH 2: Jalankan FastAPI
**Buka CMD baru**, ketik:
```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

✅ Jangan tutup window ini!

---

### LANGKAH 3: Buka Browser
```
http://127.0.0.1:8000
```

**Login dengan:**
- Username: (daftar dulu kalau belum punya)
- Password: (password yang kamu buat)

**Atau daftar akun baru:**
- Klik "Daftar"
- Isi form
- Login

---

## ✅ Selesai!

Setelah login, langsung masuk ke halaman diagnosa.

Pilih gejala → Klik "Diagnosa Sekarang" → Lihat hasil!

---

## ⚠️ Kalau Error

**Error: "Tidak dapat terhubung ke API Python"**

→ Pastikan FastAPI jalan di terminal kedua (LANGKAH 2)

**Error: "Belum ada data gejala"**

→ Jalankan seeder:
```bash
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
```

---

**SELESAI! 🎉**
