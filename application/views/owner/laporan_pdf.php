<style>

/* TABEL UTAMA */
table {
    width: 100%; /* tabel full lebar */
    border-collapse: collapse; /* menggabungkan border agar rapi ahmad */
}

/* STYLE HEADER & ISI TABEL */
th, td {
    border: 1px solid black; /* garis tabel */
    padding: 8px; /* jarak dalam cell */
    font-size: 12px; /* ukuran teks kecil (biasanya untuk laporan/print) */
}

/* KHUSUS NAMA boleh turun ke bawah (wrap text) */
.td-nama {
    word-wrap: break-word; /* memotong kata panjang */
    white-space: normal; /* boleh turun ke baris baru */
}

/* KHUSUS ANGKA no no turun */
.td-uang {
    white-space: nowrap; /* angka tetap satu baris */
}

</style>

<!-- JUDUL LAPORAN -->
<h2 style="text-align:center;">LAPORAN TRANSAKSI</h2>
<hr>

<?php
// inisialisasi total pendapatan
$total = 0;

// loop untuk menjumlahkan semua total_harga dari riwayat transaksi
foreach ($riwayat as $r) {
    $total += $r->total_harga;
}
?>

<!-- MENAMPILKAN TOTAL PENDAPATAN -->
<h4>Total Pendapatan: Rp <?= number_format($total, 0, ',', '.') ?></h4>

<!-- TABEL DATA TRANSAKSI -->
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

        <!-- CEK JIKA DATA KOSONG -->
        <?php if (empty($riwayat)): ?>

            <!-- jika tidak ada data -->
            <tr>
                <td colspan="10" style="text-align:center; padding:30px;">
                    <strong>Tidak ada data transaksi pada periode ini</strong><br>
                    <small style="color:#888;">(Laporan kosong)</small>
                </td>
            </tr>

        <?php else: ?>

            <!-- jika ada data -->
            <?php $no = 1; foreach ($riwayat as $r): ?>
                <tr>

                    <!-- nomor urut -->
                    <td><?= $no++ ?></td>

                    <!-- nomor pesanan -->
                    <td><?= $r->nomor_pesanan ?></td>

                    <!-- nama (bisa turun jika panjang) -->
                    <td class="td-nama"><?= $r->nama_lengkap ?></td>

                    <!-- nama paket -->
                    <td><?= $r->nama_paket ?></td>

                    <!-- tanggal transaksi -->
                    <td><?= date('d/m/Y', strtotime($r->tanggal_transaksi)) ?></td>

                    <!-- tanggal acara -->
                    <td><?= date('d/m/Y', strtotime($r->tanggal_acara)) ?></td>

                    <!-- lokasi -->
                    <td><?= $r->lokasi ?></td>

                    <!-- uang bayar (tidak turun) -->
                    <td class="td-uang">
                        Rp <?= number_format($r->uang_bayar,0,',','.') ?>
                    </td>

                    <!-- uang kembali -->
                    <td class="td-uang">
                        Rp <?= number_format($r->uang_kembali,0,',','.') ?>
                    </td>

                    <!-- total harga (dibold) -->
                    <td class="td-uang">
                        <strong>Rp <?= number_format($r->total_harga,0,',','.') ?></strong>
                    </td>

                </tr>
            <?php endforeach; ?>

        <?php endif; ?>

    </tbody>

</table>
