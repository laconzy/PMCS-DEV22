<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Inventory extends CI_Controller {


     public function __construct()

    {

         parent::__construct();

         $this->load->model('login_model');

		     $this->load->model('master/color_model');
         $this->load->model('cutting/bundle_model');
         $this->load->model('fg/fg_model');

         $this->load->model(['production/production_model', 'master/line_model']);
         $this->load->model('inventory/inventory');
    }



    public function index()

    {

    	   $this->login_model->user_authentication('MASTER_COLOUR');//check permission

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_MASTER';
             get_cut_plan();

        $this->load->view('inventory/inventory',$data);

    }

     


}
