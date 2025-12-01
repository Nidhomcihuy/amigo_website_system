<?php
// (opsional) jika nanti mau load data dari database, taruh di sini.
// include "db.php";

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Amigo Cake</title>
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
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

    <!-- MENU NAV -->
    <nav class="nav-links" id="navLinks">
        <a href="dashboard.php" class="active">Home</a>
        <a href="menu.php">Menu</a>
        <a href="about.php">About</a>
        <a href="galery.php">Galery</a>

        <!-- LOGOUT MOBILE (hanya muncul di mobile) -->
        <a href="logout.php" class="logout-mobile" onclick="return confirm('Yakin ingin keluar?')">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 16 16">
              <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
              <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
            Keluar
        </a>
    </nav>

    <!-- LOGOUT DESKTOP (icon) -->
    <div class="user-actions desktop-only">
        <a href="logout.php" class="logout-btn" onclick="return confirm('Yakin ingin keluar?')">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff" viewBox="0 0 16 16">
              <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 1 1 1 0v-2z"/>
              <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
        </a>
    </div>

    <!-- HAMBURGER -->
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</header>


 <!-- HERO SECTION -->
<section class="hero">
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <ul class="hero-slider">

      <li class="slide li-active">
        <h1>Custom Cake</h1>
        <p>
          Wujudkan kue impianmu bersama kami! Di toko kue kami, setiap lapisan kue dibuat dengan penuh cinta
          dan bahan premium. Kamu bisa menyesuaikan rasa, ukuran, hingga desain sesuai keinginan — cocok untuk
          ulang tahun, pernikahan, atau momen spesial lainnya.
        </p>
      </li>

      <li class="slide">
        <h1>Tentang Kami</h1>
        <p>
          Kami adalah toko kue rumahan yang berfokus pada cita rasa autentik dan tampilan yang menggoda.
          Dengan pengalaman lebih dari 5 tahun, kami berkomitmen menghadirkan kue yang tidak hanya cantik dilihat,
          tapi juga lembut di setiap gigitan.
        </p>
      </li>

      <li class="slide">
        <h1>Our Menu</h1>
        <p>
          Dari kue ulang tahun hingga dessert box, setiap produk kami dibuat fresh setiap hari.
          Pilih favoritmu dari berbagai varian rasa seperti cokelat, red velvet, dan keju — semua siap
          menemani momen manismu.
        </p>
      </li>

    </ul>

    <div class="hero-indicator">
      <span class="li-active"></span>
      <span></span>
      <span></span>
    </div>
  </div>
</section>

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

<button class="view-more" onclick="window.location.href='menu.php'">
    Pergi ke menu
</button>


</section>

   <!-- ABOUT SECTION -->
  <section class="about">
    <div class="about-text">
      <h2>We Are Amigo Cake 🎂</h2>
      <p>Di sini, kami percaya kalau setiap potongan kue bukan cuma soal rasa, tapi juga tentang momen dan kebahagiaan yang menyertainya.</p>
      <p>Dari resep klasik hingga kreasi kekinian, semua kue kami dibuat dengan bahan berkualitas dan penuh cinta dari dapur kami yang hangat.</p>
      <p>Baik kamu lagi cari kue ulang tahun, 
kue pernikahan, atau cuma pengin manisin
hari, Amigo Cake siap nemenin setiap momenmu biar makin spesial. Jadi, duduk 
santai aja, jelajahi menu kami, dan biarkan aroma manis dari Amigo Cake bikin harimu 
lebih berwarna 🍰✨</p>
    </div>
      <div class="book-map">
        <h3>Lokasi Kami</h3>
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.48670247011!2d111.90383962085413!3d-7.593536742960983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784b9afb9b0689%3A0xae3a9b1ab10dba7b!2sAmigo%20Cake!5e0!3m2!1sid!2sid!4v1763085328485!5m2!1sid!2sid"
  width="600"
  height="450"
  style="border:0;"
  allowfullscreen=""
  loading="lazy"
  referrerpolicy="no-referrer-when-downgrade">
