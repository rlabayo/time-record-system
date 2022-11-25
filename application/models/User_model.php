<?php

class User_model extends CI_Model{

    public function get(){
        $query = $this->db->query('SELECT * FROM user ORDER BY id ASC');

        return $query->result();
    }

    public function insert($param = array()){
        $this->db->insert('user', $param);
    }

    public function get_by_id($id){
        $query = $this->db->select('id, user_name, user_type')->where('id', $id)->get('user');

        return $query->result();
    }

    public function update($param = array()){
        $id = $param['id'];
        unset($param['id']);
        $this->db->where('id', $id);
        $this->db->update('user', $param);
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function get_by_user_name($user_name){
        $query = $this->db->select('id')
                    ->where('user_name', $user_name)
                    ->get('user');

        return $query->result();
    }

    public function get_by_params($user_name, $id){
        $query = $this->db->select('id')
                    ->where('user_name', $user_name)
                    ->where('id !=', $id )
                    ->get('user');

        return $query->result();
    }

    public function check_password($id){
        $query = $this->db->select('user_password')->where('id', $id)->get('user');

        return $query->result();
    }

    // public function getUser(){
    //     $query = $this->db->query('SELECT * FROM User');

    //     return $query->result();
    // }

    // public function insertUser($param = array()){
    //     $this->db->insert('User', $param);
    // }

    // public function updateUser($param = array()){
    //     $id = $param['id'];
    //     unset($param['id']);
    //     $this->db->where('id', $id);
    //     $this->db->update('User', $param);
    // }

    // public function deleteUser($id){
    //     // $this->db->delete('User', array('id' => $id));
    //     $this->db->where('id', $id);
    //     $this->db->delete('User');
    // }

    // public function method_chaining(){
    //     $query = $this->db->select('username, password')->where('id', 2)->get('User');
    //     return $query->result();
    // }
}

?>