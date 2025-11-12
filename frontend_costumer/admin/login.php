<?php
// admin/login.php
session_start(); 

// 1. Cek jika pengguna sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['level']) && $_SESSION['level'] === 'ADMIN') {
    header("Location: dashboard.php");
    exit;
}

// 2. Sertakan file koneksi database
include('../includes/db_config.php');

$error_message = ''; 

// 3. Proses form jika data dikirimkan (metode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username_input = $conn->real_escape_string($_POST['username']); 
    $password_input = $_POST['password']; 

    // Query database untuk mencari user berdasarkan USERNAME
    $sql = "SELECT ID_USERS, NAMA, USERNAME, PASSWORD, LEVEL FROM users WHERE USERNAME = '$username_input'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();

        
        // Verifikasi Password 
        if (password_verify($password_input, $user['PASSWORD'])) { 
            
            // Verifikasi Level Pengguna
            if ($user['LEVEL'] === 'ADMIN') {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['ID_USERS'];
                $_SESSION['username'] = $user['USERNAME'];
                $_SESSION['nama'] = $user['NAMA'];
                $_SESSION['level'] = $user['LEVEL'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "Akses ditolak. Anda bukan Administrator.";
            }
        } else {
            $error_message = "Username atau Password salah.";
        }
    } else {
        $error_message = "Username atau Password salah.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Cake Admin - Login</title>
    <link rel="stylesheet" href="../css/admin-login.css"> 
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <div class="login-logo">
                    <div class="logo-circle">
                        <div class="logo-text">Amigo<div style="font-size:10px; font-weight:400; line-height:1;">CAKE</div></div>
                    </div>
                    <div class="logo-text" style="text-align:left;"><span>Amigo</span><span style="font-weight: normal; font-size: 14px; opacity: 0.8;">@amigocake</span></div>
                </div>
                <div class="welcome-text">Hello,<br>Welcome!</div>
            </div>
        </div>

        <div class="login-right">
            <h2>Enter Your Detail to Continue!</h2>
            
            <?php if (!empty($error_message)): ?>
                <div style="color: red; margin-bottom: 20px; padding: 10px; border: 1px solid red; border-radius: 5px;">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST"> 
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="login-input" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="login-input" required>
                </div>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <div class="login-actions">
                    <button type="submit" class="btn-login">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>