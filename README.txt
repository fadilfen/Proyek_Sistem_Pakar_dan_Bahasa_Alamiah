# Sistem Pakar Diagnosa Penyakit Lambung

Sistem pakar untuk mendiagnosa penyakit lambung menggunakan metode Certainty Factor (CF).

## Cara Menjalankan

```bash
python app.py
```

Buka browser: `http://127.0.0.1:5000`

## Struktur File

- `app.py` - Flask web server
- `mesin.py` - Mesin inferensi CF (data + algoritma)
- `ui/index.html` - Halaman utama
- `static/css/style.css` - Styling
- `static/logo.png` - Logo (ganti dengan logo Anda)

## Fitur

1. Halaman informasi kelompok (850x320px)
2. Logo di bawah judul (120x120px)
3. Tombol "Mulai Diagnosa" dengan icon 🔍
4. Pertanyaan muncul satu per satu (10 pertanyaan)
5. Langsung tampil 5 pilihan keyakinan:
   - Sangat Tidak Yakin (0.0)
   - Tidak Yakin (0.25)
   - Ragu-ragu (0.5)
   - Yakin (0.75)
   - Sangat Yakin (1.0)
6. Tombol keyakinan berubah biru saat hover
7. Tombol "Lewati Pertanyaan Ini" untuk skip
8. Hasil diagnosa dalam modal (lebih compact)

## Data

- 10 Gejala (G01-G10)
- 4 Penyakit (P01-P04)
- 22 Rules (basis pengetahuan)

Semua data ada di `mesin.py`, tidak menggunakan database.

## Cara Edit

1. Informasi Kelompok: Buka `ui/index.html`, cari komentar
   <!-- ISI DENGAN INFORMASI KELOMPOK ANDA DI SINI -->

2. Logo: Ganti file `static/logo.png` dengan logo Anda
   (Ukuran rekomendasi: 120x120px atau rasio 1:1)

## Desain

- Background: Gradient biru-putih animasi
- Border info: 850x320px
- Border pertanyaan: 850x380px
- Modal hasil: 700px max-width (compact)
- Tombol: Putih → Biru saat hover
