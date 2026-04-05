<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Paket_model');
		$this->load->model('Transaksi_model');

		// proteksi role kasir
		if ($this->session->userdata('role') != 'kasir') {
			redirect('auth');
		}
	}

	// halaman transaksi
	// public function transaksi($id)
	// {
	//     // ambil 1 paket (HARUS row bukan result)
	//     $data['paket'] = $this->db
	//         ->get_where('paket_foto', ['id_paket' => $id])
	//         ->row(); // 🔥 PENTING

	//     // buat nomor pesanan otomatis
	//     $data['no_pesanan'] = 'ORD-' . date('Ymd') . '-' . rand(1000,9999);

	//     $this->load->view('kasir/transaksi', $data);
	// }

	// simpan transaksi
	public function simpan_transaksi()
{
    $data = [
        'nomor_pesanan' => $this->input->post('nomor_pesanan'),
        'nama_lengkap' => $this->input->post('nama'),
        'no_hp' => $this->input->post('no_hp'),
        'id_paket' => $this->input->post('id_paket'),
        'id_user' => $this->session->userdata('id_user'),
        'tanggal_transaksi' => date('Y-m-d'),
        'tanggal_acara' => $this->input->post('tanggal'),
        'jam_acara' => $this->input->post('jam'),
        'lokasi' => $this->input->post('lokasi'),
        'total_harga' => $this->input->post('total'),
        'uang_bayar' => $this->input->post('bayar'),
        'uang_kembali' => $this->input->post('kembali'),
        'status' => 'menunggu'
    ];

    $this->db->insert('transactions', $data);

    // 🔥 TAMBAHKAN INI
    $this->db->insert('activity_log', [
        'id_user' => $this->session->userdata('id_user'),
        'role' => $this->session->userdata('role'),
        'aktivitas' => 'Menambah transaksi',
        'action' => 'insert'
    ]);

    redirect('kasir/status_pesanan');
}
	public function dashboard()
	{
		// total transaksi
		$data['total'] = $this->db->count_all('transactions');

		// jumlah paket
		$data['paket'] = $this->db->count_all('paket_foto');

		// belum selesai
		$this->db->where('status !=', 'selesai');
		$data['belum_selesai'] = $this->db->count_all_results('transactions');


		// data transaksi untuk map & calendar
		$this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
		$this->db->select('lokasi, nama_paket, tanggal_acara');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
		$data['transaksi'] = $this->db->get('transactions')->result();

		$this->load->view('kasir/dashboard', $data);
	}

	public function paket()
	{
		$data['paket'] = $this->Paket_model->getGrouped();
		$this->load->view('kasir/paket', $data);
	}

	public function get_paket_by_nama($nama)
	{
		$data = $this->Paket_model->getByNama(urldecode($nama));
		echo json_encode($data);
	}


public function transaksi($id = null)
{
    if(!$id){
        // ambil paket pertama sebagai default
        $data['paket'] = $this->db->get('paket_foto')->row();
    } else {
        $data['paket'] = $this->db
            ->get_where('paket_foto', ['id_paket' => $id])
            ->row();
    }

    $data['no_pesanan'] = 'ORD-' . date('Ymd') . '-' . rand(1000,9999);

    $this->load->view('kasir/transaksi', $data);
}


	public function status_pesanan()
	{
		$this->db->select('transactions.*, paket_foto.nama_paket');
		$this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

		// 🔥 tampil semua yg belum selesai
		$this->db->where('status !=', 'selesai');

		$data['status'] = $this->db->get()->result();

		$this->load->view('kasir/status_pesanan', $data);
	}

	public function riwayat()
	{
		$this->load->library('pagination');

		$keyword = $this->input->get('keyword');
		$id_user = $this->session->userdata('id_user');

		$this->db->select('transactions.*, paket_foto.nama_paket');
		$this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

		// 🔥 hanya transaksi kasir ini
		$this->db->where('transactions.id_user', $id_user);

		if ($keyword) {
			$this->db->group_start();
			$this->db->like('transactions.nama_lengkap', $keyword);
			$this->db->or_like('paket_foto.nama_paket', $keyword);
			$this->db->group_end();
		}

		$this->db->order_by('id_transaction', 'DESC');

		$config['total_rows'] = $this->db->count_all_results('', false);
		$config['base_url'] = base_url('kasir/riwayat');
		$config['per_page'] = 6;
		$config['reuse_query_string'] = true;

		$this->pagination->initialize($config);

		$page = $this->uri->segment(3) ?? 0;

		$data['riwayat'] = $this->db->limit($config['per_page'], $page)->get()->result();
		$data['pagination'] = $this->pagination->create_links();
		$data['keyword'] = $keyword;

		$this->load->view('kasir/riwayat', $data);
	}
}
