<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root"; 
$pass = "55555";
$db   = "db_amigocake";   // ganti sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

// Query menyesuaikan tabel kamu
$sql = "SELECT ID_PRODUCT, NAMA_PRODUCT, KATEGORI_PRODUCT, DIAMETER_SIZE, 
        DESKRIPSI_PRODUCT, HARGA, PATH_GAMBAR
        FROM products";

$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    // Format harga ke number (frontend nanti format rupiah)
    $row['HARGA'] = intval($row['HARGA']);
    $products[] = $row;
}

echo json_encode($products);
?>
