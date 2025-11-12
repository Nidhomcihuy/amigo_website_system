<?php 
// PASTIKAN SEMUA VARIABEL BERIKUT TELAH DI-DEFINISIKAN SEBELUM BARIS 'include' di dashboard.php
// Contoh variabel yang harus dikirim dari dashboard.php:
// $product_id, $product_name, $product_price, $image_url, $is_favorite, $rating
?>

<div class="product-card">
    <div class="product-image">
        <img 
            src="<?= htmlspecialchars($image_url) ?>" 
            alt="<?= htmlspecialchars($product_name) ?>"
        >
    </div>
    
    <div class="favorite-btn <?= $is_favorite ? 'active' : '' ?>">
        <i class="<?= $is_favorite ? 'fas' : 'far' ?> fa-heart"></i>
    </div>
    
    <div class="rating">
        <?php 
        // Melakukan loop 5 kali untuk menampilkan bintang
        for ($i = 1; $i <= 5; $i++): 
            // Warna bintang: emas (#ffc107) jika $i <= $rating, atau abu-abu
            $star_color = ($i <= $rating) ? '#ffc107' : '#e0e0e0';
        ?>
            <i class="fas fa-star" style="color: <?= $star_color ?>;"></i>
        <?php endfor; ?>
    </div>
    
    <div class="product-name"><?= htmlspecialchars($product_name) ?></div>
    
    <div class="product-footer">
        <div class="product-price">Rp <?= number_format($product_price, 0, ',', '.') ?></div>
        
        <div class="edit-btn">
            <a href="edit_product.php?id=<?= $product_id ?>" style="color: white; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-pen"></i>
            </a>
        </div>
    </div>
</div>