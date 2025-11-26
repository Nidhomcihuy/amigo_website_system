<?php
// admin/edit_galery.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// 1. Koneksi Database (Gunakan include_once untuk mencegah Constant errors)
// Walaupun halaman ini mungkin tidak perlu data DB, ini adalah praktik yang baik.
include_once('../includes/db_config.php'); 

// Set halaman aktif untuk sidebar
$current_page = 'edit_galery'; 

// Data pengguna yang sudah diverifikasi tersedia melalui: $_SESSION
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Admin');
$user_initial = urlencode($_SESSION['nama'] ?? 'Admin');

// Asumsi: Koneksi $pdo akan ditutup di akhir file jika dibuka.
// Karena kita hanya menggunakan include_once di awal, tidak perlu menutupnya di sini.
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Edit Galery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
    <link rel="stylesheet" href="../css/edit-galery.css"> 
</head>
<body>
    
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>

        <div class="hero-banner-edit-galery">
            <div class="hero-content">
                <i class="fas fa-image"></i>
                <h2>Edit Galery</h2>
            </div>
        </div>
        
        <div class="content-wrapper">
            
            <div class="left-content" style="flex: 2;"> 
                
                <form id="editGaleryForm" action="process_galery.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="galery-form-card">
                        
                        <div class="image-upload-area large-area">
                            <div class="image-preview large-preview" id="imagePreview">
                                <i class="fas fa-image fa-4x placeholder-icon"></i>
                            </div>
                            <input type="file" id="galeryImage" name="galery_image" accept="image/*" hidden required>
                            <label for="galeryImage" class="browse-btn">Browse Files</label>
                            <p class="drag-drop-text">Drag and drop files here</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="namaKegiatan">Nama Kegiatan</label>
                            <input type="text" id="namaKegiatan" name="nama_kegiatan" placeholder="Masukkan deskripsi atau nama acara" required>
                        </div>

                        <div class="form-actions-galery">
                            <button type="button" class="btn-custom-cancel">Cancel</button>
                            <button type="submit" class="btn-custom-add">Add</button>
                        </div>

                    </div>
                </form>
            </div>
            
            <?php include('includes/right-sidebar.php'); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk menampilkan preview gambar
            const galeryImageInput = document.getElementById('galeryImage');
            const imagePreview = document.getElementById('imagePreview');

            galeryImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Galery Image Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreview.innerHTML = `<i class="fas fa-image fa-4x placeholder-icon"></i>`;
                }
            });
        });
    </script>
</body>
</html>