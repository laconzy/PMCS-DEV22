<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recut_Model extends CI_Model
{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function get_bstores_stock($order_id){
		$sql = "SELECT
		rejection.size,
		size.size_code,
		rejection.reason_code,
		rejection_type.rejection_name,
		SUM(rejection.qty) rejection_qty,
		(
			SELECT SUM(recut_request_details.qty) FROM recut_request_details
			INNER JOIN recut_request_header ON recut_request_header.id = recut_request_details.request_id
			WHERE recut_request_details.size_id = rejection.size AND  recut_request_details.reject_reason = rejection.reason_code
			AND recut_request_header.order_id = rejection.order_id
			AND recut_request_details.request_id IS NOT NULL AND recut_request_header.status = 'ACTIVE'
		) AS requested_qty
		FROM rejection
		INNER JOIN size ON size.size_id = rejection.size
		INNER JOIN order_head ON order_head.order_id = rejection.order_id
		LEFT JOIN rejection_type ON rejection_type.id = rejection.reason_code
		WHERE order_head.order_id = ".$order_id."	GROUP BY rejection.size, rejection.reason_code ORDER BY size.seq,rejection.reason_code ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function get_bstores_stock_after_save($order_id, $request_id){
		$sql = "SELECT
		rejection.size,
		size.size_code,
		rejection.reason_code,
		rejection_type.rejection_name,
		SUM(rejection.qty) rejection_qty,
		(
			SELECT SUM(recut_request_details.qty) FROM recut_request_details
			WHERE recut_request_details.size_id = rejection.size AND recut_request_details.reject_reason = rejection.reason_code
			AND recut_request_details.request_id = ".$request_id."
		) AS requested_qty,
		(
			SELECT SUM(recut_request_details.qty) FROM recut_request_details
			INNER JOIN recut_request_header ON recut_request_header.id = recut_request_details.request_id
			WHERE recut_request_details.size_id = rejection.size AND  recut_request_details.reject_reason = rejection.reason_code
			AND recut_request_header.order_id = rejection.order_id
			AND recut_request_details.request_id IS NOT NULL AND recut_request_header.status = 'ACTIVE'
		) AS all_requested_qty
		FROM rejection
		INNER JOIN size ON size.size_id = rejection.size
		INNER JOIN order_head ON order_head.order_id = rejection.order_id
		LEFT JOIN rejection_type ON rejection_type.id = rejection.reason_code
		WHERE order_head.order_id = ".$order_id."	GROUP BY rejection.size,rejection.reason_code ORDER BY size.seq,rejection.reason_code ASC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function save_header() {
		$order_id = $this->input->post('order_id');
		$user_id= $this->session->userdata('user_id');
		$cur_date = date("Y-m-d H:i:s");

		$form_data = [
			'order_id' => $order_id,
			'requested_date' => $cur_date,
			'requested_user' => $user_id,
			'status' => 'ACTIVE'
		];
		$this->db->insert('recut_request_header', $form_data);
		return $this->db->insert_id();
	}


	public function save_details($header_id){
		$data = $this->input->post('transfer_details');
		$cur_date = date("Y-m-d H:i:s");

		if($data != null and sizeof($data) > 0){
			foreach ($data as $row) {
				$form_data = [
					'request_id' => $header_id,
					'size_id' => $row['size_id'],
					'qty' => $row['qty'],
					'reject_reason' => $row['reject_reason'],
					'requested_date' => $cur_date
				];
				$this->db->insert('recut_request_details', $form_data);
			}
		}
	}


	public function get_header($request_id){
		$sql = "SELECT recut_request_header.*,user.first_name,user.last_name FROM recut_request_header
		LEFT JOIN user ON user.id = recut_request_header.requested_user
		WHERE recut_request_header.id = ".$request_id;
		$query = $this->db->query($sql);
    return $query->row_array();
	}


	public function get_recut_list($start,$limit,$search,$order)	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
		recut_request_header.*,
		CONCAT(user.first_name,' ',user.last_name) AS full_name,
		color.color_code,
		style.style_code
		FROM recut_request_header
		INNER JOIN order_head ON order_head.order_id = recut_request_header.order_id
		LEFT JOIN user ON user.id = recut_request_header.requested_user
		INNER JOIN color ON color.color_id = order_head.color
		INNER JOIN style ON style.style_id = order_head.style
		WHERE recut_request_header.id LIKE ".$search_like." OR recut_request_header.order_id LIKE ".$search_like." OR
		color.color_code LIKE ".$search_like." OR	style.style_code LIKE ".$search_like." OR
		user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like."
		ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_recut_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
		COUNT(recut_request_header.id) AS row_count
		FROM recut_request_header
		INNER JOIN order_head ON order_head.order_id = recut_request_header.order_id
		LEFT JOIN user ON user.id = recut_request_header.requested_user
		INNER JOIN color ON color.color_id = order_head.color
		INNER JOIN style ON style.style_id = order_head.style
		WHERE recut_request_header.id LIKE ".$search_like." OR recut_request_header.order_id LIKE ".$search_like." OR
		color.color_code LIKE ".$search_like." OR	style.style_code LIKE ".$search_like." OR
		user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like;

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


	public function destroy($request_id)
  {
		$this->db->where('id', $request_id);
		$this->db->update('recut_request_header', array('status' => 'CANCELLED'));
		return true;
  }


}
