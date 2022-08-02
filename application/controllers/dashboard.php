<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class dashboard extends CI_Controller {



    public function __construct()

    {

         parent::__construct();

         $this->load->model('login_model');

		     $this->load->model('master/color_model');

             $this->load->model('dashboard/order_model');
             $this->load->model('dashboard/dash_model');

    }



    public function index()

    {

      //  echo 1212;

    	   $this->login_model->user_authentication('MASTER_COLOUR');//check permission

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_MASTER';

        $this->load->view('dashboard/line_dash',$data);

    }



    public function production_dashboard()  {
        //$this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        //$data['menus'] = $this->login_model->get_authorized_menus();
        //$data['menu_code'] = 'MENU_MASTER';
        $this->load->view('dashboard/production_dash',$data);
    }

    public function production_dashboard_A()  {
        //$this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        //$data['menus'] = $this->login_model->get_authorized_menus();
        //$data['menu_code'] = 'MENU_MASTER';
        $this->load->view('dashboard/production_dash_a',$data);
    }


     public function production_data()

    {
        //$this->login_model->user_authentication('MASTER_COLOUR');//check permission

        $data = array();
        $building = $this->input->get('building');

       // $data['menus'] = $this->login_model->get_authorized_menus();
         $data = $this->dash_model->get_production_detail($building);
         $max_hour = $this->dash_model->get_max_hour();

        echo json_encode(array(
            'data' => $data,
            'max_hour' => $max_hour
        ));

    }





}
