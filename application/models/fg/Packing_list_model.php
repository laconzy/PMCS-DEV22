<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Packing_List_Model extends CI_Model
{

	public function __construct()	{
		parent::__construct();
		$this->load->database();
	}

	public function get_packing_lists($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
    packing_list.*,
		site.site_name
    FROM packing_list
		LEFT JOIN site ON site.id = packing_list.site
    WHERE packing_list.id LIKE ".$search_like." OR packing_list.customer_po LIKE ".$search_like." OR
    packing_list.container LIKE ".$search_like." OR site.site_name LIKE ".$search_like."
		ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_packing_lists_count($search)
	{
		$search_like = "'%".$search."%'";
    $sql = "SELECT
    COUNT(packing_list.id) AS row_count
    FROM packing_list
		LEFT JOIN site ON site.id = packing_list.site
    WHERE packing_list.id LIKE ".$search_like." OR packing_list.customer_po LIKE ".$search_like." OR
    packing_list.container LIKE ".$search_like." OR site.site_name LIKE ".$search_like;

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

	public function get_order_details($po) {
		$sql="SELECT
		order_head.order_id,
		order_head.order_code,
		order_head.style,
		order_head.color,
		order_head.customer_po,
		order_head.uom,
		order_head.customer,
		order_head.country,
		order_head.ship_method,
		order_head.delivary_date,
		order_head.pcd_date,
		order_head.planned_delivary_date,
		order_head.original_ord_qty,
		order_head.planned_qty,
		order_head.sales_qty,
		order_head.season,
		order_head.site,
		order_head.created_at,
		order_head.created_by,
		order_head.updated_at,
		order_head.updated_by,
		order_head.active,
		order_head.smv,
		style.style_code,
		style.style_name,
		customer.cus_code,
		customer.cus_name,
		order_items.item,
		order_items.item_color,
		order_item_sizes.size,
		order_item_sizes.order_qty,
		item.item_id,
		item.item_code,
		item.item_description,
		country.country_name,
		c.color_code AS m_color,
		c.color_name AS m_color_name,
		country.country_id,
		color.color_code,
		color.color_name,
		size.size_code,
		size.size_name,
		(SELECT
		Sum(fg.qty) AS qty_update
		from fg
		WHERE
		fg.size =  size.size_id AND
		fg.order_id = order_head.order_id) available_qty
		FROM
		order_head
		INNER JOIN style ON order_head.style = style.style_id
		INNER JOIN customer ON order_head.customer = customer.id
		INNER JOIN order_items ON order_head.order_id = order_items.order_id
		INNER JOIN order_item_sizes ON order_items.order_id = order_item_sizes.order_id AND order_items.id = order_item_sizes.order_item_id
		INNER JOIN item ON order_items.item = item.item_id
		INNER JOIN country ON order_head.country = country.country_id
		INNER JOIN color ON color.color_id = order_items.item_color
		INNER JOIN color AS c ON order_head.color = c.color_id
		INNER JOIN size ON size.size_id = order_item_sizes.size
		WHERE
		order_head.customer_po = '".$po."'";

		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;


	}


	public function save() {
		$customer_po = $this->input->post('customer_po');
		$container = $this->input->post('container');
		$ref1 = $this->input->post('ref_1');
		$ref2 = $this->input->post('ref_2');
		$ref3 = $this->input->post('ref_3');
		$site = $this->input->post('site');
		$id = $this->input->post('id');
		$user_id= $this->session->userdata('user_id');
		$cur_date = date("Y-m-d H:i:s");

		if($id > 0){
			$data = array(
				'customer_po' => $customer_po,
				'container' => $container,
				'ref_1' => $ref1,
				'ref_2' => $ref2,
				'ref_3' => $ref3,
				'site' => $site,
				'update_date' => $cur_date,
				'update_by' => $user_id
			);
			$this->db->where('id', $id);
			$this->db->update('packing_list', $data);
			return $id;
		}
		else{
			$data = array(
				'customer_po' => $customer_po,
				'container' => $container,
				'ref_1' => $ref1,
				'ref_2' => $ref2,
				'ref_3' => $ref3,
				'site' => $site,
				'create_time' => $cur_date,
				'created_by' => $user_id
			);
			$this->db->insert('packing_list', $data);
			return $insert_id = $this->db->insert_id();
		}
	}

	public function save_details(){

		$line_id = $this->input->post('line_id');

		$order_id = $this->input->post('order_id');
		$color_id = $this->input->post('color_id');
		$id = $this->input->post('id');
		$pcs_per_ctn = $this->input->post('pcs_per_ctn');
		$ctn_qty = $this->input->post('ctn_qty');
		$total_qty = $this->input->post('total_qty');
		$net_weight = $this->input->post('net_weight');
		$size_id = $this->input->post('size_id');
		$site = $this->input->post('site');

		//$size_id= $this->session->userdata('size_id');
		$user_id= $this->session->userdata('id');

		$cur_date = date("Y-m-d H:i:s");

		// $sql="SELECT
		// IFNULL(Max(packing_list_detail.line_item),0) max_line
		// FROM `packing_list_detail`
		// WHERE
		// packing_list_detail.packing_list_id = '".$id."'
		// ";
		//$query = $this->db->query($sql);

		$max_id=$this->get_max_id($id)+1;

		$data = array(

			'line_item' => $max_id,
			'packing_list_id' => $id,
			'pcs_per_ctn' => $pcs_per_ctn,
			'ctn_qty' => $ctn_qty,
			'ttl_qty' => $total_qty,
			'weight_net' => $net_weight,
			'color' => $color_id,
			'size_id' => $size_id,
			//'style' => $style,
			'order_id' => $order_id


		);
		$ship_qty=$total_qty*-1;
		$this->db->insert('packing_list_detail', $data);
		$this->update_fg($order_id,$id,$max_id,0,$size_id,$ship_qty,$user_id,$cur_date,'SHIPMENT',$color_id,$site,0);
		// function update_fg($order_id,$ref_id,$barcode,$item,$size,$qty,$created_by,$created_date,$operation,$color,$site,$location)
		return $id;
		 	//return $insert_id = $this->db->insert_id();
	}


	function get_max_id($id)
	{

		$this->db->select_max('line_item');

		$this->db->where('packing_list_id', $id);

		$query = $this->db->get('packing_list_detail')->row();

		return $query->line_item;

	}

/*	public function get_saved_details($pack_id){
		$sql="SELECT
		packing_list_detail.*,
		packing_list_detail.packing_list_id,
		packing_list_detail.pcs_per_ctn,
		packing_list_detail.ctn_qty,
		packing_list_detail.ttl_qty,
		packing_list_detail.weight_net,
		packing_list_detail.weight_nn,
		packing_list_detail.weight_gross,
		packing_list_detail.cbm,
		packing_list_detail.mesurment,
		packing_list_detail.item_id,
		packing_list_detail.color,
		packing_list_detail.size_id,
		packing_list_detail.style,
		packing_list_detail.order_id,
		order_head.order_code,
		order_head.style,
		order_head.color,
		order_head.customer_po,
		order_head.order_id,
		order_head.uom,
		order_head.customer,
		order_head.country,
		order_head.ship_method,
		order_head.delivary_date,
		order_head.pcd_date,
		order_head.planned_delivary_date,
		order_head.original_ord_qty,
		order_head.planned_qty,
		order_head.sales_qty,
		order_head.season,
		order_head.site,
		order_head.created_at,
		order_head.created_by,
		order_head.updated_at,
		order_head.updated_by,
		order_head.active,
		order_head.smv,
		size.size_code,
		size.size_name,
		style.style_code
		FROM
		packing_list_detail
		INNER JOIN order_head ON packing_list_detail.order_id = order_head.order_id
		INNER JOIN size ON packing_list_detail.size_id = size.size_id
		INNER JOIN style ON order_head.style = style.style_id
		WHERE
		packing_list_detail.packing_list_id = '".$pack_id."'

		";

		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}*/

	public function get_print($pack_id){
		$sql = "SELECT
			packing_list_detail.*,
			color.color_code,
			color.color_name,
			size.size_code,
			order_item_sizes.order_qty,
			style.style_code
			FROM packing_list_detail
			INNER JOIN order_head ON order_head.order_id = packing_list_detail.order_id
			INNER JOIN style ON style.style_id = order_head.style
			INNER JOIN color ON color.color_id = packing_list_detail.color
			INNER JOIN size ON size.size_id = packing_list_detail.size_id
			INNER JOIN order_item_sizes ON order_item_sizes.order_id = packing_list_detail.order_id AND order_item_sizes.size = packing_list_detail.size_id
			WHERE packing_list_detail.packing_list_id = ".$pack_id;
			$query = $this->db->query($sql);
			return $query->result_array();
	}

	public function get_size_data($ord_id){

		$sql="SELECT
		order_item_sizes.id,
		order_item_sizes.order_item_id,
		order_item_sizes.order_id,
		order_item_sizes.size,
		order_item_sizes.order_qty,
		order_item_sizes.planned_qty,
		order_item_sizes.balance,
		size.size_code
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

	public function get_pcs_for_ctn($size,$pack_id,$line_item){

		  $sql="SELECT
packing_list_detail.ctn_qty
FROM `packing_list_detail`
WHERE
packing_list_detail.packing_list_id = '".$pack_id."' AND
packing_list_detail.size_id = '".$size."' AND
packing_list_detail.line_item = '".$line_item."'
		";
		$query = $this->db->query($sql);

		$result = $query->row_array();

		//$query = $this->db->get('packing_list_detail')->row();
		if($result != null){
			return $result['ctn_qty'];
		}
		else {
			return null;
		}
		//print_r($result);
		//return $result;
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

	public function destroy($line_item, $bundle_no)
	{

		$this->db->where('line_item', $line_item);

		$this->db->where('packing_list_id', $bundle_no);

		$this->db->delete('packing_list_detail');

		return true;
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

public function update_fg($order_id,$ref_id,$barcode,$item,$size,$qty,$created_by,$created_date,$operation,$color,$site,$location){

$data = array(
			'order_id' => $order_id,
			'ref_id' => $ref_id,
			'barcode' => $barcode,
			'item' => $item,
			'size' => $size,
			'qty' => $qty,
			'created_by' => $created_by,
			'created_date' => $created_date,
			//'style' => $style,
			'operation' => $operation,
			'site' => $site,
			'location' => $location
		);

		$this->db->insert('fg', $data);

}


	public function get_packing_list_header_from_po($po_no){
		$this->db->from('packing_list');
		$this->db->where('customer_po', $po_no);
		$query = $this->db->get();
		return $query->row_array();
	}


	public function get_packing_list_item_from_barcode($packing_list_id, $barcode){
		$this->db->from('packing_list_detail');
		$this->db->where('packing_list_id', $packing_list_id);
		$this->db->where('barcode', $barcode);
		$query = $this->db->get();
		return $query->row_array();
	}


	public function get_order_completed_packing_list_qty($order_id, $size_id){
		$sql = "SELECT SUM(ttl_qty) AS total_sum FROM packing_list_detail
		WHERE order_id = ".$order_id." AND size_id = ".$size_id;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		if($result == null){
			return 0;
		}
		else {
			return $result['total_sum'];
		}
	}


	public function get_packing_list($pack_list_id){
		$this->db->from('packing_list');
		$this->db->where('id', $pack_list_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function add_packing_item($data){
		$this->db->insert('packing_list_detail', $data);
	}

	public function update_packing_item($packing_list_id, $barcode, $qty, $net_weight){
		$sql = "UPDATE packing_list_detail SET ctn_qty = (ctn_qty + 1), ttl_qty = (ttl_qty + ".$qty."), weight_net = ROUND((weight_net + ".$net_weight."), 2)
		WHERE packing_list_id = ".$packing_list_id." AND barcode = '".$barcode."'";
		$query = $this->db->query($sql);
	}

	public function get_order_details_from_id($order_id){
		$this->db->from('order_head');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		return $query->row_array();
	}


	public function get_order_size_details_from_id($order_id, $size_id){
		$this->db->from('order_item_sizes');
		$this->db->where('order_id', $order_id);
		$this->db->where('size', $size_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_packing_list_items($packing_list_id){
		$sql = "SELECT
			packing_list_detail.*,
			color.color_code,
			size.size_code,
			order_item_sizes.order_qty
			FROM packing_list_detail
			INNER JOIN color ON color.color_id = packing_list_detail.color
			INNER JOIN size ON size.size_id = packing_list_detail.size_id
			INNER JOIN order_item_sizes ON order_item_sizes.order_id = packing_list_detail.order_id AND order_item_sizes.size = packing_list_detail.size_id
			WHERE packing_list_detail.packing_list_id = ".$packing_list_id;
			$query = $this->db->query($sql);
			return $query->result_array();
	}

	public function remove_cartoon($packing_list_id, $barcode, $qty, $net_weight){
		$sql = "UPDATE packing_list_detail SET ctn_qty = (ctn_qty - 1), ttl_qty = (ttl_qty - ".$qty."), weight_net = ROUND((weight_net - ".$net_weight."),2) WHERE packing_list_id = ".$packing_list_id." AND  barcode = '".$barcode."'";
		$query = $this->db->query($sql);
		return true;
	}


	public function confirm_packing_list($pack_list_id){
		$sql = "UPDATE packing_list SET is_confirmed = 1 WHERE id = ".$pack_list_id;
		$query = $this->db->query($sql);
		return true;
	}


	public function add_items_to_fg($pack_list_items){
		foreach ($pack_list_items as $row) {
			$data = [
				'order_id' => $row['order_id'],
				'size' => $row['size_id'],
				'qty' => $row['ttl_qty'],
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'SHIPMENT',
				'packing_list_id' => $row['packing_list_id'],
				'cartoon_barcode' => $row['barcode']
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


	public function delete_cartoon($packing_list_id, $barcode){
		$this->db->where('packing_list_id', $packing_list_id);
		$this->db->where('barcode', $barcode);
		$this->db->delete('packing_list_detail');
	}


	//returns.....................................................................

	public function get_confirmed_cartoons($packing_list_id){
		/*$sql = "SELECT
		fg.*,
		color.color_code,
		size.size_code,
		fg_return.qty AS return_qty,
		cartoon_qty.qty AS pcs_per_ctn
		FROM fg
		INNER JOIN order_head ON order_head.order_id = fg.order_id
		INNER JOIN color ON color.color_id = order_head.color
		INNER JOIN size ON size.size_id = fg.size
		INNER JOIN master_barcode ON master_barcode.barcode = fg.cartoon_barcode
		INNER JOIN cartoon_qty ON cartoon_qty.qty_id = master_barcode.cartoon_qty
		LEFT JOIN fg AS fg_return ON fg.packing_list_id = fg_return.packing_list_id AND fg.cartoon_barcode = fg_return.cartoon_barcode
		AND fg_return.operation = 'RETURN'
		WHERE fg.packing_list_id = ".$packing_list_id." AND fg.operation = 'SHIPMENT'";*/
		$sql = "SELECT
		packing_list_detail.*,
		color.color_code,
		size.size_code,
		fg.qty AS return_qty
		FROM packing_list_detail
		INNER JOIN color ON color.color_id = packing_list_detail.color
		INNER JOIN size ON size.size_id = packing_list_detail.size_id
		LEFT JOIN fg ON fg.packing_list_id = packing_list_detail.packing_list_id AND fg.order_id = packing_list_detail.order_id AND fg.size = packing_list_detail.size_id AND fg.operation = 'RETURN'
		WHERE packing_list_detail.packing_list_id = ".$packing_list_id;
			$query = $this->db->query($sql);
			return $query->result_array();
	}


	public function get_fg_shipment_data($packing_list_id, $order_id, $size_id){
		$sql = "SELECT fg.*	FROM fg	WHERE order_id = ".$order_id." AND packing_list_id = ".$packing_list_id." AND size = '".$size_id."' AND operation = 'SHIPMENT'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_fg_return_data($packing_list_id, $order_id, $size_id){
		$sql = "SELECT fg.*	FROM fg	WHERE order_id = ".$order_id." AND packing_list_id = ".$packing_list_id." AND size = '".$size_id."' AND operation = 'RETURN'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function add_return_items_to_fg($packing_list_id, $order_id, $size, $qty){
			$data = [
				'order_id' => $order_id,
				'size' => $size,
				'qty' => $qty,
				'created_date' => date("Y-m-d H:i:s"),
				'operation' => 'RETURN',
				'packing_list_id' => $packing_list_id,
				//'cartoon_barcode' => $barcode
			];
			$this->db->insert('fg', $data);
	}

	public function update_fg_return_item($packing_list_id, $order_id, $size_id, $qty){
		$sql = "UPDATE fg SET qty = (qty + ".$qty.") WHERE packing_list_id = ".$packing_list_id." AND order_id = ".$order_id." AND size = '".$size_id."'";
		$query = $this->db->query($sql);
	}


	public function get_shipment_return_print($pack_id){
		$sql = "SELECT
		packing_list_detail.*,
		color.color_code,
		color.color_name,
		size.size_code,
		style.style_code,
		order_head.customer_po,
		fg.qty AS return_qty
		FROM packing_list_detail
		INNER JOIN color ON color.color_id = packing_list_detail.color
		INNER JOIN size ON size.size_id = packing_list_detail.size_id
		INNER JOIN order_head ON packing_list_detail.order_id = order_head.order_id
		INNER JOIN style ON order_head.style = style.style_id
		LEFT JOIN fg ON fg.packing_list_id = packing_list_detail.packing_list_id AND fg.order_id = packing_list_detail.order_id AND fg.size = packing_list_detail.size_id AND fg.operation = 'RETURN'
		WHERE packing_list_detail.packing_list_id = ".$pack_id;

		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}


	//container packing list summery -----------------------------------------------

	public function get_container_packing_list($container_no){
		$sql = "SELECT
			order_head.customer_po,
			style.style_code,
			color.color_code,
			SUM(packing_list_detail.ttl_qty) AS qty_in_pcs,
			SUM(packing_list_detail.ctn_qty) AS ctn_qty
			FROM packing_list_detail
			INNER JOIN packing_list ON packing_list.id = packing_list_detail.packing_list_id
			INNER JOIN color ON color.color_id = packing_list_detail.color
			INNER JOIN order_head ON order_head.order_id = packing_list_detail.order_id
			INNER JOIN style ON style.style_id = order_head.style
			WHERE packing_list.container = '".$container_no."' AND packing_list.is_confirmed = 1
			GROUP BY order_head.customer_po,order_head.style,order_head.color";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			return $result;
	}

}
