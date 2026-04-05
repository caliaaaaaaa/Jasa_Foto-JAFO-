<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>

<?php $active = 'log'; ?>
<?php $this->load->view('owner/components/sidebar', compact('active')); ?>

<style>

.container {
    width: 95%;
    margin: auto;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #e0e7ff;
    padding: 12px;
}

td {
    padding: 12px;
    text-align: center;
}

/* BADGE ROLE */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
}

.admin { background: #3498db; }
.kasir { background: #2ecc71; }
.owner { background: #9b59b6; }

/* ANIMASI */
tr {
    transition: 0.2s;
}
tr:hover {
    background: #f5f7ff;
}

</style>

<h2 style="margin-left:20px;">Log Aktivitas</h2>

<div class="container">

<table>

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Role</th>
    <th>Aktivitas</th>
    <th>Action</th>
    <th>Waktu</th>
</tr>

<?php $no=1; foreach($log as $l): ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $l->nama_lengkap ?? '-' ?></td>

 <td>
    <span class="badge <?= $l->role ?? '' ?>">
        <?= ucfirst($l->role ?? '-') ?>
    </span>
</td>

    <td><?= $l->aktivitas ?></td>
    <td><?= strtoupper($l->action) ?></td>
    <td><?= date('d-m-Y H:i', strtotime($l->created_at)) ?></td>
</tr>

<?php endforeach; ?>

</table>

</div>

<?php $this->load->view('owner/components/footer'); ?>
