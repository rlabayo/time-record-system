<?php

class Employee_model extends CI_Model{

    public function get(){
        $query = $this->db->query('SELECT employee.id, employee.first_name, employee.last_name, employee.datetime_added, employee.datetime_updated, user.user_name FROM employee LEFT JOIN user ON employee.created_by = user.id ORDER BY employee.id ASC');

        return $query->result();
    }

    public function insert($param = array()){
        $this->db->insert('Employee', $param);
    }

    public function get_by_id($id){
        $query = $this->db->select('id, first_name, last_name')->where('id', $id)->get('employee');

        return $query->result();
    }

    public function update($param = array()){
        $id = $param['id'];
        unset($param['id']);
        $this->db->where('id', $id);
        $this->db->update('employee', $param);
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('employee');
    }

}

?>