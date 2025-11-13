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
    <?php
if (isset($_GET['go']) && $_GET['go'] === 'order') {
    header("Location: total_order.php");
    exit();
}
?>
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Cake</h2>
                <span class="close-btn">&times;</span>
            </div>
            
            <form id="addProductForm" action="add_product_process.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-body">
                    <div class="form-left">
                        <div class="form-group">
                            <label for="productName">Nama Kue</label>
                            <input type="text" id="productName" name="product_name" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="kategori_product" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Custom Cake">Custom Cake 🎂</option>
                                <option value="Mille Crepes">Mille Crepes 🍰</option>
                                <option value="Soft Cookies">Soft Cookies 🍪</option>
                                <option value="Cheesecake">Cheesecake 🧁</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="number" id="price" name="price" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="diameter">Diameter (cm)</label>
                            <input type="number" id="diameter" name="diameter" placeholder="Contoh: 18" min="1" required>
                        </div>
                    </div>

                    <div class="form-right">
                        <div class="image-upload-area" id="imageUploadArea">
                            <div class="image-preview" id="imagePreview">
                                <i class="fas fa-image fa-3x placeholder-icon"></i>
                            </div>
                            <input type="file" id="productImage" name="product_image" accept="image/*" hidden required>
                            <label for="productImage" class="browse-btn">Browse Files</label>
                            <p class="drag-drop-text">Drag and drop files here</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions-custom">
                    <button type="button" class="btn-custom-cancel cancel-btn">Cancel</button>
                    <button type="submit" class="btn-custom-add">Add</button>
                </div>
            </form>
        </div>
    </div>
    <?php if ($message): ?>
        <div class="toast-notification <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
            <span><?= $message ?></span>
            <span class="close-notification">&times;</span>
        </div>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById("addProductModal");
            const addCakeBtn = document.querySelector(".add-cake-btn"); 
            const closeBtn = document.querySelector(".close-btn");
            const cancelBtn = document.querySelector(".btn-custom-cancel"); 
            
            const productImageInput = document.getElementById('productImage');
            const imagePreview = document.getElementById('imagePreview');
            const imageUploadArea = document.getElementById('imageUploadArea');

            const toastNotification = document.querySelector(".toast-notification");

            // --- FUNGSI MODAL ---
            function openModal() {
                modal.style.display = "flex"; 
            }
            
            function closeModal() {
                modal.style.display = "none";
                document.getElementById('addProductForm').reset();
                imagePreview.innerHTML = '<i class="fas fa-image fa-3x placeholder-icon"></i>';
                imageUploadArea.classList.remove('has-image'); 
            }

            if (addCakeBtn) {
                addCakeBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    openModal();
                });
            }
            if (closeBtn) {closeBtn.addEventListener('click', closeModal);}
            if (cancelBtn) {cancelBtn.addEventListener('click', closeModal);}

            window.addEventListener('click', function(event) {
                if (event.target == modal) {closeModal();}
            });

            // --- LOGIC IMAGE PREVIEW ---
            productImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Product Image Preview">`;
                        imageUploadArea.classList.add('has-image'); 
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreview.innerHTML = '<i class="fas fa-image fa-3x placeholder-icon"></i>';
                    imageUploadArea.classList.remove('has-image');
                }
            });

            // Logic Drag and Drop
            imageUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                imageUploadArea.style.borderColor = '#ccc';
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    productImageInput.files = files; 
                    productImageInput.dispatchEvent(new Event('change')); 
                }
            });
            imageUploadArea.addEventListener('dragover', (e) => {e.preventDefault(); imageUploadArea.style.borderColor = '#8B0000';});
            imageUploadArea.addEventListener('dragleave', () => {imageUploadArea.style.borderColor = '#ccc';});
            
            // --- LOGIC TOAST NOTIFICATION ---
            if (toastNotification) {
                // Tampilkan toast dengan delay kecil untuk memicu transisi
                setTimeout(() => {
                    toastNotification.style.opacity = 1;
                    toastNotification.style.transform = 'translateY(0)';
                }, 100); 

                const closeToastBtn = toastNotification.querySelector(".close-notification");

                function hideToast() {
                    toastNotification.style.opacity = 0;
                    toastNotification.style.transform = 'translateY(50px)';
                    setTimeout(() => {
                        toastNotification.style.display = 'none';
                    }, 500); 
                }

                const autoHideTimer = setTimeout(hideToast, 4000); 

                if (closeToastBtn) {
                    closeToastBtn.addEventListener('click', () => {
                        clearTimeout(autoHideTimer); 
                        hideToast();
                    });
                }
            }
        });
    </script>
</body>
</html>