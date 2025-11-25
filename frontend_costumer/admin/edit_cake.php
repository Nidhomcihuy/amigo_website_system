<?php
// admin/edit_cake.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// 1. Koneksi Database (Gunakan include_once untuk mencegah Constant errors)
include_once('../includes/db_config.php'); 

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
// Tidak perlu $conn->close() di sini karena kita akan membukanya lagi untuk modal jika diperlukan.

// =========================================================
// 4. LOGIKA PHP UNTUK MENAMPILKAN MODAL EDIT
// =========================================================
$is_modal_active = false;
$product_data_to_edit = null;
$modal_display_style = 'display: none;'; // Default tersembunyi
$message = null; 

// Ambil pesan notifikasi (jika ada setelah proses edit/hapus)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $edit_product_id = (int)$_GET['id'];
    
    // TIDAK PERLU include_once LAGI, karena sudah dimuat di atas.
    // Asumsi: Variabel $conn masih aktif dari include_once di atas.

    // Ambil semua detail produk, termasuk diameter dan deskripsi
    $sql_edit = "SELECT ID_PRODUCT, NAMA_PRODUCT, HARGA, PATH_GAMBAR, KATEGORI_PRODUCT, DIAMETER_SIZE, DESKRIPSI_PRODUCT
                 FROM product 
                 WHERE ID_PRODUCT = ?";
    
    if ($stmt_edit = $conn->prepare($sql_edit)) {
        $stmt_edit->bind_param("i", $edit_product_id);
        $stmt_edit->execute();
        $result_edit = $stmt_edit->get_result();
        
        if ($result_edit->num_rows === 1) {
            $product_data_to_edit = $result_edit->fetch_assoc();
            $is_modal_active = true;
            $modal_display_style = 'display: flex;'; // Tampilkan modal
        }
        $stmt_edit->close();
    } else {
        // Error handling jika query gagal disiapkan
        $message = "❌ Error database saat mengambil data edit.";
    }
    
    // Jangan tutup koneksi ($conn) di sini agar bisa digunakan di bagian HTML di bawah.
}
// =========================================================
$conn->close(); // Tutup koneksi hanya sekali, di sini.

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
    include('includes/sidebar-admin.php'); 
    ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>

        <?php if ($message): ?>
            <div class="toast-notification <?= strpos($message, '✅') !== false || strpos($message, '🗑️') !== false ? 'success' : 'error' ?>">
                <span><?= $message ?></span>
                <span class="close-notification">&times;</span>
            </div>
        <?php endif; ?>

        <div class="hero-banner-edit">
            <div class="hero-content">
            </div>
        </div>
        
        <div class="content-wrapper">
            
            <div class="left-content" style="flex: 2;"> 
                
                <div class="category-tabs">
                    <div class="category-tab active" data-category="All">All</div>
                    <?php 
                    foreach ($categories as $cat): ?>
                        <div class="category-tab" data-category="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></div>
                    <?php endforeach; 
                    if (!in_array('Soft Cookies', $categories)):
                    ?>
                        <div class="category-tab" data-category="Soft Cookies">Soft Cookies</div>
                    <?php endif; ?>
                </div>

                <div class="product-grid">
                    <?php if (!empty($all_cakes)): ?>
                        <?php foreach ($all_cakes as $cake): 
                            $product_id = $cake['ID_PRODUCT'];
                            $product_name = $cake['NAMA_PRODUCT'];
                            $product_price = $cake['HARGA'];
                            $image_url = '../' . $cake['PATH_GAMBAR']; 
                            $is_favorite = false; 
                            $rating = 5; 
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
                                    <div class="product-price">Rp <?= number_format($product_price, 0, ',', '.') ?></div>
                                    <div class="edit-btn">
                                        <a href="edit_cake.php?id=<?= htmlspecialchars($product_id) ?>" style="color: white; display: flex; align-items: center; justify-content: center;">
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
    
    <div id="editProductModal" class="modal" style="<?= $modal_display_style ?>">
        <?php if ($is_modal_active && $product_data_to_edit): 
            $p = $product_data_to_edit;
            $current_image_url = '../' . $p['PATH_GAMBAR'];
            // Kategori statis yang mungkin tidak ada di DB
            $hardcoded_categories = ['Custom Cake', 'Mille Crepes', 'Soft Cookies', 'Cheesecake'];
            $all_possible_categories = array_unique(array_merge($categories, $hardcoded_categories));
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Produk: <?= htmlspecialchars($p['NAMA_PRODUCT']) ?></h2>
                <span class="close-btn modal-close" onclick="window.location.href='edit_cake.php'">&times;</span>
            </div>
            
            <form id="editProductForm" action="edit_product_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($p['ID_PRODUCT']) ?>">
                <input type="hidden" name="old_image_path" value="<?= htmlspecialchars($p['PATH_GAMBAR']) ?>">
                
                <div class="form-body">
                    <div class="form-left">
                        <div class="form-group">
                            <label for="editProductName">Nama Kue</label>
                            <input type="text" id="editProductName" name="product_name" value="<?= htmlspecialchars($p['NAMA_PRODUCT']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="editCategory">Category</label>
                            <select id="editCategory" name="kategori_product" required>
                                <?php foreach ($all_possible_categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat) ?>" 
                                        <?= ($cat === $p['KATEGORI_PRODUCT']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="editPrice">Harga</label>
                            <input type="number" id="editPrice" name="price" value="<?= htmlspecialchars($p['HARGA']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="editDiameter">Diameter (cm)</label>
                            <input type="number" id="editDiameter" name="diameter" value="<?= htmlspecialchars($p['DIAMETER_SIZE']) ?>" min="1">
                        </div>
                        
                        <div class="form-group">
                            <label for="editDescription">Deskripsi</label>
                            <textarea id="editDescription" name="description" rows="3"><?= htmlspecialchars($p['DESKRIPSI_PRODUCT']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-right">
                        <div class="image-upload-area" id="editImageUploadArea">
                            <div class="image-preview" id="editImagePreview">
                                <img src="<?= htmlspecialchars($current_image_url) ?>" alt="Current Product Image">
                            </div>
                            <input type="file" id="editProductImage" name="product_image" accept="image/*" hidden>
                            <label for="editProductImage" class="browse-btn">Ganti Gambar</label>
                            <p class="drag-drop-text">Abaikan jika tidak ada perubahan gambar</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions-custom justify-content-between">
                    <a href="delete_product_process.php?id=<?= htmlspecialchars($p['ID_PRODUCT']) ?>" 
                       class="btn-custom-cancel delete-btn" 
                       onclick="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS produk <?= htmlspecialchars($p['NAMA_PRODUCT']) ?>? Aksi ini tidak bisa dibatalkan.');">
                        Hapus Produk
                    </a>
                    
                    <div style="display: flex; gap: 10px;">
                        <a href="edit_cake.php" class="btn-custom-cancel modal-close" style="text-decoration: none;">Batal</a>
                        <button type="submit" class="btn-custom-add">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
        <?php endif; ?>
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

        // --- LOGIKA IMAGE PREVIEW BARU (untuk modal edit) ---
        document.addEventListener('DOMContentLoaded', function() {
            const editProductImageInput = document.getElementById('editProductImage');
            const editImagePreview = document.getElementById('editImagePreview');
            const editModal = document.getElementById('editProductModal');

            if (editProductImageInput) {
                editProductImageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            editImagePreview.innerHTML = `<img src="${e.target.result}" alt="New Product Image Preview">`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
            
            // --- LOGIKA TUTUP MODAL DENGAN ESC KEY (Opsional) ---
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && editModal.style.display === 'flex') {
                    window.location.href = 'edit_cake.php'; // Mengarahkan ulang untuk menutup modal
                }
            });

            // --- LOGIKA TOAST NOTIFICATION (Pop-up) ---
            const toastNotification = document.querySelector(".toast-notification");

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
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Cake</h2>
                <span class="close-btn">×</span>
            </div>
            
            <form id="addProductForm" action="add_product_process.php" method="POST" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-left">
                        <div class="form-group">
                            <label for="productName">Nama Kue</label>
                            <input type="text" id="productName" name="product_name" required="">
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="kategori_product" required="">
                                <option value="">Pilih Kategori</option>
                                <option value="Custom Cake">Custom Cake 🎂</option>
                                <option value="Mille Crepes">Mille Crepes 🍰</option>
                                <option value="Soft Cookies">Soft Cookies 🍪</option>
                                <option value="Cheesecake">Cheesecake 🧁</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="number" id="price" name="price" required="">
                        </div>
                        
                        <div class="form-group">
                            <label for="diameter">Diameter (cm)</label>
                            <input type="number" id="diameter" name="diameter" placeholder="Contoh: 18" min="1" required="">
                        </div>
                    </div>

                    <div class="form-right">
                        <div class="image-upload-area" id="imageUploadArea">
                            <div class="image-preview" id="imagePreview">
                                <i class="fas fa-image fa-3x placeholder-icon"></i>
                            </div>
                            <input type="file" id="productImage" name="product_image" accept="image/*" hidden="" required="">
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
    <script src="js/add_cake_modal.js"></script>

</body>
</html>