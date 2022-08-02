<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
    
    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
    }
    
    public function index()
    {
        $this->login_model->user_authentication(null);
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $this->load->view('home/dashboard',$data);
    }
       
}