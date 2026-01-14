<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

#cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#contact');
}

#Deteksi form mana yang disubmit berdasarkan field yang ada
$isBiodataForm = isset($_POST['txtNim']);
$isContactForm = isset($_POST['txtNama']);

/*
  ========================================
  PROSES FORM BIODATA MAHASISWA
  ========================================
*/
if ($isBiodataForm) {
  #ambil dan bersihkan nilai dari form biodata
  $nim = bersihkan($_POST['txtNim'] ?? '');
  $nama_lengkap = bersihkan($_POST['txtNmLengkap'] ?? '');
  $tempat_lahir = bersihkan($_POST['txtT4Lhr'] ?? '');
  $tanggal_lahir = bersihkan($_POST['txtTglLhr'] ?? '');
  $hobi = bersihkan($_POST['txtHobi'] ?? '');
  $pasangan = bersihkan($_POST['txtPasangan'] ?? '');
  $pekerjaan = bersihkan($_POST['txtKerja'] ?? '');
  $nama_ortu = bersihkan($_POST['txtNmOrtu'] ?? '');
  $nama_kakak = bersihkan($_POST['txtNmKakak'] ?? '');
  $nama_adik = bersihkan($_POST['txtNmAdik'] ?? '');

  #Validasi sederhana untuk biodata
  $errors = [];

  if ($nim === '') {
    $errors[] = 'NIM wajib diisi.';
  }
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

  if (mb_strlen($nim) < 5) {
    $errors[] = 'NIM minimal 5 karakter.';
  }
  if (mb_strlen($nama_lengkap) < 3) {
    $errors[] = 'Nama Lengkap minimal 3 karakter.';
  }

  #Jika ada error, simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  if (!empty($errors)) {
    $_SESSION['old_biodata'] = [
      'nim' => $nim,
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

    $_SESSION['flash_error_biodata'] = implode('<br>', $errors);
    redirect_ke('index.php#biodata');
  }

  #menyiapkan query INSERT dengan prepared statement untuk tbl_mahasiswa
  $sql = "INSERT INTO tbl_mahasiswa (nim, cnama_lengkap, ctempat_lahir, dtanggal_lahir, chobi, cpasangan, cpekerjaan, cnama_ortu, cnama_kakak, cnama_adik) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    #jika gagal prepare, kirim pesan error ke pengguna
    $_SESSION['flash_error_biodata'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('index.php#biodata');
  }

  #bind parameter dan eksekusi (s = string)
  mysqli_stmt_bind_param($stmt, "ssssssssss", $nim, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $hobi, $pasangan, $pekerjaan, $nama_ortu, $nama_kakak, $nama_adik);

  if (mysqli_stmt_execute($stmt)) {
    #jika berhasil, kosongkan old value, beri pesan sukses
    unset($_SESSION['old_biodata']);
    $_SESSION['flash_sukses_biodata'] = 'Terima kasih, biodata Anda sudah tersimpan.';
    
    #Simpan juga ke session biodata untuk ditampilkan di section about
    $arrBiodata = [
      "nim" => $nim,
      "nama" => $nama_lengkap,
      "tempat" => $tempat_lahir,
      "tanggal" => $tanggal_lahir,
      "hobi" => $hobi,
      "pasangan" => $pasangan,
      "pekerjaan" => $pekerjaan,
      "ortu" => $nama_ortu,
      "kakak" => $nama_kakak,
      "adik" => $nama_adik
    ];
    $_SESSION["biodata"] = $arrBiodata;
    
    redirect_ke('index.php#biodata');
  } else {
    #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old_biodata'] = [
      'nim' => $nim,
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
    $_SESSION['flash_error_biodata'] = 'Data gagal disimpan. Silakan coba lagi.';
    redirect_ke('index.php#biodata');
  }
  #tutup statement
  mysqli_stmt_close($stmt);
}

/*
  ========================================
  PROSES FORM KONTAK (TAMU)
  ========================================
*/
if ($isContactForm) {
  #ambil dan bersihkan nilai dari form
  $nama  = bersihkan($_POST['txtNama']  ?? '');
  $email = bersihkan($_POST['txtEmail'] ?? '');
  $pesan = bersihkan($_POST['txtPesan'] ?? '');
  $captcha = bersihkan($_POST['txtCaptcha'] ?? '');

  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada

  if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
  }

  if ($email === '') {
    $errors[] = 'Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format e-mail tidak valid.';
  }

  if ($pesan === '') {
    $errors[] = 'Pesan wajib diisi.';
  }

  if ($captcha === '') {
    $errors[] = 'Pertanyaan wajib diisi.';
  }

  if (mb_strlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
  }

  if (mb_strlen($pesan) < 10) {
    $errors[] = 'Pesan minimal 10 karakter.';
  }

  if ($captcha!=="5") {
    $errors[] = 'Jawaban '. $captcha.' captcha salah.';
  }

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['old'] = [
      'nama'  => $nama,
      'email' => $email,
      'pesan' => $pesan,
      'captcha' => $captcha,
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('index.php#contact');
  }

  #menyiapkan query INSERT dengan prepared statement
  $sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('index.php#contact');
  }
  #bind parameter dan eksekusi (s = string)
  mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
    redirect_ke('index.php#contact'); #pola PRG: kembali ke form / halaman home
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old'] = [
      'nama'  => $nama,
      'email' => $email,
      'pesan' => $pesan,
      'captcha' => $captcha,
    ];
    $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
    redirect_ke('index.php#contact');
  }
  #tutup statement
  mysqli_stmt_close($stmt);
}
