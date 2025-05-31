<?php 
include '../config.php';

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    // Upload gambar
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = '../assets/img/';
    
    // Generate nama unik untuk gambar
    $gambar_ext = pathinfo($gambar_name, PATHINFO_EXTENSION);
    $gambar_newname = uniqid('menu_', true) . '.' . $gambar_ext;
    
    move_uploaded_file($gambar_tmp, $upload_dir . $gambar_newname);
    
    // Simpan ke database
    $sql = "INSERT INTO menu (nama, deskripsi, harga, kategori, gambar) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $nama, $deskripsi, $harga, $kategori, $gambar_newname);
    $stmt->execute();
    
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Baru - Delicious Bites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
          max-width: 800px;
          margin: 2rem auto;
          padding: 0 15px;
        }

        /* ===== HEADER STYLES ===== */
        .header {
          background: linear-gradient(135deg, var(--primary-dark), #1a1a5e);
          color: var(--text-light);
          padding: 1.5rem 0;
          text-align: center;
          margin-bottom: 2rem;
          box-shadow: var(--shadow);
          border-radius: 10px;
        }

        .header h1 {
          font-size: 1.8rem;
          margin-bottom: 0.5rem;
        }

        .header h1 span {
          color: var(--primary-accent);
        }

        .back-link {
          display: inline-block;
          margin-top: 1rem;
          color: var(--primary-accent);
          text-decoration: none;
          font-weight: 600;
          transition: var(--transition);
        }

        .back-link:hover {
          color: var(--secondary-accent);
        }

        /* ===== FORM STYLES ===== */
        .form-container {
          background-color: var(--bg-light);
          border-radius: 10px;
          padding: 2rem;
          box-shadow: var(--shadow);
          margin-bottom: 2rem;
        }

        .form-group {
          margin-bottom: 1.5rem;
        }

        .form-group label {
          display: block;
          margin-bottom: 0.5rem;
          font-weight: 600;
          color: var(--primary-dark);
        }

        .form-control {
          width: 100%;
          padding: 12px 15px;
          border: 1px solid #ddd;
          border-radius: 5px;
          font-size: 1rem;
          transition: var(--transition);
        }

        .form-control:focus {
          border-color: var(--secondary-accent);
          outline: none;
          box-shadow: 0 0 0 3px rgba(206, 64, 213, 0.2);
        }

        textarea.form-control {
          min-height: 120px;
          resize: vertical;
        }

        select.form-control {
          appearance: none;
          background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
          background-repeat: no-repeat;
          background-position: right 15px center;
          background-size: 15px;
        }

        .file-input-container {
          position: relative;
          overflow: hidden;
          display: inline-block;
          width: 100%;
        }

        .file-input {
          position: absolute;
          left: 0;
          top: 0;
          opacity: 0;
          width: 100%;
          height: 100%;
          cursor: pointer;
        }

        .file-input-label {
          display: block;
          padding: 12px 15px;
          border: 1px dashed #ddd;
          border-radius: 5px;
          text-align: center;
          transition: var(--transition);
        }

        .file-input-label:hover {
          border-color: var(--secondary-accent);
          background-color: rgba(206, 64, 213, 0.05);
        }

        .file-input-name {
          margin-top: 10px;
          font-size: 0.9rem;
          color: #666;
        }

        .btn-submit {
          background-color: var(--primary-accent);
          color: var(--primary-dark);
          border: none;
          padding: 12px 30px;
          border-radius: 50px;
          font-size: 1rem;
          font-weight: 600;
          cursor: pointer;
          transition: var(--transition);
          display: block;
          width: 100%;
          margin-top: 1rem;
          box-shadow: var(--shadow);
        }

        .btn-submit:hover {
          background-color: var(--secondary-accent);
          color: var(--text-light);
          transform: translateY(-2px);
        }

        /* Preview gambar */
        .image-preview {
          max-width: 100%;
          max-height: 200px;
          margin-top: 15px;
          display: none;
          border-radius: 5px;
          box-shadow: var(--shadow);
        }

        /* ===== FOOTER ===== */
        .footer {
          background-color: var(--primary-dark);
          color: var(--text-light);
          padding: 1.5rem 0;
          text-align: center;
          border-radius: 10px;
        }

        .footer p {
          opacity: 0.8;
          font-size: 0.9rem;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
          .container {
            width: 95%;
          }
          
          .header h1 {
            font-size: 1.5rem;
          }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Tambah <span>Menu</span> Baru</h1>
            <a href="read.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Menu
            </a>
        </header>

        <main>
            <div class="form-container">
                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Menu</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" class="form-control" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="dessert">Dessert</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="gambar">Gambar Menu</label>
                        <div class="file-input-container">
                            <input type="file" id="gambar" name="gambar" class="file-input" accept="image/*" required
                                   onchange="document.getElementById('file-name').textContent = this.files[0].name;
                                             previewImage(this);">
                            <label for="gambar" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i> Pilih Gambar
                                <div id="file-name" class="file-input-name">Belum ada file dipilih</div>
                            </label>
                        </div>
                        <img id="image-preview" class="image-preview" alt="Preview Gambar">
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Menu
                    </button>
                </form>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Delicious Bites. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Fungsi untuk preview gambar sebelum upload
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
        
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const harga = document.getElementById('harga').value;
            if (harga <= 0) {
                alert('Harga harus lebih dari 0');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>