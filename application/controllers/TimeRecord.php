<?php
use App\Http\Controllers\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class TimeRecord extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('TimeRecord_model');
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
        $data['header']['title'] = "Time Record";
        $data['header']['css'] = array(
            ['url' => 'https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css', 'rel' => 'stylesheet', 'type' => ''],
            ['url' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css', 'rel' => 'stylesheet', 'type' => '']
        );
        $data['footer']['js'] = array(
            ['src' => 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', 'type' => 'text/javascript'],
            ['src' => 'https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js', 'type' => 'text/javascript'],
            ['src' => base_url() . 'assets/js/time_record.js?ver=1', 'type' => 'text/javascript']
        );
        
        $data['employee']['records'] = [];
        if($this->session_user_type == 1){ // super admin
            $data['employee']['records'] = $this->TimeRecord_model->get_all();
        }else if($this->session_user_type == 2){ // admin
            $data['employee']['records'] = $this->TimeRecord_model->get_by_id($this->session_user_id);
        }
        
        $this->load->view('templates/header', $data['header']);
		$this->load->view('pages/time_record/index', $data['employee']);
        $this->load->view('templates/footer', $data['footer']);
	}

    public function time_recording(){ 
        if($this->session_logged_in == false){
            redirect('login');
        }
        $data['header']['title'] = "Time Record";
        $data['header']['css'] = array(
            ['url' => 'https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css', 'rel' => 'stylesheet', 'type' => ''],
            ['url' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css', 'rel' => 'stylesheet', 'type' => '']
        );
        $data['footer']['js'] = array(
            ['src' => 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', 'type' => 'text/javascript'],
            ['src' => 'https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js', 'type' => 'text/javascript'],
            ['src' => base_url() . 'assets/js/time_recording.js?ver=2', 'type' => 'text/javascript']
        );

        $date = $this->get_dates(date("Y-m-d"));
        $data['employee']['records'] = [];
        $data['employee']['records'] = $this->TimeRecord_model->filter_by_date($date['today'], $date['yesterday']); // display 2 days of records
        
        $this->load->view('templates/header', $data['header']);
		$this->load->view('pages/time_record/time_recording', $data['employee']);
        $this->load->view('templates/success_modal');
        $this->load->view('templates/error_modal');
        $this->load->view('templates/footer', $data['footer']);
    }

    public function get_emp_details(){
        $data['response']['status'] = false;

        $emp_id = $this->input->get('emp_id');
        
        $result = $this->TimeRecord_model->filter_by_emp_id($emp_id);
       
        if(count($result) > 0){ 
            $filtered_result = [];
            $filtered_result['full_name'] = $result[0]->first_name . ' ' . $result[0]->last_name;
            $filtered_result['date_time_in'] = "";
            $filtered_result['time_in'] = "";
            $filtered_result['date_time_out'] = "";
            $filtered_result['time_out'] = "";
            if(count($result) == 1){ 
                if($result[0]->time_in != ""){
                    $filtered_result['date_time_in'] = $result[0]->time_record_date;
                    $filtered_result['time_in'] = $result[0]->time_in;
                }
            }else if(count($result) == 2){
                if($result[1]->time_in != "" && $result[0]->time_out == "") {
                    $filtered_result['date_time_in'] = $result[1]->time_record_date;
                    $filtered_result['time_in'] = $result[1]->time_in;
                }else if($result[0]->time_in != "" && $result[1]->time_out != "") {
                    $filtered_result['date_time_in'] = $result[0]->time_record_date;
                    $filtered_result['time_in'] = $result[0]->time_in;
                }else if($result[1]->time_in != "" && $result[0]->time_out != ""){
                    $filtered_result['date_time_in'] = $result[1]->time_record_date;
                    $filtered_result['date_time_out'] = $result[0]->time_record_date;
                    $filtered_result['time_in'] = $result[1]->time_in;
                    $filtered_result['time_out'] = $result[0]->time_out;
                }
            }

            $data['response']['status'] = true;
            $data['response']['details'] = $filtered_result;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function time_in(){
        $this->form_validation->set_rules('time_in', 'Time in', 'trim|required');
        $this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');

        $data['response']['status'] = false;
        if($this->form_validation->run() != FALSE && $this->session_user_id != ""){
            $time_in = $this->input->post('time_in');
            $emp_id = $this->input->post('emp_id');
            $datetime = new DateTime();
            $date = $this->get_dates($datetime->format('Y-m-d'));

            $param = array(
                'employee_id' => $emp_id,
                'user_id' => $this->session_user_id,
                'time_in' => $time_in,
                'date_added' => $date['today']
            );
            $result = $this->TimeRecord_model->insert($param);

            if($result == true){
                // get employee records
                // $data['response']['records'] = $this->TimeRecord_model->filter_by_date($date['today'], $date['yesterday']);
                $data['response']['status'] = true;
            }
        }else{
            // $errors = $this->form_validation->error_array();

            $data['response']['error'] = 'Validation Error';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function time_out(){
        $this->form_validation->set_rules('time_out', 'Time out', 'trim|required');
        $this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');

        $data['response']['status'] = false;
        if($this->form_validation->run() != FALSE && $this->session_user_id != ""){
            $time_out = $this->input->post('time_out');
            $emp_id = $this->input->post('emp_id');
            $datetime = new DateTime();
            $date = $this->get_dates($datetime->format('Y-m-d'));

            $param = array(
                'employee_id' => $emp_id,
                'user_id' => $this->session_user_id,
                'time_out' => $time_out,
                'date_added' => $date['today']
            );
            $result = $this->TimeRecord_model->insert($param);

            if($result == true){
                $data['response']['status'] = true;
            }
        }else{
            // $errors = $this->form_validation->error_array();

            $data['response']['error'] = 'Validation Error';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    // get dates - today, yesterday
    public function get_dates($today){
        $date_create = date_create($today);
        date_modify($date_create, "-1 days");
        $yesterday = date_format($date_create,"Y-m-d");

        $data['today'] = $today;
        $data['yesterday'] = $yesterday;

        return $data;
    }
}
