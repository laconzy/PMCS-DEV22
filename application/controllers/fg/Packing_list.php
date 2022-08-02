<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  Packing_list extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('fg/packing_list_model');
		$this->load->model('order/order_model');
		$this->load->model('cutting/bundle_model');
		$this->load->model('master/barcode_model');
	}


	public function index()	{//ok
		$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		//$data['site'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$this->load->view('fg/packing_list_search', $data);

	}

	public function packing_list_new(){//ok
		$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['site'] = $this->bundle_model->site();
		$this->load->view('fg/packing_list', $data);
	}


	public function packing_list_view($packing_list_id)	{//ok
		$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['site'] = $this->bundle_model->site();
		$data['packing_list_id'] = $packing_list_id;
		$this->load->view('fg/packing_list', $data);
	}

	public function get_packing_lists() { //ok
			$auth_data = $this->login_model->user_authentication_ajax(null);
				if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

				$data = $_POST;
				$start = $data['start'];
				$length = $data['length'];
				$draw = $data['draw'];
				$search = $data['searchText'];//$data['search']['value'];
				$order = $data['order'][0];
				$order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

				$colors = $this->packing_list_model->get_packing_lists($start,$length,$search,$order_column);
				$count = $this->packing_list_model->get_packing_lists_count($search);
				echo json_encode(array(
						"draw" => $draw,
						"recordsTotal" => $count,
						"recordsFiltered" => $count,
						"data" => $colors
				));
		}


		public function get_packing_list($packing_list_id){ //ok
			$pack_list = $this->packing_list_model->get_packing_list($packing_list_id);
			if($pack_list != null){
				$orders = $this->packing_list_model->get_orders_from_customer_po($pack_list['customer_po']);
				echo json_encode([
					'packing_list' => $pack_list,
					'orders' => $orders
				]);
			}
			else {
				$data = [
					'status' => 'error',
					'message' => 'Incorrect packing list'
				];
			}
		}


	public function get_data_from_customer_po($po_no){//ok
		$orders = $this->packing_list_model->get_orders_from_customer_po($po_no);
		echo json_encode([
			'orders' => $orders
		]);
	}

	/*public function get_order_details($po)	{
		$data = array();
		//$po = $this->input->post('po');
		$order = $this->packing_list_model->get_order_details($po);
		//echo 12;
		//$cut_details = $this->bundle_model->get_cut_details_summery($laysheet_no);
		//$cut_plan = $this->bundle_model->get_cut_plan($laysheet['cut_plan_id']);
		$data = [
			//'laysheet' => $laysheet,
			//'cut_details' => $cut_details,
			'order_details' => $order
		];
		echo json_encode($data);
	}*/


	public function save() {
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$data = array();
		$id = $this->packing_list_model->save();
		$data = [
			'status' => 'success',
			'message' => 'Packing List Saved Successfully',
			'id' => $id
		];
		echo json_encode($data);
	}


	/*public function save_details()	{
		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$data = array();
		//$po = $this->input->post('po');
		$id = $this->packing_list_model->save_details();
		//echo 12;
		//$cut_details = $this->bundle_model->get_cut_details_summery($laysheet_no);
		//$cut_plan = $this->bundle_model->get_cut_plan($laysheet['cut_plan_id']);
		$data = [
			//'laysheet' => $laysheet,
			'status' => 'Success',
			'id' => $id
		];
		echo json_encode($data);
	}*/

	public function get_saved_details($pack_list_id){

		$data = $this->packing_list_model->get_packing_list_items($pack_list_id);
		$data = [
			'status' => 'success',
			'bundle_chart' => $data
		];

		echo json_encode($data);
	}

	public function packing_list_print($pack_list_id) {

		$user_first_name = $this->session->userdata('first_name');
		$user_last_name = $this->session->userdata('last_name');

		$pack_list = $this->packing_list_model->get_packing_list($pack_list_id);
		$order_details = $this->packing_list_model->get_orders_from_customer_po($pack_list['customer_po']);
		$order_ids_arr = [];

		foreach ($order_details as $row) {
			array_push($order_ids_arr, $row['order_id']);
		}
		$order_ids = join(',', $order_ids_arr);

		$total_orders_qty = $this->packing_list_model->get_order_qty_sum($order_ids);
		$total_ship_qty = $this->packing_list_model->get_ship_qty_sum($order_ids);
		$sizes = $this->packing_list_model->get_order_sizes($order_ids);

		$data = array();
		$data['header_data'] = $pack_list;
		$data['data'] = $this->packing_list_model->get_print($pack_list_id);
		$data['total_orders_qty'] = $total_orders_qty;
		$data['total_ship_qty'] = $total_ship_qty;
		$data['sizes'] = $sizes;
		$data['printed_by'] = $user_first_name.' '.$user_last_name;
		$data['printed_date'] = date("Y-m-d H:i:s");

		$this->load->view('fg/packing_list_print2', $data);
	}


	/*public function packing_list_print2($packing_id){

		$data = array();
		$data['data'] = $this->packing_list_model->get_print($packing_id);
		//$data['packing_id']=$packing_id;
		//print_r($data);
		$this->load->view('fg/packing_list_print2', $data);
	}*/


	/*public function destroy($line_item, $bundle_no) {
    $this->packing_list_model->destroy($line_item, $bundle_no);
    echo json_encode([
        'status' => 'success',
        'message' => 'Bundle removed successfully'
    ]);
  }*/

  public function scan_barcode(){
		$header_id = $this->input->post('header_id');
		$barcode = $this->input->post('barcode');
		$order_id = $this->input->post('order_id');

		$barcode_data = $this->barcode_model->get_barcode_from_code($barcode);
		if($barcode_data == null || $barcode_data == false){ //no saved barcode
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect Barcode'
			]);
			return;
		}
		//get order cut_details
		$order = $this->packing_list_model->get_order_details_from_id($order_id);
		if($order == null || $order == false){
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect Order Details'
			]);
			return;
		}

		//order item size Details
		$item_size_details = $this->packing_list_model->get_order_size_details_from_id($order_id, $barcode_data['size']);
		if($item_size_details == null || $item_size_details == false){
			echo json_encode([
				'status' => 'error',
				'message' => 'No order for this barcode size'
			]);
			return;
		}

		//check barcode data with order data
		if($order['style'] == $barcode_data['style'] && $order['color'] == $barcode_data['color']){

			$already_scanned_qty = $this->packing_list_model->get_order_completed_packing_list_qty($order_id, $barcode_data['size']);
			if(($already_scanned_qty + $barcode_data['qty']) >  $item_size_details['order_qty']){
				echo json_encode([
					'status' => 'error',
					'message' => 'Cartoon qty cannot be grater than order planned qty'
				]);
				return;
			}

			$items = $this->packing_list_model->get_packing_list_item_from_barcode($header_id, $barcode);
			$form_data = [
				'line_item' => 0,
				'packing_list_id' => $header_id,
				'pcs_per_ctn' => $barcode_data['qty'],
				'ctn_qty' => 1,
				'ttl_qty' => $barcode_data['qty'],
				'weight_net' => $barcode_data['net_weight'],
				'color' => $barcode_data['color'],
				'size_id' => $barcode_data['size'],
				'order_id' => $order_id,
				'barcode' => $barcode
			];

			if($items != null && $items != false && sizeof($items) > 0){// already existing barcode
				$this->packing_list_model->update_packing_item($header_id, $barcode, $barcode_data['qty'], $barcode_data['net_weight']);
			}
			else {//new barcode
				$this->packing_list_model->add_packing_item($form_data);
			}

			echo json_encode([
				'status' => 'success',
				'message' => 'Scan success',
				'data' => $barcode_data
			]);
		}
		else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Order details and barcode details are different'
			]);
			return;
		}
  }

	public function remove_cartoon(){
		$barcode = $this->input->post('barcode');
		$packing_list_id = $this->input->post('packing_list_id');
		$barcode_data = $this->barcode_model->get_barcode_from_code($barcode);
		$res = $this->packing_list_model->remove_cartoon($packing_list_id, $barcode, $barcode_data['qty'], $barcode_data['net_weight']);

		$item_details = $this->packing_list_model->get_packing_list_item_from_barcode($packing_list_id, $barcode);
		if($item_details != null && $item_details['ctn_qty'] <= 0){
			$this->packing_list_model->delete_cartoon($packing_list_id, $barcode);
		}

		if($res == true){
			echo json_encode([
				'status' => 'success',
				'message' => 'Barcode removed'
			]);
		}
		else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Error occured while removing barcode'
			]);
		}
	}


	public function confirm_packing_list($pack_list_id){
		$pack_list_data = $this->packing_list_model->get_packing_list($pack_list_id);
		if($pack_list_data != null){
				if($pack_list_data['is_confirmed'] == false){
					$this->packing_list_model->confirm_packing_list($pack_list_id);

					$pack_list_items = $this->packing_list_model->get_packing_list_items($pack_list_id);
					if($pack_list_items != null){
						$this->packing_list_model->add_items_to_fg($pack_list_items);
					}

					echo json_encode([
						'status' => 'success',
						'message' => 'Packing list confirmed'
					]);
				}
				else {
					echo json_encode([
						'status' => 'error',
						'message' => 'Already confirmed'
					]);
				}
		}
		else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect paking list id'
			]);
		}
	}



	//Returns...................................................................
	public function packing_return(){
		$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
		$data = array();
		$data['menus'] = $this->login_model->get_authorized_menus();
		$data['menu_code'] = 'MENU_FG';
		$data['site'] = $this->bundle_model->site();
		//$data['packing_list_id'] = $packing_list_id;
		$this->load->view('fg/packing_return', $data);
	}

	public function get_confirmed_cartoons($pack_list_id){
		$data = $this->packing_list_model->get_confirmed_cartoons($pack_list_id);
		$data = [
			'status' => 'success',
			'bundle_chart' => $data
		];
		echo json_encode($data);
	}


	public function return_packing_items(){
		$header_id = $this->input->post('header_id');
		$return_list = $this->input->post('return_list');

//echo json_encode($return_list);
//die();
		// $barcode_data = $this->barcode_mo;del->get_barcode_from_code($barcode);
		// if($barcode_data == null || $barcode_data == false){ //no saved barcode
		// 	echo json_encode([
		// 		'status' => 'error',
		// 		'message' => 'Incorrect Barcode'
		// 	]);
		// 	return;
		// }

		//check barcode has shipment details
		// $fg_shipment_data = $this->packing_list_model->get_fg_shipment_data($header_id, $order_id, $barcode);
		// if($fg_shipment_data == null || $fg_shipment_data == false){
		// 	echo json_encode([
		// 		'status' => 'error',
		// 		'message' => 'Incorrect Data'
		// 	]);
		// 	return;
		// }
		if($return_list != null && sizeof($return_list) > 0){
			foreach ($return_list as $row) {
				$fg_return_data = $this->packing_list_model->get_fg_return_data($header_id, $row['order_id'], $row['size_id']);

				if($fg_return_data != null && $fg_return_data != false){// already existing barcode
					// if(($fg_return_data['qty'] + $barcode_data['qty']) >  $fg_shipment_data['qty']){
					// 	echo json_encode([
					// 		'status' => 'error',
					// 		'message' => 'Return qty cannot be grater than fg qty'
					// 	]);
					// 	return;
					// }
					$this->packing_list_model->update_fg_return_item($header_id, $row['order_id'], $row['size_id'], $row['qty']);
				}
				else {//new barcode
					$this->packing_list_model->add_return_items_to_fg($header_id, $row['order_id'], $row['size_id'], $row['qty']);
				}
			}
		}
		echo json_encode([
			'status' => 'success',
			'message' => 'Scan success',
			//'data' => $barcode_data
		]);
}


