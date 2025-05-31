<?php
$host = "localhost";
$user = "root";
$pass = ""; // Jika ada password MySQL, isi di sini
$db   = "resto_menu"; // Ganti dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
