<?php
include '../functions.php';

// Jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $harga = trim($_POST['harga']);
    $kategori = trim($_POST['kategori']);
    
    // Validasi input
    $errors = validateMenuInput($nama, $deskripsi, $harga, $kategori);
    
    // Validasi file gambar
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {
        $errors[] = "File gambar harus diunggah";
    }
    
    // Jika tidak ada error, lanjutkan proses
    if (empty($errors)) {
        // Upload gambar
        $gambarName = uploadGambar($_FILES['gambar']);
        
        if ($gambarName) {
            // Tambahkan menu ke database
            $result = addMenu($nama, $deskripsi, $harga, $kategori, $gambarName);
            
            if ($result) {
                // Redirect ke halaman daftar menu dengan pesan sukses
                header("Location: read.php?success=create");
                exit;
            } else {
                // Jika gagal menyimpan ke database
                header("Location: create.php?error=Gagal menambahkan menu. Silakan coba lagi.");
                exit;
            }
        } else {
            // Jika gagal upload gambar
            header("Location: create.php?error=Gagal mengunggah gambar. Pastikan format dan ukuran gambar sesuai.");
            exit;
        }
    } else {
        // Jika ada error validasi, tampilkan pesan error
        $errorMessage = implode("<br>", $errors);
        header("Location: create.php?error=" . urlencode($errorMessage));
        exit;
    }
} else {
    // Jika bukan method POST, redirect ke halaman create
    header("Location: create.php");
    exit;
}
?>