<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Style extends CI_Controller {



    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/style_model');
         $this->load->model('master/item_model');
    }



    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_STYLE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/style/style_list',$data);
    }



    public function style_new()
    {
        $this->login_model->user_authentication('MASTER_STYLE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['operations'] = [];
        $data['style_cat'] = $this->style_model->get_style_cat();
        $data['items'] = $this->item_model->get_all();
        $this->load->view('master/style/style',$data);
    }


    public function is_style_code_exists(){
  		try{
  			$style_code = $this->input->post('data_value');
  			$style_id = $this->input->post('style_id');
  			$style_count = $this->style_model->count_styles_from_code($style_code,$style_id);
  			if($style_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Style code already exists'
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


    public function style_save(){
  		try {

  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$style_id = $data['style_id'];

  			if($style_id > 0){ //update
  				$this->style_model->update_style($data);
  			}
  			else{ //insert
  				$style_id = $this->style_model->add_style($data);
  			}

  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Style details saved successfully.',
  				'style_id' => $style_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'style_id' => 0
  			));
  		}
  	}





    public function style_view($id = 0)
    {
        $this->load->model('master/operation_model');
        $this->login_model->user_authentication('MASTER_STYLE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['style'] = $this->style_model->get_style($id);
        $data['style_cat'] = $this->style_model->get_style_cat();
        $data['operations'] = $this->operation_model->get_all();
        $data['saved_operations'] = $this->style_model->get_style_operations($id);
        $data['items'] = $this->item_model->get_all();
         // print_r($data);
        if($data['style'] == null || $data['style'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Color Not Found')
        );
    }
    else
      $this->load->view('master/style/style',$data);
    }





    public function get_styles()

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



          $style = $this->style_model->get_styles($start,$length,$search,$order_column);

          $count = $this->style_model->get_styles_count($search);

          echo json_encode(array(

              "draw" => $draw,

              "recordsTotal" => $count,

              "recordsFiltered" => $count,

              "data" => $style

          ));

      }





      public function search()

      {

        $search_term = $this->input->get('term');

        $data = $this->style_model->search($search_term);

        echo json_encode([

          'results' => $data

          ]);

      }





      public function destroy($style_id){

        $this->style_model->destroy($style_id);

        echo json_encode([

          'status' => 'success',

          'message' => 'Style deactivated successfully'

        ]);

      }


      //manage style operations-------------------------------------------------

      public function add_operation(){
        $style_id = $this->input->post('style_id');
        $operation = $this->input->post('operation');

        //check operation already added
        $is_added = $this->style_model->is_operation_already_added($style_id, $operation);
        if($is_added == true){
          echo json_encode([
            'status' => 'error',
            'message' => 'Operation already added',
            'operations' => []
          ]);
        }
        else {
          $this->style_model->add_style_operation($style_id, $operation);
          echo json_encode([
            'status' => 'success',
            'message' => 'Operation addedd successfully',
            'operations' => $this->style_model->get_style_operations($style_id)
          ]);
        }
      }


      public function remove_operation(){
        $style_id = $this->input->post('style_id');
        $operation_id = $this->input->post('operation_id');
        $seq = $this->input->post('seq');
        $this->style_model->remove_style_operation($style_id, $operation_id, $seq);
        echo json_encode([
          'status' => 'success',
          'operations' => $this->style_model->get_style_operations($style_id)
        ]);
      }


}
