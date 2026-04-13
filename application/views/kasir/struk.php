<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<title>Struk</title>

<style>
/* Mengatur margin halaman saat dicetak */
@page {
    margin: 20px;
}

/* Styling dasar body */
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #2c2c2c;
}

/* Pembungkus utama isi struk */
.container {
    width: 100%;
}

/* Bagian header (logo + nama usaha) */
.header table {
    width: 100%;
}

/* Tulisan utama logo */
.logo-text {
    font-size: 18px;
    font-weight: bold;
    color: #3B6FB6;
}

/* Tulisan kecil di bawah logo */
.sub-logo {
    font-size: 11px;
    color: #666;
}

/* Judul struk */
.title {
    text-align: center;
    font-weight: bold;
    padding: 8px 0;
    border-top: 1px solid #dcdcdc;
    border-bottom: 1px solid #dcdcdc;
    margin: 10px 0;
    font-size: 13px;
}

/* Styling tabel */
.table {
    width: 100%;
    border-collapse: collapse;
}

/* Isi tabel */
.table td {
    padding: 4px 0;
    vertical-align: top;
}

/* Bagian pembatas seperti "Data Customer", "Pembayaran" */
.section {
    background: #e9eef5;
    padding: 6px 8px;
    margin-top: 10px;
    font-weight: bold;
    border-radius: 4px;
}

/* Garis pemisah antar bagian */
.line {
    border-top: 1px solid #dcdcdc;
    margin: 10px 0;
}

/* Bagian footer (ucapan terima kasih) */
.footer {
    text-align: center;
    margin-top: 15px;
    font-size: 11px;
}

/* Untuk teks tebal */
.bold {
    font-weight: bold;
}
</style>

</head>

<body>


<div class="container">

    <!-- HEADER -->
    <div class="header">
        <table>
            <tr>
             
                <td width="60">
                    <img src="<?= base_url('assets/images/logo.png') ?>" width="50">
                </td>

             
                <td>
                    <div class="logo-text">JAFO</div>
                    <div class="sub-logo">Jasa Fotografi</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- TITLE -->
    <div class="title">STRUK PEMESANAN FOTO</div>

   
  <!-- INFO TRANSAKSI -->
	<table class="table">
		<tr>
			<td width="45%">Nomor Pesanan</td>
			<td>: <?= $transaksi->nomor_pesanan ?></td>
		</tr>
		<tr>
			<td>Tanggal Transaksi</td>
			<td>: <?= $transaksi->tanggal_transaksi ?></td>
		</tr>
		<tr>
			<td>Kasir</td>
			<td>: <?= $this->session->userdata('nama') ?></td>
		</tr>
	
	</table>

    <!-- DATA CUSTOMER -->
    <div class="section">Data Customer</div>
    <table class="table">
        <tr>
            <td width="45%">Nama</td>
            <td>: <?= $transaksi->nama_lengkap ?></td>
        </tr>
        <tr>
            <td>No Hp</td>
            <td>: <?= $transaksi->no_hp ?></td>
        </tr>
    </table>

    <!-- DETAIL PAKET -->
    <div class="section">Detail Paket</div>
    <table class="table">
        <tr>
            <td width="45%">Paket Foto</td>
            <td>: <?= $transaksi->nama_paket ?></td>
        </tr>
        <tr>

            <td>Tanggal Acara</td>
            <td>: <?= $transaksi->tanggal_acara ?></td>
        </tr>
        <tr>

            <td>Jam Acara</td>
            <td>: <?= date('H:i', strtotime($transaksi->jam_acara)) ?></td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>: <?= $transaksi->lokasi ?></td>
        </tr>
    </table>

   
    <!-- PEMBAYARAN -->
    <div class="section">Pembayaran</div>
    <table class="table">
        <tr>
            <td width="45%">Total Harga</td>
            <td>: Rp <?= number_format($transaksi->total_harga,0,',','.') ?></td>
        </tr>
        <tr>
            <td>Uang Bayar</td>
            <td>: Rp <?= number_format($transaksi->uang_bayar,0,',','.') ?></td>
        </tr>
        <tr>
            <td>Uang Kembali</td>
            <td>: Rp <?= number_format($transaksi->uang_kembali,0,',','.') ?></td>
        </tr>
    </table>

    <!-- Garis pemisah -->
    <div class="line"></div>

  
    <div class="footer">
        Terimakasih telah menggunakan <br>
        <span class="bold">Jasa Fotografi</span>
    </div>

</div>

</body>
</html>
