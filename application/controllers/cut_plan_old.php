<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cut_plan extends CI_Controller {

    public function __construct()
    {
     parent::__construct();
     $this->load->model('user_model');
     $this->load->model('user_level_model');
     $this->load->model('login_model');
     $this->load->model('cut_plan_model');
     $this->load->helper(array('form', 'url'));      

 }

 public function index()
 { 
           
        $this->load->model('permission_group_model');
        $user_levels = $this->user_level_model->get_all_user_levels();
        $departments = $this->user_model->get_departments();
        $data = array('user_levels' => $user_levels , 'departments' => $departments);
        $data['id'] = 0;
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
        // DtX - 
        // $data['dtx_designation'] = $this->permission_group_model->get_all_designations();
        // $data['dtx_staff_category'] = $this->permission_group_model->get_all_staff_category();
        $data['hela_location'] = $this->permission_group_model ->hela_location_load();
        $date['prod_ordrer_date'] =$this->cut_plan_model->get_order_detail();
        $data['USER_ADD'] = true;
        $data['USER_EDIT'] = false;
        $this->load->view('cutting/cut_plan',$data);
    }
    public function get_cutplan_data(){

        $data['head']=$this->cut_plan_model->get_order_head();
        $data['detail']=$this->cut_plan_model->get_order_detail();
      //  echo json_encode($data);

          echo json_encode(array(
            "status" => 'sucess',
             "data" => $data
        ));

    }
    public function prod_ord_details(){

        $data['detail']=$this->cut_plan_model->get_product_head_details();
        $data['size_data']=$this->cut_plan_model->get_product_size_data();
        echo json_encode(array(
            "status" => 'sucess',
             "data" => $data
        ));
    }

    
}