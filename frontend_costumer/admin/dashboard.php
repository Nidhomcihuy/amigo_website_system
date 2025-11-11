<?php
// admin/dashboard.php

// 1. Koneksi Database - Keluar satu level (../) dari folder admin
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
                WHERE KATEGORI_PRODUCT = 'Mille Crepes' /* <--- PERBAIKAN KATEGORI */
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
                            // PATH GAMBAR: Menambahkan '../' di depan path DB
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
                            // PATH GAMBAR: Menambahkan '../' di depan path DB
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

            <div class="right-sidebar">
                <div class="sidebar-title">penghasilan dari website</div>
                
                <?php
                $current_balance = 12000.00; // Contoh data
                ?>
                <div class="sidebar-card balance-card">
                    <div>Balance</div>
                    <div class="balance-amount">Rp **<?= number_format($current_balance, 0, ',', '.') ?>**</div>
                    <div class="balance-actions">
                        <button class="action-btn">
                            <i class="fas fa-arrow-up"></i>
                            <span>Top Up</span>
                        </button>
                        <button class="action-btn">
                            <i class="fas fa-arrow-right-arrow-left"></i>
                            <span>Transfer</span>
                        </button>
                    </div>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-title">Your Address</div>
                    <div class="address-info">
                        <i class="fas fa-location-dot"></i>
                        <div class="address-text">
                            <div class="address-title">Jl.Barito IVA No. 19 Keringan, Nganjuk</div>
                            <div class="address-detail">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</div>
                        </div>
                    </div>
                    <div class="address-actions">
                        <button class="outline-btn">Add Details</button>
                        <button class="outline-btn">Add Note</button>
                    </div>
                </div>

                <a href="add_product.php" class="add-cake-btn" style="text-align: center; text-decoration: none; display: block;">Add cake</a>
            </div>
        </div>
    </div>
    
    <script>
        // ... Kode JavaScript Anda ...
    </script>
</body>
</html>