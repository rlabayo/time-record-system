<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  

class validateSession {  
    public function __construct()
    {
        $this->CI =& get_instance();
        
    }

    public function login_check()  
    {  
        if(isset($_SESSION['logged_in'])){
            if($_SESSION['logged_in'] == true){
                if($_SESSION['page_visit'] == false){
                    $_SESSION['page_visit'] = true;

                    redirect('time_recording');
                }else{
                    $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $log_in = base_url().'login';
                   
                    if($uri == $log_in || base_url() == $uri){
                        $_SESSION['page_visit'] = false;
                        
                        redirect('time_recording');
                    } 
                }
            }
        }else{
            if($_SESSION['page_visit'] == false){
                $_SESSION['page_visit'] = true;
                
                redirect('login');
            }else{
                $_SESSION['page_visit'] = false;
            }
        }
        
    }
}  
?>  