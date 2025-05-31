<?php
include '../config.php'; // Perbaikan path file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM menu WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
                alert('Menu berhasil dihapus!');
                window.location.href = '../index.php';
              </script>";
    } else {
        echo "Gagal menghapus menu: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
