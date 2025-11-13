<?php
// Catatan: Variabel-variabel ini hanya contoh.
// Anda akan menggantinya dengan logika pengambilan data dari database Anda.

$total_pendapatan = "Rp. 1.500.000";
$kenaikan_pendapatan = "+15.000"; // Contoh kenaikan/penurunan
$total_order = "251";
$bulan_ini = "Bulan Ini";

// Data untuk grafik bar (contoh)
// Kunci adalah tanggal (format d nov), Nilai adalah jumlah order
$data_grafik = [
    "11 nov" => 27,
    "12 nov" => 22,
    "13 nov" => 25,
    "14 nov" => 25,
    "15 nov" => 17,
    "16 nov" => 19,
];
// Untuk sumbu Y, ambil nilai maksimal dari data dan tambahkan sedikit padding.
$max_y = max($data_grafik) + 5;
$y_steps = 5; // Langkah untuk label sumbu Y (0, 5, 10, 15, 20, 25)

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Amigo - Konten Utama</title>
    <style>
        /* Gaya dasar untuk meniru tampilan gambar */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7; /* Warna latar belakang */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .main-content {
            padding: 20px 40px;
            /* Jika ada sidebar, sesuaikan padding/margin agar tidak tertutup */
        }

        .header h1 {
            color: #333;
            margin-bottom: 5px;
        }

        .header p {
            color: #888;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .summary-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            flex: 1;
            background-color: #7b1fa2; /* Warna latar belakang card (merah marun gelap) */
            background-color: #8b2b3a; /* Mendekati warna marun di gambar */
            color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.1em;
            margin-bottom: 10px;
            text-transform: capitalize;
        }

        .card-value {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .pendapatan-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        .pendapatan-kenaikan {
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .bulan-label {
            font-size: 0.9em;
            opacity: 0.8;
            text-align: right;
        }

        /* Gaya untuk Grafik */
        .chart-container {
            background-color: #fff;
            padding: 30px 20px 10px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            /* Memastikan grafik berada di bawah card */
            overflow: hidden; 
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 2%;
            height: 300px; /* Tinggi total area grafik */
            position: relative;
            padding-left: 50px; /* Ruang untuk sumbu Y */
        }

        .bar-chart::before {
            content: '';
            position: absolute;
            left: 50px;
            bottom: 0;
            width: calc(100% - 50px);
            height: 1px;
            background-color: #ccc; /* Garis sumbu X */
        }

        .bar-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            position: relative;
            padding-top: 25px;
        }

        .bar {
            width: 70%;
            background-color: #38a169; /* Warna hijau mint */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            transition: height 0.5s ease-out;
        }
        
        .bar-label {
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
            position: absolute;
            bottom: -25px; /* Posisikan label di bawah sumbu X */
        }

        /* Gaya untuk Sumbu Y */
        .y-axis {
            position: absolute;
            left: 0;
            top: 0;
            height: calc(100% - 25px); /* Sesuaikan tinggi agar tidak menutupi label X */
            width: 40px;
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 0.8em;
            color: #555;
        }

        .y-axis span {
            /* Position the Y-axis labels accurately */
            padding-right: 5px;
            position: relative;
        }

        .y-axis span:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            width: calc(100% + 55px);
            height: 1px;
            background-color: #eee; /* Garis grid */
            z-index: 0;
        }
        .y-axis span:last-child::after {
            content: '';
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            width: calc(100% + 55px);
            height: 1px;
            background-color: #eee; /* Garis grid */
            z-index: 0;
        }
        /* Menghapus garis grid untuk angka 1 (agar tidak ada garis di sumbu X) */
        .y-axis span:nth-child(2)::after {
             background-color: transparent; 
        }

    </style>
</head>
<body>

<div class="main-content">

    <div class="header">
        <h1>Hello, Illona</h1>
        <p>this is what's happening in your store this months</p>
    </div>

    <div class="summary-cards">
        
        <div class="card">
            <div class="card-title">total pendapatan</div>
            <div class="card-value"><?php echo htmlspecialchars($total_pendapatan); ?></div>
            <div class="pendapatan-details">
                <span class="pendapatan-kenaikan"><?php echo htmlspecialchars($kenaikan_pendapatan); ?></span>
                <span class="bulan-label"><?php echo htmlspecialchars($bulan_ini); ?></span>
            </div>
        </div>

        <div class="card">
            <div class="card-title">total order</div>
            <div class="card-value"><?php echo htmlspecialchars($total_order); ?></div>
            <div class="bulan-label"><?php echo htmlspecialchars($bulan_ini); ?></div>
        </div>
        
    </div>
    
    <div class="chart-container">
        
        <div class="bar-chart">
            <div class="y-axis">
                <?php 
                // Generate label sumbu Y (misalnya 25, 20, 15, 10, 5, 1)
                for ($i = $max_y - ($max_y % $y_steps); $i >= 1; $i -= $y_steps) {
                    echo "<span>" . $i . "</span>";
                }
                echo "<span>1</span>"; // Tambahkan angka 1 secara manual
                ?>
            </div>

            <?php 
            // Loop melalui data untuk membuat setiap bar
            foreach ($data_grafik as $tanggal => $nilai) {
                // Hitung tinggi bar sebagai persentase dari tinggi maksimum (max_y)
                $height_percent = ($nilai / $max_y) * 100;
                ?>
                <div class="bar-wrapper">
                    <div class="bar" style="height: <?php echo $height_percent; ?>%;"></div>
                    <div class="bar-label"><?php echo htmlspecialchars($tanggal); ?></div>
                </div>
                <?php
            }
            ?>
        </div>
        
    </div>

</div>

</body>
</html>