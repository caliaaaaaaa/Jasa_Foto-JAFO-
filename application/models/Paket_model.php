<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paket_model extends CI_Model
{

    /**
     * Mengambil seluruh data paket foto tanpa filter.
     * Biasanya digunakan untuk menampilkan semua daftar paket di halaman pengelolaan.
     */
    public function getAll()
    {
        // Eksekusi: SELECT * FROM paket_foto
        return $this->db->get('paket_foto')->result();
    }


    /**
     * Menambahkan data paket foto baru ke dalam tabel.
     * @param array $data - Berisi data kolom (nama, harga, gambar, dll)
     */
    public function insert($data)
    {
        // Eksekusi: INSERT INTO paket_foto (...) VALUES (...)
        return $this->db->insert('paket_foto', $data);
    }


    /**
     * Mendapatkan data satu paket foto secara spesifik berdasarkan ID.
     * Digunakan saat ingin mengedit data atau melihat detail satu item saja.
     */
    public function getById($id)
    {
        // Eksekusi: SELECT * FROM paket_foto WHERE id_paket = $id
        return $this->db->get_where('paket_foto', ['id_paket' => $id])->row();
    }


    /**
     * Memperbarui data paket foto yang sudah ada.
     * @param int $id - ID paket yang akan diubah
     * @param array $data - Data baru yang akan disimpan
     */
    public function update($id, $data)
    {
        // Eksekusi: UPDATE paket_foto SET ... WHERE id_paket = $id
        $this->db->where('id_paket', $id);
        return $this->db->update('paket_foto', $data);
    }


    /**
     * Menghapus data paket foto dari tabel secara permanen.
     */
    public function delete($id)
    {
        // Eksekusi: DELETE FROM paket_foto WHERE id_paket = $id
        $this->db->where('id_paket', $id);
        return $this->db->delete('paket_foto');
    }


    /**
     * Mengambil daftar paket berdasarkan nama paket yang sama.
     * Berguna jika satu nama paket memiliki beberapa pilihan (misal: Indoor/Outdoor).
     */
    public function getByNama($nama)
    {
        // Eksekusi: SELECT * FROM paket_foto WHERE nama_paket = '$nama'
        return $this->db->get_where('paket_foto', ['nama_paket' => $nama])->result();
    }


    /**
     * Mengambil data paket dengan pengelompokan (Group By).
     * Tujuannya agar paket dengan nama yang sama hanya muncul satu kali di galeri depan,
     * sehingga tampilan tidak penuh dengan duplikasi nama yang sama.
     */
    public function getGrouped()
    {
        $this->db->select('*');
        $this->db->from('paket_foto');
        
        /**
         * Menggunakan Subquery:
         * Hanya mengambil baris yang memiliki ID paling kecil (MIN) dari setiap kelompok nama.
         */
        $this->db->where('id_paket IN (
            SELECT MIN(id_paket) 
            FROM paket_foto 
            GROUP BY nama_paket
        )');

        return $this->db->get()->result();
    }
}
