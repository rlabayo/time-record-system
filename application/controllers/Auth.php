<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Login_model');
        $this->load->library('form_validation');
        date_default_timezone_set("Asia/Manila"); 
    }

    public function index(){
        $data['header']['title'] = "Login";
        $data['header']['css'] = array(
            ['url' => 'https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css', 'rel' => 'stylesheet', 'type' => ''],
            ['url' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css', 'rel' => 'stylesheet', 'type' => '']
        );
        $data['footer']['js'] = array(
            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js', 'type' => ''],
            ['src' => base_url() . 'assets/js/login.js?ver=11', 'type' => 'text/javascript']
        );

		$this->load->view('pages/login/index', $data);
    }

    public function process(){
        $data['response']['status'] = false;
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');

        $this->set_initial_session();

        if($user_name != "" && $password != ""){
            $param = array(
                'user_name' => $user_name,
                'user_password' => $password
            );
            $result = $this->Login_model->login($param);
           
            if(count($result) > 0){
                $user_data = array(
                                'user_id'   => $result[0]->id,
                                'user_name' => $result[0]->user_name,
                                'user_type' => $result[0]->user_type,
                                'logged_in' => TRUE
                            );
                $this->session->set_userdata($user_data);     
                $this->session->mark_as_temp(array('user_id', 'user_name', 'user_type', 'logged_in'), 600); // 10 minutes 
                
                $data['response']['status'] = true;;
            }else{
                $data['response']['status'] = false;
                
            } 
                      
        }else{
            $errors = $this->form_validation->error_array();
            $data['response']['error'] = $errors;

            
        }
        echo json_encode($data);
        // $this->output
            // ->set_content_type('application/json')
            // ->set_output(json_encode($data));
            
    }

    public function set_initial_session(){
        $user_data = array(
            'user_id'   => "",
            'user_name' => "",
            'user_type' => "",
            'logged_in' => ""
        );
        $this->session->set_userdata($user_data);   
    }

    public function logout(){
        $user_data = array(
            'user_id'   => "",
            'user_name' => "",
            'user_type' => "",
            'logged_in' => "",
            'page_visit' => ""
        );
        $this->session->unset_userdata($user_data);
        $this->session->sess_destroy();

        redirect('login');
    }


}
