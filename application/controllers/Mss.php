<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Mss extends CI_Controller {



    public function __construct()

    {

         parent::__construct();

         $this->load->model('login_model');

		     $this->load->model('report_model');

         $this->load->model('master/operation_model');

         $this->load->model('master/customer_model');

         $this->load->model('master/style_model');
         $this->load->model('master/line_model');
         $this->load->model('report/mss_model');

    }




      public function mss()

    {

        $this->login_model->user_authentication(null);

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['order'] = $this->mss_model->load_order_data();
//print_r($data);
        $this->load->view('reports/mss',$data);

    }

    // publoc function get_shipment_data(){

    //     $this->mss_model->shipment_data();

    
    // }




}