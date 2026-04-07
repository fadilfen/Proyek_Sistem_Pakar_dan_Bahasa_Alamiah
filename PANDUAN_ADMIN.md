# 🔐 ADMIN PANEL - Panduan Lengkap

## ✅ FITUR YANG SUDAH LENGKAP

### 1. Authentication
- ✅ Login dengan role admin
- ✅ Redirect otomatis ke dashboard admin
- ✅ Proteksi halaman admin

### 2. Dashboard
- ✅ Statistik total gejala
- ✅ Statistik total penyakit
- ✅ Statistik total rules
- ✅ Statistik total users
- ✅ Statistik total konsultasi
- ✅ Quick actions

### 3. CRUD Gejala
- ✅ Lihat daftar gejala
- ✅ Tambah gejala baru
- ✅ Edit gejala
- ✅ Hapus gejala

### 4. CRUD Penyakit
- ✅ Lihat daftar penyakit
- ✅ Tambah penyakit baru (dengan deskripsi & solusi)
- ✅ Edit penyakit
- ✅ Hapus penyakit

### 5. CRUD Rules
- ✅ Lihat daftar rules dengan MB, MD, dan CF
- ✅ Tambah rule baru (pilih penyakit + gejala + MB + MD)
- ✅ Edit rule
- ✅ Hapus rule
- ✅ Validasi duplikasi

---

## 🚀 CARA MENGGUNAKAN

### STEP 1: Jalankan Seeder Admin
```bash
php artisan db:seed --class=UserAdminSeeder
```

### STEP 2: Login sebagai Admin
1. Buka: `http://127.0.0.1:8000`
2. Login dengan:
   - **Username:** `admin`
   - **Password:** `admin123`
3. Otomatis redirect ke `/admin/dashboard`

---

## 📋 KELOLA GEJALA

### Tambah Gejala Baru
1. Klik menu **"🔍 Kelola Gejala"**
2. Klik tombol **"➕ Tambah Gejala"**
3. Isi form:
   - **Kode Gejala:** G11 (format: G + nomor)
   - **Nama Gejala:** Contoh: "Sakit kepala"
4. Klik **"💾 Simpan"**

### Edit Gejala
1. Di daftar gejala, klik **"✏️ Edit"**
2. Ubah data yang diperlukan
3. Klik **"💾 Update"**

### Hapus Gejala
1. Klik **"🗑️ Hapus"**
2. Konfirmasi penghapusan
3. Data terhapus

---

## 🦠 KELOLA PENYAKIT

### Tambah Penyakit Baru
1. Klik menu **"🦠 Kelola Penyakit"**
2. Klik tombol **"➕ Tambah Penyakit"**
3. Isi form:
   - **Kode Penyakit:** P05 (format: P + nomor)
   - **Nama Penyakit:** Contoh: "Kanker Lambung"
   - **Deskripsi:** Penjelasan tentang penyakit
   - **Solusi:** Cara pengobatan dan pencegahan
4. Klik **"💾 Simpan"**

### Edit Penyakit
1. Di daftar penyakit, klik **"✏️ Edit"**
2. Ubah data (deskripsi, solusi, dll)
3. Klik **"💾 Update"**

### Hapus Penyakit
1. Klik **"🗑️ Hapus"**
2. Konfirmasi penghapusan
3. Data terhapus (termasuk rules terkait)

---

## 📋 KELOLA RULES (BASIS PENGETAHUAN)

### Tambah Rule Baru
1. Klik menu **"📋 Kelola Rules"**
2. Klik tombol **"➕ Tambah Rule"**
3. Isi form:
   - **Penyakit:** Pilih dari dropdown (contoh: P01 - Gastritis)
   - **Gejala:** Pilih dari dropdown (contoh: G01 - Nyeri ulu hati)
   - **MB (Measure of Belief):** 0.80 (range: 0.00 - 1.00)
   - **MD (Measure of Disbelief):** 0.10 (range: 0.00 - 1.00)
4. Klik **"💾 Simpan"**

**Contoh Rule:**
```
Penyakit: Gastritis (Maag)
Gejala: Nyeri ulu hati
MB: 0.80 (80% yakin gejala ini menunjukkan gastritis)
MD: 0.10 (10% tidak yakin)
CF: 0.70 (MB - MD = 0.80 - 0.10)
```

### Tips Menentukan MB & MD:

| Tingkat | MB | MD | Keterangan |
|---------|----|----|------------|
| Sangat Kuat | 0.8-1.0 | 0.0-0.1 | Gejala sangat khas untuk penyakit ini |
| Kuat | 0.6-0.7 | 0.1-0.2 | Gejala sering muncul pada penyakit ini |
| Sedang | 0.4-0.5 | 0.2-0.3 | Gejala kadang muncul |
| Lemah | 0.2-0.3 | 0.3-0.4 | Gejala jarang muncul |

### Edit Rule
1. Di daftar rules, klik **"✏️ Edit"**
2. Ubah penyakit, gejala, MB, atau MD
3. Lihat preview CF yang baru
4. Klik **"💾 Update"**

