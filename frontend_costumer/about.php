<?php

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About | Amigo Cake</title>
  <link rel="stylesheet" href="css/about.css?v=<?php echo time(); ?>">
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
       <div class="user-actions">
    <a href="logout.php" class="logout-btn" onclick="return confirm('Yakin ingin keluar?')">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#fff " viewBox="0 0 16 16">
          <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
          <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
        </svg>
    </a>
</div>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
  </header>


    <!-- ABOUT SECTION -->
  <section class="about">
    
    <div class="about-text">
      <h2>We Are Amigo Cake 🎂</h2>
      <p>Berawal dari sebuah oven listrik kecil, perjalanan ini dimulai dengan sederhana namun dipenuhi dengan cinta, ketekunan, dan keyakinan yang besar.</p>
      <p>Dari alat yang terbatas itulah kami belajar memahami setiap detail proses, menerima setiap kegagalan sebagai pelajaran, dan merayakan setiap keberhasilan kecil sebagai pijakan untuk melangkah lebih jauh.</p>
      <p>Tidak terhitung berapa kali adonan harus diulang, resep harus diperbaiki, dan teknik harus ditingkatkan, namun justru di situlah kami menemukan makna sejati dari berkembang—bahwa kesempurnaan lahir dari proses panjang yang penuh kesabaran.</p>
      <p>Seiring waktu, usaha kecil ini tumbuh, bukan hanya dari segi alat dan kemampuan, tetapi juga dari mimpi dan keyakinan bahwa hal baik selalu layak diperjuangkan. Dari oven kecil itu pula kami belajar bahwa segala sesuatu memiliki titik awal, dan dengan komitmen yang tulus, sesuatu yang sederhana dapat berkembang menjadi lebih besar dan lebih berarti.</p>
      <p>Kini, berada di titik ini bukanlah akhir perjalanan, melainkan langkah baru untuk terus berinovasi, berkarya, dan menghadirkan sesuatu yang lebih baik. Dan dengan semangat yang sama seperti saat pertama kali memulai, kami akan terus bertumbuh—pelan namun pasti—hingga nanti.🍰✨</p>
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
      <p>08.00 - 18.00 </p>
    </div>
  </div>
  <p class="footer-bottom">© 2025 All Rights Reserved By Kita Sendiri :)</p>
</footer>
  <script src="js/script.js"></script>
</body>
</html>
