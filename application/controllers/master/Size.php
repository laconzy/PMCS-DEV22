<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Size extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/size_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_SIZE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/size/size_list',$data);
    }

    public function size_new()
    {
        $this->login_model->user_authentication('MASTER_SIZE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/size/size',$data);
    }


    public function is_size_code_exists(){
  		try{
  			$size_code = $this->input->post('data_value');
  			$size_id = $this->input->post('size_id');
  			$size_count = $this->size_model->count_sizes_from_code($size_code,$size_id);
  			if($size_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Size code already exists'
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


    public function size_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$size_id = $data['size_id'];
  			if($size_id > 0){ //update
  				$this->size_model->update_size($data);
  			}
  			else{ //insert
  				$size_id = $this->size_model->add_size($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Size details saved successfully.',
  				'size_id' => $size_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'size_id' => 0
  			));
  		}
  	}


    public function size_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_SIZE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['size'] = $this->size_model->get_size($id);
        if($data['size'] == null || $data['size'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Size Not Found')
      );
    }
    else
      $this->load->view('master/size/size',$data);
    }


    public function get_sizes()
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

          $size = $this->size_model->get_sizes($start,$length,$search,$order_column);
          $count = $this->size_model->get_sizes_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $size
          ));
      }

      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->size_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($size_id){
        $this->size_model->destroy($size_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Size deactivated successfully'
        ]);
      }

}
