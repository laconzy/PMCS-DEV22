<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/barcode_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_BARCODE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/barcode/barcode_list',$data);
    }

    public function barcode_new()
    {
        $this->login_model->user_authentication('MASTER_BARCODE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/barcode/barcode',$data);
    }


    public function is_barcode_exists(){
  		try{
  			$style = $this->input->post('style');
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $qty = $this->input->post('cartoon_qty');
        $barcode = $this->input->post('barcode');
  			$barcode_id = $this->input->post('barcode_id');

        $is_exists = $this->barcode_model->is_barcode_exists($barcode, $barcode_id);
        if($is_exists){
          echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Barcode already exists'
  				));
        }
        else {
          $barcode_count = $this->barcode_model->count_barcodes($style, $color, $size, $qty, $barcode_id);

          if($barcode_count > 0){
    				echo json_encode(array(
    					'status' => 'error',
    					'message' => 'Barcode already exists'
    				));
    			}
    			else{
    				echo json_encode(array(
    					'status' => 'success',
    					'message' => ''
    				));
    			}
        }
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error'
  			));
  		}
  	}


    public function barcode_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$barcode_id = $data['barcode_id'];
  			if($barcode_id > 0){ //update
  				$this->barcode_model->update_barcode($data);
  			}
  			else{ //insert
  				$barcode_id = $this->barcode_model->add_barcode($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'barcode saved successfully.',
  				'barcode_id' => $barcode_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'barcode_id' => 0
  			));
  		}
  	}


    public function barcode_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_BARCODE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['barcode'] = $this->barcode_model->get_barcode($id);
        if($data['barcode'] == null || $data['barcode'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Barcode Not Found')
      );
    }
    else
      $this->load->view('master/barcode/barcode',$data);
    }


    public function get_barcodes()
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

          $colors = $this->barcode_model->get_barcodes($start,$length,$search,$order_column);
          $count = $this->barcode_model->get_barcodes_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $colors
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->barcode_model->search($search_term);
        echo json_encode([
          'results' => $data
        ]);
      }


      public function destroy($barcode_id){
        $this->barcode_model->destroy($barcode_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Barcode deactivated successfully'
        ]);
      }


      public function get_barcode($barcode_id){
        $data = $this->barcode_model->get_barcode_full_data($barcode_id);
        echo json_encode([
          'data' => $data
        ]);
      }

}
