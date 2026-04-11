<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>
<?php $active = 'riwayat'; ?>
<?php $this->load->view('owner/components/sidebar', compact('active')); ?>

<style>
	/* PAGINATION */
	.pagination {
		margin-top: 25px;
		text-align: center;
	}

	.pagination a,
	.pagination strong {
		padding: 8px 14px;
		margin: 3px;
		border-radius: 8px;
		text-decoration: none;
		border: 1px solid #ddd;
		color: #333;
		font-size: 13px;
		transition: 0.3s;
	}

	.pagination a:hover {
		background: #f1f5ff;
	}

	.pagination strong {
		background: #3B6FB6;
		color: white;
		border: none;
	}

	.container-riwayat {
		background: #ffffff;
		padding: 30px;
		border-radius: 20px;
		width: 95%;
		margin: 20px auto;
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
	}

	/* FORM FILTER RESPONSIF */
	.filter-wrapper {
		display: flex;
		gap: 10px;
		margin-bottom: 20px;
		align-items: center;
		flex-wrap: wrap;
		/* Supaya turun ke bawah jika layar sempit */
		padding: 0 2.5%;
	}

	.filter-wrapper input[type="date"] {
		padding: 8px 12px;
		border-radius: 8px;
		border: 1px solid #ddd;
		font-family: inherit;
		outline: none;
	}

	.btn-filter {
		padding: 8px 20px;
		border: none;
		background: #3B6FB6;
		color: white;
		border-radius: 8px;
		cursor: pointer;
		transition: 0.3s;
	}

	.btn-download {
		padding: 8px 20px;
		background: #2ecc71;
		color: white;
		border-radius: 8px;
		text-decoration: none;
		transition: 0.3s;
		display: inline-block;
	}

	.btn-filter:hover,
	.btn-download:hover {
		opacity: 0.8;
		color: white;
	}

	/* TABLE RESPONSIF */
	.table-responsive {
		width: 100%;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
		border-radius: 15px;
	}

	.table-riwayat {
		width: 100%;
		border-collapse: collapse;
		background: white;
		font-size: 14px;
		min-width: 1100px;
		/* Menjaga agar data tidak berantakan di layar kecil */
	}

	.table-riwayat th {
		background: #dfe3f2;
		padding: 12px 10px;
		text-align: center;
		white-space: nowrap;
	}

	.table-riwayat td {
		padding: 12px 10px;
		text-align: center;
		vertical-align: middle;
		border-bottom: 1px solid #f0f0f0;
	}

	.table-riwayat tr:nth-child(even) {
		background: #f9fbfd;
	}

	.table-riwayat tr:hover {
		background: #eef2ff;
		transition: 0.2s;
	}

	/* BUTTON ACTION */
	.btn-struk {
		padding: 6px 12px;
		background: #3B6FB6;
		color: white;
		border-radius: 8px;
		text-decoration: none;
		font-size: 12px;
		display: inline-block;
		white-space: nowrap;
	}

	/* MEDIA QUERIES */
	@media (max-width: 600px) {
		.filter-wrapper {
			flex-direction: column;
			align-items: stretch;
		}

		.filter-wrapper input,
		.btn-filter,
		.btn-download {
			width: 100%;
			text-align: center;
		}

		.container-riwayat {
			padding: 15px;
			width: 98%;
		}
	}
</style>

<br>

<!-- FORM FILTER -->
<form method="get" action="">
	<div class="filter-wrapper">
		<input type="date" name="tgl_awal" value="<?= $_GET['tgl_awal'] ?? '' ?>">

		<span style="align-self: center;">s/d</span>

		<input type="date" name="tgl_akhir" value="<?= $_GET['tgl_akhir'] ?? '' ?>">

		<button type="submit" class="btn-filter">
			<i class="fa fa-filter"></i> Filter
		</button>

		<a href="<?= base_url('owner/download_pdf?tgl_awal=' . ($_GET['tgl_awal'] ?? '') . '&tgl_akhir=' . ($_GET['tgl_akhir'] ?? '')) ?>"
			class="btn-download">
			<i class="fa fa-file-pdf"></i> Download Laporan
		</a>
	</div>
</form>

<div class="container-riwayat">
	<div class="table-responsive">
		<table class="table-riwayat">
			<thead>
				<tr>
					<th>No</th>
					<th>No Pesanan</th>
					<th>Nama</th>
					<th>Paket</th>
					<th>Tgl Transaksi</th>
					<th>Tgl Acara</th>
					<th>Jam</th>
					<th>Lokasi</th>
					<th>Total</th>
					<th>Bayar</th>
					<th>Kembali</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($riwayat)): ?>
					<?php $no = 1;
					foreach ($riwayat as $r): ?>
						<tr>
							<td><?= $no++ ?></td>
							<td style="font-weight:bold; color:#3B6FB6;"><?= $r->nomor_pesanan ?></td>
							<td><?= $r->nama_lengkap ?></td>
							<td><?= $r->nama_paket ?></td>
							<td><?= date('d/m/Y', strtotime($r->tanggal_transaksi)) ?></td>
							<td><?= date('d/m/Y', strtotime($r->tanggal_acara)) ?></td>
							<td><?= date('H:i', strtotime($r->jam_acara)) ?></td>
							<td><?= $r->lokasi ?></td>
							<td><strong>Rp <?= number_format($r->total_harga, 0, ',', '.') ?></strong></td>
							<td>Rp <?= number_format($r->uang_bayar, 0, ',', '.') ?></td>
							<td style="color:green;">Rp <?= number_format($r->uang_kembali, 0, ',', '.') ?></td>
							<td>
								<a href="<?= base_url('owner/cetak_struk/' . $r->id_transaction) ?>"
									target="_blank"
									class="btn-struk">
									<i class="fa fa-eye"></i> Struk
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="12" style="padding:40px; text-align:center; color:#888;">
							<div style="font-size: 20px;">⚠️</div>
							Tidak ada data transaksi, silakan sesuaikan filter tanggal
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>


	<!-- PAGINATION -->
	<div class="pagination">
		<?= $pagination ?>
	</div>
</div>

<?php $this->load->view('owner/components/footer'); ?>
