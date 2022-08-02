<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Commitments extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('master/line_model');
		$this->load->model('production/commitments_model');
		 $this->load->model(['production/production_model', 'master/line_model']);
	}

	public function index() {

		$this->load->model('master/site_model');
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';
		//$data['lines'] = $this->line_model->get_all();
		$data['sites'] = $this->site_model->get_all_active();

		$this->load->view('production/commitments', $data);
	}

		public function eff() {

		$this->login_model->user_authentication('PRD_EFF');

		$this->load->model('master/site_model');
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['lines'] = $this->line_model->get_all();
		$data['menu_code'] = 'MENU_REPORT';
		$data['sites'] = $this->site_model->get_all_active();

		$this->load->view('production/eff', $data);
	}

	/*public function get_lines(){
		$data = array();
		$shift=$this->input->post('shift');
		$date=$this->input->post('date');

		$data = $this->commitments_model->load_line_data($date,$shift);
	 	echo json_encode([
	  	'line' => $data
	  ]);
	}*/

	public function get_line(){
		$data = array();
		$shift = $this->input->post('shift');
		$date = $this->input->post('date');
		$line_no = $this->input->post('line_no');

		$data = $this->commitments_model->load_data_from_line_commitments($date, $shift, $line_no);
		if($data == null){
			$data = $this->commitments_model->load_single_line_data($date, $shift, $line_no);
		}
	 	echo json_encode([
	  	'line' => $data
	  ]);
	}



	public function get_line_data(){
		$data = array();
		$shift=$this->input->post('shift');
		$date=$this->input->post('date');
		$line_no=$this->input->post('line_no');

		$data = $this->commitments_model->load_data($date,$shift,$line_no);
		$commitments_data = $this->commitments_model->load_data_from_line_commitments($date,$shift,$line_no);
		$style_categories = [];

		if($data == null || sizeof($data) <= 0){ //no data in the production table, then need to get data from line_commitments table
			if($commitments_data != null){
				$style_data = $this->commitments_model->get_style_from_code("N/A");
				$commitments_data['style_code'] = $style_data['style_code'];
				$commitments_data['style'] = $style_data['style_id'];
				$commitments_data['style_category'] = null;
				$commitments_data['ttl_qty'] = 0;
				$commitments_data['smv'] = 0;
				$data = [$commitments_data];

				$style_categories = $this->commitments_model->get_style_categories();
			}
			else {
				$data = null;
			}
		}
		else {
			for($x = 0 ; $x < sizeof($data) ; $x++){
				$data[$x]['direct'] = ($commitments_data != null) ? $commitments_data['direct'] : '';
				$data[$x]['indirect'] = ($commitments_data != null) ? $commitments_data['indirect'] : '';
				$data[$x]['minutes'] = ($commitments_data != null) ? $commitments_data['minutes'] : '';
				$data[$x]['ot'] = ($commitments_data != null) ? $commitments_data['ot'] : '';
			}
			//$data = $data[0];
		}
	 	echo json_encode([
	  	'lines' => $data,
			'style_categories' => $style_categories
	  ]);
	}


	public function save_all(){
		$data = $this->input->post('data');
		$data = $this->commitments_model->save_all($data);
		echo json_encode([
			'status' => 'success',
	     'message' => "Save Sucess!"
	  ]);
	}

	public function save_eff(){
		$data = $this->input->post('data');
		$data = $this->commitments_model->save_eff($data);

		echo json_encode([
			'status' => 'success',
	    'message' => "Save Sucess!"
	  ]);
	}


	public function get_lines_from_site($site = 0){
		$lines = $this->line_model->get_all_by_site($site);
		echo json_encode([
			'data' => $lines
		]);
	}


}
