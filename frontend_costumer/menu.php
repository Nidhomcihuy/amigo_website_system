<?php
// tidak ada PHP khusus di atas
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Amigo Cake</title>

 <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script>
    function toggleMenu() {
      const nav = document.querySelector('.nav-links');
      nav.classList.toggle('active');
    }
  </script>
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="logo">Aloha, Amigos! 🍰</div>
    <nav class="nav-links">
      <a href="dashboard.php">Home</a>
      <a href="menu.php" class="active">Menu</a>
      <a href="about.php">About</a>
      <a href="galery.php">Galery</a>
    </nav>
       <div class="user-actions">
    <a href="logout.php" class="logout-btn" onclick="return confirm('Yakin ingin keluar?')">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#690108" viewBox="0 0 16 16">
          <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
          <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
        </svg>
    </a>
</div>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
  </header>
  
  <!-- MENU SECTION -->
<section class="menu" id="menu">
  <h2>Our Menu</h2>

  <div class="order-button-container">
    <a href="pesanan.php" class="order-button">Pesanan Saya🧾</a>
</div>

  <!-- KATEGORI -->
  <div class="menu-categories">
    <button class="category-btn active" data-category="All">All</button>
    <button class="category-btn" data-category="Custom Cake">Custom Cake</button>
    <button class="category-btn" data-category="Mille Crepes">Mille Crepes</button>
    <button class="category-btn" data-category="Cheesecake">Cheesecake</button>
    <button class="category-btn" data-category="Soft Cookies">Soft Cookies</button>
  </div>

  <!-- DESKRIPSI KATEGORI -->
  <p id="menu-description" class="menu-description fade show">
    Selamat datang di menu kami 🍰
  </p>

<?php
$conn = new mysqli("localhost", "root", "qwerty", "db_amigocake");

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM product ORDER BY ID_PRODUCT DESC";
$q = $conn->query($sql);

if (!$q || $q->num_rows == 0) {
  echo "<p>Tidak ada produk.</p>";
  return;
}
?>

<!-- PRODUK GRID -->
<div class="product-grid">

<?php while($p = $q->fetch_assoc()) { ?>
  
  <div class="product-card" data-category="<?php echo $p['KATEGORI_PRODUCT']; ?>">
      
      <div class="product-image">
        <img src="<?php echo $p['PATH_GAMBAR']; ?>" 
             alt="<?php echo $p['NAMA_PRODUCT']; ?>">
      </div>

      <div class="product-info">
        <h3><?php echo $p['NAMA_PRODUCT']; ?></h3>
        <p>Rp<?php echo number_format($p['HARGA'], 0, ',', '.'); ?></p>
      </div>

  </div>

<?php } ?>
</div>

<button class="view-more" onclick="openOrderPopup()">Order Now</button>

<!-- POPUP ORDER + PEMBAYARAN (2 STEP DALAM 1 POPUP) -->
<div id="popupWrap" class="popup-overlay">

    <div class="popup-box">

        <!-- CLOSE BUTTON -->
        <span class="close-btn" onclick="closeAll()">✕</span>

        <!-- STEP 1 : ORDER FORM -->
        <div id="stepOrder">

            <h2 class="popup-title">Order Cake</h2>

            <input type="text" placeholder="Nama Pemesan">
            <input type="text" placeholder="No. Telp">
            <input type="text" placeholder="Alamat">
            <input type="date">

            <input type="text" placeholder="Diameter (custom cake)">
            <input type="text" placeholder="Varian Cake">
            <input type="text" placeholder="Req Tulisan Cake (latin/biasa)">
            <input type="time">

            <button class="btn-primary" onclick="goToPayment()">Bayar</button>
        </div>

       <!-- STEP 2 : PEMBAYARAN -->
<div id="stepPayment">

    <h2 class="popup-title">Pembayaran</h2>

    <label class="label-title">Metode Pembayaran</label>

    <div class="select-box">
        <input type="radio" name="pay" id="transfer">
        <label for="transfer">Transfer Bank</label>
    </div>

    <!-- NOMOR REKENING (Hidden by default) -->
    <div class="input-box" id="rekeningBox">
        <input type="text" id="norek" readonly>
    </div>

    <!-- GROUP UPLOAD BUKTI PEMBAYARAN -->
    <div id="uploadGroup">
        <label class="label-title">Upload Bukti Pembayaran</label>

        <label class="upload-area" id="uploadBox">
            <input type="file" hidden>
            <img src="https://cdn-icons-png.flaticon.com/512/685/685655.png">
        </label>
    </div>

    <div class="select-box">
        <input type="radio" name="pay" id="cod">
        <label for="cod">Bayar di tempat</label>
    </div>

    <button class="btn-primary">Order</button>
