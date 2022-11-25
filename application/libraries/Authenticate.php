<?php

class Authenticate{

    public function is_session_exists(){
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
            if($_SESSION['is_log_in'] == true){
                redirect('employee');
            }else{
                // redirect('auth/form');
            }
        }else{
            redirect('auth/form');
        }
    }
}

?>