<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>

<?php $active = 'activity_log'; ?>
<?php $this->load->view('owner/components/sidebar', compact('active')); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .container-activity {
        width: 95%;
        margin: 20px auto;
    }

    /* BUTTON SWITCH (TAB STYLE) */
    .switch {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        background: #e2e8f0;
        padding: 5px;
        border-radius: 12px;
        width: fit-content;
    }

    .switch a {
        padding: 8px 24px;
        border-radius: 10px;
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .switch a.active {
        background: #ffffff;
        color: #3B6FB6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* CARD CONTAINER */
    .card-activity {
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        animation: fadeIn 0.4s ease;
    }

    /* TABLE STYLING */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    th {
        background: #f1f5f9;
        color: #475569;
        padding: 16px;
        text-align: center;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    td {
        padding: 16px;
        text-align: center;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background: #f8fafc;
        transition: 0.2s;
    }

    /* SOFT BADGES */
    .badge {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .admin { background: #eff6ff; color: #1d4ed8; } /* Soft Blue */
    .kasir { background: #ecfdf5; color: #047857; } /* Soft Green */

    /* ACTION TEXT */
    .action-tag {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        color: #334155;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* PAGINATION */
    .pagination {
        margin-top: 25px;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .pagination a, .pagination strong {
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: 0.3s;
    }

    .pagination a:hover {
        background: #f1f5f9;
    }

    .pagination strong {
        background: #3B6FB6;
        color: white;
        border: none;
    }

    @keyframes fadeIn {
        from {opacity:0; transform:translateY(10px);}
        to {opacity:1; transform:translateY(0);}
    }
</style>

<div class="container-activity">

    <div class="switch">
        <a href="<?= base_url('owner/activity_log?role=admin') ?>"
           class="<?= ($role=='admin') ? 'active' : '' ?>">Admin</a>

        <a href="<?= base_url('owner/activity_log?role=kasir') ?>"
           class="<?= ($role=='kasir') ? 'active' : '' ?>">Kasir</a>
    </div>

    <div class="card-activity">
        <h3 style="margin-top:0; margin-bottom: 20px; font-weight: 600; color: #1e293b;">Log Aktivitas Pengguna</h3>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pengguna</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Action</th>
                        <th>Waktu Kejadian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($log)): ?>
                        <?php $no=1; foreach($log as $l): ?>
                        <tr>
                            <td style="color: #94a3b8;"><?= $no++ ?></td>
                            <td style="font-weight: 500;"><?= $l->nama_lengkap ?? '-' ?></td>
                            <td>
                                <span class="badge <?= $l->role ?>">
                                    <?= $l->role ?>
                                </span>
                            </td>
                            <td style="text-align: left;"><?= $l->aktivitas ?></td>
                            <td><span class="action-tag"><?= strtoupper($l->action) ?></span></td>
                            <td>
                                <div style="font-weight: 500;"><?= date('d M Y', strtotime($l->created_at)) ?></div>
                                <small style="color: #94a3b8;"><?= date('H:i', strtotime($l->created_at)) ?> WIB</small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 40px; color: #94a3b8;">Tidak ada log aktivitas untuk role ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?= $pagination ?>
        </div>
    </div>

</div>

<?php $this->load->view('owner/components/footer'); ?>
