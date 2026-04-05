<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'riwayat'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<h2>Riwayat Transaksi</h2>

<div style="background:white; padding:20px; border-radius:15px; width:95%; margin:auto;">

<table border="1" cellpadding="10" style="width:100%; border-collapse:collapse;">

    <tr style="background:#dfe3f2;">
        <th>No</th>
        <th>No Pesanan</th>
        <th>Nama</th>
        <th>Paket Foto</th>
        <th>Tanggal Transaksi</th>
        <th>Tanggal Acara</th>
        <th>Jam Acara</th>
        <th>Lokasi</th>
        <th>Total Harga</th>
        <th>Uang Bayar</th>
        <th>Uang Kembali</th>
    </tr>

<?php $no=1; foreach($riwayat as $r): ?>

<tr>
    <td><?= $no++ ?></td>
    <td>INV<?= $r->id_transaction ?></td>
    <td><?= $r->nama_lengkap ?></td>
    <td><?= $r->nama_paket ?></td>
    <td><?= $r->tanggal_transaksi ?></td>
    <td><?= $r->tanggal_acara ?></td>
    <td><?= $r->jam_acara ?></td>
    <td><?= $r->lokasi ?></td>
    <td>Rp <?= number_format($r->total_harga) ?></td>
    <td>Rp <?= number_format($r->uang_bayar) ?></td>
    <td>Rp <?= number_format($r->uang_kembali) ?></td>
</tr>

<?php endforeach; ?>

</table>

</div>

<?php $this->load->view('admin/components/footer'); ?>
