<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  /*
    Ambil nilai nim dari GET dan lakukan validasi untuk 
    mengecek nim harus string dan tidak kosong.
  */
  $nim = $_GET['nim'] ?? '';
  $nim = bersihkan($nim);

  /*
    Cek apakah $nim bernilai valid:
    Kalau $nim tidak valid, maka jangan lanjutkan proses, 
    kembalikan pengguna ke halaman awal (index.php#biodata) sembari 
    mengirim penanda error.
  */
  if ($nim === '') {
    $_SESSION['flash_error_mhs'] = 'Akses tidak valid.';
    redirect_ke('index.php#biodata');
  }

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT nim, cnama_lengkap, ctempat_lahir, dtanggal_lahir, chobi, cpasangan, cpekerjaan, cnama_ortu, cnama_kakak, cnama_adik 
                                    FROM tbl_mahasiswa WHERE nim = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error_mhs'] = 'Query tidak benar.';
    redirect_ke('index.php#biodata');
  }

  mysqli_stmt_bind_param($stmt, "s", $nim);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error_mhs'] = 'Record tidak ditemukan.';
    redirect_ke('index.php#biodata');
  }

  #Nilai awal (prefill form)
  $nim_val = $row['nim'] ?? '';
  $nama_lengkap = $row['cnama_lengkap'] ?? '';
  $tempat_lahir = $row['ctempat_lahir'] ?? '';
  $tanggal_lahir = $row['dtanggal_lahir'] ?? '';
  $hobi = $row['chobi'] ?? '';
  $pasangan = $row['cpasangan'] ?? '';
  $pekerjaan = $row['cpekerjaan'] ?? '';
  $nama_ortu = $row['cnama_ortu'] ?? '';
  $nama_kakak = $row['cnama_kakak'] ?? '';
  $nama_adik = $row['cnama_adik'] ?? '';

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error_edit_mhs'] ?? '';
  $old = $_SESSION['old_edit_mhs'] ?? [];
  unset($_SESSION['flash_error_edit_mhs'], $_SESSION['old_edit_mhs']);
  
  if (!empty($old)) {
    $nama_lengkap = $old['nama_lengkap'] ?? $nama_lengkap;
    $tempat_lahir = $old['tempat_lahir'] ?? $tempat_lahir;
    $tanggal_lahir = $old['tanggal_lahir'] ?? $tanggal_lahir;
    $hobi = $old['hobi'] ?? $hobi;
    $pasangan = $old['pasangan'] ?? $pasangan;
    $pekerjaan = $old['pekerjaan'] ?? $pekerjaan;
    $nama_ortu = $old['nama_ortu'] ?? $nama_ortu;
    $nama_kakak = $old['nama_kakak'] ?? $nama_kakak;
    $nama_adik = $old['nama_adik'] ?? $nama_adik;
  }
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>Ini Header</h1>
      <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
        &#9776;
      </button>
      <nav>
        <ul>
          <li><a href="index.php#home">Beranda</a></li>
          <li><a href="index.php#about">Tentang</a></li>
          <li><a href="index.php#biodata">Biodata</a></li>
          <li><a href="index.php#contact">Kontak</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section id="biodata">
        <h2>Edit Biodata Sederhana Mahasiswa</h2>
        <?php if (!empty($flash_error)): ?>
          <div style="padding:10px; margin-bottom:10px; 
            background:#f8d7da; color:#721c24; border-radius:6px;">
            <?= $flash_error; ?>
          </div>
        <?php endif; ?>
        <form action="proses_update_mahasiswa.php" method="POST">

          <input type="hidden" name="nim" value="<?= htmlspecialchars($nim_val); ?>">

          <label for="txtNim"><span>NIM:</span>
            <input type="text" id="txtNim" name="txtNimDisplay" 
              placeholder="NIM" readonly
              value="<?= htmlspecialchars($nim_val); ?>">
          </label>

          <label for="txtNmLengkap"><span>Nama Lengkap:</span>
            <input type="text" id="txtNmLengkap" name="txtNmLengkap" 
              placeholder="Masukkan Nama Lengkap" required autocomplete="name"
              value="<?= htmlspecialchars($nama_lengkap); ?>">
          </label>

          <label for="txtT4Lhr"><span>Tempat Lahir:</span>
            <input type="text" id="txtT4Lhr" name="txtT4Lhr" 
              placeholder="Masukkan Tempat Lahir" required
              value="<?= htmlspecialchars($tempat_lahir); ?>">
          </label>

          <label for="txtTglLhr"><span>Tanggal Lahir:</span>
            <input type="date" id="txtTglLhr" name="txtTglLhr" 
              placeholder="Masukkan Tanggal Lahir" required
              value="<?= htmlspecialchars($tanggal_lahir); ?>">
          </label>

          <label for="txtHobi"><span>Hobi:</span>
            <input type="text" id="txtHobi" name="txtHobi" 
              placeholder="Masukkan Hobi" required
              value="<?= htmlspecialchars($hobi); ?>">
          </label>

          <label for="txtPasangan"><span>Pasangan:</span>
            <input type="text" id="txtPasangan" name="txtPasangan" 
              placeholder="Masukkan Pasangan" required
              value="<?= htmlspecialchars($pasangan); ?>">
          </label>

          <label for="txtKerja"><span>Pekerjaan:</span>
            <input type="text" id="txtKerja" name="txtKerja" 
              placeholder="Masukkan Pekerjaan" required
              value="<?= htmlspecialchars($pekerjaan); ?>">
          </label>

          <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
            <input type="text" id="txtNmOrtu" name="txtNmOrtu" 
              placeholder="Masukkan Nama Orang Tua" required
              value="<?= htmlspecialchars($nama_ortu); ?>">
          </label>

          <label for="txtNmKakak"><span>Nama Kakak:</span>
            <input type="text" id="txtNmKakak" name="txtNmKakak" 
              placeholder="Masukkan Nama Kakak" required
              value="<?= htmlspecialchars($nama_kakak); ?>">
          </label>

          <label for="txtNmAdik"><span>Nama Adik:</span>
            <input type="text" id="txtNmAdik" name="txtNmAdik" 
              placeholder="Masukkan Nama Adik" required
              value="<?= htmlspecialchars($nama_adik); ?>">
          </label>

          <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
          <a href="index.php#biodata" class="reset">Kembali</a>
        </form>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>