public function packing_list_return_print($pack_list_id) {

	$user_first_name = $this->session->userdata('first_name');
	$user_last_name = $this->session->userdata('last_name');

	$pack_list = $this->packing_list_model->get_packing_list($pack_list_id);
	$order_details = $this->packing_list_model->get_orders_from_customer_po($pack_list['customer_po']);
	$order_ids_arr = [];

	foreach ($order_details as $row) {
		array_push($order_ids_arr, $row['order_id']);
	}
	$order_ids = join(',', $order_ids_arr);

	$total_orders_qty = $this->packing_list_model->get_order_qty_sum($order_ids);
	$total_ship_qty = $this->packing_list_model->get_ship_qty_sum($order_ids);
	$sizes = $this->packing_list_model->get_order_sizes($order_ids);

	$data = array();
	$data['data'] = $this->packing_list_model->get_shipment_return_print($pack_list_id);
	$data['total_orders_qty'] = $total_orders_qty;
	$data['total_ship_qty'] = $total_ship_qty;
	$data['sizes'] = $sizes;
	$data['printed_by'] = $user_first_name.' '.$user_last_name;
	$data['printed_date'] = date("Y-m-d H:i:s");

	$this->load->view('fg/packing_list_return_print', $data);
}



//container packing list summery -----------------------------------------------

public function fg_container_packing_list(){
	$this->login_model->user_authentication('FG_PACK_LIST'); // user permission authentication
	$data = array();
	$data['menus'] = $this->login_model->get_authorized_menus();
	$data['menu_code'] = 'MENU_FG';
	$date = date('Y-m-d H:i:s');
	$data['current_date'] = date("jS M Y", strtotime($date));
	$this->load->view('fg/container_packing_list', $data);
}

public function fg_container_packing_list_data(){
	$container_no = $this->input->post('container_no');
	$data = $this->packing_list_model->get_container_packing_list($container_no);
	echo json_encode([
		'data' => $data
	]);
}

}
