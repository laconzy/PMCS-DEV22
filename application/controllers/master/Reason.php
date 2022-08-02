<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reason extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/reason_model');
    }

    public function index()
    {
    	   $this->login_model->user_authentication('MASTER_REASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/reason/reason_list',$data);
    }

    public function reason_new()
    {
        $this->login_model->user_authentication('MASTER_REASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['categories'] = $this->reason_model->get_all_categories();
        $this->load->view('master/reason/reason',$data);
    }


    // public function is_reason_exists(){
  	// 	try{
  	// 		$color_code = $this->input->post('data_value');
  	// 		$color_id = $this->input->post('color_id');
  	// 		$color_count = $this->color_model->count_colors_from_code($color_code,$color_id);
  	// 		if($color_count > 0){
  	// 			echo json_encode(array(
  	// 				'status' => 'error',
  	// 				'message' => 'Color code already exists'
  	// 			));
  	// 		}
  	// 		else{
  	// 			echo json_encode(array(
  	// 				'status' => 'success',
  	// 				'message' => ''
  	// 			));
  	// 		}
  	// 	}
  	// 	catch(Exception $e){
  	// 		echo json_encode(array(
  	// 			'status' => 'error',
  	// 			'message' => 'System process error'
  	// 		));
  	// 	}
  	// }


    public function reason_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$reason_id = $data['reason_id'];
  			if($reason_id > 0){ //update
  				$this->reason_model->update_reason($data);
  			}
  			else{ //insert
  				$reason_id = $this->reason_model->add_reason($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Reason details saved successfully.',
  				'reason_id' => $reason_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'reason_id' => 0
  			));
  		}
  	}


    public function reason_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_REASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['reason'] = $this->reason_model->get_reason($id);
        $data['categories'] = $this->reason_model->get_all_categories();
        if($data['reason'] == null || $data['reason'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Reason Not Found')
      );
    }
    else
      $this->load->view('master/reason/reason',$data);
    }


    public function get_reasons()
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

          $reasons = $this->reason_model->get_reasons($start,$length,$search,$order_column);
          $count = $this->reason_model->get_reasons_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $reasons
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->reason_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($reason_id){
        $this->reason_model->destroy($reason_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Reason deactivated successfully'
        ]);
      }

}
