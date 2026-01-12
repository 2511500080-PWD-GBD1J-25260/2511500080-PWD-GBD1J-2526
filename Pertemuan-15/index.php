<?php
/**
 * Halaman Utama - Form Insert Biodata Mahasiswa
 * Menampilkan form untuk menambahkan data biodata mahasiswa baru
 */

session_start();
require_once __DIR__ . '/fungsi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Biodata Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Aplikasi Biodata Mahasiswa</h1>
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
        <section id="home">
            <h2>Selamat Datang</h2>
            <p>Aplikasi CRUD Biodata Sederhana Mahasiswa - Tryout UAS Pemrograman Web Dasar</p>
            <p>Silakan isi form biodata di bawah ini untuk menambahkan data mahasiswa baru.</p>
        </section>

        <?php
        // Ambil flash message dan old value dari session
        $flash_sukses = $_SESSION['flash_sukses'] ?? '';
        $flash_error = $_SESSION['flash_error'] ?? '';
        $old = $_SESSION['old'] ?? [];

        // Hapus session setelah diambil (konsep flash message)
        unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']);
        ?>

        <section id="biodata">
            <h2>Biodata Sederhana Mahasiswa</h2>

            <?php if (!empty($flash_sukses)): ?>
                <div class="alert alert-success">
                    <?= $flash_sukses; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($flash_error)): ?>
                <div class="alert alert-error">
                    <?= $flash_error; ?>
                </div>
            <?php endif; ?>

            <form action="proses_insert.php" method="POST">

                <label for="txtNim"><span>NIM:</span>
                    <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required
                        value="<?= isset($old['nim']) ? htmlspecialchars($old['nim']) : '' ?>">
                </label>

                <label for="txtNmLengkap"><span>Nama Lengkap:</span>
                    <input type="text" id="txtNmLengkap" name="txtNmLengkap" placeholder="Masukkan Nama Lengkap"
                        required value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>">
                </label>

                <label for="txtT4Lhr"><span>Tempat Lahir:</span>
                    <input type="text" id="txtT4Lhr" name="txtT4Lhr" placeholder="Masukkan Tempat Lahir" required
                        value="<?= isset($old['tempat']) ? htmlspecialchars($old['tempat']) : '' ?>">
                </label>

                <label for="txtTglLhr"><span>Tanggal Lahir:</span>
                    <input type="text" id="txtTglLhr" name="txtTglLhr" placeholder="Masukkan Tanggal Lahir" required
                        value="<?= isset($old['tanggal']) ? htmlspecialchars($old['tanggal']) : '' ?>">
                </label>

                <label for="txtHobi"><span>Hobi:</span>
                    <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required
                        value="<?= isset($old['hobi']) ? htmlspecialchars($old['hobi']) : '' ?>">
                </label>

                <label for="txtPasangan"><span>Pasangan:</span>
                    <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required
                        value="<?= isset($old['pasangan']) ? htmlspecialchars($old['pasangan']) : '' ?>">
                </label>

                <label for="txtKerja"><span>Pekerjaan:</span>
                    <input type="text" id="txtKerja" name="txtKerja" placeholder="Masukkan Pekerjaan" required
                        value="<?= isset($old['pekerjaan']) ? htmlspecialchars($old['pekerjaan']) : '' ?>">
                </label>

                <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
                    <input type="text" id="txtNmOrtu" name="txtNmOrtu" placeholder="Masukkan Nama Orang Tua" required
                        value="<?= isset($old['ortu']) ? htmlspecialchars($old['ortu']) : '' ?>">
                </label>

                <label for="txtNmKakak"><span>Nama Kakak:</span>
                    <input type="text" id="txtNmKakak" name="txtNmKakak" placeholder="Masukkan Nama Kakak" required
                        value="<?= isset($old['kakak']) ? htmlspecialchars($old['kakak']) : '' ?>">
                </label>

                <label for="txtNmAdik"><span>Nama Adik:</span>
                    <input type="text" id="txtNmAdik" name="txtNmAdik" placeholder="Masukkan Nama Adik" required
                        value="<?= isset($old['adik']) ? htmlspecialchars($old['adik']) : '' ?>">
                </label>

                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Tryout UAS PWD - CRUD Biodata Mahasiswa</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>