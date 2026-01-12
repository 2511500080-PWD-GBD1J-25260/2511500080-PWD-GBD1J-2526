<?php
/**
 * File Proses Update Biodata Mahasiswa
 * Memproses data dari form edit biodata mahasiswa
 * dengan validasi, sanitasi, dan prepared statement
 */

session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

// Cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// Validasi NIM wajib ada dan tidak kosong
$nim = bersihkan($_POST['txtNim'] ?? '');

if (empty($nim)) {
    $_SESSION['flash_error'] = 'NIM tidak valid.';
    redirect_ke('read.php');
}

// Ambil dan bersihkan (sanitasi) nilai dari form
$nama = bersihkan($_POST['txtNmLengkap'] ?? '');
$tempat = bersihkan($_POST['txtT4Lhr'] ?? '');
$tanggal = bersihkan($_POST['txtTglLhr'] ?? '');
$hobi = bersihkan($_POST['txtHobi'] ?? '');
$pasangan = bersihkan($_POST['txtPasangan'] ?? '');
$pekerjaan = bersihkan($_POST['txtKerja'] ?? '');
$ortu = bersihkan($_POST['txtNmOrtu'] ?? '');
$kakak = bersihkan($_POST['txtNmKakak'] ?? '');
$adik = bersihkan($_POST['txtNmAdik'] ?? '');

// Validasi sederhana
$errors = [];

if ($nama === '') {
    $errors[] = 'Nama Lengkap wajib diisi.';
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

if ($pekerjaan === '') {
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

// Validasi panjang minimal
if (mb_strlen($nama) < 3) {
    $errors[] = 'Nama Lengkap minimal 3 karakter.';
}

// Jika ada error, simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
if (!empty($errors)) {
    $_SESSION['old'] = [
        'nama' => $nama,
        'tempat' => $tempat,
        'tanggal' => $tanggal,
        'hobi' => $hobi,
        'pasangan' => $pasangan,
        'pekerjaan' => $pekerjaan,
        'ortu' => $ortu,
        'kakak' => $kakak,
        'adik' => $adik,
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit.php?nim=' . urlencode($nim));
}

// Prepared statement untuk anti SQL injection
$stmt = mysqli_prepare($conn, "UPDATE tbl_biodata_mahasiswa 
                              SET nama_lengkap = ?, tempat_lahir = ?, tanggal_lahir = ?, 
                                  hobi = ?, pasangan = ?, pekerjaan = ?, 
                                  nama_ortu = ?, nama_kakak = ?, nama_adik = ? 
                              WHERE nim = ?");
if (!$stmt) {
    // Jika gagal prepare, kirim pesan error
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit.php?nim=' . urlencode($nim));
}

// Bind parameter dan eksekusi
mysqli_stmt_bind_param($stmt, "ssssssssss", $nama, $tempat, $tanggal, $hobi, $pasangan, $pekerjaan, $ortu, $kakak, $adik, $nim);

if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, kosongkan old value
    unset($_SESSION['old']);
    // Redirect balik ke read.php dan tampilkan info sukses
    $_SESSION['flash_sukses'] = 'Data biodata mahasiswa berhasil diperbaharui.';
    redirect_ke('read.php');
} else {
    // Jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old'] = [
        'nama' => $nama,
        'tempat' => $tempat,
        'tanggal' => $tanggal,
        'hobi' => $hobi,
        'pasangan' => $pasangan,
        'pekerjaan' => $pekerjaan,
        'ortu' => $ortu,
        'kakak' => $kakak,
        'adik' => $adik,
    ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit.php?nim=' . urlencode($nim));
}

// Tutup statement
mysqli_stmt_close($stmt);
