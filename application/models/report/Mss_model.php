<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mss_model extends CI_Model

{


	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}



public function load_order_data(){

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
customer.cus_name,
color.color_code,
(SELECT
Sum(order_item_sizes.order_qty)
FROM order_item_sizes
WHERE
order_item_sizes.order_id = order_head.order_id 
) order_qty,
(SELECT
Sum(cut_bundles_2.qty) cut_qty
FROM `cut_bundles_2`
WHERE
cut_bundles_2.order_id = order_head.order_id) cut_qty,
(SELECT
sum(production.qty) saw_qty
FROM `production`
WHERE
production.order_id = order_head.order_id AND
 production.operation =4
) saw_qty,
(SELECT
Sum(packing_list_detail.ttl_qty) ship_qty
FROM `packing_list_detail`
WHERE
packing_list_detail.order_id = order_head.order_id 
) ship_qty
FROM
order_head
INNER JOIN style ON order_head.style = style.style_id
INNER JOIN customer ON order_head.customer = customer.id
INNER JOIN color ON order_head.color = color.color_id
WHERE
order_head.active = 'Y' 
ORDER BY
order_head.order_id ASC
";
$query = $this->db->query($sql);

$result = $query->result_array();

return $result;
}


public function get_size_ord_qty($ord_id,$size){

	$sql="SELECT
order_item_sizes.order_qty
FROM
order_item_sizes
WHERE
order_item_sizes.order_id = '".$ord_id."' AND
order_item_sizes.size = ".$size;

$query = $this->db->query($sql);

$qty = $query->row_array();

return $qty['order_qty'];	
}



public function get__shipped_ord_qty($ord_id,$size){

	$sql="SELECT
Sum(packing_list_detail.ttl_qty) qty
FROM
packing_list_detail
WHERE
packing_list_detail.size_id = '".$size."' AND
packing_list_detail.order_id = '".$ord_id."'
GROUP BY
packing_list_detail.order_id,
packing_list_detail.size_id";

$query = $this->db->query($sql);

$qty = $query->row_array();

return $qty['order_qty'];	
}

public function shipment_data($ord_id){


	$sql="SELECT
packing_list_detail.packing_list_id,
packing_list_detail.order_id,
packing_list.container
FROM
packing_list_detail
INNER JOIN packing_list ON packing_list_detail.packing_list_id = packing_list.id
WHERE
packing_list_detail.order_id = $ord_id
GROUP BY
packing_list_detail.packing_list_id,
packing_list.container
";

$query = $this->db->query($sql);

$result = $query->result_array();

return $result;

}

public function shipment_size_data($ord_id,$container,$size){


	$sql="SELECT
packing_list_detail.size_id,
Sum(packing_list_detail.ttl_qty) qty,
packing_list_detail.order_id
FROM
packing_list_detail
INNER JOIN packing_list ON packing_list_detail.packing_list_id = packing_list.id
WHERE
packing_list_detail.order_id = $ord_id AND
packing_list.container = '".$container."' AND
packing_list_detail.size_id = '".$size."'
GROUP BY
packing_list.container,
packing_list_detail.size_id,
packing_list_detail.order_id

";

$query = $this->db->query($sql);

$qty = $query->row_array();

return $qty['qty'];	

}

public function balance_qty($ord_id,$size){
	$sql="SELECT
order_item_sizes.order_qty -IFNULL((SELECT
Sum(packing_list_detail.ttl_qty) qty
FROM packing_list_detail
WHERE
packing_list_detail.order_id = order_item_sizes.order_id AND
packing_list_detail.size_id = order_item_sizes.size
),0) AS qty,
order_item_sizes.size
FROM
order_item_sizes
WHERE
order_item_sizes.order_id = $ord_id AND
order_item_sizes.size = $size
";

$query = $this->db->query($sql);

$qty = $query->row_array();

return $qty['qty'];	
}

public function cut_qty($ord_id){

	$sql="SELECT
Sum(cut_bundles_2.qty) cut_qty
FROM `cut_bundles_2`
WHERE
cut_bundles_2.order_id = $ord_id
";

$query = $this->db->query($sql);

$qty = $query->row_array();

return $qty['cut_qty'];	
}


}