<?php

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About | Amigo Cake</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/about.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Dancing+Script:wght@700&display=swap" rel="stylesheet" />
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
      <a href="menu.php">Menu</a>
      <a href="about.php" class="active">About</a>
      <a href="galery.php">Galery</a>
    </nav>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
  </header>


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
</body>
</html>
