# 📊 Struktur Database - Sistem Pakar Penyakit Lambung

## 🗄️ Tabel-Tabel

### 1. Tabel `gejala`
Menyimpan data gejala penyakit lambung

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_gejala` | BIGINT (PK) | ID auto increment |
| `kode_gejala` | VARCHAR(10) UNIQUE | Kode gejala (G01, G02, ...) |
| `nama_gejala` | VARCHAR(255) | Nama gejala |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Contoh Data:**
```
id  | kode  | nama
----|-------|---------------------------
1   | G01   | Nyeri ulu hati
2   | G02   | Mual
3   | G03   | Muntah
```

---

### 2. Tabel `penyakit`
Menyimpan data penyakit lambung

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_penyakit` | BIGINT (PK) | ID auto increment |
| `kode_penyakit` | VARCHAR(10) UNIQUE | Kode penyakit (P01, P02, ...) |
| `nama_penyakit` | VARCHAR(255) | Nama penyakit |
| `deskripsi` | TEXT | Deskripsi penyakit |
| `solusi` | TEXT | Solusi/pengobatan |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Contoh Data:**
```
id  | kode  | nama              | deskripsi           | solusi
----|-------|-------------------|---------------------|------------------
1   | P01   | Gastritis         | Peradangan lambung  | Minum obat maag
2   | P02   | GERD              | Asam lambung naik   | Hindari makanan asam
```

---

### 3. Tabel `rules` ⭐ (INTI SISTEM PAKAR)
Menyimpan aturan hubungan gejala-penyakit dengan nilai MB dan MD

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_rule` | BIGINT (PK) | ID auto increment |
| `id_penyakit` | BIGINT (FK) | Foreign key ke tabel penyakit |
| `id_gejala` | BIGINT (FK) | Foreign key ke tabel gejala |
| `mb` | DECIMAL(3,2) | Measure of Belief (0.00 - 1.00) |
| `md` | DECIMAL(3,2) | Measure of Disbelief (0.00 - 1.00) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Contoh Data:**
```
id  | id_penyakit | id_gejala | mb   | md
----|-------------|-----------|------|------
1   | 1           | 1         | 0.80 | 0.10
2   | 1           | 2         | 0.70 | 0.15
3   | 2           | 1         | 0.60 | 0.20
```

**Penjelasan:**
- `mb` (Measure of Belief) = tingkat kepercayaan gejala menunjukkan penyakit
- `md` (Measure of Disbelief) = tingkat ketidakpercayaan
- **CF = mb - md** (dihitung saat inferensi)

---

### 4. Tabel `konsultasi`
Menyimpan riwayat konsultasi user

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT (PK) | ID auto increment |
| `user_id` | BIGINT (FK) NULLABLE | Foreign key ke tabel users (opsional) |
| `tanggal` | TIMESTAMP | Waktu konsultasi |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

---

### 5. Tabel `konsultasi_detail`
Menyimpan detail gejala yang dipilih user per konsultasi

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT (PK) | ID auto increment |
| `id_konsultasi` | BIGINT (FK) | Foreign key ke tabel konsultasi |
| `id_gejala` | BIGINT (FK) | Foreign key ke tabel gejala |
| `nilai_user` | DECIMAL(3,2) | Tingkat keyakinan user (0.00 - 1.00) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Contoh Data:**
```
id  | id_konsultasi | id_gejala | nilai_user
----|---------------|-----------|------------
1   | 1             | 1         | 0.80
2   | 1             | 2         | 1.00
3   | 1             | 3         | 0.60
```

---

## 🔗 Relasi Antar Tabel

```
users (1) ----< (N) konsultasi
                      |
                      | (1)
                      |
                      v
                    (N) konsultasi_detail >---- (1) gejala
                    
penyakit (1) ----< (N) rules >---- (1) gejala
```

---

## 🎯 Alur Kerja Database

### 1. **Setup Awal (Pakar)**
```sql
-- Insert gejala
INSERT INTO gejala (kode_gejala, nama_gejala) VALUES ('G01', 'Nyeri ulu hati');

-- Insert penyakit
INSERT INTO penyakit (kode_penyakit, nama_penyakit, deskripsi, solusi) 
VALUES ('P01', 'Gastritis', '...', '...');

-- Insert rules (basis pengetahuan)
INSERT INTO rules (id_penyakit, id_gejala, mb, md) VALUES (1, 1, 0.80, 0.10);
```

### 2. **Konsultasi User**
```sql
-- 1. Buat konsultasi baru
INSERT INTO konsultasi (user_id, tanggal) VALUES (1, NOW());

-- 2. Simpan gejala yang dipilih user
INSERT INTO konsultasi_detail (id_konsultasi, id_gejala, nilai_user) 
VALUES (1, 1, 0.80);

-- 3. Ambil rules untuk diagnosa
SELECT r.*, p.nama_penyakit, g.nama_gejala
FROM rules r
JOIN penyakit p ON r.id_penyakit = p.id_penyakit
JOIN gejala g ON r.id_gejala = g.id_gejala
WHERE r.id_gejala IN (1, 2, 3);
```

---

## 📐 Rumus Certainty Factor

### CF Kombinasi (jika ada multiple gejala untuk 1 penyakit):

```
CF(H,E) = MB(H,E) - MD(H,E)

Jika CF1 dan CF2 > 0:
CF_combine = CF1 + CF2 * (1 - CF1)

Jika CF1 dan CF2 < 0:
CF_combine = CF1 + CF2 * (1 + CF1)

Jika CF1 * CF2 < 0:
CF_combine = (CF1 + CF2) / (1 - min(|CF1|, |CF2|))
```

### CF dengan Nilai User:

```
CF_final = CF_pakar * nilai_user

Contoh:
- CF_pakar = 0.80 - 0.10 = 0.70
- nilai_user = 0.80
- CF_final = 0.70 * 0.80 = 0.56
```

---

## 🚀 Query Penting

### Ambil semua gejala untuk form
```sql
SELECT * FROM gejala ORDER BY kode_gejala;
```

### Ambil rules berdasarkan gejala yang dipilih
```sql
SELECT r.*, p.nama_penyakit, p.kode_penyakit
FROM rules r
JOIN penyakit p ON r.id_penyakit = p.id_penyakit
WHERE r.id_gejala IN (1, 2, 3)
ORDER BY p.id_penyakit;
```

### Riwayat konsultasi user
```sql
SELECT k.*, COUNT(kd.id) as jumlah_gejala
FROM konsultasi k
LEFT JOIN konsultasi_detail kd ON k.id = kd.id_konsultasi
WHERE k.user_id = 1
GROUP BY k.id
ORDER BY k.tanggal DESC;
```

---

## ✅ Status Migration

- ✅ `create_gejala_table` - Tabel gejala
- ✅ `create_penyakit_table` - Tabel penyakit
- ✅ `create_rules_table` - Tabel rules (MB & MD)
- ✅ `create_konsultasi_tables` - Tabel konsultasi & detail

---

## 📝 TODO

- [ ] Buat seeder untuk tabel `penyakit`
- [ ] Buat seeder untuk tabel `rules` (basis pengetahuan)
- [ ] Implementasi simpan riwayat konsultasi
- [ ] Buat halaman CRUD untuk pakar (kelola rules)

---

**Database siap digunakan! 🎉**
