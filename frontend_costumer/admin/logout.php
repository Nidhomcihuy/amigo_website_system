<?php
session_start(); // Mulai session

// Hapus semua data session
session_unset();
session_destroy();

// Arahkan user ke halaman login
header("Location: login.php");
exit();
?>
