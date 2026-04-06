-- SQL untuk membuat tabel users di database proyek_sispak
-- Jalankan query ini di phpMyAdmin atau MySQL client

-- Hapus tabel jika sudah ada (opsional, hati-hati dengan data yang ada)
-- DROP TABLE IF EXISTS users;

-- Buat tabel users dengan struktur yang sesuai
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    umur INT NOT NULL,
    jenis_kelamin ENUM('Pria', 'Wanita') NOT NULL,
    alamat TEXT NOT NULL,
    no_telepon VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jika tabel sudah ada dan ingin menambahkan kolom yang belum ada:
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS username VARCHAR(255) NOT NULL UNIQUE AFTER id;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS password VARCHAR(255) NOT NULL AFTER username;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS nama_lengkap VARCHAR(255) NOT NULL AFTER password;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS umur INT NOT NULL AFTER nama_lengkap;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS jenis_kelamin ENUM('Pria', 'Wanita') NOT NULL AFTER umur;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS alamat TEXT NOT NULL AFTER jenis_kelamin;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS no_telepon VARCHAR(255) NOT NULL AFTER alamat;
