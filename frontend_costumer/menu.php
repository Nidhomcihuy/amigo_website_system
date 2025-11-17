<?php

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Amigo Cake</title>
  <link rel="stylesheet" href="css/menu.css">
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
      <a href="dashboard.php" >Home</a>
      <a href="menu.php" class="active" >Menu</a>
      <a href="about.php">About</a>
      <a href="galery.php">Galery</a>
    </nav>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
  </header>

  <!-- MENU SECTION -->
<section class="menu" id="menu">
  <h2>Our Menu</h2>

  <div class="menu-categories">
    <button class="active">All</button>
    <button>Custom Cake</button>
    <button>Millecrepes</button>
    <button>Cheesecake</button>
    <button>Soft Cookies</button>
  </div>

  <!-- DESKRIPSI DINAMIS -->
  <p id="menu-description" class="menu-description fade show">
    Selamat datang di menu kami 🍰
  </p>

<?php
$conn = new mysqli("localhost", "root", "55555", "db_amigocake");

// cek error koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk terbaru (urutan paling baru di atas)
$sql = "SELECT * FROM product ORDER BY ID_PRODUCT DESC";
$q = $conn->query($sql);

// Jika tidak ada data
if (!$q || $q->num_rows == 0) {
  echo "<p>Tidak ada produk.</p>";
  return;
}
?>

<div class="product-grid">

<?php while($p = $q->fetch_assoc()) { ?>
  
  <div class="product-card">
      
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

  <button class="view-more">View More</button>
</section>

<!-- SCRIPT KATEGORI + DESKRIPSI + ANIMASI -->
<script>
  const descriptions = {
  "All": "🍰 Selamat datang di menu kami 🍰",

  "Custom Cake":
    "🎂 Sponge cake / buttercake yang diberi isian fiiling berupa diplomat cream atau fresh cream. Di coating menggunakan buttercream agar lebih kokoh dan dapat dihias sesuai keinginan customer. Dijadikan sebagai salah satu bagian penting dalam perayaan ulang tahun, anniversary atau sejenisnya. 🎂",

  "Millecrepes":
    "🍮 Disusun dari tumpukan crepes dilapisi dengan fresh cream didalamnya. Varian rasa yang bervariasi mulai dari chocolate, lotus biscoff hingga seasonal fruit. 🍮",

  "Cheesecake":
    "🧀 Disajikan sebagai dessert. Cream cheese, tepung dan telur sebagai bahan baku utama menjadikan cheesecake menjadi salah satu hidangan yang lembut. Dapat dinikmati menggunakan selai stroberi, blueberry atau tanpa selai. 🧀",

  "Soft Cookies":
    "🍪 Menggunakan butter yang berkualitas menjadikan soft cookies memiliki tekstur yang lembut di bagian dalam dan crunchy di bagian luarnya. Soft cookies memiliki banyak varian, seperti classic dan cheese red velvet yang menggunakan filling dari cream cheese. 🍪"
};

  const buttons = document.querySelectorAll(".menu-categories button");
  const desc = document.getElementById("menu-description");

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {

      // Hilangkan kelas show untuk reset animasi
      desc.classList.remove("show");

      // Ganti isi teks + animasi fade
      setTimeout(() => {
        desc.textContent = descriptions[btn.textContent];
        desc.classList.add("show");
      }, 50);

      // Tombol aktif
      document.querySelector(".menu-categories .active")?.classList.remove("active");
      btn.classList.add("active");
    });
  });
</script>
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
      
      <!-- 🔹 Ikon Sosial Media -->
      <div class="social-icons">
        <a href="https://wa.me/6285800611600" target="_blank" class="whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
        </a>
        <a href="https://www.instagram.com/amigo.cake?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
      </div>
    </div>

    <div>
      <h3>Opening Hours</h3>
      <p>Everyday</p>
      <p>08.00 AM - 10.00 PM</p>
    </div>
  </div>
  <p class="footer-bottom">© 2025 All Rights Reserved By Kita Sendiri :)</p>
</footer>

  <script src="js/script.js"></script>
  <script>
fetch("../backend/get_products.php")
  .then(response => response.json())
  .then(products => {
    const grid = document.getElementById("product-grid");
    grid.innerHTML = "";

    products.forEach(p => {
      const card = `
        <div class="product-card">
          <div class="product-image">
            <img src="../backend/${p.PATH_GAMBAR}" alt="${p.NAMA_PRODUCT}">
          </div>

          <div class="product-info">
            <h3>${p.NAMA_PRODUCT}</h3>
            <p class="price">Rp${p.HARGA.toLocaleString()}</p>
            <p class="category">${p.KATEGORI_PRODUCT}</p>
            <p class="size">Diameter: ${p.DIAMETER_SIZE} cm</p>
          </div>
        </div>
      `;
      grid.innerHTML += card;
    });
  })
  .catch(err => console.error("Error:", err));
</script>
</body>
</html>
