<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  Location_transfer extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('fg/location_transfer_model');
		//$this->load->model('master/barcode_model');
		$this->load->model('master/site_model');
		$this->load->model('master/style_model');
	}


	public function index()	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$this->load->view('fg/location_transfer_list', $data);
	}


	public function new_transfer()	{//ok
		$this->login_model->user_authentication(null); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['transfer_reasons'] = $this->location_transfer_model->get_all_transfer_reasons("LOCATION TRANSFER");
		$data['sites'] = $this->site_model->get_all_active();
		$data['styles'] = $this->style_model->get_all_active();
		$this->load->view('fg/location_transfer', $data);
	}

	public function view_transfer($transfer_id)	{//ok
		$this->login_model->user_authentication(null);  // user permission authentication
		$data = [
			'transfer_id' => $transfer_id
		];
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$transfer_data = $this->location_transfer_model->get_tranfer_header($transfer_id);

		if($transfer_data['from_order_id'] == 0){// need to get stock by style and color, used to get left over stock
			$stock = $this->location_transfer_model->get_location_stock_by_style_and_color($transfer_data['style'], $transfer_data['color'], $transfer_data['from_line'], $transfer_id);
		}
		else {
			$stock = $this->location_transfer_model->get_location_stock_by_order_id($transfer_data['from_order_id'], $transfer_data['from_line'], $transfer_id);
		}

		$data['header_data'] = $transfer_data;
		$data['stock'] = $stock;
		$this->load->view('fg/location_transfer', $data);
	}


	public function print_transfer($transfer_id)	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$transfer_data = $this->location_transfer_model->get_tranfer_header($transfer_id);

		if($transfer_data['from_order_id'] == 0){// need to get stock by style and color, used to get left over stock
			$stock = $this->location_transfer_model->get_location_stock_by_style_and_color($transfer_data['style'], $transfer_data['color'], $transfer_data['from_line'], $transfer_id);
		}
		else {
			$stock = $this->location_transfer_model->get_location_stock_by_order_id($transfer_data['from_order_id'], $transfer_data['from_line'], $transfer_id);
		}

		$full_name = $this->session->userdata('first_name');
		$data = array();
		$data['header_data'] = $transfer_data;
		$data['stock'] = $stock;
		$data['printed_by'] = $full_name;
		$data['printed_date'] = $cur_date = date("Y-m-d H:i:s");
		$this->load->view('fg/location_transfer_print', $data);
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

				$colors = $this->location_transfer_model->get_transfer_list($start,$length,$search,$order_column);
				$count = $this->location_transfer_model->get_transfer_count($search);
				echo json_encode(array(
						"draw" => $draw,
						"recordsTotal" => $count,
						"recordsFiltered" => $count,
						"data" => $colors
				));
		}


	public function get_lines(){
		$this->load->model('login_model');
		$site_id = $this->input->get('site_id');
		$lines1 = $this->login_model->get_authorized_lines_by_site_and_category($site_id, 'FG');
		$lines2 = $this->login_model->get_authorized_lines_by_site_and_category($site_id, 'LEFT_OVER');
		$lines = array_merge($lines1, $lines2);
		echo json_encode([
			'data' => $lines
		]);
	}

	public function get_style_colors(){
		$style_id = $this->input->get('style_id');
		$colors = $this->location_transfer_model->get_style_colors($style_id);
		echo json_encode([
			'data' => $colors
		]);
	}


	public function get_location_stock(){
		$site_id = $this->input->get('site_id');
		$order_id = $this->input->get('order_id');
		$line_id = $this->input->get('line_id');

		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$stock = [];

		if($order_id == 0){// need to get stock by style and color, used to get left over stock
			$stock = $this->location_transfer_model->get_location_stock_by_style_and_color($style_id, $color_id, $line_id, null);
		}
		else {
			$stock = $this->location_transfer_model->get_location_stock_by_order_id($order_id, $line_id, null);
		}

		echo json_encode([
			'data' => $stock
		]);
	}


	/*public function get_order_details2($order_id, $transfer_id = null){//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data = $this->location_transfer_model->get_order_details($order_id);
		$size_data = $this->location_transfer_model->get_size_data2($order_id, $transfer_id);
		echo json_encode([
			'order' => $data,
			'size_data' => $size_data
		]);
	}*/


	public function get_order_details(){
		$this->load->model('master/line_model');
		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$from_line_id = $this->input->get('from_line_id');
		$to_line_id = $this->input->get('to_line_id');

		$from_line_data = $this->line_model->get_line($from_line_id);
		$to_line_data = $this->line_model->get_line($to_line_id);
		$transfer_type = null;

		if($from_line_data['category'] == 'FG' && $to_line_data['category'] == 'FG'){
			$transfer_type = 'FG_TO_FG';
		}
		else if($from_line_data['category'] == 'FG' && $to_line_data['category'] == 'LEFT_OVER'){
			$transfer_type = 'FG_TO_LEFT_OVER';
		}
		else if($from_line_data['category'] == 'LEFT_OVER' && $to_line_data['category'] == 'FG'){
			$transfer_type = 'LEFT_OVER_TO_FG';
		}

		$orders = $this->location_transfer_model->get_orders_from_style_and_color($style_id, $color_id);
		echo json_encode([
			'data' => $orders,
			'transfer_type' => $transfer_type
		]);
	}


	public function save() {
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$from_site_id = $this->input->post('from_site_id');
		$to_site_id = $this->input->post('to_site_id');
		$from_line_id = $this->input->post('from_line_id');
		$to_line_id = $this->input->post('to_line_id');
		$order_id = $this->input->post('from_order_id');
		$style_id = $this->input->post('from_style_id');
		$color_id = $this->input->post('from_color_id');
		$line_id = $this->input->post('from_line_id');
		$transfer_details = $this->input->post('transfer_details');
		$transfer_type = $this->input->post('transfer_type');
		$to_order_id = $this->input->post('from_order_id');;
		$stock = null;

		if($order_id == 0){// need to get stock by style and color, used to get left over stock
			$stock = $this->location_transfer_model->get_location_stock_by_style_and_color($style_id, $color_id, $line_id, null);
		}
		else {
			$stock = $this->location_transfer_model->get_location_stock_by_order_id($order_id, $line_id, null);
		}

		//validate entered transfer qty with fg qty
		$fg_qty_error = false;
		foreach ($transfer_details as $row1) {
			foreach ($stock as $row2) {
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
		//$to_size_data = $this->fg_transfer_model->get_size_data($to_order_id);

		// if($to_size_data == null || sizeof($to_size_data) <= 0){
		// 	echo json_encode([
		// 		'status' => 'error',
		// 		'message' => 'Incorrect size details'
		// 	]);
		// }
		//else {
			//get size id list
			// $size_id_arr = [];
			// foreach ($to_size_data as $row) {
			// 	array_push($size_id_arr, $row['size']);
			// }

			//check sizes
			// $size_ok = true;
			// foreach ($transfer_details as $row) {
			// 	if(in_array($row['size_id'], $size_id_arr) == false){
			// 		$size_ok = false;
			// 		break;
			// 	}
			// }
			// if($size_ok == false){
			// 	echo json_encode([
			// 		'status' => 'error',
			// 		'message' => 'Size details are not matching'
			// 	]);
			// 	return;
			// }

			$transfer_id = $this->location_transfer_model->save_header();
			$this->location_transfer_model->save_details($transfer_id);
			//transfer finish goods in fg table
			if($transfer_type == 'LEFT_OVER_TO_FG'){
				$to_order_id = $this->input->post('to_order_id');
			}
			else if($transfer_type == 'FG_TO_LEFT_OVER'){
				$to_order_id = 0;
			}

			$this->location_transfer_model->transfer_from_fg($from_site_id, $from_line_id, $order_id, $style_id, $color_id, $transfer_details, $transfer_id);
			$this->location_transfer_model->transfer_to_fg($to_site_id, $to_line_id, $to_order_id, $style_id, $color_id, $transfer_details, $transfer_id);

			$data = [
				'status' => 'success',
				'message' => 'Finish good transfered successfully',
				'id' => $transfer_id
			];
			echo json_encode($data);
	//	}
	}

}
