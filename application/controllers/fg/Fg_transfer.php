<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  Fg_transfer extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('fg/fg_transfer_model');
		//$this->load->model('master/barcode_model');
		$this->load->model('master/site_model');
		$this->load->model('master/style_model');
	}


	public function index()	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$this->load->view('fg/fg_transfer_list', $data);
	}


	public function new_transfer()	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['transfer_reasons'] = $this->fg_transfer_model->get_all_transfer_reasons("FG TRANSFER");
		$data['sites'] = $this->site_model->get_all_active();
		$this->load->view('fg/fg_transfer', $data);
	}

	public function view_transfer($transfer_id)	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = [
			'transfer_id' => $transfer_id
		];
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		//$data['transfer_reasons'] = $this->fg_transfer_model->get_all_transfer_reasons("FG TRANSFER");

		$transfer_data = $this->fg_transfer_model->get_transfer_header($transfer_id);
		$from_order_size_data = $this->fg_transfer_model->get_size_data($transfer_data['from_order_id'], $transfer_id, $transfer_data['from_line']);
		$to_order_size_data = $this->fg_transfer_model->get_size_data($transfer_data['to_order_id'], $transfer_id, $transfer_data['to_line']);

		$data['header_data'] = $transfer_data;
		$data['from_order_stock'] = $from_order_size_data;
		$data['to_order_stock'] = $to_order_size_data;
		$this->load->view('fg/fg_transfer', $data);
	}


	public function print_transfer($transfer_id)	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$transfer_data = $this->fg_transfer_model->get_transfer_header($transfer_id);
		$transfer_details = $this->fg_transfer_model->get_transfer_details($transfer_id);
		$full_name = $this->session->userdata('first_name');

		$data = array();
		$data['transfer_data'] = $transfer_data;
		$data['transfer_details'] = $transfer_details;
		$data['printed_by'] = $full_name;
		$data['printed_date'] = $cur_date = date("Y-m-d H:i:s");
		$this->load->view('fg/fg_transfer_print', $data);
	}


	public function get_transfer_list() { //ok
			$auth_data = $this->login_model->user_authentication_ajax(null);
				if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

				$data = $_POST;
				$start = $data['start'];
				$length = $data['length'];
				$draw = $data['draw'];
				$search = $data['searchText'];//$data['search']['value'];
				$order = $data['order'][0];
				$order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

				$colors = $this->fg_transfer_model->get_transfer_list($start,$length,$search,$order_column);
				$count = $this->fg_transfer_model->get_transfer_count($search);
				echo json_encode(array(
						"draw" => $draw,
						"recordsTotal" => $count,
						"recordsFiltered" => $count,
						"data" => $colors
				));
		}

	public function get_order_details(){//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$order_id = $this->input->get('order_id');
		$line_id = $this->input->get('line_id');
		$transfer_id = $this->input->get('transfer_id');
		$data = array();
		$data = $this->fg_transfer_model->get_order_details($order_id);
		$size_data = $this->fg_transfer_model->get_size_data($order_id, $transfer_id, $line_id);
		echo json_encode([
			'order' => $data,
			'size_data' => $size_data
		]);
	}


	public function get_transfer_data($transfer_id) {
		$transfer_data = $this->fg_transfer_model->get_transfer_header($transfer_id);
		if($transfer_data != null){
			$from_order = $this->fg_transfer_model->get_order_details($transfer_data['from_order_id']);
			$from_order_size_data = $this->fg_transfer_model->get_size_data($transfer_data['from_order_id'], $transfer_id);
			$to_order = $this->fg_transfer_model->get_order_details($transfer_data['to_order_id']);
			$to_order_size_data = $this->fg_transfer_model->get_size_data($transfer_data['to_order_id'], $transfer_id);

			echo json_encode([
				'transfer_data' => $transfer_data,
				'from_order' => $from_order,
				'from_order_size_data' => $from_order_size_data,
				'to_order' => $to_order,
				'to_order_size_data' => $to_order_size_data
			]);
		}
		else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect transfer details'
			]);
		}
	}

	public function save() {
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$from_order_id = $this->input->post('from_order_id');
		$to_order_id = $this->input->post('to_order_id');
		$from_site_id = $this->input->post('from_site_id');
		$to_site_id = $this->input->post('to_site_id');
		$from_line_id = $this->input->post('from_line_id');
		$to_line_id = $this->input->post('to_line_id');
		$transfer_details = $this->input->post('transfer_details');
		$from_size_data = $this->fg_transfer_model->get_size_data($from_order_id, null, $from_line_id);

		//validate entered transfer qty with fg qty
		$fg_qty_error = false;
		foreach ($transfer_details as $row1) {
			foreach ($from_size_data as $row2) {
				if($row1['size_id'] == $row2['size']){
					if($row1['qty'] > $row2['fg_qty']){
						$fg_qty_error = true;
						break;
					}
				}
			}

			if($fg_qty_error == true){
				break;
			}
		}

		if($fg_qty_error == true){
			echo json_encode([
				'status' => 'error',
				'message' => 'Transfer qty is grater than fg qty'
			]);
			return;
		}

		//validate selected transferd sizes with to order sizes
		$to_size_data = $this->fg_transfer_model->get_size_data($to_order_id, null, null);

		if($to_size_data == null || sizeof($to_size_data) <= 0){
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect size details'
			]);
		}
		else {
			//get size id list
			$size_id_arr = [];
			foreach ($to_size_data as $row) {
				array_push($size_id_arr, $row['size']);
			}

			//check sizes
			$size_ok = true;
			foreach ($transfer_details as $row) {
				if(in_array($row['size_id'], $size_id_arr) == false){
					$size_ok = false;
					break;
				}
			}
			if($size_ok == false){
				echo json_encode([
					'status' => 'error',
					'message' => 'Size details are not matching'
				]);
				return;
			}

			$header_id = $this->fg_transfer_model->save_header();
			$this->fg_transfer_model->save_details($header_id);
			//transfer finish goods in fg table

			$order_details = $this->fg_transfer_model->get_order_details($from_order_id);
			$this->fg_transfer_model->transfer_from_fg($from_order_id, $transfer_details, $header_id, $from_line_id, $order_details['color'], $order_details['style'], $from_site_id);
			$this->fg_transfer_model->transfer_to_fg($to_order_id, $transfer_details, $header_id, $to_line_id, $order_details['color'], $order_details['style'], $to_site_id);

			$data = [
				'status' => 'success',
				'message' => 'Finish good transfered successfully',
				'id' => $header_id
			];
			echo json_encode($data);
		}
	}

	//FG to LEFT OVER transfer----------------------------------------------------

	public function new_left_over_transfer()	{//ok
		$this->login_model->user_authentication(null); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['transfer_reasons'] = $this->fg_transfer_model->get_all_transfer_reasons("LEFT OVER TRANSFER");
		$data['sites'] = $this->site_model->get_all_active();
		$data['styles'] = $this->style_model->get_all_active();
		$this->load->view('fg/fg_to_left_over_transfer', $data);
	}

	public function get_left_over_lines(){
		$this->load->model('login_model');
		$site_id = $this->input->get('site_id');
		$data = $this->login_model->get_authorized_lines_by_site_and_category_list($site_id, 'B-STORES');
		echo json_encode([
			'data' => $data
		]);
	}

	public function get_style_colors(){
		$style_id = $this->input->get('style_id');
		$colors = $this->fg_transfer_model->get_style_colors($style_id);
		echo json_encode([
			'data' => $colors
		]);
	}


	public function get_left_over_stock(){
		$site_id = $this->input->get('site_id');
		$line_id = $this->input->get('line_id');
		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$stock = $this->fg_transfer_model->get_left_over_stock($line_id, $style_id, $color_id);
		echo json_encode([
			'data' => $stock
		]);
	}


	public function get_order_details2($order_id, $transfer_id = null){//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data = $this->fg_transfer_model->get_order_details($order_id);
		$size_data = $this->fg_transfer_model->get_size_data2($order_id, $transfer_id);
		echo json_encode([
			'order' => $data,
			'size_data' => $size_data
		]);
	}

	public function get_lines(){
		$this->load->model('login_model');
		$site_id = $this->input->get('site_id');
		$data = $this->login_model->get_authorized_lines_by_site_and_category($site_id, 'FG');
		echo json_encode([
			'data' => $data
		]);
	}

}
