<?php

class Login_model extends CI_Model{

    public function login($param = array()){
        $query = $this->db->select('id, user_name, user_type')
                    ->where('user_name', $param['user_name'])
                    ->where('user_password', $param['user_password'])
                    ->get('user');

        return $query->result();
    }

}

?>