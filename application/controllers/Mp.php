<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');

        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'MP';
        $data['user'] = $this->m_user->getUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mp/index', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['title'] = 'Add New MP';
        $data['user'] = $this->m_user->getUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mp/add', $data);
        $this->load->view('templates/footer');
    }
}
