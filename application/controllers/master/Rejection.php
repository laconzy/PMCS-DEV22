<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rejection extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/rejection_type_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_REJ');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/rejection/rejection_list',$data);
    }

    public function rejection_new()
    {
        $this->login_model->user_authentication('MASTER_EMB');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/rejection/rejection',$data);
    }


    public function is_rejection_type_exists(){
  		try{
  			$rej_name = $this->input->post('data_value');
  			$id = $this->input->post('id');
  			$rej_count = $this->rejection_type_model->count_rejections_from_name($rej_name,$id);
  			if($rej_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Rejection type already exists'
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


    public function rejection_save(){
  		try
  		{
  			/*$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/
  			$data = $this->input->post('form_data');
  			$id = $data['id'];
  			if($id > 0){ //update
  				$this->rejection_type_model->update_rejection($data);
  			}
  			else{ //insert
  				$id = $this->rejection_type_model->add_rejection($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Rejection type details saved successfully.',
  				'id' => $id
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


    public function rejection_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_EMB');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['rejection'] = $this->rejection_type_model->get_rejection($id);
        if($data['rejection'] == null || $data['rejection'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Rejection Type Not Found')
      );
    }
    else
      $this->load->view('master/rejection/rejection',$data);
    }


    public function get_rejections()
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

          $rejections = $this->rejection_type_model->get_rejections($start,$length,$search,$order_column);
          $count = $this->rejection_type_model->get_rejections_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $rejections
          ));
      }


      public function get($id){
        echo json_encode([
          'data' => $this->rejection_type_model->get_rejection($id)
        ]);
      }


      public function destroy($id){
        $this->rejection_type_model->destroy($id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Rejection type deactivated successfully'
        ]);
      }

}
