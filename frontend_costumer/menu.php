<?php
// tidak ada PHP khusus di atas
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Amigo Cake</title>
<<<<<<< HEAD
 <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
=======
  <link rel="stylesheet" href="css/menu.css?v=<?php echo time(); ?>">
>>>>>>> d856e19f7bf7a7426dfa17d6f0a8f4546ca84919
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
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
  </header>

  <!-- MENU SECTION -->
<section class="menu" id="menu">
  <h2>Our Menu</h2>

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

<button class="view-more" onclick="openPopup()">Order Now</button>

<!-- POPUP ORDER FORM -->
<div id="popupOverlay" class="popup-overlay">
  <div class="popup-box">
    <h2>Order Cake</h2>

    <input type="text" placeholder="Nama Pemesan">
    <input type="text" placeholder="No. Telf">
    <input type="text" placeholder="Alamat">
    <input type="date" placeholder="Tgl Pengambilan">
    <input type="text" placeholder="Diameter (custom cake)">
    <input type="text" placeholder="Varian Cake">
    <input type="text" placeholder="Req Tulisan Cake (latin/biasa)">
    <input type="time" placeholder="Jam Pengambilan">

    <button class="submit-order">Order</button>

    <span class="close-btn" onclick="closePopup()">×</span>
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
  function openPopup() {
  document.getElementById('popupOverlay').style.display = 'flex';
}

function closePopup() {
  document.getElementById('popupOverlay').style.display = 'none';
}
</script>
</body>
</html>
