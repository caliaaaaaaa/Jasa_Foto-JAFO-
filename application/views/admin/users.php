<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'user'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>
    /* UTAMA */
    .container-user {
        background: #ffffff;
        padding: 30px;
        border-radius: 20px;
        width: 95%;
        margin: 20px auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    /* HEADER: Tombol Tambah & Search */
    .header-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-tambah {
        background: #3B6FB6;
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .btn-tambah:hover {
        background: #2f5da3;
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 5px 15px rgba(59, 111, 182, 0.3);
    }

    /* FORM PENCARIAN */
    .search-form {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        min-width: 250px;
    }

    .search-box {
        width: 100%;
        max-width: 300px;
        padding: 10px 15px;
        border-radius: 12px;
        border: 1px solid #ddd;
        outline: none;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .search-box:focus {
        border-color: #3B6FB6;
        box-shadow: 0 0 0 3px rgba(59, 111, 182, 0.1);
    }

    /* TABEL RESPONSIF */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        min-width: 800px; /* Menjamin kolom tidak gepeng */
    }

    th {
        background: #dfe3f2;
        padding: 15px;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }

    td {
        padding: 15px;
        text-align: center;
        font-size: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f7f7f7;
        color: #555;
    }

    tr:hover {
        background: #f8faff;
    }

    /* STATUS & TOMBOL */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        color: white;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
    }

    .aktif { background: #2ecc71; }
    .nonaktif { background: #e74c3c; }

    .btn-aksi {
        padding: 7px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        margin: 2px;
        display: inline-block;
        transition: 0.2s;
    }

    .edit { background: #3498db; color: white; }
    .edit:hover { background: #2980b9; color: white; }

    .nonaktif-btn { background: #e67e22; color: white; }
    .nonaktif-btn:hover { background: #d35400; color: white; }

    .aktif-btn { background: #2ecc71; color: white; }
    .aktif-btn:hover { background: #27ae60; color: white; }

    /* PAGINATION */
    .pagination {
        margin-top: 25px;
        text-align: center;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .pagination a, .pagination strong {
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        border: 1px solid #eee;
        color: #555;
        font-size: 13px;
        transition: 0.3s;
    }

    .pagination a:hover {
        background: #3B6FB6;
        color: white;
        border-color: #3B6FB6;
    }

    .pagination strong {
        background: #3B6FB6;
        color: white;
        border: none;
    }

    /* LAYAR HP (Mobile) */
    @media (max-width: 768px) {
        .header-user {
            flex-direction: column;
            align-items: stretch;
        }

        .search-form {
            justify-content: center;
            min-width: 100%;
        }

        .search-box {
            max-width: 100%;
        }

        .btn-tambah {
            justify-content: center;
        }

        .container-user {
            padding: 15px;
            width: 98%;
        }
    }
</style>

<div class="container-user">

    <div class="header-user">
        <a href="<?= base_url('admin/form_tambah') ?>" class="btn-tambah">
            <i class="fa fa-plus-circle" style="margin-right: 8px;"></i> Tambah User Baru
        </a>

        <form method="get" action="<?= base_url('admin/users') ?>" class="search-form">
            <input type="text" name="keyword" class="search-box"
                placeholder="🔍 Cari username atau nama..."
                value="<?= $keyword ?? '' ?>">
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role Access</th>
                    <th>Status Akun</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)): ?>
                    <?php $no = 1; foreach ($users as $u): ?>
                    <tr>
                        <td width="50"><?= $no++ ?></td>
                        <td><strong><?= $u->username ?></strong></td>
                        <td><?= $u->nama_lengkap ?></td>
                        <td>
                            <span style="color: #3B6FB6; font-weight: 500;">
                                <i class="fa fa-user-shield"></i> <?= ucfirst($u->role) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($u->status == 'aktif'): ?>
                                <span class="badge aktif">Aktif</span>
                            <?php else: ?>
                                <span class="badge nonaktif">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/form_edit/' . $u->id_user) ?>" class="btn-aksi edit" title="Ubah Data">
                                Edit
                            </a>

                            <?php if ($u->status == 'aktif'): ?>
                                <a href="<?= base_url('admin/nonaktif_user/' . $u->id_user) ?>"
                                    class="btn-aksi nonaktif-btn" 
                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan akun ini?')">
                                    Nonaktifkan
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/aktif_user/' . $u->id_user) ?>"
                                    class="btn-aksi aktif-btn">
                                    Aktifkan
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 40px; color: #999;">
                            <i class="fa fa-info-circle"></i> Tidak ada data user yang ditemukan.
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