### Hapus Rule
1. Klik **"🗑️ Hapus"**
2. Konfirmasi penghapusan
3. Rule terhapus

---

## 🎯 CONTOH PENGGUNAAN

### Skenario: Menambah Penyakit Baru "Kanker Lambung"

**1. Tambah Penyakit:**
```
Kode: P05
Nama: Kanker Lambung
Deskripsi: Pertumbuhan sel abnormal di lambung yang bersifat ganas
Solusi: Konsultasi dokter segera, kemungkinan perlu operasi dan kemoterapi
```

**2. Tambah Gejala Baru (jika perlu):**
```
Kode: G11
Nama: Muntah darah
```

**3. Tambah Rules:**
```
Rule 1:
- Penyakit: P05 (Kanker Lambung)
- Gejala: G09 (BAB berdarah/hitam)
- MB: 0.90
- MD: 0.05
- CF: 0.85

Rule 2:
- Penyakit: P05 (Kanker Lambung)
- Gejala: G10 (Penurunan berat badan)
- MB: 0.85
- MD: 0.10
- CF: 0.75

Rule 3:
- Penyakit: P05 (Kanker Lambung)
- Gejala: G11 (Muntah darah)
- MB: 0.95
- MD: 0.02
- CF: 0.93
```

---

## ⚠️ VALIDASI & ERROR HANDLING

### Validasi yang Diterapkan:
- ✅ Kode gejala/penyakit harus unik
- ✅ MB & MD harus antara 0.00 - 1.00
- ✅ Tidak boleh ada rule duplikat (kombinasi penyakit + gejala yang sama)
- ✅ Field required harus diisi

### Pesan Error:
- **"Kode sudah digunakan"** → Ganti kode dengan yang lain
- **"Rule untuk kombinasi ini sudah ada"** → Kombinasi penyakit + gejala sudah ada, edit yang lama atau pilih kombinasi lain
- **"Nilai harus antara 0 dan 1"** → MB/MD harus 0.00 - 1.00

---

## 📊 STATISTIK DASHBOARD

Dashboard menampilkan:
- 📊 **Total Gejala:** Jumlah gejala yang tersedia
- 🦠 **Total Penyakit:** Jumlah penyakit yang ada
- 📋 **Total Rules:** Jumlah basis pengetahuan
- 👥 **Total Users:** Jumlah pengguna terdaftar
- 📈 **Total Konsultasi:** Jumlah diagnosa yang dilakukan

---

## 🔒 KEAMANAN

### Proteksi Admin:
```php
// Di AdminController
if (session('role') !== 'admin') {
    abort(403, 'Unauthorized');
}
```

### Logout:
- Klik **"🚪 Logout"** di sidebar atau header
- Session akan dihapus
- Redirect ke halaman login

---

## 💡 TIPS & BEST PRACTICES

1. **Backup Data:** Sebelum hapus data, pastikan tidak digunakan di tempat lain
2. **Konsistensi Kode:** Gunakan format G01, G02 untuk gejala dan P01, P02 untuk penyakit
3. **MB > MD:** Biasanya MB lebih besar dari MD
4. **CF Positif:** Pastikan CF (MB - MD) bernilai positif
5. **Deskripsi Lengkap:** Isi deskripsi dan solusi penyakit dengan lengkap
6. **Test Rules:** Setelah tambah rule, test dengan diagnosa user

---

## 🎓 UNTUK PRESENTASI/DEMO

### Yang Perlu Ditunjukkan:
1. ✅ Login sebagai admin
2. ✅ Dashboard dengan statistik
3. ✅ Tambah gejala baru
4. ✅ Tambah penyakit baru (dengan deskripsi & solusi)
5. ✅ Tambah rule baru (jelaskan MB, MD, CF)
6. ✅ Edit data
7. ✅ Hapus data
8. ✅ Validasi error

### Penjelasan untuk Dosen:
- **MB (Measure of Belief):** Tingkat kepercayaan pakar bahwa gejala menunjukkan penyakit
- **MD (Measure of Disbelief):** Tingkat ketidakpercayaan pakar
- **CF (Certainty Factor):** MB - MD, nilai akhir yang digunakan dalam perhitungan
- **Basis Pengetahuan:** Kumpulan rules yang dibuat oleh pakar

---

## 📝 CHECKLIST SEBELUM DEMO

- [ ] Admin sudah bisa login
- [ ] Dashboard tampil dengan benar
- [ ] CRUD Gejala berfungsi
- [ ] CRUD Penyakit berfungsi
- [ ] CRUD Rules berfungsi
- [ ] Validasi berjalan dengan baik
- [ ] Data sudah lengkap (minimal 10 gejala, 4 penyakit, 20 rules)
- [ ] Test diagnosa user dengan data yang baru ditambahkan

---

**ADMIN PANEL SIAP DIGUNAKAN! 🎉**

Login sebagai admin dan mulai kelola basis pengetahuan sistem pakar!

**Akun Admin:**
- Username: `admin`
- Password: `admin123`
