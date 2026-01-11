<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  /* LOGIKA 1: PENGHAPUSAN MAHASISWA (NIM)
    Jika terdapat parameter 'nim' di URL
  */
  if (isset($_GET['nim'])) {
    $nim = bersihkan($_GET['nim']);

    if (empty($nim)) {
        $_SESSION['flash_error'] = 'NIM tidak valid.';
        redirect_ke('read_mahasigma.php');
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM mahasiswa WHERE nim = ?");
    mysqli_stmt_bind_param($stmt, "s", $nim);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_sukses1'] = 'Data mahasiswa berhasil dihapus.';
    } else {
        $_SESSION['flash_error1'] = 'Gagal menghapus data mahasiswa.';
    }

    mysqli_stmt_close($stmt);
    redirect_ke('read_mahasigma.php');
  }

  /* LOGIKA 2: PENGHAPUSAN BUKU TAMU (CID)
    Jika terdapat parameter 'cid' di URL
  */
  if (isset($_GET['cid'])) {
    $cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, [
      'options' => ['min_range' => 1]
    ]);

    if (!$cid) {
      $_SESSION['flash_error1'] = 'ID Tamu tidak valid.';
      redirect_ke('read.php'); // Asumsi read.php adalah halaman buku tamu
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM tbl_tamu WHERE cid = ?");
    mysqli_stmt_bind_param($stmt, "i", $cid);

    if (mysqli_stmt_execute($stmt)) {
      $_SESSION['flash_sukses'] = 'Data tamu berhasil dihapus.';
    } else {
      $_SESSION['flash_error'] = 'Gagal menghapus data tamu.';
    }

    mysqli_stmt_close($stmt);
    redirect_ke('read.php');
  }

  // Jika tidak ada parameter nim atau cid, kembalikan ke halaman awal
  redirect_ke('index.php');
?>