<?php $this->load->view('kasir/components/header'); ?>
<?php $this->load->view('kasir/components/navbar'); ?>

<?php $active = 'status'; ?>
<?php $this->load->view('kasir/components/sidebar', compact('active')); ?>

<style>
/* Container utama untuk membungkus halaman status */
.container-status {
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    width: 95%;
    margin: 20px auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* Bagian atas untuk filter (dropdown + search) */
.header-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
    flex-wrap: wrap;
}

/* Input search dan dropdown filter */
.search-box, select {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

/* Khusus input search agar fleksibel */
.search-box {
    flex: 1;
    min-width: 200px;
}

/* Efek saat input atau select aktif */
.search-box:focus, select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* Pembungkus tabel supaya bisa discroll di layar kecil */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 12px;
}

/* Styling tabel utama */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    min-width: 1000px; /* Supaya kolom tidak berantakan di layar kecil */
}

/* Header tabel */
th {
    background: #dfe3f2;
    padding: 14px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
}

/* Isi tabel */
td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

/* Warna selang-seling dan efek hover */
tr:nth-child(even) { background: #f9fbfd; }
tr:hover { background: #f1f5ff; transition: 0.2s; }

/* Badge untuk menampilkan status */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
    animation: fadeIn 0.3s ease;
}

/* Warna masing-masing status */
.menunggu { background: #95a5a6; }
.proses { background: #f1c40f; }
.selesai { background: #2ecc71; }

/* Pagination di bawah tabel */
.pagination {
    margin-top: 25px;
    text-align: center;
}

/* Styling tombol pagination */
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

/* Halaman aktif */
.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}

/* Animasi kecil saat badge muncul */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}


@media (max-width: 768px) {
    .header-status { flex-direction: column; align-items: stretch; }
    .search-box, select { width: 100%; }
    .container-status { padding: 15px; width: 98%; }
}
</style>


<div class="container-status">
    <h3 style="margin-bottom: 20px;">Status Pesanan</h3>

    
    <form method="get" action="<?= base_url('kasir/status_pesanan') ?>">
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
                </tr>
            </thead>

            <tbody>

                <!-- Cek apakah ada data -->
                <?php if (!empty($status)): ?>

                    <!-- Loop data dari database -->
                    <?php $no = 1; foreach ($status as $s): ?>
                        <tr>

                            <td><?= $no++ ?></td>

                            <!-- Data transaksi -->
                            <td style="font-weight: bold; color: #3B6FB6;"><?= $s->nomor_pesanan ?? '-' ?></td>
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

                         
                            <td><?= date('d/m/Y', strtotime($s->tanggal_acara)) ?></td>

                        
                            <td><?= date('H:i', strtotime($s->jam_acara)) ?></td>

                            <!-- Menampilkan status dengan badge -->
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

                   
                    <tr>
                        <td colspan="9" style="padding: 30px; color: #888;">
                            Data tidak ditemukan.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?= $pagination ?>
    </div>
</div>

<?php $this->load->view('kasir/components/footer'); ?>
