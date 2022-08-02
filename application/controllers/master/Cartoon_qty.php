<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartoon_qty extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/cartoon_qty_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('MASTER_CARTOON_QTY');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/cartoon_qty/cartoon_qty_list',$data);
    }

    public function cartoon_qty_new()
    {
        $this->login_model->user_authentication('MASTER_CARTOON_QTY');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/cartoon_qty/cartoon_qty',$data);
    }


    public function is_cartoon_qty_exists(){
  		try{
  			$qty = $this->input->post('data_value');
  			$qty_id = $this->input->post('qty_id');
  			$qty_count = $this->cartoon_qty_model->count_cartoon_qty($qty, $qty_id);
  			if($qty_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Cartton qty already exists'
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


    public function cartoon_qty_save(){
  		try
  		{
  			$auth_data = $this->login_model->user_authentication_ajax(null);
  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
  			$data = $this->input->post('form_data');
  			$qty_id = $data['qty_id'];
  			if($qty_id > 0){ //update
  				$this->cartoon_qty_model->update_cartoon_qty($data);
  			}
  			else{ //insert
  				$qty_id = $this->cartoon_qty_model->add_cartoon_qty($data);
  			}
  			echo json_encode(array(
  				'status' => 'success',
  				'message' => 'Cartoon qty details saved successfully.',
  				'qty_id' => $qty_id
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


    public function cartoon_qty_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_CARTOON_QTY');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $data['cartoon_qty'] = $this->cartoon_qty_model->get_cartoon_qty($id);
        if($data['cartoon_qty'] == null || $data['cartoon_qty'] == false){
          $this->load->view('common/404',array(
            'heading' => 'Resqested Cartoon Qty Not Found')
      );
    }
    else
      $this->load->view('master/cartoon_qty/cartoon_qty',$data);
    }


    public function get_cartoon_qtys()
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

          $colors = $this->cartoon_qty_model->get_cartoon_qtys($start,$length,$search,$order_column);
          $count = $this->cartoon_qty_model->get_cartoon_qty_count($search);
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
        $data = $this->cartoon_qty_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }


      public function destroy($qty_id){
        $this->cartoon_qty_model->destroy($qty_id);
        echo json_encode([
          'status' => 'success',
          'message' => 'Cartoon qty deactivated successfully'
        ]);
      }

}
