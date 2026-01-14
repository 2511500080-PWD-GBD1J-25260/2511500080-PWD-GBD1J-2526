<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error_mhs'] = 'Akses tidak valid.';
    redirect_ke('index.php#biodata');
  }

  #validasi nim wajib string dan tidak kosong
  $nim = bersihkan($_POST['nim'] ?? '');

  if ($nim === '') {
    $_SESSION['flash_error_mhs'] = 'NIM Tidak Valid.';
    redirect_ke('index.php#biodata');
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
  $nama_lengkap = bersihkan($_POST['txtNmLengkap'] ?? '');
  $tempat_lahir = bersihkan($_POST['txtT4Lhr'] ?? '');
  $tanggal_lahir = bersihkan($_POST['txtTglLhr'] ?? '');
  $hobi = bersihkan($_POST['txtHobi'] ?? '');
  $pasangan = bersihkan($_POST['txtPasangan'] ?? '');
  $pekerjaan = bersihkan($_POST['txtKerja'] ?? '');
  $nama_ortu = bersihkan($_POST['txtNmOrtu'] ?? '');
  $nama_kakak = bersihkan($_POST['txtNmKakak'] ?? '');
  $nama_adik = bersihkan($_POST['txtNmAdik'] ?? '');

  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada

  if ($nama_lengkap === '') {
    $errors[] = 'Nama Lengkap wajib diisi.';
  }
  if ($tempat_lahir === '') {
    $errors[] = 'Tempat Lahir wajib diisi.';
  }
  if ($tanggal_lahir === '') {
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
  if ($nama_ortu === '') {
    $errors[] = 'Nama Orang Tua wajib diisi.';
  }
  if ($nama_kakak === '') {
    $errors[] = 'Nama Kakak wajib diisi.';
  }
  if ($nama_adik === '') {
    $errors[] = 'Nama Adik wajib diisi.';
  }

  if (mb_strlen($nama_lengkap) < 3) {
    $errors[] = 'Nama Lengkap minimal 3 karakter.';
  }

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['old_edit_mhs'] = [
      'nama_lengkap' => $nama_lengkap,
      'tempat_lahir' => $tempat_lahir,
      'tanggal_lahir' => $tanggal_lahir,
      'hobi' => $hobi,
      'pasangan' => $pasangan,
      'pekerjaan' => $pekerjaan,
      'nama_ortu' => $nama_ortu,
      'nama_kakak' => $nama_kakak,
      'nama_adik' => $nama_adik,
    ];

    $_SESSION['flash_error_edit_mhs'] = implode('<br>', $errors);
    redirect_ke('edit_mahasiswa.php?nim=' . urlencode($nim));
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE nim = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_mahasiswa 
                                SET cnama_lengkap = ?, ctempat_lahir = ?, dtanggal_lahir = ?, chobi = ?, cpasangan = ?, cpekerjaan = ?, cnama_ortu = ?, cnama_kakak = ?, cnama_adik = ? 
                                WHERE nim = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error_edit_mhs'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit_mahasiswa.php?nim=' . urlencode($nim));
  }

  #bind parameter dan eksekusi (s = string)
  mysqli_stmt_bind_param($stmt, "ssssssssss", $nama_lengkap, $tempat_lahir, $tanggal_lahir, $hobi, $pasangan, $pekerjaan, $nama_ortu, $nama_kakak, $nama_adik, $nim);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['old_edit_mhs']);
    /*
      Redirect balik ke index.php#biodata dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses_mhs'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('index.php#biodata'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old_edit_mhs'] = [
      'nama_lengkap' => $nama_lengkap,
      'tempat_lahir' => $tempat_lahir,
      'tanggal_lahir' => $tanggal_lahir,
      'hobi' => $hobi,
      'pasangan' => $pasangan,
      'pekerjaan' => $pekerjaan,
      'nama_ortu' => $nama_ortu,
      'nama_kakak' => $nama_kakak,
      'nama_adik' => $nama_adik,
    ];
    $_SESSION['flash_error_edit_mhs'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit_mahasiswa.php?nim=' . urlencode($nim));
  }
  #tutup statement
  mysqli_stmt_close($stmt);
