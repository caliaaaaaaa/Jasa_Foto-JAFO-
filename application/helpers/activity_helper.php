<?php
defined('BASEPATH') OR exit('No direct script access allowed');	
	
	function log_activity($ci, $aktivitas, $action)
{
    $ci->db->insert('activity_log', [
        'id_user'   => $ci->session->userdata('id_user'),
        'role'      => $ci->session->userdata('role'),
        'aktivitas' => $aktivitas,
        'action'    => $action,
        'created_at'=> date('Y-m-d H:i:s')
    ]);
}
