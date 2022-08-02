<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model(['contract_model' , 'master/supplier_model']);
    }

    public function index()
    {
    	  $this->login_model->user_authentication('PROD_SUP_CON'); // user permission authentication
        $data = [
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_PRODUCTION',
          'suppliers' => $this->supplier_model->get_all(),
          'emb_types' => $this->contract_model->get_emb_types()
        ];
        $this->load->view('contract/contract',$data);
    }


    public function listing()
    {
    	  $this->login_model->user_authentication('PROD_SUP_CON'); // user permission authentication
        $data = [
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_PRODUCTION',
        ];
        $this->load->view('contract/contract_list',$data);
    }


    public function show($id = 0)
    {
        $this->login_model->user_authentication('PROD_SUP_CON'); // user permission authentication
        $data = [
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_PRODUCTION',
          'suppliers' => $this->supplier_model->get_all(),
          'emb_types' => $this->contract_model->get_emb_types(),
          'contract_no' => $id
        ];
        $this->load->view('contract/contract',$data);
    }



    public function get_order_item_components($order_id){
      echo json_encode([
        'data' => $this->contract_model->get_order_item_components($order_id)
      ]);
    }


    public function get_order_summery($order_id){
      echo json_encode([
        'data' => $this->contract_model->get_order_size_wise_summery($order_id)
      ]);
    }


    public function save(){
      $data = $this->input->post('data');
      $details = $this->input->post('details');
      $contract_no = $this->contract_model->create($data , $details);
      echo json_encode([
        'status' => 'success',
        'message' => 'Contract details saved successfully',
        'contract_no' => $contract_no
      ]);
    }


    public function get_list()
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

          $colors = $this->contract_model->get_list($start,$length,$search,$order_column);
          $count = $this->contract_model->get_list_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $colors
          ));
      }


      public function get_order_contracts($order_id = 0){
        echo json_encode([
          'data' => $this->contract_model->get_order_contracts($order_id)
        ]);
      }


      public function get_contract($contract_no = 0){
        echo json_encode([
          'data' => $this->contract_model->get($contract_no)
        ]);
      }


      public function print_contract($contract_no,$order_id){
        $data = [
          'contract' => $this->contract_model->get($contract_no),
          'contract_details' => $this->contract_model->get_contract_item_details($order_id,$contract_no)
        ];
        $this->load->view('contract/contract_report',$data);
      }


    /*public function colour_new()
    {
        $this->login_model->user_authentication(null);
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $this->load->view('master/colour/colour',$data);
    }*/


    /*public function is_color_code_exists(){
  		try{
  			$color_code = $this->input->post('data_value');
  			$color_id = $this->input->post('color_id');
  			$color_count = $this->color_model->count_colors_from_code($color_code,$color_id);
  			if($color_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Color code already exists'
  				));
  			}
  			else{
  				echo json_encode(array(
  					'status' => 'success',
  					'message' => ''
  				));
  			}
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error'
  			));
  		}
  	}*/


  /*  public function color_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$color_id = $data['color_id'];
  			if($color_id > 0){ //update
  				$this->color_model->update_color($data);
  			}
  			else{ //insert
  				$color_id = $this->color_model->add_color($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Color details saved successfully.',
  				'color_id' => $color_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'color_id' => 0
  			));
  		}
  	}*/




    /*public function get_colors()
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

          $colors = $this->color_model->get_colors($start,$length,$search,$order_column);
          $count = $this->color_model->get_colors_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $colors
          ));
      }*/


      /*public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->color_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }*/

}
