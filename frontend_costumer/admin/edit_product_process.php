<?php
// admin/edit_product_process.php
session_start();
include('../includes/db_config.php');

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Ambil Data dari Form (7 Parameter, termasuk ID dan old_path)
    $product_id = trim($_POST['product_id'] ?? 0);
    $nama_product = trim($_POST['product_name'] ?? '');
    $kategori_product = trim($_POST['kategori_product'] ?? '');
    $harga = trim($_POST['price'] ?? 0);
    $diameter = trim($_POST['diameter'] ?? 0);
    $deskripsi = trim($_POST['description'] ?? '');
    $old_path_gambar = trim($_POST['old_image_path'] ?? ''); // Path gambar lama

    // Sanitasi dan Konversi Tipe Data
    $product_id = (int)$product_id;
    $nama_product = $conn->real_escape_string($nama_product);
    $kategori_product = $conn->real_escape_string($kategori_product);
    $deskripsi = $conn->real_escape_string($deskripsi);
    $harga = (float)$harga; 
    $diameter = (int)$diameter; 

    // Validasi ID
    if ($product_id <= 0) {
        $_SESSION['message'] = "❌ Error: ID produk tidak valid.";
        header("Location: edit_cake.php");
        exit;
    }

    // 2. Proses Upload Gambar Baru (Jika ada)
    $path_gambar = $old_path_gambar; // Default: pertahankan path lama
    $target_dir = "../images/products/"; 
    $allowed_extensions = ['jpg', 'jpeg', 'png'];

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $file = $_FILES['product_image'];
        
        // Cek ukuran file (Maks 2MB)
        if ($file['size'] > 2097152) {
             $_SESSION['message'] = "❌ Ukuran file baru terlalu besar. Maksimal 2MB.";
             header("Location: edit_cake.php?id=" . $product_id);
             exit;
        }

        $image_info = pathinfo($file['name']);
        $file_extension = strtolower($image_info['extension']);

        if (in_array($file_extension, $allowed_extensions)) {
            $new_file_name = uniqid('cake_edit_') . '.' . $file_extension;
            $target_file = $target_dir . $new_file_name;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // Simpan path baru
                $path_gambar = "images/products/" . $new_file_name;

                // Opsional: Hapus file lama di server jika itu bukan gambar default
                $old_file = "../" . $old_path_gambar;
                if (!empty($old_path_gambar) && file_exists($old_file) && $old_path_gambar != "images/products/default_cake.jpg") {
                    unlink($old_file);
                }
            } else {
                $_SESSION['message'] = "❌ Gagal mengunggah gambar baru. Cek izin folder server.";
                header("Location: edit_cake.php?id=" . $product_id);
                exit;
            }
        } else {
            $_SESSION['message'] = "❌ Format file baru tidak diizinkan. Gunakan JPG atau PNG.";
            header("Location: edit_cake.php?id=" . $product_id);
            exit;
        }
    }

    // 3. Masukkan Data ke Database (Query UPDATE)
    $sql = "UPDATE product SET 
                NAMA_PRODUCT = ?, 
                HARGA = ?, 
                PATH_GAMBAR = ?, 
                KATEGORI_PRODUCT = ?, 
                DIAMETER_SIZE = ?, 
                DESKRIPSI_PRODUCT = ?
            WHERE ID_PRODUCT = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Binding: sdsisi (6 kolom update + 1 ID
    // TIPE DATA YANG DIKOREKSI: sdssisi (7 TIPE DATA)
    $stmt->bind_param("sdssisi", 
        $nama_product,          // s
        $harga,                 // d
        $path_gambar,           // s
        $kategori_product,      // s
        $diameter,              // i
        $deskripsi,             // s
        $product_id             // i (di klausa WHERE)
    );

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Produk **$nama_product** berhasil diperbarui!";
    } else {
        $_SESSION['message'] = "❌ Gagal memperbarui produk: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    
    // Redirect kembali ke halaman edit_cake
    header("Location: edit_cake.php");
    exit;

} else {
    // Jika diakses tanpa POST request
    header("Location: edit_cake.php");
    exit;
}
?>