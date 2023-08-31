<?php

// function is_logged_in()
// {
//     $ci = get_instance();
//     if (!$ci->session->userdata('email')) {
//         redirect('auth');
//     } else {
//         $role_id = $ci->session->userdata('role_id');
//         $menu = $ci->uri->segment(1);

//         $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
//         $menu_id = $queryMenu['id'];

//         $userAccess = $ci->db->get_where('user_access_menu', [
//             'role_id' => $role_id,
//             'menu_id' => $menu_id
//         ]);

//         if ($userAccess->num_rows() < 1) {
//             redirect('auth/blocked');
//         }
//     }
// }


// function check_access($role_id, $menu_id)
// {
//     $ci = get_instance();

//     $ci->db->where('role_id', $role_id);
//     $ci->db->where('menu_id', $menu_id);
//     $result = $ci->db->get('user_access_menu');

//     if ($result->num_rows() > 0) {
//         return "checked='checked'";
//     }
// }

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}


function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_access_submenu($role_id, $menu_id, $sub_menu_id)
{
    $ci = get_instance();

    // $ci->db->where('role_id', $role_id);
    // // $ci->db->where('menu_id', $menu_id);
    // $ci->db->where('sub_menu_id', $sub_menu_id);
    // $result = $ci->db->get('user_access_submenu');
    $result = $ci->db->query("
    SELECT 
    uam.role_id ,
    uam.menu_id ,
    uas.sub_menu_id
    FROM wpu_login.user_menu um 
    JOIN wpu_login.user_access_menu uam ON um.id =uam.menu_id 
    JOIN wpu_login.user_access_submenu uas ON uam.role_id =uas.role_id 
    WHERE uam.role_id =" . $role_id . " AND uam.menu_id=" . $menu_id . " AND uas.sub_menu_id =" . $sub_menu_id . "
    ");

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
