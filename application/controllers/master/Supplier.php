<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/supplier_model');
    }

    public function index()
    {
        $this->login_model->user_authentication('MASTER_SUP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/supplier/index',$data);
    }

    public function listing()
    {
    	  $this->login_model->user_authentication('MASTER_SUP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/supplier/supplier_list',$data);
    }


    public function is_exists(){
  		try{
  			$supplier_code = $this->input->post('data_value');
  			$supplier_id = $this->input->post('supplier_id');
  			$supplier_count = $this->supplier_model->count_supplier_from_code($supplier_code,$supplier_id);
  			if($supplier_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Supplier code already exists'
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
  	}


    public function save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$supplier_id = $data['supplier_id'];
  			if($supplier_id > 0){ //update
  				$this->supplier_model->update($data);
  			}
  			else{ //insert
  				$supplier_id = $this->supplier_model->create($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Supplier details saved successfully.',
  				'supplier_id' => $supplier_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'style_id' => 0
  			));
  		}
  	}


    public function show($id = 0)
    {
        $this->login_model->user_authentication('MASTER_SUP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['supplier'] = $this->supplier_model->get($id);
        if($data['supplier'] == null || $data['supplier'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Supplier Not Found')
      );
    }
    else
      $this->load->view('master/supplier/index',$data);
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

          $supplier = $this->supplier_model->get_list($start,$length,$search,$order_column);
          $count = $this->supplier_model->get_list_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $supplier
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->style_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($sup_id){
        $this->supplier_model->destroy($sup_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Supplier deactivated successfully'
        ]);
      }

}
