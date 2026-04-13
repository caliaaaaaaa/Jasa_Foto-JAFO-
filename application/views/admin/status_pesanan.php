<?php 

$this->load->view('admin/components/header'); 
$this->load->view('admin/components/navbar'); 

$active = 'status'; 
$this->load->view('admin/components/sidebar', compact('active')); 
?>

<style>
/* CONTAINER: pembungkus utama halaman status */
.container-status {
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    width: 95%;
    margin: 20px auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* HEADER / FILTER AREA (search + filter status) */
.header-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
    flex-wrap: wrap; /* agar responsif */
}

/* SEARCH BOX DAN SELECT FILTER */
.search-box, select {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

/* search fleksibel mengikuti lebar */
.search-box {
    flex: 1;
    min-width: 200px;
}

/* efek focus */
.search-box:focus, select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* WRAPPER TABEL AGAR SCROLLABLE */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 12px;
}

/* TABLE UTAMA */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    min-width: 1000px; /* menjaga struktur kolom */
}

/* HEADER TABLE */
th {
    background: #dfe3f2;
    padding: 14px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
}

/* DATA TABLE */
td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

/* STRIP BARIS GENAP */
tr:nth-child(even) {
    background: #f9fbfd;
}

/* HOVER BARIS */
tr:hover {
    background: #f1f5ff;
    transition: 0.2s;
}

/* BADGE STATUS */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
}

/* warna status */
.proses { background: #f1c40f; }
.selesai { background: #2ecc71; }
.menunggu { background: #95a5a6; }

/* BUTTON AKSI */
.btn-aksi {
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 12px;
    cursor: pointer;
    transition: 0.25s;
    white-space: nowrap;
}

/* tombol proses */
.btn-proses { background: #f1c40f; }
.btn-proses:hover { background: #d4ac0d; transform: translateY(-2px); }

/* tombol selesai */
.btn-selesai { background: #2ecc71; }
.btn-selesai:hover { background: #27ae60; transform: translateY(-2px); }

/* tulisan selesai */
.done {
    font-size: 14px;
    color: #2ecc71;
    font-weight: 600;
}

/* PAGINATION */
.pagination {
    margin-top: 25px;
    text-align: center;
}

/* link pagination */
.pagination a,
.pagination strong {
    padding: 8px 14px;
    margin: 3px;
    border-radius: 8px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
    font-size: 13px;
    display: inline-block;
}

/* halaman aktif */
.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .header-status {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box, select {
        width: 100%;
    }

    .container-status {
        padding: 15px;
        width: 98%;
    }
}
</style>

<div class="container-status">
    <h3 style="margin-bottom: 20px;">Status Pesanan</h3>

    <!-- FORM FILTER DAN SEARCH -->
    <form method="get" action="<?= base_url('admin/status_pesanan') ?>">
        <div class="header-status">

            <!-- filter berdasarkan status -->
            <select name="status" onchange="this.form.submit()">
                <option value="all">Semua Status</option>

                <!-- selected jika sesuai filter -->
                <option value="menunggu" <?= ($filter_status == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                <option value="proses" <?= ($filter_status == 'proses') ? 'selected' : '' ?>>Proses</option>
                <option value="selesai" <?= ($filter_status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>

            <!-- input pencarian -->
            <input type="text" name="keyword" class="search-box"
                placeholder="🔍 Cari No Pesanan atau Nama..."
                value="<?= $keyword ?>"
                
                
                onkeydown="if(event.key==='Enter'){this.form.submit()}">
        </div>
    </form>

    <!-- TABEL DATA -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Pesanan</th>
                    <th>Nama Lengkap</th>
                    <th>No HP</th>
                    <th>Paket Foto</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <!-- cek apakah ada data -->
                <?php if (!empty($status)): ?>

                    <?php $no = 1; foreach ($status as $s): ?>
                        <tr>
                          
                            <td><?= $no++ ?></td>

                            
                            <td style="font-weight: bold; color: #3B6FB6;">
                                <?= $s->nomor_pesanan ?? '-' ?>
                            </td>

                            <td><?= $s->nama_lengkap ?? '-' ?></td>
                            <td><?= $s->no_hp ?? '-' ?></td>

                            <td>
							<?php if (!empty($s->nama_paket)): ?>
								<span>
									<?= $s->nama_paket ?>
								</span>
							<?php else: ?>
								<span style="color:red; font-weight:bold;">
									(Paket dihapus)
								</span>
							<?php endif; ?>
						</td>
						
                            <td><?= $s->lokasi ?? '-' ?></td>

                            <!-- format tanggal -->
                            <td><?= date('d/m/Y', strtotime($s->tanggal_acara)) ?></td>

                            <!-- format jam -->
                            <td><?= date('H:i', strtotime($s->jam_acara)) ?></td>

                            <!-- STATUS -->
                            <td>
                                <?php if ($s->status == 'menunggu'): ?>
                                    <span class="badge menunggu">Menunggu</span>

                                <?php elseif ($s->status == 'proses'): ?>
                                    <span class="badge proses">Proses</span>

                                <?php else: ?>
                                    <span class="badge selesai">Selesai</span>
                                <?php endif; ?>
                            </td>

                            <!-- AKSI UPDATE STATUS -->
                            <td>
                                <form method="post" action="<?= base_url('admin/update_status/' . $s->id_transaction) ?>">

                                    <!-- jika status menunggu -->
                                    <?php if ($s->status == 'menunggu'): ?>
                                        <button class="btn-aksi btn-proses" name="status" value="proses">
                                            Update ke Proses
                                        </button>

                                    <!-- jika status proses -->
                                    <?php elseif ($s->status == 'proses'): ?>
                                        <button class="btn-aksi btn-selesai" name="status" value="selesai">
                                            Selesaikan
                                        </button>

                                    <!-- jika sudah selesai -->
                                    <?php else: ?>
                                        <span class="done">✔ Selesai</span>
                                    <?php endif; ?>

                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    
                    <tr>
                        <td colspan="10" style="padding: 30px; color: #888;">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <?= $pagination ?>
    </div>
</div>

<?php 

$this->load->view('admin/components/footer'); 
?>
