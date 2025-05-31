<?php
include '../functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php?error=ID menu tidak valid");
    exit;
}

$id = $_GET['id'];
$menu = getMenuById($id);

if (!$menu) {
    header("Location: ../index.php?error=Menu tidak ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Delicious Bites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --primary-color: #ff7f50;
            --secondary-color: #fff5ec;
            --primary-dark: #2c3e50;
            --text-color: #333;
            --accent-color: #ffb347;
            --danger-color: #e74c3c;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        header.header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        header h1 span {
            color: #fff;
            font-weight: bold;
        }

        .admin-nav {
            margin: 2rem 0;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .admin-nav a {
            padding: 0.5rem 1rem;
            text-decoration: none;
            background-color: var(--primary-dark);
            color: white;
            border-radius: 5px;
            transition: var(--transition);
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            background-color: var(--accent-color);
            color: var(--primary-dark);
        }

        .admin-panel {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-3px);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 179, 71, 0.25);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            background-color: var(--accent-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .required {
            color: var(--danger-color);
        }

        .current-image,
        .preview-image {
            max-width: 200px;
            border-radius: 5px;
            box-shadow: var(--shadow);
            margin-top: 10px;
        }

        .preview-image {
            display: none;
        }

        footer.footer {
            background-color: var(--primary-dark);
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }

        @media (max-width: 600px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1><span>Delicious</span> Bites</h1>
        <p>Panel Admin</p>
    </header>

    <div class="container">
        <nav class="admin-nav">
            <a href="../index.php">Lihat Website</a>
            <a href="read.php">Kelola Menu</a>
            <a href="update.php?id=<?php echo $id; ?>" class="active">Edit Menu</a>
        </nav>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert" style="color: red; margin-bottom: 1rem;">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <div class="admin-panel">
            <div class="admin-header">
                <h2>Edit Menu</h2>
                <a href="../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama</a>
            </div>

            <form action="process_update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Menu <span class="required">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($menu['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="required">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" required><?php echo htmlspecialchars($menu['deskripsi']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="harga" class="form-label">Harga (Rp) <span class="required">*</span></label>
                    <input type="number" id="harga" name="harga" class="form-control" min="1000" value="<?php echo $menu['harga']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori <span class="required">*</span></label>
                    <select id="kategori" name="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="makanan" <?php echo ($menu['kategori'] == 'makanan') ? 'selected' : ''; ?>>Makanan</option>
                        <option value="minuman" <?php echo ($menu['kategori'] == 'minuman') ? 'selected' : ''; ?>>Minuman</option>
                        <option value="dessert" <?php echo ($menu['kategori'] == 'dessert') ? 'selected' : ''; ?>>Dessert</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar" class="form-label">Gambar</label>
                    <p>Gambar Saat Ini:</p>
                    <img src="../assets/img/<?php echo $menu['gambar']; ?>" alt="<?php echo $menu['nama']; ?>" class="current-image">
                    <p>Unggah gambar baru (kosongkan jika tidak ingin mengganti):</p>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <img id="preview" class="preview-image">
                    <p style="font-size: 0.9rem; color: #666;">Format: JPG, JPEG, PNG, GIF (Max: 5MB)</p>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Delicious Bites. All rights reserved.</p>
    </footer>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
