<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #validasi nim wajib string dan tidak kosong
  $nim = $_GET['nim'] ?? '';
  $nim = bersihkan($nim);

  if ($nim === '') {
    $_SESSION['flash_error_mhs'] = 'NIM Tidak Valid.';
    redirect_ke('index.php#biodata');
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query DELETE dengan prepared statement 
    (WAJIB WHERE nim = ?)
  */
  $stmt = mysqli_prepare($conn, "DELETE FROM tbl_mahasiswa
                                WHERE nim = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error_mhs'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('index.php#biodata');
  }

  #bind parameter dan eksekusi (s = string)
  mysqli_stmt_bind_param($stmt, "s", $nim);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, tampilkan pesan sukses
    /*
      Redirect balik ke index.php#biodata dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses_mhs'] = 'Terima kasih, data Anda sudah dihapus.';
  } else { #jika gagal, tampilkan error umum
    $_SESSION['flash_error_mhs'] = 'Data gagal dihapus. Silakan coba lagi.';
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('index.php#biodata');
