# 📤 PANDUAN GIT PUSH & PULL

## 🚀 UNTUK YANG PUSH (Kamu)

### STEP 1: Pastikan File Penting Ada
```bash
# Cek file yang akan di-push
git status
```

File yang HARUS ada:
- ✅ `composer.json` & `composer.lock`
- ✅ `Mesin_Inferensi/requirements.txt`
- ✅ `.env.example` (BUKAN `.env`)
- ✅ `.gitignore`
- ✅ Semua file di `database/migrations/`
- ✅ Semua file di `database/seeders/`
- ✅ Semua file di `app/`
- ✅ Semua file di `resources/views/`
- ✅ Semua file di `public/css/`
- ✅ Semua file di `Mesin_Inferensi/` (kecuali `__pycache__`, `venv/`)
- ✅ File dokumentasi (`.md`)

File yang TIDAK boleh di-push (sudah di `.gitignore`):
- ❌ `/vendor/`
- ❌ `.env`
- ❌ `Mesin_Inferensi/__pycache__/`
- ❌ `Mesin_Inferensi/venv/`

### STEP 2: Add & Commit
```bash
# Add semua file
git add .

# Commit dengan pesan yang jelas
git commit -m "feat: Sistem Pakar Penyakit Lambung dengan Admin Panel"
```

### STEP 3: Push ke Remote
```bash
# Push ke branch main
git push origin main

# Atau jika branch lain
git push origin nama-branch
```

---

## 📥 UNTUK YANG PULL (Teman Kamu)

### STEP 1: Clone Repository
```bash
git clone <url-repository>
cd Proyek_Sistem_Pakar_dan_Bahasa_Ilmiah
```

### STEP 2: Install Dependencies
```bash
# Install Laravel dependencies
composer install

# Install Python dependencies
cd Mesin_Inferensi
pip install -r requirements.txt
cd ..
```

### STEP 3: Setup Environment
```bash
# Copy .env.example ke .env
copy .env.example .env  # Windows
# atau
cp .env.example .env    # Linux/Mac

# Generate app key
php artisan key:generate
```

### STEP 4: Setup Database
```bash
# Buat database di MySQL
# CREATE DATABASE proyek_sispak;

# Jalankan migration
php artisan migrate

# Jalankan seeder
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
php artisan db:seed --class=UserAdminSeeder
```

### STEP 5: Jalankan Aplikasi
```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: FastAPI
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

**Baca dokumentasi lengkap di:** `SETUP_AFTER_PULL.md`

---

## 📋 CHECKLIST SEBELUM PUSH

- [ ] Semua fitur sudah di-test
- [ ] Tidak ada error di console
- [ ] File `.env` tidak ikut ter-push
- [ ] File `vendor/` tidak ikut ter-push
- [ ] File dokumentasi sudah lengkap
- [ ] `composer.json` dan `composer.lock` ada
- [ ] `requirements.txt` ada
- [ ] `.env.example` ada
- [ ] `.gitignore` sudah benar
- [ ] Migration files ada semua
- [ ] Seeder files ada semua

---

## 🔄 UPDATE DARI TEMAN

Jika teman kamu push update:
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

## 📝 COMMIT MESSAGE YANG BAIK

Gunakan format:
```
feat: Tambah fitur admin panel
fix: Perbaiki bug di diagnosa
docs: Update dokumentasi
style: Perbaiki CSS admin
refactor: Refactor DiagnosaController
```

---

## 🎯 FILE PENTING YANG HARUS DI-PUSH

### Laravel
```
/app/
/bootstrap/
/config/
/database/
  /migrations/
  /seeders/
/public/
  /css/
/resources/
  /views/
/routes/
composer.json
composer.lock
.env.example
.gitignore
```

### Python (Mesin_Inferensi)
```
/Mesin_Inferensi/
  main.py
  cf.py
  database.py
  models.py
  requirements.txt
```

### Dokumentasi
```
README.md
START.md
SETUP_AFTER_PULL.md
PANDUAN_LENGKAP.md
PANDUAN_ADMIN.md
DATABASE_STRUCTURE.md
INTEGRASI_LARAVEL_PYTHON.md
```

---

## ⚠️ JANGAN PUSH FILE INI

- ❌ `.env` (kredensial database)
- ❌ `/vendor/` (install ulang dengan composer)
- ❌ `/node_modules/`
- ❌ `Mesin_Inferensi/__pycache__/`
- ❌ `Mesin_Inferensi/venv/`
- ❌ `*.log`
- ❌ `.DS_Store`, `Thumbs.db`

---

## 💡 TIPS

1. **Selalu pull sebelum push:**
   ```bash
   git pull origin main
   git push origin main
   ```

2. **Cek status sebelum commit:**
   ```bash
   git status
   ```

3. **Lihat perubahan:**
   ```bash
   git diff
   ```

4. **Batalkan perubahan:**
   ```bash
   git checkout -- nama-file
   ```

5. **Lihat history:**
   ```bash
   git log --oneline
   ```

---

## 🆘 TROUBLESHOOTING

### Conflict saat pull
```bash
# Lihat file yang conflict
git status

# Edit file, hapus marker conflict (<<<<, ====, >>>>)
# Lalu:
git add .
git commit -m "resolve: Fix merge conflict"
git push origin main
```

### Lupa push file penting
```bash
git add nama-file
git commit -m "fix: Tambah file yang terlupa"
git push origin main
```

### Ingin undo commit terakhir
```bash
# Undo commit tapi keep changes
git reset --soft HEAD~1

# Undo commit dan discard changes
git reset --hard HEAD~1
```

---

**SELAMAT BERKOLABORASI! 🤝**

Jika ada masalah, hubungi developer atau baca dokumentasi lengkap.
