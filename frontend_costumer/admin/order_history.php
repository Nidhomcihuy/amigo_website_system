<?php
// admin/order_history.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
// Asumsi sudah ada logika autentikasi
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    // header("Location: login.php");
    // exit;
}

// Data pengguna dummy
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Illona');
$user_initial = urlencode($_SESSION['nama'] ?? 'Illona');

// Set halaman aktif untuk sidebar
$current_page = 'order_history'; 

// --- Logika Tab ---
$current_tab = isset($_GET['tab']) && $_GET['tab'] === 'history' ? 'history' : 'ongoing';

// --- DATA DUMMY PESANAN (Ganti dengan Query DB nyata) ---

// Data Ongoing (Status: Process) - Dari oder history (1).png
$orders_ongoing = [
    ['id' => 'ALV0987664', 'status' => 'Process', 'total_cake' => 2, 'date' => '09-10-2025'],
    ['id' => 'ALV0987665', 'status' => 'Process', 'total_cake' => 3, 'date' => '09-10-2025'],
    ['id' => 'ALV0987666', 'status' => 'Process', 'total_cake' => 1, 'date' => '09-10-2025'],
    ['id' => 'ALV0987667', 'status' => 'Process', 'total_cake' => 2, 'date' => '09-10-2025'],
];

// Data History (Status: Done) - Dari oder history.png
$orders_history = [
    ['id' => 'ALV0987650', 'status' => 'Done', 'total_cake' => 2, 'date' => '08-10-2025'],
    ['id' => 'ALV0987651', 'status' => 'Done', 'total_cake' => 1, 'date' => '08-10-2025'],
    ['id' => 'ALV0987652', 'status' => 'Done', 'total_cake' => 4, 'date' => '07-10-2025'],
    ['id' => 'ALV0987653', 'status' => 'Done', 'total_cake' => 3, 'date' => '07-10-2025'],
];

$orders_to_display = ($current_tab === 'history') ? $orders_history : $orders_ongoing;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Order History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
    <link rel="stylesheet" href="../css/order_history.css"> </head>
<body>
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>
        
        <div class="content-wrapper">
            <div class="left-content order-history-content">
                
                <div class="order-history-header-banner">
                    <h2 class="header-title">Order History</h2>
                </div>
                
                
                <div class="search-bar-container">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Look For Order History...">
                </div>

                <div class="tab-switcher">
                    <a href="?tab=ongoing" class="tab-btn <?= $current_tab === 'ongoing' ? 'active' : '' ?>">Ongoing</a>
                    <a href="?tab=history" class="tab-btn <?= $current_tab === 'history' ? 'active' : '' ?>">History</a>
                </div>

                <div class="orders-list">
                    <?php foreach ($orders_to_display as $order): ?>
                        <div class="order-card">
                            <div class="card-left">
                                <div class="order-details">
                                    <div class="order-id">Order ID : **<?= htmlspecialchars($order['id']) ?>**</div>
                                    <div class="order-status">Status : <span class="status-<?= strtolower($order['status']) ?>">**<?= htmlspecialchars($order['status']) ?>**</span></div>
                                    <div class="order-total">Total Order : **<?= htmlspecialchars($order['total_cake']) ?>** Cake</div>
                                </div>
                            </div>
                            <div class="card-right">
                                <div class="order-date">Date : **<?= htmlspecialchars($order['date']) ?>**</div>
                                <div class="order-actions">
                                    <?php if ($current_tab === 'ongoing'): ?>
                                        <button class="action-btn cancel-btn">Cancel</button>
                                        <button class="action-btn complete-btn">Mark As Complete</button>
                                    <?php else: ?>
                                        <button class="action-btn delete-btn">Delete</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($orders_to_display)): ?>
                        <p class="no-orders">Tidak ada pesanan di tab ini.</p>
                    <?php endif; ?>
                </div>

            </div>
            
            <?php include('includes/right-sidebar.php'); ?>
            
        </div>
    </div>
</body>
</html>