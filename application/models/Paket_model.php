<?php
class Paket_model extends CI_Model {

    // ambil semua paket
    public function getAll(){
        return $this->db->get('paket_foto')->result();
    }

    // insert paket
    public function insert($data){
        return $this->db->insert('paket_foto', $data);
    }

    // ambil 1 paket
    public function getById($id){
        return $this->db->get_where('paket_foto', ['id_paket' => $id])->row();
    }

    // update paket
    public function update($id, $data){
        $this->db->where('id_paket', $id);
        return $this->db->update('paket_foto', $data);
    }

    // hapus paket
    public function delete($id){
        $this->db->where('id_paket', $id);
        return $this->db->delete('paket_foto');
    }


	public function getByNama($nama){
    return $this->db->get_where('paket_foto', ['nama_paket' => $nama])->result();
}
public function getGrouped(){
    $this->db->select('*');
    $this->db->from('paket_foto');
    $this->db->where('id_paket IN (
        SELECT MIN(id_paket) 
        FROM paket_foto 
        GROUP BY nama_paket
    )');

    return $this->db->get()->result();
}
}
