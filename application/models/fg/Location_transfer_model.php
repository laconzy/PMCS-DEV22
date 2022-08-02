<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Location_Transfer_Model extends CI_Model
{

	public function __construct()	{
		parent::__construct();
		$this->load->database();
	}

	public function get_transfer_list($start,$limit,$search,$order)	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
    fg_transfer_header.*,
		f_line.line_code AS from_line_code,
		t_line.line_code AS to_line_code,
		CONCAT(user.first_name,' ',user.last_name) AS full_name
    FROM fg_transfer_header
		LEFT JOIN user ON user.id = fg_transfer_header.transfered_user
		LEFT JOIN line AS f_line ON f_line.line_id = fg_transfer_header.from_line
		LEFT JOIN line AS t_line ON t_line.line_id = fg_transfer_header.to_line
    WHERE fg_transfer_header.transfer_type='LOCATION' AND fg_transfer_header.id LIKE ".$search_like." OR fg_transfer_header.from_order_id LIKE ".$search_like." OR
    fg_transfer_header.to_order_id LIKE ".$search_like." OR user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like."
		ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_transfer_count($search)
	{
		$search_like = "'%".$search."%'";
    $sql = "SELECT
    COUNT(fg_transfer_header.id) AS row_count
    FROM fg_transfer_header
		LEFT JOIN user ON user.id = fg_transfer_header.transfered_user
		LEFT JOIN line AS f_line ON f_line.line_id = fg_transfer_header.from_line
		LEFT JOIN line AS t_line ON t_line.line_id = fg_transfer_header.to_line
    WHERE fg_transfer_header.transfer_type='LOCATION' AND fg_transfer_header.id LIKE ".$search_like." OR fg_transfer_header.from_order_id LIKE ".$search_like." OR
    fg_transfer_header.to_order_id LIKE ".$search_like." OR user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like;

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


	public function get_orders_from_customer_po($po_no){
		$sql = "SELECT
		order_head.*,
		style.style_code,
		customer.cus_name,
		color.color_code,
		color.color_name
		FROM order_head
		INNER JOIN style ON style.style_id = order_head.style
		INNER JOIN customer ON customer.id = order_head.customer
		INNER JOIN color ON color.color_id = order_head.color
		WHERE order_head.customer_po = '".$po_no."'";

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function get_order_details($order_id) {
		$sql="SELECT
		order_head.*,
		style.style_code,
		style.style_name,
		customer.cus_code,
		customer.cus_name,
		color.color_code,
		color.color_name,
		color.color_code,
		color.color_name
		FROM
		order_head
		INNER JOIN style ON order_head.style = style.style_id
		INNER JOIN customer ON order_head.customer = customer.id
		INNER JOIN color ON color.color_id = order_head.color
		WHERE
		order_head.order_id = '".$order_id."'";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result;
	}


	public function save_header() {
		$from_order_id = $this->input->post('from_order_id');
		$to_order_id = $this->input->post('from_order_id');
		$style_id = $this->input->post('from_style_id');
		$color_id = $this->input->post('from_color_id');
		$from_site_id = $this->input->post('from_site_id');
		$to_site_id = $this->input->post('to_site_id');
		$from_line_id = $this->input->post('from_line_id');
		$to_line_id = $this->input->post('to_line_id');
		$transfer_reason = $this->input->post('transfer_reason');
		$transfer_type = $this->input->post('transfer_type');
		$user_id= $this->session->userdata('user_id');
		$cur_date = date("Y-m-d H:i:s");

		if($transfer_type == 'LEFT_OVER_TO_FG'){
			$to_order_id = $this->input->post('to_order_id');
		}
		else if($transfer_type == 'FG_TO_LEFT_OVER'){
			$to_order_id = 0;
		}

		$form_data = [
			'from_order_id' => $from_order_id,
			'to_order_id' => $to_order_id,
			'transfer_reason' => $transfer_reason,
			'transfered_date' => $cur_date,
			'transfered_user' => $user_id,
			'transfer_type' => 'LOCATION',
			'style' => $style_id,
			'color' => $color_id,
			'from_site' => $from_site_id,
			'to_site' => $to_site_id,
			'from_line' => $from_line_id,
			'to_line' => $to_line_id,
			'transfer_sub_type' => $transfer_type
		];
		$this->db->insert('fg_transfer_header', $form_data);
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
				$this->db->insert('fg_transfer_details', $form_data);
			}
		}
	}


	public function get_size_data($ord_id, $transfer_id = null){
		$sql="SELECT
		order_item_sizes.id,
		order_item_sizes.order_item_id,
		order_item_sizes.order_id,
		order_item_sizes.size,
		order_item_sizes.order_qty,
		order_item_sizes.planned_qty,
		order_item_sizes.balance,
		size.size_code,";

		if($transfer_id != null){
			$sql .= "(
				SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
				AND fg.size = order_item_sizes.size AND fg.operation IN ('TRANSFER_IN') AND fg.fg_transfer_id = ".$transfer_id."
			) AS fg_transfer_in_qty,
			(
				SELECT (SUM(fg.qty) * -1) FROM fg WHERE fg.order_id = order_item_sizes.order_id
				AND fg.size = order_item_sizes.size AND fg.operation IN ('TRANSFER_OUT') AND fg.fg_transfer_id = ".$transfer_id."
			) AS fg_transfer_out_qty,";
		}

		$sql .= "(
			SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
			AND fg.size = order_item_sizes.size AND fg.operation IN ('FG_RECEIVE', 'RETURN','SHIPMENT', 'TRANSFER_IN', 'TRANSFER_OUT')
		) AS fg_qty
		FROM
		order_item_sizes
		INNER JOIN size ON order_item_sizes.size = size.size_id
		WHERE
		order_item_sizes.order_id = ".$ord_id."
		ORDER BY
		size.seq ASC
		";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;
	}


	public function get_ord_qty($ord_id){

		  $sql="SELECT
				sum(order_item_sizes.order_qty) order_qty
				FROM `order_item_sizes`
				WHERE
				order_item_sizes.order_id = '".$ord_id."'

		";
		$query = $this->db->query($sql);

		$result = $query->row_array();
	}


	public function site() {
		$sql = "SELECT
				site.site_code,
				site.id,
				site.site_name,
				site.description
				FROM `site`
				WHERE
				site.active = 'Y'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function transfer_from_fg($from_site_id, $from_line_id, $from_order_id, $style_id, $color_id, $transfer_data, $transfer_id){
		$user_id = $this->session->userdata('user_id');
		foreach ($transfer_data as $row) {
			$data = [
				'order_id' => $from_order_id,
				'size' => $row['size_id'],
				'qty' => ($row['qty'] * -1),
				'created_by' => $user_id,
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'LOCATION_TRANSFER_OUT',
				'line_no' => null,
				'color' => $color_id,
				'style' => $style_id,
				'location' => $from_line_id,
				'packing_list_id' => null,
				'cartoon_barcode' => null,
				'fg_transfer_id' => $transfer_id,
				'operation_point' => 'OUT',
				'site' => $from_site_id
			];
			$this->db->insert('fg', $data);
		}
	}


	public function transfer_to_fg($to_site_id, $to_line_id, $to_order_id, $style_id, $color_id, $transfer_data, $transfer_id){
		$user_id = $this->session->userdata('user_id');
		foreach ($transfer_data as $row) {
			$data = [
				'order_id' => $to_order_id,
				'size' => $row['size_id'],
				'qty' => $row['qty'],
				'created_by' => $user_id,
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'LOCATION_TRANSFER_IN',
				'line_no' => null,
				'color' => $color_id,
				'style' => $style_id,
				'location' => $to_line_id,
				'packing_list_id' => null,
				'cartoon_barcode' => null,
				'fg_transfer_id' => $transfer_id,
				'operation_point' => 'OUT',
				'site' => $to_site_id
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


	public function get_ship_qty_sum($order_ids){
		$sql = "SELECT
			sum(qty) as order_qty
			FROM fg
			WHERE operation = 'SHIPMENT' AND order_id IN (".$order_ids.")";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			if($data == null || $data == false || $data['order_qty'] == null){
				return 0;
			}
			else {
				return ($data['order_qty'] * -1);
			}
	}


	public function get_order_sizes($ord_ids){
		$sql="SELECT
		order_item_sizes.size,
		size.size_code
		FROM
		order_item_sizes
		INNER JOIN size ON order_item_sizes.size = size.size_id
		WHERE
		order_item_sizes.order_id IN (".$ord_ids.")
		GROUP BY order_item_sizes.size ORDER BY size.seq ASC";

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_transfer_header($transfer_id){
		$this->db->select('fg_transfer_header.*,user.first_name,user.last_name');
		$this->db->from('fg_transfer_header');
		$this->db->join('user', 'user.id = fg_transfer_header.transfered_user');
		$this->db->where('fg_transfer_header.id', $transfer_id);
		$query = $this->db->get();
    return $query->row_array();
	}

	public function get_transfer_details($transfer_id){
		$this->db->select('fg_transfer_details.*,size.size_code');
		$this->db->from('fg_transfer_details');
		$this->db->join('size', 'size.size_id = fg_transfer_details.size_id');
		$this->db->where('fg_transfer_details.transfer_id', $transfer_id);
		$query = $this->db->get();
    return $query->result_array();
	}

	public function get_all_transfer_reasons($type){
		$this->db->from('reason');
		$this->db->where('category', $type);
		$this->db->where('active', 'Y');
		$query = $this->db->get();
    return $query->result_array();
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


	//FG to LEFT OVER transfer----------------------------------------------------


	public function get_left_over_stock($line_id, $style_id, $color_id){
		$sql = "SELECT
		fg.size,
		size.size_code,
		SUM(fg.qty) left_over_qty,
		(SELECT SUM(fg_transfer_details.qty) FROM fg_transfer_details
			INNER JOIN fg_transfer_header ON fg_transfer_header.id = fg_transfer_details.transfer_id
			WHERE fg_transfer_details.size_id = fg.size AND fg_transfer_header.style_id = fg.style
			AND fg_transfer_header.color_id = fg.color AND fg_transfer_header.transfer_type = 'LEFT_OVER' AND fg_transfer_details.transfer_id IS NOT NULL
		) AS all_transfered_qty
		FROM fg
		INNER JOIN size ON size.size_id = fg.size
		WHERE fg.style = ".$style_id." AND fg.color = ".$color_id." AND fg.line_no = ".$line_id." AND fg.operation = 'LEFT_OVER'
		GROUP BY fg.size ORDER BY size.seq ASC";
		//echo $sql;die();
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function get_size_data2($ord_id, $transfer_id = null){
		$sql="SELECT
		order_item_sizes.id,
		order_item_sizes.order_item_id,
		order_item_sizes.order_id,
		order_item_sizes.size,
		order_item_sizes.order_qty,
		order_item_sizes.planned_qty,
		order_item_sizes.balance,
		size.size_code,";

		if($transfer_id != null){
			$sql .= "(
				SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
				AND fg.size = order_item_sizes.size AND fg.operation IN ('LEFT_OVER_TRANSFER') AND fg.fg_transfer_id = ".$transfer_id."
			) AS left_over_transfer_qty,";
		}

		$sql .= "(
			SELECT SUM(fg.qty) FROM fg WHERE fg.order_id = order_item_sizes.order_id
			AND fg.size = order_item_sizes.size AND fg.operation IN ('FG_RECEIVE', 'RETURN','SHIPMENT', 'TRANSFER_IN', 'TRANSFER_OUT')
		) AS fg_qty
		FROM
		order_item_sizes
		INNER JOIN size ON order_item_sizes.size = size.size_id
		WHERE
		order_item_sizes.order_id = ".$ord_id."
		ORDER BY
		size.seq ASC";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
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


	public function get_location_stock_by_order_id($order_id, $line_id, $transfer_id){
		$sql = "SELECT
		fg.size,
		size.size_code,
		order_item_sizes.order_qty,
		order_item_sizes.planned_qty,
		SUM(fg.qty) fg_qty,";

		if($transfer_id != null){
			$sql .= "
			(
				SELECT
					SUM(fg_transfer_details.qty)
				FROM
					fg_transfer_details
				WHERE
					fg_transfer_details.size_id = fg.size
					AND fg_transfer_details.transfer_id = ".$transfer_id."
			) AS transfered_qty ";
		}
		else {
			$sql .= "0 AS transfered_qty ";
		}

		$sql .= "FROM
			fg
		INNER JOIN size ON size.size_id = fg.size
		INNER JOIN order_item_sizes ON order_item_sizes.order_id = fg.order_id AND order_item_sizes.size = fg.size
		WHERE
			fg.order_id = ".$order_id."
		AND fg.location = ".$line_id."
		GROUP BY
			fg.size
		ORDER BY
		size.seq ASC";
		//echo $sql;die();
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_location_stock_by_style_and_color($style_id, $color_id, $line_id, $transfer_id){
		$sql = "SELECT
		fg.size,
		size.size_code,
		SUM(fg.qty) fg_qty,";

		if($transfer_id != null){
			$sql .= "
			(
				SELECT
					SUM(fg_transfer_details.qty)
				FROM
					fg_transfer_details
				WHERE
					fg_transfer_details.size_id = fg.size
					AND fg_transfer_details.transfer_id = ".$transfer_id."
			) AS transfered_qty ";
		}
		else {
			$sql .= "0 AS transfered_qty ";
		}

		$sql .= "FROM
			fg
		INNER JOIN size ON size.size_id = fg.size
		WHERE
			fg.style = ".$style_id."
		AND fg.color = ".$color_id."
		AND fg.location = ".$line_id."
		GROUP BY
			fg.size
		ORDER BY
			size.seq ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_tranfer_header($transfer_id){
		$sql = "SELECT
		fg_transfer_header.*,
		from_site.site_name AS from_site_name,
		to_site.site_name AS to_site_name,
		from_line.line_code AS from_line_code,
		to_line.line_code AS to_line_code,
		style.style_code,
		color.color_code,
		reason.reason_text,
		user.first_name,
		user.last_name
		FROM fg_transfer_header
		INNER JOIN site AS from_site ON from_site.id = fg_transfer_header.from_site
		INNER JOIN site AS to_site ON to_site.id = fg_transfer_header.to_site
		INNER join line AS from_line ON from_line.line_id = fg_transfer_header.from_line
		INNER join line AS to_line ON to_line.line_id = fg_transfer_header.to_line
		INNER JOIN style ON style.style_id = fg_transfer_header.style
		INNER JOIN color ON color.color_id = fg_transfer_header.color
		INNER JOIN reason ON reason.reason_id = fg_transfer_header.transfer_reason
		LEFT JOIN user ON user.id = fg_transfer_header.transfered_user
		WHERE fg_transfer_header.id = ".$transfer_id;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result;
	}


}
