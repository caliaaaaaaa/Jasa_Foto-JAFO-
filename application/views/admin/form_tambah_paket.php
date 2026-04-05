<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>
	
<?php $active = 'kelola'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>
<style>

.form-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    margin: auto;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}


/* GRID 2 KOLOM */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* INPUT */
.input-group {
    display: flex;
    flex-direction: column;
}

.input-group label {
    margin-bottom: 5px;
    font-weight: 500;
}

.input-group input,
.input-group select,
.input-group textarea {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

/* UPLOAD BOX */
.upload-box {
    border: 2px dashed #ccc;
    border-radius: 15px;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

/* BUTTON */
.btn-group {
    margin-top: 20px;
    text-align: right;
}

.btn-batal {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    background: #ccc;
}

.btn-simpan {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
}

.upload-box {
    border: 2px dashed #ccc;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
}

.upload-box button {
    margin-top: 10px;
    padding: 8px 15px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
	  margin: auto;
}

</style>

<script>
function previewGambar(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    const file = input.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>


<h2>Kelola Paket Foto</h2><br>


<div class="form-container">

<form method="post" enctype="multipart/form-data" action="<?= base_url('admin/tambah_paket') ?>">

<div class="form-grid">

    <!-- KIRI -->
    <div>

        <!-- NAMA -->
        <div class="input-group">
            <label>Nama Paket</label>
            <input type="text" name="nama">
        </div>
<br>
        <!-- DURASI -->
        <div class="input-group">
            <label>Durasi Pemotretan</label>
            <input type="number" name="durasi">
        </div>

        <!-- 🔥 UPLOAD GAMBAR (PINDAH KE SINI) -->
        <div class="input-group">
            <label>Upload Gambar</label>

            <div class="upload-box">
                <p>Drag & Drop Image</p>
                
                <!-- INPUT FILE -->
                <input type="file" name="gambar" id="gambarInput" onchange="previewGambar(event)">
                
                <button type="button" onclick="document.getElementById('gambarInput').click()">
                    Pilih Gambar
                </button>
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div class="input-group">
            <label>Deskripsi Paket</label>
            <textarea name="deskripsi"></textarea>
        </div>

    </div>

    <!-- KANAN -->
    <div>

        <div class="input-group">
            <label>Estimasi Pengerjaan</label>
            <input type="text" name="estimasi">
        </div>

        <div class="input-group">
            <label>Harga Paket</label>
            <input type="number" name="harga">
        </div>

        <!-- 🔥 PREVIEW GAMBAR -->
        <div class="input-group">
            <label>Preview Gambar</label>

            <img id="preview" src="" 
                 style="width:50%; height:300px; object-fit:cover; border-radius:10px; display:none;">
        </div>

        <div class="input-group">
            <label>Jenis Paket</label>
            <select name="jenis">
                <option>Basic</option>
                <option>Plus</option>
                <option>Premium</option>
            </select>
        </div>

    </div>

</div>

<div class="btn-group">
    <button type="reset" class="btn-batal">Batal</button>
    <button type="submit" class="btn-simpan">Simpan</button>
</div>

</form>

</div>

</div>
</div>
