<div class="top-bar">
    <?php
    // Contoh mengambil nama pengguna dari sesi atau database
    $admin_name = "Illona"; // Ganti dengan data dinamis dari PHP
    $notification_count = 3; // Ganti dengan data dinamis dari PHP
    $profile_img_url = "https://ui-avatars.com/api/?name=Illona&background=7d3e5d&color=fff";
    ?>
    <div class="greeting">Hello, **<?= htmlspecialchars($admin_name) ?>**</div>
    <div class="top-icons">
        
        <div class="profile-pic">
            <img src="<?= $profile_img_url ?>" alt="Profile">
        </div>
    </div>
</div>