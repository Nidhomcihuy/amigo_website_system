<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Amigo Cake</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="text-box">
            <h1>Lets order<br>delicious<br>cake</h1>
        </div>
    </div>

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
</html>
