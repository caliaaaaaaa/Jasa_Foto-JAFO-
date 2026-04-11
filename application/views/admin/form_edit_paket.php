<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>
	
<?php $active = 'kelola'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>
<style>

/* DESKRIPSI BIAR BESAR */
textarea {
    min-height: 150px;
    resize: vertical;
}

/* OPTIONAL: BIAR LEBIH PROPORSIONAL */
.input-group textarea {
    padding: 12px;
    line-height: 1.5;
}

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
    padding: 15px;
    text-align: center;
    height: auto; /* penting */
}

.upload-box:hover {
    border-color: #3B6FB6;
    background: #f9fbff;
}

.upload-box p {
    margin-bottom: 10px;
    font-size: 14px;
    color: #666;
}

.upload-box input {
    margin-top: 10px;
}

.upload-box button {
    margin-top: 10px;
    padding: 8px 15px;
    border-radius: 10px;
    border: none;
    background: #3B6FB6;
    color: white;
    cursor: pointer;
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



<div class="form-container">

<form method="post" enctype="multipart/form-data" action="<?= base_url('admin/edit_paket/'.$paket->id_paket) ?>">

<div class="form-grid">

    <!-- KIRI -->
    <div>

        <!-- NAMA -->
        <div class="input-group">
            <label>Nama Paket</label>
            <input type="text" name="nama" value="<?= $paket->nama_paket ?>">
        </div>
<br>

        <!-- DURASI -->
        <div class="input-group">
            <label>Durasi Pemotretan</label>
            <input type="number" name="durasi" value="<?= $paket->durasi_jam ?>">
        </div>

        <!-- UPLOAD -->
   <div class="input-group">
                        <label>Foto Paket</label>
                        <div class="upload-box">
                            <p>Format: JPG, PNG, WEBP </p>
                            <input type="file" name="gambar" id="gambarInput" onchange="previewGambar(event)" style="display:none;">
                            <button type="button" class="btn-upload-custom" onclick="document.getElementById('gambarInput').click()">
                                <i class="fa fa-cloud-upload"></i> Pilih Gambar
                            </button>
                        </div>
                    </div>

        <!-- DESKRIPSI -->
        <div class="input-group">
            <label>Deskripsi Paket</label>
            <textarea name="deskripsi"><?= $paket->deskripsi ?></textarea>
        </div>


		
    </div>

    <!-- KANAN -->
    <div>

        <div class="input-group">
            <label>Estimasi Pengerjaan</label>
            <input type="text" name="estimasi" value="<?= $paket->durasi_jam ?> Jam">
        </div>

        <div class="input-group">
            <label>Harga Paket</label>
            <input type="number" name="harga" value="<?= $paket->harga ?>">
        </div>

        <!-- PREVIEW -->
 

        <!-- JENIS -->
        <div class="input-group">
            <label>Jenis Paket</label>
            <select name="jenis">
                <option value="Basic" <?= ($paket->jenis == 'Basic')?'selected':'' ?>>Basic</option>
                <option value="Plus" <?= ($paket->jenis == 'Plus')?'selected':'' ?>>Plus</option>
                <option value="Premium" <?= ($paket->jenis == 'Premium')?'selected':'' ?>>Premium</option>
            </select>
        </div>

       <div class="input-group">
            <label>Preview Gambar</label>

            <img id="preview" 
                 src="<?= base_url('assets/images/'.$paket->gambar) ?>" 
                 style="width:50%; height:300px; object-fit:cover; border-radius:10px;">
        </div>

    </div>

</div>

<!-- 🔥 BUTTON KANAN -->
<div class="btn-group">
    <button type="reset" class="btn-batal">Batal</button>
    <button type="submit" class="btn-simpan">Update</button>
</div>

</form>
