<?php $this->load->view('owner/components/header'); ?>
<?php $this->load->view('owner/components/navbar'); ?>
<?php $this->load->view('owner/components/sidebar'); ?>
<div class="layout">
	

	<div class="main">

		<style>
			.container {
				background: #f4f6fb;
				padding: 30px;
				border-radius: 20px;
				width: 95%;
				margin: auto;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				background: white;
				border-radius: 12px;
				overflow: hidden;
			}

			th {
				background: #e3e8f5;
				padding: 12px;
			}

			td {
				padding: 12px;
				text-align: center;
			}

			tr:nth-child(even) {
				background: #f9f9f9;
			}

			.badge {
				padding: 6px 14px;
				border-radius: 20px;
				color: white;
			}

			.menunggu {
				background: #95a5a6;
			}

			.proses {
				background: #f1c40f;
			}

			.selesai {
				background: #2ecc71;
			}
		</style>

		<h2>Status Pesanan</h2>

		<div class="container">

			<table>

				<th>No</th>
				<th>Nama Lengkap</th>
				<th>Paket Foto</th>
				<th>Lokasi</th>
				<th>Tanggal Acara</th>
				<th>Status</th>
				

				<?php $no = 1;
				foreach ($status as $s): ?>

					<tr>
						<td><?= $no++ ?></td>
						<td><?= $s->nama_lengkap ?></td>
						<td><?= $s->nama_paket ?></td>
						<td><?= $s->lokasi ?></td>
						<td><?= $s->tanggal_acara ?></td>

						<td>
							<span class="badge <?= $s->status ?>">
								<?= ucfirst($s->status) ?>
							</span>
						</td>
					</tr>

				<?php endforeach; ?>

			</table>

		</div>

	</div>
</div>

<?php $this->load->view('owner/components/footer'); ?>
