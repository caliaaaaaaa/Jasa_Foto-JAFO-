
	<style>

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    font-size: 12px;
}

/* 🔥 KHUSUS NAMA → boleh turun */
.td-nama {
    word-wrap: break-word;
    white-space: normal;
}

/* 🔥 KHUSUS ANGKA → jangan turun */
.td-uang {
    white-space: nowrap;
}


</style>



<h2 style="text-align:center;">LAPORAN TRANSAKSI</h2>
<hr>

<?php
$total = 0;
foreach ($riwayat as $r) {
    $total += $r->total_harga;
}
?>

<h4>Total Pendapatan: Rp <?= number_format($total, 0, ',', '.') ?></h4>

<table border="1" width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">

    <thead>
        <tr>
            <th>No</th>
            <th>No Pesanan</th>
            <th>Nama</th>
            <th>Paket</th>
            <th>Tgl Transaksi</th>
            <th>Tgl Acara</th>
            <th>Lokasi</th>
            <th>Bayar</th>
            <th>Kembali</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($riwayat)): ?>
            <tr>
                <td colspan="10" style="text-align:center; padding:30px;">
                    <strong>Tidak ada data transaksi pada periode ini</strong><br>
                    <small style="color:#888;">(Laporan kosong)</small>
                </td>
            </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($riwayat as $r): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $r->nomor_pesanan ?></td>
                   <td class="td-nama"><?= $r->nama_lengkap ?></td>
                    <td><?= $r->nama_paket ?></td>
                    <td><?= date('d/m/Y', strtotime($r->tanggal_transaksi)) ?></td>
                    <td><?= date('d/m/Y', strtotime($r->tanggal_acara)) ?></td>
                    <td><?= $r->lokasi ?></td>
                   <td class="td-uang">Rp <?= number_format($r->uang_bayar,0,',','.') ?></td>
<td class="td-uang">Rp <?= number_format($r->uang_kembali,0,',','.') ?></td>
<td class="td-uang"><strong>Rp <?= number_format($r->total_harga,0,',','.') ?></strong></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>

</table>