</iframe></iframe>

        <p class="address">Jl Barito IVA No. 19 Keringan, Nganjuk</p>
      </div>
  </section>


  <!-- ==== GALERI ==== -->
<section class="galeri">
  <div class="galeri-container">
    <div class="book-text">

      <h2>Galeri Kegiatan Kami</h2>
      <p class="galeri-subtitle">"Momen berharga yang kami abadikan dalam setiap langkah perjalanan bersama.✨"</p>

      <!-- ==== WRAPPER GRID ==== -->
      <div class="galeri-grid">

         <div class="galeri-card fade-card">
          <div class="galeri-image" style="background-image: url('image_costumer/coba5.jpeg');"></div>
          <div class="galeri-info">
            <h3>Ngopaski</h3>
          </div>
        </div>

        <div class="galeri-card fade-card">
          <div class="galeri-image" style="background-image: url('image_costumer/coba5.jpeg');"></div>
          <div class="galeri-info">
            <h3>Ngopaski</h3>
          </div>
        </div>

        <div class="galeri-card fade-card">
          <div class="galeri-image" style="background-image: url('image_costumer/coba5.jpeg');"></div>
          <div class="galeri-info">
            <h3>Ngopaski</h3>
          </div>
        </div>

        <div class="galeri-card fade-card">
          <div class="galeri-image" style="background-image: url('image_costumer/coba5.jpeg');"></div>
          <div class="galeri-info">
            <h3>Ngopaski</h3>
          </div>
        </div>

      </div> <!-- end galeri-grid -->

    </div> <!-- end book-text -->
  </div> <!-- end galeri-container -->
</section>


<!-- ==== LIGHTBOX POPUP ==== -->
<div id="lightbox" class="lightbox">
  <img id="lightbox-img" src="">
</div>


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
      <p>08.00 - 18.00 </p>
    </div>
  </div>
  <p class="footer-bottom">© 2025 All Rights Reserved By Kita Sendiri :)</p>
</footer>


  <script src="js/script.js"></script>
  <script>
  const slides = document.querySelectorAll('.hero-slider .slide');
  const indicators = document.querySelectorAll('.hero-indicator span');
  const slider = document.querySelector('.hero-slider');

  let index = 0;
  let startX = 0;

  // Fungsi tampilkan slide
  function showSlide(i) {
    slides.forEach(s => s.classList.remove('li-active'));
    indicators.forEach(d => d.classList.remove('li-active'));

    slides[i].classList.add('li-active');
    indicators[i].classList.add('li-active');
  }

  // Auto slide tiap 4 detik
  setInterval(() => {
    index = (index + 1) % slides.length;
    showSlide(index);
  }, 4000);

  // Swipe Gesture
  slider.addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
  });

  slider.addEventListener('touchend', e => {
    const endX = e.changedTouches[0].clientX;

    // swipe kiri → slide berikutnya
    if (startX - endX > 50) {
      index = (index + 1) % slides.length;
      showSlide(index);
    }

    // swipe kanan → slide sebelumnya
    if (endX - startX > 50) {
      index = (index - 1 + slides.length) % slides.length;
      showSlide(index);
    }
  });
</script>

<script>
// ========== FADE-IN ANIMATION ==========  
const fadeCards = document.querySelectorAll(".fade-card");

function fadeInOnScroll() {
  fadeCards.forEach(card => {
    const rect = card.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      card.classList.add("show");
    }
  });
}

window.addEventListener("scroll", fadeInOnScroll);
fadeInOnScroll();

// ========== LIGHTBOX POP-UP ==========  
const lightbox = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightbox-img");

document.querySelectorAll(".galeri-card").forEach(card => {
  card.addEventListener("click", () => {
    const bg = card.querySelector(".galeri-image").style.backgroundImage;
    const url = bg.slice(5, -2); // ambil URL dari background-image
    lightboxImg.src = url;
    lightbox.classList.add("show");
  });
});

// Click anywhere on lightbox to close
lightbox.addEventListener("click", () => {
  lightbox.classList.remove("show");
});
</script>
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
</body>
</html>
