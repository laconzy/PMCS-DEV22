<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barcode_Transfer_Model extends CI_Model
{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add_transfer($transfer_type, $barcode, $operation, $transfer_line, $transfer_shift){
		$current_timestamp = date("Y-m-d H:i:s");
		$current_user = $this->session->userdata('user_id');
		$data = [
			'transfer_type' => $transfer_type,
			'barcode' => $barcode,
			'operation' => $operation,
			'transfer_line' => $transfer_line,
			'transfer_shift' => $transfer_shift,
			'transfered_at' => $current_timestamp,
			'transfered_by' => $current_user
		];
		$this->db->insert('barcode_transfers', $data);
		return $this->db->insert_id();
	}


	public function transfer_line($barcode, $operation, $transfer_line){
		$data = [
			'line_no' => $transfer_line
		];
		$this->db->where('barcode', $barcode);
		$this->db->where('operation', $operation);
		$this->db->update('production', $data);

		if($operation == 9){ //Line In
			$data = [
				'line_no' => $transfer_line
			];
			$this->db->where('barcode', $barcode);
			$this->db->where('operation', 3);
			$this->db->update('production', $data);
		}
	}


	public function transfer_shift($barcode, $operation, $transfer_shift){
		$data = [
			'shift' => $transfer_shift
		];
		$this->db->where('barcode', $barcode);
		$this->db->where('operation', $operation);
		$this->db->update('production', $data);

		if($operation == 9){ //Line In
			$data = [
				'shift' => $transfer_shift
			];
			$this->db->where('barcode', $barcode);
			$this->db->where('operation', 3);
			$this->db->update('production', $data);
		}
	}


	public function get_barcode_data($barcode, $operation){
		$this->db->where('barcode', $barcode);
		$this->db->where('operation', $operation);
		$this->db->from('production');
		$query = $this->db->get();
		return $query->row_array();
	}


	public function get_operations(){
		$sql = "SELECT * FROM operation WHERE operation_name NOT IN ('LINE OUT')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function get_transfers($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
		barcode_transfers.*,
		line.line_code,
		operation.operation_name,
		user.first_name,
		user.last_name
		FROM barcode_transfers
		INNER JOIN operation ON operation.operation_id = barcode_transfers.operation
		INNER JOIN user ON user.id = barcode_transfers.transfered_by
		LEFT JOIN line ON line.line_id = barcode_transfers.transfer_line
		WHERE barcode_transfers.id LIKE ".$search_like." OR	transfer_type LIKE ".$search_like." OR barcode LIKE ".$search_like."
		OR operation_name LIKE ".$search_like." OR line_code LIKE ".$search_like." OR transfer_shift LIKE ".$search_like."
		ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_transfers_count($search)
	{
		$search_like = "'%".$search."%'";

		$sql = "SELECT COUNT(barcode_transfers.id) row_count FROM barcode_transfers
				INNER JOIN operation ON operation.operation_id = barcode_transfers.operation
				INNER JOIN user ON user.id = barcode_transfers.transfered_by
				LEFT JOIN line ON line.line_id = barcode_transfers.transfer_line
				WHERE barcode_transfers.id LIKE ".$search_like." OR	transfer_type LIKE ".$search_like." OR barcode LIKE ".$search_like."
				OR operation_name LIKE ".$search_like." OR line_code LIKE ".$search_like." OR transfer_shift LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


	public function get_operation_wise_sum($order_id, $operation, $line_id, $size_id){
		$sql = "SELECT
		SUM(qty) AS total_qty
		FROM production
		WHERE order_id=".$order_id." AND operation=".$operation." AND line_no=".$line_id."
		AND size=".$size_id;
		$query = $this->db->query($sql);
		$data = $query->row_array();
		if($data == null){
			return 0;
		}
		else {
			return $data['total_qty'];
		}
	}

}
