# 🏥 Sistem Pakar Diagnosa Penyakit Lambung

> Sistem pakar berbasis web untuk mendiagnosa penyakit lambung menggunakan metode Certainty Factor (CF) dengan integrasi Laravel + FastAPI Python

## 🚀 Quick Start

### 1. Setup Database
```bash
php artisan migrate:fresh
php artisan db:seed --class=GejalaSeeder
php artisan db:seed --class=PenyakitSeeder
php artisan db:seed --class=RulesSeeder
```

### 2. Install Python Dependencies
```bash
cd Mesin_Inferensi
pip install -r requirements.txt
```

### 3. Jalankan Aplikasi

**Terminal 1 - Laravel:**
```bash
php artisan serve
# atau double click: start-laravel.bat
```

**Terminal 2 - FastAPI:**
```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
# atau double click: start-fastapi.bat
```

### 4. Akses Aplikasi
- **Web App**: http://127.0.0.1:8000
- **API Docs**: http://127.0.0.1:8001/docs

---

## 📚 Dokumentasi Lengkap

- 📖 [PANDUAN_LENGKAP.md](PANDUAN_LENGKAP.md) - Panduan instalasi & troubleshooting
- 🔗 [INTEGRASI_LARAVEL_PYTHON.md](INTEGRASI_LARAVEL_PYTHON.md) - Cara kerja integrasi
- 🗄️ [DATABASE_STRUCTURE.md](DATABASE_STRUCTURE.md) - Struktur database & query

---

## 🎯 Fitur

- ✅ Login & Register User
- ✅ Form Diagnosa dengan 10 Gejala Penyakit Lambung
- ✅ Slider Tingkat Keyakinan (0.0 - 1.0)
- ✅ Algoritma Certainty Factor (MB & MD)
- ✅ Hasil Diagnosa dengan Visualisasi CF
- ✅ Top 3 Kemungkinan Penyakit
- ✅ Responsive Design

---

## 🛠️ Tech Stack

### Backend
- **Laravel 11** - PHP Framework
- **FastAPI** - Python API Framework
- **MySQL** - Database

### Frontend
- **Blade Template** - Laravel Templating
- **CSS3** - Custom Styling
- **JavaScript** - Interaktivitas

### Algoritma
- **Certainty Factor (CF)** - Metode inferensi
- **MB (Measure of Belief)** - Tingkat kepercayaan
- **MD (Measure of Disbelief)** - Tingkat ketidakpercayaan

---

## 📊 Data

### Gejala (10)
1. Nyeri ulu hati
2. Mual
3. Muntah
4. Perut kembung
5. Cepat kenyang
6. Sendawa berlebihan
7. Nyeri perut setelah makan
8. Heartburn
9. BAB berdarah/hitam
10. Penurunan berat badan

### Penyakit (4)
1. **Gastritis (Maag)** - Peradangan lambung
2. **GERD** - Asam lambung naik
3. **Tukak Lambung** - Luka pada lambung
4. **Dispepsia Fungsional** - Gangguan pencernaan

### Rules (22)
Basis pengetahuan dengan nilai MB dan MD untuk setiap kombinasi gejala-penyakit

---

## 🔬 Algoritma Certainty Factor

### Rumus Dasar
```
CF = MB - MD
```

### CF dengan Nilai User
```
CF_final = CF_pakar × nilai_user
```

### Kombinasi CF (Multiple Gejala)
```
CF_combine = CF1 + CF2 × (1 - CF1)
```

---

## 📸 Screenshots

### Login Page
Halaman login dengan desain modern dan gradient animation

### Dashboard
Menu navigasi dengan card-based design

### Form Diagnosa
Checkbox gejala + slider tingkat keyakinan

### Hasil Diagnosa
Visualisasi CF dengan progress bar dan top 3 hasil

---

## 🤝 Contributing

Proyek ini dibuat untuk tugas Sistem Pakar dan Bahasa Ilmiah.

---

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Developer

Dikembangkan dengan ❤️ menggunakan Laravel & FastAPI

---

**Happy Coding! 🚀**
