<?php 

$this->load->view('admin/components/header'); 
$this->load->view('admin/components/navbar'); 

$active = 'user'; 
$this->load->view('admin/components/sidebar', compact('active')); 
?>

<style>
/* CONTAINER: untuk memposisikan form di tengah halaman */
.container-form {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

/* CARD: kotak utama form */
.form-card {
    background: #ffffff;
    padding: 40px;
    border-radius: 20px;
    width: 65%;
    max-width: 700px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transition: 0.3s;
}

/* TITLE: judul form */
.form-card h3 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 22px;
    font-weight: 600;
    color: #2F4B7C;
}

/* INPUT GROUP: pembungkus label dan input */
.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

/* LABEL INPUT */
.input-group label {
    margin-bottom: 6px;
    font-weight: 500;
    color: #333;
}

/* INPUT DAN SELECT */
.input-group input,
.input-group select {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}

/* efek saat input difokuskan */
.input-group input:focus,
.input-group select:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* BUTTON GROUP: posisi tombol */
.btn-group {
    margin-top: 25px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

/* tombol batal */
.btn-batal {
    padding: 10px 22px;
    border-radius: 10px;
    border: none;
    background: #ccc;
    cursor: pointer;
    transition: 0.2s;
}

/* hover batal */
.btn-batal:hover {
    background: #b3b3b3;
}

/* tombol simpan */
.btn-simpan {
    padding: 10px 22px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

/* hover simpan */
.btn-simpan:hover {
    background: #2F4B7C;
    transform: translateY(-1px);
}
</style>

<!-- heading kosong (kemungkinan untuk jarak layout) -->
<h2 style="margin-left:30px;"></h2>

<!-- menampilkan pesan error dari session -->
<?php if ($this->session->flashdata('error')): ?>
    <div style="background:#ffdddd; padding:12px; border-radius:10px; margin:20px; color:red; text-align:center;">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php 
// mengambil data lama jika validasi gagal (agar input tidak hilang)
$old = $this->session->flashdata('old'); 
?>

<div class="container-form">

    <div class="form-card">

        <h3>Tambah User</h3>

        <!-- form untuk mengirim data ke controller -->
        <form method="post" action="<?= base_url('admin/tambah_user') ?>">

            <!-- input username -->
            <div class="input-group">
                <label>Username</label>
                <input 
                    type="text" 
                    name="username"
                    value="<?= $old['username'] ?? '' ?>"
                    placeholder="Masukkan username">
            </div>

            <!-- input nama lengkap -->
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama"
                    value="<?= $old['nama'] ?? '' ?>"
                    placeholder="Masukkan nama lengkap">
            </div>


			    <!-- input password -->
            <div class="input-group">
                <label>Password</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Masukkan password">
            </div>


            <!-- pilihan role user -->
            <div class="input-group">
                <label>Role</label>
                <select name="role">
                    <!-- jika sebelumnya pilih admin, tetap terpilih -->
                    <option value="admin" <?= (isset($old['role']) && $old['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                    
                    <!-- role kasir -->
                    <option value="kasir" <?= (isset($old['role']) && $old['role'] == 'kasir') ? 'selected' : '' ?>>Kasir</option>
                    
                    <!-- role owner -->
                    <option value="owner" <?= (isset($old['role']) && $old['role'] == 'owner') ? 'selected' : '' ?>>Owner</option>
                </select>
            </div>

        

            <!-- tombol aksi -->
            <div class="btn-group">
                <!-- reset form -->
                <button type="reset" class="btn-batal">Batal</button>
                
                <!-- submit form -->
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>

        </form>

    </div>

</div>

<?php 
// memanggil footer (bagian bawah halaman)
$this->load->view('admin/components/footer'); 
?>
