<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {
    
    public function __construct()
    {
         parent::__construct();
//         $this->load->model('login_model');         
//         $status = $this->login_model->user_authentication();
//         if($status != true)
//             redirect('login');
    }
    
    
    public function forgot_password(){
        $this->load->view('login/forgot_password');
    }
    
}