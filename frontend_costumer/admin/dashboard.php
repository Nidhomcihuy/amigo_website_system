<?php
// admin/dashboard.php

// PENTING: Selalu mulai sesi di awal file
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    // Jika belum login atau bukan admin, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// 4. Ambil dan Hapus Pesan Sesi untuk notifikasi Toast
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}

// Data pengguna yang sudah diverifikasi sekarang tersedia melalui:
// $_SESSION['id'], $_SESSION['nama'], $_SESSION['username'], $_SESSION['level']

// ... (lanjutkan kode koneksi database Anda) ...
include('../includes/db_config.php');

// 2. Ambil Data Populer (ID 1, 2, 3)
$popular_cakes = [];
$sql_popular = "SELECT ID_PRODUCT, NAMA_PRODUCT, HARGA, PATH_GAMBAR, KATEGORI_PRODUCT 
                FROM product 
                WHERE ID_PRODUCT IN (1, 2, 3) 
                LIMIT 3"; 
$result_popular = $conn->query($sql_popular);

if ($result_popular && $result_popular->num_rows > 0) {
    while($row = $result_popular->fetch_assoc()) {
        $popular_cakes[] = $row;
    }
}

// 3. Ambil Data Varian (MENGGUNAKAN KATEGORI MILLE CREPES)
$variant_cakes = [];
$sql_variant = "SELECT ID_PRODUCT, NAMA_PRODUCT, HARGA, PATH_GAMBAR, KATEGORI_PRODUCT
                FROM product 
                WHERE KATEGORI_PRODUCT = 'Custom Cake'
                LIMIT 3"; 

$result_variant = $conn->query($sql_variant);

if ($result_variant && $result_variant->num_rows > 0) {
    while($row = $result_variant->fetch_assoc()) {
        $variant_cakes[] = $row;
    }
}

// Catatan: Pastikan $conn->close() dijalankan di akhir sesi atau footer.
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
</head>
<body>
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>

        <div class="hero-banner">
            <div class="hero-content">
                <h1>Amigo Cake Admin</h1>
                <p>Arrange your cake and add the cake</p>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="left-content">
                <div class="section-header">
                    <h2 class="section-title">Category</h2>
                    <a href="categories.php" class="view-all">
                        View all <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Category or Menu...">
                </div>
                <div class="category-grid">
                    <div class="category-card"><div class="category-icon">🎂</div><div class="category-name">costum cake</div></div>
                    <div class="category-card"><div class="category-icon">🍰</div><div class="category-name">millecrepes</div></div>
                    <div class="category-card"><div class="category-icon">🍪</div><div class="category-name">cookies</div></div>
                    <div class="category-card"><div class="category-icon">🎂</div><div class="category-name">soft cake</div></div>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Popular Dishes</h2>
                    <a href="products.php?popular=true" class="view-all">
                        View all <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <div class="product-grid">
                    <?php if (!empty($popular_cakes)): ?>
                        <?php foreach ($popular_cakes as $cake): 
                            $product_id = $cake['ID_PRODUCT'];
                            $product_name = $cake['NAMA_PRODUCT'];
                            $product_price = $cake['HARGA'];
                            $image_url = '../' . $cake['PATH_GAMBAR']; 
                            $is_favorite = true; 
                            $rating = 5;         
                            include('templates/product_card.php'); 
                        endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada produk populer ditemukan.</p>
                    <?php endif; ?>
                </div>

                <div class="section-header">
                    <h2 class="section-title">variant cake</h2>
                    <a href="products.php?category=variant" class="view-all">
                        View all <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <div class="product-grid">
                    <?php if (!empty($variant_cakes)): ?>
                        <?php foreach ($variant_cakes as $cake): 
                            $product_id = $cake['ID_PRODUCT'];
                            $product_name = $cake['NAMA_PRODUCT'];
                            $product_price = $cake['HARGA'];
                            $image_url = '../' . $cake['PATH_GAMBAR'];
                            $is_favorite = false; 
                            $rating = 0; 
                            include('templates/product_card.php'); 
                        endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada varian kue ditemukan. Cek nama KATEGORI_PRODUCT di database.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('includes/right-sidebar.php'); ?>
        </div>
    </div>
   
 <?php include('includes/modals/add_cake_modal.php'); ?>
<script src="js/add_cake_modal.js"></script>


    
</body>
</html>