</div>


    </div>
</div>

</section>

<!-- FOOTER -->
<footer>
  <div class="footer-content">
    <div>
      <h3>Contact Us</h3>
      <p>📍 Location</p>
      <p>📞 +62 858-0061-1600</p> 
      <p>✉️ illonaleilani@gmail.com</p>
    </div>

    <div>
      <h3>Amigo Cake</h3>
      <p>Setiap potongan adalah momen bahagia. Kue yang dibuat dengan cinta dan bahan terbaik untuk hari spesial Anda.</p>

      <div class="social-icons">
        <a href="https://wa.me/6285800611600" target="_blank" class="whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
        </a>
        <a href="https://www.instagram.com/amigo.cake" target="_blank" class="instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
      </div>
    </div>

    <div>
      <h3>Opening Hours</h3>
      <p>Everyday</p>
      <p>08.00 - 18.00 </p>
    </div>
  </div>
  <p class="footer-bottom">© 2025 All Rights Reserved By Kita Sendiri :)</p>
</footer>


<!-- SCRIPT FILTER + DESKRIPSI -->
<script>
const descriptions = {
  "All": "🍰 Selamat datang di menu kami 🍰",

  "Custom Cake":
    "🎂 Sponge cake / buttercake yang diberi isian diplomat cream atau fresh cream, dilapisi buttercream, cocok untuk ulang tahun dan event spesial 🎂",

  "Mille Crepes":
    "🍮 Tumpukan crepes lembut dengan fresh cream di setiap lapisan. Varian: coklat, biscoff, oreo, buah musiman 🍮",

  "Cheesecake":
    "🧀 Cream cheese lembut yang dipanggang atau dikukus, cocok dengan topping blueberry, strawberry atau tanpa topping 🧀",

  "Soft Cookies":
    "🍪 Luar crunchy, dalam lembut. Varian classic, choco chunk, red velvet cheese, dan banyak lagi 🍪"
};

const buttons = document.querySelectorAll(".category-btn");
const products = document.querySelectorAll(".product-card");
const desc = document.getElementById("menu-description");

buttons.forEach(btn => {
  btn.addEventListener("click", () => {

    // update tombol active
    buttons.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");

    const category = btn.dataset.category;

    // animasi fade deskripsi
    desc.classList.remove("show");
    setTimeout(() => {
      desc.textContent = descriptions[category];
      desc.classList.add("show");
    }, 50);

    // FILTER PRODUK
    products.forEach(prod => {
      const prodCat = prod.dataset.category.trim();
      prod.style.display =
        (category === "All" || prodCat === category)
          ? "block"
          : "none";
    });

  });
});
</script>
<script>
// --- BUKA POPUP ---
function openOrderPopup() {
    document.getElementById("popupWrap").style.display = "flex";
    document.getElementById("stepOrder").style.display = "block";
    document.getElementById("stepPayment").style.display = "none";
}

// --- TUTUP SEMUA POPUP ---
function closeAll() {
    document.getElementById("popupWrap").style.display = "none";
}

// --- PINDAH KE STEP PEMBAYARAN ---
function goToPayment() {
    document.getElementById("stepOrder").style.display = "none";
    document.getElementById("stepPayment").style.display = "block";
}


// --- PEMBAYARAN RADIO: TRANSFER / COD ---
document.getElementById("transfer").addEventListener("change", function() {
    document.getElementById("rekeningBox").style.display = "block";
    document.getElementById("uploadBox").style.display = "block";
});

document.getElementById("cod").addEventListener("change", function() {
    document.getElementById("rekeningBox").style.display = "none";
    document.getElementById("uploadBox").style.display = "none";
});

// Default
document.getElementById("rekeningBox").style.display = "none";
document.getElementById("uploadBox").style.display = "none";
</script>
<script>
// Ketika memilih transfer
document.getElementById("transfer").addEventListener("change", function() {

    // nomor rekening otomatis terisi
    document.getElementById("norek").value = "1234567890 (BCA A/N Amigo Cake)";

    document.getElementById("rekeningBox").style.display = "block";
    document.getElementById("uploadGroup").style.display = "block";
});

// Ketika memilih COD
document.getElementById("cod").addEventListener("change", function() {

    document.getElementById("rekeningBox").style.display = "none";
    document.getElementById("uploadGroup").style.display = "none";
});

// DEFAULT awal: disembunyikan
document.getElementById("rekeningBox").style.display = "none";
document.getElementById("uploadGroup").style.display = "none";

</script>
</body>
</html>
