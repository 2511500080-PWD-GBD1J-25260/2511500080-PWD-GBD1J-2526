<?php
/**
 * proses_delete_biodata.php
 * ==========================
 * File untuk memproses DELETE data biodata pengunjung
 * - Menerima bid dari GET parameter
 * - Validasi bid
 * - Delete dari tabel tbl_biodata
 * - Redirect ke read_biodata.php dengan status sukses/gagal
 * 
 * Catatan: Konfirmasi penghapusan dilakukan via JavaScript
 * pada link delete di read_biodata.php
 */

session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

# Validasi bid wajib angka dan > 0
$bid = filter_input(INPUT_GET, 'bid', FILTER_VALIDATE_INT, [
  'options' => ['min_range' => 1]
]);

if (!$bid) {
  $_SESSION['flash_error_imoet'] = 'ID imoet tidak valid.';
  redirect_ke('read_imoet.php');
}

/**
 * Prepared statement untuk anti SQL injection
 * Query DELETE dengan WHERE bid = ?
 */
$stmt = mysqli_prepare($conn, "DELETE FROM tbl_imoet WHERE bid = ?");

if (!$stmt) {
  # Jika gagal prepare, kirim pesan error
  $_SESSION['flash_error_imoet'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('read_imoet.php');
}

# Bind parameter dan eksekusi (i = integer)
mysqli_stmt_bind_param($stmt, "i", $bid);

if (mysqli_stmt_execute($stmt)) {
  # Jika berhasil, redirect dengan pesan sukses
  $_SESSION['flash_sukses_imoet'] = 'Biodata berhasil dihapus.';
} else {
  # Jika gagal, tampilkan error
  $_SESSION['flash_error_imoet'] = 'Data gagal dihapus. Silakan coba lagi.';
}

# Tutup statement
mysqli_stmt_close($stmt);

# Redirect ke halaman pembaca (PRG pattern)
redirect_ke('read_imoet.php');
