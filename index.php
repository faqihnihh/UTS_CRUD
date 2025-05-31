<?php
include 'config.php';
include 'functions.php';
$menus = getAllMenu();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Restoran - Delicious Bites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* ===== VARIABEL & GLOBAL STYLES ===== */
        :root {
          --primary-dark: #020940;
          --primary-accent: #FEB200;
          --secondary-accent: #CE40D5;
          --text-light: #f8f9fa;
          --text-dark: #212529;
          --bg-light: #ffffff;
          --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          --transition: all 0.3s ease;
        }

        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Poppins', sans-serif;
        }

        body {
          background-color: #f5f5f5;
          color: var(--text-dark);
          line-height: 1.6;
        }

        .container {
          width: 90%;
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 15px;
        }

        /* ===== HEADER STYLES ===== */
        .header {
          background: linear-gradient(135deg, var(--primary-dark), #1a1a5e);
          color: var(--text-light);
          padding: 2rem 0;
          text-align: center;
          margin-bottom: 2rem;
          box-shadow: var(--shadow);
          position: relative;
        }

        .header h1 {
          font-size: 2.5rem;
          margin-bottom: 0.5rem;
        }

        .header h1 span {
          color: var(--primary-accent);
        }

        .header p {
          font-size: 1.1rem;
          opacity: 0.9;
        }

        .admin-link {
          position: absolute;
          top: 20px;
          right: 20px;
          background-color: var(--primary-accent);
          color: var(--primary-dark);
          padding: 8px 20px;
          border-radius: 50px;
          text-decoration: none;
          font-weight: 600;
          font-size: 0.9rem;
          transition: var(--transition);
          display: flex;
          align-items: center;
          gap: 8px;
        }

        .admin-link:hover {
          background-color: var(--secondary-accent);
          color: var(--text-light);
          transform: translateY(-2px);
        }

        /* ===== FILTER SECTION ===== */
        .filter-section {
          margin-bottom: 2.5rem;
        }

        .filter {
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 10px;
        }

        .filter-btn {
          padding: 12px 24px;
          border: none;
          border-radius: 50px;
          background-color: var(--primary-accent);
          color: var(--primary-dark);
          font-weight: 600;
          cursor: pointer;
          transition: var(--transition);
          display: flex;
          align-items: center;
          gap: 8px;
          box-shadow: var(--shadow);
        }

        .filter-btn i {
          font-size: 1rem;
        }

        .filter-btn:hover {
          background-color: var(--secondary-accent);
          color: var(--text-light);
          transform: translateY(-3px);
        }

        .filter-btn.active {
          background-color: var(--secondary-accent);
          color: var(--text-light);
        }

        /* ===== MENU SECTION ===== */
        .menu-container {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
          gap: 2rem;
          margin-bottom: 3rem;
        }

        .menu-item {
          background-color: var(--bg-light);
          border-radius: 10px;
          overflow: hidden;
          box-shadow: var(--shadow);
          transition: var(--transition);
        }

        .menu-item:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .menu-img {
          position: relative;
          height: 200px;
          overflow: hidden;
        }

        .menu-img img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: var(--transition);
        }

        .menu-item:hover .menu-img img {
          transform: scale(1.05);
        }

        .menu-price {
          position: absolute;
          bottom: 10px;
          right: 10px;
          background-color: var(--primary-accent);
          color: var(--primary-dark);
          padding: 5px 15px;
          border-radius: 50px;
          font-weight: 700;
          box-shadow: var(--shadow);
        }

        .menu-content {
          padding: 1.5rem;
        }

        .menu-content h3 {
          font-size: 1.3rem;
          margin-bottom: 0.5rem;
          color: var(--primary-dark);
        }

        .menu-content p {
          color: #666;
          margin-bottom: 1rem;
          font-size: 0.9rem;
        }

        .menu-category {
          display: inline-block;
          padding: 5px 15px;
          border-radius: 50px;
          font-size: 0.8rem;
          font-weight: 600;
          text-transform: uppercase;
        }

        .menu-category.makanan {
          background-color: rgba(254, 178, 0, 0.2);
          color: #b78103;
        }

        .menu-category.minuman {
          background-color: rgba(0, 123, 255, 0.2);
          color: #0069d9;
        }

        .menu-category.dessert {
          background-color: rgba(206, 64, 213, 0.2);
          color: #9c27b0;
        }

        .no-menu {
          text-align: center;
          grid-column: 1 / -1;
          padding: 2rem;
          color: #666;
        }

        .loading {
          text-align: center;
          grid-column: 1 / -1;
          padding: 2rem;
        }

        .loading i {
          color: var(--primary-accent);
          font-size: 2rem;
          animation: spin 1s infinite linear;
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        /* ===== SEARCH BAR ===== */
        .search-container {
          margin-bottom: 2rem;
          display: flex;
          justify-content: center;
        }

        .search-form {
          display: flex;
          width: 100%;
          max-width: 500px;
          box-shadow: var(--shadow);
          border-radius: 50px;
          overflow: hidden;
        }

        .search-input {
          flex: 1;
          padding: 12px 20px;
          border: none;
          font-size: 1rem;
          outline: none;
        }

        .search-btn {
          background-color: var(--primary-accent);
          color: var(--primary-dark);
          border: none;
          padding: 0 20px;
          cursor: pointer;
          transition: var(--transition);
          font-weight: 600;
        }

        .search-btn:hover {
          background-color: var(--secondary-accent);
          color: var(--text-light);
        }

        /* ===== FOOTER ===== */
        .footer {
          background-color: var(--primary-dark);
          color: var(--text-light);
          padding: 1.5rem 0;
          text-align: center;
          margin-top: 3rem;
        }

        .footer p {
          opacity: 0.8;
          font-size: 0.9rem;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
          .header h1 {
            font-size: 2rem;
          }
          
          .admin-link {
            position: relative;
            top: auto;
            right: auto;
            margin: 1rem auto 0;
            width: fit-content;
          }
          
          .filter {
            flex-direction: column;
            align-items: center;
          }
          
          .filter-btn {
            width: 100%;
            justify-content: center;
          }
          
          .menu-container {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
          }
        }

        @media (max-width: 480px) {
          .header h1 {
            font-size: 1.8rem;
          }
          
          .menu-container {
            grid-template-columns: 1fr;
          }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1><span>Faqih</span> Bites</h1>
            <p>Setiap Gigitan Penuh Cerita</p>
            <a href="admin/read.php" class="admin-link">
                <i class="fas fa-user-shield"></i> Admin Panel
            </a>
        </div>
    </header>

    <main class="container">
        <!-- Search Bar -->
        <section class="search-container">
            <form action="index.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari menu..." class="search-input" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>
        
        <!-- Filter Kategori -->
        <section class="filter-section">
            <div class="filter">
                <button class="filter-btn active" onclick="filterMenu('all')">
                    <i class="fas fa-utensils"></i> Semua
                </button>
                <button class="filter-btn" onclick="filterMenu('makanan')">
                    <i class="fas fa-hamburger"></i> Makanan
                </button>
                <button class="filter-btn" onclick="filterMenu('minuman')">
                    <i class="fas fa-glass-martini-alt"></i> Minuman
                </button>
                <button class="filter-btn" onclick="filterMenu('dessert')">
                    <i class="fas fa-ice-cream"></i> Dessert
                </button>
            </div>
        </section>

        <!-- Daftar Menu -->
        <section class="menu-section">
            <div class="menu-container">
                <?php
                // Filter pencarian jika ada
                $filteredMenus = $menus;
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $filteredMenus = array_filter($menus, function($menu) use ($search) {
                        return (stripos($menu['nama'], $search) !== false || 
                                stripos($menu['deskripsi'], $search) !== false ||
                                stripos($menu['kategori'], $search) !== false);
                    });
                }
                
                if (count($filteredMenus) > 0) {
                    foreach ($filteredMenus as $menu) {
                        echo '<div class="menu-item" data-kategori="'.$menu['kategori'].'">
                                <div class="menu-img">
                                    <img src="assets/img/'.$menu['gambar'].'" alt="'.$menu['nama'].'">
                                    <span class="menu-price">Rp '.number_format($menu['harga'], 0, ',', '.').'</span>
                                </div>
                                <div class="menu-content">
                                    <h3>'.$menu['nama'].'</h3>
                                    <p>'.$menu['deskripsi'].'</p>
                                    <div class="menu-category '.$menu['kategori'].'">
                                        '.ucfirst($menu['kategori']).'
                                    </div>
                                </div>
                              </div>';
                    }
                } else {
                    if (isset($_GET['search'])) {
                        echo '<p class="no-menu">Tidak ada menu yang sesuai dengan pencarian Anda</p>';
                    } else {
                        echo '<p class="no-menu">Tidak ada menu yang tersedia</p>';
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Delicious Bites. All rights reserved.</p>
        </div>
    </footer>

    <script>
    // Fungsi untuk filter menu berdasarkan kategori
    function filterMenu(kategori) {
        // Mengubah status tombol filter
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
        
        // Filter item menu
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            if (kategori === 'all') {
                item.style.display = 'block';
            } else {
                if (item.getAttribute('data-kategori') === kategori) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
        
        // Tampilkan pesan jika tidak ada menu yang sesuai
        const visibleItems = document.querySelectorAll('.menu-item[style="display: block"]');
        const noMenu = document.querySelector('.no-menu');
        
        if (visibleItems.length === 0 && !noMenu) {
            const menuContainer = document.querySelector('.menu-container');
            const noMenuMsg = document.createElement('p');
            noMenuMsg.className = 'no-menu';
            noMenuMsg.textContent = 'Tidak ada menu dalam kategori ini';
            menuContainer.appendChild(noMenuMsg);
        } else if (visibleItems.length > 0 && noMenu) {
            noMenu.remove();
        }
    }

    // Animation pada scroll
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        
        // Efek muncul secara bertahap untuk item menu
        menuItems.forEach((item, index) => {
            item.style.opacity = "0";
            item.style.transform = "translateY(20px)";
            
            setTimeout(() => {
                item.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                item.style.opacity = "1";
                item.style.transform = "translateY(0)";
            }, 100 * index);
        });
    });
    </script>
</body>
</html>