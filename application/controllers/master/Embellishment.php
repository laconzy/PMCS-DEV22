<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Embellishment extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/embellishment_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_EMB');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/embellishment/embellishment_list',$data);
    }

    public function embellishment_new()
    {
        $this->login_model->user_authentication('MASTER_EMB');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/embellishment/embellishment',$data);
    }


    public function is_embellishment_type_exists(){
  		try{
  			$emb_name = $this->input->post('data_value');
  			$emb_id = $this->input->post('emb_id');
  			$emb_count = $this->embellishment_model->count_embellishments_from_name($emb_name,$emb_id);
  			if($emb_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Embellishment type already exists'
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


    public function embellishment_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$emb_id = $data['emb_id'];
  			if($emb_id > 0){ //update
  				$this->embellishment_model->update_embellishment($data);
  			}
  			else{ //insert
  				$emb_id = $this->embellishment_model->add_embellishment($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Embellishment type details saved successfully.',
  				'emb_id' => $emb_id
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


    public function embellishment_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_EMB');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['embellishment'] = $this->embellishment_model->get_embellishment($id);
        if($data['embellishment'] == null || $data['embellishment'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Embellishment Not Found')
      );
    }
    else
      $this->load->view('master/embellishment/embellishment',$data);
    }


    public function get_embellishments()
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

          $embellishments = $this->embellishment_model->get_embellishments($start,$length,$search,$order_column);
          $count = $this->embellishment_model->get_embellishments_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $embellishments
          ));
      }


      public function get($id){
        echo json_encode([
          'data' => $this->embellishment_model->get_embellishment($id)
        ]);
      }


      public function destroy($emb_id){
        $this->embellishment_model->destroy($emb_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Embellishment deactivated successfully'
        ]);
      }

}
