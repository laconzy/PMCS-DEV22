<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/season_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_SEASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/season/season_list',$data);
    }

    public function season_new()
    {
        $this->login_model->user_authentication('MASTER_SEASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/season/season',$data);
    }


    public function is_season_code_exists(){
  		try{
  			$season_name = $this->input->post('data_value');
  			$season_id = $this->input->post('season_id');
  			$season_count = $this->season_model->count_seasons_from_code($season_name,$season_id);
  			if($season_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'season name already exists'
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


    public function season_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$season_id = $data['season_id'];
  			if($season_id > 0){ //update
  				$this->season_model->update_season($data);
  			}
  			else{ //insert
  				$season_id = $this->season_model->add_season($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'season details saved successfully.',
  				'season_id' => $season_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'season_id' => 0
  			));
  		}
  	}


    public function season_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_SEASON');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['season'] = $this->season_model->get_season($id);
        if($data['season'] == null || $data['season'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested season Not Found')
      );
    }
    else
      $this->load->view('master/season/season',$data);
    }


    public function get_seasons()
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

          $seasons = $this->season_model->get_seasons($start,$length,$search,$order_column);
          $count = $this->season_model->get_seasons_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $seasons
          ));
      }

      public function destroy($season_id){
        $this->season_model->destroy($season_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Season deactivated successfully'
        ]);
      }


}
