<?php
include '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    // Validasi
    $errors = validateMenuInput($nama, $deskripsi, $harga, $kategori);

    if (!empty($errors)) {
        // Kembalikan ke form dengan pesan error
        session_start();
        $_SESSION['errors'] = $errors;
        header("Location: update.php?id=" . $id);
        exit;
    }

    // Cek apakah ada file gambar baru diupload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $upload = uploadGambar($_FILES['gambar']);
        if ($upload !== false) {
            $gambar = $upload;
        }
    }

    // Update data
    $success = updateMenu($id, $nama, $deskripsi, $harga, $kategori, $gambar);
    if ($success) {
        header("Location: ../index.php?update=success");
    } else {
        echo "Gagal menyimpan perubahan.";
    }
} else {
    echo "Permintaan tidak valid.";
}
?>
