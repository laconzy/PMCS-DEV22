<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Barcode_Transfer extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('master/line_model');
		$this->load->model('production/barcode_transfer_model');
	}


	public function index() {
		$this->login_model->user_authentication('BARCODE_TRANSFER');
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';
		$this->load->view('production/barcode_transfer_list', $data);
	}

	public function new_transfer() {
		$this->login_model->user_authentication('BARCODE_TRANSFER');
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';
		$data['lines'] = $this->login_model->get_authorized_lines();
		$data['operations'] = $this->barcode_transfer_model->get_operations();
		$data['selected_operation'] = 'LINE IN';
 		$this->load->view('production/barcode_transfer', $data);
	}


	public function transfer() {
		$transfer_type = $this->input->post('transfer_type');
		$barcode = $this->input->post('barcode');
		$transfer_line = $this->input->post('transfer_line');
		$transfer_shift = $this->input->post('transfer_shift');
		$operation = $this->input->post('operation');

		$barcode_data = $this->barcode_transfer_model->get_barcode_data($barcode, $operation);
		if($barcode_data == null || sizeof($barcode_data) <= 0){
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect barcode details'
			]);
			return;
		}

		$current_opt_qty = $this->barcode_transfer_model->get_operation_wise_sum($barcode_data['order_id'], $barcode_data['operation'], $barcode_data['line_no'], $barcode_data['size']);
		$next_opt_qty = $this->barcode_transfer_model->get_operation_wise_sum($barcode_data['order_id'], 4, $barcode_data['line_no'], $barcode_data['size']);

		$after_tranfer_qty = $current_opt_qty - $barcode_data['qty'];
		if($after_tranfer_qty < $next_opt_qty){
			echo json_encode([
				'status' => 'error',
				'message' => 'Cannot transfer. Line in qty cannot be less than line out qty'
			]);
			return;
		}

		if($transfer_type == 'LINE'){
			$transfer_shift = null;
			$this->barcode_transfer_model->add_transfer($transfer_type, $barcode, $operation, $transfer_line, $transfer_shift);
			$this->barcode_transfer_model->transfer_line($barcode, $operation, $transfer_line);
		}
		if($transfer_type == 'SHIFT'){
			$transfer_line = null;
			$this->barcode_transfer_model->add_transfer($transfer_type, $barcode, $operation, $transfer_line, $transfer_shift);
			$this->barcode_transfer_model->transfer_shift($barcode, $operation, $transfer_shift);
		}

		echo json_encode([
			'status' => 'success',
			'message' => 'Barcode transfered successfully'
		]);
	}


	public function get_tranafers()
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

			$list = $this->barcode_transfer_model->get_transfers($start,$length,$search,$order_column);
			$count = $this->barcode_transfer_model->get_transfers_count($search);
			echo json_encode(array(
					"draw" => $draw,
					"recordsTotal" => $count,
					"recordsFiltered" => $count,
					"data" => $list
			));
	}



}
