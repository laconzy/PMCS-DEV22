<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colour extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/color_model');
    }

    public function index()
    {
    	   $this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/colour/colour_list',$data);
    }

    public function colour_new()
    {
        $this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/colour/colour',$data);
    }


    public function is_color_code_exists(){
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
  	}


    public function color_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$color_id = $data['color_id'];
  			if($color_id > 0){ //update
  				$this->color_model->update_color($data);
  			}
  			else{ //insert
  				$color_id = $this->color_model->add_color($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Color details saved successfully.',
  				'color_id' => $color_id
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


    public function color_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_COLOUR');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['color'] = $this->color_model->get_color($id);
        if($data['color'] == null || $data['color'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Color Not Found')
      );
    }
    else
      $this->load->view('master/colour/colour',$data);
    }


    public function get_colors()
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

          $colors = $this->color_model->get_colors($start,$length,$search,$order_column);
          $count = $this->color_model->get_colors_count($search);
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
