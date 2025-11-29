<?php
session_start();
require_once "includes/db_config.php";

header("Content-Type: application/json");

// CEGAH AKSES TANPA LOGIN
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "msg" => "Not logged in"]);
    exit;
}

/* ============================================================
   STEP 1 — INSERT ORDER
============================================================ */
if ($_POST['step'] === "order") {

    try {
        $stmt = $pdo->prepare("
            INSERT INTO orders 
            (id_users, nama_pemesan, telp, alamat, tanggal, diameter, varian, tulisan, waktu, created_at)
            VALUES 
            (:id_users, :nama, :telp, :alamat, :tanggal, :diameter, :varian, :tulisan, :waktu, NOW())
        ");

        $stmt->execute([
            ":id_users" => $_SESSION['user_id'],
            ":nama"     => $_POST['nama'],
            ":telp"     => $_POST['telp'],
            ":alamat"   => $_POST['alamat'],
            ":tanggal"  => $_POST['tanggal'],
            ":diameter" => $_POST['diameter'],
            ":varian"   => $_POST['varian'],
            ":tulisan"  => $_POST['tulisan'],
            ":waktu"    => $_POST['waktu']
        ]);

        $order_id = $pdo->lastInsertId();

        echo json_encode(["status" => "success", "order_id" => $order_id]);
        exit;

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "msg" => "Order gagal"]);
        exit;
    }
}

/* ============================================================
   STEP 2 — INSERT PAYMENT
============================================================ */
if ($_POST['step'] === "payment") {

    $order_id = $_POST['order_id'];
    $metode = $_POST['metode'];
    $norek = $_POST['metode'] == "transfer" ? $_POST['norek'] : null;

    $fileName = null;

    // Jika transfer → upload bukti
    if ($metode === "transfer") {
        if (!empty($_FILES['bukti']['name'])) {

            $folder = "uploads/bukti/";
            if (!file_exists($folder)) mkdir($folder, 0777, true);

            $fileName = time() . "_" . $_FILES['bukti']['name'];

            move_uploaded_file($_FILES['bukti']['tmp_name'], $folder . $fileName);
        }
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO payments 
            (order_id, metode, no_rekening, bukti_bayar, created_at)
            VALUES 
            (:order_id, :metode, :norek, :bukti, NOW())
        ");

        $stmt->execute([
            ":order_id" => $order_id,
            ":metode"   => $metode,
            ":norek"    => $norek,
            ":bukti"    => $fileName
        ]);

        echo json_encode(["status" => "success"]);
        exit;

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "msg" => "Payment gagal"]);
        exit;
    }
}

?>
