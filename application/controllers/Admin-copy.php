<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $role_name = html_escape($this->input->post('role', true));

            $this->db->insert('user_role', array('role' => strtolower($role_name)));

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
            redirect('admin/role');
        }
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function roleedit($id)
    {
        $rolename = html_escape($this->input->post('rolenameedit', true));

        $this->db->update('user_role', array('role' => $rolename), array('id' => $id));

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role Name has Changed!</div>');
        redirect('admin/role');
    }

    public function roledelete($id)
    {
        $this->db->delete('user_role', array('id' => $id));

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role Name was deleted!</div>');
        redirect('admin/role');
    }

    public function userlogin()
    {
        $this->load->model('m_user');
        $data['title'] = 'User Login';
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $this->m_user->getUser();

        $this->db->select('*');
        $this->db->join('user_role', 'user.role_id=user_role.id');
        $this->db->from('user');
        $data['get_user'] = $this->db->get()->result_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|is_unique[user.password]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/user', $data);
            $this->load->view('templates/footer');
        } else {
            $name = html_escape($this->input->post('name', true));
            $email = html_escape($this->input->post('email', true));
            $role_id = $this->input->post('role_id');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $data = array(
                'departement_id' => $data['user']['departement_id'],
                'name' => $name,
                'email' => $email,
                'image' => 'default.jpg',
                'password' => $password,
                'role_id' => $role_id,
                'is_active' => 1,
                'date_created' => time()
            );

            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New user login added!</div>');
            redirect('admin/userlogin');
        }
    }
}
