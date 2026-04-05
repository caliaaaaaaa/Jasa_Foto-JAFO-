<?php $this->load->view('kasir/components/header'); ?>
<?php $this->load->view('kasir/components/navbar'); ?>

<div class="layout">
<?php $this->load->view('kasir/components/sidebar'); ?>

<div class="main">

<style>

/* GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* CARD */
.card-paket {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}
.card-paket:hover {
    transform: translateY(-5px);
}
.card-paket img {
    width: 70%;
    height: 250px; 
    object-fit: cover;
    border-radius: 12px;
    display: block;
    margin: 20px auto;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
}
.card-body {
    padding: 15px;
}
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

/* OVERLAY */
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

/* SIDE CARD */
.side-card {
    width: 50%;
    height: 100%;
    background: white;
    padding: 30px;
    border-radius: 20px 0 0 20px;
    transform: translateX(100%);
    transition: 0.4s ease;
}
.overlay.active .side-card {
    transform: translateX(0);
}

/* DETAIL */
.content-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.left img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 15px;
}


/* CLOSE */
.close {
    position: absolute;
    top: 60px;
    right: 40px;
    font-size: 24px;
    cursor: pointer;
}

/* INFO */
.info-card {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
}

/* JENIS */
.jenis {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}
.radio {
    cursor: pointer;
    text-align: center;
}
.radio span {
    display: block;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #ccc;
    margin: auto;
}
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

/* 🔥 BUTTON */
.btn-beli {
    background: #2ecc71;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

/* HEADER CARD */
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

/* INFO CARD UPGRADE */
.info-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;

    box-shadow: 0 6px 20px rgba(0,0,0,0.08);

    animation: fadeUp 0.5s ease;
}

/* BUTTON BELI */
.btn-beli {
    width: 100%;
    margin-top: 15px;

    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;

    padding: 12px;
    border-radius: 25px;
    border: none;

    font-weight: bold;
    cursor: pointer;

    transition: 0.3s;
}

.btn-beli:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(46, 204, 113, 0.4);
}

/* DURASI */
.durasi {
    margin-top: 10px;
    color: #555;
}

/* ANIMASI */
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


<form method="get" action="<?= base_url('kasir/paket') ?>">
    <input type="text" name="keyword" class="search-box" 
           placeholder="🔍 Search">
</form>

<div class="grid">

<?php foreach($paket as $p): ?>

<div class="card-paket">

    <img src="<?= base_url('assets/images/'.$p->gambar) ?>">

    <div class="card-body">
        <h4><?= $p->nama_paket ?></h4>
        <p>Rp <?= number_format($p->harga) ?></p>

        <div class="btn-detail"
        onclick='showDetail(<?= json_encode($p->nama_paket) ?>)'>
            Detail
        </div>
    </div>

</div>

<?php endforeach; ?>

</div>

<!-- OVERLAY -->
<div id="overlay" class="overlay">

<div class="side-card">

    <!-- 🔥 HEADER CARD -->
    <div class="header-card">
        <h2 id="d_kategori"></h2>
        <span class="close" onclick="closeDetail()">×</span>
    </div>

    <div class="content-detail">

        <!-- KIRI -->
        <div class="left">
            <img id="d_gambar">
        </div>

        <!-- KANAN -->
        <div class="right">

            <div class="info-card">

                <h4>Jenis Paket</h4>

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

                <p id="d_deskripsi"></p>

                <p class="durasi">⏱ <span id="d_durasi"></span></p>

                <h3 id="d_harga"></h3>

                <!-- 🔥 BUTTON PINDAH KE SINI -->
                <button class="btn-beli" onclick="beliPaket()">Beli Paket</button>

            </div>

        </div>

    </div>

</div>
</div>

       
    

<script>

let paketList = [];
let selectedId = null;

// 🔥 LOAD DATA BERDASARKAN NAMA
function showDetail(nama){

    fetch("<?= base_url('kasir/get_paket_by_nama/') ?>" + encodeURIComponent(nama))
    .then(res => res.json())
    .then(data => {

        paketList = data;

        document.getElementById('overlay').classList.add('active');
        document.getElementById('d_kategori').innerText = "Jasa Foto " + nama;

        // tampil pertama
        tampilkanJenis(paketList[0].jenis.toLowerCase());
    });
}

// 🔥 SWITCH JENIS
function tampilkanJenis(jenis){

    let p = paketList.find(x => x.jenis.toLowerCase() === jenis);
    if(!p) return;

    selectedId = p.id_paket;

    document.getElementById('d_gambar').src = "<?= base_url('assets/images/') ?>" + p.gambar;
    document.getElementById('d_deskripsi').innerHTML = p.deskripsi.replace(/\n/g,"<br>");
    document.getElementById('d_harga').innerText = "Rp " + parseInt(p.harga).toLocaleString();
    document.getElementById('d_durasi').innerText = p.durasi_jam + " Jam";

    // reset
    document.getElementById('basic').classList.remove('active');
    document.getElementById('plus').classList.remove('active');
    document.getElementById('premium').classList.remove('active');

    document.getElementById(jenis).classList.add('active');
}


function beliPaket(){
    window.location.href = "<?= base_url('kasir/transaksi/') ?>" + selectedId;
}


// CLOSE
function closeDetail(){
    document.getElementById('overlay').classList.remove('active');
}

</script>

<?php $this->load->view('kasir/components/footer'); ?>



