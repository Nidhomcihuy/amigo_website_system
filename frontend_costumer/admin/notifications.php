<?php
// admin/notifications.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// Data pengguna dari sesi
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Illona');
$user_initial = urlencode($_SESSION['nama'] ?? 'Illona');

// Set halaman aktif untuk sidebar
$current_page = 'notifications'; 

// --- DATA DUMMY NOTIFIKASI (Ganti dengan Query DB nyata) ---
$notifications = [
    [
        'id' => 1,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => '3 hours ago',
        'is_read' => false,
    ],
    [
        'id' => 2,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => '5 hours ago',
        'is_read' => false,
    ],
    [
        'id' => 3,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => 'Yesterday',
        'is_read' => false,
    ],
    [
        'id' => 4,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => 'Yesterday',
        'is_read' => true,
    ],
    [
        'id' => 5,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => '1 week ago',
        'is_read' => true,
    ],
    [
        'id' => 6,
        'title' => 'Add New Menu',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
        'time' => '1 week ago',
        'is_read' => true,
    ],
];

// Hitung notifikasi baru/belum dibaca
$new_notifications_count = count(array_filter($notifications, fn($n) => !$n['is_read']));

// Jika Anda perlu koneksi database, include di sini:
// include('../includes/db_config.php');
// ... (logika pengambilan data dari tabel notifikasi) ...
// $conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
    <link rel="stylesheet" href="../css/notifications.css"> </head>
<body>
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>
        
        <div class="content-wrapper">
            <div class="left-content notifications-content">
                
                <div class="notifications-header-banner">
                    <h2 class="header-title">Notifications</h2>
                </div>
                
                <p class="new-notifications-info">you have **<?= $new_notifications_count ?>** new notifications</p>

                <div class="notifications-toolbar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search">
                    </div>
                    <select class="filter-dropdown">
                        <option value="terbaru">Terbaru</option>
                        <option value="belum-baca">Belum Dibaca</option>
                        <option value="sudah-baca">Sudah Dibaca</option>
                    </select>
                </div>

                <div class="notifications-list">
                    <?php foreach ($notifications as $notification): ?>
                        <div class="notification-card <?= $notification['is_read'] ? 'read' : 'unread' ?>">
                            <div class="card-left">
                                <div class="card-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="card-details">
                                    <div class="card-title"><?= htmlspecialchars($notification['title']) ?></div>
                                    <div class="card-content"><?= htmlspecialchars($notification['content']) ?></div>
                                </div>
                            </div>
                            <div class="card-right">
                                <?php if (!$notification['is_read']): ?>
                                    <button class="mark-read-btn">Mark As Read</button>
                                <?php endif; ?>
                                <div class="card-time">
                                    <i class="fas fa-clock"></i>
                                    <span><?= htmlspecialchars($notification['time']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="pagination">
                    <a href="#" class="page-arrow"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="page-number active">1</a>
                    <a href="#" class="page-number">2</a>
                    <a href="#" class="page-number">3</a>
                    <a href="#" class="page-number">4</a>
                    <a href="#" class="page-arrow"><i class="fas fa-chevron-right"></i></a>
                </div>

            </div>
            
            <?php include('includes/right-sidebar.php'); ?>
            
        </div>
    </div>
    <?php include('includes/modals/add_cake_modal.php'); ?>
<script src="js/add_cake_modal.js"></script>

</body>
</html>