<?php
/**
 * read_biodata.php
 * =================
 * File untuk menampilkan semua record biodata pengunjung (READ)
 * - Menampilkan data dalam bentuk tabel
 * - Link Edit mengarah ke edit_biodata.php
 * - Link Delete dengan konfirmasi mengarah ke proses_delete_biodata.php
 * - Menampilkan flash message sukses/gagal
 */

session_start();
require 'koneksi.php';
require 'fungsi.php';

# Query untuk mengambil semua data biodata
$sql = "SELECT * FROM tbl_imoet ORDER BY bid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  die("Query error: " . mysqli_error($conn));
}

# Ambil flash message jika ada
$flash_sukses = $_SESSION['flash_sukses_imoet'] ?? '';
$flash_error  = $_SESSION['flash_error_imoet'] ?? '';

# Bersihkan session flash message
unset($_SESSION['flash_sukses_imoet'], $_SESSION['flash_error_imoet']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Biodata Pengunjung</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Styling tambahan untuk halaman read */
    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    table th {
      background: #003366;
      color: #fff;
    }

    table tr:nth-child(even) {
      background: #f9f9f9;
    }

    table tr:hover {
      background: #f1f1f1;
    }

    .btn-link {
      display: inline-block;
      padding: 5px 10px;
      margin: 2px;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
    }

    .btn-edit {
      background: #0379ee;
      color: #fff;
    }

    .btn-edit:hover {
      background: #025bb5;
    }

    .btn-delete {
      background: #dc3545;
      color: #fff;
    }

    .btn-delete:hover {
      background: #a71d2a;
    }

    .btn-back {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background: #003366;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
    }

    .btn-back:hover {
      background: #0379ee;
    }

    .alert-success {
      padding: 10px;
      margin-bottom: 10px;
      background: #d4edda;
      color: #155724;
      border-radius: 6px;
    }

    .alert-error {
      padding: 10px;
      margin-bottom: 10px;
      background: #f8d7da;
      color: #721c24;
      border-radius: 6px;
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
    <div class="container">
      <h2>Data Biodata Pengunjung</h2>

      <!-- Tampilkan flash message sukses -->
      <?php if (!empty($flash_sukses)): ?>
        <div class="alert-success">
          <?= $flash_sukses; ?>
        </div>
      <?php endif; ?>

      <!-- Tampilkan flash message error -->
      <?php if (!empty($flash_error)): ?>
        <div class="alert-error">
          <?= $flash_error; ?>
        </div>
      <?php endif; ?>

      <!-- Tabel data biodata -->
      <table>
        <tr>
          <th>No</th>
          <th>Aksi</th>
          <th>ID</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Tempat Lahir</th>
          <th>Tanggal Lahir</th>
          <th>Hobi</th>
          <th>Pasangan</th>
          <th>Pekerjaan</th>
          <th>Created At</th>
        </tr>
        <?php $i = 1; ?>
        <?php if (mysqli_num_rows($q) === 0): ?>
          <tr>
            <td colspan="11" style="text-align:center;">Belum ada data biodata.</td>
          </tr>
        <?php else: ?>
          <?php while ($row = mysqli_fetch_assoc($q)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td>
                <!-- Link Edit: mengarah ke form edit -->
                <a class="btn-link btn-edit" href="edit_biodata.php?bid=<?= (int)$row['bid']; ?>">Edit</a>
                <!-- Link Delete: dengan konfirmasi JavaScript -->
                <a class="btn-link btn-delete" 
                   onclick="return confirm('Hapus biodata <?= htmlspecialchars($row['bnama']); ?>?')" 
                   href="proses_delete_biodata.php?bid=<?= (int)$row['bid']; ?>">Delete</a>
              </td>
              <td><?= $row['bid']; ?></td>
              <td><?= htmlspecialchars($row['bnim']); ?></td>
              <td><?= htmlspecialchars($row['bnama']); ?></td>
              <td><?= htmlspecialchars($row['btempat_lahir']); ?></td>
              <td><?= htmlspecialchars($row['btgl_lahir']); ?></td>
              <td><?= htmlspecialchars($row['bhobi']); ?></td>
              <td><?= htmlspecialchars($row['bpasangan']); ?></td>
              <td><?= htmlspecialchars($row['bpekerjaan']); ?></td>
              <td><?= formatTanggal($row['dcreated_at']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </table>

      <a href="index.php#biodata" class="btn-back">← Kembali ke Form Biodata</a>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>
