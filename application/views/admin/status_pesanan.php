<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'status'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>
/* CONTAINER */
.container-status {
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    width: 95%;
    margin: 20px auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* HEADER / FILTER AREA */
.header-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
    flex-wrap: wrap; /* Agar elemen turun jika layar sempit */
}

/* SEARCH & SELECT */
.search-box, select {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

.search-box {
    flex: 1; /* Search box akan mengambil sisa ruang */
    min-width: 200px;
}

.search-box:focus, select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* PEMBUNGKUS TABEL RESPONSIF */
.table-responsive {
    width: 100%;
    overflow-x: auto; /* Scroll horizontal jika tabel meluber */
    -webkit-overflow-scrolling: touch;
    border-radius: 12px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    min-width: 1000px; /* Menjaga kolom agar tidak terlalu berdempetan */
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

/* DATA */
td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

/* ROW STRIP */
tr:nth-child(even) {
    background: #f9fbfd;
}

/* HOVER ROW */
tr:hover {
    background: #f1f5ff;
    transition: 0.2s;
}

/* BADGE */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
}

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

.btn-proses { background: #f1c40f; }
.btn-proses:hover { background: #d4ac0d; transform: translateY(-2px); }

.btn-selesai { background: #2ecc71; }
.btn-selesai:hover { background: #27ae60; transform: translateY(-2px); }

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

.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}

/* RESPONSIVE BREAKPOINT */
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

    <form method="get" action="<?= base_url('admin/status_pesanan') ?>">
        <div class="header-status">
            <select name="status" onchange="this.form.submit()">
                <option value="all">Semua Status</option>
                <option value="menunggu" <?= ($filter_status == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                <option value="proses" <?= ($filter_status == 'proses') ? 'selected' : '' ?>>Proses</option>
                <option value="selesai" <?= ($filter_status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>

            <input type="text" name="keyword" class="search-box"
                placeholder="🔍 Cari No Pesanan atau Nama..."
                value="<?= $keyword ?>"
                onkeydown="if(event.key==='Enter'){this.form.submit()}">
        </div>
    </form>

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
                <?php if (!empty($status)): ?>
                    <?php $no = 1; foreach ($status as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: bold; color: #3B6FB6;"><?= $s->nomor_pesanan ?? '-' ?></td>
                            <td><?= $s->nama_lengkap ?? '-' ?></td>
                            <td><?= $s->no_hp ?? '-' ?></td>
                            <td><?= $s->nama_paket ?? '-' ?></td>
                            <td><?= $s->lokasi ?? '-' ?></td>
                            <td><?= date('d/m/Y', strtotime($s->tanggal_acara)) ?></td>
                            <td><?= date('H:i', strtotime($s->jam_acara)) ?></td>
                            <td>
                                <?php if ($s->status == 'menunggu'): ?>
                                    <span class="badge menunggu">Menunggu</span>
                                <?php elseif ($s->status == 'proses'): ?>
                                    <span class="badge proses">Proses</span>
                                <?php else: ?>
                                    <span class="badge selesai">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="post" action="<?= base_url('admin/update_status/' . $s->id_transaction) ?>">
                                    <?php if ($s->status == 'menunggu'): ?>
                                        <button class="btn-aksi btn-proses" name="status" value="proses">
                                            Update ke Proses
                                        </button>
                                    <?php elseif ($s->status == 'proses'): ?>
                                        <button class="btn-aksi btn-selesai" name="status" value="selesai">
                                            Selesaikan
                                        </button>
                                    <?php else: ?>
                                        <span class="done">✔ Selesai</span>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="padding: 30px; color: #888;">Data tidak ditemukan.</td>
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
