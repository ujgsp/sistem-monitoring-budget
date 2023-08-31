<?php

class M_dashboard extends CI_Model
{

    protected $table = 't_budget'; //nama tabel utama dari database
    protected $column_order = array(); //field yang ada di table user
    protected $column_search = array(); //field yang diizin untuk pencarian 
    protected $order = array('tb.start_job', 'asc'); // default order 

    protected $budget_kategori = '';
    protected $departement_id = '';
    protected $session_id = '';

    public function setQuery()
    {
        // filter
        if ($this->input->post('filter_tahun')) {
            $this->db->where('tb.tahun', $this->input->post('filter_tahun'));
        }
        if ($this->input->post('filter_pic')) {
            $this->db->where('tb.pic_user_id', $this->input->post('filter_pic'));
        }
        if ($this->input->post('filter_nama_budget')) {
            $this->db->like('tb.keterangan', $this->input->post('filter_nama_budget'));
        }
        if ($this->input->post('filter_coa')) {
            $this->db->like('tb.m_coa_id', $this->input->post('filter_coa'));
        }
        if ($this->input->post('filter_departement_id')) {
            $this->db->like('tb.departement_id', $this->input->post('filter_departement_id'));
        }

        $this->db->select('
        bpb.id_coa ,
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.id ,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        u.nama ,
        d.inisial,
        tb.total_budget_reals ,
        ifnull(sum(bpb.estimasi) ,0) AS budget_usage,
        tb.saldo 
        ');

        $this->db->join('`user` u', 'tb.pic_user_id =u.id');
        $this->db->join('departement d', 'tb.departement_id =d.id');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->join('b_plan_busage bpb', 'tb.kode_budget =bpb.id_coa', 'LEFT');
        $this->db->from('t_budget tb');
        $this->db->group_by('tb.keterangan ');

        // control by session login
        $role = $this->session->userdata('role');
        if (
            ($role == 'supervisor') or ($role == 'tu') or ($role == 'manager') or ($role == 'departement')
        ) {
            $this->db->where('tb.status', '1');
            $this->db->where('mc.budget_category', $this->budget_kategori);
            $this->db->where('tb.departement_id', $this->departement_id);
        } elseif ($role == 'staff') {
            $this->db->where('tb.status', '1');
            $this->db->where('mc.budget_category', $this->budget_kategori);
            $this->db->where('tb.pic_user_id', $this->session_id);
        } else {
            $this->db->where('tb.status', '1');
            $this->db->where('mc.budget_category', $this->budget_kategori);
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

    public function set_budget_category($kategori)
    {
        $this->budget_kategori = $kategori;
    }

    public function set_departement_id($departement_id)
    {
        $this->departement_id = $departement_id;
    }

    public function set_session_id($session_id)
    {
        $this->session_id = $session_id;
    }

    public function getMasterData($tahun, $type)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        /*  
        SELECT
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        tb.total ,
        u.nama ,
        ifnull(bpb.estimasi,0) AS budget_usage,
        ifnull(tb.total - bpb.estimasi, tb.total) AS saldo
        FROM	t_budget AS tb
        JOIN m_coa AS mc ON tb.m_coa_id=mc.id
        LEFT JOIN b_plan_busage AS bpb ON tb.kode_budget=bpb.id_coa
        -- LEFT JOIN t_mp_budget AS tmb ON tb.kode_budget=tmb.id
        JOIN user AS u ON u.id=tb.pic_user_id
        WHERE tb.tahun='2023' AND tb.`status`='1' AND tb.soft_delete=0
        */

        $this->db->select('
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        tb.total_budget_reals ,
        u.nama ,
        ifnull(SUM(bpb.estimasi),0) AS budget_usage,
        ifnull(tb.total_budget_reals - SUM(bpb.estimasi), tb.total_budget_reals) AS saldo
        ');

        $this->db->join('m_coa AS mc', 'tb.m_coa_id=mc.id');
        $this->db->join('b_plan_busage AS bpb', ' tb.kode_budget=bpb.id_coa', 'LEFT');
        $this->db->join('user AS u', 'u.id=tb.pic_user_id');
        $this->db->from('t_budget AS tb');
        $this->db->where('tb.tahun', $tahun);
        $this->db->where('tb.status', '1');
        $this->db->where('mc.budget_category', $type);
        $this->db->group_by('tb.keterangan');

        // control where by session login
        // if ($this->session->userdata('role') == 'staff') {
        //     $this->db->where('u.id', $data['user']['id']);
        //     $this->db->group_by('tb.keterangan');
        // } elseif (($this->session->userdata('role') == 'supervisor') ||  ($this->session->userdata('role') == 'manager')) {
        //     $this->db->where('tb.departement_id', $data['user']['departement_id']);
        //     $this->db->group_by('tb.keterangan');
        // }

        return $this->db->get()->result_array();
    }

    public function getTopBudgetUsed()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        tb.total ,
        u.nama ,
        ifnull(SUM(bpb.estimasi),0) AS budget_usage,
        ifnull(tb.total - SUM(bpb.estimasi), tb.total) AS saldo
        ');

        $this->db->join('m_coa AS mc', 'tb.m_coa_id=mc.id');
        $this->db->join('b_plan_busage AS bpb', ' tb.kode_budget=bpb.id_coa', 'LEFT');
        $this->db->join('user AS u', 'u.id=tb.pic_user_id');
        $this->db->from('t_budget AS tb');
        $this->db->where('tb.tahun', '2023');
        $this->db->where('tb.status', '1');
        $this->db->where('tb.soft_delete', 0);
        $this->db->group_by('tb.keterangan');
        $this->db->where('tb.departement_id', $data['user']['departement_id']);
        return $this->db->get()->result_array();
    }

    public function getCoa($departement_id = FALSE)
    {
        if ($departement_id === FALSE) {
            $query = $this->db->get('m_coa');
            return $query->result_array();
        }

        $query = $this->db->get_where('m_coa', ['departement_id' => $departement_id]);
        return $query->result_array();
    }

    /* counting */

    public function count($kategori, $pic = FALSE, $departement_id = FALSE)
    {


        /*  
        SELECT 
        sum(tb.total_budget_reals) AS total_budget,
        sum(bpb.estimasi) AS total_penggunaan,
        sum(tb.saldo) AS saldo
        FROM db_budget.t_budget tb 
        JOIN db_budget.b_plan_busage bpb ON tb.kode_budget =bpb.id_coa 
        WHERE 
        -- bpb.id_mp ='IT/MP/0606-00002/2023'
        tb.pic_user_id =2
        */

        if (($departement_id or $pic) === FALSE) {
            $this->db->select('
            SUM(tb.total_budget_reals) AS total_budget,
            sum(bpb.estimasi) AS total_penggunaan,
            sum(tb.saldo) AS saldo
            ');
            $this->db->join('b_plan_busage bpb', 'tb.kode_budget =bpb.id_coa', 'left');
            $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
            $this->db->from('t_budget tb');
            $this->db->where('tb.departement_id', $departement_id);
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.tahun', date('Y'));
            return $this->db->get()->row_array();
        }

        $this->db->select('
        SUM(tb.total_budget_reals) AS total_budget,
        sum(bpb.estimasi) AS total_penggunaan,
        sum(tb.saldo) AS saldo
        ');
        $this->db->join('b_plan_busage bpb', 'tb.kode_budget =bpb.id_coa', 'left');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where('tb.pic_user_id', $pic);
        $this->db->where('mc.budget_category', $kategori);
        $this->db->where('tb.tahun', date('Y'));
        return $this->db->get()->row_array();
    }

    public function countByAll($kategori, $departement_id)
    {
        $this->db->select('
        SUM(tb.total_budget_reals) AS total_budget,
        sum(bpb.estimasi) AS total_penggunaan,
        sum(tb.saldo) AS saldo
        ');
        $this->db->join('b_plan_busage bpb', 'tb.kode_budget =bpb.id_coa', 'left');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where('tb.departement_id', $departement_id);
        $this->db->where('mc.budget_category', $kategori);
        $this->db->where('tb.tahun', date('Y'));
        return $this->db->get()->row_array();
    }

    /* chart */

    public function barChart()
    {
        $this->db->select('
		tb.keterangan ,
		tb.lokasi ,
		tb.total_budget_reals 
		');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where('mc.budget_category', 'capex');
        $this->db->where('tb.status', '1');
        return $this->db->get()->result_array();
    }

    public function get_budget_by_dept($tahun)
    {
        /* $sql = $this->db->query("
        SELECT 
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.id ,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        tb.start_job ,
        tb.end_job ,
        u.nama ,
        d.inisial,
        d.departement ,
        sum(tb.total_budget_reals) AS total_budget  ,
        ifnull(sum(bpb.estimasi) ,0) AS budget_usage,
        sum(tb.saldo ) AS total_saldo 
        FROM db_budget.t_budget tb 
        JOIN db_budget.`user` u ON tb.pic_user_id =u.id 
        JOIN db_budget.departement d ON tb.departement_id =d.id 
        JOIN db_budget.m_coa mc ON tb.m_coa_id =mc.id 
        LEFT JOIN db_budget.b_plan_busage bpb ON tb.kode_budget =bpb.id_coa 
        WHERE tb.status ='1' AND tb.tahun ='" . $tahun . "'
        GROUP BY d.departement 
        "); */

        $sql = $this->db->query("
        SELECT 
        d.departement ,
        sum(tb.total_budget_reals) AS total_budget,
        penggunaan.total_pengguaan AS budget_usage,
        -- sum(tb.saldo)
        (sum(tb.total_budget_reals)) - penggunaan.total_pengguaan AS total_saldo
        FROM db_budget.t_budget tb
        JOIN db_budget.departement d ON tb.departement_id =d.id ,
            (SELECT sum(bpb.estimasi) AS total_pengguaan FROM db_budget.b_plan_busage bpb ) AS penggunaan
        WHERE tb.tahun ='".$tahun."' AND tb.status ='1'
        GROUP BY d.departement 
        ");
        return $sql->result_array();
    }

    // pie chart
    public function pie_chart($tahun, $pic_user_id)
    {
        $result = $this->db->query("
		SELECT bp.m2 AS vendor, count(no) AS counting FROM db_budget.b_procurement bp 
		JOIN db_budget.t_mp_budget tmb ON tmb.kode_mp =bp.id_mp 
		WHERE tmb.pic_user_id =" . $pic_user_id . " AND tmb.tahun ='" . $tahun . "' AND bp.proses='1'
		GROUP BY bp.m2 
		");

        $data = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $item) {
                // masukan isi database sebagai array
                $data[] = array(
                    'label'  => $item["vendor"],
                    'value'  => $item["counting"]
                );
            }
        }

        echo json_encode($data);
    }

    // public function pie_chart_by_all($tahun, $departement_id = FALSE)
    public function pie_chart_by_all($tahun, $departement_id)
    {
        // if ($departement_id === FALSE) {
        //     $result = $this->db->query("
        //     SELECT bp.m2 AS vendor, count(no) AS counting FROM db_budget.b_procurement bp 
        //     JOIN db_budget.t_mp_budget tmb ON tmb.kode_mp =bp.id_mp 
        //     WHERE tmb.tahun ='" . $tahun . "' AND bp.proses='1'
        //     GROUP BY bp.m2 
        //     ");

        //     $data = array();
        //     if ($result->num_rows() > 0) {
        //         foreach ($result->result_array() as $item) {
        //             // masukan isi database sebagai array
        //             $data[] = array(
        //                 'label'  => $item["vendor"],
        //                 'value'  => $item["counting"]
        //             );
        //         }
        //     }

        //     echo json_encode($data);
        // }

        $result = $this->db->query("
		SELECT bp.m2 AS vendor, count(no) AS counting FROM db_budget.b_procurement bp 
		JOIN db_budget.t_mp_budget tmb ON tmb.kode_mp =bp.id_mp 
		WHERE tmb.departement_id =" . $departement_id . " AND tmb.tahun ='" . $tahun . "' AND bp.proses='1'
		GROUP BY bp.m2 
		");

        $data = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $item) {
                // masukan isi database sebagai array
                $data[] = array(
                    'label'  => $item["vendor"],
                    'value'  => $item["counting"]
                );
            }
        }

        echo json_encode($data);
    }

    public function pie_chart_by_kadiv($tahun)
    {
        $result = $this->db->query("SELECT bp.m2 AS vendor, count(bp.`no`) AS counting  
                                        FROM db_budget.b_procurement bp 
                                        JOIN db_budget.t_mp_budget tmb ON bp.id_mp =tmb.kode_mp 
                                        WHERE bp.proses ='1' AND tmb.tahun ='" . $tahun . "'
                                        GROUP BY bp.m2 ");

        $data = array();
        // if ($result->num_rows() > 0) {
        foreach ($result->result_array() as $item) {
            // masukan isi database sebagai array
            $data[] = array(
                'label'  => $item["vendor"],
                'value'  => $item["counting"]
            );
        }
        echo json_encode($data);
        // $response = json_encode($data);
        // return $response;
    }

    public function pie_chart_by_dept($tahun)
    {
        $sql = $this->db->query("SELECT d.departement, count(tb.id) AS counting  FROM db_budget.t_budget tb 
        JOIN db_budget.departement d ON tb.departement_id =d.id WHERE tb.tahun ='" . $tahun . "'
        GROUP BY d.departement ");

        $data = array();
        // if ($sql->num_rows() > 0) {
        foreach ($sql->result_array() as $item) {
            // masukan isi database sebagai array
            $data[] = array(
                'label'  => $item["departement"],
                'value'  => $item["counting"]
            );
        }
        // }

        echo json_encode($data);
    }

    public function pie_chart_mp_by_dept($tahun)
    {
        $sql = $this->db->query("SELECT d.departement ,count(tmb.id) AS counting  FROM db_budget.t_mp_budget tmb 
        JOIN db_budget.departement d ON tmb.departement_id =d.id WHERE tmb.tahun ='" . $tahun . "'
        GROUP BY d.departement ");

        $data = array();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $item) {
                // masukan isi database sebagai array
                $data[] = array(
                    'label'  => $item["departement"],
                    'value'  => $item["counting"]
                );
            }
        }

        echo json_encode($data);
    }

    public function bar_chart($tahun, $pic_user_id, $kategori = NULL, $lokasi = NULL)
    {
        // $sql = $this->db->get_where('t_budget', ['tahun' => $tahun, 'pic_user_id' => $pic_user_id]);
        // $this->db->where(['mc.budget_category' => $kategori, 'tb.lokasi' => $lokasi]);

        $this->db->select('tb.keterangan,tb.total_budget_reals');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where(['tb.tahun' => $tahun, 'tb.pic_user_id' => $pic_user_id]);

        if (($kategori == NULL) && ($lokasi == NULL)) {
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori == NULL)) {
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        }

        $data = array();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[] = array(
                    'y'    => $row["keterangan"],
                    'a'    => $row["total_budget_reals"],
                    // 'color'			=>	'#' . rand(100000, 999999) . ''
                );
            }
        } else {
            $data[] = array(
                'y'  => 'No Data',
                'a'  => 0,
            );
        }

        echo json_encode($data);

        // if ($lokasi) {
        //     $this->db->where('mc.budget_category', $kategori);
        //     $this->db->where('tb.lokasi', $lokasi);
        // }


    }

    public function bar_chart_by_all($tahun, $departement_id, $kategori = NULL, $lokasi = NULL)
    {
        $this->db->select('tb.keterangan,tb.total_budget_reals');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where(['tb.tahun' => $tahun, 'tb.departement_id' => $departement_id]);

        if (($kategori == NULL) && ($lokasi == NULL)) {
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori == NULL)) {
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        }

        // $sql = $this->db->get();
        $data = array();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[] = array(
                    'y'    => $row["keterangan"],
                    'a'    => $row["total_budget_reals"],
                    // 'color'			=>	'#' . rand(100000, 999999) . ''
                );
            }
        } else {
            $data[] = array(
                'y'  => 'No Data',
                'a'  => 0,
            );
        }

        echo json_encode($data);
    }

