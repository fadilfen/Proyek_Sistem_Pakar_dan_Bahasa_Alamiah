# 🔐 ADMIN PANEL - Dokumentasi

## ✅ Yang Sudah Dibuat

### 1. Database & Authentication
- ✅ Kolom `role` di tabel users (enum: 'pengguna', 'admin')
- ✅ Seeder untuk user admin default
- ✅ Login redirect berdasarkan role

### 2. Controllers
- ✅ `AdminController` - Dashboard
- ✅ `GejalaController` - CRUD Gejala
- ✅ `PenyakitController` - CRUD Penyakit
- ✅ `RulesController` - CRUD Rules (MB & MD)

### 3. Routes
- ✅ `/admin/dashboard` - Dashboard admin
- ✅ `/admin/gejala` - Kelola gejala
- ✅ `/admin/penyakit` - Kelola penyakit
- ✅ `/admin/rules` - Kelola rules

### 4. Views
- ✅ Layout admin dengan sidebar
- ✅ Dashboard dengan statistik
- ✅ CRUD Gejala (index, create, edit)
- ✅ CRUD Penyakit (index)
- ✅ CRUD Rules (index)

### 5. CSS
- ✅ `admin.css` - Styling lengkap untuk admin panel

---

## 🔑 Login Admin

**Username:** `admin`  
**Password:** `admin123`

---

## 📋 Cara Menggunakan

### 1. Jalankan Seeder Admin
```bash
php artisan db:seed --class=UserAdminSeeder
```

### 2. Login sebagai Admin
1. Buka: `http://127.0.0.1:8000`
2. Login dengan username: `admin`, password: `admin123`
3. Otomatis redirect ke `/admin/dashboard`

### 3. Kelola Data

#### Kelola Gejala
- **Lihat:** `/admin/gejala`
- **Tambah:** Klik "➕ Tambah Gejala"
- **Edit:** Klik "✏️ Edit" pada data
- **Hapus:** Klik "🗑️ Hapus" (dengan konfirmasi)

#### Kelola Penyakit
- **Lihat:** `/admin/penyakit`
- **Tambah:** Klik "➕ Tambah Penyakit"
- **Edit:** Klik "✏️ Edit" pada data
- **Hapus:** Klik "🗑️ Hapus" (dengan konfirmasi)

#### Kelola Rules
- **Lihat:** `/admin/rules`
- **Tambah:** Klik "➕ Tambah Rule"
  - Pilih Penyakit
  - Pilih Gejala
  - Input MB (0.00 - 1.00)
  - Input MD (0.00 - 1.00)
- **Edit:** Klik "✏️ Edit" pada data
- **Hapus:** Klik "🗑️ Hapus" (dengan konfirmasi)

---

## 🎨 Fitur Admin Panel

### Dashboard
- 📊 Total Gejala
- 🦠 Total Penyakit
- 📋 Total Rules
- 👥 Total Users
- 📈 Total Konsultasi
- 🚀 Quick Actions (Tambah data cepat)

### Sidebar Menu
- 📊 Dashboard
- 🔍 Kelola Gejala
- 🦠 Kelola Penyakit
- 📋 Kelola Rules
- 🚪 Logout

### Fitur CRUD
- ✅ Create (Tambah data baru)
- ✅ Read (Lihat daftar data)
- ✅ Update (Edit data)
- ✅ Delete (Hapus data dengan konfirmasi)
- ✅ Validasi input
- ✅ Alert success/error
- ✅ Responsive table

---

## 📝 File yang Perlu Dilengkapi

Saya sudah buat struktur dasar. Untuk melengkapi, buat file berikut:

### 1. Penyakit - Create & Edit
```
resources/views/admin/penyakit/create.blade.php
resources/views/admin/penyakit/edit.blade.php
```

### 2. Rules - Index, Create & Edit
```
resources/views/admin/rules/index.blade.php
resources/views/admin/rules/create.blade.php
resources/views/admin/rules/edit.blade.php
```

---

## 🔒 Security

### Middleware Protection
Tambahkan di `AdminController` constructor:
```php
public function __construct()
{
    if (session('role') !== 'admin') {
        abort(403, 'Unauthorized');
    }
}
```

### Validasi Input
- Kode unik (tidak boleh duplikat)
- MB & MD range 0.00 - 1.00
- Required fields

---

## 🎯 Next Steps

1. ✅ Lengkapi views yang tersisa (create/edit penyakit & rules)
2. ✅ Test semua CRUD
3. ✅ Tambahkan fitur search/filter
4. ✅ Export data ke Excel/PDF
5. ✅ Statistik lebih detail (chart)

---

## 💡 Tips

1. **Backup Data:** Sebelum hapus, pastikan data tidak digunakan di rules
2. **Validasi MB & MD:** Pastikan nilai antara 0.00 - 1.00
3. **Kode Unik:** Gunakan format G01, G02 untuk gejala dan P01, P02 untuk penyakit
4. **Testing:** Test CRUD sebelum demo

---

**Admin Panel Siap Digunakan! 🎉**

Login sebagai admin dan mulai kelola basis pengetahuan sistem pakar!
