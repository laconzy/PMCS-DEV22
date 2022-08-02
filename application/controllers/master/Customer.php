<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/customer_model');
		     $this->load->model('master/country_model');
    }

    public function index()
    {
        $this->login_model->user_authentication('MASTER_CUS');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/customer/customer_list',$data);
    }

    public function customer_new()
    {
        $this->login_model->user_authentication('MASTER_CUS');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
		    $data['countries'] = $this->country_model->get('ALL');
		    //$data['site'] = array();
        $this->load->view('master/customer/customer',$data);
    }

	public function is_customer_code_exists(){
		try{
			$cus_code = $this->input->post('data_value');
			$cus_id = $this->input->post('cus_id');
			$cus_count = $this->customer_model->count_customer_from_code($cus_code,$cus_id);
			if($cus_count > 0){
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Customer code already exists'
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

	public function customer_save(){
		try
		{
			$auth_data = $this->login_model->user_authentication_ajax(null);
			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
			$data = $this->input->post('form_data');
			$cus_id = $data['id'];
			if($cus_id > 0){ //update
				$this->customer_model->update_customer($data);
			}
			else{ //insert
				$cus_id = $this->customer_model->add_customer($data);
			}
			echo json_encode(array(
				'status' => 'success',
				'message' => 'Customer details saved successfully.',
				'cus_id' => $cus_id
			));
		}
		catch(Exception $e){
			echo json_encode(array(
				'status' => 'error',
				'message' => 'System process error',
				'cus_id' => 0
			));
		}
	}

	public function customer_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_CUS');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
		$data['countries'] = $this->country_model->get('ALL');
		$data['customer'] = $this->customer_model->get_customer($id);
		if($data['customer'] == null || $data['customer'] == false){
			$this->load->view('common/404',array(
				'heading' => 'Resqested Customer Not Found')
			);
		}
		else
			$this->load->view('master/customer/customer',$data);
    }

	public function get_customers()
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

        $customers = $this->customer_model->get_customers($start,$length,$search,$order_column);
        $count = $this->customer_model->get_customers_count($search);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $customers
        ));
    }


    public function search()
    {
      $search_term = $this->input->get('term');
      $data = $this->customer_model->search($search_term);
      echo json_encode([
        'results' => $data
        ]);
    }

    public function destroy($customer_id){
      $this->customer_model->destroy($customer_id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Customer deactivated successfully'
      ]);
    }

}
