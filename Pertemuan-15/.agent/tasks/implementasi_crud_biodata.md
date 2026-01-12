# Implementasi CRUD Biodata Mahasiswa - Pertemuan 15

## Analisis Requirement

Berdasarkan soal tryout UAS PWD, perlu dibuat aplikasi CRUD Biodata Sederhana Mahasiswa dengan ketentuan:

### Poin-poin Pengerjaan:
1. **[10 poin]** Buat tabel database untuk biodata mahasiswa
2. **[5+10 poin]** Form insert dengan validasi, sanitasi, PRG pattern
3. **[10+5 poin]** Tampilan data dengan link edit dan delete
4. **[10 poin]** Form edit dengan NIM readonly, tombol Kirim & Batal
5. **[5+10 poin]** Proses update dengan validasi, sanitasi, PRG pattern
6. **[5 poin]** Tampilan hasil update dengan status sukses/gagal
7. **[5 poin]** Konfirmasi delete dengan JavaScript
8. **[5 poin]** Tampilan hasil delete dengan status sukses/gagal
9. **[5 poin]** Kerapian struktur kode, indentasi, komentar
10. **[15 poin]** Proses commit yang runtut dan jelas

### Referensi:
- Struktur dan pola dari Pertemuan-13 (CRUD buku tamu)
- Form biodata sudah ada di section#biodata pada index.php Pertemuan-13
- Field: NIM, Nama Lengkap, Tempat Lahir, Tanggal Lahir, Hobi, Pasangan, Pekerjaan, Nama Orang Tua, Nama Kakak, Nama Adik

## Planning Implementasi

### Fase 1: Setup Database & Koneksi
- [ ] Buat file `koneksi.php` (copy dari Pertemuan-13)
- [ ] Buat file SQL untuk tabel biodata mahasiswa
- [ ] Buat file `fungsi.php` untuk helper functions

### Fase 2: Halaman Utama & Form Insert
- [ ] Buat `index.php` dengan struktur HTML lengkap
- [ ] Implementasi form biodata di section#biodata
- [ ] Buat `style.css` untuk styling
- [ ] Buat `script.js` untuk interaksi client-side

### Fase 3: Proses Insert
- [ ] Buat `proses_insert.php` dengan:
  - Validasi method POST
  - Sanitasi input
  - Validasi data (tidak kosong, format)
  - Prepared statement untuk INSERT
  - PRG pattern (Post-Redirect-Get)
  - Flash message sukses/error

### Fase 4: Read/Tampilan Data
- [ ] Buat `read.php` untuk menampilkan semua data
- [ ] Tampilkan dalam tabel dengan kolom aksi (Edit & Delete)
- [ ] Implementasi flash message untuk feedback

### Fase 5: Form Edit
- [ ] Buat `edit.php` dengan:
  - Validasi parameter NIM dari GET
  - Query data berdasarkan NIM
  - Form pre-filled dengan data existing
  - NIM field readonly
  - Tombol Kirim & Batal (seperti di section#contact)

### Fase 6: Proses Update
- [ ] Buat `proses_update.php` dengan:
  - Validasi method POST
  - Validasi NIM
  - Sanitasi input
  - Validasi data
  - Prepared statement untuk UPDATE
  - PRG pattern
  - Flash message sukses/error

### Fase 7: Proses Delete
- [ ] Buat `proses_delete.php` dengan:
  - Validasi parameter NIM dari GET
  - Prepared statement untuk DELETE
  - Flash message sukses/error
  - Redirect ke read.php

### Fase 8: JavaScript Confirmation
- [ ] Implementasi confirm dialog untuk delete
- [ ] Character counter untuk textarea (jika ada)
- [ ] Menu toggle untuk responsive

### Fase 9: Polish & Testing
- [ ] Rapikan indentasi semua file
- [ ] Tambahkan komentar yang jelas
- [ ] Test semua fitur CRUD
- [ ] Pastikan validasi berjalan
- [ ] Pastikan PRG pattern bekerja

### Fase 10: Git Workflow
- [ ] Commit setiap fase dengan pesan yang jelas
- [ ] Push secara berkala
- [ ] Dokumentasi proses di commit message

## Struktur File yang Akan Dibuat

```
Pertemuan-15/
├── index.php              # Halaman utama dengan form insert
├── koneksi.php           # Koneksi database
├── fungsi.php            # Helper functions
├── proses_insert.php     # Proses insert data
├── read.php              # Tampilan semua data
├── edit.php              # Form edit data
├── proses_update.php     # Proses update data
├── proses_delete.php     # Proses delete data
├── style.css             # Styling
├── script.js             # JavaScript
└── biodata_mahasiswa.sql # SQL create table
```

## Catatan Penting

1. **Nama tabel dibebaskan** - gunakan nama yang deskriptif
2. **Nama file action dibebaskan** - gunakan nama yang jelas
3. **Name dan ID input dibebaskan** - gunakan konvensi yang konsisten
4. **NIM sebagai Primary Key** - readonly saat edit
5. **Wajib gunakan Prepared Statement** - keamanan SQL injection
6. **Wajib implementasi PRG Pattern** - mencegah double submit
7. **Wajib validasi & sanitasi** - keamanan input
8. **Flash message untuk feedback** - UX yang baik
9. **Commit message harus jelas** - dokumentasi proses
10. **Kode harus rapi** - indentasi, komentar, struktur

## Estimasi Waktu

- Fase 1-2: 20 menit
- Fase 3-4: 30 menit
- Fase 5-6: 30 menit
- Fase 7-8: 20 menit
- Fase 9-10: 20 menit
- **Total: ~2 jam**
