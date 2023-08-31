<?php

class M_user extends CI_Model
{
  public function get_data_join()
  {
    $this->db->select('
      departement.departement,
      user_role.role,
      user.nama,
      user.nama,
      user.is_active,
      user.id,
      ');
    $this->db->join('user_role', 'user_role.id=user.role_id');
    $this->db->join('departement', 'departement.id=user.departement_id');
    $this->db->from('user');
    return $this->db->get()->result_array();
  }

  public function get_data($table)
  {
    return $this->db->get($table)->result_array();
  }

  public function insert_data($table, $data)
  {
    $this->db->insert($table, $data);
  }

  public function get_data_by_id($id)
  {
    $this->db->select('
      user.nama,
      user.username,
      user.is_active,
      user.role_id,
      user.email,
      user.departement_id,
      user.id,
      ');
    // $this->db->join('departement', 'departement.id=user.departement_id');
    // $this->db->join('user_rol');
    $this->db->from('user');
    $this->db->where('user.id', $id);
    return $this->db->get()->row_array();
  }

  public function update_data($table, $data, $where)
  {
    $this->db->update($table, $data, $where);
  }

  public function getUser()
  {
    $this->db->select('
      user.id,
      user.name,
      user.departement_id,
      departement.inisial,
      departement.departement,
      ');
    $this->db->join('departement', 'departement.id=user.departement_id');
    $result = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    return $result;
  }
}
