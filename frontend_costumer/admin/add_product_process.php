<?php
// admin/add_product_process.php

session_start();
include('../includes/db_config.php'); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Ambil Data dari Form (6 Parameter)
    $nama_product = trim($_POST['product_name'] ?? '');
    $kategori_product = trim($_POST['kategori_product'] ?? '');
    $harga = trim($_POST['price'] ?? 0);
    $diameter = trim($_POST['diameter'] ?? 0); 
    // Variabel deskripsi (dibiarkan kosong)
    $deskripsi = trim($_POST['description'] ?? ''); 
    // echo $kategori_product; // <-- BARIS INI HARUS DIHAPUS/DIKOMENTARI
    
    // Sanitasi dan Konversi Tipe Data
    $nama_product = $conn->real_escape_string($nama_product);
    $kategori_product = $conn->real_escape_string($kategori_product);
    $deskripsi = $conn->real_escape_string($deskripsi);
    $harga = (float)$harga; 
    $diameter = (int)$diameter; 

    // Lakukan validasi dasar
    if (empty($nama_product) || $harga <= 0 || $diameter <= 0) {
        $_SESSION['message'] = "❌ Nama, harga, dan diameter produk harus diisi dengan benar.";
        header("Location: dashboard.php");
        exit;
    }

    // 2. Proses Upload Gambar
    $target_dir = "../images/products/"; 
    $path_gambar = ""; 
    
    // Pastikan folder tujuan ada
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            $_SESSION['message'] = "❌ Gagal membuat folder upload. Hubungi administrator.";
            header("Location: dashboard.php");
            exit;
        }
    }

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_info = pathinfo($_FILES['product_image']['name']);
        $file_extension = strtolower($image_info['extension']);
        $new_file_name = uniqid('cake_') . '.' . $file_extension;
        $target_file = $target_dir . $new_file_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        
        // Cek ukuran file (Maks 2MB)
        if ($_FILES['product_image']['size'] > 2097152) {
             $_SESSION['message'] = "❌ Ukuran file terlalu besar. Maksimal 2MB.";
             header("Location: dashboard.php");
             exit;
        }

        if (in_array($file_extension, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $path_gambar = "images/products/" . $new_file_name;
            } else {
                $_SESSION['message'] = "❌ Gagal mengunggah file. Cek izin folder server.";
                header("Location: dashboard.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "❌ Format file tidak diizinkan. Gunakan JPG atau PNG.";
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "❌ Gambar produk wajib diunggah."; 
        header("Location: dashboard.php");
        exit;
    }
    
    // 3. Masukkan Data ke Database
    $sql = "INSERT INTO product (NAMA_PRODUCT, HARGA, PATH_GAMBAR, KATEGORI_PRODUCT, DIAMETER_SIZE, DESKRIPSI_PRODUCT) 
             VALUES (?, ?, ?, ?, ?, ?)"; 
    
    $stmt = $conn->prepare($sql);
    
    // Binding: sdssis (Nama, Harga, Path, Kategori, Diameter, Deskripsi)
    $stmt->bind_param("sdsiss", 
        $nama_product, 
        $harga, 
        $path_gambar, 
        $kategori_product, 
        $diameter, 
        $deskripsi
    );


    if ($stmt->execute()) {
        // SET PESAN SUKSES DI SESSION
        $_SESSION['message'] = "✅ Produk **$nama_product** (Diameter: $diameter cm) berhasil ditambahkan!";
    } else {
        $_SESSION['message'] = "❌ Gagal menambahkan produk: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    
    // REDIRECT KE DASHBOARD.PHP (Akan memuat pesan dari session)
    header("Location: dashboard.php");
    exit;

} else {
    // Jika diakses tanpa POST request
    header("Location: dashboard.php");
    exit;
}
?>