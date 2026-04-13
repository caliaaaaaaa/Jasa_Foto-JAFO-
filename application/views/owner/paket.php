<?php 

$this->load->view('owner/components/header'); 
$this->load->view('owner/components/navbar'); 


$active = 'paket'; 
$this->load->view('owner/components/sidebar', compact('active')); 
?>

<div class="layout">

<div class="main">

<style>

/* GRID (menampilkan card paket dalam bentuk grid 4 kolom) */
.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* CARD PAKET */
.card-paket {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

/* efek hover card */
.card-paket:hover {
    transform: translateY(-5px);
}

/* gambar paket */
.card-paket img {
    width: 70%;
    height: 250px; 
    object-fit: cover;
    border-radius: 12px;
    display: block;
    margin: 20px auto;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
}

/* isi card */
.card-body {
    padding: 15px;
}

/* tombol detail */
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

/* OVERLAY (background saat detail dibuka) */
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

/* overlay aktif */
.overlay.active {
    display: flex;
}

/* SIDE CARD (panel detail di kanan) */
.side-card {
    width: 50%;
    height: 100%;
    background: white;
    padding: 30px;
    border-radius: 20px 0 0 20px;
    transform: translateX(100%);
    transition: 0.4s ease;
}

/* animasi muncul */
.overlay.active .side-card {
    transform: translateX(0);
}

/* layout detail */
.content-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* gambar detail */
.left img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 15px;
}

/* tombol close */
.close {
    position: absolute;
    top: 60px;
    right: 40px;
    font-size: 24px;
    cursor: pointer;
}

/* card info */
.info-card {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
}

/* pilihan jenis paket */
.jenis {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

/* radio custom */
.radio {
    cursor: pointer;
    text-align: center;
}

/* bulatan radio */
.radio span {
    display: block;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #ccc;
    margin: auto;
}

/* radio aktif */
.radio.active span {
    background: #2F4B7C;
}

/* search box */
.search-box {
    padding: 8px 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin: 20px 0;
}

/* header detail */
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

/* info card tambahan */
.info-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;

    box-shadow: 0 6px 20px rgba(0,0,0,0.08);

    animation: fadeUp 0.5s ease;
}

/* durasi */
.durasi {
    margin-top: 10px;
    color: #555;
}

/* animasi muncul dari bawah */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* animasi dari atas */
@keyframes fadeDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- FORM SEARCH PAKET -->
<form method="get" action="<?= base_url('owner/paket') ?>">
    <input type="text" name="keyword" class="search-box" 
           placeholder="🔍 Search">
</form>

<!-- GRID PAKET -->
<div class="grid">

<?php foreach($paket as $p): ?>

<div class="card-paket">

    <!-- gambar paket -->
    <img src="<?= base_url('assets/images/'.$p->gambar) ?>">

    <div class="card-body">

        <!-- nama paket -->
        <h4><?= $p->nama_paket ?></h4>

        <!-- harga -->
        <p>Rp <?= number_format($p->harga) ?></p>

        <!-- tombol detail (memanggil JS) -->
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

        <!-- tombol close -->
        <span class="close" onclick="closeDetail()">×</span>
    </div>

    <div class="content-detail">

        <!-- BAGIAN KIRI (GAMBAR) -->
        <div class="left">
            <img id="d_gambar">
        </div>

        <!-- BAGIAN KANAN -->
        <div class="right">

            <div class="info-card">

                <h4>Jenis Paket</h4>

                <!-- pilihan jenis -->
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

                <!-- deskripsi -->
                <p id="d_deskripsi"></p>

                <!-- durasi -->
                <p class="durasi">⏱ <span id="d_durasi"></span></p>

                <!-- harga -->
                <h3 id="d_harga"></h3>

            </div>

        </div>

    </div>

	
</div>
</div>

<script>

// menyimpan data paket dari server
let paketList = [];

// menyimpan id paket yang dipilih
let selectedId = null;

//  FUNCTION MENAMPILKAN DETAIL BERDASARKAN NAMA
function showDetail(nama){

    // ambil data paket dari server (AJAX)
    fetch("<?= base_url('owner/get_paket_by_nama/') ?>" + encodeURIComponent(nama))
    .then(res => res.json())
    .then(data => {

        paketList = data; // simpan data ke array

        // tampilkan overlay
        document.getElementById('overlay').classList.add('active');

        // set judul
        document.getElementById('d_kategori').innerText = "Jasa Foto " + nama;

        // tampilkan jenis pertama
        tampilkanJenis(paketList[0].jenis.toLowerCase());
    });
}

// FUNCTION GANTI JENIS PAKET
function tampilkanJenis(jenis){

    // cari paket sesuai jenis
    let p = paketList.find(x => x.jenis.toLowerCase() === jenis);
    if(!p) return;

    selectedId = p.id_paket; // simpan id

    // update tampilan
    document.getElementById('d_gambar').src = "<?= base_url('assets/images/') ?>" + p.gambar;
    document.getElementById('d_deskripsi').innerHTML = p.deskripsi.replace(/\n/g,"<br>");
    document.getElementById('d_harga').innerText = "Rp " + parseInt(p.harga).toLocaleString();
    document.getElementById('d_durasi').innerText = p.durasi_jam + " Jam";

    // reset radio
    document.getElementById('basic').classList.remove('active');
    document.getElementById('plus').classList.remove('active');
    document.getElementById('premium').classList.remove('active');

    // aktifkan yang dipilih
    document.getElementById(jenis).classList.add('active');
}

// FUNCTION CLOSE DETAIL
function closeDetail(){
    document.getElementById('overlay').classList.remove('active');
}

</script>

<?php 

$this->load->view('owner/components/footer'); 
?>
