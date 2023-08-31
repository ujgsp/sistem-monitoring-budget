<?php

class M_budget extends CI_Model
{
    protected $table = 'log_download'; //nama tabel utama dari database
    protected $column_order = array('id', 'kategori', 'filename', 'created_date', null); //field yang ada di table user
    protected $column_search = array('id', 'kategori', 'filename', 'created_date', null); //field yang diizin untuk pencarian 
    protected $order = array('log_download.id' => 'desc'); // default order 

    protected $budget_kategori = '';
    protected $departement_id = '';

    public function setQuery()
    {
        if ($this->input->post('jenis') == 'budget') {

            $this->table = 't_budget';
            $this->column_order = array();
            $this->column_search = array('keterangan');
            $this->order = array('t_budget.id' => 'desc');

            $this->db->select('*');
            $this->db->join('m_coa', 'm_coa.id=t_budget.m_coa_id');
            $this->db->join('departement', 'departement.id=t_budget.departement_id_real');
            $this->db->from($this->table);
            $this->db->where('m_coa.budget_category', $this->budget_kategori);
            $this->db->where('t_budget.departement_id', $this->departement_id);
            $this->db->where('t_budget.status', '0');
        } elseif ($this->input->post('jenis') == 'budget_acc') {

            if ($this->input->post('filter_tahun')) {
                $this->db->where('t_budget.tahun', $this->input->post('filter_tahun'));
            }
            if ($this->input->post('filter_pic')) {
                $this->db->where('t_budget.pic_user_id', $this->input->post('filter_pic'));
            }
            // if ($this->input->post('filter_kategori')) {
            //     $this->db->where('stt_sik', $this->input->post('filter_kategori'));
            // }

            // ifnull(SUM(bpb.estimasi),0) AS budget_usage,
            $this->table = 't_budget';
            $this->column_order = array();
            $this->column_search = array('keterangan');
            $this->order = array('t_budget.id' => 'desc');

            $this->db->select('*');
            $this->db->join('m_coa', 'm_coa.id=t_budget.m_coa_id');
            $this->db->join('departement', 'departement.id=t_budget.departement_id_real');
            $this->db->join('user', 'user.id=t_budget.pic_user_id');
            $this->db->from($this->table);
            $this->db->where('m_coa.budget_category', $this->budget_kategori);
            $this->db->where('t_budget.departement_id', $this->departement_id);
            $this->db->where('t_budget.status', '1');
        } else {
            $this->db->select('
            id,kategori,filename,tahun,created_date
            ');
            $this->db->from($this->table);
            $this->db->where('log_download.departement', $this->session->userdata('departement'));
        }
    }

    private function _get_datatables_query()
    {
        $this->setQuery();

        $i = 0;

        foreach ($this->column_search as $item) { // looping awal
            if ($_POST['search']['value']) { // jika datatable mengirimkan pencarian dengan metode POST

                if ($i === 0) { // looping awal
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->setQuery();
        return $this->db->count_all_results();
    }

    // akhir datatable server side

    public function getCOA($departement_id)
    {
        $sql = $this->db->get_where('m_coa', ['departement_id' => $departement_id]);
        return $sql->result_array();
    }

    public function getDepartement()
    {
        $sql = $this->db->get('departement');
        return $sql->result_array();
    }

    public function insertData($data)
    {
        $this->db->insert('t_budget', $data);
    }

    public function updateData($data, $kode_budget)
    {
        $this->db->update('t_budget', $data, array('kode_budget' => $kode_budget));
    }

    public function getBudget($kategori_budget, $departement_id)
    {
        $this->db->select('*');
        $this->db->join('m_coa', 'm_coa.id=t_budget.m_coa_id');
        $this->db->join('departement', 'departement.id=t_budget.departement_id_real');
        $this->db->from('t_budget');
        $this->db->where('m_coa.budget_category', $kategori_budget);
        $this->db->where('t_budget.departement_id', $departement_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getPIC($departement_id)
    {
        $this->db->select('
        user.id,
        user.name,
        ');
        $this->db->join('user_role', 'user_role.id=user.role_id');
        $this->db->from('user');
        $this->db->where('user.departement_id', $departement_id);
        $this->db->where('user_role.role', 'staff');
        return $this->db->get()->result_array();
    }

    public function getLogDownload($departement)
    {
        $sql = $this->db->get_where('log_download', ['departement' => $departement])->result_array();
        return $sql;
    }

    public function getDataById($table, $where_id)
    {
        $sql = $this->db->get_where($table, $where_id);
        return $sql->row_array();
    }

    public function set_budget_category($kategori)
    {
        $this->budget_kategori = $kategori;
    }

    public function set_departement_id($departement_id)
    {
        $this->departement_id = $departement_id;
    }

    public function edit_data($kode_budget)
    {
        $initialbudget = str_replace('.', '', $this->input->post('initialbudget'));
        $pic_id = $this->input->post('pic_id');

        $data = array(
            'total_budget_reals' => $initialbudget,
            'saldo' => $initialbudget,
            'pic_user_id' => $pic_id,
            'status' => '1',
        );

        $this->db->update('t_budget', $data, array('kode_budget' => $kode_budget));
    }
}
