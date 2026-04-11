<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'user'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>
/* CONTAINER */
.container-form {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

/* CARD */
.form-card {
    background: #ffffff;
    padding: 40px;
    border-radius: 20px;
    width: 65%;
    max-width: 700px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transition: 0.3s;
}

/* TITLE */
.form-card h3 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 22px;
    font-weight: 600;
    color: #2F4B7C;
}

/* INPUT GROUP */
.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

.input-group label {
    margin-bottom: 6px;
    font-weight: 500;
    color: #333;
}

/* INPUT */
.input-group input,
.input-group select {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}

.input-group input:focus,
.input-group select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* BUTTON */
.btn-group {
    margin-top: 25px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-batal {
    padding: 10px 22px;
    border-radius: 10px;
    border: none;
    background: #ccc;
    cursor: pointer;
    transition: 0.2s;
}

.btn-batal:hover {
    background: #b3b3b3;
}

.btn-simpan {
    padding: 10px 22px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.btn-simpan:hover {
    background: #2F4B7C;
    transform: translateY(-1px);
}
</style>

<h2 style="margin-left:30px;"></h2>

<?php if ($this->session->flashdata('error')): ?>
    <div style="background:#ffdddd; padding:12px; border-radius:10px; margin:20px; color:red; text-align:center;">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php $old = $this->session->flashdata('old'); ?>

<div class="container-form">

    <div class="form-card">

        <h3>Tambah User</h3>

        <form method="post" action="<?= base_url('admin/tambah_user') ?>">

            <div class="input-group">
                <label>Username</label>
                <input 
                    type="text" 
                    name="username"
                    value="<?= $old['username'] ?? '' ?>"
                    placeholder="Masukkan username">
            </div>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama"
                    value="<?= $old['nama'] ?? '' ?>"
                    placeholder="Masukkan nama lengkap">
            </div>

            <div class="input-group">
                <label>Role</label>
                <select name="role">
                    <option value="admin" <?= (isset($old['role']) && $old['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="kasir" <?= (isset($old['role']) && $old['role'] == 'kasir') ? 'selected' : '' ?>>Kasir</option>
                    <option value="owner" <?= (isset($old['role']) && $old['role'] == 'owner') ? 'selected' : '' ?>>Owner</option>
                </select>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Masukkan password">
            </div>

            <div class="btn-group">
                <button type="reset" class="btn-batal">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>

        </form>

    </div>

</div>

<?php $this->load->view('admin/components/footer'); ?>
