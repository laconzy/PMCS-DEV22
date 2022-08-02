<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  BStores_transfer extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('fg/bstores_transfer_model');
		$this->load->model('master/site_model');
		$this->load->model('master/line_model');
	}


	public function index()	{//ok
		$this->login_model->user_authentication('B_STORE_TRANSFER'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$this->load->view('fg/bstores_transfer_list', $data);
	}

	public function new_transfer()	{//ok
		$this->login_model->user_authentication('B_STORE_TRANSFER'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		//$data['transfer_reasons'] = $this->bstores_transfer_model->get_all_transfer_reasons();
		$data['styles'] = $this->bstores_transfer_model->get_all_styles();
		$data['sites'] = $this->site_model->get_all_active();
		$this->load->view('fg/bstores_transfer', $data);
	}

	public function view_transfer($transfer_id)	{//ok
		$this->login_model->user_authentication('B_STORE_TRANSFER');  // user permission authentication
		$data = [
			'transfer_id' => $transfer_id
		];
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';

		$transfer_data = $this->bstores_transfer_model->get_tranfer_header($transfer_id);
		if($transfer_data != null && $transfer_data['line_id'] != null){
			$transfer_data['line_details'] = $this->line_model->get_line($transfer_data['line_id']);
		}
		else {
			$transfer_data['line_details'] = null;
		}

		$data['transfer_data'] = $transfer_data;
		$data['style'] = $this->bstores_transfer_model->get_style($transfer_data['style_id']);
		$data['color'] = $this->bstores_transfer_model->get_color($transfer_data['color_id']);
		$data['transfer_reason'] = $this->bstores_transfer_model->get_transfer_reason($transfer_data['transfer_reason']);
		//$data['sites'] = $this->site_model->get_all_active();
		$this->load->view('fg/bstores_transfer', $data);
	}


	public function print_transfer($transfer_id)	{//ok
		//$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$transfer_data = $this->bstores_transfer_model->get_transfer_header_for_print($transfer_id);
		$transfer_details = $this->bstores_transfer_model->get_transfer_details($transfer_id);
		$full_name = $this->session->userdata('first_name');

		if($transfer_data['transfer_type'] == 'LEFT_OVER'){
			$transfer_data['line_details'] = $this->line_model->get_line($transfer_data['line_id']);
		}
		else {
			$transfer_data['line_details'] = null;
		}

		$data = array();
		$data['transfer_data'] = $transfer_data;
		$data['transfer_details'] = $transfer_details;
		$data['style'] = $this->bstores_transfer_model->get_style($transfer_data['style_id']);
		$data['color'] = $this->bstores_transfer_model->get_color($transfer_data['color_id']);
		$data['transfer_reason'] = $this->bstores_transfer_model->get_transfer_reason($transfer_data['transfer_reason']);
		$data['printed_by'] = $full_name;
		$data['printed_date'] = $cur_date = date("Y-m-d H:i:s");
		$this->load->view('fg/bstores_transfer_print', $data);
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

				$transfers = $this->bstores_transfer_model->get_transfer_list($start,$length,$search,$order_column);
				$count = $this->bstores_transfer_model->get_transfer_count($search);
				echo json_encode(array(
						"draw" => $draw,
						"recordsTotal" => $count,
						"recordsFiltered" => $count,
						"data" => $transfers
				));
		}


	public function get_style_colors($style_id = 0){
		$colors = $this->bstores_transfer_model->get_style_colors($style_id);
		echo json_encode([
			'data' => $colors
		]);
	}


	public function get_transfer_reasons($type = ''){
		$reasons = $this->bstores_transfer_model->get_transfer_reasons($type);
		echo json_encode([
			'data' => $reasons
		]);
	}


	public function get_order_details(){
		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$orders = $this->bstores_transfer_model->get_orders_from_style_and_color($style_id, $color_id);
		echo json_encode([
			'data' => $orders
		]);
	}


	public function get_stock_details(){
		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$site_id = $this->input->get('site_id');
		$bstores_stock = $this->bstores_transfer_model->get_bstores_stock($style_id, $color_id, $site_id);
		echo json_encode([
			'stock' => $bstores_stock
		]);
	}

	public function get_stock_details_after_transfer(){
		$style_id = $this->input->get('style_id');
		$color_id = $this->input->get('color_id');
		$transfer_id = $this->input->get('transfer_id');
		$bstores_stock = $this->bstores_transfer_model->get_bstores_stock_after_transfer($style_id, $color_id, $transfer_id);
		echo json_encode([
			'stock' => $bstores_stock
		]);
	}

	public function get_order_stock(){
		$order_id = $this->input->get('order_id');
		$order_stock = $this->bstores_transfer_model->get_order_stock($order_id);
		echo json_encode([
			'stock' => $order_stock
		]);
	}


	public function save() {
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$order_id = $this->input->post('order_id');
		$style_id = $this->input->post('style_id');
		$color_id = $this->input->post('color_id');
		$site_id = $this->input->post('site_id');
		$line_id = $this->input->post('line_id');
		$transfer_details = $this->input->post('transfer_details');
		$transfer_type = $this->input->post('transfer_type');
		$bstores_size_data = $this->bstores_transfer_model->get_bstores_stock($style_id, $color_id, $site_id);

		//validate entered transfer qty with fg qty
		$bstores_qty_error = false;
		foreach ($transfer_details as $row1) {
			foreach ($bstores_size_data as $row2) {
				if($row1['size_id'] == $row2['size']){
					if($row1['qty'] > $row2['bstores_qty']){
						$bstores_qty_error = true;
						break;
					}
				}
			}

			if($bstores_qty_error == true){
				break;
			}
		}

		if($bstores_qty_error == true){
			echo json_encode([
				'status' => 'error',
				'message' => 'Transfer qty is cannot be grater than b stores qty'
			]);
			return;
		}

		//chek transfer type do action based on type
		if($transfer_type == 'FG_TRANSFER'){
			//validate selected transferd sizes with order sizes
			$order_size_data = $this->bstores_transfer_model->get_order_stock($order_id);
			if($order_size_data == null || sizeof($order_size_data) <= 0){
				echo json_encode([
					'status' => 'error',
					'message' => 'Incorrect size details'
				]);
			}
			else {
				//get size id list
				$size_id_arr = [];
				foreach ($order_size_data as $row) {
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

				$header_id = $this->bstores_transfer_model->save_header();
				$this->bstores_transfer_model->save_details($header_id);
				//transfer finish goods in fg table
				$this->bstores_transfer_model->transfer_from_bstores($style_id, $color_id, $transfer_details, $header_id, 'FG_TRANSFER_OUT', $site_id);
				$this->bstores_transfer_model->transfer_to_fg($order_id, $transfer_details, $header_id, $site_id, $line_id, $style_id, $color_id);

				$data = [
					'status' => 'success',
					'message' => 'B stores items transfered to FG successfully',
					'id' => $header_id
				];
				echo json_encode($data);
			}
		}
		else if($transfer_type == 'LEFT_OVER'){
			$header_id = $this->bstores_transfer_model->save_header();
			$this->bstores_transfer_model->save_details($header_id);
			$this->bstores_transfer_model->transfer_from_bstores($style_id, $color_id, $transfer_details, $header_id, 'LEFT_OVER_OUT', $site_id);
			$this->bstores_transfer_model->transfer_to_left_over($line_id, $transfer_details, $header_id, $site_id, $style_id, $color_id);
			$data = [
				'status' => 'success',
				'message' => 'B stores items were moved to left over successfully',
				'id' => $header_id
			];
			echo json_encode($data);
		}
		else { //WRITEOFF
			$header_id = $this->bstores_transfer_model->save_header();
			$this->bstores_transfer_model->save_details($header_id);
			$this->bstores_transfer_model->transfer_from_bstores($style_id, $color_id, $transfer_details, $header_id, 'WRITEOFF', $site_id);
			$data = [
				'status' => 'success',
				'message' => 'B stores items were write off successfully',
				'id' => $header_id
			];
			echo json_encode($data);
		}

	}


	public function get_left_over_lines(){
		$this->load->model('login_model');
		$site_id = $this->input->get('site_id');
		$category = $this->input->get('category');
		$data = $this->login_model->get_authorized_lines_by_site_and_category($site_id, $category);
		echo json_encode([
			'data' => $data
		]);
	}

}
