<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('m_user');
        $this->load->model('m_dashboard');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->m_user->getUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    // AJAX

    public function counttotal()
    {
        $category = $this->input->get('category');
        // $year = $this->input->get('year');

        $data['user'] = $this->m_user->getUser();

        if ($this->session->userdata('role') == 'staff') {
            $result = $this->m_dashboard->count($category, $data['user']['id']);
        } elseif (($this->session->userdata('role') == 'kadiv') && ($this->session->userdata('role') == 'bod')) {
            // $result = $this->m_dashboard->count($category, $data['user']['departement_id']);
        } else {
            $result = $this->m_dashboard->countByAll($category, $data['user']['departement_id']);
            // $result = $this->m_dashboard->countByAll('capex', 10);
        }

        echo json_encode(
            array(
                'total_budget' => number_format($result['total_budget'], 0, ',', '.'),
                'total_penggunaan' => number_format($result['total_penggunaan'], 0, ',', '.'),
                'total_saldo' => number_format($result['saldo'], 0, ',', '.'),
                ''
            )
        );
    }

    public function chart()
    {
        $data['user'] = $this->m_user->getUser();

        $type_chart = $this->input->get('type');
        $year = $this->input->get('year');
        $category = $this->input->get('category');
        $location = $this->input->get('location');
        $departement = $this->input->get('departement');

        $role = $this->session->userdata('role');

        # control
        switch ($type_chart) {
            case 'bar':
                if ($role == 'staff') {
                    $this->m_dashboard->bar_chart($year, $data['user']['id'], $category, $location);
                } elseif (($role == 'kadiv') or ($role == 'bod')) {
                    $this->m_dashboard->bar_chart_by_kadiv($year, $category, $location, $departement);
                } else {
                    $this->m_dashboard->bar_chart_by_all($year, $data['user']['departement_id'], $category, $location);
                }
                break;

            case 'pie':
                if ($role == 'staff') {
                    $this->m_dashboard->pie_chart($year, $data['user']['id']);
                } elseif (($role == 'kadiv') or ($role == 'bod')) {
                    $this->m_dashboard->pie_chart_by_kadiv($year);
                } else {
                    $this->m_dashboard->pie_chart_by_all($year, $data['user']['departement_id']);
                }
                break;

            case 'pie2':
                $this->m_dashboard->pie_chart_by_dept($year);
                break;
            case 'pie3':
                $this->m_dashboard->pie_chart_mp_by_dept($year);
                break;
        }
    }

    // DATATABLE

    public function datatable($tahun_anggaran, $category)
    {
        $data['user'] = $this->m_user->getUser();
        $data['param'] = array('tahun_anggaran' => $tahun_anggaran, 'category' => $category);
        $this->load->view('dashboard/table', $data);
    }
}
