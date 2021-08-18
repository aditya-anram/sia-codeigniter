<?php
//user access
function is_logged_in()
{
    //instansiasi
    $ci = get_instance();

    //cek login
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        //sudah login
        $role_id = $ci->session->userdata('role_id');
        //akses menu
        $menu = $ci->uri->segment(1);

        //ambil menu
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();

        //ambil id nya
        $menu_id = $queryMenu['id'];

        //user aceess
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        //jika ada data di tabel
        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }

    function check_access($role_id, $menu_id)
    {
        $ci = get_instance();

        //cek boleh akses nggak
        $ci->db->where('role_id', $role_id);
        $ci->db->where('menu_id', $menu_id);
        $result = $ci->db->get('user_access_menu');

        //cek ada gak

        if ($result->num_rows() > 0) {
            return "checked='checked'";
        }
    }
}
