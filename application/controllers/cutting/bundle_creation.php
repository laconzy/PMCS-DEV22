<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bundle_creation extends CI_Controller {



    public function __construct()

    {

         parent::__construct();

         $this->load->model('login_model');

		     $this->load->model('master/color_model');

    }
    public function index()

    {

    	   $this->login_model->user_authentication('MASTER_COLOUR');//check permission

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_MASTER';

        $this->load->view('master/colour/colour_list',$data);

    }
}