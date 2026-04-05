<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB $db
 * @property CI_Input $input
 * @property CI_URI $uri
 * @property CI_Pagination $pagination
 * @property CI_Upload $upload
 * @property Paket_model $Paket_model
 * @property User_model $User_model
 * @property Transaksi_model $Transaksi_model
 * @property Status_model $Status_model
 */
class Admin extends CI_Controller
{

    // 🔐 CONSTRUCTOR → dijalankan pertama kali
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_model');

        // 🔒 PROTEKSI ROLE (hanya admin)
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        // 📦 LOAD MODEL
        $this->load->model('User_model');
    }

    // 📊 DASHBOARD ADMIN
  public function dashboard()
{
    // total hari ini
    $this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
    $data['total_hari_ini'] = $this->db->count_all_results('transactions');

    // 🔥 jumlah paket (INI YANG DIGANTI)
    $data['jumlah_paket'] = $this->db->count_all('paket_foto');

    // belum selesai
    $this->db->where('status !=', 'selesai');
    $data['belum_selesai'] = $this->db->count_all_results('transactions');

    // data transaksi untuk map & calendar
    $this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
    $this->db->select('lokasi, nama_paket, tanggal_acara');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
    $data['transaksi'] = $this->db->get('transactions')->result();

    $this->load->view('admin/dashboard', $data);
}

    // 📋 MENAMPILKAN DATA USER
public function users()
{
    $this->load->library('pagination');

    // 🔍 ambil keyword dari input
    $keyword = $this->input->get('keyword');

    // 🔥 QUERY DASAR
    $this->db->from('users');

    if($keyword){
        $this->db->group_start();
        $this->db->like('username', $keyword);
        $this->db->or_like('nama_lengkap', $keyword);
        $this->db->or_like('role', $keyword);
        $this->db->group_end();
    }

    // 🔢 TOTAL DATA (HARUS sebelum limit)
    $config['total_rows'] = $this->db->count_all_results('', false);

    // ⚙️ CONFIG PAGINATION
    $config['base_url'] = base_url('admin/users');
    $config['per_page'] = 6;
    $config['uri_segment'] = 3;
    $config['reuse_query_string'] = true;

    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';
    $config['num_links'] = 5;

    $this->pagination->initialize($config);

    // 🔥 OFFSET
    $page = $this->uri->segment(3);
    $page = ($page !== null && is_numeric($page)) ? (int)$page : 0;

    // 🔥 AMBIL DATA SESUAI HALAMAN
    $data['users'] = $this->db->limit($config['per_page'], $page)->get()->result();

    // 🔗 LINK PAGINATION
    $data['pagination'] = $this->pagination->create_links();

    // kirim keyword ke view
    $data['keyword'] = $keyword;

    $this->load->view('admin/users', $data);
}

    // ➕ MENAMPILKAN FORM TAMBAH USER
    public function form_tambah()
    {
        $this->load->view('admin/form_tambah_user');
    }

    // ➕ PROSES TAMBAH USER
    public function tambah_user()
    {
        $data = [
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'role' => $this->input->post('role'),
            'nama_lengkap' => $this->input->post('nama'),
        ];

        $this->User_model->insert($data);

        // 📝 LOG AKTIVITAS
        $this->db->insert('activity_log', [
            'id_user' => $this->session->userdata('id_user'),
            'aktivitas' => 'Menambah user',
            'action' => 'insert'
        ]);

        redirect('admin/users');
    }

    // ✏️ MENAMPILKAN FORM EDIT USER
    public function form_edit($id)
    {
        $data['user'] = $this->User_model->getById($id);
        $this->load->view('admin/form_edit_user', $data);
    }

    // ✏️ PROSES EDIT USER
    public function edit_user($id)
    {
        $data = [
            'username' => $this->input->post('username'),
            'role' => $this->input->post('role'),
            'nama_lengkap' => $this->input->post('nama'),
        ];

        $this->User_model->update($id, $data);

      $this->db->insert('activity_log', [
    'id_user' => $this->session->userdata('id_user'),
    'role' => $this->session->userdata('role'),
    'aktivitas' => 'Update user',
    'action' => 'update'
]);

        redirect('admin/users');
    }

    // ❌ NONAKTIFKAN USER
    public function nonaktif_user($id)
    {
        $this->User_model->nonaktif($id);

        $this->db->insert('activity_log', [
            'id_user' => $this->session->userdata('id_user'),
			'role' => $this->session->userdata('role'),
            'aktivitas' => 'Nonaktifkan user',
            'action' => 'update'
        ]);

        redirect('admin/users');
    }

    // HALAMAN LIST PAKET
 public function paket()
{
    $data['paket'] = $this->Paket_model->getGrouped();
    $this->load->view('admin/paket', $data);
}

