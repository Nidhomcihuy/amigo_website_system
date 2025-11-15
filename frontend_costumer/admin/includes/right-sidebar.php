<div class="right-sidebar">
    <div class="sidebar-title">penghasilan dari website</div>
    
    <?php
    // Data ini dapat diambil dari database di file utama (dashboard.php)
    $current_balance = 12000; // Contoh data
    ?>
    
    <div class="sidebar-card balance-card">
        <div>Balance</div>
        <div class="balance-amount">Rp <?= number_format($current_balance, 0, ',', '.') ?></div>
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