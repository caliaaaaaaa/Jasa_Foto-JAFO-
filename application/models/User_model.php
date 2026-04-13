<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    /**
     * Mengambil seluruh data pengguna yang terdaftar di sistem.
     * Digunakan oleh Admin atau Owner untuk melihat daftar karyawan.
     */
    public function getAll()
    {
        // Eksekusi: SELECT * FROM users
        return $this->db->get('users')->result();
    }


    /**
     * Menambahkan data pengguna baru (registrasi akun karyawan).
     * @param array $data - Berisi username, password (MD5), nama, dan role.
     */
    public function insert($data)
    {
        // Eksekusi: INSERT INTO users (...) VALUES (...)
        return $this->db->insert('users', $data);
    }


    /**
     * Mendapatkan data satu pengguna secara spesifik berdasarkan ID.
     * Digunakan saat proses edit profil atau verifikasi data akun tertentu.
     */
    public function getById($id)
    {
        // Eksekusi: SELECT * FROM users WHERE id_user = $id
        return $this->db->get_where('users', ['id_user' => $id])->row();
    }


    /**
     * Memperbarui data pengguna yang sudah ada (misal: ganti password atau nama).
     * @param int $id - ID pengguna yang datanya akan diubah.
     * @param array $data - Data baru yang akan disimpan.
     */
    public function update($id, $data)
    {
        // Eksekusi: UPDATE users SET ... WHERE id_user = $id
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }


    /**
     * Mengubah status pengguna menjadi 'nonaktif'.
     * Pengguna yang dinonaktifkan tidak akan bisa login ke sistem meskipun passwordnya benar.
     */
    public function nonaktif($id)
    {
        // Eksekusi: UPDATE users SET status = 'nonaktif' WHERE id_user = $id
        $this->db->where('id_user', $id);
        return $this->db->update('users', ['status' => 'nonaktif']);
    }


    /**
     * Mengaktifkan kembali akun pengguna yang sebelumnya dinonaktifkan.
     */
    public function aktif($id)
    {
        // Eksekusi: UPDATE users SET status = 'aktif' WHERE id_user = $id
        $this->db->where('id_user', $id);
        return $this->db->update('users', ['status' => 'aktif']);
    }
}
