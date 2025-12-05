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

    <!-- MENU NAV -->
    <nav class="nav-links" id="navLinks">
        <a href="dashboard.php">Home</a>
        <a href="menu.php" class="active">Menu</a>
        <a href="about.php">About</a>
        <a href="galery.php">Galery</a>

        <!-- LOGOUT MOBILE (hanya muncul di mobile) -->
        <a href="logout.php" class="logout-mobile logout-trigger">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#690108" viewBox="0 0 16 16">
              <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
              <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
            Keluar
        </a>
    </nav>

    <!-- LOGOUT DESKTOP (icon) -->
    <div class="user-actions desktop-only">
        <a href="logout.php" class="logout-btn logout-trigger">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#690108" viewBox="0 0 16 16">
              <path d="M6 3.5A.5.5 0 0 1 6.5 3h6a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h6A1.5 1.5 0 0 0 14 12.5v-9A1.5 1.5 0 0 0 12.5 2h-6A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 1 1 1 0v-2z"/>
              <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
        </a>
    </div>

    <!-- HAMBURGER -->
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

<?php echo "". ($_SESSION['user_id'] ?? ''); ?>

<button class="view-more" onclick="openOrderPopup()">Order Now</button>

<!-- POPUP ORDER + PEMBAYARAN (2 STEP) -->
<div id="popupWrap" class="popup-overlay" style="display:none;">

    <div class="popup-box">

        <!-- CLOSE BUTTON -->
        <span class="close-btn" onclick="closeAll()">✕</span>

        <!-- STEP 1 : ORDER FORM -->
       <div id="stepOrder" style="display:block;">

    <h2 class="popup-title">Order Cake</h2>

    <!-- KATEGORI & PRODUCT (dipindah ke sini) -->
    <label>Pilih Kategori</label>
    <select id="kategoriProduct" onchange="loadProductByKategori()">
        <option value="">-- Pilih Kategori --</option>
    </select>

    <label>Pilih Produk</label>
    <select id="namaProduct" disabled onchange="fillProductDetail()">
        <option value="">-- Pilih Produk --</option>
    </select>

    <!-- CUSTOM AREA -->
    <div id="customArea" style="display:none;">
        <input type="text" id="diameterCake" placeholder="Diameter (custom cake)">
        <input type="text" id="varianCake" placeholder="Varian Cake">
        <input type="text" id="tulisanCake" placeholder="Req Tulisan Cake (latin/biasa)">
    </div>

    <!-- HARGA -->
  <div id="hargaGroup">
    <label>Harga</label>
    <input type="text" id="harga" readonly>
    </div>


    <!-- FORM ORDER -->
    <input type="text" id="namaPemesan" placeholder="Nama Pemesan">
    <input type="text" id="telpPemesan" placeholder="No. Telp">
    <input type="text" id="alamatPemesan" placeholder="Alamat">
    <input type="date" id="tanggalPemesan">
    <input type="time" id="waktuAmbil">

    <button class="btn-primary" onclick="goToPayment()">Bayar</button>
</div>

<!-- STEP 2 : PEMBAYARAN -->
<div id="stepPayment" style="display:none;">

    <h2 class="popup-title">Pembayaran</h2>

    <label class="label-title">Metode Pembayaran</label>

    <div class="select-box">
        <input type="radio" name="pay" id="transfer">
        <label for="transfer">Transfer Bank</label>
    </div>

    <!-- CARD NOMOR REKENING -->
    <div id="rekeningCard" class="rekening-card" style="display:none;">
        <div class="bank-logo">🏦 BANK BCA</div>

        <div class="rekening-number">123 456 7890</div>

        <div class="rekening-name">a/n Amigo Cake</div>

        <button type="button" class="copy-btn" onclick="copyRekening()">Salin</button>
    </div>

    <!-- UPLOAD BUKTI -->
    <div id="uploadGroup" style="display:none;">
        <label class="label-title">Upload Bukti Pembayaran</label>

        <label class="upload-area" id="uploadBox">
            <input type="file" id="buktiBayar" hidden>
            <img src="https://cdn-icons-png.flaticon.com/512/685/685655.png">
        </label>

        <p id="fileName" style="font-size: 14px; margin-top: 8px;"></p>
    </div>

    <div class="select-box">
        <input type="radio" name="pay" id="cod">
        <label for="cod">Bayar di tempat</label>
    </div>

    <button class="btn-primary" onclick="finishPayment()">Order</button>

