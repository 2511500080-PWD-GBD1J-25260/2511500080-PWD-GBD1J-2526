<?php
/**
 * File Koneksi Database
 * Menghubungkan aplikasi ke database MySQL
 */

// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_pwd2025";

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
