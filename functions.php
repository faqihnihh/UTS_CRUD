<?php
include 'config.php';

/**
 * Fungsi untuk mendapatkan semua menu
 * @return array
 */
function getAllMenu() {
    global $conn;
    $query = "SELECT * FROM menu ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $menus = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $menus[] = $row;
        }
    }
    
    return $menus;
}

/**
 * Fungsi untuk mendapatkan menu berdasarkan ID
 * @param int $id
 * @return array|null
 */
function getMenuById($id) {
    global $conn;
    $query = "SELECT * FROM menu WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

/**
 * Fungsi untuk menambahkan menu baru
 * @param string $nama
 * @param string $deskripsi
 * @param int $harga
 * @param string $kategori
 * @param string $gambar
 * @return bool
 */
function addMenu($nama, $deskripsi, $harga, $kategori, $gambar) {
    global $conn;
    $query = "INSERT INTO menu (nama, deskripsi, harga, kategori, gambar) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssiss", $nama, $deskripsi, $harga, $kategori, $gambar);
    
    return mysqli_stmt_execute($stmt);
}

/**
 * Fungsi untuk memperbarui menu
 * @param int $id
 * @param string $nama
 * @param string $deskripsi
 * @param int $harga
 * @param string $kategori
 * @param string $gambar
 * @return bool
 */
function updateMenu($id, $nama, $deskripsi, $harga, $kategori, $gambar = null) {
    global $conn;
    
    if ($gambar) {
        $query = "UPDATE menu SET nama = ?, deskripsi = ?, harga = ?, kategori = ?, gambar = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssissi", $nama, $deskripsi, $harga, $kategori, $gambar, $id);
    } else {
        $query = "UPDATE menu SET nama = ?, deskripsi = ?, harga = ?, kategori = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssisi", $nama, $deskripsi, $harga, $kategori, $id);
    }
    
    return mysqli_stmt_execute($stmt);
}

/**
 * Fungsi untuk menghapus menu
 * @param int $id
 * @return bool
 */
function deleteMenu($id) {
    global $conn;
    $query = "DELETE FROM menu WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    return mysqli_stmt_execute($stmt);
}

/**
 * Fungsi untuk upload gambar
 * @param array $file
 * @return string|bool
 */
function uploadGambar($file) {
    $targetDir = "../assets/img/";
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Cek apakah file adalah gambar
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }
    
    // Cek ukuran file (max 5MB)
    if ($file["size"] > 5000000) {
        return false;
    }
    
    // Izinkan hanya format tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return false;
    }
    
    // Buat nama file unik
    $uniqueName = uniqid() . '_' . $fileName;
    $targetFile = $targetDir . $uniqueName;
    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $uniqueName;
    } else {
        return false;
    }
}

/**
 * Fungsi untuk validasi input menu
 * @param string $nama
 * @param string $deskripsi
 * @param int $harga
 * @param string $kategori
 * @return array
 */
function validateMenuInput($nama, $deskripsi, $harga, $kategori) {
    $errors = [];
    
    if (empty($nama)) {
        $errors[] = "Nama menu harus diisi";
    }
    
    if (empty($deskripsi)) {
        $errors[] = "Deskripsi menu harus diisi";
    }
    
    if (empty($harga) || !is_numeric($harga) || $harga <= 0) {
        $errors[] = "Harga harus berupa angka positif";
    }
    
    if (empty($kategori) || !in_array($kategori, ['makanan', 'minuman', 'dessert'])) {
        $errors[] = "Kategori harus diisi dengan benar";
    }
    
    return $errors;
}
?>