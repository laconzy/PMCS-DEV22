<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Recut extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('master/line_model');
		$this->load->model('production/recut_model');
	}


	public function index() {
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';
		$this->load->view('production/recut_list', $data);
	}

	public function new_request() {
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';
		$this->load->view('production/recut', $data);
	}


	public function view_request($request_id) {
		$this->load->model('order/order_model');
		$this->load->model('approval_proc_model');
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_PRODUCTION';

		$header_data = $this->recut_model->get_header($request_id);
		$data['request_id'] = $request_id;
		$data['header_data'] = $header_data;
		$data['order_data'] = $this->order_model->get($header_data['order_id']);
		$data['stock'] = $this->recut_model->get_bstores_stock_after_save($header_data['order_id'], $request_id);

		$proc_inst = null;
		$proc_def = $this->approval_proc_model->get_proc_def_from_code('RECUT');
		if($proc_def != null){
			$proc_inst = $this->approval_proc_model->get_proc_from_proc_id_and_object_id($proc_def['proc_id'], $request_id);
		}
		$data['proc_inst'] = $proc_inst;

		$this->load->view('production/recut', $data);
	}


	public function print_request($request_id) {
		$this->load->model('order/order_model');
		$data = array();
		$full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');

		$header_data = $this->recut_model->get_header($request_id);
		$data['request_id'] = $request_id;
		$data['header_data'] = $header_data;
		$data['order_data'] = $this->order_model->get($header_data['order_id']);
		$data['stock'] = $this->recut_model->get_bstores_stock_after_save($header_data['order_id'], $request_id);
		$data['printed_by'] = $full_name;
		$data['printed_date'] = $cur_date = date("Y-m-d H:i:s");

		$this->load->view('production/recut_print', $data);
	}

	public function get_stock_details(){
		$this->load->model('order/order_model');
		$order_id = $this->input->get('order_id');
		$order_data = $this->order_model->get($order_id);

		if($order_data == null){
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect Order',
				'stock' => [],
				'order_data' => []
			]);
		}
		else {
			$stock = $this->recut_model->get_bstores_stock($order_id);
			if($stock == null){
				$stock = [];
			}

			echo json_encode([
				'status' => 'success',
				'stock' => $stock,
				'order_data' => $order_data
			]);
		}
	}


	public function save() {
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$order_id = $this->input->post('order_id');
		$transfer_details = $this->input->post('transfer_details');
		$rejection_size_data = $this->recut_model->get_bstores_stock($order_id);

		//validate entered transfer qty with fg qty
		$rejection_qty_error = false;
		foreach ($transfer_details as $row1) {
			foreach ($rejection_size_data as $row2) {
				if($row1['size_id'] == $row2['size'] && $row1['reject_reason'] == $row2['reason_code']){
					if($row1['qty'] > $row2['rejection_qty']){
						$rejection_qty_error = true;
						break;
					}
				}
			}

			if($rejection_qty_error == true){
				break;
			}
		}

		if($rejection_qty_error == true){
			echo json_encode([
				'status' => 'error',
				'message' => 'Request qty is cannot be grater than rejection qty'
			]);
			return;
		}

		$header_id = $this->recut_model->save_header();
		$this->recut_model->save_details($header_id);
		$data = [
			'status' => 'success',
			'message' => 'Recut request saved successfully',
			'id' => $header_id
		];
		echo json_encode($data);
	}


	public function get_recut_list() { //ok
			$auth_data = $this->login_model->user_authentication_ajax(null);
				if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

				$data = $_POST;
				$start = $data['start'];
				$length = $data['length'];
				$draw = $data['draw'];
				$search = $data['searchText'];//$data['search']['value'];
				$order = $data['order'][0];
				$order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

				$list = $this->recut_model->get_recut_list($start,$length,$search,$order_column);
				$count = $this->recut_model->get_recut_count($search);
				echo json_encode(array(
						"draw" => $draw,
						"recordsTotal" => $count,
						"recordsFiltered" => $count,
						"data" => $list
				));
		}


		public function destroy(){
			$request_id = $this->input->post('request_id');
			$this->recut_model->destroy($request_id);
			echo json_encode([
				'status' => 'success',
				'message' => 'Request cancelled successfully'
			]);
		}


		//approvals ----------------------------------------------------------------


		public function send_for_approval(){
			$this->load->model('approval_proc_model');

		}



}
