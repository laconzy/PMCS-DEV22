<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  fg extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('login_model');
		$this->load->model('cutting/bundle_model');
		$this->load->model('order/order_model');
	}


	public function index()

	{





		$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication

		$data = array();

		$data['menus'] = $this->login_model->get_authorized_menus();

		$data['menu_code'] = 'MENU_PRODUCTION';
		$data['site'] = $this->bundle_model->site();

		$this->load->view('cutting/bundle_creation', $data);

	}

}
