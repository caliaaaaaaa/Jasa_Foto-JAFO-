<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends CI_Controller
{
public function dashboard()
{
    // 💰 pendapatan bulan ini
    $this->db->select_sum('total_harga');
    $this->db->where('status', 'selesai');
    $this->db->where('MONTH(tanggal_transaksi)', date('m'));
    $data['pendapatan_bulan'] = $this->db->get('transactions')->row()->total_harga;

    // 📊 pesanan hari ini
    $this->db->where('DATE(tanggal_transaksi)', date('Y-m-d'));
    $data['pesanan_hari_ini'] = $this->db->count_all_results('transactions');

    // 📸 jumlah paket
    $data['jumlah_paket'] = $this->db->count_all('paket_foto');

    // ⏳ belum selesai
    $this->db->where('status !=', 'selesai');
    $data['belum_selesai'] = $this->db->count_all_results('transactions');

    // 📈 grafik (12 bulan)
    $query = $this->db->query("
        SELECT MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total
        FROM transactions
        WHERE status='selesai'
        GROUP BY MONTH(tanggal_transaksi)
    ");
    $data['grafik'] = $query->result();

    // 📅 kalender
    $data['transaksi'] = $this->db->get('transactions')->result();

// 🔥 TRANSAKSI TERBARU
$this->db->select('transactions.*, paket_foto.nama_paket');
$this->db->from('transactions');
$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
$this->db->order_by('id_transaction', 'DESC');
$this->db->limit(5);

$data['latest'] = $this->db->get()->result();

    $this->load->view('owner/dashboard', $data);
}

public function paket()
{
    // 🔍 ambil keyword
    $keyword = $this->input->get('keyword');

    // 🔥 QUERY UTAMA (ambil 1 paket per nama)
    $this->db->select('
        MIN(id_paket) as id_paket,
        nama_paket,
        MIN(gambar) as gambar,
        MIN(harga) as harga
    ');
    $this->db->from('paket_foto');

    // 🔍 SEARCH
    if($keyword){
        $this->db->like('nama_paket', $keyword);
    }

    // 🔥 GROUP BIAR GA DOUBLE
    $this->db->group_by('nama_paket');

    // 🔽 URUTKAN BIAR RAPI
    $this->db->order_by('nama_paket', 'ASC');

    $data['paket'] = $this->db->get()->result();

    // kirim keyword ke view (biar tetap muncul di input)
    $data['keyword'] = $keyword;

    $this->load->view('owner/paket', $data);
}


public function status_pesanan()
{
    $this->load->library('pagination');

    // 🔍 ambil input
    $keyword = $this->input->get('keyword');
    $filter_status = $this->input->get('status');

    // 🔥 QUERY
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

    // 🔽 URUTKAN
    $this->db->order_by('tanggal_acara', 'ASC');

    // 🔢 TOTAL
    $config['total_rows'] = $this->db->count_all_results('', false);

    // ⚙️ PAGINATION
    $config['base_url'] = base_url('owner/status_pesanan');
    $config['per_page'] = 6;
    $config['reuse_query_string'] = true;

    $this->pagination->initialize($config);

    // 🔢 OFFSET
    $page = $this->uri->segment(3);
    $page = ($page) ? (int)$page : 0;

    // 🔥 DATA
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

    $this->db->select('transactions.*, paket_foto.nama_paket');
    $this->db->from('transactions');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

    // 🔥 hanya selesai
    $this->db->where('transactions.status', 'selesai');

    if($keyword){
        $this->db->group_start();
        $this->db->like('transactions.nama_lengkap', $keyword);
        $this->db->or_like('paket_foto.nama_paket', $keyword);
        $this->db->group_end();
    }

    $this->db->order_by('id_transaction', 'DESC');

    $config['total_rows'] = $this->db->count_all_results('', false);
    $config['base_url'] = base_url('owner/riwayat');
    $config['per_page'] = 6;
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
    $this->db->select('activity_log.*, users.nama_lengkap');
    $this->db->from('activity_log');
    $this->db->join('users', 'users.id_user = activity_log.id_user', 'left');
    $this->db->order_by('id_log', 'DESC');

    $data['log'] = $this->db->get()->result();

    $this->load->view('owner/activity_log', $data);
}
}
