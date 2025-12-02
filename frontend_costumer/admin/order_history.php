<?php
// admin/order_history.php
session_start();
include('../includes/db_config.php'); // pastikan $conn (mysqli) tersedia

// --- Autentikasi dan Proteksi Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Admin');
$current_page = 'order_history';

// Tab: 'ongoing' atau 'history'
$current_tab = isset($_GET['tab']) && $_GET['tab'] === 'history' ? 'history' : 'ongoing';

// Helper untuk aman ambil kolom
function col($row, $name, $fallback = '') {
    return isset($row[$name]) ? htmlspecialchars((string)$row[$name]) : $fallback;
}

// Cek apakah kolom "status" ada di tabel orders
$has_status = false;
$colCheck = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'status'");
if ($colCheck && $colCheck->num_rows > 0) {
    $has_status = true;
}

// Build query
if ($has_status) {
    // kita pakai status umum: 'Process' untuk ongoing, 'Done' untuk history
    $statusForTab = ($current_tab === 'history') ? 'Done' : 'Process';
    $sql = "SELECT * FROM `orders` WHERE `status` = ? ORDER BY `created_at` DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $statusForTab);
} else {
    // fallback: ambil semua order, urutkan newest first
    $sql = "SELECT * FROM `orders` ORDER BY `created_at` DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Amigo Cake Admin - Order History</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/admindashboard.css">
<link rel="stylesheet" href="../css/order_history.css">
<style>

</style>
</head>
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
                <input id="searchOrders" type="text" placeholder="Look For Order History...">
            </div>

            <div class="tab-switcher">
                <a href="?tab=ongoing" class="tab-btn <?= $current_tab === 'ongoing' ? 'active' : '' ?>">Ongoing</a>
                <a href="?tab=history" class="tab-btn <?= $current_tab === 'history' ? 'active' : '' ?>">History</a>
            </div>

            <div class="orders-list" id="ordersList">
                <?php if (empty($orders)): ?>
                    <p class="no-orders">Tidak ada pesanan di tab ini.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <?php
                            // Ambil beberapa kolom umum (fallback bila nama kolom berbeda)
                            $order_id = col($order, 'id') ?: col($order, 'order_id') ?: col($order, 'id_orders') ?: '—';
                            $nama_pemesan = col($order, 'nama_pemesan') ?: col($order, 'customer_name') ?: '—';
                            $telp = col($order, 'telp') ?: col($order, 'phone') ?: '-';
                            $alamat = col($order, 'alamat') ?: col($order, 'address') ?: '-';
                            $tanggal = col($order, 'tanggal') ?: col($order, 'order_date') ?: col($order, 'created_at') ?: '-';
                            $diameter = col($order, 'diameter') ?: '-';
                            $varian = col($order, 'varian') ?: '-';
                            $tulisan = col($order, 'tulisan') ?: '-';
                            $harga = col($order, 'harga') ?: col($order, 'total_price') ?: '0';
                            $waktu = col($order, 'waktu') ?: '-';
                            $created_at = col($order, 'created_at') ?: '-';
                            $status = col($order, 'status') ?: '-';
                        ?>
                        <div class="order-card" data-order-id="<?= $order_id ?>">
                            <div class="card-left">
                                <div class="order-details">
                                    <div class="order-id">Order ID : <?= $order_id ?></div>
                                    <div class="order-status">Status : 
                                        <?php if ($status !== '-'): ?>
                                            <span class="badge status-<?= strtolower($status) ?>"><?= $status ?></span>
                                        <?php else: ?>
                                            <span class="badge status-done">—</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="order-total">Nama : <?= $nama_pemesan ?> &nbsp; | &nbsp; Telp : <?= $telp ?></div>
                                    <div class="order-meta" style="margin-top:6px; color:#555; font-size:14px;">
                                        Alamat : <?= $alamat ?> <br>
                                        Produk : <?= $varian ?> (Diameter: <?= $diameter ?> cm) <br>
                                        Tulisan : <?= $tulisan ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-right">
                                <div class="order-date">Tanggal : <?= $tanggal ?><br><small><?= $created_at ?></small></div>
                                <div class="order-actions" style="margin-top:10px;">
                                    <?php if ($current_tab === 'ongoing'): ?>
                                        <form method="post" action="order_actions.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                            <button type="submit" name="action" value="cancel" class="action-btn cancel-btn" onclick="return confirm('Batalkan pesanan ini?')">Cancel</button>
                                        </form>
                                        <form method="post" action="order_actions.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                            <button type="submit" name="action" value="complete" class="action-btn complete-btn">Mark As Complete</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="post" action="order_actions.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                            <button type="submit" name="action" value="delete" class="action-btn delete-btn" onclick="return confirm('Hapus riwayat pesanan ini?')">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

        <?php include('includes/right-sidebar.php'); ?>

    </div>
</div>

<?php include('includes/modals/add_cake_modal.php'); ?>
<script src="../js/add_cake_modal.js"></script>

<script>
// Simple client-side search (filter cards by order id, name, phone)
document.getElementById('searchOrders').addEventListener('input', function(e) {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('#ordersList .order-card').forEach(card => {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(q) ? '' : 'none';
    });
});
</script>

</body>
</html>
