<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gatepass extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
         $this->load->model('gatepass_model');
    }

    public function index()
    {
    	  // $this->login_model->user_authentication(null); // user permission authentication
        // $data = array();
        // $data['menus'] = $this->login_model->get_authorized_menus();
        // $data['menu_code'] = 'MENU_PRODUCTION';
        // $data['gp_no'] = 0;
        // $this->load->view('gatepass/gatepass',$data);
    }


    public function manual_gatepass()
    {
      $this->load->model('master/site_model');
      $this->login_model->user_authentication(null); // user permission authentication
      $data = array();
      $data['menus'] = $this->login_model->get_authorized_menus();
      $data['menu_code'] = 'MENU_GATEPASS';
      $data['sites'] = $this->site_model->get_all_active();
      $data['user_site'] = $this->session->userdata('site');
      $data['current_date'] = date("Y-m-d");
      $this->load->view('gatepass/manual_gatepass',$data);
    }


    public function manual_gatepass_view($id = 0)
    {
      $this->load->model('master/site_model');
      $this->load->model('approval_proc_model');
      $this->login_model->user_authentication(null); // user permission authentication
      $data = array();
      $data['menus'] = $this->login_model->get_authorized_menus();
      $data['menu_code'] = 'MENU_GATEPASS';
      $data['sites'] = $this->site_model->get_all_active();
      $gp = $this->gatepass_model->get_manual_gp($id);
      $data['gp'] = $gp;
      //$data['items'] = $this->gatepass_model->get_manula_gp_items($id);
      $data['user_site'] = $gp['site'];
      $data['current_date'] = date("Y-m-d");

      $approval_data = [];
      if($gp['proc_inst_id'] != null){

        $approval_data = $this->approval_proc_model->get_authorization_details($gp['proc_inst_id']);
      }

      $data['approval_data'] = $approval_data;

      $this->load->view('gatepass/manual_gatepass',$data);
    }



    public function save_manual_gatepass(){
        $data = $this->input->post('form_data');
        $id = 0;
        if($data['id'] > 0){ //update
          //nedd to check change of gatepass type
          $items = null;
          if($data['type'] == 'laysheet transfer'){
            $items = $this->gatepass_model->get_manula_gp_items($data['id']);
          }
          else {
            $items = $this->gatepass_model->get_manula_gp_laysheets($data['id']);
          }

          if($items != null && sizeof($items) > 0){
            echo json_encode(array(
              'status' => 'error',
              'message' => 'Cannot change gate pass type. remove previous items to change type.'
            ));
            return;
          }

          $this->gatepass_model->update_manual_gp($data);
          $id = $data['id'];
        }
        else{ //insert
          $id = $this->gatepass_model->create_manual_gp($data);
        }
        echo json_encode(array(
          'status' => 'success',
          'message' => 'Gate pass saved successfully.',
          'gp' => $this->gatepass_model->get_manual_gp($id)
        ));
    }


    public function save_manual_gp_item(){
      $data = $this->input->post('item');

      if($data['id'] > 0){
        $this->gatepass_model->update_manual_gp_item($data);
      }
      else {
        $id = $this->gatepass_model->add_manual_gp_item($data);
      }

      echo json_encode([
        'status' => 'success',
        'message' => 'Item added successfully',
        'items' => $this->gatepass_model->get_manula_gp_items($data['header_id'])
      ]);
    }


    public function get_manual_gp_items(){
      $header_id = $this->input->get('header_id');
      $items = $this->gatepass_model->get_manula_gp_items($header_id);
      echo json_encode([
        'items' => $items
      ]);
    }


    public function delete_manual_gp_item(){
      $item_id = $this->input->post('item_id');
      $header_id = $this->input->post('header_id');
      $this->gatepass_model->delete_manual_gp_item($item_id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Item removed successfully',
        'items' => $this->gatepass_model->get_manula_gp_items($header_id)
      ]);
    }


    public function print_manual_gp($id = 0)
    {
      $this->load->model('master/site_model');
      $this->load->model('approval_proc_model');
      $this->login_model->user_authentication(null); // user permission authentication
      $data = array();
      $gp = $this->gatepass_model->get_manual_gp($id);
      $data['gp'] = $gp;
      if($gp['type'] == 'laysheet transfer'){
        $data['laysheets'] = $this->gatepass_model->get_manula_gp_laysheets($id);
      }
      else {
        $data['items'] = $this->gatepass_model->get_manula_gp_items($id);
      }

      $data['current_date'] = date("Y-m-d");
      $approval_data = [];
      if($gp['proc_inst_id'] != null){
        $approval_data = $this->approval_proc_model->get_authorization_details($gp['proc_inst_id']);
      }
  		$data['approval_data'] = $approval_data;

      $this->load->view('gatepass/manual_gatepass_print',$data);
    }


    public function manual_gatepass_list()
    {
    	  $this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_GATEPASS';
        $this->load->view('gatepass/manual_gatepass_list',$data);
    }


    public function get_manual_gp_list()
  	{
  	    $auth_data = $this->login_model->user_authentication_ajax(null);
          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

          $data = $_POST;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

          $list = $this->gatepass_model->get_manual_gp_list($start,$length,$search,$order_column);
          $count = $this->gatepass_model->get_manual_gp_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $list
          ));
      }


      public function save_manual_gp_laysheet(){
        $data = $this->input->post('laysheet');
        //check for valida laysheet numbers
        $ls_data = $this->gatepass_model->get_laysheet_details($data['laysheet_no']);
        //echo json_encode(  $ls_data);die();
        if($ls_data == null){
          echo json_encode([
            'status' => 'error',
            'message' => 'Incorrect laysheet no'
          ]);
          return;
        }

        if($data['id'] > 0){
          $this->gatepass_model->update_manual_gp_laysheet($data);
        }
        else {
          $id = $this->gatepass_model->add_manual_gp_laysheet($data);
        }

        echo json_encode([
          'status' => 'success',
          'message' => 'Laysheet added successfully',
          'laysheets' => $this->gatepass_model->get_manula_gp_laysheets($data['header_id'])
        ]);
      }


      public function get_manual_gp_laysheets(){
        $header_id = $this->input->get('header_id');
        $laysheets = $this->gatepass_model->get_manula_gp_laysheets($header_id);
        echo json_encode([
          'laysheets' => $laysheets
        ]);
      }


      public function delete_manual_gp_laysheet(){
        $item_id = $this->input->post('item_id');
        $header_id = $this->input->post('header_id');
        $this->gatepass_model->delete_manual_gp_item($item_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Item removed successfully',
          'laysheets' => $this->gatepass_model->get_manula_gp_laysheets($header_id)
        ]);
      }


      public function receive_manual_gp(){
        $id = $this->input->post('id');
        $this->gatepass_model->receive_manual_gp($id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Gate pass received successfully'
        ]);
      }
}
