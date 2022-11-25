<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Employee_model');
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
        $data['header']['title'] = "Employee Record";
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
            ['src' => base_url() . 'assets/js/employee.js?ver=1', 'type' => 'text/javascript']
        );
        $data['employee']['records'] = $this->Employee_model->get();

        $this->load->view('templates/header', $data['header']);
		$this->load->view('pages/employee/index', $data['employee']);
        $this->load->view('pages/employee/add_modal');
        $this->load->view('pages/employee/edit_modal');
        $this->load->view('templates/success_modal');
        $this->load->view('templates/error_modal');
        $this->load->view('templates/info_modal');
        $this->load->view('templates/confirmation_modal');
        $this->load->view('templates/session_modal');
        $this->load->view('templates/footer', $data['footer']);
	}

    public function create(){
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

        $data['response']['status'] = false;
        $data['response']['session_expired'] = false;

        if($this->form_validation->run() != FALSE && ($this->session_user_id != "")){
            $datetime = new DateTime();
            $date_added = $datetime->format('Y-m-d h:i:s');
            $param = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'created_by' => $_SESSION['user_id'],
                'datetime_added' => $date_added
            );
            $this->Employee_model->insert($param);
            
            // get employee records
            $data['response']['records'] = $this->Employee_model->get();
            $data['response']['status'] = true;
        }else{
            // $errors = $this->form_validation->error_array();

            $data['response']['error'] = 'Validation Error';

            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        
    }

    public function get_all(){
        $data['employee']['records'] = $this->Employee_model->get();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_by_id(){
        $data['employee']['records'] = $this->Employee_model->get_by_id($this->input->get('id'));

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update(){
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $data['response']['status'] = false;
        $data['response']['session_expired'] = false;
        if($this->form_validation->run() != FALSE && ($this->session_user_id != "")){
            $datetime = new DateTime();
            $date_updated = $datetime->format('Y-m-d h:i:s');

            $param = array(
                'id' => $this->input->post('id'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'created_by' => $this->session_user_id,
                'datetime_updated' => $date_updated
            );
            $this->Employee_model->update($param);
            
            // get employee records
            $data['response']['records'] = $this->Employee_model->get();
            $data['response']['status'] = true;
        }else{
            // $errors = $this->form_validation->error_array();

            $data['response']['error'] = 'Validation Error';

            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
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

        if($id != "" && ($this->session_user_id != "")){
            $this->Employee_model->delete($id);
            
            // get employee records
            $data['response']['records'] = $this->Employee_model->get();
            $data['response']['status'] = true;
        }else{
            // $errors = $this->form_validation->error_array();

            $data['response']['error'] = 'Validation Error';
            
            if($this->session_user_id == ""){
                $data['response']['session_expired'] = true; 
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
