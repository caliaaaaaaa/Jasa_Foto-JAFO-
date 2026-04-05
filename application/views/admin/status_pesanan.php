<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'status'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* CARD UTAMA */
.container-status {
    background: #f4f6fb;
    padding: 30px;
    border-radius: 20px;
    width: 95%;
    margin: auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* HEADER */
.header-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* SEARCH */
.search-box {
    padding: 8px 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

th {
    background: #dfe3f2;
    padding: 12px;
    text-align: center;
}

td {
    padding: 12px;
    text-align: center;
}

/* ROW */
tr:nth-child(even) {
    background: #f9f9f9;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
}

/* WARNA STATUS */
.proses {
    background: #f1c40f;
}

.selesai {
    background: #2ecc71;
}

/* PAGINATION */
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination span {
    padding: 6px 10px;
    margin: 3px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
}

/* SELECT */
select {
    padding: 8px 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    transition: 0.2s;
}
select:focus {
    border-color: #3B6FB6;
}

/* BADGE LEBIH HIDUP */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    animation: fadeIn 0.5s ease;
}

/* WARNA */
.menunggu { background: #95a5a6; }
.proses { background: #f1c40f; }
.selesai { background: #2ecc71; }

/* BUTTON AKSI */
.btn-aksi {
    padding: 6px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.2s;
}

.btn-proses {
    background: #f39c12;
    color: white;
}
.btn-proses:hover {
    background: #d68910;
}

.btn-selesai {
    background: #2ecc71;
    color: white;
}
.btn-selesai:hover {
    background: #27ae60;
}

/* ANIMASI */
@keyframes fadeIn {
    from {opacity:0; transform:translateY(5px);}
    to {opacity:1; transform:translateY(0);}
}

/* BUTTON AKSI */
.btn-aksi {
    padding: 6px 14px;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 12px;
    cursor: pointer;
    transition: 0.3s;
}

/* PROSES */
.btn-proses {
    background: #f1c40f;
}
.btn-proses:hover {
    background: #d4ac0d;
    transform: scale(1.05);
}

/* SELESAI */
.btn-selesai {
    background: #2ecc71;
}
.btn-selesai:hover {
    background: #27ae60;
    transform: scale(1.05);
}

/* DONE ICON */
.done {
    font-size: 16px;
    color: #2ecc71;
}

.btn-aksi:active {
    transform: scale(0.95);
}
</style>

<h2>STATUS PESANAN</h2>

<div class="container-status">

    <!-- FILTER + SEARCH -->
<form method="get" action="<?= base_url('admin/status_pesanan') ?>">
    <div class="header-status">

        <select name="status" onchange="this.form.submit()">
    <option value="all">Semua Status</option>
    <option value="menunggu" <?= ($filter_status=='menunggu')?'selected':'' ?>>Menunggu</option>
    <option value="proses" <?= ($filter_status=='proses')?'selected':'' ?>>Proses</option>
    <option value="selesai" <?= ($filter_status=='selesai')?'selected':'' ?>>Selesai</option>
</select>


       <input type="text" name="keyword" class="search-box" 
       placeholder="🔍 Search"
       value="<?= $keyword ?>"
       onkeydown="if(event.key==='Enter'){this.form.submit()}">

    </div>
</form>

    <!-- TABLE -->
    <table>

        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Paket Foto</th>
            <th>Lokasi</th>
            <th>Tanggal Acara</th>
            <th>Status</th>
			<th>Aksi</th>
        </tr>

        <?php $no=1; foreach($status as $s): ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $s->nama_lengkap ?? '-' ?></td>
            <td><?= $s->nama_paket ?? '-' ?></td>
			<td><?= $s->lokasi ?? '-' ?></td>
            <td><?= $s->tanggal_acara ?? '-' ?></td>

           <td>
    <?php if($s->status == 'menunggu'): ?>
        <span class="badge" style="background:#95a5a6;">Menunggu</span>
    <?php elseif($s->status == 'proses'): ?>
        <span class="badge proses">Proses</span>
    <?php else: ?>
        <span class="badge selesai">Selesai</span>
    <?php endif; ?>
</td>


<td>
    <form method="post" action="<?= base_url('admin/update_status/'.$s->id_transaction) ?>">

        <?php if($s->status == 'menunggu'): ?>
            <button class="btn-aksi btn-proses" name="status" value="proses">
                Proses
            </button>

        <?php elseif($s->status == 'proses'): ?>
            <button class="btn-aksi btn-selesai" name="status" value="selesai">
                Selesai
            </button>

        <?php else: ?>
            <span class="done">✔ Selesai</span>
        <?php endif; ?>

    </form>
</td>
</td>
        </tr>

        <?php endforeach; ?>

    </table>

    <!-- PAGINATION -->
<div class="pagination">
    <?= $pagination ?>
</div>
</div>

<?php $this->load->view('admin/components/footer'); ?>
