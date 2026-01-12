<?php
/**
 * Halaman Read - Menampilkan Data Biodata Mahasiswa
 * Menampilkan semua data biodata mahasiswa dalam bentuk tabel
 * dengan link untuk edit dan delete
 */

session_start();
require 'koneksi.php';
require 'fungsi.php';

// Query untuk mengambil semua data biodata mahasiswa
$sql = "SELECT * FROM tbl_biodata_mahasiswa ORDER BY created_at DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
    die("Query error: " . mysqli_error($conn));
}

// Ambil flash message
$flash_sukses = $_SESSION['flash_sukses'] ?? '';
$flash_error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_sukses'], $_SESSION['flash_error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Biodata Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Data Biodata Mahasiswa</h1>
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
            <h2>Daftar Biodata Mahasiswa</h2>

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

            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Hobi</th>
                    <th>Pasangan</th>
                    <th>Pekerjaan</th>
                    <th>Nama Orang Tua</th>
                    <th>Nama Kakak</th>
                    <th>Nama Adik</th>
                    <th>Dibuat Pada</th>
                </tr>
                <?php $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($q)): ?>
                    <tr>
                        <td>
                            <?= $i++ ?>
                        </td>
                        <td>
                            <a href="edit.php?nim=<?= urlencode($row['nim']); ?>">Edit</a>
                            <a onclick="return confirm('Yakin ingin menghapus data mahasiswa dengan NIM <?= htmlspecialchars($row['nim']); ?>?')"
                                href="proses_delete.php?nim=<?= urlencode($row['nim']); ?>">Delete</a>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['nim']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['nama_lengkap']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['tempat_lahir']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['tanggal_lahir']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['hobi']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['pasangan']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['pekerjaan']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['nama_ortu']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['nama_kakak']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['nama_adik']); ?>
                        </td>
                        <td>
                            <?= formatTanggal(htmlspecialchars($row['created_at'])); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Tryout UAS PWD - CRUD Biodata Mahasiswa</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>