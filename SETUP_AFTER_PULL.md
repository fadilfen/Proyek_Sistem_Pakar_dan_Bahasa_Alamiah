# 🚀 SETUP PROJECT SETELAH GIT PULL

## 📋 Panduan untuk Teman yang Pull Project

### STEP 1: Clone/Pull Repository
```bash
# Clone (jika pertama kali)
git clone <url-repository>
cd Proyek_Sistem_Pakar_dan_Bahasa_Ilmiah

# Atau Pull (jika sudah ada)
git pull origin main
```

---

## 🔧 STEP 2: Install Dependencies

### A. Install Composer Dependencies (Laravel)
```bash
composer install
```

### B. Install Python Dependencies (FastAPI)
```bash
cd Mesin_Inferensi
pip install -r requirements.txt
cd ..
```

---

## ⚙️ STEP 3: Konfigurasi Environment

### A. Copy File .env
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### B. Generate Application Key
```bash
php artisan key:generate
```

### C. Edit File .env
Buka file `.env` dan sesuaikan:
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:... (sudah di-generate otomatis)
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyek_sispak
DB_USERNAME=root
DB_PASSWORD=

# Sesuaikan dengan kredensial MySQL kamu!
```

---

## 🗄️ STEP 4: Setup Database

### A. Buat Database
Buka phpMyAdmin atau MySQL CLI:
```sql
CREATE DATABASE proyek_sispak;
```

### B. Jalankan Migration
```bash
php artisan migrate
```

Output yang benar:
```
✓ 0001_01_01_000000_create_users_table
✓ 2025_01_01_000001_create_gejala_table
✓ 2025_01_01_000002_create_penyakit_table
✓ 2025_01_01_000003_create_rules_table
✓ 2025_01_01_000004_create_konsultasi_tables
✓ 2026_04_07_113559_add_hasil_to_konsultasi_table
```

### C. Jalankan Seeder (Data Awal)
```bash
# Seeder Gejala (10 gejala)
php artisan db:seed --class=GejalaSeeder

# Seeder Penyakit (4 penyakit)
php artisan db:seed --class=PenyakitSeeder

# Seeder Rules (22 rules dengan MB & MD)
php artisan db:seed --class=RulesSeeder

