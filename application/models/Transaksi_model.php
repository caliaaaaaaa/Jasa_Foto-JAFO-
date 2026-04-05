<?php

class Transaksi_model extends CI_Model {

    public function getRiwayat(){

        $this->db->select('
            transactions.*,
            customers.nama_lengkap,
            paket_foto.nama_paket
        ');

        $this->db->from('transactions');

        $this->db->join('customers', 'customers.id_customer = transactions.id_customer');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

        $this->db->order_by('transactions.id_transaction', 'DESC');

        return $this->db->get()->result();
    }




    // simpan transaksi
    public function insert($data){
        return $this->db->insert('transactions', $data);
    }


}


   

