<?php
// includes/db_config.php

// Hindari akses langsung via URL
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__) . '/');

$host = 'localhost';
$dbname = 'db_amigocake';   // sesuaikan nama database Anda
$username = 'root';       // sesuaikan
$password = '55555';           // sesuaikan (default Laragon: kosong)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Pastikan $pdo tersedia di luar file ini
// Tidak perlu return, karena kita pakai variabel global biasa
?>