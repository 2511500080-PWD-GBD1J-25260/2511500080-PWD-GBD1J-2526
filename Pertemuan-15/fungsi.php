<?php
/**
 * Fungsi untuk redirect ke URL tertentu
 */
function redirect_ke($url)
{
    header("Location: " . $url);
    exit();
}

/**
 * Fungsi untuk sanitasi input (mencegah XSS)
 */
function bersihkan($str)
{
    return htmlspecialchars(trim($str));
}

/**
 * Fungsi untuk cek apakah string tidak kosong
 */
function tidakKosong($str)
{
    return strlen(trim($str)) > 0;
}

/**
 * Fungsi untuk format tanggal
 */
function formatTanggal($tgl)
{
    return date("d M Y H:i:s", strtotime($tgl));
}