</div>

</section>

<!-- FOOTER -->
 <footer>
  <div class="footer-content">
    <div>
      <h3>Contact Us</h3>
      <p>📍 Jl Barito IVA No. 19 Keringan, Nganjuk</p>
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
function loadKategori() {

    fetch("product_api.php?mode=kategori")
        .then(r => r.json())
        .then(data => {
            console.log("KATEGORI:", data);

            let select = document.getElementById("kategoriProduct");

            select.innerHTML = `<option value="">-- Pilih Kategori --</option>`;

            data.forEach(k => {
                select.innerHTML += `<option value="${k}">${k}</option>`;
            });
        })
        .catch(err => console.error("FETCH ERROR:", err));
}


function loadProductByKategori() {
    let kategori = document.getElementById("kategoriProduct").value;
    let productSelect = document.getElementById("namaProduct");
    let hargaInput = document.getElementById("harga");

    // Jika tidak pilih kategori
    if (!kategori) {
        productSelect.innerHTML = `<option value="">-- Pilih Produk --</option>`;
        hargaInput.value = "";
        document.getElementById("hargaGroup").style.display = "block";
        return;
    }

    // JIKA CUSTOM CAKE
    if (kategori.toLowerCase() === "custom cake") {

        document.getElementById("customArea").style.display = "block";
        productSelect.innerHTML = `<option>(Custom tidak punya produk)</option>`;
        productSelect.disabled = true;

        // SEMBUNYIKAN HARGA
        document.getElementById("hargaGroup").style.display = "none";
        hargaInput.value = ""; // harga kosong

        return;
    }

    // NORMAL (kategori lain)
    document.getElementById("customArea").style.display = "none";
    productSelect.disabled = false;

    // TAMPILKAN HARGA
    document.getElementById("hargaGroup").style.display = "block";

    productSelect.innerHTML = `<option>Loading...</option>`;

    // Fetch produk
    fetch("product_api.php?mode=product&kategori=" + encodeURIComponent(kategori))
        .then(r => r.json())
        .then(data => {
            productSelect.innerHTML = `<option value="">-- Pilih Produk --</option>`;
            data.forEach(p => {
                productSelect.innerHTML += `
                    <option value="${p.ID_PRODUCT}" data-harga="${p.HARGA}">
                        ${p.NAMA_PRODUCT}
                    </option>`;
            });
        })
        .catch(err => console.error("FETCH ERROR:", err));
}


// load kategori saat modal dibuka
document.addEventListener("DOMContentLoaded", loadKategori);
</script>

<script>
// SAFE GET ELEMENT
function el(id) {
    return document.getElementById(id);
}

// =====================================================
// RESET POPUP
// =====================================================
function openOrderPopup() {

    el("stepOrder").style.display = "block";
    el("stepPayment").style.display = "none";

    // RESET INPUT
    el("namaPemesan").value = "";
    el("telpPemesan").value = "";
    el("alamatPemesan").value = "";
    el("tanggalPemesan").value = "";
    el("diameterCake").value = "";
    el("varianCake").value = "";
    el("tulisanCake").value = "";
    el("waktuAmbil").value = "";

    // FIX REKENING & UPLOAD
    el("rekeningCard").style.display = "none";
    el("uploadGroup").style.display = "none";

    // RESET RADIO
    document.querySelectorAll("input[name='pay']").forEach(r => r.checked = false);

    // RESET BUKTI FILE
    el("buktiBayar").value = "";

    el("popupWrap").style.display = "flex";
}

// =====================================================
// CLOSE POPUP
// =====================================================
function closeAll() {
    el("popupWrap").style.display = "none";
}

// =====================================================
// STEP 1 → INSERT ORDER
// =====================================================
function goToPayment() {

    let nama = el("namaPemesan").value;
    let telp = el("telpPemesan").value;

    if (!nama || !telp) {
        alert("Nama dan No. Telp wajib diisi!");
        return;
    }

    let formData = new FormData();
    formData.append("step", "order");
    formData.append("nama", nama);
    formData.append("telp", telp);
    formData.append("alamat", el("alamatPemesan").value);
    formData.append("tanggal", el("tanggalPemesan").value);
    formData.append("diameter", el("diameterCake").value);
    formData.append("varian", el("varianCake").value);
    formData.append("tulisan", el("tulisanCake").value);
    formData.append("waktu", el("waktuAmbil").value);
    formData.append("kategori", el("kategoriProduct").value);
    formData.append("product_id", el("namaProduct").value);

    let kategori = el("kategoriProduct").value;
    if (kategori.toLowerCase() !== "custom cake") {
        formData.append("harga", el("harga").value);
    } else {
        formData.append("harga", "0"); 
    }

    fetch("order_process.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(res => {

        if (res.status === "success") {

            window.currentOrderID = res.order_id;

            el("stepOrder").style.display = "none";
            el("stepPayment").style.display = "block";

        } else {
            alert("Gagal menyimpan order.");
        }
    })
    .catch(err => console.error("FETCH ERROR:", err));
}



