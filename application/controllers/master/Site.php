<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		 $this->load->model('master/site_model');
		 $this->load->model('master/country_model');
    }

    public function index()
    {
        $this->login_model->user_authentication('MASTER_SITE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('master/site/site_list',$data);
    }

    public function site_new()
    {
        $this->login_model->user_authentication('MASTER_SITE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
		    $data['countries'] = $this->country_model->get('ALL');
        $this->load->view('master/site/site',$data);
    }

	public function is_site_code_exists(){
		try{
			$site_code = $this->input->post('data_value');
			$site_id = $this->input->post('site_id');
			$site_count = $this->site_model->count_sites_from_code($site_code,$site_id);
			if($site_count > 0){
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Site code already exists'
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

	public function site_save(){
		try
		{
			$auth_data = $this->login_model->user_authentication_ajax(null);
			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
			$data = $this->input->post('form_data');
			$site_id = $data['id'];
			if($site_id > 0){ //update
				$this->site_model->update_site($data);
			}
			else{ //insert
				$site_id = $this->site_model->add_site($data);
			}
			echo json_encode(array(
				'status' => 'success',
				'message' => 'Site details saved successfully.',
				'site_id' => $site_id
			));
		}
		catch(Exception $e){
			echo json_encode(array(
				'status' => 'error',
				'message' => 'System process error',
				'site_id' => 0
			));
		}
	}

	public function site_view($id = 0)
    {
        $this->login_model->user_authentication('MASTER_SITE');//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
		$data['countries'] = $this->country_model->get('ALL');
		$data['site'] = $this->site_model->get_site($id);
		if($data['site'] == null || $data['site'] == false){
			$this->load->view('common/404',array(
				'heading' => 'Resqested Site Not Found')
			);
		}
		else
			$this->load->view('master/site/site',$data);
    }

	public function get_sites()
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

        $sites = $this->site_model->get_sites($start,$length,$search,$order_column);
        $count = $this->site_model->get_sites_count($search);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $sites
        ));
    }


    public function destroy($site_id){
      $this->site_model->destroy($site_id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Site deactivated successfully'
      ]);
    }
}
