<?php 
// Variabel $current_page harus diset di file utama (dashboard.php, total_order.php, dll.)
$active_page = $current_page ?? 'dashboard';
?>
<div class="sidebar">
    <div class="logo">
        <img src="../image_costumer/amigo.svg" alt="Amigo Cake Logo" class="logo-img">
    </div>

    <nav>
        <a href="dashboard.php" class="menu-item <?= $active_page === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="total_order.php" class="menu-item <?= $active_page === 'total_order' ? 'active' : '' ?>">
            <i class="fas fa-shopping-bag"></i>
            <span>Total Order</span>
        </a>
        
        <a href="edit_cake.php" class="menu-item <?= $active_page === 'edit_cake' ? 'active' : '' ?>">
            <i class="fas fa-cake-candles"></i>
            <span>Edit Cake</span>
        </a>
        
        <a href="notifications.php" class="menu-item <?= $active_page === 'notifications' ? 'active' : '' ?>">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>
        
        <a href="order_history.php" class="menu-item <?= $active_page === 'order_history' ? 'active' : '' ?>">
            <i class="fas fa-clock-rotate-left"></i>
            <span>Order History</span>
        </a>
        
        <a href="account.php" class="menu-item <?= $active_page === 'account' ? 'active' : '' ?>">
            <i class="fas fa-gear"></i>
            <span>Settings</span>
        </a>
        
        <a href="logout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>