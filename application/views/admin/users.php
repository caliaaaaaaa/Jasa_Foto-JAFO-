<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>
	
<?php $active = 'user'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* CONTAINER */
.container-user {
    background: #f4f6fb;
    padding: 30px;
    border-radius: 20px;
    width: 95%;
    margin: auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* HEADER */
.header-user {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* BUTTON TAMBAH */
.btn-tambah {
    background: #3B6FB6;
    color: white;
    padding: 8px 15px;
    border-radius: 10px;
    text-decoration: none;
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

/* BADGE STATUS */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
}

.aktif {
    background: #2ecc71;
}

.nonaktif {
    background: #e74c3c;
}

/* AKSI BUTTON */
.btn-aksi {
    padding: 5px 10px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12px;
    margin: 2px;
}

.edit {
    background: #3498db;
    color: white;
}

.nonaktif-btn {
    background: #e67e22;
    color: white;
}

/* PAGINATION */
.pagination a,
.pagination strong {
    padding: 6px 12px;
    margin: 3px;
    border-radius: 6px;
    text-decoration: none;
    border: 1px solid #ccc;
    color: #333;
	
}

.pagination strong {
    background: #3B6FB6;
    color: white;
    border: none;
}


.pagination {
    margin-top: 20px;
    text-align: center; /* 🔥 ini bikin ke tengah */
}
</style>

<h2>DATA USER</h2>

<div class="container-user">

    <!-- HEADER -->
    <div class="header-user">

        <a href="<?= base_url('admin/form_tambah') ?>" class="btn-tambah">
            + Tambah User
        </a>

       <form method="get" action="<?= base_url('admin/users') ?>">
    <input type="text" name="keyword" class="search-box"
           placeholder="🔍 Search"
           value="<?= $keyword ?>">
</form>

    </div>

    <!-- TABLE -->
    <table>

        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; foreach($users as $u): ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $u->username ?></td>
            <td><?= $u->nama_lengkap ?></td>
            <td><?= ucfirst($u->role) ?></td>

            <td>
                <?php if($u->status == 'aktif'): ?>
                    <span class="badge aktif">Aktif</span>
                <?php else: ?>
                    <span class="badge nonaktif">Nonaktif</span>
                <?php endif; ?>
            </td>

            <td>
                <a href="<?= base_url('admin/form_edit/'.$u->id_user) ?>" class="btn-aksi edit">
                    Edit
                </a>

                <a href="<?= base_url('admin/nonaktif_user/'.$u->id_user) ?>" class="btn-aksi nonaktif-btn">
                    Nonaktif
                </a>
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
