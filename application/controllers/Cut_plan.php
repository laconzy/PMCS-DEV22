<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cut_plan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('user_level_model');
        $this->load->model('login_model');
        $this->load->model('cut_plan_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {

        $this->load->model('permission_group_model');
        $user_levels = $this->user_level_model->get_all_user_levels();
        //$departments = $this->user_model->get_departments();
      $data = array(/*'user_levels' => $user_levels, 'departments' => $departments*/);
        $data['id'] = 0;
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_CAD';
        $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
        // DtX -
        // $data['dtx_designation'] = $this->permission_group_model->get_all_designations();
        // $data['dtx_staff_category'] = $this->permission_group_model->get_all_staff_category();
        $data['hela_location'] = $this->permission_group_model->hela_location_load();
        $date['prod_ordrer_date'] = $this->cut_plan_model->get_order_detail();
        $data['USER_ADD'] = true;
        $data['USER_EDIT'] = false;
        $this->load->view('cutting/cut_plan', $data);
    }

    public function get_cutplan_data() {

        $data['head'] = $this->cut_plan_model->get_order_head();
        $data['detail'] = $this->cut_plan_model->get_order_detail();
        //  echo json_encode($data);

        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }

    public function load_cut_plan() {
        $data['detail'] = $this->cut_plan_model->get_cut_plan();
        $data['size_data'] = $this->cut_plan_model->get_cut_no();
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }

    public function lay_sheet() {
        $this->load->model('permission_group_model');
        $user_levels = $this->user_level_model->get_all_user_levels();
        /*$departments = $this->user_model->get_departments();*/
      $data = array(/*'user_levels' => $user_levels, 'departments' => $departments*/);
        $data['id'] = 0;
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_CAD';
        $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
        // DtX -
        // $data['dtx_designation'] = $this->permission_group_model->get_all_designations();
        // $data['dtx_staff_category'] = $this->permission_group_model->get_all_staff_category();
        $data['hela_location'] = $this->permission_group_model->hela_location_load();
        $date['prod_ordrer_date'] = $this->cut_plan_model->get_order_detail();
        $data['USER_ADD'] = true;
        $data['USER_EDIT'] = false;
        $this->load->view('cutting/lay_sheet', $data);
    }
    public function print_lay_sheet(){

          $lay_sheet_no=0;
          $count =$this->cut_plan_model->laysheetcont();

          if($count>0){
        $lay_sheet_no=$this->cut_plan_model->get_laysheet();
          }else{
             $lay_sheet_no = $this->cut_plan_model->create_lay_sheet();
          }
          echo json_encode(array(
           // "status" => 'sucess',
            "lay_sheet" => $lay_sheet_no
        ));

   // $date['laysheet_data'] = $this->cut_plan_model->create_lay_sheet();

    }

    public function print_laysheet($id=0) {
          $this->load->model('permission_group_model');
        // $user_levels = $this->user_level_model->get_all_user_levels();
        // $departments = $this->user_model->get_departments();
        // $data = array('user_levels' => $user_levels, 'departments' => $departments);
        // $data['id'] = 0;
        // $data['menus'] = $this->login_model->get_authorized_menus();
        // $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
        // // DtX -
        // // $data['dtx_designation'] = $this->permission_group_model->get_all_designations();
        // // $data['dtx_staff_category'] = $this->permission_group_model->get_all_staff_category();
        // $data['hela_location'] = $this->permission_group_model->hela_location_load();
        //$date['prod_ordrer_date'] = $this->cut_plan_model->get_order_detail();

          $id=$id;



          $data['record']=$this->cut_plan_model->get_lay_sheet_data($id);
          $data['ratio']=$this->cut_plan_model->cutplan_ratio($id);
        $data['USER_ADD'] = true;
        $data['USER_EDIT'] = false;
        $this->load->view('cutting/lay_sheet_print', $data);
    }

    public function prod_ord_details() {

        $data['detail'] = $this->cut_plan_model->get_product_head_details();
        $data['size_data'] = $this->cut_plan_model->get_product_size_data();
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }
	
	
	public function load_saved_cut_plans() {

        $data['load_cut_list'] = $this->cut_plan_model->get_saved_cp_list();
        
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }
	
	public function load_save_cut_plan_ratio() {
		
		 $data = $this->cut_plan_model->load_save_cut_plan_ratio();
        
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
		
		
	}
	
	
	

    public function save_cut_plan_ratio() {

        $data = $this->cut_plan_model->save_cut_plan_ratio();
        //$data['size_data']=$this->cut_plan_model->get_product_size_data();
        // $data=$this->cut_plan_model->save_cut_plan_detail();
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }
	
	 public function load_cut_plan_no() {

        $data = $this->cut_plan_model->load_cut_plan_no();
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }

    public function load_updated_qty() {

        $data['size_qty'] = $this->cut_plan_model->get_product_size_data();
        echo json_encode(array(
            "status" => 'sucess',
            "data" => $data
        ));
    }


    public function listing(){
    //  $this->login_model->user_authentication('PROD_EMB_GRN'); // user permission authentication
      $data = array();
      $data['menus'] = $this->login_model->get_authorized_menus();
      $data['menu_code'] = 'MENU_CAD';
      $this->load->view('cutting/cut_plan_list',$data);
    }



    public function get_cut_plans()
    {
       /* $auth_data = $this->login_model->user_authentication_ajax(null);
          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

          $data = $_POST;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

          $cut_plans = $this->cut_plan_model->get_cut_plans($start,$length,$search,$order_column);
          $count = $this->cut_plan_model->get_cut_plans_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $cut_plans
          ));
      }


      public function destroy($plan_id){
        $res = $this->cut_plan_model->can_delete_cut_plan($plan_id);
        if($res == false){
          echo json_encode([
            'status' => 'error',
            'message' => 'Cannot delete cut plan. Already bundled.'
          ]);
        }
        else{
          $this->cut_plan_model->destroy($plan_id);
          echo json_encode([
            'status' => 'success',
            'message' => 'Cut plan removed successfully.'
          ]);
        }        
      }
	  
	  
	   public function destroy_cut_no($cp_detail_id){
        $res = $this->cut_plan_model->can_delete_cut_plan_detail_line($cp_detail_id);
        if($res == false){
          echo json_encode([
            'status' => 'error',
            'message' => 'Cannot delete cut plan line. Already bundled.'
          ]);
        }
        else{
          $this->cut_plan_model->destroy_cp_detail_id($cp_detail_id);
          echo json_encode([
            'status' => 'success',
            'message' => 'Cut plan removed successfully.'
          ]);
        }        
      }


      public function cut_plan_view($cut_plan_id)
    {
       $data = array();
       $data['cut_plan_id'] = $cut_plan_id;
       $data['cut_plan_size_count'] = $this->cut_plan_model->get_cut_plan_size_count($cut_plan_id); 
       $data['cut_plan_size'] = $this->cut_plan_model->get_cut_plan_size($cut_plan_id);
       $data['cut_plan_details'] = $this->cut_plan_model->get_cut_plan_details($cut_plan_id,$data['cut_plan_size']);
      // echo json_encode($data['cut_plan_details'] );
       $this->load->view('cutting/view_cut_plan',$data);
    }


}
