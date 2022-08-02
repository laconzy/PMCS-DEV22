<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/component_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_COM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/component/component_list',$data);
    }

    public function component_new()
    {
        $this->login_model->user_authentication('MASTER_COM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/component/component',$data);
    }


    public function is_component_code_exists(){
  		try{
  			$component_code = $this->input->post('data_value');
  			$component_id = $this->input->post('com_id');
  			$component_count = $this->component_model->count_component_from_code($component_code,$component_id);
  			if($component_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Component code already exists'
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


    public function component_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$component_id = $data['com_id'];
  			if($component_id > 0){ //update
  				$this->component_model->update_component($data);
  			}
  			else{ //insert
  				$component_id = $this->component_model->add_component($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'component details saved successfully.',
  				'component_id' => $component_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'component_id' => 0
  			));
  		}
  	}


    public function component_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_COM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['component'] = $this->component_model->get_component($id);
        if($data['component'] == null || $data['component'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Component Not Found')
      );
    }
    else
      $this->load->view('master/component/component',$data);
    }


    public function get_component()
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

          $components = $this->component_model->get_components($start,$length,$search,$order_column);
          $count = $this->component_model->get_components_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $components
          ));
      }

      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->component_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($com_id){
        $this->component_model->destroy($com_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Component deactivated successfully'
        ]);
      }


}
