<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'user'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* CARD FORM */
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
    margin-bottom: 20px;
    text-align: center;
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

.btn-update {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
}

/* HOVER */
.btn-update:hover {
    background: #2F4B7C;
}

</style>

<br>
<br>
<br>
<br>

<div class="container-form">

    <div class="form-card">

        <h3>Edit User</h3>

        <form method="post" action="<?= base_url('admin/edit_user/'.$user->id_user) ?>">

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= $user->username ?>">
            </div>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= $user->nama_lengkap ?>">
            </div>

			

<div class="input-group">
				<label>Password </label>
				<input type="password" name="password" value="<?= $user->password ?>">

            <div class="input-group">
                <label>Role</label>
                <select name="role">
                    <option value="admin" <?= $user->role=='admin'?'selected':'' ?>>Admin</option>
                    <option value="kasir" <?= $user->role=='kasir'?'selected':'' ?>>Kasir</option>
                    <option value="owner" <?= $user->role=='owner'?'selected':'' ?>>Owner</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="reset" class="btn-batal">Batal</button>
                <button type="submit" class="btn-update">Update</button>
            </div>

        </form>

    </div>

</div>

<?php $this->load->view('admin/components/footer'); ?>
