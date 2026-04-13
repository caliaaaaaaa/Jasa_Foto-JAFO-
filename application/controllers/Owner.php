<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        // Proteksi halaman
        if (!$this->session->userdata('id_user')) {
            redirect('login');
        }

        // Proteksi role
        if ($this->session->userdata('role') != 'owner') {
            redirect('login');
        }
    }


    
    public function dashboard()
    {
        // Menghitung total pendapatan dari transaksi yang sudah selesai pada bulan berjalan
		$this->db->select_sum('total_harga');
		$this->db->where('MONTH(tanggal_transaksi)', date('m'));
		$this->db->where('YEAR(tanggal_transaksi)', date('Y'));
		$data['pendapatan_bulan'] = $this->db->get('transactions')->row()->total_harga;

        // Menghitung jumlah pesanan yang masuk pada hari ini
        $this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
        $data['pesanan_hari_ini'] = $this->db->count_all_results('transactions');

        // Menghitung total variasi paket foto yang tersedia
        $data['jumlah_paket'] = $this->db->count_all('paket_foto');

        // Menghitung pesanan yang masih dalam proses (belum selesai)
        $this->db->where('status !=', 'selesai');
        $data['belum_selesai'] = $this->db->count_all_results('transactions');

        // Mengambil data untuk grafik pendapatan bulanan
        $query = $this->db->query("
            SELECT MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total
            FROM transactions
            WHERE status='selesai'
            GROUP BY MONTH(tanggal_transaksi)
        ");
        $data['grafik'] = $query->result();

        // Mengambil data jadwal acara hari ini untuk kebutuhan peta atau kalender
        $this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
        $this->db->select('lokasi, nama_paket, tanggal_acara');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
        $data['transaksi'] = $this->db->get('transactions')->result();

        // Mengambil 5 transaksi terbaru untuk ditampilkan di tabel dashboard
        $this->db->select('transactions.*, paket_foto.nama_paket');
        $this->db->from('transactions');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
        $this->db->order_by('id_transaction', 'DESC');
        $this->db->limit(5);
        $data['latest'] = $this->db->get()->result();

        $this->load->view('owner/dashboard', $data);
    }


    
    public function get_paket_by_nama($nama)
    {
        $this->load->model('Paket_model');
        $data = $this->Paket_model->getByNama(urldecode($nama));
        echo json_encode($data);
    }



    public function paket()
    {
        $keyword = $this->input->get('keyword');

        // Mengambil ringkasan paket foto 
        $this->db->select('
            MIN(id_paket) as id_paket,
            nama_paket,
            MIN(gambar) as gambar,
            MIN(harga) as harga
        ');
        $this->db->from('paket_foto');

        // Filter 
        if ($keyword) {
            $this->db->like('nama_paket', $keyword);
        }

        $this->db->group_by('nama_paket');
        $this->db->order_by('nama_paket', 'ASC');

        $data['paket'] = $this->db->get()->result();
        $data['keyword'] = $keyword;

        $this->load->view('owner/paket', $data);
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
			$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket', 'left');

        // Fitur pencarian data pesanan
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('transactions.nama_lengkap', $keyword);
            $this->db->or_like('transactions.nomor_pesanan', $keyword);
            $this->db->or_like('paket_foto.nama_paket', $keyword);
            $this->db->group_end();
        }

        // Filter berdasarkan status transaksi
        if ($filter_status && $filter_status != 'all') {
            $this->db->where('transactions.status', $filter_status);
        }

        $this->db->order_by('tanggal_transaksi', 'DESC');
        $this->db->order_by('id_transaction', 'DESC');

        // Inisialisasi sistem paginasi
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['base_url'] = base_url('owner/status_pesanan');
        $config['per_page'] = 10;
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ?? 0;

        $data['status'] = $this->db->limit($config['per_page'], $page)->get()->result();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['filter_status'] = $filter_status;

        $this->load->view('owner/status_pesanan', $data);
    }


   
    public function riwayat()
    {
        $this->load->library('pagination');

        $keyword = $this->input->get('keyword');
        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');

        $this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
        $this->db->from('transactions');
		$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket', 'left');
        $this->db->where('transactions.status', 'selesai');

        // Penerapan filter rentang tanggal
        if ($tgl_awal && $tgl_akhir) {
            $this->db->where('DATE(transactions.tanggal_transaksi) >=', $tgl_awal);
            $this->db->where('DATE(transactions.tanggal_transaksi) <=', $tgl_akhir);
        }

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('transactions.nama_lengkap', $keyword);
            $this->db->or_like('transactions.nomor_pesanan', $keyword);
            $this->db->or_like('paket_foto.nama_paket', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('tanggal_transaksi', 'DESC');
        $this->db->order_by('id_transaction', 'DESC');

        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['base_url'] = base_url('owner/riwayat');
        $config['per_page'] = 10;
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ?? 0;

        $data['riwayat'] = $this->db->limit($config['per_page'], $page)->get()->result();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;

        $this->load->view('owner/riwayat', $data);
    }


   
    public function activity_log()
    {
        $this->load->library('pagination');

        // Menentukan role mana yang akan dilihat log-nya 
        $role = $this->input->get('role') ?? 'admin';

        $this->db->select('activity_log.*, users.nama_lengkap');
        $this->db->from('activity_log');
        $this->db->join('users', 'users.id_user = activity_log.id_user', 'left');
        $this->db->where('activity_log.role', $role);
        $this->db->order_by('id_log', 'DESC');

        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['base_url'] = base_url('owner/activity_log');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $page = $this->input->get('per_page') ?? 0;

        $data['log'] = $this->db->limit($config['per_page'], $page)->get()->result();
        $data['pagination'] = $this->pagination->create_links();
        $data['role'] = $role;

        $this->load->view('owner/activity_log', $data);
    }



    public function download_pdf()
    {
        $this->load->library('dompdf_gen');

        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');

        $this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
        $this->db->from('transactions');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
        $this->db->where('transactions.status', 'selesai');

        if ($tgl_awal && $tgl_akhir) {
            $this->db->where('DATE(tanggal_transaksi) >=', $tgl_awal);
            $this->db->where('DATE(tanggal_transaksi) <=', $tgl_akhir);
        }

        $this->db->order_by('id_transaction', 'DESC');
        $data['riwayat'] = $this->db->get()->result();

        // Merender view laporan ke dalam format HTML untuk dikonversi ke PDF
        $html = $this->load->view('owner/laporan_pdf', $data, true);

        $this->dompdf_gen->dompdf->loadHtml($html);
        $this->dompdf_gen->dompdf->setPaper('A4', 'landscape');
        $this->dompdf_gen->dompdf->render();
        $this->dompdf_gen->dompdf->stream("laporan.pdf", array("Attachment" => 1));
    }


   
    public function cetak_struk($id)
    {
        $this->load->library('Dompdf_gen');

        $this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
        $this->db->from('transactions');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
        $this->db->where('id_transaction', $id);

        $data['transaksi'] = $this->db->get()->row();

        // Menggunakan view yang sama dengan bagian kasir untuk konsistensi
        $this->load->view('kasir/struk', $data);

        $html = $this->output->get_output();

        $this->dompdf_gen->dompdf->load_html($html);
        $this->dompdf_gen->dompdf->set_paper([0, 0, 400, 700], 'portrait');
        $this->dompdf_gen->dompdf->render();

        $this->dompdf_gen->dompdf->stream("struk.pdf", array("Attachment" => false));
    }
}
