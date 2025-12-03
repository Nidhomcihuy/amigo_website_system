<?php
session_start();
require_once "includes/db_config.php";

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ===============================
// AMBIL LIST PESANAN (JOIN PRODUK)
// ===============================
$sql = "SELECT o.*, p.NAMA_PRODUCT 
        FROM orders o
        LEFT JOIN product p ON o.id_product = p.ID_PRODUCT
        WHERE o.id_users = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

// ===============================
// AMBIL DETAIL PESANAN
// ===============================
$selectedOrder = null;
if (isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];

    $detailQuery = "SELECT o.*, p.NAMA_PRODUCT
                FROM orders o
                LEFT JOIN product p ON o.id_product = p.ID_PRODUCT
                WHERE o.id = ? AND o.id_users = ?";

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

                <div class="order-card">

                    <!-- CHECKBOX DENGAN AUTO ACTIVE -->
                    <div class="checkbox 
                        <?= (isset($_GET['order_id']) && $_GET['order_id'] == $row['id']) ? 'active' : '' ?>" 
                        onclick="window.location.href='pesanan.php?order_id=<?= $row['id']; ?>'">
                    </div>

                    <div class="order-info">

                      <?php 
        $isCustom = empty($row['id_product']) || $row['kategori'] === "custom cake";
            ?>

            <?php if ($isCustom): ?>
         <p class="order-name">Custom Cake</p>
             <p>Diameter: <?= $row['diameter']; ?> cm</p>
          <p>Tulisan: <?= $row['tulisan'] ?: "-"; ?></p>
            <?php else: ?>
             <p class="order-name"><?= $row['NAMA_PRODUCT']; ?></p>
            <?php endif; ?>


                        <p class="order-qty">Jumlah: 1</p>
                        <p class="order-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                    </div>

                </div>

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

                <p><strong>Nama Cake :</strong>
                   \<?php 
                    $isCustom = empty($selectedOrder['id_product']) || $selectedOrder['kategori'] === "custom cake";
                    ?>

                    <?= $isCustom ? "Custom Cake" : $selectedOrder['NAMA_PRODUCT']; ?>

                </p>

                <?php if ($selectedOrder['kategori'] === "custom cake"): ?>
                    <p><strong>Diameter :</strong> <?= $selectedOrder['diameter']; ?> cm</p>
                    <p><strong>Tulisan Cake :</strong><br><?= $selectedOrder['tulisan']; ?></p>
                <?php endif; ?>

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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".order-card");

    // Baca order_id dari URL
    const params = new URLSearchParams(window.location.search);
    const selectedId = params.get("order_id");

    cards.forEach(card => {
        let checkbox = card.querySelector(".checkbox");

        // ID dari checkbox diambil dari onclick dalam PHP
        let cardId = checkbox.getAttribute("onclick").match(/\d+/)[0];

        // Jika card ini yang aktif → beri efek highlight
        if (cardId === selectedId) {
            card.classList.add("active");
            
            // Auto-scroll posisi card ke tengah layar
            setTimeout(() => {
                card.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }, 200);
        }

        // Klik pada card = pindah URL
        card.addEventListener("click", () => {
            window.location.href = `pesanan.php?order_id=${cardId}`;
        });
    });
});
</script>

</body>
</html>
