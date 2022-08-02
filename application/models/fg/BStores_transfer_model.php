<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class BStores_Transfer_Model extends CI_Model
{

	public function __construct()	{
		parent::__construct();
		$this->load->database();
	}

	public function get_transfer_list($start,$limit,$search,$order)	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
    bstores_transfer_header.*,
		CONCAT(user.first_name,' ',user.last_name) AS full_name,
		color.color_code,
		style.style_code
    FROM bstores_transfer_header
		LEFT JOIN user ON user.id = bstores_transfer_header.transfered_user
		INNER JOIN color ON color.color_id = bstores_transfer_header.color_id
		INNER JOIN style ON style.style_id = bstores_transfer_header.style_id
    WHERE bstores_transfer_header.id LIKE ".$search_like." OR bstores_transfer_header.transfer_order_id LIKE ".$search_like." OR
    color.color_code LIKE ".$search_like." OR	style.style_code LIKE ".$search_like." OR
		user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like."
		ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_transfer_count($search)
	{
		$search_like = "'%".$search."%'";
    $sql = "SELECT
    COUNT(bstores_transfer_header.id) AS row_count
    FROM bstores_transfer_header
		LEFT JOIN user ON user.id = bstores_transfer_header.transfered_user
		INNER JOIN color ON color.color_id = bstores_transfer_header.color_id
		INNER JOIN style ON style.style_id = bstores_transfer_header.style_id
    WHERE bstores_transfer_header.id LIKE ".$search_like." OR bstores_transfer_header.transfer_order_id LIKE ".$search_like." OR
    color.color_code LIKE ".$search_like." OR	style.style_code LIKE ".$search_like." OR
		user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like;

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


	public function get_all_styles(){
		$this->db->from('style');
		$this->db->where('active', 'Y');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_style_colors($style_id) {
		$sql="SELECT
		color.color_id,
		color.color_code
		FROM order_head
		INNER JOIN color ON color.color_id = order_head.color
		WHERE order_head.style = ".$style_id."
		GROUP BY order_head.color";

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function get_transfer_reasons($type){
		$this->db->from('reason');
		if($type == 'FG_TRANSFER'){
			$this->db->where('category', 'B STORES FG TRANSFER');
		}
		else if($type == 'LEFT_OVER'){
			$this->db->where('category', 'LEFT OVER TRANSFER');
		}
		else{
			$this->db->where('category', 'B STORES WRITE OFF');
		}
		$this->db->where('active', 'Y');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}


	public function get_orders_from_style_and_color($style_id, $color_id){
		$this->db->from('order_head');
		$this->db->where('style', $style_id);
		$this->db->where('color', $color_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}


	public function get_bstores_stock($style_id, $color_id, $site_id){
		$sql = "SELECT
		rejection.size,
		size.size_code,
		SUM(rejection.qty) bstores_qty,
		(SELECT SUM(bstores_transfer_details.qty) FROM bstores_transfer_details
			INNER JOIN bstores_transfer_header ON bstores_transfer_header.id = bstores_transfer_details.transfer_id
			WHERE bstores_transfer_details.size_id = rejection.size AND bstores_transfer_header.style_id = order_head.style
			AND bstores_transfer_header.color_id = order_head.color AND bstores_transfer_details.transfer_id IS NOT NULL
		) AS all_transfered_qty
		FROM rejection
		INNER JOIN size ON size.size_id = rejection.size
		INNER JOIN order_head ON order_head.order_id = rejection.order_id
		WHERE order_head.style = ".$style_id." AND order_head.color = ".$color_id." AND rejection.receive_location = ".$site_id."
		GROUP BY rejection.size ORDER BY size.seq ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_bstores_stock_after_transfer($style_id, $color_id, $transfer_id){
		$sql = "SELECT
		rejection.size,
		size.size_code,
		SUM(rejection.qty) bstores_qty,
		(SELECT SUM(bstores_transfer_details.qty) FROM bstores_transfer_details
			INNER JOIN bstores_transfer_header ON bstores_transfer_header.id = bstores_transfer_details.transfer_id
			WHERE bstores_transfer_details.size_id = rejection.size AND bstores_transfer_header.style_id = order_head.style
			AND bstores_transfer_header.color_id = order_head.color AND bstores_transfer_details.transfer_id IS NOT NULL
		) AS all_transfered_qty,
		(SELECT bstores_transfer_details.qty FROM bstores_transfer_details
			WHERE bstores_transfer_details.size_id = rejection.size AND bstores_transfer_details.transfer_id = ".$transfer_id."
		) AS transfered_qty
		FROM rejection
		INNER JOIN size ON size.size_id = rejection.size
		INNER JOIN order_head ON order_head.order_id = rejection.order_id
		WHERE order_head.style = ".$style_id." AND order_head.color = ".$color_id."
		GROUP BY rejection.size ORDER BY size.seq ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_order_stock($order_id){
		$sql = "SELECT
		order_item_sizes.id,
		order_item_sizes.order_id,
		order_item_sizes.size,
		order_item_sizes.order_qty,
		order_item_sizes.planned_qty,
		size.size_code,
		(
			SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
			AND fg.size = order_item_sizes.size
		) AS fg_qty
		FROM
		order_item_sizes
		INNER JOIN size ON order_item_sizes.size = size.size_id
		WHERE
		order_item_sizes.order_id = ".$order_id."
		ORDER BY size.seq ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function save_header() {
		$style_id = $this->input->post('style_id');
		$color_id = $this->input->post('color_id');
		$order_id = $this->input->post('order_id');
		$line_id = $this->input->post('line_id');
		$site_id = $this->input->post('site_id');
		$transfer_reason = $this->input->post('transfer_reason');
		$transfer_type = $this->input->post('transfer_type');
		$line_id = null;
		$user_id= $this->session->userdata('user_id');
		$cur_date = date("Y-m-d H:i:s");

		if($transfer_type == 'WRITEOFF' || $transfer_type == 'LEFT_OVER'){
			$order_id = null;
		}
		if($transfer_type == 'LEFT_OVER' || $transfer_type == 'FG_TRANSFER'){
			$line_id = $this->input->post('line_id');
		}

		$form_data = [
			'style_id' => $style_id,
			'color_id' => $color_id,
			'transfer_order_id' => $order_id,
			'transfer_reason' => $transfer_reason,
			'transfered_date' => $cur_date,
			'transfered_user' => $user_id,
			'transfer_type' => $transfer_type,
			'line_id' => $line_id,
			'transfer_type' => $transfer_type,
			'site_id' => $site_id
		];
		$this->db->insert('bstores_transfer_header', $form_data);
		return $this->db->insert_id();
	}


	public function save_details($header_id){
		$data = $this->input->post('transfer_details');
		$cur_date = date("Y-m-d H:i:s");

		if($data != null and sizeof($data) > 0){
			foreach ($data as $row) {
				$form_data = [
					'transfer_id' => $header_id,
					'size_id' => $row['size_id'],
					'qty' => $row['qty'],
					'transfered_date' => $cur_date
				];
				$this->db->insert('bstores_transfer_details', $form_data);
			}
		}
	}


	// public function get_size_data($ord_id, $transfer_id = null){
	// 	$sql="SELECT
	// 	order_item_sizes.id,
	// 	order_item_sizes.order_item_id,
	// 	order_item_sizes.order_id,
	// 	order_item_sizes.size,
	// 	order_item_sizes.order_qty,
	// 	order_item_sizes.planned_qty,
	// 	order_item_sizes.balance,
	// 	size.size_code,";
	//
	// 	if($transfer_id != null){
	// 		$sql .= "(
	// 			SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
	// 			AND fg.size = order_item_sizes.size AND fg.operation IN ('TRANSFER_IN') AND fg.fg_transfer_id = ".$transfer_id."
	// 		) AS fg_transfer_in_qty,
	// 		(
	// 			SELECT (SUM(fg.qty) * -1) FROM fg WHERE fg.order_id = order_item_sizes.order_id
	// 			AND fg.size = order_item_sizes.size AND fg.operation IN ('TRANSFER_OUT') AND fg.fg_transfer_id = ".$transfer_id."
	// 		) AS fg_transfer_out_qty,";
	// 	}
	//
	// 	$sql .= "(
	// 		SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
	// 		AND fg.size = order_item_sizes.size AND fg.operation IN ('FG_RECEIVE', 'RETURN','SHIPMENT', 'TRANSFER_IN', 'TRANSFER_OUT')
	// 	) AS fg_qty
	// 	FROM
	// 	order_item_sizes
	// 	INNER JOIN size ON order_item_sizes.size = size.size_id
	// 	WHERE
	// 	order_item_sizes.order_id = ".$ord_id."
	// 	ORDER BY
	// 	size.seq ASC
	// 	";
	// 	$query = $this->db->query($sql);
	//
	// 	$result = $query->result_array();
	// 	//print_r($result);
	// 	return $result;
	// }


	// public function get_ord_qty($ord_id){
	//
	// 	  $sql="SELECT
	// 			sum(order_item_sizes.order_qty) order_qty
	// 			FROM `order_item_sizes`
	// 			WHERE
	// 			order_item_sizes.order_id = '".$ord_id."'
	//
	// 	";
	// 	$query = $this->db->query($sql);
	//
	// 	$result = $query->row_array();
	// }


	// public function site() {
	// 	$sql = "SELECT
	// 			site.site_code,
	// 			site.id,
	// 			site.site_name,
	// 			site.description
	// 			FROM `site`
	// 			WHERE
	// 			site.active = 'Y'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result_array();
	// }


	public function transfer_from_bstores($style_id, $color_id, $transfer_data, $transfer_id, $transfer_type, $site_id){
		$user_id = $this->session->userdata('user_id');
		foreach ($transfer_data as $row) {
			$data = [
				'order_id' => null,
				'size' => $row['size_id'],
				'qty' => ($row['qty'] * -1),
				'created_date' => date("Y-m-d H:i:s"),
				'created_by' => $user_id,
				'operation' => 'F',
				'operation_name' => 'FAIL',
				'line_no' => null,
				'status' => 'CONFIRMED',
				'scan_date' => null,
				'shift' => null,
				'hour' => null,
				'style_id' => $style_id,
				'color_id' => $color_id,
				'transfer_id' => $transfer_id,
				'transfer_status' => $transfer_type,
				'receive_location' => $site_id
			];
			$this->db->insert('rejection', $data);
		}
	}


	public function transfer_to_fg($to_order_id, $transfer_data, $transfer_id, $site_id, $line_id, $style_id, $color_id){
		$user_id = $this->session->userdata('user_id');

		foreach ($transfer_data as $row) {
			$data = [
				'order_id' => $to_order_id,
				'size' => $row['size_id'],
				'qty' => $row['qty'],
				'created_by' => $user_id,
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'FG_TRANSFER_IN',
				'line_no' => null,
				'color' => $color_id,
				'style' => $style_id,
				'location' => $line_id,
				'packing_list_id' => null,
				'cartoon_barcode' => null,
				'fg_transfer_id' => $transfer_id,
				'operation_point' => 'OUT',
				'site' => $site_id
			];
			$this->db->insert('fg', $data);
		}
	}


	public function transfer_to_left_over($line_id, $transfer_data, $transfer_id, $site_id, $style_id, $color_id){
		$user_id = $this->session->userdata('user_id');
		foreach ($transfer_data as $row) {
			$data = [
				'order_id' => 0,
				'size' => $row['size_id'],
				'qty' => $row['qty'],
				'created_by' => $user_id,
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'LEFT_OVER_IN',
				'line_no' => null,
				'color' => $color_id,
				'style' => $style_id,
				'location' => $line_id,
				'packing_list_id' => null,
				'cartoon_barcode' => null,
				'fg_transfer_id' => $transfer_id,
				'operation_point' => 'OUT',
				'site' => $site_id
			];
			$this->db->insert('fg', $data);
		}
	}


	public function get_order_qty_sum($order_ids){
		$sql = "SELECT
			sum(order_qty) as order_qty
			FROM order_item_sizes
			WHERE order_id IN (".$order_ids.")";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			if($data == null || $data == false || $data['order_qty'] == null){
				return 0;
			}
			else {
				return $data['order_qty'];
			}
	}


	// public function get_ship_qty_sum($order_ids){
	// 	$sql = "SELECT
	// 		sum(qty) as order_qty
	// 		FROM fg
	// 		WHERE operation = 'SHIPMENT' AND order_id IN (".$order_ids.")";
	// 		$query = $this->db->query($sql);
	// 		$data = $query->row_array();
	// 		if($data == null || $data == false || $data['order_qty'] == null){
	// 			return 0;
	// 		}
	// 		else {
	// 			return ($data['order_qty'] * -1);
	// 		}
	// }


	// public function get_order_sizes($ord_ids){
	// 	$sql="SELECT
	// 	order_item_sizes.size,
	// 	size.size_code
	// 	FROM
	// 	order_item_sizes
	// 	INNER JOIN size ON order_item_sizes.size = size.size_id
	// 	WHERE
	// 	order_item_sizes.order_id IN (".$ord_ids.")
	// 	GROUP BY order_item_sizes.size ORDER BY size.seq ASC";
	//
	// 	$query = $this->db->query($sql);
	// 	$result = $query->result_array();
	// 	return $result;
	// }


	public function get_transfer_header_for_print($transfer_id){
		$this->db->select('bstores_transfer_header.*,user.first_name,user.last_name');
		$this->db->from('bstores_transfer_header');
		$this->db->join('user', 'user.id = bstores_transfer_header.transfered_user');
		$this->db->where('bstores_transfer_header.id', $transfer_id);
		$query = $this->db->get();
    return $query->row_array();
	}

	public function get_transfer_details($transfer_id){
		$this->db->select('bstores_transfer_details.*,size.size_code');
		$this->db->from('bstores_transfer_details');
		$this->db->join('size', 'size.size_id = bstores_transfer_details.size_id');
		$this->db->where('bstores_transfer_details.transfer_id', $transfer_id);
		$query = $this->db->get();
    return $query->result_array();
	}

	// public function get_all_transfer_reasons(){
	// 	$this->db->from('reason');
	// 	$this->db->where('category', 'FG TRANSFER');
	// 	$this->db->where('active', 'Y');
	// 	$query = $this->db->get();
  //   return $query->result_array();
	// }


	public function get_tranfer_header($transfer_id){
		$sql = "SELECT
		bstores_transfer_header.*,
		site.site_name
		FROM bstores_transfer_header
		LEFT JOIN site ON site.id = bstores_transfer_header.site_id
		WHERE bstores_transfer_header.id = ".$transfer_id;
		//$this->db->from('bstores_transfer_header');
		//$this->db->where('id', $transfer_id);
		$query = $this->db->query($sql);
    return $query->row_array();
	}


	public function get_style($style_id){
		$this->db->from('style');
		$this->db->where('style_id', $style_id);
		$query = $this->db->get();
    return $query->row_array();
	}

	public function get_color($color_id){
		$this->db->from('color');
		$this->db->where('color_id', $color_id);
		$query = $this->db->get();
    return $query->row_array();
	}


	public function get_transfer_reason($reason_id){
		$this->db->from('reason');
		$this->db->where('reason_id', $reason_id);
		$query = $this->db->get();
    return $query->row_array();
	}

	public function get_left_over_lines(){
		$sql = "SELECT * FROM line WHERE line_id IN (66, 67)";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
}
