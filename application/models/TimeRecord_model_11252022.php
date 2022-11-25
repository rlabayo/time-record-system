<?php

class TimeRecord_model extends CI_Model{

    public function get_all(){
        $query = $this->db->query('SELECT employee.id as employee_id, employee.first_name, employee.last_name, user.user_name, 
                                    employee_time_record.date_added as time_record_date, employee_time_record.time_in,employee_time_record.time_out 
                                    FROM employee_time_record 
                                    INNER JOIN employee ON employee.id = employee_time_record.employee_id 
                                    INNER JOIN user ON employee_time_record.user_id = user.id
                                    ORDER BY employee_time_record.id DESC');

        return $query->result();
    }

    public function get_by_id($user_id){
        $query = $this->db->query('SELECT employee.id as employee_id, employee.first_name, employee.last_name, user.user_name, 
                                    employee_time_record.date_added as time_record_date, employee_time_record.time_in,employee_time_record.time_out 
                                    FROM employee 
                                    RIGHT JOIN employee_time_record ON employee.id = employee_time_record.employee_id 
                                    RIGHT JOIN user ON employee_time_record.user_id = user.id
                                    WHERE employee_time_record.user_id LIKE "%' . $user_id . '%"
                                    ORDER BY employee_time_record.id DESC');

        return $query->result();
    }

    public function filter_by_date($today, $yesterday){
        $query = $this->db->query('SELECT employee.id as employee_id, employee.first_name, employee.last_name, user.user_name, 
                                    employee_time_record.date_added as time_record_date, employee_time_record.time_in,employee_time_record.time_out 
                                    FROM employee 
                                    RIGHT JOIN employee_time_record ON employee.id = employee_time_record.employee_id 
                                    RIGHT JOIN user ON employee_time_record.user_id = user.id
                                    WHERE employee_time_record.date_added LIKE "%'. $today .'%" OR employee_time_record.date_added LIKE "%'. $yesterday .'%"
                                    ORDER BY employee_time_record.date_added DESC, employee_time_record.id DESC');
        return $query->result();
    }

    public function filter_by_emp_id($emp_id){
        $query = $this->db->query('SELECT employee.id as employee_id, employee.first_name, employee.last_name, employee_time_record.id as time_record_id,
                                    employee_time_record.date_added as time_record_date, employee_time_record.time_in, employee_time_record.time_out 
                                    FROM employee 
                                    LEFT JOIN employee_time_record ON employee.id = employee_time_record.employee_id 
                                    WHERE employee.id = "'. $emp_id .'" 
                                    ORDER BY employee_time_record.date_added DESC, employee_time_record.id DESC
                                    LIMIT 2');
                                    // AND ( (employee_time_record.date_added LIKE "%'. $today .'%") OR (employee_time_record.date_added LIKE "%'. $yesterday .'%"))
        return $query->result();
    }

    public function insert($param = array()){
        $result = $this->db->insert('employee_time_record', $param);

        return $result;
    }



}

?>