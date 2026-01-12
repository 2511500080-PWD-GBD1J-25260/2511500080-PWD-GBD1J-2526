<?php
/**
 * File Proses Delete Biodata Mahasiswa
 * Menghapus data biodata mahasiswa dari database berdasarkan NIM
 */

session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

// Cek apakah ada parameter NIM di URL
if (!isset($_GET['nim'])) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// Ambil dan bersihkan NIM dari GET
$nim = bersihkan($_GET['nim']);

// Validasi NIM tidak boleh kosong
if (empty($nim)) {
    $_SESSION['flash_error'] = 'NIM tidak valid.';
    redirect_ke('read.php');
}

// Prepared statement untuk delete (mencegah SQL injection)
$stmt = mysqli_prepare($conn, "DELETE FROM tbl_biodata_mahasiswa WHERE nim = ?");
if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('read.php');
}

// Bind parameter dan eksekusi
mysqli_stmt_bind_param($stmt, "s", $nim);

// Cek hasil eksekusi
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_sukses'] = 'Data mahasiswa berhasil dihapus.';
} else {
    $_SESSION['flash_error'] = 'Gagal menghapus data mahasiswa.';
}

// Tutup statement dan redirect ke halaman read
mysqli_stmt_close($stmt);
redirect_ke('read.php');
