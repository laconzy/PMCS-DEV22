<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Production_Model extends CI_Model
{

	public function __construct()
	{

		parent::__construct();

		$this->load->database();
	}

	/*     * public function create($data) {

	  $this->db->insert_batch('cut_bundles', $data);

	  } */

	public function destroy(/* $order_id, */ $operation_id, /* $operation_point, */ $barcode)
	{

		//$this->db->where('order_id', $order_id);

		$this->db->where('operation', $operation_id);

		//$this->db->where('operation_point', $operation_point);

		$this->db->where('barcode', $barcode);

		$this->db->delete('production');


		if ($operation_id==3) {
		$this->db->where('operation', 9);

		//$this->db->where('operation_point', $operation_point);

		$this->db->where('barcode', $barcode);

		$this->db->delete('production');
		}
		if ($operation_id==4) {
		//$this->db->where('operation', 9);

		//$this->db->where('operation_point', $operation_point);

		$this->db->where('barcode', $barcode);

		$this->db->delete('fg');
		}
		return true;
	}

	/*  public function destroy_all($laysheet_no) {

	  $this->db->where('laysheet_no', $laysheet_no);

	  $this->db->delete('cut_bundles');

	  return true;

	  } */

	public function get_cut_bundle($barcode)
	{

		$this->db->select('cut_bundles.*,cut_bundles.site as line_no');

		$this->db->from('cut_bundles');

		$this->db->where('barcode', $barcode);

		$query = $this->db->get();
		$a = $query->row_array();

		return $a;
	}

	public function get_cut_bundle_2($barcode)
	{

		$this->db->select('cut_bundles_2.*,cut_bundles_2.site as line_no');

		$this->db->from('cut_bundles_2');

		$this->db->where('barcode', $barcode);

		$query = $this->db->get();
		$a = $query->row_array();

		return $a;
	}

	public function get_barcode_data($barcode)
	{

		//         $insert_data = [
		//            'order_id' => $data['order_id'],
		//            'laysheet_no' => $data['laysheet_no'],
		//            'bundle_no' => $data['bundle_no'],
		//            'barcode' => $data['barcode'],
		//            'item' => $data['item'],
		//            'size' => $data['size'],
		//            'qty' => $data['qty'],
		//            'color' => $data['color'],
		//            'created_by' => $user,
		//            'created_date' => $cur_date,
		//            'operation' => $operation,
		//            'operation_point' => $operation_point,
		//            'line_no' => $line_no,
		//            'scan_date' => $scan_date
		//        ];
		$sql = "SELECT
	barcode.id laysheet_no,
	barcode.barcode_no,
	barcode.`no` bundle_no,
	barcode.printed_by,
	barcode.printed_date,
	fg_barcode.barcode,
	fg_barcode.size_id size,
	fg_barcode.item_id item,
	fg_barcode.qty,
	fg_barcode.color,
	size.size_code,
	item.item_code,
	fg_barcode.order_id,
	(SELECT
	Sum(p.qty) AS qty
	FROM
	production AS p
	WHERE
	p.order_id = fg_barcode.order_id AND
	p.size = 	fg_barcode.size_id AND
	p.operation = '9' AND
	p.color = fg_barcode.color AND
	p.item = fg_barcode.item_id) qty_in,
	(SELECT
	Sum(p.qty) AS qty
	FROM
	production AS p
	WHERE
	p.order_id = fg_barcode.order_id AND
	p.size = fg_barcode.size_id AND
	p.operation = '4' AND
	p.color = 	fg_barcode.color AND
	p.item = fg_barcode.item_id) out_qty
	FROM
	barcode
	INNER JOIN fg_barcode ON barcode.id = fg_barcode.id
	INNER JOIN fg_barcode_head ON fg_barcode.id = fg_barcode_head.id
	INNER JOIN size ON fg_barcode.size_id = size.size_id
	INNER JOIN item ON fg_barcode.item_id = item.item_id
	WHERE
	barcode.barcode_no = '$barcode'
	";
		$query = $this->db->query($sql);

		return $query->result_array();
	}


	public function get_barcode_data2($barcode, $line_no)
	{
		$order_data = $this->get_order_data_from_fg_barcode($barcode);//need to remove later.

		$sql = "SELECT
	barcode.id laysheet_no,
	barcode.barcode_no,
	barcode.`no` bundle_no,
	barcode.printed_by,
	barcode.printed_date,
	fg_barcode.barcode,
	fg_barcode.size_id size,
	fg_barcode.item_id item,
	fg_barcode.qty,
	fg_barcode.color,
	size.size_code,
	item.item_code,
	fg_barcode.order_id,
	(SELECT
	Sum(p.qty) AS qty
	FROM
	production AS p
	WHERE
	p.order_id = fg_barcode.order_id AND
	p.size = 	fg_barcode.size_id AND
	p.operation = '9' AND
	p.color = fg_barcode.color AND
	p.item = fg_barcode.item_id";

	$validation_needed = false;
	if($order_data != null){
		$date1 = "2022-06-06 23:59:59";
		$date2 = $order_data['created_at'];
		$dateTimestamp1 = strtotime($date1);
		$dateTimestamp2 = strtotime($date2);

		if($dateTimestamp2 > $dateTimestamp1){
			$validation_needed = true;
		}
	}

	if($validation_needed){
		$sql .= " AND p.line_no = ".$line_no;
	}

$sql .=") qty_in,
	(SELECT
	Sum(p.qty) AS qty
	FROM
	production AS p
	WHERE
	p.order_id = fg_barcode.order_id AND
	p.size = fg_barcode.size_id AND
	p.operation = '4' AND
	p.color = 	fg_barcode.color AND
	p.item = fg_barcode.item_id";

	if($validation_needed){
		$sql .= " AND p.line_no = ".$line_no;
	}

	$sql .= ") out_qty
	FROM
	barcode
	INNER JOIN fg_barcode ON barcode.id = fg_barcode.id
	INNER JOIN fg_barcode_head ON fg_barcode.id = fg_barcode_head.id
	INNER JOIN size ON fg_barcode.size_id = size.size_id
	INNER JOIN item ON fg_barcode.item_id = item.item_id
	WHERE
	barcode.barcode_no = '$barcode'";
	//echo $sql;die();
		$query = $this->db->query($sql);

		return $query->result_array();
	}


	public function get_order_data_from_fg_barcode($barcode){
		$sql = "SELECT
		order_head.*
		FROM barcode
		INNER JOIN fg_barcode ON fg_barcode.id = barcode.id
		INNER JOIN order_head ON order_head.order_id = fg_barcode.order_id
		WHERE barcode.barcode_no = '".$barcode."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function is_barcode_exists(/* $order_id, */ $operation, /* $operation_point, */ $barcode)
	{

		$this->db->from('production');

		//$this->db->where('order_id',$order_id);

		$this->db->where('operation', $operation);

		//$this->db->where('operation_point',$operation_point);

		$this->db->where('barcode', $barcode);


		$count = $this->db->count_all_results();
//echo  $this->db->last_query();
		return ($count > 0) ? true : false;
	}

	public function add_item_to_production($data, $operation, $operation_point, $line_no, $scan_date,$shift, $previous_operation, $shift_type = null)
	{
		$user = $this->session->userdata('user_id');
		$cur_date = date("Y-m-d H:i:s");
		$is_completed = $operation==3 ? 1 : null;

		$insert_data = [
			'order_id' => $data['order_id'],
			'laysheet_no' => $data['laysheet_no'],
			'bundle_no' => $data['bundle_no'],
			'barcode' => $data['barcode'],
			'item' => $data['item'],
			'size' => $data['size'],
			'qty' => $data['qty'],
			'color' => $data['color'],
			'created_by' => $user,
			'created_date' => $cur_date,
			'operation' => $operation,
			'operation_point' => $operation_point,
			'line_no' => $line_no,
			'scan_date' => $scan_date,
			'shift' => $shift,
			'from_line'=> $data['line_no'],
			'shift_type' => $shift_type,
			'prev_operation' => $previous_operation,
			'is_completed' => $is_completed
		];


		$this->db->insert('production', $insert_data);
		if($operation==3){
			$insert_data2 = [
				'order_id' => $data['order_id'],
				'laysheet_no' => $data['laysheet_no'],
				'bundle_no' => $data['bundle_no'],
				'barcode' => $data['barcode'],
				'item' => $data['item'],
				'size' => $data['size'],
				'qty' => $data['qty'],
				'color' => $data['color'],
				'created_by' => $user,
				'created_date' => $cur_date,
				'operation' => 9,
				'operation_point' => $operation_point,
				'line_no' => $line_no,
				'scan_date' => $scan_date,
				'shift' => $shift,
				'from_line'=> $data['line_no'],
				'prev_operation' => $operation,
				'is_completed' => 1
			];
			$this->db->insert('production', $insert_data2);
		}

		return true;
	}

	public function add_manual_item_to_production($data, $operation, $operation_point, $line_no, $scan_date,$shift,$location,$site,$hour, $shift_type)
	{

		$user = $this->session->userdata('user_id');

//print_r($data);
		$cur_date = date("Y-m-d H:i:s");
		foreach ($data as $row) {
			$insert_data = [
				'order_id' => $row['order_id'],
				'laysheet_no' => 0 ,
				'bundle_no' => $row['bundle_no'],
				'barcode' => $row['barcode_no'],
				'item' => $row['item'],
				'size' => $row['size'],
				'qty' => $row['qty'],
				'color' => $row['color'],
				'created_by' => $user,
				'created_date' => $cur_date,
				'operation' => $operation,
				'operation_point' => $operation_point,
				'line_no' => $line_no,
				'scan_date' => $scan_date,
				'shift' => $shift,
				'hour' => $hour,
				'shift_type' => $shift_type
			];

			$this->db->insert('production', $insert_data);
			$this->fg_model->update_fg($row['order_id'],$row['bundle_no'],$row['barcode_no'],$row['item'],$row['size'],$row['qty'],$user,$cur_date,'FG_RECEIVE',$row['color'],$site,$location, $scan_date,$line_no);
		}


		return true;
	}

	public function get_bundle_from_production(/* $order_id, */ $operation, /* $operation_point, */ $barcode)
	{
		$this->db->select('production.*,size.size_code,line.line_code,item.item_code,color.color_code');
		$this->db->from('production');
		$this->db->join('size', 'production.size = size.size_id');
		$this->db->join('item', 'production.item = item.item_id');
		$this->db->join('color', 'production.color = color.color_id');
		$this->db->join('line', 'production.line_no = line.line_id', 'left');
		//$this->db->where('production.order_id',$order_id);
		$this->db->where('production.operation', $operation);
		//$this->db->where('production.operation_point',$operation_point);
		$this->db->where('production.barcode', $barcode);
		$query = $this->db->get();
		// echo 123;
		//echo $this->db->last_query();
		return $query->row_array();
	}

	public function get_bundle_from_grn($order_id, $operation, $barcode)
	{

		$this->db->select('grn_details.*,size.size_code');

		$this->db->from('grn_details');

		$this->db->join('size', 'grn_details.size = size.size_id');

		$this->db->where('grn_details.order_id', $order_id);

		$this->db->where('grn_details.operation', $operation);

		$this->db->where('grn_details.barcode', $barcode);

		$query = $this->db->get();

		return $query->row_array();
	}

	public function get_qty($order, $component, $color, $size, $operation)
	{

		$sql = "SELECT
					Sum(production.qty) total
					FROM `production`
					WHERE
					production.order_id = '1' AND
					production.item = '6' AND
					production.size = '7' AND
					production.operation = '4' AND
					production.color = '19'";

		$query = $this->db->query($sql);
		return $query->row_array();
	}

public function site()
	{

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


	public function get_operations_grater_than_seq($seq){
		$sql = "SELECT operation.* FROM operation WHERE operation.seq > ".$seq;
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function check_bundle_moved_to_next_operations($barcode, $current_operation_seq){
		$sql = "SELECT
		production.*
		FROM production
		INNER JOIN operation ON operation.operation_id = production.operation
		WHERE production.barcode = '".$barcode."' AND operation.seq > ".$current_operation_seq;
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function check_bundle_list_moved_to_next_operations($barcode_list, $current_operation_seq){
		$sql = "SELECT
		production.*
		FROM production
		INNER JOIN operation ON operation.operation_id = production.operation
		WHERE production.barcode IN (".$barcode_list.") AND operation.seq > ".$current_operation_seq;
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function get_order($order_id){
		$this->db->from('order_head');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		return $query->row_array();
	}


	public function complete_production_operation($barcode, $operation){
		$this->db->where('barcode', $barcode);
		$this->db->where('operation', $operation);
		$this->db->update('production', ['is_completed' => 1]);
	}

	public function incomplete_production_operation($barcode, $operation){
		$this->db->where('barcode', $barcode);
		$this->db->where('operation', $operation);
		$this->db->update('production', ['is_completed' => null]);
	}


	public function get_style_operation($style_id, $operation_id){
		$sql = "SELECT * FROM style_operations WHERE style_id = ".$style_id." AND operation_id = ".$operation_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_previous_operation($style_id, $operation_id){
		$sql = "SELECT *
		FROM style_operations
		WHERE style_id = ".$style_id." AND operation_order < (
			SELECT operation_order FROM style_operations WHERE style_id = ".$style_id." AND operation_id = ".$operation_id."
		) ORDER BY operation_order DESC LIMIT 0,1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

}
