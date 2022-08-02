<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/designation_model');
    }

    public function index()
    {
      	$this->login_model->user_authentication('MASTER_DESG');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/designation/designation_list',$data);
    }

    public function designation_new()
    {
        $this->login_model->user_authentication('MASTER_DESG');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/designation/designation',$data);
    }


    public function is_designation_exists(){
  		try{
  			$designation = $this->input->post('data_value');
  			$des_id = $this->input->post('des_id');
  			$des_count = $this->designation_model->count_designation_from_code($designation,$des_id);
  			if($des_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Descignation name already exists'
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


    public function designation_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$des_id = $data['des_id'];
  			if($des_id > 0){ //update
  				$this->designation_model->update_designation($data);
  			}
  			else{ //insert
  				$des_id = $this->designation_model->add_designation($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Designation details saved successfully.',
  				'des_id' => $des_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'color_id' => 0
  			));
  		}
  	}


    public function designation_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_DESG');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['designation'] = $this->designation_model->get_designation($id);
        if($data['designation'] == null || $data['designation'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Designation Not Found')
      );
    }
    else
      $this->load->view('master/designation/designation',$data);
    }


    public function get_designations()
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

          $designations = $this->designation_model->get_designations($start,$length,$search,$order_column);
          $count = $this->designation_model->get_designations_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $designations
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->designation_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($des_id){
        $this->designation_model->destroy($des_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Designation deactivated successfully'
        ]);
      }

}
