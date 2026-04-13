<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    /**
     * Mengambil seluruh riwayat transaksi yang pernah terjadi.
     * Menggunakan teknik JOIN untuk menggabungkan data dari tabel Customers dan Paket Foto
     * agar informasi yang ditampilkan lengkap (ada nama pelanggan dan nama paketnya).
     */
    public function getRiwayat()
    {
        // Memilih kolom spesifik yang ingin ditampilkan
        $this->db->select('
            transactions.*,
            customers.nama_lengkap,
            paket_foto.nama_paket
        ');

        $this->db->from('transactions');

        /**
         * Relasi Tabel:
         * 1. Menghubungkan ID Customer di transaksi dengan tabel Customers.
         * 2. Menghubungkan ID Paket di transaksi dengan tabel Paket Foto.
         */
        $this->db->join('customers', 'customers.id_customer = transactions.id_customer');
        $this->db->join('paket_foto', 'paket_foto.id_paket = transactions.id_paket');

        // Mengurutkan dari transaksi terbaru (ID terbesar) ke yang lama
        $this->db->order_by('transactions.id_transaction', 'DESC');

        // Eksekusi query dan mengembalikan hasil dalam bentuk array objek
        return $this->db->get()->result();
    }


    /**
     * Menyimpan data transaksi baru ke dalam database.
     * Digunakan saat kasir menekan tombol simpan setelah mengisi formulir pesanan.
     * @param array $data - Berisi detail pesanan pelanggan.
     */
    public function insert($data)
    {
        // Eksekusi: INSERT INTO transactions (...) VALUES (...)
        return $this->db->insert('transactions', $data);
    }
}
