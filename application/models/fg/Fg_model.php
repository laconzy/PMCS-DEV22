<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class fg_Model extends CI_Model

{


	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	public function get_order_details($po)
	{


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


	public function save()
	{

		$customer_po = $this->input->post('customer_po');

		$container = $this->input->post('container');
		$id = $this->input->post('id');

		$user_id= $this->session->userdata('user_id');
		//$id= $this->session->userdata('id');

		$cur_date = date("Y-m-d H:i:s");

	//	$plies = $this->input->post('plies');


		if($id > 0){

			$data = array(
				'customer_po' => $customer_po,

				'container' => $container,

				'update_date' => $cur_date,

				'update_by' => $user_id);

			$this->db->where('id', $id);

			$this->db->update('packing_list', $data);

		 //	return $insert_id = $this->db->insert_id();

		}else{

			$data = array(

				'customer_po' => $customer_po,

				'container' => $container,

				'create_time' => $cur_date,

				'created_by' => $user_id);

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

	public function get_saved_details($pack_id){
		$sql="SELECT
		packing_list_detail.line_item,
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

	}

	public function get_print($pack_id){
		$sql="SELECT
		packing_list_detail.line_item,
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
		size.size_id,
		style.style_code,
		color.color_code
		FROM
		packing_list_detail
		INNER JOIN order_head ON packing_list_detail.order_id = order_head.order_id
		INNER JOIN size ON packing_list_detail.size_id = size.size_id
		INNER JOIN style ON order_head.style = style.style_id
		INNER JOIN color ON order_head.color = color.color_id
		WHERE
		packing_list_detail.packing_list_id = '".$pack_id."'
		ORDER BY
		size.seq ASC
		";

		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

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

		return $result['ctn_qty'];
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

public function update_fg($order_id,$ref_id,$barcode,$item,$size,$qty,$created_by,$created_date,$operation,$color,$site,$location, $scan_date = null, $line_no = null){
$style = null;
if($order_id != null){
	$order_data = $this->get_order($order_id);
	if($order_data != null){
		$style = $order_data['style'];
	}
}

$data = array(
			'order_id' => $order_id,
			'ref_id' => $ref_id,
			'barcode' => $barcode,
			'item' => $item,
			'size' => $size,
			'qty' => $qty,
			'created_by' => $created_by,
			'created_date' => $created_date,
			'style' => $style,
			'operation' => $operation,
			'site' => $site,
			'operation_point' => 'OUT',
			'color' => $color,
			'scan_date' => $scan_date,
			'location' => $location,
			'line_no' => $line_no
		);

		$this->db->insert('fg', $data);

}

public function get_order($order_id){
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('order_head');
		return $query->row_array();
}

}
