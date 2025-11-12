<?php
// includes/db_config.php

// -----------------------------------------------------
// KONFIGURASI KONEKSI DATABASE
// Ganti dengan detail koneksi database Anda yang sebenarnya
// -----------------------------------------------------
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Ganti dengan username DB Anda
define('DB_PASSWORD', 'gooyounjung');     // Ganti dengan password DB Anda
define('DB_NAME', 'db_amigocake'); // Ganti dengan nama database Anda

/* Mencoba terhubung ke database MySQL */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan program dan tampilkan error
    die("Koneksi Database Gagal: " . $conn->connect_error);
}

// Opsional: Atur charset menjadi utf8mb4 (disarankan)
$conn->set_charset("utf8mb4");

// Echo ini hanya untuk tes. Hapus setelah diproduksi!
// echo "Koneksi berhasil! Siap mengambil data kue.";

// Catatan: Setelah ini, Anda bisa menggunakan variabel $conn untuk query SQL
?>