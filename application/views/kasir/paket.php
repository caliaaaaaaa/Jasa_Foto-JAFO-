<?php 

$this->load->view('kasir/components/header'); 
$this->load->view('kasir/components/navbar'); 
$active = 'paket'; 
$this->load->view('kasir/components/sidebar', compact('active')); 
?>

<div class="layout">

<div class="main">

<style>


/* Untuk menampilkan card paket dalam bentuk grid 4 kolom */
.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* Styling card paket */
.card-paket {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

/* Efek hover saat card disentuh */
.card-paket:hover {
    transform: translateY(-5px);
}

/* Styling gambar dalam card */
.card-paket img {
    width: 70%;
    height: 250px; 
    object-fit: cover;
    border-radius: 12px;
    display: block;
    margin: 20px auto;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
}

/* Isi dalam card */
.card-body {
    padding: 15px;
}

/* Tombol detail */
.btn-detail {
    display: block;
    text-align: center;
    margin-top: 10px;
    padding: 8px;
    background: #3B6FB6;
    color: white;
    border-radius: 20px;
    cursor: pointer;
}


/* Background gelap saat detail muncul */
.overlay {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(8px);
    display: none;
    justify-content: flex-end;
    z-index: 999;
}


.overlay.active {
    display: flex;
}


/* Panel detail yang muncul dari kanan */
.side-card {
    width: 50%;
    height: 100%;
    background: white;
    padding: 30px;
    border-radius: 20px 0 0 20px;
    transform: translateX(100%);
    transition: 0.4s ease;
}

/* Animasi muncul */
.overlay.active .side-card {
    transform: translateX(0);
}

/* Layout isi detail */
.content-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Gambar detail */
.left img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 15px;
}

/* Tombol close */
.close {
    position: absolute;
    top: 60px;
    right: 40px;
    font-size: 24px;
    cursor: pointer;
}

/* Card info kanan */
.info-card {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
}

/* JENIS PAKETTTT */
.jenis {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

/* Radio custom */
.radio {
    cursor: pointer;
    text-align: center;
}

/* Lingkaran radio */
.radio span {
    display: block;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #ccc;
    margin: auto;
}

/* Aktif */
.radio.active span {
    background: #2F4B7C;
}

/* SEARCH */
.search-box {
    padding: 8px 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin: 20px 0;
}

/* BUTTON BELI */
.btn-beli {
    background: #2ecc71;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

/* Header detail */
.header-card h2{
    background: #f1f3f7;
    padding: 15px 20px;
    border-radius: 15px;
    margin-bottom: 20px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    box-shadow: 0 4px 12px rgba(0,0,0,0.08);

    animation: fadeDown 0.4s ease;
}

/* Animasi info card */
.info-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;

    box-shadow: 0 6px 20px rgba(0,0,0,0.08);

    animation: fadeUp 0.5s ease;
}

/* Hover tombol beli */
.btn-beli:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(46, 204, 113, 0.4);
}

/* Durasi paket */
.durasi {
    margin-top: 10px;
    color: #555;
}

/* Animasi masuk */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Animasi turun */
@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- FORM SEARCH -->
<form method="get" action="<?= base_url('kasir/paket') ?>">
    <input type="text" name="keyword" class="search-box" 
           placeholder="🔍 Search">
</form>

<!-- LIST PAKET -->
<div class="grid">

<?php foreach($paket as $p): ?>
<!-- Looping data paket dari database -->

<div class="card-paket">

    <!-- Gambar paket -->
    <img src="<?= base_url('assets/images/'.$p->gambar) ?>">

    <div class="card-body">
        <!-- Nama paket -->
        <h4><?= $p->nama_paket ?></h4>

        <!-- Harga paket -->
        <p>Rp <?= number_format($p->harga) ?></p>

        <!-- Tombol detail (memanggil JS) -->
        <div class="btn-detail"
        onclick='showDetail(<?= json_encode($p->nama_paket) ?>)'>
            Detail
        </div>
    </div>

</div>

<?php endforeach; ?>

</div>

<!-- OVERLAY DETAIL -->
<div id="overlay" class="overlay">

<div class="side-card">

    <!-- HEADER DETAIL -->
    <div class="header-card">
        <h2 id="d_kategori"></h2>
        <!-- Tombol close -->
        <span class="close" onclick="closeDetail()">×</span>
    </div>

    <div class="content-detail">

        <!-- KIRI (GAMBAR) -->
        <div class="left">
            <img id="d_gambar">
        </div>

        <!-- KANAN (INFO) -->
        <div class="right">

            <div class="info-card">

                <h4>Jenis Paket</h4>

                <!-- PILIH JENIS -->
                <div class="jenis">
                    <div class="radio" id="basic" onclick="tampilkanJenis('basic')">
                        <span></span> Basic
                    </div>
                    <div class="radio" id="plus" onclick="tampilkanJenis('plus')">
                        <span></span> Plus
                    </div>
                    <div class="radio" id="premium" onclick="tampilkanJenis('premium')">
                        <span></span> Premium
                    </div>
                </div>

                <hr>

                <!-- Deskripsi -->
                <p id="d_deskripsi"></p>

                <!-- Durasi -->
                <p class="durasi">⏱ <span id="d_durasi"></span></p>

                <!-- Harga -->
                <h3 id="d_harga"></h3>

                <!-- Tombol beli -->
                <button class="btn-beli" onclick="beliPaket()">Beli Paket</button>

            </div>

        </div>

    </div>

</div>
</div>

<script>


let paketList = [];

let selectedId = null;

// FUNCTION DETAIL 
function showDetail(nama){

    fetch("<?= base_url('kasir/get_paket_by_nama/') ?>" + encodeURIComponent(nama))
    .then(res => res.json())
    .then(data => {

        // Simpan data ke array
        paketList = data;

        // Tampilkan overlay
        document.getElementById('overlay').classList.add('active');

        // Set judul kategori
        document.getElementById('d_kategori').innerText = "Jasa Foto " + nama;

        // Tampilkan jenis pertama otomatis
        tampilkanJenis(paketList[0].jenis.toLowerCase());
    });
}


// Menampilkan detail sesuai jenis paket
function tampilkanJenis(jenis){

    // Cari paket sesuai jenis
    let p = paketList.find(x => x.jenis.toLowerCase() === jenis);
    if(!p) return;

    // Simpan ID
    selectedId = p.id_paket;

    // Set data ke tampilan
    document.getElementById('d_gambar').src = "<?= base_url('assets/images/') ?>" + p.gambar;
    document.getElementById('d_deskripsi').innerHTML = p.deskripsi.replace(/\n/g,"<br>");
    document.getElementById('d_harga').innerText = "Rp " + parseInt(p.harga).toLocaleString();
    document.getElementById('d_durasi').innerText = p.durasi_jam + " Jam";

    // Reset semua radio
    document.getElementById('basic').classList.remove('active');
    document.getElementById('plus').classList.remove('active');
    document.getElementById('premium').classList.remove('active');

    // Aktifkan yang dipilih
    document.getElementById(jenis).classList.add('active');
}

// beli paket
// Redirect ke halaman transaksi dengan ID paket
function beliPaket(){
    window.location.href = "<?= base_url('kasir/transaksi/') ?>" + selectedId;
}

// CLOSE DETAIL
function closeDetail(){
    document.getElementById('overlay').classList.remove('active');
}

</script>

<?php 
// Memanggil footer (bagian bawah halaman)
$this->load->view('kasir/components/footer'); 
?>
