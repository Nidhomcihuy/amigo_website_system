<div class="top-bar">
    <div class="greeting">Hello, 
        <?= htmlspecialchars($_SESSION['nama'] ?? 'Admin') ?>
    </div>
    <div class="top-icons">
        
        <div class="profile-pic">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['nama'] ?? 'Admin') ?>&background=7d3e5d&color=fff" alt="Profile">
        </div>
    </div>
</div>
