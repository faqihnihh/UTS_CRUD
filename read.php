<?php
include '../functions.php';
$menus = getAllMenu();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Delicious Bites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-dark: #2c3e50;
            --primary-accent: #f9c74f;
            --secondary-accent: #f9844a;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: var(--primary-dark);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: var(--primary-dark);
        }

        .header p {
            font-size: 1.2rem;
            margin-top: 0.3rem;
            color: #555;
        }

        .admin-panel {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }

        .admin-header h2 {
            color: var(--primary-dark);
        }

        .btn-add {
            background-color: var(--primary-accent);
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

        .btn-add:hover {
            background-color: var(--secondary-accent);
            transform: translateY(-3px);
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--primary-dark);
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-action {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-action:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }

        .category-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .category-badge.makanan {
            background-color: rgba(254, 178, 0, 0.2);
            color: #b78103;
        }

        .category-badge.minuman {
            background-color: rgba(0, 123, 255, 0.2);
            color: #0069d9;
        }

        .category-badge.dessert {
            background-color: rgba(206, 64, 213, 0.2);
            color: #9c27b0;
        }

        .admin-nav {
            display: flex;
            background-color: var(--primary-dark);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .admin-nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            border-radius: 5px;
            transition: var(--transition);
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            background-color: var(--primary-accent);
            color: var(--primary-dark);
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #f0f0f0;
            margin-top: 2rem;
            color: #777;
        }

        @media (max-width: 768px) {
            .admin-panel {
                padding: 1rem;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table th, .table td {
                padding: 8px 10px;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1><span>Delicious</span> Bites</h1>
            <p>Admin Panel</p>
        </div>
    </header>

    <div class="container">
        <nav class="admin-nav">
            <a href="../index.php">Lihat Website</a>
            <a href="read.php" class="active">Kelola Menu</a>
        </nav>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                    switch ($_GET['success']) {
                        case 'create': echo "Menu berhasil ditambahkan!"; break;
                        case 'update': echo "Menu berhasil diperbarui!"; break;
                        case 'delete': echo "Menu berhasil dihapus!"; break;
                        default: echo "Operasi berhasil dilakukan!";
                    }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <div class="admin-panel">
            <div class="admin-header">
                <h2>Daftar Menu</h2>
                <a href="create.php" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Menu Baru
                </a>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($menus) > 0): ?>
                            <?php foreach ($menus as $menu): ?>
                                <tr>
                                    <td><?php echo $menu['id']; ?></td>
                                    <td>
                                        <img src="../assets/img/<?php echo $menu['gambar']; ?>" alt="<?php echo $menu['nama']; ?>">
                                    </td>
                                    <td><?php echo $menu['nama']; ?></td>
                                    <td><?php echo substr($menu['deskripsi'], 0, 50) . '...'; ?></td>
                                    <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="category-badge <?php echo $menu['kategori']; ?>">
                                            <?php echo ucfirst($menu['kategori']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="update.php?id=<?php echo $menu['id']; ?>" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete.php?id=<?php echo $menu['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Tidak ada menu yang tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Delicious Bites. All rights reserved.</p>
    </footer>
</body>
</html>
