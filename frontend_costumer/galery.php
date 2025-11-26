<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book A Cake | Amigo Cake</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Dancing+Script:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/galery.css?v=<?php echo time(); ?>">
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
      <a href="menu.php">Menu</a>
      <a href="about.php">About</a>
      <a href="galery.php"  class="active">Galery</a>
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
</body>
</html>
