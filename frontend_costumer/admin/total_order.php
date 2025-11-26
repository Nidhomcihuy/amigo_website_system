<?php
// admin/total_order.php
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// 1. Koneksi Database (Jika diperlukan untuk data dinamis)
include('../includes/db_config.php');

// --- DATA DUMMY UNTUK STATISTIK (Ganti dengan Query DB nyata) ---
// Contoh: Mengambil data dari tabel order
$total_pendapatan = 1500000;
$kenaikan_pendapatan = 15000; 
$total_order = 251;

// Data untuk Chart (Ganti dengan hasil query data bulanan)
$data_chart = [26, 22, 25, 25, 17, 19]; 
$labels = ['11 nov', '12 nov', '13 nov', '14 nov', '15 nov', '16 nov'];

// Data pengguna dari sesi
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Illona');
$user_initial = urlencode($_SESSION['nama'] ?? 'Illona');

// Set halaman aktif untuk sidebar
$current_page = 'total_order'; 

// Tutup koneksi (disarankan)
$pdo = null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Total Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
    <link rel="stylesheet" href="../css/total-order-stats.css"> </head>
<body>
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>

        <div class="info-greeting">this is what's happening in your store this months</div>

        <div class="stats-grid">
            
            <div class="stat-card pendapatan-card">
                <div class="stat-title">total pendapatan</div>
                <div class="stat-value">Rp. **<?= number_format($total_pendapatan, 0, ',', '.') ?>**</div>
                <div class="stat-footer">
                    <span class="stat-badge">+<?= number_format($kenaikan_pendapatan, 0, ',', '.') ?></span>
                    <span class="stat-time">Bulan ini</span>
                </div>
            </div>

            <div class="stat-card order-card">
                <div class="stat-title">total order</div>
                <div class="stat-value big-value"><?= $total_order ?></div>
                <div class="stat-footer">
                    <span class="stat-time">Bulan ini</span>
                </div>
            </div>

        </div>

        <div class="chart-container">
            <div class="chart-bar-area">
                
                <div class="chart-y-axis">
                    <?php for ($i = 25; $i >= 1; $i -= 5): ?>
                        <span><?= $i ?></span>
                    <?php endfor; ?>
                    <span>1</span>
                </div>

                <div class="chart-bars">
                    <?php 
                    $max_val = max($data_chart) + 5; // Untuk skala chart
                    foreach ($data_chart as $index => $value): 
                        // Menghitung tinggi bar berdasarkan persentase
                        $height = ($value / $max_val) * 100;
                    ?>
                        <div class="bar-wrapper">
                            <div class="bar" style="height: <?= $height ?>%;"></div>
                            <div class="bar-label"><?= $labels[$index] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

    </div>
</body>
</html>