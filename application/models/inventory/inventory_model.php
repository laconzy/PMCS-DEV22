<?php


if (!defined('BASEPATH'))

	exit('No direct script access allowed');


class inventory_model extends CI_Model
{


	private $DB1 = null;
    private $DB2 = null;

    public function __construct()
    {
        parent::__construct();
     //   $this->DB1 = $this->load->database('default',true);
        $this->load->database();
        $this->DB2 = $this->load->database('db2',true);
    }

	// public function __construct()
	// {

	// 	parent::__construct();

	// 	$this->load->database();

	// }


	public function get_po_number()
	{


		$sql = "SELECT
				DISTINCT fabric.allocated_qty PO
				FROM `fabric`
				";

		$query = $this->DB2->query($sql);
		$result= $query->result_array();

		//print_r($result);

		return $result ;
	}

public function stores()
	{


		$sql = "SELECT
stores_location_main_location.id,
stores_location_main_location.main_location_name,
stores_location_main_location.main_location_desc
FROM
	`stores_location_main_location`
				";

		$query = $this->DB2->query($sql);
		$result= $query->result_array();

		//print_r($result);

		return $result ;
	}
public function get_barcode_data($barcode){

	 $sql="SELECT
		fabric.pack_details_id,
		fabric.fab_id,
		fabric.invoice,
		fabric.pi_no,
		fabric.batch_no,
		fabric.role_no,
		fabric.recieved recieved,
		fabric.actchchual actchchual,
		fabric.allocated_qty,
		fabric.bin,
		fabric.width,
		fabric.shade,
		fabric.assigned_id,
		fabric.item_code,
		fabric.ins_status,
		fabric.`comment`,
		fabric.main_stores,
		fabric.sub_stores,
		fabric.bin_code,
		fabric_header.po_no,
		fabric_header.invoice,
		fabric_header.description as description,
		fabric_header.date,
		fabric_header.part_no,
		fabric_header.color,
		(SELECT SUM(rfc.issue) FROM replacement_fabric_packinglist_details AS rfc WHERE rfc.item_code = fabric.item_code) AS packed_qty
		FROM
		fabric
		INNER JOIN fabric_header ON fabric_header.id = fabric.fab_id
		WHERE
		fabric.item_code = '".$barcode."' AND fabric.ins_status = 'Pass'";
		//echo $sql;die();
		$query = $this->DB2->query($sql);
		$result= $query->row_array();
//print_r($result);
		return $result ;

}


	public function get_fabric_header($id){
		$this->DB2->where('id', $id);
		$this->DB2->from('fabric_header');
		$query = $this->DB2->get();
		return $query->row_array();
	}


	public function create_packing_list($scan_date, $laysheet, $customer, $style,$order_code, $remarks)
	{
		$user_id = $this->session->userdata('user_id');
		$user_name = $this->session->userdata('username');
		$data = array(
			//'ord_no' => $this->input->post('ord_no'),
			'laysheet_no' => $laysheet,
			'from_fatory_id' => 3,
			'to_factory_id' => 3,
			'from_factory_name' => 'Dignity DTRT',
			'to_factory_name' => 'DIGNITY DTRT',
			'date' => $scan_date,
			'savedby' => $user_id,
			'stat' => 'added',
			'pcd' => null,
			'lot_no' => null,
			'style_no' => $style,//add new form field -> text field
			'attention' => '*',
			'buyer_code' => $customer,
			//'buyer_po' => $buyer_po,
			'order_code' => $order_code,
			'seal_no' => '*',
			'driver' => '*',
			'vehicle_no' => '*',
			'advicedby' => '*',
			'remarks' => $remarks,
			'user_name' => $user_name,
			'category' => '*',
			'factory_code' => 3
			// 'created_by' => $this->session->userdata('user_id')
		);

		$this->DB2->insert('replacement_fabric_packinglist', $data);
		$insert_id = $this->DB2->insert_id();
		$this->DB2->where('packing_id',$insert_id);
		$this->DB2->update('replacement_fabric_packinglist', ['packing_list_no' => 'RGP10'.$insert_id]);
		return $insert_id;
	}


