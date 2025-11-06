<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Judul Halaman</title>
  <style>
    
#about,
#contact {
background-color: #ffffff;
border-radius: 10px;
padding: 20px;
max-width: 700px;
margin: 20px auto;
box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

#about h2,
#contact h2 {
color: #003366;
border-bottom: 2px solid #003366;
padding-bottom: 6px;
margin-top: 0;
margin-bottom: 16px;
}

#about p,
#contact label {
display: flex;
justify-content: flex-start;
align-items: baseline;
margin: 0;
padding: 6px 0;
border-bottom: 1px solid #e6e6e6;
}

#about strong,
#contact label>span {
min-width: 180px;
color: #003366;
font-weight: 600;
text-align: left;
padding-right: 16px;
flex-shrink: 0;
}

#contact input,
#contact textarea {
flex: 1;
border: 1px solid #ccc;
border-radius: 6px;
padding: 8px;
color: #000;
font-weight: normal;
margin: 0;
box-sizing: border-box;
}






#about strong,
#contact label>span {
text-align: left;
padding-right: 0;
margin-bottom: 2px;
}
#contact input,
#contact textarea,
#contact button {
width: 100%;
}
}

  </style>
</head>
<body>

<main>


  <section id="about">
    <?php
    $nim = "2511500080";
    $Nama_Lengkap = "Marsya Maharani";
    $Tempat_Lahir = "Pangkalpinang";
    $Tanggal_Lahir = "05 Maret 2007";
    $hobi = "Memasak";
    $Pasangan = "Belum ada;";
    $Pekerjaan = "Mahasiswa 2025";
    $Nama_orang_tua ="Bapak Syahrial dan Ibu Yesi";
    $Nama_kakak = "Ikhsan";
    $Nama_adik = "Regina Putri";
    ?>
    <h2>  &#128526;TENTANG SAYA &#128526; </h2>
          <p><strong>NIM:</strong><?php echo "$nim";?></p> 
          <P><strong>Nama Lengkap:</strong><?php echo "$Nama_Lengkap";?></P>
          <P><strong>Tempat lahir:</strong><?php echo "$Tempat_Lahir";?></P>
          <P><strong>Tanggal lahir:</strong><?php echo "$Tanggal_Lahir";?></P>
          <p><strong>Hobi:</strong><?php echo "$hobi";?></p> 
          <P><strong>Pasangan:</strong><?php echo " $Pasangan";?></P>
          <P><strong>Pekerjaan:</strong><?php echo " $Pekerjaan";?></P> 
          <P><strong>Nama orang tua:</strong><?php echo "$Nama_orang_tua";?></P> 
          <P><strong>Nama kakak:</strong><?php echo "$Nama_kakak";?></P>
          <P><strong>Nama adik:</strong><?php echo "$Nama_adik";?></p>
 

    <?php
$namaMatkul1 = "Algoritma dan Struktur Data";
$sksMatkul1 = 4;
$nilaiHadir1 = 90;
$nilaiTugas1 = 60;
$nilaiUTS1 = 80;
$nilaiUAS1 = 70;

$namaMatkul2 = "Agama";
$sksMatkul2 = 2;
$nilaiHadir2 = 70;
$nilaiTugas2 = 50;
$nilaiUTS2 = 60;
$nilaiUAS2 = 80;

$namaMatkul3 = "Matematika"; 
$sksMatkul3 = 4;
$nilaiHadir3 = 80;
$nilaiTugas3 = 70;
$nilaiUTS3 = 75;
$nilaiUAS3 = 80;

$namaMatkul4 = "Fisika";
$sksMatkul4 = 7;
$nilaiHadir4 = 85;
$nilaiTugas4 = 75;
$nilaiUTS4 = 80;
$nilaiUAS4 = 85;

$namaMatkul5 = "Pemrograman Web Dasar";
$sksMatkul5 = 3;
$nilaiHadir5 = 69;
$nilaiTugas5 = 80;
$nilaiUTS5 = 90;
$nilaiUAS5 = 100;


function hitungNilaiAkhir($hadir, $tugas, $uts, $uas) {
    return (0.1 * $hadir) + (0.2 * $tugas) + (0.3 * $uts) + (0.4 * $uas);
}

function tentukanGrade($hadir, $nilaiAkhir) {
    if ($hadir < 70) {
        return "E";
    } elseif ($nilaiAkhir >= 85) {
        return "A";
    } elseif ($nilaiAkhir >= 80) {
        return "A-";
    } elseif ($nilaiAkhir >= 75) {
        return "B+";
    } elseif ($nilaiAkhir >= 70) {
        return "B";
    } elseif ($nilaiAkhir >= 65) {
        return "B-";
    } elseif ($nilaiAkhir >= 60) {
        return "C+";
    } elseif ($nilaiAkhir >= 55) {
        return "C";
    } elseif ($nilaiAkhir >= 50) {
        return "C-";
    } elseif ($nilaiAkhir >= 45) {
        return "D";
    } else {
        return "E";
    }
}

