<?php
class User_model extends CI_Model {

    // ambil semua user
    public function getAll(){
        return $this->db->get('users')->result();
    }

    // insert user
    public function insert($data){
        return $this->db->insert('users', $data);
    }

    // ambil 1 user
    public function getById($id){
        return $this->db->get_where('users', ['id_user' => $id])->row();
    }

    // update user
    public function update($id, $data){
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    // nonaktifkan user
    public function nonaktif($id){
        $this->db->where('id_user', $id);
        return $this->db->update('users', ['status' => 'nonaktif']);
    }
}
