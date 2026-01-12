<?php
/**
 * File Edit Biodata Mahasiswa
 * Menampilkan form untuk mengedit data biodata mahasiswa yang sudah ada
 */

session_start();
require 'koneksi.php';
require 'fungsi.php';

// Ambil nilai NIM dari GET dan lakukan validasi
$nim = bersihkan($_GET['nim'] ?? '');

// Cek apakah NIM valid
if (empty($nim)) {
    $_SESSION['flash_error'] = 'NIM tidak valid.';
    redirect_ke('read.php');
}

// Ambil data dari database menggunakan prepared statement
$stmt = mysqli_prepare($conn, "SELECT * FROM tbl_biodata_mahasiswa WHERE nim = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('read.php');
}

mysqli_stmt_bind_param($stmt, "s", $nim);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

// Cek apakah data ditemukan
if (!$row) {
    $_SESSION['flash_error'] = 'Data mahasiswa tidak ditemukan.';
    redirect_ke('read.php');
}

// Nilai awal (prefill form) dari database
$nama = $row['nama_lengkap'] ?? '';
$tempat = $row['tempat_lahir'] ?? '';
$tanggal = $row['tanggal_lahir'] ?? '';
$hobi = $row['hobi'] ?? '';
$pasangan = $row['pasangan'] ?? '';
$pekerjaan = $row['pekerjaan'] ?? '';
$ortu = $row['nama_ortu'] ?? '';
$kakak = $row['nama_kakak'] ?? '';
$adik = $row['nama_adik'] ?? '';

// Ambil error dan nilai old input kalau ada (dari validasi yang gagal)
$flash_error = $_SESSION['flash_error'] ?? '';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['flash_error'], $_SESSION['old']);

// Jika ada old value, gunakan old value (untuk repopulate form saat error)
if (!empty($old)) {
    $nama = $old['nama'] ?? $nama;
    $tempat = $old['tempat'] ?? $tempat;
    $tanggal = $old['tanggal'] ?? $tanggal;
    $hobi = $old['hobi'] ?? $hobi;
    $pasangan = $old['pasangan'] ?? $pasangan;
    $pekerjaan = $old['pekerjaan'] ?? $pekerjaan;
    $ortu = $old['ortu'] ?? $ortu;
    $kakak = $old['kakak'] ?? $kakak;
    $adik = $old['adik'] ?? $adik;
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
        <h1>Edit Biodata Mahasiswa</h1>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
            &#9776;
        </button>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="read.php">Lihat Data</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="biodata">
            <h2>Edit Biodata Sederhana Mahasiswa</h2>

            <?php if (!empty($flash_error)): ?>
                <div class="alert alert-error">
                    <?= $flash_error; ?>
                </div>
            <?php endif; ?>

            <form action="proses_update.php" method="POST">

                <label for="txtNim"><span>NIM:</span>
                    <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM"
                        value="<?= htmlspecialchars($nim); ?>" readonly>
                </label>

                <label for="txtNmLengkap"><span>Nama Lengkap:</span>
                    <input type="text" id="txtNmLengkap" name="txtNmLengkap" placeholder="Masukkan Nama Lengkap"
                        required value="<?= htmlspecialchars($nama); ?>">
                </label>

                <label for="txtT4Lhr"><span>Tempat Lahir:</span>
                    <input type="text" id="txtT4Lhr" name="txtT4Lhr" placeholder="Masukkan Tempat Lahir" required
                        value="<?= htmlspecialchars($tempat); ?>">
                </label>

                <label for="txtTglLhr"><span>Tanggal Lahir:</span>
                    <input type="text" id="txtTglLhr" name="txtTglLhr" placeholder="Masukkan Tanggal Lahir" required
                        value="<?= htmlspecialchars($tanggal); ?>">
                </label>

                <label for="txtHobi"><span>Hobi:</span>
                    <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required
                        value="<?= htmlspecialchars($hobi); ?>">
                </label>

                <label for="txtPasangan"><span>Pasangan:</span>
                    <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required
                        value="<?= htmlspecialchars($pasangan); ?>">
                </label>

                <label for="txtKerja"><span>Pekerjaan:</span>
                    <input type="text" id="txtKerja" name="txtKerja" placeholder="Masukkan Pekerjaan" required
                        value="<?= htmlspecialchars($pekerjaan); ?>">
                </label>

                <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
                    <input type="text" id="txtNmOrtu" name="txtNmOrtu" placeholder="Masukkan Nama Orang Tua" required
                        value="<?= htmlspecialchars($ortu); ?>">
                </label>

                <label for="txtNmKakak"><span>Nama Kakak:</span>
                    <input type="text" id="txtNmKakak" name="txtNmKakak" placeholder="Masukkan Nama Kakak" required
                        value="<?= htmlspecialchars($kakak); ?>">
                </label>

                <label for="txtNmAdik"><span>Nama Adik:</span>
                    <input type="text" id="txtNmAdik" name="txtNmAdik" placeholder="Masukkan Nama Adik" required
                        value="<?= htmlspecialchars($adik); ?>">
                </label>

                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
                <a href="read.php" class="reset">Kembali</a>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Tryout UAS PWD - CRUD Biodata Mahasiswa</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>