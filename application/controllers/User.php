<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        date_default_timezone_set("Asia/Manila");

        $this->session_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $this->session_user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';
        $this->session_logged_in = isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : '';
        
    }
    
	public function index()
	{
        if($this->session_logged_in == false){
            redirect('login');
        }
        $data['header']['title'] = "User";
        $data['header']['css'] = array(
            ['url' => 'https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css', 'rel' => 'stylesheet', 'type' => ''],
            ['url' => '//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css', 'rel' => 'stylesheet', 'type' => 'text/css'],
            ['url' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css', 'rel' => 'stylesheet', 'type' => '']
        );
        $data['footer']['js'] = array(
            ['src' => 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', 'type' => 'text/javascript'],
            ['src' => 'https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js', 'type' => 'text/javascript'],
            ['src' => '//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js', 'type' => 'text/javascript'],
            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js', 'type' => ''],
            ['src' => base_url() . 'assets/js/user.js?ver=1', 'type' => 'text/javascript']
        );
        $data['user']['records'] = $this->User_model->get();
        
        $this->load->view('templates/header', $data['header']);
		$this->load->view('pages/user/index', $data['user']);
        $this->load->view('pages/user/add_modal.php');
        $this->load->view('pages/user/edit_modal.php');
        $this->load->view('templates/success_modal');
        $this->load->view('templates/error_modal');
        $this->load->view('templates/info_modal');
        $this->load->view('templates/confirmation_modal');
        $this->load->view('templates/session_modal');
        $this->load->view('templates/footer', $data['footer']);
	}

    public function create(){
        $this->form_validation->set_rules('user_name', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
        
        $data['response']['status'] = false;
        $data['response']['session_expired'] = false;

        if($this->form_validation->run() != FALSE && $this->session_user_id != ""){
            $datetime = new DateTime();
            $date_added = $datetime->format('Y-m-d h:i:s');
            $param = array(
                'user_name' => $this->input->post('user_name'),
                'user_password' => $this->input->post('user_password'),
                'user_type' => $this->input->post('user_type'),
                'datetime_added' => $date_added
            );
            $this->User_model->insert($param);
            
            // get employee records
            $data['response']['records'] = $this->User_model->get();
            $data['response']['status'] = true;
        }else{
            $errors = $this->form_validation->error_array();
            // $data['response']['error'] = 'Validation Error';
            $data['response']['error'] = $errors;

            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        
    }

    public function update(){
        $this->form_validation->set_rules('user_name', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_password', 'Password', 'trim');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $data['response']['status'] = false;
        $data['response']['session_expired'] = false;
        
        if($this->form_validation->run() != FALSE && $this->session_user_id != ""){
            $is_exists = $this->check_user_name_if_exists($this->input->post('user_name'), $this->input->post('id'));
            
            if($is_exists == true){
                $data['response']['error'] = 'Username already exists';
            }else{
                $datetime = new DateTime();
                $date_updated = $datetime->format('Y-m-d h:i:s');

                $param = array(
                    'id' => $this->input->post('id'),
                    'user_name' => $this->input->post('user_name'),
                    'user_type' => $this->input->post('user_type'),
                    'datetime_modified' => $date_updated
                );

                if($this->input->post('user_password') != ""){
                    $param['user_password'] = $this->input->post('user_password');
                }
                $this->User_model->update($param);
                
                // get employee records
                $data['response']['records'] = $this->User_model->get();
                $data['response']['status'] = true;
            }
            
        }else{
            $errors = $this->form_validation->error_array();

            // $data['response']['error'] = 'Validation Error';
            $data['response']['error'] = $errors;

            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_by_id(){
        $data['user']['records'] = $this->User_model->get_by_id($this->input->get('id'));

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function check_user_name_if_exists($user_name, $id){
        $status = false;

        $records = $this->User_model->get_by_params($user_name, $id);
        
        if(count($records) > 0){
            $status = true;
        }
        return $status;
    }

    public function check_user_name(){
        $data['user']['status'] = false;

        if($this->input->get('id') != ""){
            $records = $this->User_model->get_by_params($this->input->get('user_name'), $this->input->get('id'));
        }else{
            $records = $this->User_model->get_by_user_name($this->input->get('user_name'));
        }

        if(count($records) > 0){
            $data['user']['status'] = true;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function check_user(){
        $id = $this->input->get('id');

        $result = $this->User_model->get_by_id($id);
        $data['status'] = false;

        if(count($result) > 0){
            $user_id = $result[0]->id;
            if($this->session_user_id == $user_id){
                $data['status'] = true;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function delete(){
        $id = $this->input->get('id');

        $data['response']['status'] = false;
        $data['response']['session_expired'] = false;
        

        if(($id != "" && ($this->session_user_id != "")) && ($id != $this->session_user_id)){

            $this->User_model->delete($id);
                
            // get employee records
            $data['response']['records'] = $this->User_model->get();
            $data['response']['status'] = true;

        }else{
            $data['response']['error'] = "Validation error";

            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function check_user_password(){
        $data['response']['status'] = false;
        $result = $this->User_model->check_password($this->input->get('id'));

        $current_password = $this->input->get('current_password');

        if($result[0]->user_password == $current_password){
            $data['response']['status'] = true;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
