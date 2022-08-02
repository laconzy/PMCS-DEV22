<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Report_Model extends CI_Model

{


	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}


	public function get_daily_production($date_from, $date_to, $operation,$building,$shift)
	{

$b=$building;
//echo 'building'.$building;
		 $sql = "SELECT
		size.size_code,
		production.size,
		production.item,
		SUM(production.qty) qty,
		production.operation,
		production.color,
		color.color_code,
		color.color_name,
		item.item_code,
		item.item_description,
		order_head.customer,
		order_head.customer_po,
		customer.id,
		customer.cus_name,
		customer.cus_code,
		production.scan_date,
		production.created_date,
		style.style_code,
		order_head.order_code,
		line.line_code
		FROM
		production
		INNER JOIN size ON production.size = size.size_id
		INNER JOIN order_head ON production.order_id = order_head.order_id
		INNER JOIN color ON production.color = color.color_id
		INNER JOIN item ON production.item = item.item_id
		INNER JOIN customer ON order_head.customer = customer.id
		INNER JOIN style ON order_head.style = style.style_id
		INNER JOIN line ON production.line_no = line.line_id
		WHERE
		production.scan_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'	AND
		production.operation = '" . $operation . "'";
		
		if($shift <> 'X'){
			//echo 0;
			 $sql .=" AND
		production.shift = '".$shift."'";
		}

		if ($b <> 'X') {
			//echo 2;
			 	$sql .= " AND
		 line.section = '".$b."'";
		}

		$sql .=" GROUP BY
		production.item,
		production.size,
		production.operation,
		production.operation_point,
		production.color,
		production.line_no,
		order_head.order_code";
		//echo	$sql;
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

	public function get_daily_production_cutting($date_from, $date_to, $operation,$building)
	{



		$sql="SELECT
cut_bundles_2.laysheet_no,
cut_bundles_2.order_id,
cut_bundles_2.bundle_no,
cut_bundles_2.barcode,
cut_bundles_2.style,
cut_bundles_2.color,
cut_bundles_2.part_no,
cut_bundles_2.item,
cut_bundles_2.bpo,
cut_bundles_2.size,
SUM(cut_bundles_2.qty) qty,
cut_bundles_2.created_by,
DATE(cut_bundles_2.created_date) AS scan_date,
cut_bundles_2.plies_count,
cut_bundles_2.cut_no,
cut_bundles_2.site,
cut_bundles_2.diff,
cut_bundles_2.`start`,
cut_bundles_2.`end`,
cut_bundles_2.letter,
order_head.order_code,
order_head.style,
order_head.color,
order_head.customer_po,
order_head.uom,
color.color_code,
color.color_name,
item.item_code,
item.item_description,
customer.cus_code,
customer.cus_name,
style.style_code,
style.style_name,
site.site_code,
site.site_name as line_code,
size.size_code,
size.size_name
FROM
cut_bundles_2
INNER JOIN order_head ON cut_bundles_2.order_id = order_head.order_id
INNER JOIN color ON order_head.color = color.color_id
INNER JOIN item ON cut_bundles_2.item = item.item_id
INNER JOIN customer ON order_head.customer = customer.id
INNER JOIN style ON cut_bundles_2.style = style.style_id
INNER JOIN site ON cut_bundles_2.site = site.id
INNER JOIN size ON cut_bundles_2.size = size.size_id
WHERE
DATE(cut_bundles_2.created_date) BETWEEN '".$date_from."' AND '".$date_to."'
GROUP BY
cut_bundles_2.item,
cut_bundles_2.bpo,
order_head.order_code,
size.size_code";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

	public function get_scan_history($cut_plan_id, $barcode)
	{
		$sql = "SELECT
production.order_id,
production.laysheet_no,
production.bundle_no,
production.barcode,
production.item,
production.size,
production.qty,
production.created_by,
production.created_date,
production.operation,
production.operation_point,
production.line_no,
production.color,
production.scan_date,
size.size_code,
size.size_name,
operation.operation_name,
line.line_code,
`user`.first_name,
`user`.last_name,
(SELECT cut_no FROM cut_bundles WHERE barcode=production.barcode) cut_no
FROM
production
INNER JOIN size ON production.size = size.size_id
INNER JOIN operation ON production.operation = operation.operation_id
INNER JOIN line ON production.line_no = line.line_id
INNER JOIN `user` ON production.created_by = `user`.id
WHERE
production.order_id IS NOT NULL";
		if ($cut_plan_id != '' or $cut_plan_id != null) {
			$sql .= " AND production.order_id = '" . $cut_plan_id . "'";
		}
		if ($barcode != '' or $barcode != null) {
			$sql .= " AND production.barcode = '" . $barcode . "'";
		}

		$sql .= " ORDER BY				
				production.laysheet_no ASC,
				production.bundle_no ASC,
				operation.seq ASC
				";
		//echo $sql;
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}
	public function destroy($barcode, $operation)
	{
		$this->copy_to_history($barcode, $operation);
		$this->db->where('barcode', $barcode);

		$this->db->where('operation', $operation);

		$this->db->delete('production');

		return true;
	}



	public function copy_to_history($barcode, $operation)
	{
		$user=$this->session->userdata('user_id');

		$sql ="INSERT INTO production_delete_history
				SELECT 
	production.order_id,
	production.laysheet_no,
	production.bundle_no,
	production.barcode,
	production.item,
	production.size,
	production.qty,
	".$user.",
	production.created_date,
	production.operation,
	production.operation_point,
	production.line_no,
	production.color,
	production.scan_date
	FROM production
	WHERE production.barcode='".$barcode."' and production.operation='".$operation."'";
		$query = $this->db->query($sql);
	}
	
	public function get_order_status_report_2($customer, $style, $customer_po, $color,$size)
	{

		$customer_po = ($customer_po == 'NO') ? '' : $customer_po;

		$data = [];

		$sql1 = "SELECT
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
order_item_sizes.size,
order_item_sizes.order_qty s_ord_qty,
order_item_sizes.planned_qty s_plan_qty,
size.size_code
FROM
order_head
INNER JOIN style ON order_head.style = style.style_id
INNER JOIN customer ON order_head.customer = customer.id
INNER JOIN color ON order_head.color = color.color_id
INNER JOIN order_item_sizes ON order_head.order_id = order_item_sizes.order_id
INNER JOIN size ON order_item_sizes.size = size.size_id WHERE
order_head.active = 'Y' AND
order_head.customer_po LIKE '" . $customer_po . "%'";

		if ($customer != 0) {

			$sql1 .= " AND order_head.customer=" . $customer;

		}

		if ($style != 0) {

			$sql1 .= " AND order_head.style=" . $style;

		}

		if ($color != 'NO') {

			$sql1 .= " AND color.color_code LIKE '%" . $color . "%'";

		}
		if ($size != 'NO') {

			$sql1 .= " AND size.size_code LIKE '%" . $size . "%'";

		}

		$sql1 .= " AND
				order_head.active = 'Y' 
				ORDER BY
					order_head.order_id DESC,
					 size.seq ASC
				 LIMIT 100";

		//echo $sql1;//die();

		$query = $this->db->query($sql1);

		$orders = $query->result_array();

		foreach ($orders as $row) {

			$order_data = $row;


			$sql2 = "SELECT
						operation.*
					FROM
						operation
					ORDER BY
					operation.seq ASC
					"; // get all operations of a order

			$query2 = $this->db->query($sql2, [$row['order_id']]);

			$operations = $query2->result_array();


			$order_data['operations'] = [];

			foreach ($operations as $row2) {

				$sql3 = "SELECT
							IFNULL(SUM(qty), 0)AS qty
						FROM
							production
						WHERE
						production.order_id = ? AND
						production.operation = ? AND
						production.operation_point = 'OUT' AND
						production.size = ?
						";
				$query3 = $this->db->query($sql3, [$row['order_id'], $row2['operation_id'], $row['size']]);
//echo $this->db->last_query();
				$out_qty = $query3->row_array();

				$out_qty = $out_qty['qty'];

				$order_data['operations'][$row2['operation_id']] = $out_qty;

			}


			$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles WHERE order_id = ? AND cut_bundles.size=?";

			$query4 = $this->db->query($sql4, [$row['order_id'], $row['size']]);

			$cut_qty = $query4->row_array();

			$cut_qty = $cut_qty['qty'];

			$order_data['cut_qty'] = $cut_qty;


			$sql5 = "SELECT IFNULL(SUM(qty),0) as qty
						FROM fg
						WHERE
						fg.order_id = ? AND
						fg.size = ? AND
						fg.operation = 'FG_RECEIVE'";

			$query5 = $this->db->query($sql5, [$row['order_id'], $row['size']]);

			$fg_qty = $query5->row_array();

			$fg_qty = $fg_qty['qty'];

			$order_data['fg_qty'] = $fg_qty;


			$sql6 = "SELECT IFNULL(SUM(qty),0) as qty
						FROM fg
						WHERE
						fg.order_id = ? AND
						fg.size = ? AND
						fg.operation = 'SHIPMENT'";

			$query5 = $this->db->query($sql6, [$row['order_id'], $row['size']]);

			$ship_qty = $query5->row_array();

			$ship_qty = $ship_qty['qty'];

			$order_data['ship_qty'] = $ship_qty;


			array_push($data, $order_data);

		}

		return $data;

	}

	public function get_order_status_report($customer, $style, $customer_po,$color)
	{

		$customer_po = ($customer_po == 'NO') ? '' : $customer_po;

		$data = [];

		$sql1 = "SELECT
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
order_item_sizes.size,
sum(order_item_sizes.order_qty) s_ord_qty,
sum(order_item_sizes.planned_qty) s_plan_qty
FROM
order_head
INNER JOIN style ON order_head.style = style.style_id
INNER JOIN customer ON order_head.customer = customer.id
INNER JOIN color ON order_head.color = color.color_id
INNER JOIN order_item_sizes ON order_head.order_id = order_item_sizes.order_id
WHERE
order_head.active = 'Y' AND
order_head.customer_po LIKE '" . $customer_po . "%'";

		if ($customer != 0) {

			$sql1 .= " AND order_head.customer=" . $customer;

		}

		if ($style != 0) {

			$sql1 .= " AND order_head.style=" . $style;

		}

		if ($color != 'NO') {

			$sql1 .= " AND color.color_code LIKE '%" . $color . "%'";

		}
		// if ($size != 'NO') {

		// 	$sql1 .= " AND size.size_code LIKE '%" . $size . "%'";

		// }

		$sql1 .= " AND
				order_head.active = 'Y' 
				GROUP BY
				order_head.color,
				order_head.customer_po,
				order_head.style
				ORDER BY
					order_head.order_id DESC
				 LIMIT 100";

		//echo $sql1;//die();

		$query = $this->db->query($sql1);

		$orders = $query->result_array();

		foreach ($orders as $row) {

			$order_data = $row;


			$sql2 = "SELECT
						operation.*
					FROM
						operation
					ORDER BY
					operation.seq ASC
					"; // get all operations of a order

			$query2 = $this->db->query($sql2, [$row['order_id']]);

			$operations = $query2->result_array();


			$order_data['operations'] = [];

			foreach ($operations as $row2) {

				$sql3 = "SELECT
							IFNULL(SUM(qty), 0)AS qty
						FROM
							production
						WHERE
						production.order_id = ? AND
						production.operation = ? AND
						production.operation_point = 'OUT' 
						";
				$query3 = $this->db->query($sql3, [$row['order_id'], $row2['operation_id']]);
//echo $this->db->last_query();
				$out_qty = $query3->row_array();

				$out_qty = $out_qty['qty'];

				$order_data['operations'][$row2['operation_id']] = $out_qty;

			}


			$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles WHERE order_id = ? ";

			$query4 = $this->db->query($sql4, [$row['order_id']]);

			$cut_qty = $query4->row_array();

			$cut_qty = $cut_qty['qty'];

			$order_data['cut_qty'] = $cut_qty;


			array_push($data, $order_data);

		}

		return $data;

	}


	public function line_wise_report_a($date_from, $date_to, $operation,$building,$shift)
	{

		$b=$building;
		//echo 'building'.$building;
		echo  $sql = "SELECT
						production.size,
						production.item,
						Sum(production.qty) AS qty,
						production.operation,
						production.color,
						color.color_code,
						color.color_name,
						item.item_code,
						item.item_description,
						order_head.customer,
						order_head.customer_po,
						customer.id,
						customer.cus_name,
						customer.cus_code,
						production.scan_date,
						production.created_date,
						style.style_code,
						order_head.order_code,
						line.line_code,
						production.shift,
						production.scan_date,
						(SELECT
						Sum(p1.qty)
						FROM
						production AS p1
						WHERE
						p1.operation = 4 AND
						p1.line_no = production.line_no AND
						p1.scan_date = production.scan_date AND
						p1.`hour` = 1 AND
						p12.shift = 'A'

						GROUP BY
						p1.scan_date,
						p1.`hour`) hr1,
						(SELECT
						Sum(p2.qty)
						FROM
						production AS p2
						WHERE
						p2.operation = 4 AND
						p2.line_no = production.line_no AND
						p2.scan_date = production.scan_date AND
						p2.`hour` = 2 AND
						p12.shift = 'A'
						GROUP BY
						p2.scan_date,
						p2.`hour`
						) hr2,
						(SELECT
						Sum(p3.qty)
						FROM
						production AS p3
						WHERE
						p3.operation = 4 AND
						p3.line_no = production.line_no AND
						p3.scan_date = production.scan_date AND
						p3.`hour` = 3 AND
						p12.shift = 'A'
						GROUP BY
						p3.scan_date,
						p3.`hour`
						) hr3,(SELECT
						Sum(p4.qty)
						FROM
						production AS p4
						WHERE
						p4.operation = 4 AND
						p4.line_no = production.line_no AND
						p4.scan_date = production.scan_date AND
						p4.`hour` = 4 AND
						p12.shift = 'A'
						GROUP BY
						p4.scan_date,
						p4.`hour`) hr4,
						(SELECT
						Sum(p5.qty)
						FROM
						production AS p5
						WHERE
						p5.operation = 4 AND
						p5.line_no = production.line_no AND
						p5.scan_date = production.scan_date AND
						p5.`hour` = 5 AND
						p12.shift = 'A'
						GROUP BY
						p5.scan_date,
						p5.`hour`
						) hr5,
						(SELECT
						Sum(p6.qty)
						FROM
						production AS p6
						WHERE
						p6.operation = 4 AND
						p6.line_no = production.line_no AND
						p6.scan_date = production.scan_date AND
						p6.`hour` = 6 AND
						p12.shift = 'A'
						GROUP BY
						p6.scan_date,
						p6.`hour`
						) hr6,
						(SELECT
						Sum(p7.qty)
						FROM
						production AS p7
						WHERE
						p7.operation = 4 AND
						p7.line_no = production.line_no AND
						p7.scan_date = production.scan_date AND
						p7.`hour` = 7 AND
						p12.shift = 'A'
						GROUP BY
						p7.scan_date,
						p7.`hour`
						) hr7,
						(SELECT
						Sum(p8.qty)
						FROM
						production AS p8
						WHERE
						p8.operation = 4 AND
						p8.line_no = production.line_no AND
						p8.scan_date = production.scan_date AND
						p8.`hour` = 8 AND
						p12.shift = 'A'
						GROUP BY
						p8.scan_date,
						p8.`hour`
						) hr8,
						(SELECT
						Sum(p9.qty)
						FROM
						production AS p9
						WHERE
						p9.operation = 4 AND
						p9.line_no = production.line_no AND
						p9.scan_date = production.scan_date AND
						p9.`hour` = 9 AND
						p12.shift = 'A'
						GROUP BY
						p9.scan_date,
						p9.`hour`
						) hr9,
						(SELECT
						Sum(p10.qty)
						FROM
						production AS p10
						WHERE
						p10.operation = 4 AND
						p10.line_no = production.line_no AND
						p10.scan_date = production.scan_date AND
						p10.`hour` = 10 AND
						p12.shift = 'A'
						GROUP BY
						p10.scan_date,
						p10.`hour`
						)p10,
						(SELECT
						Sum(p11.qty)
						FROM
						production AS p11
						WHERE
						p11.operation = 4 AND
						p11.line_no = production.line_no AND
						p11.scan_date = production.scan_date AND
						p11.`hour` = 11 AND
						p12.shift = 'A'
						GROUP BY
						p11.scan_date,
						p11.`hour`
						) hr11,
						(SELECT
						Sum(p12.qty)
						FROM
						production AS p12
						WHERE
						p12.operation = 4 AND
						p12.line_no = production.line_no AND
						p12.scan_date = production.scan_date AND
						p12.`hour` = 12 AND
						p12.shift = 'A'
						GROUP BY
						p12.scan_date,
						p12.`hour`
						) hr12
						FROM
						production
						INNER JOIN order_head ON production.order_id = order_head.order_id
						INNER JOIN color ON production.color = color.color_id
						INNER JOIN item ON production.item = item.item_id
						INNER JOIN customer ON order_head.customer = customer.id
						INNER JOIN style ON order_head.style = style.style_id
						INNER JOIN line ON production.line_no = line.line_id
						WHERE
						production.scan_date BETWEEN '".$date_to."' AND '".$date_to."'	AND
						production.operation = '4'  AND
						production.shift = 'A'
						GROUP BY
						line.line_code,
						production.shift
						ORDER BY
						production.shift ASC,
						line.seq ASC";
		
		
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

	public function line_wise_report_b($date_from, $date_to, $operation,$building,$shift)
	{

		$b=$building;
		//echo 'building'.$building;
		  $sql = "SELECT
						production.size,
						production.item,
						Sum(production.qty) AS qty,
						production.operation,
						production.color,
						color.color_code,
						color.color_name,
						item.item_code,
						item.item_description,
						order_head.customer,
						order_head.customer_po,
						customer.id,
						customer.cus_name,
						customer.cus_code,
						production.scan_date,
						production.created_date,
						style.style_code,
						order_head.order_code,
						line.line_code,
						production.shift,
						production.scan_date
						FROM
						production
						INNER JOIN order_head ON production.order_id = order_head.order_id
						INNER JOIN color ON production.color = color.color_id
						INNER JOIN item ON production.item = item.item_id
						INNER JOIN customer ON order_head.customer = customer.id
						INNER JOIN style ON order_head.style = style.style_id
						INNER JOIN line ON production.line_no = line.line_id
						WHERE
						production.scan_date BETWEEN '".$date_from."' AND '".$date_to."'	AND
						production.operation = '4' AND
						production.shift = 'B'
						GROUP BY
						line.line_code,
						production.shift
						ORDER BY
						production.shift ASC,
						line.seq ASC";
		
		
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

}

