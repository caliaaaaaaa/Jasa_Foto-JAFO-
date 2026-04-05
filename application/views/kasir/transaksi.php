<?php $this->load->view('kasir/components/header'); ?>
<?php $this->load->view('kasir/components/navbar'); ?>

<div class="layout">
<?php $this->load->view('kasir/components/sidebar'); ?>

<div class="main">

<style>
    /* Google Fonts Import (Opsional, agar lebih cantik) */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .main {
        padding: 40px;
        background: #f0f2f5;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    /* CARD UTAMA */
    .card-transaksi {
        background: #ffffff;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.05);
        max-width: 1100px;
        margin: 0 auto;
    }

    /* HEADER */
    .header-transaksi {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .header-transaksi h2 {
        font-weight: 700;
        color: #1a1d23;
        margin: 0;
        font-size: 24px;
    }

    .total-badge {
        background: #ebf2ff;
        padding: 12px 24px;
        border-radius: 14px;
        color: #3B6FB6;
        font-weight: 700;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* CONTENT LAYOUT */
    .content-wrapper {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 40px;
        align-items: start;
    }

    /* LEFT: PREVIEW PAKET */
    .card-paket {
        background: #ffffff;
        border-radius: 20px;
        padding: 12px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .card-paket img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 15px;
    }

    .card-paket-info {
        padding: 10px 5px;
    }

    .card-paket-info h4 {
        margin: 0 0 5px 0;
        color: #1a1d23;
        font-size: 18px;
        font-weight: 600;
    }

    .card-paket-info p {
        margin: 0;
        color: #3B6FB6;
        font-weight: 700;
        font-size: 16px;
    }

    /* RIGHT: FORM STYLING */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .input-group {
        display: flex;
        flex-direction: column;
    }

    .input-group label {
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-group input {
        padding: 14px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        outline: none;
        transition: all 0.2s;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
    }

    .input-group input:focus {
        border-color: #3B6FB6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(59, 111, 182, 0.1);
    }

    /* INPUT RP (Bayar & Kembali) */
    .rp-wrapper {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        transition: 0.2s;
    }

    .rp-wrapper:focus-within {
        border-color: #3B6FB6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(59, 111, 182, 0.1);
    }

    .rp-wrapper span {
        padding: 0 15px;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
    }

    .rp-wrapper input {
        border: none !important;
        background: transparent !important;
        padding-left: 0;
        box-shadow: none !important;
        flex: 1;
    }

    /* BUTTONS */
    .footer-btn {
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-batal {
        padding: 14px 28px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: white;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-batal:hover {
        background: #f8fafc;
        color: #ef4444;
        border-color: #fecaca;
    }

    .btn-simpan {
        padding: 14px 35px;
        border-radius: 12px;
        border: none;
        background: #3B6FB6;
        color: white;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(59, 111, 182, 0.25);
        transition: 0.3s;
    }

    .btn-simpan:hover {
        background: #2d558d;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 111, 182, 0.3);
    }

    /* Responsif */
    @media (max-width: 992px) {
        .content-wrapper { grid-template-columns: 1fr; }
        .card-paket { max-width: 400px; margin: 0 auto 20px; }
    }
</style>

<form method="post" action="<?= base_url('kasir/simpan_transaksi') ?>">

<div class="card-transaksi">

    <!-- HEADER -->
    <div class="header-transaksi">
        <h2>Transaksi Baru</h2>
        <div class="total-badge">
            <span>🛒</span> 
            Total: Rp <span id="totalText">0</span>
        </div>
    </div>

    <div class="content-wrapper">

        <!-- LEFT: PREVIEW PAKET -->
        <div class="card-paket">
            <img src="<?= base_url('assets/images/'.$paket->gambar) ?>" alt="Gambar Paket">
            <div class="card-paket-info">
                <h4><?= $paket->nama_paket ?></h4>
                <p>Rp <?= number_format($paket->harga) ?></p>
            </div>
        </div>

        <!-- RIGHT: FORM INPUT -->
        <div>
            <div class="form-grid">

                <div class="input-group">
                    <label>Nomor Pesanan</label>
                    <input type="text" name="nomor_pesanan" value="<?= $no_pesanan ?>" readonly style="background: #f1f5f9; color: #94a3b8;">
                </div>

                <div class="input-group">
                    <label>Tanggal Acara</label>
                    <input type="date" name="tanggal">
                </div>

                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama pelanggan">
                </div>

                <div class="input-group">
                    <label>Jam Acara</label>
                    <input type="time" name="jam">
                </div>

                <div class="input-group">
                    <label>No HP / WhatsApp</label>
                    <input type="text" name="no_hp" placeholder="08xxx">
                </div>

                <div class="input-group">
                    <label>Lokasi Acara</label>
                    <input type="text" name="lokasi" placeholder="Alamat lokasi">
                </div>

                <div class="input-group">
                    <label>Uang Bayar</label>
                    <div class="rp-wrapper">
                        <span>Rp</span>
                        <input type="number" id="bayar" name="bayar" onkeyup="hitung()" placeholder="0">
                    </div>
                </div>

                <div class="input-group">
                    <label>Uang Kembali</label>
                    <div class="rp-wrapper">
                        <span>Rp</span>
                        <input type="text" id="kembali" name="kembali" readonly style="color: #3B6FB6; font-weight: bold;">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- BUTTON ACTION -->
    <div class="footer-btn">
        <button type="button" class="btn-batal" onclick="window.history.back()">Batal</button>
        <button type="submit" class="btn-simpan">Simpan & Cetak Struk</button>
    </div>

</div>

<!-- HIDDEN DATA -->
<input type="hidden" name="id_paket" value="<?= $paket->id_paket ?>">
<input type="hidden" id="total" name="total" value="<?= $paket->harga ?>">

</form>

</div>
</div>

<script>
function hitung(){
    let total = parseInt(document.getElementById('total').value) || 0;
    let bayar = parseInt(document.getElementById('bayar').value) || 0;

    let kembali = bayar - total;

    // Format mata uang untuk input kembali
    document.getElementById('kembali').value = kembali.toLocaleString('id-ID');
    document.getElementById('totalText').innerText = total.toLocaleString('id-ID');
}

// Tampilkan total awal saat halaman dimuat
window.onload = function() {
    let totalVal = parseInt(document.getElementById('total').value) || 0;
    document.getElementById('totalText').innerText = totalVal.toLocaleString('id-ID');
};
</script>

<?php $this->load->view('kasir/components/footer'); ?>
