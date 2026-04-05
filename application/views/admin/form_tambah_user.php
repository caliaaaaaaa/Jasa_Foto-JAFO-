<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>
	
<?php $active = 'user'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* CONTAINER */
.container-form {
    background: #f4f6fb;
    padding: 30px;
    border-radius: 20px;
    width: 95%;
    margin: auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* CARD */
.form-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 50%;
    margin: auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* TITLE */
.form-card h3 {
    text-align: center;
    margin-bottom: 20px;
}

/* INPUT GROUP */
.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.input-group label {
    margin-bottom: 5px;
    font-weight: 500;
}

/* INPUT */
.input-group input,
.input-group select {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    transition: 0.3s;
}

.input-group input:focus,
.input-group select:focus {
    border-color: #3B6FB6;
}

/* BUTTON */
.btn-group {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-batal {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    background: #ccc;
    cursor: pointer;
}

.btn-simpan {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
}

.btn-simpan:hover {
    background: #2F4B7C;
}

</style>

<h2 style="margin-left:30px;">TAMBAH USER</h2>

<div class="container-form">

    <div class="form-card">

        <h3>Form Tambah User</h3>

        <form method="post" action="<?= base_url('admin/tambah_user') ?>">

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username">
            </div>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap">
            </div>

            <div class="input-group">
                <label>Role</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password">
            </div>

            <div class="btn-group">
                <button type="reset" class="btn-batal">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>

        </form>

    </div>

</div>

<?php $this->load->view('admin/components/footer'); ?>
