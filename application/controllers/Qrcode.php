<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode extends CI_Controller {


	public function __construct()
    {
         parent::__construct();
         $this->load->helper('form');
				 $this->load->model('qrcode_model');
				 $this->load->model('login_model');
    }

	public function index()
	{
		$this->login_model->user_authentication(null); //user authentication
		//$data['menus'] = $this->login_model->get_authorized_menus();
		$qr_data = $this->qrcode_model->get_qr_info();
		$final_data = [];
		foreach ($qr_data as $row) {
			$row['link'] = base_url() . 'qrdata_view/'.$row['id'];		
			array_push($final_data, $row);
		}
		$data = [
			'qr_data' => $final_data
		];
		$this->load->view('qrcode/qrcode',$data);
	}
}
