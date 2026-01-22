<?php
/**
 * proses_update_biodata.php
 * ==========================
 * File untuk memproses UPDATE data biodata pengunjung
 * - Menerima data dari form edit_biodata.php via POST
 * - Validasi dan sanitasi input
 * - Update ke tabel tbl_biodata
 * - Implementasi pola PRG (Post-Redirect-Get)
 */

session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

# Cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error_imoet'] = 'Akses tidak valid.';
  redirect_ke('read_imoet.php');
}

# Validasi bid wajib angka dan > 0
$bid = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT, [
  'options' => ['min_range' => 1]
]);

if (!$bid) {
  $_SESSION['flash_error_imoet'] = 'ID Biodata tidak valid.';
  redirect_ke('read_imoet.php');
}

# Ambil dan bersihkan (sanitasi) nilai dari form
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
  redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

/**
 * Prepared statement untuk anti SQL injection
 * Query UPDATE dengan WHERE bid = ?
 */
$stmt = mysqli_prepare($conn, "UPDATE tbl_imoet 
  SET bnim = ?, bnama = ?, btempat_lahir = ?, btgl_lahir = ?, 
      bhobi = ?, bpasangan = ?, bpekerjaan = ?, bortu = ?, bkakak = ?, badik = ?
  WHERE bid = ?");

if (!$stmt) {
  # Jika gagal prepare, kirim pesan error
  $_SESSION['flash_error_imoet'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('edit_imoet.php?bid=' . (int)$bid);
}

# Bind parameter dan eksekusi (s = string, i = integer)
mysqli_stmt_bind_param($stmt, "ssssssssssi", 
  $nim, $nama, $tempat, $tanggal, $hobi, $pasangan, $kerja, $ortu, $kakak, $adik, $bid
);

if (mysqli_stmt_execute($stmt)) {
  # Jika berhasil, kosongkan old value
  unset($_SESSION['old_imoet']);
  # Redirect ke read_biodata.php dengan pesan sukses
  $_SESSION['flash_sukses_biodata'] = 'Terima kasih, biodata Anda sudah diperbaharui.';
  redirect_ke('read_biodata.php'); # PRG: kembali ke halaman pembaca
} else {
  # Jika gagal, simpan kembali old value dan tampilkan error
  $_SESSION['old_imoet'] = [
    'kodepen'      => $kodepen,
    'nama'     => $nama,
    'alamat'   => $alamat,
    'tanggal'  => $tanggal,
    'hobi'     => $hobi,
    's1ta' => $s1ta,
    'pekerjaan'    => $pekerjaan,
    'ortu'     => $ortu,
    'pacar'    => $pacar,
    'mantan'     => $mantan,
  ];
  $_SESSION['flash_error_biodata'] = 'Data gagal diperbaharui. Silakan coba lagi.';
  redirect_ke('edit_biodata.php?bid=' . (int)$bid);
}

# Tutup statement
mysqli_stmt_close($stmt);
