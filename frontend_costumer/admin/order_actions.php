<?php
// admin/order_actions.php
session_start();
include('../includes/db_config.php'); // pastikan $conn (mysqli) tersedia

// Proteksi halaman: hanya admin boleh akses
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    $_SESSION['message'] = "❌ Akses ditolak.";
    header("Location: order_history.php");
    exit;
}

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: order_history.php");
    exit;
}

// Ambil input (trim)
$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$order_id_raw = isset($_POST['order_id']) ? trim($_POST['order_id']) : '';

if ($action === '' || $order_id_raw === '') {
    $_SESSION['message'] = "❌ Data tidak lengkap.";
    header("Location: order_history.php");
    exit;
}

// Kita coba deteksi apakah order identifier numeric (kolom id) atau bukan (mis. order_id string)
$is_numeric_id = ctype_digit($order_id_raw);

// Helper: prepare & execute safely with checks
function run_prepared_query($conn, $sql, $types, $params) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ['ok'=>false, 'error'=> "Prepare failed: " . $conn->error];
    }
    // bind params dynamically
    if ($types !== '') {
        $bind_names[] = $types;
        for ($i=0; $i < count($params); $i++) {
            $bind_name = 'bind' . $i;
            $$bind_name = $params[$i];
            $bind_names[] = &$$bind_name;
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_names);
    }
    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return ['ok'=>false, 'error'=> $err];
    }
    $affected = $stmt->affected_rows;
    $stmt->close();
    return ['ok'=>true, 'affected'=>$affected];
}

// Map action ke status / operasi
if ($action === 'complete') {
    $new_status = 'Done';
    if ($is_numeric_id) {
        $sql = "UPDATE `orders` SET `status` = ? WHERE `id` = ?";
        $result = run_prepared_query($conn, $sql, "si", [$new_status, (int)$order_id_raw]);
    } else {
        $sql = "UPDATE `orders` SET `status` = ? WHERE `order_id` = ?";
        $result = run_prepared_query($conn, $sql, "ss", [$new_status, $order_id_raw]);
    }

    if ($result['ok']) {
        $_SESSION['message'] = "✅ Pesanan berhasil ditandai sebagai Selesai.";
    } else {
        $_SESSION['message'] = "❌ Gagal mengubah status: " . htmlspecialchars($result['error']);
    }
    header("Location: order_history.php");
    exit;

} elseif ($action === 'cancel') {
    $new_status = 'Cancelled';
    if ($is_numeric_id) {
        $sql = "UPDATE `orders` SET `status` = ? WHERE `id` = ?";
        $result = run_prepared_query($conn, $sql, "si", [$new_status, (int)$order_id_raw]);
    } else {
        $sql = "UPDATE `orders` SET `status` = ? WHERE `order_id` = ?";
        $result = run_prepared_query($conn, $sql, "ss", [$new_status, $order_id_raw]);
    }

    if ($result['ok']) {
        $_SESSION['message'] = "✅ Pesanan dibatalkan.";
    } else {
        $_SESSION['message'] = "❌ Gagal membatalkan pesanan: " . htmlspecialchars($result['error']);
    }
    header("Location: order_history.php");
    exit;

} elseif ($action === 'delete') {
    if ($is_numeric_id) {
        $sql = "DELETE FROM `orders` WHERE `id` = ?";
        $result = run_prepared_query($conn, $sql, "i", [(int)$order_id_raw]);
    } else {
        $sql = "DELETE FROM `orders` WHERE `order_id` = ?";
        $result = run_prepared_query($conn, $sql, "s", [$order_id_raw]);
    }

    if ($result['ok']) {
        $_SESSION['message'] = "✅ Riwayat pesanan dihapus.";
    } else {
        $_SESSION['message'] = "❌ Gagal menghapus: " . htmlspecialchars($result['error']);
    }
    header("Location: order_history.php");
    exit;

} else {
    $_SESSION['message'] = "❌ Aksi tidak dikenali.";
    header("Location: order_history.php");
    exit;
}
