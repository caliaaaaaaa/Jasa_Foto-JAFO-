<?php $this->load->view('kasir/components/header'); ?>
<?php $this->load->view('kasir/components/navbar'); ?>

<?php $active = 'dashboard'; ?>
<?php $this->load->view('kasir/components/sidebar', compact('active')); ?>
<div class="layout">
<div class="main">

<style>
	
	.layout {
    display: flex;
}

.main {
    flex: 1;
    padding: 30px;
    background: #f4f6fb;
    min-height: 100vh;
}
/* BACKGROUND */



/* TITLE */
.title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
}

/* GRID CARD */
.card-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
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
    box-shadow: 0 5px 15px rgba(59,111,182,0.4);
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

/* SECTION */
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

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #6c8cd5, #3B6FB6);
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 12px;
    margin-top: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(59,111,182,0.4);
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
        <i class="fa fa-clipboard-list card-icon"></i>
        <div class="card-text">Total Transaksi</div>
        <div class="card-value"><?= $total ?? 0 ?> Transaksi</div>
    </div>

    <div class="card-box">
        <i class="fa fa-box card-icon"></i>
        <div class="card-text">Jumlah Paket</div>
        <div class="card-value"><?= $paket ?? 0 ?> Paket</div>
    </div>

    <div class="card-box">
        <i class="fa fa-hourglass-half card-icon"></i>
        <div class="card-text">Pesanan Belum Selesai</div>
        <div class="card-value"><?= $belum_selesai ?? 0 ?> Pesanan</div>
    </div>

</div>



	<!-- 🔥 BAWAH -->
<div class="section">

    <!-- MAP -->
   <div class="box map-box">
    <h4>Lokasi Pesanan (Hari ini)</h4>

	<?php if(!empty($transaksi_hari_ini)): 
		$t = $transaksi_hari_ini[0];
	?>

        <iframe 
            src="https://www.google.com/maps?q=<?= urlencode($t->lokasi) ?>&output=embed"
            width="100%" height="250"
            style="border-radius:15px;">
        </iframe>

        <p style="margin-top:10px; font-weight:600;">
            📍 <?= $t->nama_paket ?> - <?= $t->lokasi ?>
        </p>

    <?php else: ?>

        <iframe 
            src="https://www.google.com/maps?q=Subang&output=embed"
            width="100%" height="250"
            style="border-radius:15px;">
        </iframe>

        <p style="margin-top:10px;">
            Tidak ada pesanan hari ini
        </p>

    <?php endif; ?>

</div>

    <!-- 📅 KALENDER -->
    <div class="box calendar-box">
        <h4>Calendar</h4>
        <div id="calendar"></div>
    </div>

</div>

<!-- 🔥 FULLCALENDAR -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

	var events = <?= json_encode(array_map(function($t){
		return [
			"title" => $t->nama_paket,
			"date" => $t->tanggal_acara
		];
	}, $semua_transaksi)); ?>;

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        height: 400,
        events: events
    });

    calendar.render();
});
</script>

</div>

</div>
</div>

<?php $this->load->view('kasir/components/footer'); ?>
 