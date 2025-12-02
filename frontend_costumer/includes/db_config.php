<?php
// includes/db_config.php


// Hindari akses langsung via URL
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__) . '/');

// -----------------------------------------------------
// KONFIGURASI KONEKSI DATABASE
// Ganti dengan detail koneksi database Anda yang sebenarnya
// -----------------------------------------------------
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Ganti dengan username DB Anda
define('DB_PASSWORD', 'gooyounjung12');     // Ganti dengan password DB Anda
define('DB_NAME', 'db_amigocake'); // Ganti dengan nama database Anda


$host = 'localhost';
$dbname = 'db_amigocake';   // sesuaikan nama database Anda
$username = 'root';       // sesuaikan
$password = 'gooyounjung12';           // sesuaikan (default Laragon: kosong)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi MySQLi gagal: " . $conn->connect_error);
}

// Pastikan $pdo tersedia di luar file ini
// Tidak perlu return, karena kita pakai variabel global biasa
?>