<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Paket_model');

		if (!$this->session->userdata('id_user')) {
			redirect('login');
		}

		if ($this->session->userdata('role') != 'admin') {
			redirect('login');
		}

		$this->load->model('User_model');
	}

	// 🔥 FUNCTION LOG
	private function log($aktivitas, $action)
	{
		$this->db->insert('activity_log', [
			'id_user'   => $this->session->userdata('id_user'),
			'role'      => $this->session->userdata('role'),
			'aktivitas' => $aktivitas,
			'action'    => $action,
			'created_at' => date('Y-m-d H:i:s')
		]);
	}

	public function dashboard()
	{


		$this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
		$data['total_hari_ini'] = $this->db->count_all_results('transactions');

		$data['jumlah_paket'] = $this->db->count_all('paket_foto');

		$this->db->where('status !=', 'selesai');
		$data['belum_selesai'] = $this->db->count_all_results('transactions');

		$this->db->where('DATE(tanggal_acara)', date('Y-m-d'));
		$this->db->select('lokasi, nama_paket, tanggal_acara');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
		$data['transaksi'] = $this->db->get('transactions')->result();

		$this->load->view('admin/dashboard', $data);
	}

	public function users()
	{


		$this->load->library('pagination');
		$keyword = $this->input->get('keyword');

		$this->db->from('users');

		if ($keyword) {
			$this->db->group_start();
			$this->db->like('username', $keyword);
			$this->db->or_like('nama_lengkap', $keyword);
			$this->db->or_like('role', $keyword);
			$this->db->group_end();
		}

		$config['total_rows'] = $this->db->count_all_results('', false);
		$config['base_url'] = base_url('admin/users');
		$config['per_page'] = 10;
		$config['reuse_query_string'] = true;

		$this->pagination->initialize($config);

		$page = $this->uri->segment(3) ?? 0;

		$data['users'] = $this->db->limit($config['per_page'], $page)->get()->result();
		$data['pagination'] = $this->pagination->create_links();
		$data['keyword'] = $keyword;

		$this->load->view('admin/users', $data);
	}

	public function form_tambah()
	{

		$this->load->view('admin/form_tambah_user');
	}

	public function tambah_user()
	{
		$username = $this->input->post('username');
		$nama     = $this->input->post('nama');
		$role     = $this->input->post('role');
		$password = $this->input->post('password');

		// 🔥 simpan data lama
		$this->session->set_flashdata('old', $_POST);

		// 🔥 VALIDASI
		if (!$username || !$nama || !$role || !$password) {
			$this->session->set_flashdata('error', 'Semua field wajib diisi!');
			redirect('admin/form_tambah');
		}

		// 🔥 SIMPAN
		$data = [
			'username'      => $username,
			'password'      => md5($password),
			'role'          => $role,
			'nama_lengkap'  => $nama,
		];

		$this->User_model->insert($data);

		$this->log('Menambah user', 'insert');

		// 🔥 hapus old biar form bersih
		$this->session->unset_userdata('old');

		redirect('admin/users');
	}

	public function form_edit($id)
	{


		$data['user'] = $this->User_model->getById($id);
		$this->load->view('admin/form_edit_user', $data);
	}

	public function edit_user($id)
	{
		$data = [
			'username' => $this->input->post('username'),
			'role' => $this->input->post('role'),
			'nama_lengkap' => $this->input->post('nama'),
		];

		$this->User_model->update($id, $data);

		$this->log('Update user ID ' . $id, 'update');

		redirect('admin/users');
	}

	public function nonaktif_user($id)
	{
		$this->User_model->nonaktif($id);

		$this->log('Nonaktifkan user ID ' . $id, 'update');

		redirect('admin/users');
	}


	public function aktif_user($id)
	{
		$this->User_model->aktif($id);

		$this->log('Aktifkan user ID ' . $id, 'update');

		redirect('admin/users');
	}

	public function paket()
	{


		$keyword = $this->input->get('keyword');

		$this->db->select('
            MIN(id_paket) as id_paket,
            nama_paket,
            MIN(gambar) as gambar,
            MIN(harga) as harga
        ');
		$this->db->from('paket_foto');

		if ($keyword) {
			$this->db->like('nama_paket', $keyword);
		}

		$this->db->group_by('nama_paket');
		$this->db->order_by('nama_paket', 'ASC');

		$data['paket'] = $this->db->get()->result();
		$data['keyword'] = $keyword;

		$this->load->view('admin/paket', $data);
	}

	public function get_paket_by_nama($nama)
	{


		$data = $this->Paket_model->getByNama(urldecode($nama));
		echo json_encode($data);
	}

	public function form_tambah_paket()
	{

		$this->load->view('admin/form_tambah_paket');
	}

	public function tambah_paket()
	{
		// ambil data
		$nama      = $this->input->post('nama');
		$deskripsi = $this->input->post('deskripsi');
		$harga     = $this->input->post('harga');
		$durasi    = $this->input->post('durasi');
		$jenis     = $this->input->post('jenis');

		// 🔥 simpan data lama biar ga hilang
		$this->session->set_flashdata('old', $_POST);

		// 🔥 VALIDASI
		if (!$nama || !$deskripsi || !$harga || !$durasi || !$jenis) {
			$this->session->set_flashdata('error', 'Semua field wajib diisi!');
			redirect('admin/form_tambah_paket');
		}

		// 🔥 VALIDASI GAMBAR
		if (empty($_FILES['gambar']['name'])) {
			$this->session->set_flashdata('error', 'Gambar wajib diupload!');
			redirect('admin/form_tambah_paket');
		}

		// 🔥 UPLOAD
		$config['upload_path']   = './assets/images/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('gambar')) {
			$this->session->set_flashdata('error', 'Upload gagal!');
			redirect('admin/form_tambah_paket');
		}

		$gambar = $this->upload->data('file_name');

		// 🔥 SIMPAN DATA
		$data = [
			'nama_paket'  => $nama,
			'deskripsi'   => $deskripsi,
			'harga'       => $harga,
			'durasi_jam'  => $durasi,
			'gambar'      => $gambar,
			'jenis'       => $jenis
		];

		$this->Paket_model->insert($data);

		$this->log('Menambah paket foto', 'insert');

		// 🔥 HAPUS old biar form bersih
		$this->session->unset_userdata('old');

		redirect('admin/paket');
	}
	public function form_edit_paket($id)
	{


		$data['paket'] = $this->Paket_model->getById($id);
		$this->load->view('admin/form_edit_paket', $data);
	}

	public function edit_paket($id)
	{
		$data = [
			'nama_paket' => $this->input->post('nama'),
			'deskripsi' => $this->input->post('deskripsi'),
			'harga' => $this->input->post('harga'),
			'durasi_jam' => $this->input->post('durasi'),
			'jenis' => $this->input->post('jenis')
		];

		$this->Paket_model->update($id, $data);

		$this->log('Update paket ID ' . $id, 'update');

		redirect('admin/paket');
	}

	public function hapus_paket($id)
	{
		$this->Paket_model->delete($id);

		$this->log('Hapus paket ID ' . $id, 'delete');

		redirect('admin/paket');
	}

	public function status_pesanan()
	{


		$this->load->library('pagination');

		$keyword = $this->input->get('keyword');
		$filter_status = $this->input->get('status');

$this->db->select('
    transactions.id_transaction,
    transactions.nomor_pesanan,
    transactions.nama_lengkap,
    transactions.no_hp,
    transactions.lokasi,
    transactions.tanggal_acara,
    transactions.jam_acara,
    transactions.status,
    CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket
');
		$this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

	if ($keyword) {
    $this->db->group_start();
    $this->db->like('transactions.nama_lengkap', $keyword);
    $this->db->or_like('transactions.nomor_pesanan', $keyword); // ✅ TAMBAHAN
    $this->db->or_like('paket_foto.nama_paket', $keyword);
    $this->db->group_end();
}

		if ($filter_status && $filter_status != 'all') {
			$this->db->where('transactions.status', $filter_status);
		}

		$this->db->order_by('tanggal_transaksi', 'DESC');
$this->db->order_by('id_transaction', 'DESC');

		$config['total_rows'] = $this->db->count_all_results('', false);
		$config['base_url'] = base_url('admin/status_pesanan');
		$config['per_page'] = 10;
		$config['reuse_query_string'] = true;

		$this->pagination->initialize($config);

		$page = $this->uri->segment(3) ?? 0;

		$data['status'] = $this->db->limit($config['per_page'], $page)->get()->result();
		$data['pagination'] = $this->pagination->create_links();
		$data['keyword'] = $keyword;
		$data['filter_status'] = $filter_status;

		$this->load->view('admin/status_pesanan', $data);
	}

	public function update_status($id)
	{
		$status = $this->input->post('status');

		$this->db->where('id_transaction', $id);
		$this->db->update('transactions', [
			'status' => $status
		]);

		$this->log('Update status transaksi ID ' . $id . ' menjadi ' . $status, 'update');

		redirect('admin/status_pesanan');
	}

	public function riwayat()
	{


		$this->load->library('pagination');

		$keyword = $this->input->get('keyword');

	$this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
		$this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
		$this->db->where('transactions.status', 'selesai');

		if ($keyword) {
    $this->db->group_start();
    $this->db->like('transactions.nama_lengkap', $keyword);
    $this->db->or_like('transactions.nomor_pesanan', $keyword); // ✅ TAMBAHAN
    $this->db->or_like('paket_foto.nama_paket', $keyword);
    $this->db->group_end();
}

	$this->db->order_by('tanggal_transaksi', 'DESC');
$this->db->order_by('id_transaction', 'DESC');

	$config['total_rows'] = $this->db->count_all_results('', false);
$config['base_url'] = base_url('admin/riwayat');
$config['per_page'] = 10;
$config['reuse_query_string'] = true;
$config['uri_segment'] = 3; // 🔥 WAJIB

		$this->pagination->initialize($config);

		$page = $this->uri->segment(3) ?? 0;

		$data['riwayat'] = $this->db->limit($config['per_page'], $page)->get()->result();
		$data['pagination'] = $this->pagination->create_links();
		$data['keyword'] = $keyword;

		$this->load->view('admin/riwayat', $data);
	}


	public function cetak_struk($id)
	{
		$this->load->library('Dompdf_gen');

		$this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
		$this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
		$this->db->where('id_transaction', $id);

		$data['transaksi'] = $this->db->get()->row();

		// 🔥 pakai view kasir
		$this->load->view('kasir/struk', $data);

		$html = $this->output->get_output();

		$this->dompdf_gen->dompdf->loadhtml($html);
		$this->dompdf_gen->dompdf->setpaper([0, 0, 400, 700], 'portrait');
		$this->dompdf_gen->dompdf->render();

		$this->dompdf_gen->dompdf->stream("struk.pdf", array("Attachment" => false));
	}
}