    public function bar_chart_by_kadiv($tahun, $kategori = NULL, $lokasi = NULL, $departement = NULL)
    {
        $this->db->select('tb.keterangan,tb.total_budget_reals');
        $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
        $this->db->from('t_budget tb');
        $this->db->where('tb.tahun', $tahun);

        if (($kategori == NULL) && ($lokasi == NULL) && ($departement == NULL)) {
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi == NULL) && ($departement == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi != NULL) && ($departement == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($kategori != NULL) && ($lokasi != NULL) && ($departement != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $this->db->where('tb.departement_id', $departement);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori == NULL) && ($departement == NULL)) {
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori != NULL) && ($departement == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori != NULL) && ($departement != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $this->db->where('tb.departement_id', $departement);
            $sql = $this->db->get();
        }
        elseif (($departement != NULL) && ($kategori == NULL) && ($lokasi == NULL)) {
            $this->db->where('tb.departement_id', $departement);
            $sql = $this->db->get();
        } elseif (($departement != NULL) && ($kategori != NULL) && ($lokasi == NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.departement_id', $departement);
            $sql = $this->db->get();
        } elseif (($lokasi != NULL) && ($kategori != NULL) && ($departement != NULL)) {
            $this->db->where('mc.budget_category', $kategori);
            $this->db->where('tb.lokasi', $lokasi);
            $this->db->where('tb.departement_id', $departement);
            $sql = $this->db->get();
        }

        // $sql = $this->db->get();
        $data = array();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[] = array(
                    'y'    => $row["keterangan"],
                    'a'    => $row["total_budget_reals"]
                );
            }
        } else {
            $data[] = array(
                'y'  => 'No Data',
                'a'  => 0,
            );
        }

