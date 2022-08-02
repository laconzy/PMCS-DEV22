<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/item_model');
         $this->load->model('master/component_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_ITEM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/item/item_list',$data);
    }

    public function item_new()
    {
        $this->login_model->user_authentication('MASTER_ITEM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/item/item',$data);
    }


    public function is_item_code_exists(){
  		try{
  			$item_code = $this->input->post('data_value');
  			$item_id = $this->input->post('item_id');
  			$item_count = $this->item_model->count_item_from_code($item_code,$item_id);
  			if($item_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Item code already exists'
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


    public function item_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$item_id = $data['item_id'];
  			if($item_id > 0){ //update
  				$this->item_model->update_item($data);
  			}
  			else{ //insert
  				$item_id = $this->item_model->add_item($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'item details saved successfully.',
  				'item_id' => $item_id
  			));
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error',
  				'item_id' => 0
  			));
  		}
  	}


    public function item_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_ITEM');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['item'] = $this->item_model->get_item($id);
        if($data['item'] == null || $data['item'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Item Not Found')
      );
    }
    else
      $this->load->view('master/item/item',$data);
    }


    public function get_items()
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

          $items = $this->item_model->get_items($start,$length,$search,$order_column);
          $count = $this->item_model->get_items_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $items
          ));
      }

      public function add_item_component(){
          $data = [
            'item_id' => $this->input->post('item_id'),
            'component_id' => $this->input->post('component_id')
          ];
          $this->item_model->add_item_component($data);
          $component = $this->component_model->get_component($data['component_id']);
          echo json_encode(array(
    				'status' => 'success',
    				'message' => 'item component saved successfully.',
    				'component' => $component
    			));
      }


      public function delete_item_component(){
          $data = [
            'item_id' => $this->input->post('item_id'),
            'component_id' => $this->input->post('component_id')
          ];
          $this->item_model->delete_item_component($data);
          echo json_encode(array(
    				'status' => 'success',
    				'message' => 'item component removed successfully.'
    			));
      }

      public function get_item_components(){
        $item_id = $this->input->get('item_id');
        $components = $this->item_model->get_item_components($item_id);
        echo json_encode($components);
      }

      public function search()
      {
        $search_term = $this->input->get('item');
        $data = $this->item_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


}