	public function get_buyer_codes() {
		$query = $this->DB2->get('buyer_code');
		return $query->result_array();
	}



public function get_packing_lists($start,$limit,$search,$order)
{
	$search_like = "'%".$search."%'";
	$sql = "SELECT * FROM replacement_fabric_packinglist WHERE packing_id LIKE ".$search_like." OR
			packing_list_no LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
	$query = $this->DB2->query($sql);
	return $query->result_array();
}

public function get_packing_lists_count($search)
{
	$search_like = "'%".$search."%'";
	$sql = "SELECT COUNT(packing_id) row_count FROM replacement_fabric_packinglist WHERE packing_id LIKE ".$search_like." OR
			packing_list_no LIKE ".$search_like;
	$query = $this->DB2->query($sql);
	$result = $query->row_array();
	return $result['row_count'];
}


public function add_role($pack_list_id, $barcode, $qty){
	$barcode_data = $this->get_barcode_data($barcode);
	$header_data = $this->get_fabric_header($barcode_data['fab_id']);
	$insert_data = [
		'pack_list_id' => $pack_list_id,
		'item_no' => $barcode_data['part_no'],
		'description' => $barcode_data['description'],
		'line_no' => null,
		'invoice' => $barcode_data['invoice'],
		'pi_no' => $barcode_data['pi_no'],
		'batch_no' => $barcode_data['batch_no'],
		'roll_no' => $barcode_data['role_no'],
		'noof_roll' => null,
		'actual' => $qty,
		'issue' => $qty,
		'pack_d_id' => $barcode_data['pack_details_id'],
		'fabric_in_id' => $barcode_data['fab_id'],
		'cut' => null,
		'bin' => $barcode_data['bin'],
		'width' => $barcode_data['width'],
		'shade' => $barcode_data['shade'],
		'factory_receive' => 0,
		'po_no' => $header_data['po_no'],
		'status' => 'saved',
		'category' => null,
		'assign_id' => null,
		'item_code' => $barcode_data['item_code'],
		'main_stores' => $barcode_data['main_stores'],
		'sub_stores' => $barcode_data['sub_stores'],
		'bin_location' => $barcode_data['sub_stores'],
		'bin_code' => $barcode_data['bin_code'],
		'org_qty' => null
	];

	$this->DB2->insert('replacement_fabric_packinglist_details', $insert_data);
	$insert_id = $this->DB2->insert_id();
	return $insert_id;
}


public function get_packing_list_header($packing_id){
	$this->DB2->where('packing_id', $packing_id);
	$this->DB2->from('replacement_fabric_packinglist');
	$query = $this->DB2->get();
	return $query->row_array();
}

public function get_added_role($id){
	$this->DB2->where('pack_details_id', $id);
	$this->DB2->from('replacement_fabric_packinglist_details');
	$query = $this->DB2->get();
	return $query->row_array();
}


public function get_added_roles($packing_id){
	$sql = "SELECT
	replacement_fabric_packinglist_details.*,
	SUBSTRING(replacement_fabric_packinglist_details.description, 1, 30) AS short_description,
	inventory_part_tbl.color_code
	FROM replacement_fabric_packinglist_details
	LEFT JOIN inventory_part_tbl ON inventory_part_tbl.part_no = replacement_fabric_packinglist_details.item_no
	WHERE replacement_fabric_packinglist_details.pack_list_id = ".$packing_id;
	$query = $this->DB2->query($sql);
	return $query->result_array();
}



public function get_packing_roles($packing_id){
	$sql = "SELECT
	replacement_fabric_packinglist_details.*,
	SUBSTRING(replacement_fabric_packinglist_details.description, 1, 30) AS short_description,
	inventory_part_tbl.color_code
	FROM replacement_fabric_packinglist_details
	LEFT JOIN inventory_part_tbl ON inventory_part_tbl.part_no = replacement_fabric_packinglist_details.item_no
	WHERE replacement_fabric_packinglist_details.pack_list_id = ".$packing_id;
	$query = $this->DB2->query($sql);
	return $query->result_array();
}


public function is_already_scanned($packing_id, $barcode){
	$this->DB2->where('pack_list_id', $packing_id);
	$this->DB2->where('item_code', $barcode);
	$this->DB2->from('replacement_fabric_packinglist_details');
	$query = $this->DB2->get();
	$data = $query->result_array();
	if($data == null || sizeof($data) <= 0){
		return false;
	}
	else {
		return true;
	}
}


public function destroy_list($packing_id, $items){
	foreach ($items as $item) {
		$sql = "INSERT INTO replacement_fabric_packinglist_history
			SELECT NULL AS id,replacement_fabric_packinglist_details.* FROM replacement_fabric_packinglist_details
			WHERE replacement_fabric_packinglist_details.pack_list_id = ".$packing_id."
			AND replacement_fabric_packinglist_details.pack_details_id = ".$item;
		$this->DB2->query($sql);

		$this->DB2->where('pack_list_id', $packing_id);
		$this->DB2->where('pack_details_id', $item);
		$this->DB2->delete('replacement_fabric_packinglist_details');
	}
}


public function confirm($packing_id){
	$current_timestamp = date("Y-m-d H:i:s");
	$this->DB2->where('packing_id',$packing_id);
	$this->DB2->update('replacement_fabric_packinglist', ['stat' => 'confirmed', 'confirmed_date' => $current_timestamp]);
}


public function unconfirm($packing_id){
	$current_timestamp = null;//date("Y-m-d H:i:s");
	$this->DB2->where('packing_id',$packing_id);
	$this->DB2->update('replacement_fabric_packinglist', ['stat' => 'added', 'confirmed_date' => $current_timestamp]);
}

//report1 ----------------------------------------------------------------------

public function get_receiving_data($fabric_code, $color, $date_from, $date_to, $received_date_from, $received_date_to, $main_store, $invoice, $pi_no, $status){
	$sql = "SELECT
	fabric.*,
	fabric_header.id,
	fabric_header.po_no,
	fabric_header.part_no,
	fabric_header.description,
	fabric_header.fab_composion,
	fabric_header.color,
	fabric_header.date,
	fabric_header.user_name,
	fabric_header.factory_name,
	fabric_header.line_no,
	fabric_header.release_no,
	fabric_header.style,
	fabric_header.fng_no,
	fabric_header.actual_received_date,
	fabric_header.status
	FROM fabric
	INNER JOIN fabric_header ON fabric_header.id = fabric.fab_id
	WHERE fabric_header.status = '".$status."'";

	if($fabric_code != ''){
		$sql .= " AND fabric_header.part_no = '".$fabric_code."'";
	}

	if($color != ''){
		$sql .= " AND fabric_header.color = '".$color."'";
	}

	if($date_from != '' && $date_to != ''){
		$sql .= " AND fabric_header.date BETWEEN '".$date_from."' AND '".$date_to."'";
	}

	if($received_date_from != '' && $received_date_to != ''){
		$sql .= " AND fabric_header.actual_received_date BETWEEN '".$received_date_from."' AND '".$received_date_to."'";
	}

	if($main_store != ''){
		$sql .= " AND fabric.main_stores = '".$main_store."'";
	}

	if($invoice != ''){
		$sql .= " AND fabric.invoice = '".$invoice."'";
	}

	if($pi_no != ''){
		$sql .= " AND fabric.pi_no = '".$pi_no."'";
	}

	//echo $sql;die();
	$query = $this->DB2->query($sql);
	return $query->result_array();
}


public function get_main_stores(){
	$this->DB2->from('stores_location_main_location');
	$query = $this->DB2->get();
	return $query->result_array();
}

public function allocate_customer_po($customer_po, $barcode_list){
	$data = [
		'allocated_qty' => $customer_po
	];
	$this->DB2->where_in('item_code', $barcode_list);
	$this->DB2->update('fabric', $data);
}


public function get_fabric_allocation_data($fabric_code, $color, $date_from, $date_to, $received_date_from, $received_date_to, $main_store, $invoice, $pi_no, $status, $role_no = null){
	$sql = "SELECT
	fabric.*,
	fabric_header.id,
	fabric_header.po_no,
	fabric_header.part_no,
	fabric_header.description,
	fabric_header.fab_composion,
	fabric_header.color,
	fabric_header.date,
	fabric_header.user_name,
	fabric_header.factory_name,
	fabric_header.line_no,
	fabric_header.release_no,
	fabric_header.style,
	fabric_header.fng_no,
	fabric_header.actual_received_date,
	fabric_header.status,
	purchase_order_header_tbl.customer_po
	FROM fabric
	INNER JOIN fabric_header ON fabric_header.id = fabric.fab_id
	LEFT JOIN purchase_order_header_tbl ON purchase_order_header_tbl.po_no = fabric_header.po_no
	WHERE fabric_header.status = '".$status."'";

	if($fabric_code != ''){
		$sql .= " AND fabric_header.part_no = '".$fabric_code."'";
	}

	if($color != ''){
		$sql .= " AND fabric_header.color = '".$color."'";
	}

	if($date_from != '' && $date_to != ''){
		$sql .= " AND fabric_header.date BETWEEN '".$date_from."' AND '".$date_to."'";
	}

	if($received_date_from != '' && $received_date_to != ''){
		$sql .= " AND fabric_header.actual_received_date BETWEEN '".$received_date_from."' AND '".$received_date_to."'";
	}

	if($main_store != ''){
		$sql .= " AND fabric.main_stores = '".$main_store."'";
	}

	if($invoice != ''){
		$sql .= " AND fabric.invoice = '".$invoice."'";
	}

	if($pi_no != ''){
		$sql .= " AND fabric.pi_no = '".$pi_no."'";
	}

	$parms = [];

	if($role_no != null && $role_no != ''){
		$role_no_list = explode(',', $role_no);
		array_push($parms, $role_no_list);
		$sql .= " AND fabric.role_no IN ?";
	}

	//echo $sql;die();
	$query = $this->DB2->query($sql, $parms);
	return $query->result_array();
}


//fabric inspection ------------------------------------------------------------

public function change_inspection_status($status, $barcode_list){
	$data = [
		'ins_status' => $status
	];
	$this->DB2->where_in('item_code', $barcode_list);
	$this->DB2->update('fabric', $data);
}


public function change_width($width, $barcode_list){
	$data = [
		'width' => $width
	];
	$this->DB2->where_in('item_code', $barcode_list);
	$this->DB2->update('fabric', $data);
}


public function change_shade($shade, $barcode_list){
	$data = [
		'shade' => $shade
	];
	$this->DB2->where_in('item_code', $barcode_list);
	$this->DB2->update('fabric', $data);
}


public function is_role_issued($barcode_list){
	$this->DB2->where_in('item_code', $barcode_list);
	$this->DB2->from('replacement_fabric_packinglist_details');
	$query = $this->DB2->get();
	$data = $query->result_array();
	if($data != null && sizeof($data) > 0){
		return true;
	}
	else {
		return false;
	}
}


//print labels -----------------------------------------------------------------

public function get_print_labels_data($barcodes){

	 $sql="SELECT
		fabric.*,
		DATE_FORMAT(fabric.inspection_date, '%Y-%m-%d') AS ins_date,
		fabric_header.po_no,
		fabric_header.invoice,
		fabric_header.description as description,
		fabric_header.date,
		fabric_header.part_no,
		fabric_header.color,
		fabric_header.buyer_code,
		fabric_header.style,
		fabric_header.fng_no 
		FROM
		fabric
		INNER JOIN fabric_header ON fabric_header.id = fabric.fab_id
		WHERE
		fabric.item_code IN ?";

		$query = $this->DB2->query($sql, [$barcodes]);
		$result= $query->result_array();
		return $result ;
}


public function get_packing_labels_data($barcodes){
	$sql="SELECT
		replacement_fabric_packinglist_details.*,
		replacement_fabric_packinglist.*
		
		FROM
		replacement_fabric_packinglist_details
		INNER JOIN replacement_fabric_packinglist ON replacement_fabric_packinglist.packing_id = replacement_fabric_packinglist_details.pack_list_id
		WHERE
		replacement_fabric_packinglist_details.packing_id IN ?";

		$query = $this->DB2->query($sql, [$barcodes]);
		$result= $query->result_array();
		return $result ;
}
}
