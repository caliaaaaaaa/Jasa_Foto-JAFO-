<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

    
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Paket_model');
        $this->load->model('Transaksi_model');

        // Proteksi halaman
        if (!$this->session->userdata('id_user')) {
            redirect('login');
        }

        // Proteksi role
        if ($this->session->userdata('role') != 'kasir') {
            redirect('login');
        }
    }



	
public function dashboard()
{
    $data['total'] = $this->db->count_all('transactions');
    $data['paket'] = $this->db->count_all('paket_foto');

    $this->db->where('status !=', 'selesai');
    $data['belum_selesai'] = $this->db->count_all_results('transactions');

    // DATA MAP (HARI INI)
    $this->db->where('DATE(tanggal_acara)', date('Y-m-d'));
    $this->db->select('lokasi, nama_paket, tanggal_acara');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
    $data['transaksi_hari_ini'] = $this->db->get('transactions')->result();

    // DATA CALENDAR (SEMUA)
    $this->db->select('tanggal_acara, nama_paket');
    $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
    $data['semua_transaksi'] = $this->db->get('transactions')->result();

    $this->load->view('kasir/dashboard', $data);
}


   
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

        $this->load->view('kasir/paket', $data);
    }


	public function transaksi($id = null)
		{
			if (!$id) {
				$data['paket'] = $this->db->get('paket_foto')->row();
			} else {
				$data['paket'] = $this->db
					->get_where('paket_foto', ['id_paket' => $id])
					->row();
			}

			$data['no_pesanan'] = '(Auto Generate)';

			$this->load->view('kasir/transaksi', $data);
		}


    public function simpan_transaksi()
    {
        $tanggal = $this->input->post('tanggal');
        
        // Validasi tgl acara tdk pada masa lampau
        if ($tanggal < date('Y-m-d')) {
            $this->session->set_flashdata('error', 'Tanggal acara tidak boleh di masa lalu!');
            $this->session->set_flashdata('old', $_POST);

            $this->log('Gagal transaksi (tanggal masa lalu)', 'insert');

            redirect($_SERVER['HTTP_REFERER']);
        }

        $jam      = $this->input->post('jam');
        $id_paket = $this->input->post('id_paket');

        //  pengecekan bentrok jadwal berdasarkan durasi paket
        $paket = $this->db->get_where('paket_foto', ['id_paket' => $id_paket])->row();
        $durasi = $paket->durasi_jam;

        $start_baru = strtotime($jam);
        $end_baru   = strtotime("+$durasi hour", $start_baru);

        $this->db->where('tanggal_acara', $tanggal);
        $transaksi = $this->db->get('transactions')->result();

        $bentrok = false;

        foreach ($transaksi as $t) {
            $start_lama = strtotime($t->jam_acara);
            $paket_lama = $this->db->get_where('paket_foto', [
                'id_paket' => $t->id_paket
            ])->row();

            $end_lama = strtotime("+{$paket_lama->durasi_jam} hour", $start_lama);

            // Cek irisan waktu antara jadwal baru dengan jadwal yang sudah ada
            if ($start_baru < $end_lama && $end_baru > $start_lama) {
                $bentrok = true;
                break;
            }
        }

        // Penanganan jika ditemukan jadwal yang bentrok
        if ($bentrok) {
            $this->session->set_flashdata('error', 'Jam bentrok dengan booking lain!');
            $this->session->set_flashdata('old', $_POST);

            $this->log('Gagal transaksi (jam bentrok)', 'insert');

            redirect($_SERVER['HTTP_REFERER']);
        }

        // Validasi form
        if (
            !$this->input->post('nama') ||
            !$this->input->post('no_hp') ||
            !$this->input->post('lokasi') ||
            !$this->input->post('tanggal') ||
            !$this->input->post('jam') ||
            !$this->input->post('bayar')
        ) {
            // Validasi format nomor HP harus berupa angka
            $no_hp = $this->input->post('no_hp');
            if (!ctype_digit($no_hp)) {
                $this->session->set_flashdata('error', 'No HP hanya boleh angka!');
                $this->session->set_flashdata('old', $_POST);
                $this->log('Gagal transaksi (no hp tidak valid)', 'insert');
                redirect($_SERVER['HTTP_REFERER']);
            }

            $this->session->set_flashdata('error', 'Semua data wajib diisi!');
            $this->log('Gagal transaksi (data tidak lengkap)', 'insert');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Validasi kecukupan nominal pembayaran
        $total = $this->input->post('total');
        $bayar = $this->input->post('bayar');

        if ($bayar < $total) {
            $this->session->set_flashdata('error', 'Uang kurang!');
            $this->log('Gagal transaksi (uang kurang)', 'insert');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Proses penyimpanan data transaksi utama
        $data = [
			
            'nama_lengkap' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'id_paket' => $id_paket,
            'id_user' => $this->session->userdata('id_user'),
            'tanggal_transaksi' => date('Y-m-d'),
            'tanggal_acara' => $tanggal,
            'jam_acara' => $jam,
            'lokasi' => $this->input->post('lokasi'),
            'total_harga' => $total,
            'uang_bayar' => $bayar,
            'uang_kembali' => $bayar - $total,
            'status' => 'menunggu'
        ];

        $this->db->insert('transactions', $data);
        $id = $this->db->insert_id();

        if (!$id) {
            die('Gagal insert transaksi');
        }

        // Otomatisasi generate nomor pesanan  
        $nomor = 'ORD-' . str_pad($id, 3, '0', STR_PAD_LEFT);
        $this->db->where('id_transaction', $id);
        $this->db->update('transactions', [
            'nomor_pesanan' => $nomor
        ]);

        $this->log('Melakukan transaksi ID ' . $id, 'insert');

        // Input data ke tabel status pengerjaan pesanan
        $this->db->insert('status_pesanan', [
            'id_transaction' => $id,
            'status' => 'menunggu'
        ]);

        redirect('kasir/cetak_struk/' . $id);
    }


   
    public function cetak_struk($id)
    {
        $this->load->library('Dompdf_gen');

        $this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
        $this->db->from('transactions');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');
        $this->db->where('id_transaction', $id);

        $data['transaksi'] = $this->db->get()->row();

        $this->load->view('kasir/struk', $data);

        $html = $this->output->get_output();

        $this->dompdf_gen->dompdf->loadhtml($html);
        $this->dompdf_gen->dompdf->setpaper([0, 0, 400, 700], 'portrait');
        $this->dompdf_gen->dompdf->render();

        $this->log('Cetak struk transaksi ID ' . $id, 'read');

        // Menampilkan PDF ke chrom tanpa download otomatis
        $this->dompdf_gen->dompdf->stream("struk.pdf", array("Attachment" => false));

        
    }


   
    public function get_paket_by_nama($nama)
    {
        $data = $this->Paket_model->getByNama(urldecode($nama));
        echo json_encode($data);
    }



		public function status_pesanan()
			{
				$this->load->library('pagination');

				$keyword = $this->input->get('keyword');
				$filter_status = $this->input->get('status');

				// Menggabungkan data transaksi dengan detail paket foto terkait
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

				// Fitur pencarian berdasarkan nama pelanggan, nomor pesanan, atau nama paket
				if ($keyword) {
					$this->db->group_start();
					$this->db->like('transactions.nama_lengkap', $keyword);
					$this->db->or_like('transactions.nomor_pesanan', $keyword);
					$this->db->or_like('paket_foto.nama_paket', $keyword);
					$this->db->group_end();
				}

				// Filter data berdasarkan status pengerjaan (jika dipilih)
				if ($filter_status && $filter_status != 'all') {
					$this->db->where('transactions.status', $filter_status);
				}

				// Mengurutkan data terbaru berdasarkan tanggal transaksi dan ID
				$this->db->order_by('tanggal_transaksi', 'DESC');
				$this->db->order_by('id_transaction', 'DESC');

				// Pengaturan sistem paginasi halaman
				$config['total_rows'] = $this->db->count_all_results('', false);
				$config['base_url'] = base_url('kasir/status_pesanan');
				$config['per_page'] = 10;
				$config['reuse_query_string'] = true;

				$this->pagination->initialize($config);

				$page = $this->uri->segment(3) ?? 0;

				$data['status'] = $this->db->limit($config['per_page'], $page)->get()->result();
				$data['pagination'] = $this->pagination->create_links();
				$data['keyword'] = $keyword;
				$data['filter_status'] = $filter_status;

				$this->load->view('kasir/status_pesanan', $data);
			}



			public function riwayat()
			{
				$this->load->library('pagination');

				$keyword = $this->input->get('keyword');

				// Mengambil seluruh kolom transaksi yang difilter hanya untuk status 'selesai'
				$this->db->select('transactions.*, CONCAT(paket_foto.nama_paket, " ", paket_foto.jenis) as nama_paket');
				$this->db->from('transactions');
				$this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket', 'left');
				$this->db->where('transactions.status', 'selesai');

				// Fitur pencarian pada halaman riwayat
				if ($keyword) {
					$this->db->group_start();
					$this->db->like('transactions.nama_lengkap', $keyword);
					$this->db->or_like('transactions.nomor_pesanan', $keyword);
					$this->db->or_like('paket_foto.nama_paket', $keyword);
					$this->db->group_end();
				}

				$this->db->order_by('tanggal_transaksi', 'DESC');
				$this->db->order_by('id_transaction', 'DESC');

				// Konfigurasi pembagian halaman riwayat
				$config['total_rows'] = $this->db->count_all_results('', false);
				$config['base_url'] = base_url('kasir/riwayat');
				$config['per_page'] = 10;
				$config['reuse_query_string'] = true;
				$config['uri_segment'] = 3;

				$this->pagination->initialize($config);

				$page = $this->uri->segment(3) ?? 0;

				$data['riwayat'] = $this->db->limit($config['per_page'], $page)->get()->result();
				$data['pagination'] = $this->pagination->create_links();
				$data['keyword'] = $keyword;

				$this->load->view('kasir/riwayat', $data);
			}
}
