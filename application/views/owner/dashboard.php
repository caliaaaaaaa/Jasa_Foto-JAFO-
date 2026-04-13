<?php 

$this->load->view('owner/components/header'); 
$this->load->view('owner/components/navbar'); 


$active = 'dashboard'; 
$this->load->view('owner/components/sidebar', compact('active')); 
?>

<div class="main">

<style>

/* TITLE (judul dashboard) */
.title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
}

/* GRID CARD (layout 4 kotak statistik) */
.card-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

/* CARD BOX (kotak statistik) */
.card-box {
    position: relative;
    padding: 25px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.6);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: 0.4s;
    overflow: hidden;
}

/* efek hover card */
.card-box:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

/* ICON pada card */
.card-icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 20px;
    background: linear-gradient(135deg, #6c8cd5, #3B6FB6);
    color: white;
    padding: 12px;
    border-radius: 50%;
}

/* TEXT kecil pada card */
.card-text {
    font-size: 13px;
    color: #6b7280;
}

/* NILAI utama pada card */
.card-value {
    font-size: 26px;
    font-weight: bold;
    color: #2F4B7C;
}

/* SECTION bawah (grafik + kalender) */
.section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
    margin-top: 30px;
}

/* BOX container */
.box {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* RESPONSIVE (untuk HP) */
@media(max-width:900px){
    .card-container {
        grid-template-columns: 1fr;
    }
    .section {
        grid-template-columns: 1fr;
    }
}

</style>

<br>

<!-- CARD STATISTIK DASHBOARD -->
<div class="card-container">

    <!-- CARD 1: Pendapatan bulan ini -->
    <div class="card-box">
        <i class="fa fa-money-bill card-icon"></i>
        <div class="card-text">Pendapatan Bulan Ini</div>
        <!-- menampilkan total pendapatan dari controller -->
        <div class="card-value">Rp <?= number_format($pendapatan_bulan ?? 0) ?></div>
    </div>

    <!-- CARD 2: jumlah pesanan hari ini -->
    <div class="card-box">
        <i class="fa fa-clipboard-list card-icon"></i>
        <div class="card-text">Pesanan Hari Ini</div>
        <div class="card-value"><?= $pesanan_hari_ini ?? 0 ?> Pesanan</div>
    </div>

    <!-- CARD 3: jumlah paket -->
    <div class="card-box">
        <i class="fa fa-box card-icon"></i>
        <div class="card-text">Jumlah Paket</div>
        <div class="card-value"><?= $jumlah_paket ?? 0 ?> Paket</div>
    </div>

    <!-- CARD 4: pesanan yang belum selesai -->
    <div class="card-box">
        <i class="fa fa-hourglass-half card-icon"></i>
        <div class="card-text">Belum Selesai</div>
        <div class="card-value"><?= $belum_selesai ?? 0 ?> Pesanan</div>
    </div>

</div>

<!-- SECTION BAWAH -->
<div class="section">

    <!-- GRAFIK PENDAPATAN -->
    <div class="box">
        <h4>Grafik Pendapatan</h4>
        <!-- canvas untuk Chart.js -->
        <canvas id="chart"></canvas>
    </div>

    <!-- KALENDER EVENT -->
    <div class="box calendar-box">
        <h4>Calendar</h4>
        <!-- tempat FullCalendar -->
        <div id="calendar"></div>
    </div>

<!-- IMPORT CHART JS (library grafik) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// array untuk label bulan
let bulan = [];

// array untuk total pendapatan
let total = [];

// ambil data dari PHP ($grafik) lalu masukkan ke JS
<?php foreach($grafik as $g): ?>
    bulan.push("Bulan <?= $g->bulan ?>"); // label bulan
    total.push(<?= $g->total ?>); // nilai pendapatan
<?php endforeach; ?>

// membuat grafik line menggunakan Chart.js
new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Pendapatan',
            data: total,
            tension: 0.4 // membuat garis lebih smooth
        }]
    }
});
</script>

<!--  IMPORT FULLCALENDAR -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
// jalankan saat halaman selesai load
document.addEventListener('DOMContentLoaded', function () {

    // mengambil data transaksi dari PHP lalu ubah ke format JSON
    var events = <?= json_encode(array_map(function($t){
        return [
            "title" => $t->nama_paket, // nama paket jadi judul event
            "date" => $t->tanggal_acara // tanggal event
        ];
    }, $transaksi)); ?>;

    // inisialisasi kalender
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth', // tampilan bulanan
        height: 400,
        events: events // data event dari transaksi
    });

    // render kalender
    calendar.render();
});
</script>

</div>

<?php 

$this->load->view('owner/components/footer'); 
?>