// =====================================================
// STEP 2 → SAVE PAYMENT
// =====================================================
function finishPayment() {

    let metode = document.querySelector("input[name='pay']:checked");

    if (!metode) {
        alert("Pilih metode pembayaran terlebih dahulu!");
        return;
    }

    metode = metode.id;

    let formData = new FormData();
    formData.append("step", "payment");
    formData.append("order_id", window.currentOrderID);
    formData.append("metode", metode);

    if (metode === "transfer") {

        let buktiFile = el("buktiBayar").files[0];

        if (!buktiFile) {
            alert("Upload bukti pembayaran dulu!");
            return;
        }

        formData.append("bukti", buktiFile);
    }

    fetch("order_process.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(res => {

        if (res.status === "success") {
            alert("Order berhasil dibuat!");
            window.location.href = "pesanan.php";
        } else {
            alert("Gagal menyimpan pembayaran.");
        }
    })
    .catch(err => console.error("FETCH ERROR:", err));
}



// =====================================================
// SHOW / HIDE REKENING CARD & UPLOAD
// =====================================================

// Transfer
if (el("transfer")) {
    el("transfer").addEventListener("change", function () {

        el("rekeningCard").style.display = "block";
        el("uploadGroup").style.display = "block";

        document.querySelector(".rekening-number").textContent = "123 456 7890";
        document.querySelector(".rekening-name").textContent = "a/n Amigo Cake";
    });
}

// COD
if (el("cod")) {
    el("cod").addEventListener("change", function () {
        el("rekeningCard").style.display = "none";
        el("uploadGroup").style.display = "none";
        el("buktiBayar").value = "";
    });
}

// =====================================================
// COPY NOMOR REKENING
// =====================================================
function copyRekening() {
    const norek = document.querySelector(".rekening-number").textContent.trim();
    navigator.clipboard.writeText(norek);
    alert("Nomor rekening disalin: " + norek);
}

// =====================================================
// CLICK UPLOAD BOX
// =====================================================
if (el("uploadBox")) {
    el("uploadBox").addEventListener("click", function () {
        el("buktiBayar").click();
    });
}

// FILE NAME (opsional)
if (el("buktiBayar")) {
    el("buktiBayar").addEventListener("change", function () {
        console.log("File dipilih:", this.files[0]);
    });
}

</script>


<script>
function fillProductDetail() {
    let selected = document.querySelector("#namaProduct option:checked");

    if (selected && selected.dataset.harga) {
        document.getElementById("harga").value = selected.dataset.harga;
    }
}
</script>
<script>
// Load kategori saat halaman dibuka
document.addEventListener("DOMContentLoaded", () => {
    fetch("product_api.php?mode=kategori")
    .then(r => r.json())
    .then(data => {
        let kategoriSelect = document.getElementById("kategoriProduct");
        data.forEach(k => {
            kategoriSelect.innerHTML += `<option value="${k}">${k}</option>`;
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".product-card").forEach((card, i) => {
        card.style.animationDelay = (1 + i * 0.12) + "s";
    });
});
</script>
  <!-- LOGOUT ANIMATION POPUP -->
<div id="logoutOverlay" class="logout-overlay">
    <div class="logout-box">
        <div class="logout-spinner"></div>
        <p>See you again!👋</p>
    </div>
</div>
<script>
document.querySelectorAll(".logout-trigger").forEach(btn => {
    btn.addEventListener("click", function(e) {

        e.preventDefault(); // cegah redirect langsung
        
        const overlay = document.getElementById("logoutOverlay");
        overlay.classList.add("active");

        // Redirect setelah animasi
        setTimeout(() => {
            window.location.href = this.href;
        }, 1300); 
    });
});
</script>
</body>
</html>