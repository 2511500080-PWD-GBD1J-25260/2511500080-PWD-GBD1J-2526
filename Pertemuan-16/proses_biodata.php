<?php
/**
 * proses_biodata.php
 * ==================
 * File untuk memproses CREATE (insert) data biodata pengunjung
 * - Menerima data dari form #biodata via POST
 * - Validasi dan sanitasi input
 * - Insert ke tabel tbl_biodata
 * - Implementasi pola PRG (Post-Redirect-Get)
 */

session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

# Cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#biodata');
}

# Ambil dan bersihkan (sanitasi) nilai dari form biodata
$nim      = bersihkan($_POST['txtNim'] ?? '');
$nama     = bersihkan($_POST['txtNmLengkap'] ?? '');
$tempat   = bersihkan($_POST['txtT4Lhr'] ?? '');
$tanggal  = bersihkan($_POST['txtTglLhr'] ?? '');
$hobi     = bersihkan($_POST['txtHobi'] ?? '');
$pasangan = bersihkan($_POST['txtPasangan'] ?? '');
$kerja    = bersihkan($_POST['txtKerja'] ?? '');
$ortu     = bersihkan($_POST['txtNmOrtu'] ?? '');
$kakak    = bersihkan($_POST['txtNmKakak'] ?? '');
$adik     = bersihkan($_POST['txtNmAdik'] ?? '');

# Validasi sederhana
$errors = []; # Array untuk menampung semua error

if ($nim === '') {
  $errors[] = 'NIM wajib diisi.';
} elseif (!ctype_digit($nim)) {
  $errors[] = 'NIM harus berupa angka.';
} elseif (mb_strlen($nim) < 5) {
  $errors[] = 'NIM minimal 5 karakter.';
}

if ($nama === '') {
  $errors[] = 'Nama Lengkap wajib diisi.';
} elseif (mb_strlen($nama) < 3) {
  $errors[] = 'Nama minimal 3 karakter.';
}

if ($tempat === '') {
  $errors[] = 'Tempat Lahir wajib diisi.';
}

if ($tanggal === '') {
  $errors[] = 'Tanggal Lahir wajib diisi.';
}

if ($hobi === '') {
  $errors[] = 'Hobi wajib diisi.';
}

if ($pasangan === '') {
  $errors[] = 'Pasangan wajib diisi.';
}

if ($kerja === '') {
  $errors[] = 'Pekerjaan wajib diisi.';
}

if ($ortu === '') {
  $errors[] = 'Nama Orang Tua wajib diisi.';
}

if ($kakak === '') {
  $errors[] = 'Nama Kakak wajib diisi.';
}

if ($adik === '') {
  $errors[] = 'Nama Adik wajib diisi.';
}

# Jika ada error, simpan nilai lama dan pesan error, lalu redirect (PRG)
if (!empty($errors)) {
  $_SESSION['old_biodata'] = [
    'nim'      => $nim,
    'nama'     => $nama,
    'tempat'   => $tempat,
    'tanggal'  => $tanggal,
    'hobi'     => $hobi,
    'pasangan' => $pasangan,
    'kerja'    => $kerja,
    'ortu'     => $ortu,
    'kakak'    => $kakak,
    'adik'     => $adik,
  ];

  $_SESSION['flash_error_biodata'] = implode('<br>', $errors);
  redirect_ke('index.php#biodata');
}

# Menyiapkan query INSERT dengan prepared statement (anti SQL injection)
$sql = "INSERT INTO tbl_biodata 
        (bnim, bnama, btempat_lahir, btgl_lahir, bhobi, bpasangan, bpekerjaan, bortu, bkakak, badik) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  # Jika gagal prepare, kirim pesan error ke pengguna
  $_SESSION['flash_error_biodata'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#biodata');
}

# Bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, "ssssssssss", 
  $nim, $nama, $tempat, $tanggal, $hobi, $pasangan, $kerja, $ortu, $kakak, $adik
);

if (mysqli_stmt_execute($stmt)) {
  # Jika berhasil, kosongkan old value dan beri pesan sukses
  unset($_SESSION['old_biodata']);
  $_SESSION['flash_sukses_biodata'] = 'Terima kasih, biodata Anda sudah tersimpan.';
  redirect_ke('read_biodata.php'); # PRG: redirect ke halaman pembaca
} else {
  # Jika gagal, simpan kembali old value dan tampilkan error
  $_SESSION['old_biodata'] = [
    'nim'      => $nim,
    'nama'     => $nama,
    'tempat'   => $tempat,
    'tanggal'  => $tanggal,
    'hobi'     => $hobi,
    'pasangan' => $pasangan,
    'kerja'    => $kerja,
    'ortu'     => $ortu,
    'kakak'    => $kakak,
    'adik'     => $adik,
  ];
  $_SESSION['flash_error_biodata'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#biodata');
}

# Tutup statement
mysqli_stmt_close($stmt);
