<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    
    public function index()
    {
        $this->load->view('login');
    }


		public function login()
		{
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			// 🔍 cek user berdasarkan username dulu
			$user = $this->db->get_where('users', [
				'username' => $username
			])->row();

			// ❌ kalau username tidak ditemukan
			if (!$user) {
				$this->session->set_flashdata('error', 'Username atau password salah!');
				redirect('login');
			}

			// ❌ kalau password salah
			if ($user->password != $password) {
				$this->session->set_flashdata('error', 'Username atau password salah!');
				redirect('login');
			}

			// ❌ kalau akun nonaktif
			if ($user->status != 'aktif') {
				$this->session->set_flashdata('error', 'Akun kamu sudah dinonaktifkan!');
				redirect('login');
			}

			// ✅ LOGIN BERHASIL
			$this->session->set_userdata([
				'id_user' => $user->id_user,
				'role' => $user->role,
				'nama' => $user->nama_lengkap
			]);

			// log aktivitas
			$this->db->insert('activity_log', [
				'id_user'   => $user->id_user,
				'role'      => $user->role,
				'aktivitas' => 'Login ke sistem',
				'action'    => 'login',
				'created_at' => date('Y-m-d H:i:s')
			]);

			// redirect sesuai role
			if ($user->role == 'admin') {
				redirect('admin/dashboard');
			} elseif ($user->role == 'kasir') {
				redirect('kasir/dashboard');
			} else {
				redirect('owner/dashboard');
			}
		}


    
    public function logout()
    {
        // Mencatat log aktivitas logout sebelum sesi dihancurkan
        $this->db->insert('activity_log', [
            'id_user'   => $this->session->userdata('id_user'),
            'role'      => $this->session->userdata('role'),
            'aktivitas' => 'Logout dari sistem',
            'action'    => 'logout',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Menghapus seluruh data sesi dan mengembalikan ke halaman login
        $this->session->sess_destroy();
        redirect('login');
    }
}
