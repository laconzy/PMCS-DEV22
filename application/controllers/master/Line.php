<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Line extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/line_model');
         $this->load->model('master/site_model');
    }

    public function index()
    {
    	   $this->login_model->user_authentication('MASTER_LINE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/line/line_list',$data);
    }

    public function line_new()
    {
        $this->login_model->user_authentication('MASTER_LINE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['sites'] = $this->site_model->get_all_active();
        $this->load->view('master/line/line',$data);
    }


    public function is_line_code_exists(){
  		try{
  			$line_code = $this->input->post('data_value');
  			$line_id = $this->input->post('line_id');
  			$line_count = $this->line_model->count_lines_from_code($line_code,$line_id);
  			if($line_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Line already exists'
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


    public function line_save(){
  		try
  		{
  			/*$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/
  			$data = $this->input->post('form_data');
  			$line_id = $data['line_id'];
  			if($line_id > 0){ //update
  				$this->line_model->update_line($data);
  			}
  			else{ //insert
  				$line_id = $this->line_model->add_line($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Line details saved successfully.',
  				'line_id' => $line_id
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


    public function line_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_LINE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['sites'] = $this->site_model->get_all_active();
        $data['line'] = $this->line_model->get_line($id);
        if($data['line'] == null || $data['line'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Line Not Found')
          );
        }
        else {
          $this->load->view('master/line/line',$data);
        }
    }


    public function get_lines()
  	{
  	    /*$auth_data = $this->login_model->user_authentication_ajax(null);
          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

          $data = $_POST;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

          $lines = $this->line_model->get_lines($start,$length,$search,$order_column);
          $count = $this->line_model->get_lines_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $lines
          ));
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->line_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($line_id){
        $this->line_model->destroy($line_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Line deactivated successfully'
        ]);
      }

}
