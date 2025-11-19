<?php
// admin/delete_product_process.php
session_start();
include('../includes/db_config.php');

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// Cek apakah ID produk ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    
    // 1. Ambil path gambar lama sebelum menghapus produk (untuk dihapus dari server)
    $sql_path = "SELECT PATH_GAMBAR, NAMA_PRODUCT FROM product WHERE ID_PRODUCT = ?";
    $stmt_path = $conn->prepare($sql_path);
    $stmt_path->bind_param("i", $product_id);
    $stmt_path->execute();
    $result_path = $stmt_path->get_result();
    $product_info = $result_path->fetch_assoc();
    $image_path = $product_info['PATH_GAMBAR'] ?? null;
    $product_name = $product_info['NAMA_PRODUCT'] ?? 'Produk Tidak Dikenal';
    $stmt_path->close();
    
    // 2. Hapus data produk dari database
    $sql_delete = "DELETE FROM product WHERE ID_PRODUCT = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $product_id);

    if ($stmt_delete->execute()) {
        
        // 3. Hapus file gambar fisik dari server (Opsional)
        if ($image_path && $image_path != "images/products/default_cake.jpg") {
            $full_path = "../" . $image_path;
            if (file_exists($full_path)) {
                unlink($full_path);
            }
        }
        
        $_SESSION['message'] = "🗑️ Produk **$product_name** (ID: $product_id) berhasil dihapus!";
    } else {
        $_SESSION['message'] = "❌ Gagal menghapus produk: " . $conn->error;
    }

    $stmt_delete->close();
    $conn->close();
    
    // Redirect kembali ke halaman edit_cake
    header("Location: edit_cake.php");
    exit;

} else {
    // Jika ID tidak valid
    $_SESSION['message'] = "❌ ID produk tidak ditemukan atau tidak valid.";
    header("Location: edit_cake.php");
    exit;
}
?>