function tentukanMutu($grade) {
    switch ($grade) {
        case "A": return 4.00;
        case "A-": return 3.70;
        case "B+": return 3.30;
        case "B": return 3.00;
        case "B-": return 2.70;
        case "C+": return 2.30;
        case "C": return 2.00;
        case "C-": return 1.70;
        case "D": return 1.00;
        case "E": return 0.00;
        default: return 0.00;
    }
}

function tentukanStatus($grade) {
    if (in_array($grade, ["A", "A-", "B+", "B", "B-", "C+", "C", "C-"])) {
        return "Lulus";
    } else {
        return "Gagal";
    }
}

for ($i = 1; $i <= 5; $i++) {
    $hadir = ${"nilaiHadir$i"};
    $tugas = ${"nilaiTugas$i"};
    $uts = ${"nilaiUTS$i"};
    $uas = ${"nilaiUAS$i"};
    $sks = ${"sksMatkul$i"};

    ${"nilaiAkhir$i"} = hitungNilaiAkhir($hadir, $tugas, $uts, $uas);
    ${"grade$i"} = tentukanGrade($hadir, ${"nilaiAkhir$i"});
    ${"mutu$i"} = tentukanMutu(${"grade$i"});
    ${"bobot$i"} = ${"mutu$i"} * $sks;
    ${"status$i"} = tentukanStatus(${"grade$i"});
}

$totalBobot = $bobot1 + $bobot2 + $bobot3 + $bobot4 + $bobot5;
$totalSKS = $sksMatkul1 + $sksMatkul2 + $sksMatkul3 + $sksMatkul4 + $sksMatkul5;
$IPK = $totalSKS > 0 ? $totalBobot / $totalSKS : 0;
?>

    </style>
</head>
<body>
    <h2><br>Nilai Saya</br></h2>

        <div class="matkul">
            <br>
            <div><span class="label">Nama Matakuliah ke-1 :</span> <span class="value"><?php echo $namaMatkul1; ?></span></div>
            <div><span class="label">SKS :</span> <span class="value"><?php echo $sksMatkul1; ?></span></div>
            <div><span class="label">Kehadiran :</span> <span class="value"><?php echo $nilaiHadir1; ?></span></div>
            <div><span class="label">Tugas :</span> <span class="value"><?php echo $nilaiTugas1; ?></span></div>
            <div><span class="label">UTS :</span> <span class="value"><?php echo $nilaiUTS1; ?></span></div>
            <div><span class="label">UAS :</span> <span class="value"><?php echo $nilaiUAS1; ?></span></div>
            <div><span class="label">Nilai Akhir :</span> <span class="value"><?php echo number_format($nilaiAkhir1, 2); ?></span></div>
            <div><span class="label">Grade :</span> <span class="value"><?php echo $grade1; ?></span></div>
            <div><span class="label">Angka Mutu :</span> <span class="value"><?php echo number_format($mutu1, 2); ?></span></div>
            <div><span class="label">Bobot :</span> <span class="value"><?php echo number_format($bobot1, 2); ?></span></div>
            <div><span class="label">Status :</span> <span class="value"><?php echo $status1; ?></span></div>
</br>
        </div>

        <div class="matkul">
             <br>
            <div><span class="label">Nama Matakuliah ke-2 :</span> <span class="value"><?php echo $namaMatkul2; ?></span></div>
            <div><span class="label">SKS :</span> <span class="value"><?php echo $sksMatkul2; ?></span></div>
            <div><span class="label">Kehadiran :</span> <span class="value"><?php echo $nilaiHadir2; ?></span></div>
            <div><span class="label">Tugas :</span> <span class="value"><?php echo $nilaiTugas2; ?></span></div>
            <div><span class="label">UTS :</span> <span class="value"><?php echo $nilaiUTS2; ?></span></div>
            <div><span class="label">UAS :</span> <span class="value"><?php echo $nilaiUAS2; ?></span></div>
            <div><span class="label">Nilai Akhir :</span> <span class="value"><?php echo number_format($nilaiAkhir2, 2); ?></span></div>
            <div><span class="label">Grade :</span> <span class="value"><?php echo $grade2; ?></span></div>
            <div><span class="label">Angka Mutu :</span> <span class="value"><?php echo number_format($mutu2, 2); ?></span></div>
            <div><span class="label">Bobot :</span> <span class="value"><?php echo number_format($bobot2, 2); ?></span></div>
            <div><span class="label">Status :</span> <span class="value"><?php echo $status2; ?></span></div>
