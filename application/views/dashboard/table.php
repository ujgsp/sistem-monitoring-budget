<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <table class="table">
        <?php
        $tahun_anggaran =  $param['tahun_anggaran'];
        $category = $param['category'];
        ?>
        <thead>
            <tr>
                <th>#</th>
                <th>COA</th>
                <th>Accounts / Budget Name / Activities</th>
                <th>PIC</th>
                <th>Location</th>
                <th>Dept</th>
                <th>Year</th>
                <th>Initial Budget</th>
                <th>Budgets Used</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // bagian 1
            $no_coa = 'A';

            $this->db->select("
            mc.id ,
            mc.account_number ,
            mc.account_name,
            ");
            $this->db->join('m_coa mc', 'tb.m_coa_id =mc.id');
            $this->db->from('t_budget tb');
            $this->db->where('mc.budget_category', $category);
            // control by session login
            $role = $this->session->userdata('role');
            if (
                ($role == 'supervisor') or ($role == 'tu') or ($role == 'manager') or ($role == 'departement')
            ) {
                $this->db->where('tb.departement_id', $user['departement_id']);
                $this->db->where('tb.tahun', $tahun_anggaran);
                $this->db->group_by('mc.account_number');
            } elseif ($role == 'staff') {
                $this->db->where('tb.pic_user_id', $user['id']);
                $this->db->where('tb.tahun', $tahun_anggaran);
                $this->db->group_by('mc.account_number');
            } else {
                $this->db->where('tb.tahun', $tahun_anggaran);
                $this->db->group_by('mc.account_number');
            }
            // $this->db->where('tb.tahun', $tahun_anggaran);
            // $this->db->group_by('mc.account_number');
            $coa = $this->db->get()->result_array();
            // $coa = $this->db->query("
            // 						SELECT 
            // 						mc.id ,
            // 						mc.account_number ,
            // 						mc.account_name
            // 						FROM db_budget.t_budget tb 
            // 						JOIN db_budget.m_coa mc ON tb.m_coa_id =mc.id 
            // 						WHERE mc.budget_category ='" . $category . "' AND tb.tahun ='" . $tahun_anggaran . "'
            // 						GROUP BY mc.account_number
            // 						")->result_array();
            foreach ($coa as $item_coa) :
            ?>
                <tr>
                    <th><?= $no_coa; ?></th>
                    <th><?= $item_coa['account_number']; ?></th>
                    <th colspan="8"><?= $item_coa['account_name']; ?></th>
                </tr>

                <?php
                // bagian 2
                $no_budget = 1;
                $this->db->select('
                        bpb.id_coa ,
                        mc.account_number ,
                        mc.account_name ,
                        mc.budget_category,
                        tb.id ,
                        tb.keterangan ,
                        tb.lokasi ,
                        tb.tahun ,
                        u.name ,
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
                // control by session login
                $role = $this->session->userdata('role');
                if (
                    ($role == 'supervisor') or ($role == 'tu') or ($role == 'manager') or ($role == 'departement')
                ) {
                    $this->db->where('tb.departement_id', $user['departement_id']);
                    $this->db->where('tb.status', '1');
                    $this->db->where('m_coa_id', $item_coa['id']);
                    $this->db->group_by('tb.keterangan ');
                } elseif ($role == 'staff') {
                    $this->db->where('tb.pic_user_id', $user['id']);
                    $this->db->where('tb.status', '1');
                    $this->db->where('m_coa_id', $item_coa['id']);
                    $this->db->group_by('tb.keterangan ');
                } else {
                    $this->db->where('tb.status', '1');
                    $this->db->where('m_coa_id', $item_coa['id']);
                    $this->db->group_by('tb.keterangan ');
                }

                $budget = $this->db->get();
                $total_inisial_budget = 0;
                $total_budget_used = 0;
                $total_balance = 0;
                foreach ($budget->result_array() as $item_budget) :
                    $total_inisial_budget += $item_budget['total_budget_reals'];
                    $total_budget_used += $item_budget['budget_usage'];
                    $total_balance += $item_budget['saldo'];
                ?>

                    <tr>
                        <td><?= $no_budget . '.' . $no_coa; ?></td>
                        <td>&nbsp;</td>
                        <td><?= $item_budget['keterangan']; ?></td>
                        <td><?= ucwords($item_budget['name']); ?></td>
                        <td><?= strtoupper($item_budget['lokasi']); ?></td>
                        <td><?= $item_budget['inisial']; ?></td>
                        <td><?= $item_budget['tahun']; ?></td>
                        <td><?= number_format($item_budget['total_budget_reals'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="<?= base_url('dashboard/' . encodeParamUrl($item_budget['id_coa'])) ?>" target="_blank">
                                <?= number_format($item_budget['budget_usage'], 0, ',', '.'); ?>
                            </a>

                        </td>
                        <td><?= number_format($item_budget['saldo'], 0, ',', '.'); ?></td>
                    </tr>

                <?php
                    // $no_coa++;
                    $no_budget++;
                endforeach;
                ?>

                <!-- totalan -->
                <tr>
                    <th colspan="7" class="text-right">Total</th>
                    <th><?= number_format($total_inisial_budget, 0, ',', '.'); ?></th>
                    <th><?= number_format($total_budget_used, 0, ',', '.'); ?></th>
                    <th><?= number_format($total_balance, 0, ',', '.'); ?></th>
                </tr>
            <?php
                $no_coa++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>