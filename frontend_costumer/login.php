<<<<<<< HEAD
<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Sesuaikan path ke file konfigurasi
require_once 'includes/db_config.php';

$login_error = '';
$register_error = '';
$register_success = '';

// ─── PROSES LOGIN ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $login_error = "Email dan password wajib diisi.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT ID_USERS, NAMA, USERNAME, PASSWORD, LEVEL FROM users WHERE USERNAME = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['PASSWORD'])) {
                $_SESSION['user_id'] = $user['ID_USERS'];
                $_SESSION['user_name'] = $user['NAMA'] ?: $user['USERNAME'];
                $_SESSION['user_level'] = $user['LEVEL'];
                header("Location: dashboard.php");
                exit;
            } else {
                $login_error = "Email atau password salah.";
            }
        } catch (PDOException $e) {
            $login_error = "Terjadi kesalahan sistem saat login.";
        }
    }
}

// ─── PROSES REGISTER (HANYA SIMPAN DATA, TIDAK LOGIN) ───────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password)) {
        $register_error = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = "Format email tidak valid.";
    } elseif ($password !== $confirm_password) {
        $register_error = "Password dan konfirmasi tidak cocok.";
    } elseif (strlen($password) < 6) {
        $register_error = "Password minimal 6 karakter.";
    } else {
        try {
            // Cek email sudah terdaftar
            $stmt = $pdo->prepare("SELECT ID_USERS FROM users WHERE USERNAME = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                $register_error = "Email sudah terdaftar.";
            } else {
                // Simpan user baru, TANPA login
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (NAMA, USERNAME, PASSWORD, LEVEL) VALUES (:nama, :email, :password, 'customer')");
                $stmt->execute([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $hashed_password
                ]);

                $register_success = "Pendaftaran berhasil! Silakan login dengan akun Anda.";
                // Reset form (opsional)
                // Tidak redirect, tetap di halaman ini
            }
        } catch (PDOException $e) {
            $register_error = "Gagal membuat akun. Coba lagi nanti.";
        }
    }
}
?>

=======
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Amigo Cake</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<<<<<<< HEAD
    <style>
        .alert {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            text-align: center;
            font-size: 0.9rem;
        }
        .alert.error { background-color: #ffecec; color: #c0392b; }
        .alert.success { background-color: #e8f5e9; color: #27ae60; }
    </style>
=======
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919
</head>
<body>

<div class="container">
<<<<<<< HEAD
=======

    <!-- LEFT SIDE -->
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919
    <div class="left">
        <div class="text-box">
            <h1>Lets order<br>delicious<br>cake</h1>
        </div>
    </div>

<<<<<<< HEAD
    <div class="right">
        <div class="form-wrapper">

            <!-- LOGIN FORM -->
            <div class="login-card form-card <?php echo ($register_success || $register_error) ? '' : 'active'; ?>" id="loginCard">
                <?php if ($login_error): ?>
                    <div class="alert error"><?php echo htmlspecialchars($login_error); ?></div>
                <?php endif; ?>
                <?php if ($register_success): ?>
                    <div class="alert success"><?php echo htmlspecialchars($register_success); ?></div>
                <?php endif; ?>

                <h2>Login</h2>
                <form method="POST" action="">
                    <input type="hidden" name="login" value="1">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Masukan email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Masukan password" required>
                    </div>
                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="register-text">
                    Belum punya akun? 
                    <a href="#" id="toRegister">daftar</a>
                </p>
                <div class="divider">or continue with</div>
                <div class="google-btn"><span>G</span></div>
            </div>

            <!-- REGISTER FORM -->
            <div class="login-card form-card <?php echo ($register_error) ? 'active' : ''; ?>" id="registerCard">
                <?php if ($register_error): ?>
                    <div class="alert error"><?php echo htmlspecialchars($register_error); ?></div>
                <?php endif; ?>

                <h2>Daftar</h2>
                <form method="POST" action="">
                    <input type="hidden" name="register" value="1">
                    <label>Nama</label>
                    <div class="input-group">
                        <input type="text" name="nama" placeholder="Masukan nama" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
                    </div>
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Masukan email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Masukan password" required>
                    </div>
                    <label>Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" placeholder="Masukan ulang password" required>
                    </div>
                    <button type="submit" class="btn-login">Daftar</button>
                </form>

                <p class="register-text">
                    Sudah punya akun? 
                    <a href="#" id="toLogin">login</a>
                </p>
                <div class="divider">or continue with</div>
                <div class="google-btn"><span>G</span></div>
            </div>

        </div>
    </div>
</div>
=======
    <!-- RIGHT SIDE -->
    <div class="right">
    <div class="form-wrapper">

        <!-- LOGIN FORM -->
        <div class="login-card form-card active" id="loginCard">
            <h2>Login</h2>

            <label>Email</label>
            <div class="input-group">
                <input type="email" placeholder="Masukan email">
            </div>

            <label>Password</label>
            <div class="input-group">
                <input type="password" placeholder="Masukan password">
            </div>

            <button class="btn-login">Login</button>

            <p class="register-text">
                Belum punya akun? 
                <a href="#" id="toRegister">daftar</a>
            </p>

            <div class="divider">or continue with</div>

            <div class="google-btn"><span>G</span></div>
        </div>

        <!-- REGISTER FORM -->
        <div class="login-card form-card" id="registerCard">
            <h2>Daftar</h2>

            <label>Nama</label>
            <div class="input-group">
                <input type="text" placeholder="Masukan nama">
            </div>

            <label>Email</label>
            <div class="input-group">
                <input type="email" placeholder="Masukan email">
            </div>

            <label>Password</label>
            <div class="input-group">
                <input type="password" placeholder="Masukan password">
            </div>

            <label>Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" placeholder="Masukan ulang password">
            </div>

            <button class="btn-login">Daftar</button>

            <p class="register-text">
                Sudah punya akun? 
                <a href="#" id="toLogin">login</a>
            </p>
            <div class="divider">or continue with</div>

            <div class="google-btn"><span>G</span></div>
        </div>

    </div>
</div>
</div>
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919

<script>
const loginCard = document.getElementById("loginCard");
const registerCard = document.getElementById("registerCard");

document.getElementById("toRegister").onclick = (e) => {
    e.preventDefault();
    loginCard.classList.remove("active");
    registerCard.classList.add("active");
};

document.getElementById("toLogin").onclick = (e) => {
    e.preventDefault();
    registerCard.classList.remove("active");
    loginCard.classList.add("active");
};
</script>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919
