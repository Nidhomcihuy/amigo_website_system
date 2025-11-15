<?php
// admin/account.php (Menu Settings/Account)
session_start(); 

// --- Autentikasi dan Perlindungan Halaman ---
if (!isset($_SESSION['loggedin']) || $_SESSION['level'] !== 'ADMIN') {
    header("Location: login.php");
    exit;
}

// Data pengguna dari sesi
$user_name = htmlspecialchars($_SESSION['nama'] ?? 'Illona');
$user_initial = urlencode($_SESSION['nama'] ?? 'Illona');

// Set halaman aktif untuk sidebar
$current_page = 'account'; 

// --- DATA DUMMY AKUN (Ambil dari $_SESSION atau DB) ---
$current_first_name = 'Illona';
$current_last_name = 'Admin';
$current_phone = '081234567890';
$current_email = 'illona@amigo.com';

// Anda dapat menyertakan db_config.php di sini jika ingin mengambil data pengguna secara real-time
// include('../includes/db_config.php');
// $conn->close(); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - My Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admindashboard.css"> 
    <link rel="stylesheet" href="../css/account-settings.css"> </head>
<body>
    <?php include('includes/sidebar-admin.php'); ?>

    <div class="main-content">
        
        <?php include('includes/topbar.php'); ?>
        
        <div class="content-wrapper">
            <div class="left-content account-settings-content">
                
                <div class="account-header-banner">
                    <h2 class="header-title">My Account</h2>
                </div>
                
                <h3 class="section-subtitle">Add Your Account</h3>
                <form action="add_account_process.php" method="POST" class="account-form add-form">
                    <div class="form-row">
                        <div class="form-group-half">
                            <label for="fname">FIRST NAME</label>
                            <input type="text" id="fname" name="first_name" required>
                        </div>
                        <div class="form-group-half">
                            <label for="sname">SECOND NAME</label>
                            <input type="text" id="sname" name="second_name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pnumber">PHONE NUMBER</label>
                        <input type="tel" id="pnumber" name="phone_number" required>
                    </div>

                    <div class="form-group">
                        <label for="email_add">E-MAIL ADDRESS</label>
                        <input type="email" id="email_add" name="email_address" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_pass">PASSWORD</label>
                        <input type="password" id="new_pass" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn-save">SAVE</button>
                </form>

                <hr class="form-separator">

                <h3 class="section-subtitle">Update Your Account</h3>
                <form action="update_account_process.php" method="POST" class="account-form update-form">
                    <div class="form-row">
                        <div class="form-group-half">
                            <label for="upd_name">YOUR NAME</label>
                            <input type="text" id="upd_name" name="name" value="<?= htmlspecialchars($current_first_name . ' ' . $current_last_name) ?>">
                        </div>
                        <div class="form-group-half">
                            <label for="upd_email">E-MAIL ADDRESS</label>
                            <input type="email" id="upd_email" name="email_address" value="<?= htmlspecialchars($current_email) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upd_phone">PHONE NUMBER</label>
                        <input type="tel" id="upd_phone" name="phone_number" value="<?= htmlspecialchars($current_phone) ?>">
                    </div>

                    <div class="form-row password-row">
                        <div class="form-group-half">
                            <label for="curr_pass">CURRENT PASSWORD <a href="#" class="forgot-link">Forget?</a></label>
                            <input type="password" id="curr_pass" name="current_password" required>
                        </div>
                        <div class="form-group-half">
                            <label for="new_pass_upd">NEW PASSWORD</label>
                            <input type="password" id="new_pass_upd" name="new_password">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-update">Update</button>
                </form>

            </div>
            
            <?php include('includes/right-sidebar.php'); ?>
            
        </div>
    </div>
</body>
</html>