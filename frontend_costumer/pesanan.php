<?php
session_start();
require_once "includes/db_config.php";

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil semua pesanan milik user
$sql = "SELECT * FROM orders WHERE id_users = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

// Jika ada detail order yang dipilih
$selectedOrder = null;
if (isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];

    // Ambil detail orders
    $detailQuery = "SELECT * FROM orders WHERE id = ? AND id_users = ?";
    $detailStmt = $conn->prepare($detailQuery);
    $detailStmt->bind_param("ii", $order_id, $user_id);
    $detailStmt->execute();
    $selectedOrder = $detailStmt->get_result()->fetch_assoc();

    // Ambil metode pembayaran
    $payQuery = "SELECT metode FROM payments WHERE order_id = ?";
    $payStmt = $conn->prepare($payQuery);
    $payStmt->bind_param("i", $order_id);
    $payStmt->execute();
    $payment = $payStmt->get_result()->fetch_assoc();

    $selectedOrder['metode_bayar'] = $payment ? $payment['metode'] : "Belum bayar";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | Amigo Cake</title>
    <link rel="stylesheet" href="css/pesanan.css?v=<?php echo time(); ?>">
</head>

<body>

<div class="container">

    <!-- Tombol kembali -->
    <a href="menu.php" class="btn-kembali">← Kembali ke Menu</a>

    <div class="left-section">
        <h2>Pesanan saya</h2>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($row = $orders->fetch_assoc()): ?>
                <a href="pesanan.php?order_id=<?= $row['id']; ?>" class="order-card">

                    <div class="checkbox"></div>

                    <div class="order-info">
                        <p class="order-name"><?= $row['varian']; ?> (<?= $row['diameter']; ?> cm)</p>
                        <p class="order-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                        <p class="order-qty">Jumlah : 1</p>
                    </div>

                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada pesanan.</p>
        <?php endif; ?>
    </div>

    <!-- Panel kanan -->
    <div class="right-section">
        <h2>Detail</h2>

        <div class="detail-box">
            <?php if ($selectedOrder): ?>
                <p><strong>Nama Cake :</strong> <?= $selectedOrder['varian']; ?></p>

                <p><strong>Diameter :</strong> <?= $selectedOrder['diameter']; ?> cm</p>

                <p><strong>Tulisan Cake :</strong><br>
                <?= $selectedOrder['tulisan']; ?></p>

                <p><strong>Tanggal Pengambilan :</strong> <?= $selectedOrder['tanggal']; ?></p>

                <p><strong>Jam Pengambilan :</strong> <?= $selectedOrder['waktu']; ?></p>

                <p><strong>Jumlah Pesanan :</strong> 1 Cake</p>

                <p><strong>Status Pesanan :</strong> Proses</p>

                <p><strong>Harga :</strong> Rp <?= number_format($selectedOrder['harga'], 0, ',', '.'); ?></p>

                <p><strong>Metode Bayar :</strong> <?= $selectedOrder['metode_bayar']; ?></p>

            <?php else: ?>
                <p>Pilih salah satu pesanan di kiri untuk melihat detail.</p>
            <?php endif; ?>
        </div>

    </div>

</div>

</body>
</html>
