<?php
session_start();

require 'fungsi.php';
require 'koneksi.php';

// validasi method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#contact');
}

// ambil & bersihkan input
$nama = bersihkan($_POST['txtNama'] ?? '');
$email = bersihkan($_POST['txtEmail'] ?? '');
$pesan = bersihkan($_POST['txtPesan'] ?? '');
$captcha = bersihkan($_POST['captcha'] ?? '');

$errors = [];

// validasi wajib isi
if ($nama === '') {
  $errors[] = 'Nama wajib diisi.';
} elseif (strlen($nama) < 3) {
  $errors[] = 'Nama minimal 3 karakter.';
}

if ($email === '') {
  $errors[] = 'Email wajib diisi.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Format e-mail tidak valid.';
}

if ($pesan === '') {
  $errors[] = 'Pesan wajib diisi.';
} elseif (strlen($pesan) < 10) {
  $errors[] = 'Pesan minimal 10 karakter.';
}

// validasi captcha sederhana
if ($captcha !== '5') {
  $errors[] = 'Captcha salah.';
}

// jika ada error
if (!empty($errors)) {
  $_SESSION['old'] = [
    'nama' => $nama,
    'email' => $email,
    'pesan' => $pesan,
  ];
  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#contact');
}

// insert database (prepared statement)
$sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#contact');
}

mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

if (mysqli_stmt_execute($stmt)) {
  unset($_SESSION['old']);
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
} else {
  $_SESSION['old'] = [
    'nama' => $nama,
    'email' => $email,
    'pesan' => $pesan,
  ];
  $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
}

mysqli_stmt_close($stmt);
redirect_ke('index.php#contact');