        echo json_encode($data);
    }

    public function getLimitMp()
    {
        $sql = $this->db->query("
        SELECT 
        u.nama,
        d.departement ,
        bp2.m3 AS budget_usage,
        date_format(tmb.created_date, '%d-%b-%y') AS tanggal,
        tmb.name_mp
        FROM db_budget.t_mp_budget tmb 
        JOIN db_budget.b_mp bm ON tmb.kode_mp =bm.id_mp 
        JOIN db_budget.b_procurement bp ON tmb.kode_mp =bp.id_mp 
        JOIN db_budget.b_si bs ON tmb.kode_mp =bs.id_mp 
        JOIN db_budget.b_legal bl ON tmb.kode_mp =bl.id_mp 
        JOIN db_budget.`user` u ON tmb.pic_user_id =u.id 
        JOIN db_budget.departement d ON tmb.departement_id =d.id 
        LEFT JOIN db_budget.b_procurement bp2 ON tmb.kode_mp =bp2.id_mp 
        WHERE bp2.proses ='1'
        ORDER BY tmb.created_date DESC LIMIT 5
        ");

        return $sql->result_array();
    }

    public function get_budget_by_id($id_coa)
    {
        $sql = $this->db->query("
        SELECT 
        mc.account_number ,
        mc.account_name ,
        mc.budget_category,
        tb.id ,
        tb.keterangan ,
        tb.lokasi ,
        tb.tahun ,
        u.nama ,
        d.inisial,
        tb.total_budget_reals ,
        ifnull(sum(bpb.estimasi) ,0) AS budget_usage,
        tb.saldo 
        FROM db_budget.t_budget tb 
        LEFT JOIN db_budget.b_plan_busage bpb ON tb.kode_budget =bpb.id_coa 
        JOIN db_budget.`user` u ON  tb.pic_user_id =u.id 
        JOIN db_budget.departement d ON tb.departement_id =d.id 
        JOIN db_budget.m_coa mc ON tb.m_coa_id =mc.id 
        WHERE bpb.id_coa ='".$id_coa."'
        ")->row_array();
        return $sql;
    }

    public function get_budget_detail_by_id($id_coa)
    {
        $sql = $this->db->query("
        SELECT 
        tmb.name_mp ,
        bpb.estimasi 
        FROM db_budget.b_plan_busage bpb 
        JOIN db_budget.t_budget tb ON bpb.id_coa =tb.kode_budget 
        JOIN db_budget.t_mp_budget tmb ON bpb.id_mp  =tmb.kode_mp 
        WHERE tb.kode_budget ='".$id_coa."'
        ")->result_array();
        return $sql;
    }
}
