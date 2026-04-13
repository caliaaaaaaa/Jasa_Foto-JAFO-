<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>

<?php $active = 'status'; ?>
<?php $this->load->view('owner/components/sidebar', compact('active')); ?> 

<style>
/* CONTAINER UTAMA HALAMAN STATUS */
.container-status {
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    width: 95%;
    margin: 20px auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* HEADER / AREA FILTER (SELECT + SEARCH) */
.header-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
    flex-wrap: wrap;
}

/* INPUT SEARCH DAN SELECT FILTER */
.search-box, select {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

/* SEARCH AKAN MENGISI SISA RUANG */
.search-box {
    flex: 1;
    min-width: 200px;
}

/* EFEK FOCUS INPUT */
.search-box:focus, select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* WRAPPER TABEL AGAR RESPONSIVE (BISA SCROLL) */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
}

/* TABEL DATA */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    min-width: 1000px;
}

/* HEADER KOLOM */
th {
    background: #dfe3f2;
    padding: 14px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
}

/* ISI DATA */
td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
    border-bottom: 1px solid #f0f0f0;
}

/* WARNA SELANG SELING */
tr:nth-child(even) { background: #f9fbfd; }

/* HOVER ROW */
tr:hover { background: #f1f5ff; transition: 0.2s; }

/* BADGE STATUS (MENUNGGU, PROSES, SELESAI) */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
}

/* WARNA STATUS */
.menunggu { background: #95a5a6; }
.proses { background: #f1c40f; }
.selesai { background: #2ecc71; }

/* PAGINATION */
.pagination {
    margin-top: 25px;
    text-align: center;
}

/* STYLE LINK PAGINATION */
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

/* HALAMAN AKTIF */
.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .header-status { flex-direction: column; align-items: stretch; }
    .search-box, select { width: 100%; }
    .container-status { padding: 15px; width: 98%; }
}
</style>

<div class="container-status">

    <!-- JUDUL HALAMAN -->
    <h3 style="margin-bottom: 20px;">Status Pesanan</h3>

    <!-- FORM FILTER (STATUS + SEARCH) -->
    <form method="get" action="<?= base_url('owner/status_pesanan') ?>">
        <div class="header-status">

            <!-- FILTER STATUS (AUTO SUBMIT SAAT DIPILIH) -->
            <select name="status" onchange="this.form.submit()">
                <option value="all">Semua Status</option>
                <option value="menunggu" <?= ($filter_status == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                <option value="proses" <?= ($filter_status == 'proses') ? 'selected' : '' ?>>Proses</option>
                <option value="selesai" <?= ($filter_status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>

            <!-- SEARCH BERDASARKAN NO PESANAN / NAMA -->
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
                </tr>
            </thead>

            <tbody>

                <!-- CEK DATA ADA / TIDAK -->
                <?php if (!empty($status)): ?>

                    <?php $no = 1; foreach ($status as $s): ?>
                        <tr>

                            <!-- NOMOR -->
                            <td><?= $no++ ?></td>

                            <!-- NOMOR PESANAN -->
                            <td style="font-weight: bold; color: #3B6FB6;">
                                <?= $s->nomor_pesanan ?? '-' ?>
                            </td>

                            <!-- DATA CUSTOMER -->
                            <td><?= $s->nama_lengkap ?? '-' ?></td>
                            <td><?= $s->no_hp ?? '-' ?>

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

                            <!-- FORMAT TANGGAL & JAM -->
                            <td><?= date('d/m/Y', strtotime($s->tanggal_acara)) ?></td>
                            <td><?= date('H:i', strtotime($s->jam_acara)) ?></td>

                            <!-- STATUS DENGAN BADGE -->
                            <td>
                                <?php if ($s->status == 'menunggu'): ?>
                                    <span class="badge menunggu">Menunggu</span>
                                <?php elseif ($s->status == 'proses'): ?>
                                    <span class="badge proses">Proses</span>
                                <?php else: ?>
                                    <span class="badge selesai">Selesai</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <!-- JIKA DATA KOSONG -->
                    <tr>
                        <td colspan="9" style="padding: 30px; color: #888;">
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

<?php $this->load->view('owner/components/footer'); ?> <!-- Footer -->
