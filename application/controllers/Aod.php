<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aod extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('aod_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('PROD_SUP_AOD'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $this->load->view('aod/aod',$data);
    }


    public function listing()
    {
    	  $this->login_model->user_authentication('PROD_SUP_AOD'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $this->load->view('aod/aod_list',$data);
    }


    public function get_pending_bundles($order_id = 0 , $operation = 0){
      echo json_encode([
        'data' => $this->aod_model->get_pending_bundles($order_id , $operation)
      ]);
    }


    public function get_added_bundles($aod_no){
      echo json_encode([
        'data' => $this->aod_model->get_added_bundles($aod_no)
      ]);
    }


    public function save(){
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

  			$data = $this->input->post('form_data');
        $aod_no = 0;
  			if($data['aod_no'] > 0){ //update
  				$this->aod_model->update($data);
          $aod_no = $data['aod_no'];
  			}
  			else{ //insert
  				$aod_no = $this->aod_model->create($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'AOD details saved successfully.',
  				'aod' => $this->aod_model->get_aod($aod_no)
  			));
  	}


    public function add_selected_barcodes(){
      $barcodes = $this->input->post('barcodes');
      $aod_no = $this->input->post('aod_no');
      $order_id = $this->input->post('order_id');
      $operation = $this->input->post('operation');
      $this->aod_model->add_selected_barcodes($order_id, $operation, $barcodes , $aod_no);
      echo json_encode([
        'status' => 'success',
        'message' => 'Bundles successfully added to aod'
      ]);
    }


    public function remove_barcodes(){
      $barcodes = $this->input->post('barcodes');
      $aod_no = $this->input->post('aod_no');
      $this->aod_model->remove_barcodes($aod_no, $barcodes);
      echo json_encode([
        'status' => 'success',
        'message' => 'Bundles successfully removed from aod'
      ]);
    }

    public function get_aod($aod_no = 0){
      echo json_encode([
        'data' => $this->aod_model->get_aod($aod_no)
      ]);

    }


    public function show($id = 0)
    {
    	  $this->login_model->user_authentication('PROD_SUP_AOD'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['aod_no'] = $id;
        $this->load->view('aod/aod',$data);
    }

    /*public function colour_new()
    {
        $this->login_model->user_authentication(null);
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $this->load->view('master/colour/colour',$data);
    }*/


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





    /*public function color_view($id = 0)
    {
        $this->login_model->user_authentication(null);
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['color'] = $this->color_model->get_color($id);
        if($data['color'] == null || $data['color'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Color Not Found')
      );
    }
    else
      $this->load->view('master/colour/colour',$data);
    }*/


    public function get_aods()
  	{
  	   /* $auth_data = $this->login_model->user_authentication_ajax(null);
          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

          $data = $_POST;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

          $aods = $this->aod_model->get_aods($start,$length,$search,$order_column);
          $count = $this->aod_model->get_aods_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $aods
          ));
      }


      public function destroy($aod_no){
        $this->aod_model->destroy($aod_no);
        echo json_encode([
          'status' => 'success',
          'message' => 'Supplier AOD deactivated successfully'
        ]);
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->color_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }

}
