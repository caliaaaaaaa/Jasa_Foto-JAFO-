<?php $this->load->view('admin/components/header'); ?>
<?php $this->load->view('admin/components/navbar'); ?>

<?php $active = 'kelola'; ?>
<?php $this->load->view('admin/components/sidebar', compact('active')); ?>

<style>

/* WRAPPER HALAMAN UTAMA */
.page-wrapper {
    width: 95%;
    margin: 30px auto;
}

/* CARD: container utama form */
.form-container {
    background: #ffffff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

/* TITLE */
.form-title {
    text-align: center;
    margin-bottom: 25px;
}

.form-title h2 {
    display: inline-block;
    background: #f1f3f7;
    padding: 12px 25px;
    border-radius: 15px;
    font-size: 20px;
}

/* GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

/* INPUT GROUP LABEL + INPUT  */
.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.input-group label {
    margin-bottom: 6px;
    font-weight: 500;
}

/* INPUT STYLE */
.input-group input,
.input-group select,
.input-group textarea {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
}

/* efek saat input di klik */
.input-group input:focus,
.input-group select:focus,
.input-group textarea:focus {
    border-color: #3B6FB6;
    box-shadow: 0 0 0 3px rgba(59,111,182,0.1);
}

/* TEXTAREA */
textarea {
    min-height: 110px;
}

/* UPLOAD BOX: area upload gambar */
.upload-box {
    border: 2px dashed #ccc;
    border-radius: 15px;
    padding: 15px;
    text-align: center;
    height: auto; 
}

/* efek hover upload */
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

/* PREVIEW */
.preview-img {
    width: 70%;
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
    display: none;
    margin-top: 10px;
}

/* BUTTON */
.btn-group {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-batal,
.btn-simpan {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-batal {
    background: #ccc;
}

.btn-batal:hover {
    background: #b5b5b5;
}

.btn-simpan {
    background: #3B6FB6;
    color: white;
}

.btn-simpan:hover {
    background: #2F4B7C;
    transform: translateY(-2px);
}

/* ALERT ERROR dari server */
.alert-error {
    background: #ffe5e5;
    padding: 12px;
    border-radius: 10px;
    color: red;
    margin-bottom: 20px;
}

/* PREVIEW CARD */
.preview-card {
    width: 100%;
    max-width: 320px; /* biar ga kepanjangan */
    height: 260px;
    border-radius: 15px;
    overflow: hidden;
    background: #f4f6fb;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    margin-top: 5px;
}

/* GAMBAR */
.preview-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

/* TEXT DEFAULT */
.preview-text {
    position: absolute;
    color: #aaa;
    font-size: 13px;
}
</style>

<script>
function previewGambar(event) {
	 // mengambil input file
    const input = event.target;
	// mengambil elemen img preview
    const preview = document.getElementById('preview');
	// mengambil file pertama yang dipilih memey
    const file = input.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
		 // tampilkan gambar
        preview.style.display = 'block';
    }
}
</script>

<div class="page-wrapper">

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert-error">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php $old = $this->session->flashdata('old'); ?>

    <div class="form-container">

        <div class="form-title">
            <h2>Kelola Paket</h2>
        </div>

		<!-- form kirim ke controller -->
        <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/tambah_paket') ?>">

            <div class="form-grid">

                <!-- KIRI -->
                <div>

                    <div class="input-group">
                        <label>Nama Paket</label>
                        <input type="text" name="nama" value="<?= $old['nama'] ?? '' ?>">
                    </div>

                    <div class="input-group">
                        <label>Durasi Pemotretan</label>
                        <input type="number" name="durasi" value="<?= $old['durasi'] ?? '' ?>">
                    </div>

					<div class="input-group">
                        <label>Foto Paket</label>
                        <div class="upload-box">
                            <p>Format: JPG & PNG </p>
                            <input type="file" name="gambar" id="gambarInput" onchange="previewGambar(event)" style="display:none;">
                            <button type="button" class="btn-upload-custom" onclick="document.getElementById('gambarInput').click()">
                                <i class="fa fa-cloud-upload"></i> Pilih Gambar
                            </button>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Deskripsi Paket</label>
                        <textarea name="deskripsi"><?= $old['deskripsi'] ?? '' ?></textarea>
                    </div>

                </div>

                <!-- KANAN -->
                <div>

				<div class="input-group">
					<label>Estimasi Pengerjaan</label>
					<input type="text" name="estimasi" value="<?= $old['estimasi'] ?? '' ?>" placeholder="contoh: 1-3 hari">
				</div>

                    <div class="input-group">
                        <label>Harga Paket</label>
                        <input type="number" name="harga" value="<?= $old['harga'] ?? '' ?>">
                    </div>

                   

                    <div class="input-group">
                        <label>Jenis Paket</label>
                        <select name="jenis">
                            <option value="Basic" <?= (isset($old['jenis']) && $old['jenis'] == 'Basic') ? 'selected' : '' ?>>Basic</option>
                            <option value="Plus" <?= (isset($old['jenis']) && $old['jenis'] == 'Plus') ? 'selected' : '' ?>>Plus</option>
                            <option value="Premium" <?= (isset($old['jenis']) && $old['jenis'] == 'Premium') ? 'selected' : '' ?>>Premium</option>
                        </select>
                    </div>

                 <div class="input-group">
				<label>Preview Gambar</label>

					<div class="preview-card">
						<img id="preview" src="">
						<span class="preview-text">Preview akan tampil di sini</span>
					</div>

		</div>

            <div class="btn-group">
                <button type="reset" class="btn-batal">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>

        </form>

    </div>

</div>

		<script>
			// fungsi untuk preview gambar sebelum diupload
		function previewGambar(event) {
			 // mengambil input file
			const input = event.target;
			// ambil elemen gambar preview
			const preview = document.getElementById('preview');
			// ambil elemen teks preview default
			const text = document.querySelector('.preview-text');

			// mengambil file pertama yang dipilih
			const file = input.files[0];
			if (file) {
				preview.src = URL.createObjectURL(file);
				preview.style.display = 'block';
				text.style.display = 'none';
			}
		}
		</script>

<?php $this->load->view('admin/components/footer'); ?>
