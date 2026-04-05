<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
            redirect('auth');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}
