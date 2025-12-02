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

// Build query: LEFT JOIN ke tabel product agar dapat mengambil nama produk & diameter
// Alias kolom product jadi product_name & product_diameter untuk kemudahan
if ($has_status) {
    $statusForTab = ($current_tab === 'history') ? 'Done' : 'Process';
    $sql = "SELECT o.*, p.NAMA_PRODUCT AS product_name, p.DIAMETER_SIZE AS product_diameter
            FROM `orders` o
            LEFT JOIN `product` p ON o.id_product = p.ID_PRODUCT
            WHERE o.status = ?
            ORDER BY o.created_at DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $statusForTab);
} else {
    $sql = "SELECT o.*, p.NAMA_PRODUCT AS product_name, p.DIAMETER_SIZE AS product_diameter
            FROM `orders` o
            LEFT JOIN `product` p ON o.id_product = p.ID_PRODUCT
            ORDER BY o.created_at DESC";
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

            <?php if (!empty($_SESSION['message'])): ?>
                <?php $msg = $_SESSION['message']; unset($_SESSION['message']); ?>
                <div class="message-box <?= strpos($msg, '❌') === 0 ? 'message-error' : 'message-success' ?>">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

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
                            $tanggal = col($order, 'tanggal') ?: col($order, 'order_date') ?: '-';
                            $product_name = col($order, 'product_name') ?: col($order, 'varian') ?: '-';
                            $product_diameter = col($order, 'product_diameter') ?: col($order, 'diameter') ?: '-';
                            $tulisan = col($order, 'tulisan') ?: '-';
                            $harga = col($order, 'harga') ?: col($order, 'total_price') ?: '0';
                            $waktu = col($order, 'waktu') ?: '-';
                            $created_at = col($order, 'created_at') ?: '-';
                            $status = col($order, 'status') ?: '-';
                            // safe id for element/JS (escape quotes)
                            $order_js_id = htmlspecialchars($order_id, ENT_QUOTES);
                        ?>
                        <div class="order-card" data-order-id="<?= $order_js_id ?>">
                            <div class="card-left">
                                <div class="order-details">
                                    <div class="order-id">Order ID : <?= $order_js_id ?></div>
                                    <div class="order-status">Status :
                                        <?php if ($status !== '-'): ?>
                                            <span class="badge status-<?= strtolower(preg_replace('/\s+/', '-', $status)) ?>"><?= $status ?></span>
                                        <?php else: ?>
                                            <span class="badge status-done">—</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="order-total">Nama : <?= $nama_pemesan ?> &nbsp; | &nbsp; Telp : <?= $telp ?></div>
                                    <div class="order-meta" style="margin-top:6px; color:#555; font-size:14px;">
                                        Alamat : <?= $alamat ?> <br>
                                        Produk : <?= $product_name ?> (Diameter: <?= $product_diameter ?> cm) <br>
                                        Tulisan : <?= $tulisan ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-right">
                                <div class="order-date">Tanggal : <?= $tanggal ?><br><small><?= $created_at ?></small></div>
                                <div class="order-actions" style="margin-top:10px;">
                                    <?php if ($current_tab === 'ongoing'): ?>
                                        <!-- Cancel form -->
                                        <form method="post" action="order_actions.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order_js_id ?>">
                                            <input type="hidden" name="action" value="cancel">
                                            <button type="submit" class="action-btn cancel-btn" onclick="return confirm('Batalkan pesanan ini?')">Cancel</button>
                                        </form>

                                        <!-- Hidden form untuk complete (akan disubmit oleh JS dari modal) -->
                                        <form id="completeForm-<?= $order_js_id ?>" method="post" action="order_actions.php" style="display:none;">
                                            <input type="hidden" name="order_id" value="<?= $order_js_id ?>">
                                            <input type="hidden" name="action" value="complete">
                                        </form>

                                        <!-- Button yang membuka modal konfirmasi -->
                                        <button type="button" class="action-btn complete-btn" onclick="openConfirmComplete('<?= $order_js_id ?>')">
                                            Mark As Complete
                                        </button>

                                    <?php else: ?>
                                        <form method="post" action="order_actions.php" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order_js_id ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="action-btn delete-btn" onclick="return confirm('Hapus riwayat pesanan ini?')">Delete</button>
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

<!-- Modal konfirmasi (satu modal global untuk semua pesanan) -->
<div id="confirmCompleteModal" class="confirm-overlay" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
    <div class="confirm-box">
        <h3 id="confirmTitle">Konfirmasi</h3>
        <p id="confirmText">Apakah Anda yakin ingin menandai pesanan ini sebagai <strong>Selesai</strong>?</p>
        <div class="confirm-buttons">
            <button id="confirmYesBtn" class="btn-yes" type="button">Ya</button>
            <button id="confirmNoBtn" class="btn-no" type="button">Tidak</button>
        </div>
    </div>
</div>

<?php include('includes/modals/add_cake_modal.php'); ?>
<script src="../js/add_cake_modal.js"></script>

<script>
// Simple client-side search (filter cards by order id, name, phone, product)
document.getElementById('searchOrders').addEventListener('input', function(e) {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('#ordersList .order-card').forEach(card => {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(q) ? '' : 'none';
    });
});

// Modal confirm logic
let selectedOrderId = null;
const modal = document.getElementById('confirmCompleteModal');
const yesBtn = document.getElementById('confirmYesBtn');
const noBtn = document.getElementById('confirmNoBtn');

function openConfirmComplete(orderId) {
    selectedOrderId = orderId;
    modal.style.display = 'flex';
    // optionally adjust message to include ID
    const txt = document.getElementById('confirmText');
    if (txt) txt.innerHTML = 'Apakah Anda yakin ingin menandai pesanan <strong>' + escapeHtml(orderId) + '</strong> sebagai <strong>Selesai</strong>?';
}

function closeConfirmComplete() {
    selectedOrderId = null;
    modal.style.display = 'none';
}

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

yesBtn.addEventListener('click', function() {
    if (!selectedOrderId) return closeConfirmComplete();
    const form = document.getElementById('completeForm-' + selectedOrderId);
    if (form) {
        form.submit();
    } else {
        // fallback: create form and submit
        const f = document.createElement('form');
        f.method = 'post';
        f.action = 'order_actions.php';
        const oid = document.createElement('input');
        oid.type = 'hidden'; oid.name = 'order_id'; oid.value = selectedOrderId;
        const act = document.createElement('input');
        act.type = 'hidden'; act.name = 'action'; act.value = 'complete';
        f.appendChild(oid); f.appendChild(act);
        document.body.appendChild(f);
        f.submit();
    }
});

noBtn.addEventListener('click', function() {
    closeConfirmComplete();
});

// close modal on overlay click (but not when clicking inside box)
modal.addEventListener('click', function(e) {
    if (e.target === modal) closeConfirmComplete();
});
</script>

</body>
</html>
