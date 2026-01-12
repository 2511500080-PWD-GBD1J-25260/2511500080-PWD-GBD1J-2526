/**
 * Database Schema untuk Aplikasi CRUD Biodata Mahasiswa
 * Tabel: tbl_biodata_mahasiswa
 * Primary Key: nim (VARCHAR)
 */

-- Membuat tabel biodata mahasiswa
CREATE TABLE IF NOT EXISTS tbl_biodata_mahasiswa (
  nim VARCHAR(20) PRIMARY KEY,
  nama_lengkap VARCHAR(100) NOT NULL,
  tempat_lahir VARCHAR(50) NOT NULL,
  tanggal_lahir VARCHAR(20) NOT NULL,
  hobi VARCHAR(100) NOT NULL,
  pasangan VARCHAR(100) NOT NULL,
  pekerjaan VARCHAR(100) NOT NULL,
  nama_ortu VARCHAR(100) NOT NULL,
  nama_kakak VARCHAR(100) NOT NULL,
  nama_adik VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
