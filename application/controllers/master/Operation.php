<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operation extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/operation_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_OPERATION');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/operation/operation_list',$data);
    }

    public function operation_new()
    {
        $this->login_model->user_authentication('MASTER_OPERATION');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/operation/operation',$data);
    }


    public function is_operation_code_exists(){
  		try{
  			$operation_name = $this->input->post('data_value');
  			$operation_id = $this->input->post('operation_id');
  			$operation_count = $this->operation_model->count_operations_from_code($operation_name,$operation_id);
  			if($operation_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Operation name already exists'
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


    public function operation_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$operation_id = $data['operation_id'];
  			if($operation_id > 0){ //update
  				$this->operation_model->update_operation($data);
  			}
  			else{ //insert
  				$operation_id = $this->operation_model->add_operation($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Operation details saved successfully.',
  				'operation_id' => $operation_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'operation_id' => 0
  			));
  		}
  	}


    public function operation_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_OPERATION');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['operation'] = $this->operation_model->get_operation($id);
        if($data['operation'] == null || $data['operation'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Operation Not Found')
      );
    }
    else
      $this->load->view('master/operation/operation',$data);
    }


    public function get_operations()
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

          $operations = $this->operation_model->get_operations($start,$length,$search,$order_column);
          $count = $this->operation_model->get_operations_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $operations
          ));
      }


      public function get($id){
        echo json_encode([
          'data' => $this->operation_model->get_operation($id)
        ]);
      }


      public function destroy($operation_id){
        $this->operation_model->destroy($operation_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Operation deactivated successfully'
        ]);
      }
	
}
