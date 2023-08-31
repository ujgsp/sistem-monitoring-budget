<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Budget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('m_user');
        $this->load->model('m_budget');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Budget';
        $data['user'] = $this->m_user->getUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('budget/index', $data);
        $this->load->view('templates/footer');
    }

    // datatable

    public function budgetproposal($kategori)
    {
        $data['user'] = $this->m_user->getUser();

        $this->m_budget->set_budget_category($kategori);
        $this->m_budget->set_departement_id($data['user']['departement_id']);

        $list = $this->m_budget->get_datatables();
        $data = array();
        $no = $_POST['start'];
        # definisikan column table view
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = '[' . $field->account_number . '] ' . $field->account_name;
            $row[] = '<a>' . $field->account_name . '</a><br><small>' . $field->account_number . '</small>';
            $row[] = $field->keterangan;
            $row[] = strtoupper($field->lokasi);
            $row[] = $field->tahun;
            $row[] = $field->inisial;
            $row[] = number_format($field->total_budget_referensi, 0, ',', '.');
            $row[] = '
			<a href="' . base_url('budget/edit/' . encodeParamUrl($field->kode_budget)) . '" class="btn btn-primary">Edit</a>
			<a href="' . base_url('budget/delete/' . encodeParamUrl($field->kode_budget)) . '"  data-ket="' . $field->keterangan . '"class="btn btn-danger btn_delete" title="Hapus">Delete</a>
			';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_budget->count_all(),
            "recordsFiltered" => $this->m_budget->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function initialbudget($kategori)
    {
        $data['user'] = $this->m_user->getUser();

        $this->m_budget->set_budget_category($kategori);
        $this->m_budget->set_departement_id($data['user']['departement_id']);

        $list = $this->m_budget->get_datatables();
        $data = array();
        $no = $_POST['start'];
        # definisikan column table view
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a>' . $field->account_name . '</a><br><small>' . $field->account_number . '</small>';
            $row[] = $field->keterangan;
            $row[] = ucwords($field->name);
            $row[] = strtoupper($field->lokasi);
            $row[] = $field->tahun;
            $row[] = $field->inisial;
            // $row[] = empty($field->start_job) ? '-' : date('M-y', strtotime($field->start_job)). ' s.d ' . date('M-y', strtotime($field->end_job));
            // $row[] = empty($field->start_job) ? '-' : '<span class="badge badge-warning">' . date('M-y', strtotime($field->start_job)) . '/' . date('M-y', strtotime($field->end_job)) . '</span>';
            $row[] = number_format($field->total_budget_referensi, 0, ',', '.');
            $row[] = number_format($field->total_budget_reals, 0, ',', '.');
            $selisih = $field->total_budget_referensi - $field->total_budget_reals;
            // $row[] = number_format($selisih, 0, ',', '.');

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_budget->count_all(),
            "recordsFiltered" => $this->m_budget->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function edit($kode_budget)
    {
        $data['title'] = 'Budget';
        $data['user'] = $this->m_user->getUser();

        $data['pic'] = $this->m_budget->getPIC($data['user']['departement_id']);

        $kode = base64_decode($kode_budget);
        $this->db->select('
        m_coa.account_number,
        m_coa.account_name,
        t_budget.kode_budget,
        t_budget.keterangan,
        t_budget.lokasi,
        t_budget.tahun,
        t_budget.total_budget_referensi,
        t_budget.keterangan,
        departement.departement
        ');
        $this->db->join('m_coa', 't_budget.m_coa_id=m_coa.id');
        $this->db->join('departement', 't_budget.departement_id_real=departement.id');
        $this->db->from('t_budget');
        $this->db->where('t_budget.kode_budget', $kode);
        $data['get_data_by_id'] = $this->db->get()->row_array();

        // set rules validation 
        $this->form_validation->set_rules('initialbudget', 'Initial Budget', 'required');
        $this->form_validation->set_rules('pic_id', 'PIC', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('budget/budget_proposal_edit', $data);
            $this->load->view('templates/footer');
        } else {
            // proses update data
            $this->m_budget->edit_data($kode);

            // redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Budget Proposal was changed!</div>');
            redirect('budget');
        }
    }

    public function delete($kode_budget)
    {
        $kode = base64_decode($kode_budget);
        $this->db->delete('t_budget', array('kode_budget' => $kode));

        // redirect
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Budget was deleted!</div>');
        redirect('budget');
    }
}
