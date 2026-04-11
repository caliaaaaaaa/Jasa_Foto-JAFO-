<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'riwayat'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>
/* CONTAINER UTAMA */
.container-riwayat {
    background: #ffffff;
    padding: 30px;
    border-radius: 20px;
    width: 95%;
    margin: 20px auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* HEADER AREA (Search & Title) */
.header-riwayat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
    flex-wrap: wrap;
}

.search-box {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
    min-width: 250px;
}

.search-box:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59, 111, 182, 0.1);
}

/* PEMBUNGKUS TABEL RESPONSIF */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 15px;
    border: 1px solid #eee;
}

/* TABLE STYLE */
.table-riwayat {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 13px;
    min-width: 1100px; /* Menjaga agar kolom tidak berhimpitan */
}

.table-riwayat th {
    background: #dfe3f2;
    padding: 15px 10px;
    text-align: center;
    font-weight: 600;
    white-space: nowrap;
}

.table-riwayat td {
    padding: 12px 10px;
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

/* ZEBRA & HOVER */
.table-riwayat tr:nth-child(even) { background: #f9fbfd; }
.table-riwayat tr:hover { background: #f1f5ff; transition: 0.2s; }

/* TOMBOL AKSI */
.btn-struk {
    padding: 7px 14px;
    background: #3B6FB6;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12px;
    display: inline-block;
    white-space: nowrap;
    transition: 0.3s;
}

.btn-struk:hover {
    background: #2F4B7C;
    transform: translateY(-2px);
    color: white;
}

/* PAGINATION */
.pagination {
    margin-top: 30px;
    text-align: center;
}

.pagination a, .pagination strong {
    padding: 8px 15px;
    margin: 3px;
    border-radius: 8px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
    font-size: 13px;
    display: inline-block;
    transition: 0.3s;
}

.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}

/* RESPONSIVE BREAKPOINT */
@media (max-width: 768px) {
    .container-riwayat {
        padding: 15px;
        width: 98%;
    }
    
    .header-riwayat {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        width: 100%;
    }
}
</style>

<div class="container-riwayat">
    
    <div class="header-riwayat">
        <h3 style="margin: 0; color: #333;">Riwayat Transaksi</h3>
        
        <form method="get" action="<?= base_url('admin/riwayat') ?>">
            <input type="text" name="keyword" class="search-box" 
                   placeholder="🔍 Cari No. Pesanan atau Nama..." 
                   value="<?= $this->input->get('keyword') ?>">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-riwayat">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Paket</th>
                    <th>Tgl Transaksi</th>
                    <th>Tgl Acara</th>
                    <th>Jam</th>
                    <th>Lokasi</th>
                    <th>Total Harga</th>
                    <th>Uang Bayar</th>
                    <th>Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($riwayat)): ?>
                    <?php $no = ($this->uri->segment(3)) ? $this->uri->segment(3) + 1 : 1; 
                    foreach($riwayat as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td style="font-weight: bold; color: #3B6FB6;"><?= $r->nomor_pesanan ?></td>
                        <td><?= $r->nama_lengkap ?></td>
                        <td><?= $r->nama_paket ?></td>
                        <td><?= date('d/m/Y', strtotime($r->tanggal_transaksi)) ?></td>
                        <td><?= date('d/m/Y', strtotime($r->tanggal_acara)) ?></td>
                        <td><?= date('H:i', strtotime($r->jam_acara)) ?></td>
                        <td><?= $r->lokasi ?></td>
                        <td><strong>Rp <?= number_format($r->total_harga, 0, ',', '.') ?></strong></td>
                        <td>Rp <?= number_format($r->uang_bayar, 0, ',', '.') ?></td>
                        <td style="color: green; font-weight: bold;">Rp <?= number_format($r->uang_kembali, 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= base_url('admin/cetak_struk/'.$r->id_transaction) ?>" 
                           target="_blank" 
                           class="btn-struk">
                           <i class="fa fa-eye"></i> Struk
                        </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" style="padding: 40px; color: #888; font-style: italic;">
                            Data transaksi tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?= $pagination ?>
    </div>

</div>

<?php $this->load->view('admin/components/footer'); ?>
