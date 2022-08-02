<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/department_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_DEP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/department/department_list',$data);
    }

    public function department_new()
    {
        $this->login_model->user_authentication('MASTER_DEP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
      //  echo json_encode($data['hod_lits']);die();

        $this->load->view('master/department/department',$data);
    }


    public function is_department_code_exists(){
  		try{
  			$dep_name = $this->input->post('data_value');
  			$dep_id = $this->input->post('dep_id');
  			$dep_count = $this->department_model->count_departments_from_code($dep_name,$dep_id);
  			if($dep_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Department code already exists'
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


    public function department_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$dep_id = $data['dep_id'];
  			if($dep_id > 0){ //update
  				$this->department_model->update_department($data);
  			}
  			else{ //insert
  				$dep_id = $this->department_model->add_department($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Department details saved successfully.',
  				'dep_id' => $dep_id
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


    public function department_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_DEP');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['department'] = $this->department_model->get_department($id);
        
        if($data['department'] == null || $data['department'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Department Not Found')
      );
    }
    else
      $this->load->view('master/department/department',$data);
    }


    public function get_departments()
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

          $departments = $this->department_model->get_departments($start,$length,$search,$order_column);
          $count = $this->department_model->get_departments_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $departments
          ));
      }

      public function destroy($dep_id){
        $this->department_model->destroy($dep_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Department deactivated successfully'
        ]);
      }


}
