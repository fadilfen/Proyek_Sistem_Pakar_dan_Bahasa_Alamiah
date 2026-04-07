# 🔍 DEBUG STEP BY STEP - Error {"message":"API Sistem Pakar Penyakit Lambung"}

## 🎯 Ikuti Langkah Ini Satu Per Satu

### STEP 1: Pastikan FastAPI Jalan

**Buka Terminal/CMD baru:**
```bash
cd Mesin_Inferensi
uvicorn main:app --reload --port 8001
```

**Harus muncul:**
```
INFO:     Uvicorn running on http://127.0.0.1:8001
INFO:     Application startup complete.
```

✅ **Jangan tutup terminal ini!**

---

### STEP 2: Test API dengan Browser

**Buka browser, akses:**
```
http://127.0.0.1:8001/docs
```

**Harus muncul:** Halaman Swagger UI dengan 2 endpoint

**Test endpoint `/diagnosa`:**
1. Klik `POST /diagnosa`
2. Klik "Try it out"
3. Paste JSON ini:
```json
{
  "gejala": {
    "G01": 1.0,
    "G02": 0.8
  }
}
```
4. Klik "Execute"

**Hasil yang BENAR:**
```json
{
  "hasil_utama": {
    "penyakit": "Tukak Lambung (Ulkus Peptikum)",
    "cf": 0.91
  },
  "top_hasil": [...]
}
```

**Kalau muncul hasil di atas → API Python OK ✅**

---

### STEP 3: Test API dengan PHP Script

**Buka browser:**
```
http://127.0.0.1:8000/test-api.php
```

**Harus muncul:**
- Test 1: Response dari root endpoint
- Test 2: Response dari diagnosa endpoint
- Test 3: Decoded JSON
- Kotak hijau: "✅ API BEKERJA DENGAN BAIK!"

**Kalau muncul kotak hijau → Koneksi Laravel ke Python OK ✅**

---

### STEP 4: Test Form Diagnosa

**Buka:**
```
http://127.0.0.1:8000
```

1. Login (atau daftar akun baru)
2. Pilih **2-3 gejala** (centang checkbox)
3. Klik "Diagnosa Sekarang"

**Yang akan muncul:**
- Halaman dengan data debug (array)
- Lihat isi `all_input`, `gejala`, `nilai`

**Screenshot halaman ini dan kirim ke saya!**

---

### STEP 5: Cek Browser Console

**Buka Developer Tools (F12):**
1. Tab **Console** → Lihat ada error JavaScript?
2. Tab **Network** → Klik request yang muncul saat submit
3. Lihat:
   - Request URL
   - Request Method
   - Request Payload
   - Response

**Screenshot tab Network dan kirim ke saya!**

---

## 🐛 Kemungkinan Masalah

### Masalah 1: Form Tidak Submit ke Controller

**Gejala:** Tidak muncul halaman debug setelah klik "Diagnosa Sekarang"

**Penyebab:** JavaScript error atau form action salah

**Solusi:** Cek browser console (F12 → Console)

---

### Masalah 2: Controller Tidak Kirim ke API Python

**Gejala:** Muncul halaman debug, tapi tidak ada request ke Python

**Penyebab:** Code tidak sampai ke bagian HTTP request

**Solusi:** Hapus `dd()` di controller, tambahkan logging

---

### Masalah 3: Request Kirim ke Endpoint Salah

**Gejala:** Response `{"message":"API Sistem Pakar..."}`

**Penyebab:** URL salah atau method salah

**Cek:**
- URL harus: `http://127.0.0.1:8001/diagnosa`
- Method harus: `POST`
- Header harus: `Content-Type: application/json`

---

## 📸 Yang Perlu Di-Screenshot

1. **Terminal FastAPI** → Pastikan ada log request masuk
2. **Browser http://127.0.0.1:8001/docs** → Test endpoint berhasil
3. **Browser http://127.0.0.1:8000/test-api.php** → Kotak hijau muncul
4. **Halaman debug** setelah submit form → Isi array
5. **Browser Console (F12)** → Tab Console & Network

---

## 🔧 Temporary Fix

Kalau masih error, hapus `dd()` di controller dan ganti dengan ini:

```php
public function proses(Request $request)
{
    $gejalaInput = $request->input('gejala', []);
    $nilaiUser = $request->input('nilai', []);

    if (empty($gejalaInput)) {
        return back()->with('error', 'Pilih minimal 1 gejala!');
    }

    $data = [];
    foreach ($gejalaInput as $kode) {
        $data[$kode] = isset($nilaiUser[$kode]) ? (float)$nilaiUser[$kode] : 1.0;
    }

    // Test langsung tanpa validasi
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(10)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('http://127.0.0.1:8001/diagnosa', [
                'gejala' => $data
            ]);

        // Debug response
        if (!$response->successful()) {
            return back()->with('error', 'API Error: ' . $response->status() . ' - ' . $response->body());
        }

        $hasil = $response->json();
        
        // Debug hasil
        if (!isset($hasil['hasil_utama'])) {
            return back()->with('error', 'Response tidak valid: ' . json_encode($hasil));
        }

        return view('hasil', compact('hasil'));
        
    } catch (\Exception $e) {
        return back()->with('error', 'Exception: ' . $e->getMessage());
    }
}
```

---

**Lakukan STEP 1-5 dan screenshot hasilnya!** 📸