# Seeder Admin (user admin)
php artisan db:seed --class=UserAdminSeeder
```

### D. Verifikasi Data
Buka phpMyAdmin, cek tabel:
- `gejala` → harus ada 10 data
- `penyakit` → harus ada 4 data
- `rules` → harus ada 22 data
- `users` → harus ada 1 admin (username: admin)

---

## 🐍 STEP 5: Setup Python (FastAPI)

### A. Cek Koneksi Database Python
```bash
cd Mesin_Inferensi
python database.py
```

Output yang benar:
```
Koneksi ke database berhasil!
Koneksi berhasil!
```

### B. Test Algoritma CF
```bash
python cf.py
```

Output yang benar:
```
Hasil CF semua penyakit:
{'Gastritis': 0.88, 'GERD': 0.3}
...
```

---

## 🚀 STEP 6: Jalankan Aplikasi

### Terminal 1: Laravel Server
```bash
php artisan serve
```

Output:
```
INFO  Server running on [http://127.0.0.1:8000]
```

### Terminal 2: FastAPI Server
```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

Output:
```
INFO:     Uvicorn running on http://127.0.0.1:8001
INFO:     Application startup complete.
```

---

## ✅ STEP 7: Test Aplikasi

### A. Test Laravel
Buka browser: `http://127.0.0.1:8000`

Harus muncul halaman login.

### B. Test FastAPI
Buka browser: `http://127.0.0.1:8001/docs`

Harus muncul Swagger UI.

### C. Test Login User
1. Daftar akun baru atau
2. Login dengan akun yang sudah ada

### D. Test Login Admin
- Username: `admin`
- Password: `admin123`

Harus redirect ke `/admin/dashboard`

---

## 📁 STRUKTUR FILE YANG HARUS ADA

```
Proyek_Sistem_Pakar_dan_Bahasa_Ilmiah/
├── app/
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── GejalaSeeder.php
│       ├── PenyakitSeeder.php
│       ├── RulesSeeder.php
│       └── UserAdminSeeder.php
├── Mesin_Inferensi/
│   ├── main.py
│   ├── cf.py
│   ├── database.py
│   ├── models.py
│   └── requirements.txt
├── public/
│   └── css/
│       ├── auth.css
│       ├── style.css
│       ├── diagnosa.css
│       └── admin.css
├── resources/
│   └── views/
│       ├── admin/
│       ├── login.blade.php
│       ├── daftar.blade.php
│       ├── diagnosa.blade.php
│       ├── hasil.blade.php
│       └── riwayat.blade.php
├── .env.example
├── composer.json
├── README.md
└── START.md
```

---

## ⚠️ TROUBLESHOOTING

### Error: "SQLSTATE[HY000] [1049] Unknown database"
**Solusi:**
```sql
CREATE DATABASE proyek_sispak;
```

### Error: "Class 'GejalaSeeder' not found"
**Solusi:**
```bash
composer dump-autoload
php artisan db:seed --class=GejalaSeeder
```

### Error: "No module named 'fastapi'"
**Solusi:**
```bash
cd Mesin_Inferensi
pip install -r requirements.txt
```

### Error: "Connection refused" (FastAPI)
**Solusi:**
Pastikan FastAPI jalan di terminal 2:
```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

### Error: "Permission denied" (Linux/Mac)
**Solusi:**
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📝 CHECKLIST SETUP

- [ ] Git pull berhasil
- [ ] `composer install` berhasil
- [ ] `pip install -r requirements.txt` berhasil
- [ ] File `.env` sudah dibuat dan dikonfigurasi
- [ ] Database `proyek_sispak` sudah dibuat
- [ ] Migration berhasil (6 migration)
- [ ] Seeder berhasil (gejala, penyakit, rules, admin)
- [ ] Laravel server jalan di port 8000
- [ ] FastAPI server jalan di port 8001
- [ ] Bisa buka http://127.0.0.1:8000 (login page)
- [ ] Bisa buka http://127.0.0.1:8001/docs (Swagger UI)
- [ ] Bisa login sebagai user
- [ ] Bisa login sebagai admin (username: admin, password: admin123)
- [ ] Bisa diagnosa dan lihat hasil
- [ ] Admin bisa CRUD gejala, penyakit, rules

---

## 🎯 AKUN DEFAULT

### Admin
- **Username:** `admin`
- **Password:** `admin123`
- **Akses:** Dashboard admin, CRUD semua data

### User
- Daftar sendiri melalui halaman register
- **Akses:** Diagnosa, riwayat

---

## 💾 FILE YANG TIDAK DI-PUSH (GITIGNORE)

File berikut tidak di-push ke Git (ada di `.gitignore`):
- `/vendor/` (install ulang dengan `composer install`)
- `/node_modules/`
- `.env` (copy dari `.env.example`)
- `/storage/*.key`
- `/public/storage`

---

## 🔄 UPDATE DARI GIT

Jika ada update dari teman:
```bash
# Pull update
git pull origin main

# Update dependencies (jika ada perubahan)
composer install
pip install -r Mesin_Inferensi/requirements.txt

# Jalankan migration baru (jika ada)
php artisan migrate

# Jalankan seeder baru (jika ada)
php artisan db:seed --class=NamaSeederBaru
```

---

## 📞 KONTAK

Jika ada masalah saat setup, hubungi:
- **Developer:** [Nama Kamu]
- **WhatsApp:** [Nomor Kamu]

---

## 📚 DOKUMENTASI LENGKAP

Baca dokumentasi lainnya:
- `README.md` - Overview project
- `START.md` - Cara menjalankan (simple)
- `PANDUAN_LENGKAP.md` - Panduan instalasi detail
- `PANDUAN_ADMIN.md` - Cara menggunakan admin panel
- `DATABASE_STRUCTURE.md` - Struktur database
- `INTEGRASI_LARAVEL_PYTHON.md` - Cara kerja integrasi

---

**SELAMAT CODING! 🚀**

Jika setup berhasil, kamu sudah bisa:
1. ✅ Login sebagai user
2. ✅ Diagnosa penyakit lambung
3. ✅ Lihat riwayat
4. ✅ Login sebagai admin
5. ✅ Kelola gejala, penyakit, dan rules
