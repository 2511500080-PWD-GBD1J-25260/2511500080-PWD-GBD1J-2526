<?php
/**
 * edit_biodata.php
 * =================
 * File untuk menampilkan form edit biodata pengunjung (UPDATE)
 * - Mengambil data berdasarkan bid dari GET parameter
 * - Input bid bersifat readonly (tidak bisa diubah)
 * - Pre-fill form dengan data dari database
 * - Tombol Kirim dan Batal seperti di section #contact
 */

session_start();
require 'koneksi.php';
require 'fungsi.php';

/**
 * Validasi bid dari GET parameter
 * - Harus angka dan lebih besar dari 0
 * - Menggunakan filter_input untuk keamanan
 */
$bid = filter_input(INPUT_GET, 'bid', FILTER_VALIDATE_INT, [
  'options' => ['min_range' => 1]
]);

# Jika bid tidak valid, redirect ke halaman pembaca
if (!$bid) {
  $_SESSION['flash_error_biodata'] = 'Akses tidak valid.';
  redirect_ke('read_biodata.php');
}

/**
 * Ambil data dari database menggunakan prepared statement
 */
$stmt = mysqli_prepare($conn, "SELECT * FROM tbl_biodata WHERE bid = ? LIMIT 1");
if (!$stmt) {
  $_SESSION['flash_error_biodata'] = 'Query tidak benar.';
  redirect_ke('read_biodata.php');
}

mysqli_stmt_bind_param($stmt, "i", $bid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

# Jika data tidak ditemukan
if (!$row) {
  $_SESSION['flash_error_biodata'] = 'Record tidak ditemukan.';
  redirect_ke('read_biodata.php');
}

# Nilai awal dari database (prefill form)
$nim      = $row['bnim'] ?? '';
$nama     = $row['bnama'] ?? '';
$tempat   = $row['btempat_lahir'] ?? '';
$tanggal  = $row['btgl_lahir'] ?? '';
$hobi     = $row['bhobi'] ?? '';
$pasangan = $row['bpasangan'] ?? '';
$kerja    = $row['bpekerjaan'] ?? '';
$ortu     = $row['bortu'] ?? '';
$kakak    = $row['bkakak'] ?? '';
$adik     = $row['badik'] ?? '';

# Ambil error dan nilai old input jika ada (dari validasi gagal)
$flash_error = $_SESSION['flash_error_biodata'] ?? '';
$old = $_SESSION['old_biodata'] ?? [];
unset($_SESSION['flash_error_biodata'], $_SESSION['old_biodata']);

# Jika ada old value, gunakan untuk prefill
if (!empty($old)) {
  $nim      = $old['nim'] ?? $nim;
  $nama     = $old['nama'] ?? $nama;
  $tempat   = $old['tempat'] ?? $tempat;
  $tanggal  = $old['tanggal'] ?? $tanggal;
  $hobi     = $old['hobi'] ?? $hobi;
  $pasangan = $old['pasangan'] ?? $pasangan;
  $kerja    = $old['kerja'] ?? $kerja;
  $ortu     = $old['ortu'] ?? $ortu;
  $kakak    = $old['kakak'] ?? $kakak;
  $adik     = $old['adik'] ?? $adik;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Biodata Pengunjung</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Input readonly styling */
    input[readonly] {
      background-color: #e9ecef;
      cursor: not-allowed;
    }

    .reset {
      display: inline-block;
      padding: 10px 24px;
      font-size: 16px;
      border-radius: 6px;
      text-decoration: none;
      background-color: #6c757d;
      color: #fff;
      margin-left: 8px;
    }

    .reset:hover {
      background-color: #545b62;
    }
  </style>
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
        <li><a href="index.php#contact">Kontak</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="biodata">
      <h2>Edit Biodata Pengunjung</h2>

      <!-- Tampilkan flash message error -->
      <?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
      <?php endif; ?>

      <!-- Form edit biodata, action ke proses_update_biodata.php -->
      <form action="proses_update_biodata.php" method="POST">

        <!-- Input bid: readonly, tidak bisa diubah oleh pengguna -->
        <label for="txtBid"><span>ID Biodata:</span>
          <input type="text" id="txtBid" name="bid" 
            value="<?= (int)$bid; ?>" readonly>
        </label>

        <label for="txtNim"><span>NIM:</span>
          <input type="text" id="txtNim" name="txtNim" 
            placeholder="Masukkan NIM" required
            value="<?= htmlspecialchars($nim); ?>">
        </label>

        <label for="txtNmLengkap"><span>Nama Lengkap:</span>
          <input type="text" id="txtNmLengkap" name="txtNmLengkap" 
            placeholder="Masukkan Nama Lengkap" required
            value="<?= htmlspecialchars($nama); ?>">
        </label>

        <label for="txtT4Lhr"><span>Tempat Lahir:</span>
          <input type="text" id="txtT4Lhr" name="txtT4Lhr" 
            placeholder="Masukkan Tempat Lahir" required
            value="<?= htmlspecialchars($tempat); ?>">
        </label>

        <label for="txtTglLhr"><span>Tanggal Lahir:</span>
          <input type="text" id="txtTglLhr" name="txtTglLhr" 
            placeholder="Masukkan Tanggal Lahir" required
            value="<?= htmlspecialchars($tanggal); ?>">
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
            value="<?= htmlspecialchars($kerja); ?>">
        </label>

        <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
          <input type="text" id="txtNmOrtu" name="txtNmOrtu" 
            placeholder="Masukkan Nama Orang Tua" required
            value="<?= htmlspecialchars($ortu); ?>">
        </label>

        <label for="txtNmKakak"><span>Nama Kakak:</span>
          <input type="text" id="txtNmKakak" name="txtNmKakak" 
            placeholder="Masukkan Nama Kakak" required
            value="<?= htmlspecialchars($kakak); ?>">
        </label>

        <label for="txtNmAdik"><span>Nama Adik:</span>
          <input type="text" id="txtNmAdik" name="txtNmAdik" 
            placeholder="Masukkan Nama Adik" required
            value="<?= htmlspecialchars($adik); ?>">
        </label>

        <!-- Tombol Kirim dan Batal seperti di section #contact -->
        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
        <a href="read_biodata.php" class="reset">Kembali</a>
      </form>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>
