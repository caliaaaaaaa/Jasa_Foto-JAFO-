<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'dashboard'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* BACKGROUND: memberikan warna latar belakang halaman dengan gradasi */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* TITLE: styling untuk judul halaman dashboard */
.title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
}

/* GRID CARD: mengatur layout card menjadi 3 kolom */
.card-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

/* CARD: kotak utama untuk menampilkan data statistik */
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

/* EFEK HOVER CARD: animasi saat mouse diarahkan ke card */
.card-box:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

/* ICON: ikon di pojok kanan atas card */
.card-icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 22px;
    background: linear-gradient(135deg, #6c8cd5, #3B6FB6);
    color: white;
    padding: 12px;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(59,111,182,0.4);
}

/* TEXT: teks keterangan kecil pada card */
.card-text {
    font-size: 13px;
    color: #6b7280;
}

/* VALUE: angka utama pada card */
.card-value {
    font-size: 26px;
    font-weight: bold;
    color: #2F4B7C;
}

/* SECTION: layout bagian bawah (map dan kalender) */
.section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
    margin-top: 30px;
}

/* BOX: container umum untuk map dan kalender */
.box {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* MAP: efek zoom ringan saat hover peta */
.map-box iframe {
    transition: 0.3s;
}

.map-box iframe:hover {
    transform: scale(1.02);
}

/* BUTTON: styling tombol umum */
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

/* EFEK HOVER BUTTON */
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(59,111,182,0.4);
}

/* RESPONSIVE: tampilan mobile */
@media(max-width:900px){
    .card-container {
        grid-template-columns: 1fr;
    }
    .section {
        grid-template-columns: 1fr;
    }
}

</style>

<!-- JUDUL HALAMAN -->
<h2 class="title"></h2>

<!-- CARD STATISTIK -->
<div class="card-container">

    <!-- CARD TOTAL PESANAN HARI INI -->
    <div class="card-box">
        <i class="fa fa-clipboard-list card-icon"></i>
        <div class="card-text">Total Pesanan Hari Ini</div>
        <div class="card-value"><?= $total_hari_ini ?> Pesanan</div>
    </div>

    <!-- CARD JUMLAH PAKET -->
    <div class="card-box">
        <i class="fa fa-box card-icon"></i>
        <div class="card-text">Jumlah Paket</div>
        <div class="card-value"><?= $jumlah_paket ?> Paket</div>
    </div>

    <!-- CARD PESANAN BELUM SELESAI -->
    <div class="card-box">
        <i class="fa fa-hourglass-half card-icon"></i>
        <div class="card-text">Pesanan Belum Selesai</div>
        <div class="card-value"><?= $belum_selesai ?> Pesanan</div>
    </div>

</div>

<!-- BAGIAN BAWAH: MAP DAN KALENDER -->
<div class="section">

    <!-- MAP LOKASI PESANAN -->
    <div class="box map-box">
        <h4>Lokasi Pesanan (Hari ini)</h4>

		<?php if(!empty($transaksi_hari_ini)): 
			$t = $transaksi_hari_ini[0];
		?>

        <!-- MAP BERDASARKAN LOKASI TRANSAKSI -->
        <iframe 
            src="https://www.google.com/maps?q=<?= urlencode($t->lokasi) ?>&output=embed"
            width="100%" height="250"
            style="border-radius:15px;">
        </iframe>

        <!-- INFORMASI LOKASI -->
        <p style="margin-top:10px; font-weight:600;">
            📍 <?= $t->nama_paket ?> - <?= $t->lokasi ?>
        </p>

        <?php else: ?>

        <!-- MAP DEFAULT JIKA TIDAK ADA DATA -->
        <iframe 
            src="https://www.google.com/maps?q=Subang&output=embed"
            width="100%" height="250"
            style="border-radius:15px;">
        </iframe>

        <!-- PESAN JIKA TIDAK ADA TRANSAKSI -->
        <p style="margin-top:10px;">
            Tidak ada pesanan hari ini
        </p>

        <?php endif; ?>

    </div>

    <!-- KALENDER EVENT -->
    <div class="box calendar-box">
        <h4>Calendar</h4>
        <div id="calendar"></div> <!-- tempat render kalender -->
    </div>

</div>

<!-- IMPORT FULLCALENDAR -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // DATA EVENT DIAMBIL DARI PHP (TRANSAKSI)
		var events = <?= json_encode(array_map(function($t){
			return [
				"title" => $t->nama_paket,
				"date" => $t->tanggal_acara
			];
		}, $semua_transaksi)); ?>;

    // INISIALISASI FULLCALENDAR
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth', // tampilan bulanan
        height: 400,                 // tinggi kalender
        events: events               // data event
    });

    // MENAMPILKAN KALENDER
    calendar.render();
});
</script>

<?php $this->load->view('admin/components/footer'); ?>
