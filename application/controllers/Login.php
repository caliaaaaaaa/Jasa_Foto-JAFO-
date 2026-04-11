<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index(){
        $this->load->view('login');
    }

    public function login(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $user = $this->db->get_where('users', [
            'username' => $username,
            'password' => $password,
            'status' => 'aktif'
        ])->row();

        if($user){

            $this->session->set_userdata([
                'id_user' => $user->id_user,
                'role' => $user->role,
                'nama' => $user->nama_lengkap
            ]);

            // 🔥 LOG LOGIN
            $this->db->insert('activity_log', [
                'id_user'   => $user->id_user,
                'role'      => $user->role,
                'aktivitas' => 'Login ke sistem',
                'action'    => 'login'
            ]);

            // redirect sesuai role
            if($user->role == 'admin'){
                redirect('admin/dashboard');
            } elseif($user->role == 'kasir'){
                redirect('kasir/dashboard');
            } else {
                redirect('owner/dashboard');
            }

        } else {
            $this->session->set_flashdata('error', 'Login gagal!');
            redirect('login');
        }
    }

    public function logout(){

        // 🔥 LOG LOGOUT
        $this->db->insert('activity_log', [
            'id_user'   => $this->session->userdata('id_user'),
            'role'      => $this->session->userdata('role'),
            'aktivitas' => 'Logout dari sistem',
            'action'    => 'logout'
        ]);

        $this->session->sess_destroy();
        redirect('login');
    }
}
