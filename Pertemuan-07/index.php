<?php
session_start();
$sesnim = "";
if (isset($_SESSION["sesnim"])):
  $sesnim = $_SESSION["sesnim"];
endif;
$sesnama = "";
if (isset($_SESSION["sesnama"])):
  $sesnama = $_SESSION["sesnama"];
endif;
$sesTempat_lahir = "";
if (isset($_SESSION["sesTempat_lahir"])):
  $sesTempat_lahir = $_SESSION["sesTempat_lahir"];
endif;
$sesTanggal_lahir = "";
if (isset($_SESSION["sesTanggal_lahir"])):
  $sesTanggal_lahir = $_SESSION["sesTanggal_lahir"];
endif;
$sesHobi = "";
if (isset($_SESSION["sesHobi"])):
  $sesHobi = $_SESSION["sesHobi"];
endif;
$sesPasangan = "";
if (isset($_SESSION["sesPasangan"])):
  $sesPasangan = $_SESSION["sesPasangan"];
endif;
$sesPekerjaan = "";
if (isset($_SESSION["sesPekerjaan"])):
  $sesPekerjaan = $_SESSION["sesPekerjaan"];
endif;
$sesNama_ortu = "";
if (isset($_SESSION["sesNama_ortu"])):
  $sesNama_ortu = $_SESSION["sesNama_ortu"];
endif;
$sesNama_kakak = "";
if (isset($_SESSION["sesNama_kakak"])):
  $sesNama_kakak = $_SESSION["sesNama_kakak"];
endif;
$sesNama_adik = "";
if (isset($_SESSION["sesNama_adik"])):
  $sesNama_adik = $_SESSION["sesNama_adik"];
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Judul Halaman</title>
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
        <li><a href="#home">Beranda</a></li>
        <li><a href="#about">Tentang</a></li>
        <li><a href="#contact">Kontak</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="home">
      <h2>Selamat Datang</h2>
      <?php
      echo "halo dunia!<br>";
      echo "nama saya hadi";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    <section id="about">
      <h2>Tentang Kamu</h2>
      <p><strong>NIM:</strong><?php echo $sesnim ?></p>
      <p><strong>Nama:</strong><?php echo $sesnama ?></p>
      <p><strong>Tempat Lahir:</strong><?php echo $sesTempat_lahir ?></p>
      <p><strong>Tanggal Lahir:</strong><?php echo $sesTempat_lahir ?></p>
      <p><strong>Hobi:</strong><?php echo $sesHobi ?></p>
      <p><strong>Pasangan:</strong><?php echo $sesPasangan ?></p>
      <p><strong>Pekerjaan:</strong><?php echo $sesPekerjaan ?></p>
      <p><strong>Nama Orang Tua:</strong><?php echo $sesNama_ortu ?></p>
      <p><strong>Nama Kakak:</strong><?php echo $sesNama_kakak ?></p>
      <p><strong>Nama Adik:</strong><?php echo $sesNama_adik ?></p>
    </section>



    <section id="contact">
      <h2>Kontak Kami</h2>
      <form action="" method="GET">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required autocomplete="name">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required autocomplete="email">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..." required></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>


        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>
    </section>

    <section id="aboutyou">
      <h2>Entry Data Mahasiswa</h2>

      <form action="proses.php" method="post">

        <label for="txtNim"><span>Nim:</span>
          <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan nim" required autocomplete="nim">
        </label>
        <label for="txtNama1"><span>Nama:</span>
          <input type="text" id="txtNama1" name="txtNama1" placeholder="Masukkan nama" required autocomplete="name">
        </label>
        <label for="txtTempat_lahir"><span>Tempat Lahir:</span>
          <input type="text" id="txtTempat_lahir" name="txtTempat_lahir" placeholder="Masukkan Tempat lahir" required autocomplete="tempat_lahir">
        </label>
        <label for="txtTanggal_lahir"><span>Tanggal Lahir:</span>
          <input type="text" id="txtTanggal_lahir" name="txtTanggal_lahir" placeholder="Masukan Tanggal Lahir" required autocomplete="tanggal_lahir">
        </label>
        <label for="txtHobi"><span>Hobi:</span>
          <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukan Tanggal Lahir" required autocomplete="hobi">
        </label>
        <label for="txtPasangan"><span>Pasangan:</span>
          <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required autocomplete="pasangan">
        </label>
        <label for="txtPekerjaan"><span>Pekerjaan:</span>
          <input type="text" id="txtPekerjaan" name="txtPekerjaan" placeholder="Masukkan Pekerjaan" required autocomplete="pekerjaan">
        </label>
        <label for="txtNama_ortu"><span>Nama Orang Tua:</span>
          <input type="text" id="txtNama_ortu" name="txtNama_ortu" placeholder="Masukkan Nama Orang Tua" required autocomplete="nama_ortu">
        </label>
        <label for="txtNama_Kakak"><span>Nama Kakak:</span>
          <input type="text" id="txtNama_kakak" name="txtNama_kakak" placeholder="Masukkan Nama Kakak" required autocomplete="nama_kakak">
        </label>
        <label for="txtNama_adik"><span>Nama Adik:</span>
          <input type="text" id="txtNama_adik" name="txtNama_adik" placeholder="Masukkan Nama Adik" required autocomplete="nama_adik">
        </label>


        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>
    </section>



  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>