</br>
        </div>

        <div class="matkul">
            <br>
            <div><span class="label">Nama Matakuliah ke-3 :</span> <span class="value"><?php echo $namaMatkul3; ?></span></div>
            <div><span class="label">SKS :</span> <span class="value"><?php echo $sksMatkul3; ?></span></div>
            <div><span class="label">Kehadiran :</span> <span class="value"><?php echo $nilaiHadir3; ?></span></div>
            <div><span class="label">Tugas :</span> <span class="value"><?php echo $nilaiTugas3; ?></span></div>
            <div><span class="label">UTS :</span> <span class="value"><?php echo $nilaiUTS3; ?></span></div>
            <div><span class="label">UAS :</span> <span class="value"><?php echo $nilaiUAS3; ?></span></div>
            <div><span class="label">Nilai Akhir :</span> <span class="value"><?php echo number_format($nilaiAkhir3, 2); ?></span></div>
            <div><span class="label">Grade :</span> <span class="value"><?php echo $grade3; ?></span></div>
            <div><span class="label">Angka Mutu :</span> <span class="value"><?php echo number_format($mutu3, 2); ?></span></div>
            <div><span class="label">Bobot :</span> <span class="value"><?php echo number_format($bobot3, 2); ?></span></div>
            <div><span class="label">Status :</span> <span class="value"><?php echo $status3; ?></span></div>
</br>
        </div>

        <div class="matkul">
            <br>
            <div><span class="label">Nama Matakuliah ke-4 :</span> <span class="value"><?php echo $namaMatkul4; ?></span></div>
            <div><span class="label">SKS :</span> <span class="value"><?php echo $sksMatkul4; ?></span></div>
            <div><span class="label">Kehadiran :</span> <span class="value"><?php echo $nilaiHadir4; ?></span></div>
            <div><span class="label">Tugas :</span> <span class="value"><?php echo $nilaiTugas4; ?></span></div>
            <div><span class="label">UTS :</span> <span class="value"><?php echo $nilaiUTS4; ?></span></div>
            <div><span class="label">UAS :</span> <span class="value"><?php echo $nilaiUAS4; ?></span></div>
            <div><span class="label">Nilai Akhir :</span> <span class="value"><?php echo number_format($nilaiAkhir4, 2); ?></span></div>
            <div><span class="label">Grade :</span> <span class="value"><?php echo $grade4; ?></span></div>
            <div><span class="label">Angka Mutu :</span> <span class="value"><?php echo number_format($mutu4, 2); ?></span></div>
            <div><span class="label">Bobot :</span> <span class="value"><?php echo number_format($bobot4, 2); ?></span></div>
            <div><span class="label">Status :</span> <span class="value"><?php echo $status4; ?></span></div>
</br>
        </div>

        <div class="matkul">
             <br>
            <div><span class="label">Nama Matakuliah ke-5 :</span> <span class="value"><?php echo $namaMatkul5; ?></span></div>
            <div><span class="label">SKS :</span> <span class="value"><?php echo $sksMatkul5; ?></span></div>
            <div><span class="label">Kehadiran :</span> <span class="value"><?php echo $nilaiHadir5; ?></span></div>
            <div><span class="label">Tugas :</span> <span class="value"><?php echo $nilaiTugas5; ?></span></div>
            <div><span class="label">UTS :</span> <span class="value"><?php echo $nilaiUTS5; ?></span></div>
            <div><span class="label">UAS :</span> <span class="value"><?php echo $nilaiUAS5; ?></span></div>
            <div><span class="label">Nilai Akhir :</span> <span class="value"><?php echo number_format($nilaiAkhir5, 2); ?></span></div>
            <div><span class="label">Grade :</span> <span class="value"><?php echo $grade5; ?></span></div>
            <div><span class="label">Angka Mutu :</span> <span class="value"><?php echo number_format($mutu5, 2); ?></span></div>
            <div><span class="label">Bobot :</span> <span class="value"><?php echo number_format($bobot5, 2); ?></span></div>
            <div><span class="label">Status :</span> <span class="value"><?php echo $status5; ?></span></div>
</br>
        </div>
    </div>

    <div class="total">
        <div><span class="label">Total Bobot :</span> <span class="value"><?php echo number_format($totalBobot, 2); ?></span></div>
        <div><span class="label">Total SKS :</span> <span class="value"><?php echo $totalSKS; ?></span></div>
        <div><span class="label">IPK :</span> <span class="value"><?php echo number_format($IPK, 2); ?></span></div>
    </div>

</body>
</html>

          
            
            
             
            
