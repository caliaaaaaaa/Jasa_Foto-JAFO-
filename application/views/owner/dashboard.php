<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>
<?php $active = 'dashboard'; ?>
<?php $this->load->view('owner/components/sidebar', compact('active')); ?>

<div class="main">

<style>

/* BACKGROUND */


/* TITLE */
.title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
}

/* CARD GRID */
.card-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

/* CARD */
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

.card-box:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

/* ICON */
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

/* TEXT */
.card-text {
    font-size: 13px;
    color: #6b7280;
}

.card-value {
    font-size: 26px;
    font-weight: bold;
    color: #2F4B7C;
}

/* SECTION BAWAH */
.section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
    margin-top: 30px;
}

/* BOX */
.box {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* RESPONSIVE */
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

<!-- 🔥 CARD -->
<div class="card-container">

    <div class="card-box">
        <i class="fa fa-money-bill card-icon"></i>
        <div class="card-text">Pendapatan Bulan Ini</div>
        <div class="card-value">Rp <?= number_format($pendapatan_bulan ?? 0) ?></div>
    </div>

    <div class="card-box">
        <i class="fa fa-clipboard-list card-icon"></i>
        <div class="card-text">Pesanan Hari Ini</div>
        <div class="card-value"><?= $pesanan_hari_ini ?? 0 ?> Pesanan</div>
    </div>

    <div class="card-box">
        <i class="fa fa-box card-icon"></i>
        <div class="card-text">Jumlah Paket</div>
        <div class="card-value"><?= $jumlah_paket ?? 0 ?> Paket</div>
    </div>

    <div class="card-box">
        <i class="fa fa-hourglass-half card-icon"></i>
        <div class="card-text">Belum Selesai</div>
        <div class="card-value"><?= $belum_selesai ?? 0 ?> Pesanan</div>
    </div>

</div>

<!-- 🔥 BAWAH -->
<div class="section">

    <!-- 📈 GRAFIK -->
    <div class="box">
        <h4>Grafik Pendapatan</h4>
        <canvas id="chart"></canvas>
    </div>

    <!-- 📅 KALENDER -->
    <!-- 📅 KALENDER -->
    <div class="box calendar-box">
        <h4>Calendar</h4>
        <div id="calendar"></div>
    </div>


<!-- 🔥 CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let bulan = [];
let total = [];

<?php foreach($grafik as $g): ?>
    bulan.push("Bulan <?= $g->bulan ?>");
    total.push(<?= $g->total ?>);
<?php endforeach; ?>

new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Pendapatan',
            data: total,
            tension: 0.4
        }]
    }
});
</script>

<!-- 🔥 FULLCALENDAR -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var events = [
        <?php foreach($transaksi as $t): ?>
        {
            title: "<?= $t->nama_paket ?>",
            date: "<?= $t->tanggal_acara ?>"
        },
        <?php endforeach; ?>
    ];

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        height: 350,
        events: events
    });

    calendar.render();
});
</script>

</div>

<?php $this->load->view('owner/components/footer'); ?>