public function get_paket_by_nama($nama)
{
    $data = $this->Paket_model->getByNama(urldecode($nama));
    echo json_encode($data);
}
    // FORM TAMBAH PAKET
    public function form_tambah_paket()
    {
        $this->load->view('admin/form_tambah_paket');
    }

    // SIMPAN PAKET
    public function tambah_paket()
    {
        $config['upload_path'] = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $gambar = null;
        } else {
            $gambar = $this->upload->data('file_name');
        }

        $data = [
            'nama_paket' => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
            'durasi_jam' => $this->input->post('durasi'),
            'gambar' => $gambar,
            'jenis' => $this->input->post('jenis')
        ];

        $this->Paket_model->insert($data);
        redirect('admin/paket');
    }

    // EDIT PAKET
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

        $this->db->insert('activity_log', [
            'id_user' => $this->session->userdata('id_user'),
			'role' => $this->session->userdata('role'),
            'aktivitas' => 'Update paket foto',
            'action' => 'update'
        ]);

        redirect('admin/paket');
    }

    public function hapus_paket($id)
    {
        $this->Paket_model->delete($id);

        $this->db->insert('activity_log', [
            'id_user' => $this->session->userdata('id_user'),
			'role' => $this->session->userdata('role'),
            'aktivitas' => 'Hapus paket foto',
            'action' => 'delete'
        ]);

        redirect('admin/paket');
    }

public function status_pesanan()
{
    $this->load->library('pagination');

    // 🔍 ambil input
    $keyword = $this->input->get('keyword');
    $filter_status = $this->input->get('status');

    // 🔥 QUERY UTAMA
    $this->db->select('transactions.*, paket_foto.nama_paket');
    $this->db->from('transactions');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

    // 🔍 SEARCH
    if($keyword){
        $this->db->group_start();
        $this->db->like('transactions.nama_lengkap', $keyword);
        $this->db->or_like('paket_foto.nama_paket', $keyword);
        $this->db->group_end();
    }

    // 🔽 FILTER STATUS
    if($filter_status && $filter_status != 'all'){
        $this->db->where('transactions.status', $filter_status);
    }

	
    // 🔥 URUTKAN
    $this->db->order_by('tanggal_acara', 'ASC');

    // 🔢 TOTAL DATA
    $config['total_rows'] = $this->db->count_all_results('', false);

    // ⚙️ PAGINATION
    $config['base_url'] = base_url('admin/status_pesanan');
    $config['per_page'] = 6;
    $config['uri_segment'] = 3;
    $config['reuse_query_string'] = true;

    $this->pagination->initialize($config);

    // 🔥 OFFSET
    $page = $this->uri->segment(3);
    $page = ($page) ? (int)$page : 0;

    // 🔥 AMBIL DATA
    $data['status'] = $this->db->limit($config['per_page'], $page)->get()->result();

    // 🔗 PAGINATION
    $data['pagination'] = $this->pagination->create_links();

    // kirim ke view (PENTING!)
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

    redirect('admin/status_pesanan');
}

 public function riwayat()
{
    $this->load->library('pagination');

    $keyword = $this->input->get('keyword');

    $this->db->select('transactions.*, paket_foto.nama_paket');
    $this->db->from('transactions');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

    if($keyword){
        $this->db->group_start();
        $this->db->like('transactions.nama_lengkap', $keyword);
        $this->db->or_like('paket_foto.nama_paket', $keyword);
        $this->db->group_end();
    }

    $this->db->order_by('id_transaction', 'DESC');

    $config['total_rows'] = $this->db->count_all_results('', false);
    $config['base_url'] = base_url('admin/riwayat');
    $config['per_page'] = 6;
    $config['reuse_query_string'] = true;

    $this->pagination->initialize($config);

    $page = $this->uri->segment(3) ?? 0;

    $data['riwayat'] = $this->db->limit($config['per_page'], $page)->get()->result();
    $data['pagination'] = $this->pagination->create_links();
    $data['keyword'] = $keyword;

    $this->load->view('admin/riwayat', $data);
}
	
}
