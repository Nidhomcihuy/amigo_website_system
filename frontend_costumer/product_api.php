<?php
require_once "includes/db_config.php";

header("Content-Type: application/json");

$mode = $_GET['mode'] ?? '';

/* ================================
   1. GET LIST KATEGORI
================================ */
if ($mode == "kategori") {

    $sql = "SELECT DISTINCT KATEGORI_PRODUCT FROM product ORDER BY KATEGORI_PRODUCT ASC";
    $result = $conn->query($sql);

    $kategori = [];
    while ($row = $result->fetch_assoc()) {
        $kategori[] = $row['KATEGORI_PRODUCT'];
    }

    echo json_encode($kategori);
    exit;
}

/* ================================
   2. GET PRODUK BY KATEGORI
================================ */
if ($mode == "product" && isset($_GET['kategori'])) {

    $kategori = $_GET['kategori'];

    $stmt = $conn->prepare("SELECT * FROM product WHERE KATEGORI_PRODUCT = ?");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();

    $produk = [];
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row;
    }

    echo json_encode($produk);
    exit;
}

echo json_encode(["status" => "error"]);
?>
