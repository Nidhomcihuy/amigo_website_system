<?php
// admin/edit_cake.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// 1. Koneksi Database
include('../includes/db_config.php');

// 2. Ambil SEMUA Data Produk
$all_cakes = [];
$sql_all = "SELECT ID_PRODUCT, NAMA_PRODUCT, HARGA, PATH_GAMBAR, KATEGORI_PRODUCT 
            FROM product
            ORDER BY KATEGORI_PRODUCT, NAMA_PRODUCT"; 
$result_all = $conn->query($sql_all);

if ($result_all && $result_all->num_rows > 0) {
    while($row = $result_all->fetch_assoc()) {
        $all_cakes[] = $row;
    }
}

// 3. Ambil daftar kategori unik untuk navigasi tab
$categories = [];
$sql_cat = "SELECT DISTINCT KATEGORI_PRODUCT FROM product ORDER BY KATEGORI_PRODUCT";
$result_cat = $conn->query($sql_cat);
if ($result_cat) {
    while($row_cat = $result_cat->fetch_assoc()) {
        $categories[] = $row_cat['KATEGORI_PRODUCT'];
    }
}

$conn->close();

// Data pengguna yang sudah diverifikasi tersedia melalui: $_SESSION
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Admin');
$user_initial = urlencode($_SESSION['nama'] ?? 'Admin');

// Set halaman aktif untuk sidebar
$current_page = 'edit_cake'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Edit Cake</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> <link rel="stylesheet" href="../css/edit-cake.css">     </head>
<body>
    <?php 
    // MENGGUNAKAN INCLUDE SIDEBAR
    include('includes/sidebar-admin.php'); 
    ?>

    <div class="main-content">
    
        <?php include('includes/topbar.php'); ?>

        <div class="hero-banner-edit">
            <div class="hero-content">
            </div>
        </div>
        
        <div class="content-wrapper">
            
            <div class="left-content" style="flex: 2;"> 
                
                <div class="category-tabs">
                    <div class="category-tab active" data-category="All">All</div>
                    <?php 
                    // Tampilkan kategori dinamis dari DB
                    foreach ($categories as $cat): ?>
                        <div class="category-tab" data-category="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></div>
                    <?php endforeach; 
                    // Tampilkan kategori statis yang tidak ada di DB Anda (seperti Soft Cookies)
                    if (!in_array('Soft Cookies', $categories)):
                    ?>
                         <div class="category-tab" data-category="Soft Cookies">Soft Cookies</div>
                    <?php endif; ?>
                </div>

                <div class="product-grid">
                    <?php if (!empty($all_cakes)): ?>
                        <?php foreach ($all_cakes as $cake): 
                            // Mapping Data
                            $product_id = $cake['ID_PRODUCT'];
                            $product_name = $cake['NAMA_PRODUCT'];
                            $product_price = $cake['HARGA'];
                            $image_url = '../' . $cake['PATH_GAMBAR']; // Path relatif ke assets
                            $is_favorite = false; 
                            $rating = 5; 
                            
                            // Baris produk yang menggunakan data dari DB
                            ?>
                            <div class="product-card" data-category="<?= htmlspecialchars($cake['KATEGORI_PRODUCT']) ?>">
                                <div class="product-image">
                                    <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($product_name) ?>">
                                </div>
                                <div class="favorite-btn"><i class="far fa-heart"></i></div>
                                <div class="rating">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star" style="color: <?= $i < $rating ? '#ffc107' : '#e0e0e0' ?>;"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="product-name"><?= htmlspecialchars($product_name) ?></div>
                                <div class="product-footer">
                                    <div class="product-price">$<?= number_format($product_price / 100000, 2) ?></div>
                                    <div class="edit-btn">
                                        <a href="edit_form.php?id=<?= $product_id ?>" style="color: white; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada produk ditemukan untuk diedit.</p>
                    <?php endif; ?>
                </div>
                
                <div style="text-align: right; margin-top: 20px;">
                    <a href="products.php" class="view-all">View all <i class="fas fa-chevron-right"></i></a>
                </div>

            </div>
            
            <?php include('includes/right-sidebar.php'); ?>

        </div>
    </div>

    <script>
        // --- LOGIKA FILTERING KATEGORI DENGAN JAVASCRIPT ---
        const tabs = document.querySelectorAll('.category-tab');
        const productCards = document.querySelectorAll('.product-card');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const selectedCategory = this.getAttribute('data-category');

                productCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    
                    if (selectedCategory === 'All' || cardCategory === selectedCategory) {
                        card.style.display = 'grid'; // Menggunakan grid untuk layout product-card
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // --- Logika toggle favorite (diperlukan karena kartu produk diulang) ---
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                const icon = this.querySelector('i');
                if (this.classList.contains('active')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            });
        });
    </script>
    <?php include('includes/modals/add_cake_modal.php'); ?>
<script src="js/add_cake_modal.js"></script>

</body>
</html>