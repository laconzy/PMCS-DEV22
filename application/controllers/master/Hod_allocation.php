<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hod_Allocation extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/hod_allocation_model');
         $this->load->model('master/site_model');
         $this->load->model('master/department_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/hod_allocation/hod_allocation_list',$data);
    }

    public function hod_allocation_new()
    {
        $this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['sites'] = $this->site_model->get_all_active();
        $data['departments'] = $this->department_model->get_all();
        $this->load->view('master/hod_allocation/hod_allocation',$data);
    }


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


    public function allocate_hod(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$id = $data['id'];

  			if($id > 0){ //update
          $prev_data = $this->hod_allocation_model->get_allocation_from_site_and_department($data['site_id'], $data['department_id']);
          if($prev_data != null && $prev_data['id'] != $id){
            echo json_encode([
      				'status' => 'error',
      				'message' => 'HOD Allocation already avaliable for this site and department',
      				'id' => 0
      			]);
            return;
          }

  				$this->hod_allocation_model->update_allocation($data);
  			}
  			else{ //insert
          $prev_data = $this->hod_allocation_model->get_allocation_from_site_and_department($data['site_id'], $data['department_id']);
          if($prev_data != null){
            echo json_encode([
      				'status' => 'error',
      				'message' => 'HOD Allocation already avaliable for this site and department',
      				'id' => 0
      			]);
            return;
          }
  				$id = $this->hod_allocation_model->add_allocation($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Allocation details saved successfully.',
  				'id' => $id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'id' => 0
  			));
  		}
  	}


    public function hod_allocation_view($id = 0)
    {
        $this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['sites'] = $this->site_model->get_all_active();
        $data['departments'] = $this->department_model->get_all();

        $data['allocation'] = $this->hod_allocation_model->get_allocation($id);
        if($data['allocation'] == null || $data['allocation'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Allocation Not Found')
      );
    }
    else
      $this->load->view('master/hod_allocation/hod_allocation',$data);
    }


    public function get_allocations()
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

          $list = $this->hod_allocation_model->get_allocations($start,$length,$search,$order_column);
          $count = $this->hod_allocation_model->get_allocations_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $list
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->color_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($color_id){
        $this->color_model->destroy($color_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Colour deactivated successfully'
        ]);
      }

}
