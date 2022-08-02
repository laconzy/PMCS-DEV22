<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Report_Model extends CI_Model
{


	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function get_daily_production($date_from, $date_to, $operation,$building,$shift, $site) {

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
		production.shift,
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
		production.operation = '" . $operation . "' ";

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

		if($site != null && $site != ''){
			$sql .= " AND line.location = ".$site;
		}

		$sql .=" GROUP BY
		production.item,
		production.size,
		production.operation,
		production.operation_point,
		production.color,
		production.line_no,
		order_head.order_code,
		production.scan_date";
		//echo	$sql;
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

	public function get_daily_production_cutting($date_from, $date_to, $operation,$building, $site)
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
		cut_bundles_2.shift,
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
		INNER JOIN cut_laysheet ON cut_laysheet.laysheet_no = cut_bundles_2.laysheet_no
		WHERE
		DATE(cut_bundles_2.created_date) BETWEEN '".$date_from."' AND '".$date_to."' AND cut_laysheet.is_completed = 1 ";

		if($site != null && $site != ''){
			$sql .= " AND cut_bundles_2.site = ".$site;
		}

		$sql .= " GROUP BY
		cut_bundles_2.item,
		cut_bundles_2.bpo,
		order_head.order_code,
		size.size_code";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		//print_r($result);
		return $result;

	}

	public function get_scan_history($order_id, $barcode, $operation, $line_no, $size, $scan_date)
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
		production.prev_operation,
		production.shift,
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

		if ($order_id != null or $order_id != '') {
			$sql .= " AND production.order_id = '" . $order_id . "'";
		}
		if ($barcode != null or $barcode != '') {
			$sql .= " AND production.barcode = '" . $barcode . "'";
		}
		if ($operation != null or $operation != '') {
			$sql .= " AND production.operation = " . $operation;
		}
		if ($line_no != null or $line_no != '') {
			$sql .= " AND production.line_no = " . $line_no;
		}
		if ($size != null or $size != '') {
			$sql .= " AND size.size_code = '" . $size."'";
		}
		if ($scan_date != null or $scan_date != '') {
			$sql .= " AND production.scan_date = '" . $scan_date."'";
		}


		$sql .= " ORDER BY
		production.laysheet_no ASC,
		production.bundle_no ASC,
		operation.seq ASC
		";
		//echo $sql;die();
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

		if($operation == 4){
			$this->db->where('barcode', $barcode);
			$this->db->where('operation', 'FG_RECEIVE');
			$this->db->delete('fg');
		}
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
		LIMIT 30";

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


					$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles_2 WHERE order_id = ? AND cut_bundles_2.size=?";

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

			public function get_order_status_report_3($customer, $style, $customer_po, $color,$size)
	{
		$query_parms = [];
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
	order_item_sizes.order_qty AS s_ord_qty,
	order_item_sizes.planned_qty AS s_plan_qty,
	size.size_code,
	view_status_report.CUTTING_OUT,
	view_status_report.PREPARATION,
	view_status_report.SUPERMARKET_IN,
	view_status_report.SUPERMARKET_OUT,
	view_status_report.LINE_OUT,
	view_status_report.LINE_IN
	FROM
	order_head
	INNER JOIN style ON order_head.style = style.style_id
	INNER JOIN customer ON order_head.customer = customer.id
	INNER JOIN color ON order_head.color = color.color_id
	INNER JOIN order_item_sizes ON order_head.order_id = order_item_sizes.order_id
	INNER JOIN size ON order_item_sizes.size = size.size_id
	LEFT JOIN view_status_report ON order_head.order_id = view_status_report.order_id AND size.size_id = view_status_report.size
	WHERE
	order_head.active = 'Y'";

		if($customer_po != ''){
				$sql1 .= " AND order_head.customer_po IN ?";
				$arr = explode(',', $customer_po);
				array_push($query_parms, $arr);
		}

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
		LIMIT 30
		";

	//	echo $sql1;die();

		$query = $this->db->query($sql1, $query_parms);
		$orders = $query->result_array();

		foreach ($orders as $row) {
			$order_data = $row;
			// $sql2 = "SELECT
			// operation.*
			// FROM
			// operation
			// ORDER BY
			// operation.seq ASC
			// 		"; // get all operations of a order

			// 		$query2 = $this->db->query($sql2, [$row['order_id']]);

			// 		$operations = $query2->result_array();


					$order_data['operations'] = [];

// 					foreach ($operations as $row2) {

// 						$sql3 = "SELECT
// 						IFNULL(SUM(qty), 0)AS qty
// 						FROM
// 						production
// 						WHERE
// 						production.order_id = ? AND
// 						production.operation = ? AND
// 						production.operation_point = 'OUT' AND
// 						production.size = ?
// 						";
// 						$query3 = $this->db->query($sql3, [$row['order_id'], $row2['operation_id'], $row['size']]);
// //echo $this->db->last_query();
// 						$out_qty = $query3->row_array();

// 						$out_qty = $out_qty['qty'];

// 						$order_data['operations'][$row2['operation_id']] = $out_qty;

// 					}

					$sql3 = "SELECT
						IFNULL(Sum(rejection.qty),0) rej_qty
						FROM `rejection`
						WHERE
						rejection.order_id =? AND
						rejection.size = ?";

					$query3 = $this->db->query($sql3, [$row['order_id'], $row['size']]);

					$rej_qty = $query3->row_array();

					$rej_qty = $rej_qty['rej_qty'];

					$order_data['rej_qty'] = $rej_qty;


					$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles_2 WHERE order_id = ? AND cut_bundles_2.size=?";

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

					//get fg transferd qty (PO to PO transfer, B Stores Transfer)
					$sql7 = "SELECT IFNULL(SUM(qty),0) as qty
					FROM fg
					WHERE
					fg.order_id = ? AND
					fg.size = ? AND
					fg.operation NOT IN ('FG_RECEIVE', 'SHIPMENT')";

					$query7 = $this->db->query($sql7, [$row['order_id'], $row['size']]);
					$transfered_qty = $query7->row_array();
					$transfered_qty = $transfered_qty['qty'];
					$order_data['transfered_qty'] = $transfered_qty;

					//get fg wip, avaliable fg balance
					$sql8 = "SELECT IFNULL(SUM(qty),0) as qty FROM fg
					WHERE fg.order_id = ? AND	fg.size = ?";

					$query8 = $this->db->query($sql8, [$row['order_id'], $row['size']]);
					$fg_wip_qty = $query8->row_array();
					$fg_wip_qty = $fg_wip_qty['qty'];
					$order_data['fg_wip_qty'] = $fg_wip_qty;

					array_push($data, $order_data);
				}

				return $data;

			}

			public function get_order_status_report($customer, $style, $customer_po,$color, $order_status, $date_from, $date_to)
			{
				$query_parms = [];
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
				order_head.active = 'Y'";

				if($customer_po != ''){
					$sql1 .= " AND order_head.customer_po IN ?";
					$arr = explode(',', $customer_po);
					array_push($query_parms, $arr);
				}

				if ($customer != 0) {
					$sql1 .= " AND order_head.customer=" . $customer;
				}

				if ($style != 0) {
					$sql1 .= " AND order_head.style=" . $style;
				}

				if ($color != 'NO') {
					$sql1 .= " AND color.color_code LIKE '%" . $color . "%'";
				}

				if ($order_status != 'NO') {
					$order_status = ($order_status == 'complete') ? 1 : 0;
					$sql1 .= " AND order_head.is_complete = ".$order_status;
				}

				if($date_from != '' && $date_to != ''){
					$sql1 .= " AND (order_head.delivary_date BETWEEN '".$date_from."' AND '".$date_to."')";
				}
				// $sql1 .= " GROUP BY
				// 		order_head.order_id
				// 		";
		// if ($size != 'NO') {

		// 	$sql1 .= " AND size.size_code LIKE '%" . $size . "%'";

		// }

				$sql1 .= " GROUP BY
				order_head.color,
				order_head.customer_po,
				order_head.style,
				order_head.order_id
				ORDER BY
				order_head.order_id DESC ";

				//echo $sql1;die();

				$query = $this->db->query($sql1, $query_parms);

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


					$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles_2 WHERE order_id = ? ";
					$query4 = $this->db->query($sql4, [$row['order_id']]);
					$cut_qty = $query4->row_array();
					$cut_qty = $cut_qty['qty'];
					$order_data['cut_qty'] = $cut_qty;

					$sql5 = "SELECT
						IFNULL(Sum(rejection.qty),0) rej_qty
						FROM `rejection`
						WHERE
						rejection.order_id =?";

					$query5 = $this->db->query($sql5, [$row['order_id']]);
					$rej_qty = $query5->row_array();
					$rej_qty = $rej_qty['rej_qty'];
					$order_data['rej_qty'] = $rej_qty;

					$sql6 = "SELECT IFNULL(SUM(qty),0) as qty
					FROM fg
					WHERE
					fg.order_id = ? AND
					fg.operation = 'FG_RECEIVE'";

					$query6 = $this->db->query($sql6, [$row['order_id']]);
					$fg_qty = $query6->row_array();
					$fg_qty = $fg_qty['qty'];
					$order_data['fg_qty'] = $fg_qty;


					$sql7 = "SELECT IFNULL(SUM(qty),0) as qty
					FROM fg
					WHERE
					fg.order_id = ? AND
					fg.operation = 'SHIPMENT'";

					$query7 = $this->db->query($sql7, [$row['order_id']]);
					$ship_qty = $query7->row_array();
					$ship_qty = $ship_qty['qty'];
					$order_data['ship_qty'] = $ship_qty;

					$sql8 = "SELECT IFNULL(SUM(qty),0) as qty
					FROM fg
					WHERE
					fg.order_id = ? AND
					fg.operation NOT IN ('FG_RECEIVE', 'SHIPMENT')";

					$query8 = $this->db->query($sql8, [$row['order_id']]);
					$transfered_qty = $query8->row_array();
					$transfered_qty = $transfered_qty['qty'];
					$order_data['transfered_qty'] = $transfered_qty;

					//get fg wip, avaliable fg balance
					$sql9 = "SELECT IFNULL(SUM(qty),0) as qty FROM fg
					WHERE fg.order_id = ?";

					$query9 = $this->db->query($sql9, [$row['order_id']]);
					$fg_wip_qty = $query9->row_array();
					$fg_wip_qty = $fg_wip_qty['qty'];
					$order_data['fg_wip_qty'] = $fg_wip_qty;

					array_push($data, $order_data);

				}

				return $data;

			}


			public function line_wise_report_a($date_from, $date_to, $operation,$building,$shift)
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
				production.scan_date,
				IFNULL((SELECT
				Sum(p1.qty)
				FROM
				production AS p1
				WHERE
				p1.operation = 4 AND
				p1.line_no = production.line_no AND
				p1.scan_date = production.scan_date AND
				p1.`hour` = 1 AND
				p1.shift = 'A'
				GROUP BY
				p1.scan_date,
				p1.`hour`),0) hr1,
				IFNULL((SELECT
				Sum(p2.qty)
				FROM
				production AS p2
				WHERE
				p2.operation = 4 AND
				p2.line_no = production.line_no AND
				p2.scan_date = production.scan_date AND
				p2.`hour` = 2 AND
				p2.shift = 'A'
				GROUP BY
				p2.scan_date,
				p2.`hour`
				),0) hr2,
				IFNULL((SELECT
				Sum(p3.qty)
				FROM
				production AS p3
				WHERE
				p3.operation = 4 AND
				p3.line_no = production.line_no AND
				p3.scan_date = production.scan_date AND
				p3.`hour` = 3 AND
				p3.shift = 'A'
				GROUP BY
				p3.scan_date,
				p3.`hour`
				),0) hr3,
				IFNULL((SELECT
				Sum(p4.qty)
				FROM
				production AS p4
				WHERE
				p4.operation = 4 AND
				p4.line_no = production.line_no AND
				p4.scan_date = production.scan_date AND
				p4.`hour` = 4 AND
				p4.shift = 'A'
				GROUP BY
				p4.scan_date,
				p4.`hour`),0) hr4,
				IFNULL((SELECT
				Sum(p5.qty)
				FROM
				production AS p5
				WHERE
				p5.operation = 4 AND
				p5.line_no = production.line_no AND
				p5.scan_date = production.scan_date AND
				p5.`hour` = 5 AND
				p5.shift = 'A'
				GROUP BY
				p5.scan_date,
				p5.`hour`
				),0) hr5,
				IFNULL((SELECT
				Sum(p6.qty)
				FROM
				production AS p6
				WHERE
				p6.operation = 4 AND
				p6.line_no = production.line_no AND
				p6.scan_date = production.scan_date AND
				p6.`hour` = 6 AND
				p6.shift = 'A'
				GROUP BY
				p6.scan_date,
				p6.`hour`
				),0) hr6,
				IFNULL((SELECT
				Sum(p7.qty)
				FROM
				production AS p7
				WHERE
				p7.operation = 4 AND
				p7.line_no = production.line_no AND
				p7.scan_date = production.scan_date AND
				p7.`hour` = 7 AND
				p7.shift = 'A'
				GROUP BY
				p7.scan_date,
				p7.`hour`
				),0) hr7,
				IFNULL((SELECT
				Sum(p8.qty)
				FROM
				production AS p8
				WHERE
				p8.operation = 4 AND
				p8.line_no = production.line_no AND
				p8.scan_date = production.scan_date AND
				p8.`hour` = 8 AND
				p8.shift = 'A'
				GROUP BY
				p8.scan_date,
				p8.`hour`
				),0) hr8,
				IFNULL((SELECT
				Sum(p9.qty)
				FROM
				production AS p9
				WHERE
				p9.operation = 4 AND
				p9.line_no = production.line_no AND
				p9.scan_date = production.scan_date AND
				p9.`hour` = 9 AND
				p9.shift = 'A'
				GROUP BY
				p9.scan_date,
				p9.`hour`
				),0) hr9,
				IFNULL((SELECT
				Sum(p10.qty)
				FROM
				production AS p10
				WHERE
				p10.operation = 4 AND
				p10.line_no = production.line_no AND
				p10.scan_date = production.scan_date AND
				p10.`hour` = 10 AND
				p10.shift = 'A'
				GROUP BY
				p10.scan_date,
				p10.`hour`
				),0) hr10,
				IFNULL((SELECT
				Sum(p11.qty)
				FROM
				production AS p11
				WHERE
				p11.operation = 4 AND
				p11.line_no = production.line_no AND
				p11.scan_date = production.scan_date AND
				p11.`hour` = 11 AND
				p11.shift = 'A'
				GROUP BY
				p11.scan_date,
				p11.`hour`
				),0) hr11,
				IFNULL((SELECT
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
				),0) hr12
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
				production.scan_date,
				IFNULL((SELECT
				Sum(p1.qty)
				FROM
				production AS p1
				WHERE
				p1.operation = 4 AND
				p1.line_no = production.line_no AND
				p1.scan_date = production.scan_date AND
				p1.`hour` = 1 AND
				p1.shift = 'B'
				GROUP BY
				p1.scan_date,
				p1.`hour`),0) hr1,
				IFNULL((SELECT
				Sum(p2.qty)
				FROM
				production AS p2
				WHERE
				p2.operation = 4 AND
				p2.line_no = production.line_no AND
				p2.scan_date = production.scan_date AND
				p2.`hour` = 2 AND
				p2.shift = 'B'
				GROUP BY
				p2.scan_date,
				p2.`hour`
				),0) hr2,
				IFNULL((SELECT
				Sum(p3.qty)
				FROM
				production AS p3
				WHERE
				p3.operation = 4 AND
				p3.line_no = production.line_no AND
				p3.scan_date = production.scan_date AND
				p3.`hour` = 3 AND
				p3.shift = 'B'
				GROUP BY
				p3.scan_date,
				p3.`hour`
				),0) hr3,
				IFNULL((SELECT
				Sum(p4.qty)
				FROM
				production AS p4
				WHERE
				p4.operation = 4 AND
				p4.line_no = production.line_no AND
				p4.scan_date = production.scan_date AND
				p4.`hour` = 4 AND
				p4.shift = 'B'
				GROUP BY
				p4.scan_date,
				p4.`hour`),0) hr4,
				IFNULL((SELECT
				Sum(p5.qty)
				FROM
				production AS p5
				WHERE
				p5.operation = 4 AND
				p5.line_no = production.line_no AND
				p5.scan_date = production.scan_date AND
				p5.`hour` = 5 AND
				p5.shift = 'B'
				GROUP BY
				p5.scan_date,
				p5.`hour`
				),0) hr5,
				IFNULL((SELECT
				Sum(p6.qty)
				FROM
				production AS p6
				WHERE
				p6.operation = 4 AND
				p6.line_no = production.line_no AND
				p6.scan_date = production.scan_date AND
				p6.`hour` = 6 AND
				p6.shift = 'B'
				GROUP BY
				p6.scan_date,
				p6.`hour`
				),0) hr6,
				IFNULL((SELECT
				Sum(p7.qty)
				FROM
				production AS p7
				WHERE
				p7.operation = 4 AND
				p7.line_no = production.line_no AND
				p7.scan_date = production.scan_date AND
				p7.`hour` = 7 AND
				p7.shift = 'B'
				GROUP BY
				p7.scan_date,
				p7.`hour`
				),0) hr7,
				IFNULL((SELECT
				Sum(p8.qty)
				FROM
				production AS p8
				WHERE
				p8.operation = 4 AND
				p8.line_no = production.line_no AND
				p8.scan_date = production.scan_date AND
				p8.`hour` = 8 AND
				p8.shift = 'B'
				GROUP BY
				p8.scan_date,
				p8.`hour`
				),0) hr8,
				IFNULL((SELECT
				Sum(p9.qty)
				FROM
				production AS p9
				WHERE
				p9.operation = 4 AND
				p9.line_no = production.line_no AND
				p9.scan_date = production.scan_date AND
				p9.`hour` = 9 AND
				p9.shift = 'B'
				GROUP BY
				p9.scan_date,
				p9.`hour`
				),0) hr9,
				IFNULL((SELECT
				Sum(p10.qty)
				FROM
				production AS p10
				WHERE
				p10.operation = 4 AND
				p10.line_no = production.line_no AND
				p10.scan_date = production.scan_date AND
				p10.`hour` = 10 AND
				p10.shift = 'B'
				GROUP BY
				p10.scan_date,
				p10.`hour`
				),0) hr10,
				IFNULL((SELECT
				Sum(p11.qty)
				FROM
				production AS p11
				WHERE
				p11.operation = 4 AND
				p11.line_no = production.line_no AND
				p11.scan_date = production.scan_date AND
				p11.`hour` = 11 AND
				p11.shift = 'B'
				GROUP BY
				p11.scan_date,
				p11.`hour`
				),0) hr11,
				IFNULL((SELECT
				Sum(p12.qty)
				FROM
				production AS p12
				WHERE
				p12.operation = 4 AND
				p12.line_no = production.line_no AND
				p12.scan_date = production.scan_date AND
				p12.`hour` = 12 AND
				p12.shift = 'B'
				GROUP BY
				p12.scan_date,
				p12.`hour`
				),0) hr12
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

	// public function line_data($status,$section,$category,$shift){
	// 	 $sql="SELECT
	// 		line.line_id,
	// 		line.line_code,
	// 		line.active,
	// 		line.created_at,
	// 		line.created_user,
	// 		line.updated_at,
	// 		line.updated_user,
	// 		line.location,
	// 		line.section,
	// 		line.category
	// 		FROM `line`
	// 		WHERE
	// 		line.category = '".$category."' AND
	// 		#line.section = '".$section."' AND
	// 		line.active = '".$status."' AND
	// 		line.double_shift like '".$shift."'
	// 		";
	// 	$query = $this->db->query($sql);

	// 	$result = $query->result_array();
	// 	//print_r($result);
	// 	return $result;
	// }

			public function line_data($status,$section,$category,$shift){
				$sql="SELECT
				line.line_id,
				line.line_code,
				line.active,
				line.created_at,
				line.created_user,
				line.updated_at,
				line.updated_user,
				line.location,
				line.section,
				line.category,
				style.style_name
				FROM
				line
				INNER JOIN production ON line.line_id = production.line_no
				INNER JOIN order_head ON production.order_id = order_head.order_id
				INNER JOIN style ON order_head.style = style.style_id
				WHERE
				line.category = '".$category."' AND
			#line.section = '".$section."' AND
				line.active = '".$status."' AND
				line.double_shift like '".$shift."' AND
				production.scan_date = '2021-09-03'
				GROUP BY
				line.line_id
				ORDER BY
				line.section ASC,
				style.style_name ASC,
				line.line_id ASC
				";
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;
			}
			public function total_per_day(){

				$sql="SELECT
				line.line_id,
				line.line_code,
				line.active,
				line.created_at,
				line.created_user,
				line.updated_at,
				line.updated_user,
				line.location,
				line.section,
				line.category
				FROM `line`
				WHERE
				line.category = '".$category."' AND
				line.section = '".$section."' AND
				line.active = '".$status."'
				";
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;
			}
			public function daily_production($line,$shift,$date){

				$sql="SELECT
				ifnull(sum(production.qty),0) qty
				FROM `production`
				WHERE
				production.line_no = '".$line."' AND
				production.shift = '".$shift."' AND
				production.scan_date = '".$date."' AND
				production.operation=4";

				$query = $this->db->query($sql);
//echo $this->db->last_query();
				$qty = $query->row_array();

				return $qty['qty'];

			}

			public function daily_production_hourly($line,$shift,$date,$hour){

				$sql="SELECT
				ifnull(sum(production.qty),0) qty
				FROM `production`
				WHERE
				production.line_no = '".$line."' AND
				production.shift = '".$shift."' AND
				production.scan_date = '".$date."' AND
				production.hour=".$hour." AND
				production.operation=4";

				$query = $this->db->query($sql);
//echo $this->db->last_query();
				$qty = $query->row_array();

				return $qty['qty'];

			}

			public function daily_production_hourly_total($section,$shift,$date,$hour){

				$sql="SELECT
				ifnull(sum(production.qty),0) qty
				FROM
				production
				INNER JOIN line ON production.line_no = line.line_id
				where
				line.section = '".$section."' AND
				production.shift = '".$shift."' AND
				production.scan_date = '".$date."' AND
				production.hour=".$hour." AND
				production.operation=4";

				$query = $this->db->query($sql);
//echo $this->db->last_query();
				$qty = $query->row_array();

				return $qty['qty'];

			}


			public function get_the_style_running($line,$date){

				$sql="SELECT
				GROUP_CONCAT(DISTINCT style.style_code) style,
				GROUP_CONCAT(DISTINCT style.style_name) style_name
				FROM
				production
				INNER JOIN order_head ON production.order_id = order_head.order_id
				INNER JOIN style ON order_head.style = style.style_id
				WHERE
				production.line_no = '".$line."' AND
				production.scan_date = '".$date."' AND
				production.operation=4";

				$query = $this->db->query($sql);

				return $style_data = $query->row_array();

				//return $qty['style'];

			}


			public function get_plan_qty($line,$date,$shift){

				$sql="SELECT
				line_commitments.plan_qty
				FROM `line_commitments`
				WHERE
				line_commitments.shift = '".$shift."' AND
				line_commitments.line = '".$line."' AND
				line_commitments.date = '".$date."'
				";

				$query = $this->db->query($sql);

				$qty = $query->row_array();

				return $qty['plan_qty'];

			}

			public function get_commietd_qty($line,$date,$shift){

				$sql="SELECT
				line_commitments.commited
				FROM `line_commitments`
				WHERE
				line_commitments.shift = '".$shift."' AND
				line_commitments.line = '".$line."' AND
				line_commitments.date = '".$date."'
				";

				$query = $this->db->query($sql);

				$qty = $query->row_array();

				return $qty['commited'];

			}

			public function get_working_hours($line,$date,$shift){

				$sql="SELECT
				line_commitments.hrs
				FROM `line_commitments`
				WHERE
				line_commitments.shift = '".$shift."' AND
				line_commitments.line = '".$line."' AND
				line_commitments.date = '".$date."'
				";

				$query = $this->db->query($sql);

				$qty = $query->row_array();

				return $qty['hrs'];

			}


			public function max_hour_per_day($line,$date,$shift){

				$sql="SELECT
				MAX(production.hour) hour
				FROM `production`
				WHERE
				production.shift = '".$shift."' AND
				production.scan_date = '".$date."' AND
				production.operation=4
				";

				$query = $this->db->query($sql);

				$qty = $query->row_array();

				return $qty['hour'];

			}

			public function get_super_market_wip(){


				$sql="SELECT
					view_sm_wip_report.tty_sum,
					view_sm_wip_report.order_id,
					view_sm_wip_report.style_code,
					view_sm_wip_report.customer_po,
					view_sm_wip_report.color_code,
					view_sm_wip_report.order_code,
					view_sm_wip_report.line_no,
					view_sm_wip_report.site_name
					FROM
						`view_sm_wip_report`
					WHERE
						view_sm_wip_report.tty_sum <> 0
					GROUP BY
					view_sm_wip_report.site_name,
					view_sm_wip_report.order_id";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}

			public function get_super_market_wip_detail($order_id){


				$sql="SELECT *
					FROM `view_sm_inventory`
					WHERE
					view_sm_inventory.qty_abl > 0 AND
					view_sm_inventory.order_id = '".$order_id."'";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}
			public function get_cutting_wip_detail($order_id){


				$sql="SELECT
						view_cut_wip_report_rp.qty_avl qty_abl,
						view_cut_wip_report_rp.style_name,
						view_cut_wip_report_rp.size_code,
						view_cut_wip_report_rp.customer_po,
						view_cut_wip_report_rp.bundle_no,
						view_cut_wip_report_rp.barcode,
						view_cut_wip_report_rp.line_code,
						view_cut_wip_report_rp.order_id
						FROM `view_cut_wip_report_rp`
						WHERE
						view_cut_wip_report_rp.qty_avl > 0 AND
						view_cut_wip_report_rp.order_id = '".$order_id."'";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}

			public function get_cut_to_sm_detail($order_id){


				$sql="SELECT
						view_cut_to_sm_detail.qty_abl,
						view_cut_to_sm_detail.order_id,
						view_cut_to_sm_detail.bundle_no,
						view_cut_to_sm_detail.barcode,
						view_cut_to_sm_detail.item,
						view_cut_to_sm_detail.size,
						view_cut_to_sm_detail.operation,
						view_cut_to_sm_detail.style_code,
						view_cut_to_sm_detail.customer_po,
						view_cut_to_sm_detail.color_code,
						view_cut_to_sm_detail.size_code,
						view_cut_to_sm_detail.order_code,
						view_cut_to_sm_detail.line_code
						FROM `view_cut_to_sm_detail`
						WHERE
						view_cut_to_sm_detail.order_id = '".$order_id."' AND
						view_cut_to_sm_detail.qty_abl > 0
						";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}


			public function get_cutting_wip(){



				// $sql="SELECT
				// view_cut_wip_report.qty tty_sum,
				// view_cut_wip_report.style_code,
				// view_cut_wip_report.color_code,
				// view_cut_wip_report.order_id,
				// view_cut_wip_report.order_code
				// FROM `view_cut_wip_report`
				// WHERE
				// view_cut_wip_report.qty > 0

				// ";

				$sql="SELECT
				view_cut_wip_report.qty AS tty_sum,
				view_cut_wip_report.style_code,
				view_cut_wip_report.color_code,
				view_cut_wip_report.order_id,
				view_cut_wip_report.order_code,
				view_cut_wip_report.site_name
				FROM
				view_cut_wip_report
				WHERE
				view_cut_wip_report.qty <> 0";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}

			// public function get_cutting_wip(){



			// 	$sql="SELECT
			// 	view_cut_wip_report.qty tty_sum,
			// 	view_cut_wip_report.style_code,
			// 	view_cut_wip_report.color_code,
			// 	view_cut_wip_report.order_id,
			// 	view_cut_wip_report.order_code
			// 	FROM `view_cut_wip_report`
			// 	WHERE
			// 	view_cut_wip_report.qty > 0

			// 	";

			// 	$query = $this->db->query($sql);

			// 	$orders = $query->result_array();
			// 	return $orders;


			// }

			public function get_cutting_to_sm_wip(){


// 				$sql="SELECT
// view_cut_to_sm_wip_report.qty tty_sum,
// view_cut_to_sm_wip_report.order_id,
// view_cut_to_sm_wip_report.color_code,
// view_cut_to_sm_wip_report.customer_po,
// view_cut_to_sm_wip_report.style_code,
// view_cut_to_sm_wip_report.order_code
// FROM `view_cut_to_sm_wip_report`
// WHERE
// view_cut_to_sm_wip_report.qty  >0";

				$sql="SELECT
view_cut_to_sm_wip_report.qty tty_sum,
view_cut_to_sm_wip_report.order_id,
view_cut_to_sm_wip_report.color_code,
view_cut_to_sm_wip_report.customer_po,
view_cut_to_sm_wip_report.style_code,
view_cut_to_sm_wip_report.order_code,
view_cut_to_sm_wip_report.line_no,
line.line_code site_name
FROM
view_cut_to_sm_wip_report
INNER JOIN line ON view_cut_to_sm_wip_report.line_no = line.line_id
WHERE
view_cut_to_sm_wip_report.qty <> 0
GROUP BY
view_cut_to_sm_wip_report.line_no,
view_cut_to_sm_wip_report.order_id";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}

			public function get_line_wip(){


				$sql="SELECT *,
				view_line_wip_report.qty tty_sum
FROM `view_line_wip_report`
WHERE
view_line_wip_report.qty > 0
";

				$query = $this->db->query($sql);

				$orders = $query->result_array();
				return $orders;


			}

			// public function get_line_wip(){

			// 	$sql="SELECT
			// 	Sum(production.qty) AS ttl_qty,
			// 	Sum(production.qty) - (SELECT
			// 	Sum(p.qty) AS ttl_qty
			// 	FROM
			// 	production AS p
			// 	INNER JOIN order_head AS OH ON p.order_id = OH.order_id
			// 	INNER JOIN style AS s ON OH.style = s.style_id
			// 	WHERE
			// 	p.operation = 4 AND
			// 	OH.style = style.style_id AND
			// 	OH.order_code = O.order_code
			// 	) AS tty_sum,
			// 	style.style_code,
			// 	O.order_code
			// 	FROM
			// 	production
			// 	INNER JOIN order_head AS O ON production.order_id = O.order_id
			// 	INNER JOIN style ON O.style = style.style_id
			// 	WHERE
			// 	production.operation = 9
			// 	GROUP BY
			// 	production.operation,
			// 	O.style,
			// 	style.style_code,
			// 	O.customer_po,
			// 	O.order_code
			// 	";

			// 	$query = $this->db->query($sql);

			// 	$orders = $query->result_array();
			// 	$data = array();
			// 	foreach ($orders as $row) {

			// 		if($row['tty_sum'] != 0){
			// 			array_push($data, $row);
			// 		}

			// 	}
			// 	return $data;
			// }

			public function get_production_out($date_from, $date_to, $operation,$building,$shift)
			{

				$b=$building;
//echo 'building'.$building;
				$sql = "SELECT
				view_line_out.ttl_qty,
				view_line_out.style_code,
				view_line_out.shift,
				view_line_out.line_code,
				view_line_out.scan_date,
				view_line_out.smv,
				view_line_out.produced_min,
				view_line_out.line_id,
				view_line_out.location,
				view_line_out.seq,
				view_line_out.section,
				view_line_out.active,
				view_line_out.style
				FROM `view_line_out`
				WHERE
				view_line_out.scan_date BETWEEN '".$date_from."' AND '".$date_to."'

				";

				if($shift <> 'X'){
			//echo 0;
					$sql .=" AND
					view_line_out.shift = '".$shift."'";
				}

				if ($b <> 'X') {
			//echo 2;
					$sql .= " AND
					view_line_out.section = '".$b."'";
				}

				$sql .=" ORDER BY
				view_line_out.seq ASC,
				view_line_out.section ASC";
		//echo	$sql;
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}

			public function efficeincy_data($date,$shift,$line_no)
			{

//echo 'building'.$building;
				$sql = "SELECT
				eff_report.shift,
				eff_report.line_id,
				eff_report.style_id,
				eff_report.direct,
				eff_report.indirect,
				eff_report.out_qty,
				(eff_report.out_qty*eff_report.smv) minutes,
				eff_report.work_hours,
				eff_report.smv,
				eff_report.eff,
				eff_report.date,
				eff_report.created_by,
				eff_report.created_date,
				eff_report.work_mins,
				eff_report.ot,
				line.line_code,
				line.seq,
				line.location,
				line.section,
				style.style_code,
				style.style_name,
				(eff_report.work_mins+eff_report.ot)*(eff_report.direct+eff_report.indirect) AS clock_minutes
				FROM
				eff_report
				INNER JOIN line ON eff_report.line_id = line.line_id
				INNER JOIN style ON eff_report.style_id = style.style_id
				WHERE
				eff_report.shift = '".$shift."' AND
				eff_report.line_id = $line_no AND
				eff_report.date = '".$date."'
				ORDER BY
				line.seq ASC
				";
		//echo	$sql;
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}
			public function efficeincy_production($date)
			{


				$sql = "SELECT
				view_line_out.ttl_qty,
				view_line_out.style_code,
				view_line_out.shift,
				view_line_out.line_code,
				view_line_out.scan_date,
				view_line_out.smv,
				view_line_out.produced_min,
				view_line_out.line_id,
				view_line_out.location,
				view_line_out.seq,
				view_line_out.section,
				view_line_out.active,
				view_line_out.style,
				view_line_out.style_name
				FROM `view_line_out`
				WHERE
				view_line_out.scan_date = '".$date."'";
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}

			public function eff_product_wise($date, $site)	{

				$sql = "SELECT
				Sum(e.direct) AS direct,
				Sum(e.indirect) AS indirect,
				Sum(e.out_qty) AS qty,
				Sum(e.out_qty*e.smv) AS minutes,
				e.work_hours,
				e.smv,
				e.eff,
				e.date,
				e.created_by,
				e.created_date,
				e.work_mins,
				Sum((e.work_mins+e.ot)*(e.direct+e.indirect)) AS clock_minutes,
				(sum(e.work_mins)/570) AS no_lines,
				style_cat.category style_name
				FROM
				eff_report AS e
				INNER JOIN style ON e.style_id = style.style_id
				INNER JOIN style_cat ON style.style_cat = style_cat.id
				INNER JOIN line ON line.line_id = e.line_id
				WHERE
				e.date = '".$date."' AND line.location = ".$site."
				GROUP BY
				style_cat.category
				";
				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}

			public function paln_qty($date,$shift,$line)
			{



				$sql = "SELECT
				line_commitments.plan_qty
				WHERE
				line_commitments.date = '".$date."' AND
				line_commitments.line = $line AND
				line_commitments.shift = '".$shift."'";
				$query = $this->db->query($sql);

				$qty = $query->row_array();

				return $qty['plan_qty'];

			}

			public function eff_line_wise($date, $site)
			{

				$sql = "SELECT
				view_efficeincy.shift,
				view_efficeincy.line_id,
				view_efficeincy.direct,
				view_efficeincy.indirect,
				Sum(view_efficeincy.out_qty) AS out_qty,
				Sum(view_efficeincy.out_qty * view_efficeincy.smv) AS prod_minutes,
				Avg(view_efficeincy.smv) AS avg_smv,
				Sum(view_efficeincy.clock_hrs) AS clock_hrs,
				view_efficeincy.line_code,
				view_efficeincy.section,
				view_efficeincy.seq,
				Sum(view_efficeincy.ot) AS ot,
				Sum(view_efficeincy.work_mins) AS work_mins,
				line_commitments.plan_qty,
				line_commitments.commited_by,
				line_commitments.plan_sah
				FROM
				view_efficeincy
				LEFT JOIN line_commitments ON view_efficeincy.line_id = line_commitments.line AND view_efficeincy.shift = 		line_commitments.shift AND view_efficeincy.date = line_commitments.date
				INNER JOIN line ON line.line_id = view_efficeincy.line_id
				WHERE
				view_efficeincy.date = '".$date."' AND line.location = ".$site."
				GROUP BY
				view_efficeincy.shift,
				view_efficeincy.line_id	";

				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}


			public function eff_section_wise($date, $site)
			{
				// $sql = "SELECT
				// Sum(e.out_qty) AS out_qty,
				// Sum(e.minutes) AS minutes,
				// e.ot,
				// Sum(e.work_mins) AS work_mins,
				// line.category,
				// line.location,
				// line.section,
				// e.shift,
				// Sum(e.direct) AS direct,
				// Sum(e.indirect) AS indirect,
				// Sum(e.plan_qty) AS plan_qty,
				// Sum(e.plan_sah) AS plan_sah,
				// sum(e.clock_hrs) clock_minutes,
				// SUM(e.work_mins) work_mins
				// FROM
				// view_efficeincy AS e
				// INNER JOIN line ON e.line_id = line.line_id
				// WHERE
				// e.date = '".$date."'
				// GROUP BY
				// e.shift,
				// line.section
				// ORDER BY
				// e.shift ASC
				// ";
				$sql="SELECT
					e.shift,
					Sum(e.direct) direct,
					Sum(e.indirect) indirect,
					Sum(e.out_qty) out_qty,
					Sum(e.prod_minutes) minutes,
					Avg(e.avg_smv) smv,
					Sum(e.clock_hrs) clock_minutes,
					Sum(e.ot) ot,
					Sum(e.work_mins) work_mins,
					Sum(e.plan_qty) plan_qty,
					Sum(e.plan_sah) plan_sah,
					line.section
					FROM
						view_line_wise_eff AS e
					INNER JOIN line ON e.line_id = line.line_id
					WHERE
						e.date = '".$date."' AND line.location = ".$site."
					GROUP BY
					e.shift,
					line.section,
					e.date
					ORDER BY
					e.shift ASC
					";

				$query = $this->db->query($sql);

				$result = $query->result_array();
		//print_r($result);
				return $result;

			}


			public function get_scan_history2($po_no, $order_id, $cut_no, $operation, $barcode)
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
				order_head.customer_po,
				cut_bundles_2.cut_no
				FROM
				production
				INNER JOIN size ON production.size = size.size_id
				INNER JOIN operation ON production.operation = operation.operation_id
				INNER JOIN line ON production.line_no = line.line_id
				INNER JOIN `user` ON production.created_by = `user`.id
				INNER JOIN order_head ON order_head.order_id = production.order_id
				LEFT JOIN cut_bundles_2 ON cut_bundles_2.barcode = production.barcode
				WHERE
				production.order_id IS NOT NULL";

				if($po_no != null && $po_no != ''){
					$sql .= " AND order_head.customer_po = '" . $po_no . "'";
				}

				if ($order_id != null && $order_id != '') {
					$sql .= " AND production.order_id = '" . $order_id . "'";
				}

				if ($operation != null && $operation != '') {
					$sql .= " AND production.operation = '" . $operation . "'";
				}
				else {
					$sql .= " AND production.operation IN (1, 2, 3, 9)";
				}

				if ($barcode != null && $barcode != '') {
					$sql .= " AND production.barcode = '" . $barcode . "'";
				}

				if ($cut_no != null && $cut_no != '') {
					$sql .= " AND cut_bundles_2.cut_no = '" . $cut_no . "'";
				}

				$sql .= " ORDER BY
				production.laysheet_no ASC,
				production.bundle_no ASC,
				operation.seq ASC
				";
			//	echo $sql;die();
				$query = $this->db->query($sql);

				$result = $query->result_array();
				//print_r($result);
				return $result;

			}


			public function get_barcode_tracking($cut_no, $order_id){
				$sql = "SELECT
				cut_bundles_2.order_id,
				cut_bundles_2.barcode,
				cut_bundles_2.bundle_no,
				cut_bundles_2.laysheet_no,
				cut_bundles_2.cut_no,
				cut_bundles_2.letter,
				size.size_code,
				MAX(CASE
						WHEN `production`.`operation` = 1 THEN
							`production`.created_date
						END)
					AS 'CUTTING_OUT',
				MAX(CASE
						WHEN `production`.`operation` = 2 THEN
							`production`.created_date
						END)
					AS 'SUPERMARKET_IN',
				MAX(CASE
						WHEN `production`.`operation` = 3 THEN
							`production`.created_date
						END)
					AS 'SUPERMARKET_OUT',
				MAX(CASE
						WHEN `production`.`operation` = 9 THEN
							`production`.created_date
						END)
					AS 'LINE_IN',
				MAX(CASE
						WHEN `production`.`operation` = 4 THEN
							`production`.created_date
						END)
					AS 'LINE_OUT',
				MAX(CASE
						WHEN `production`.`operation` = 12 THEN
							`production`.created_date
						END)
					AS 'PREPERATION',
				MAX(CASE
						WHEN `production`.`operation` = 13 THEN
							`production`.created_date
						END)
					AS 'PLACKET',
				MAX(CASE
						WHEN `production`.`operation` = 14 THEN
							`production`.created_date
						END)
					AS 'HEAT_SEAL',
				MAX(CASE
						WHEN `production`.`operation` = 15 THEN
							`production`.created_date
						END)
					AS 'BINDING'
				FROM
				cut_bundles_2
				LEFT JOIN production ON cut_bundles_2.order_id = production.order_id AND cut_bundles_2.barcode = production.barcode
				INNER JOIN size ON size.size_id = cut_bundles_2.size
				WHERE cut_bundles_2.order_id IS NOT NULL ";

				if($cut_no != null && $cut_no != ''){
					$sql .= " AND cut_bundles_2.cut_no = ".$cut_no;
				}

				if($order_id != null && $order_id != ''){
					$sql .= " AND cut_bundles_2.order_id = ".$order_id;
				}

				$sql .= " GROUP BY production.barcode";

				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}


			//User Login Audit Report ------------------------------------------------

			public function get_user_login_audit_summery($date){
				$sql = "SELECT
				user_login_audit.*,
				user.user_name,
				user.first_name,
				user.last_name,
				(SELECT MAX(a.login_timestamp) FROM user_login_audit AS a WHERE a.user_id = user.id AND a.login_timestamp LIKE '".$date."%') AS last_timestamp,
				(SELECT COUNT(b.id) FROM user_login_audit AS b WHERE b.user_id = user.id AND b.login_timestamp LIKE '".$date."%') AS login_count
				FROM user_login_audit
				INNER JOIN user ON user.id = user_login_audit.user_id
				WHERE user_login_audit.login_timestamp LIKE '".$date."%'
				GROUP BY user_login_audit.user_id";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}


			public function get_user_login_audit_details($date){
				$sql = "SELECT
				user_login_audit.*,
				user.user_name,
				user.first_name,
				user.last_name,
				departments.dep_name
				FROM user_login_audit
				INNER JOIN user ON user.id = user_login_audit.user_id
				INNER JOIN departments ON departments.dep_id = user.department
				WHERE user_login_audit.login_timestamp LIKE '".$date."%'";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			//Daily rejection report -------------------------------------------------

			public function get_daily_redjection_data($from_date, $to_date, $sizes){
				$sql = "SELECT tbl.*,";

				foreach ($sizes as $row) {
					$sql .= "SUM(if (size = ".$row['size'].", ttl_qty, 0)) AS size".$row['size'].",";
				}

				$sql .= "(
						SELECT
							SUM(p.qty)
						FROM
							production p
						INNER JOIN order_head oh ON oh.order_id = p.order_id
						WHERE
							oh.style = tbl.style_id
						AND oh.color = tbl.color_id
						AND oh.customer_po = tbl.customer_po
						AND p.line_no = tbl.line_id
						AND p.scan_date = tbl.scan_date
						AND p.operation = 4
					) AS daily_output
				FROM
				(SELECT
					rejection.scan_date,
					rejection.size,
					SUM(qty) AS ttl_qty,
					order_head.customer_po,
					style.style_id,
					style.style_code,
					color.color_id,
					color.color_code,
					rejection_type.rejection_name,
					line.line_id,
					line.line_code
				FROM
					rejection
				INNER JOIN order_head ON order_head.order_id = rejection.order_id
				INNER JOIN style ON style.style_id = order_head.style
				INNER JOIN color ON color.color_id = order_head.color
				INNER JOIN line ON line.line_id = rejection.line_no
				LEFT JOIN rejection_type ON rejection_type.id = rejection.reason_code
				WHERE
					rejection.scan_date BETWEEN '".$from_date."'
				AND '".$to_date."'
				GROUP BY
					rejection.scan_date,
					rejection.line_no,
					order_head.customer_po,
					order_head.style,
					order_head.color,
					rejection.reason_code,
					rejection.size
				ORDER BY
					rejection.scan_date,
					rejection.line_no
				) AS tbl

				GROUP BY
					tbl.scan_date,
					tbl.line_code,
					tbl.customer_po,
					tbl.style_code,
					tbl.color_code,
					tbl.rejection_name
				ORDER BY tbl.scan_date, tbl.line_code, tbl.customer_po, tbl.style_code, tbl.color_code, tbl.rejection_name ";
					//echo ($sql);die();
				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}


			public function get_rejection_sizes($from_date, $to_date){
				$sql = "SELECT
				rejection.size,
				size.size_code
				FROM
				rejection
				INNER JOIN size ON size.size_id = rejection.size
				WHERE rejection.scan_date BETWEEN '".$from_date."' AND '".$to_date."'
				GROUP BY rejection.size";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			//Order status report - size wise ---------------------------------------

			public function get_customer_styles($customer_id){

			}


			public function get_daily_total($date, $site, $shift){
				/*$sql = "SELECT
				style_cat.id,
				style_cat.category,
				SUM(e.out_qty) AS out_qty,
				SUM(e.minutes) AS minutes,
				SUM(e.work_mins) AS work_minutes,
				SUM(e.direct) AS direct_operators,
				SUM(e.indirect) AS indirect_operators,
				COUNT(e.line_id) AS line_count,
				SUM(e.smv) AS total_smv,
				(
					SELECT SUM(line_commitments.plan_sah) FROM line_commitments
					WHERE line_commitments.date = e.date AND line_commitments.line IN
					(
						SELECT eff_report.line_id FROM eff_report WHERE eff_report.date = e.date
						AND eff_report.style_category = e.style_category
					)
				) AS plan_sah
				FROM
				eff_report AS e
				INNER JOIN style_cat ON style_cat.id = e.style_category
				INNER JOIN line ON line.line_id = e.line_id
				WHERE
				e.date = '".$date."' AND line.location = ".$site;

				if($shift != null){
					$sql .= " AND e.shift = '".$shift."'";
				}

				$sql .= " GROUP BY
				e.style_category";*/

				$sql = "SELECT
				style_cat.id AS category_id,
				style_cat.category AS category_name,
				SUM(view_efficeincy.out_qty) AS out_qty,
				SUM(view_efficeincy.minutes) AS minutes,
				SUM(view_efficeincy.work_mins) AS work_mins,
				SUM(view_efficeincy.direct) AS direct_operators,
				SUM(view_efficeincy.indirect) AS indirect_operators,
				COUNT(DISTINCT view_efficeincy.line_id,view_efficeincy.shift) AS line_count,
				SUM(view_efficeincy.smv) AS total_smv,
				SUM(view_efficeincy.plan_sah) AS plan_sah,
				SUM(view_efficeincy.clock_hrs) AS clock_hrs
			FROM
				view_efficeincy
			INNER JOIN style_cat ON style_cat.id = view_efficeincy.style_category
			INNER JOIN line ON line.line_id = view_efficeincy.line_id
			WHERE
				view_efficeincy.date = '".$date."' AND line.location = ".$site;

				if($shift != null){
					$sql .= " AND view_efficeincy.shift = '".$shift."'";
				}

				$sql .= " GROUP BY
					view_efficeincy.style_category";

				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			// FG stock report ........................................................

			public function get_fg_stock_data($style_id, $color_id, $size_id){
				$sql = "SELECT
				fg.order_id,
				style.style_code,
				style.style_name,
				color.color_code,
				color.color_name,
				order_head.customer_po,
				size.size_code,
				SUM(fg.qty) AS total_qty
				FROM fg
				INNER JOIN order_head ON order_head.order_id = fg.order_id
				INNER JOIN style ON style.style_id = order_head.style
				INNER JOIN color ON color.color_id = order_head.color
				INNER JOIN size ON size.size_id = fg.size
				WHERE transection_id IS NOT NULL ";

				if($style_id != null && $style_id != ''){
					$sql .= " AND order_head.style = ". $style_id;
				}

				if($color_id != null && $color_id != ''){
					$sql .= " AND order_head.color = ". $color_id;
				}

				if($size_id != null && $size_id != ''){
					$sql .= " AND fg.size = ". $size_id;
				}

				$sql .= " GROUP BY fg.order_id, fg.size ";

				$query = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}


			//bundle ageing report ---------------------------------------------------

			public function get_operation($operation_id){
				$sql = "SELECT * FROM operation WHERE operation_id = ".$operation_id;
				$query = $this->db->query($sql);
				return $query->row_array();
			}

			public function get_operation_by_seq($seq){
				$sql = "SELECT * FROM operation WHERE seq = ".$seq;
				$query = $this->db->query($sql);
				return $query->row_array();
			}

			public function get_operations(){
				$sql = "SELECT * FROM operation ORDER BY seq";
				$query = $this->db->query($sql);
				return $query->result_array();
			}


			public function get_bundle_ageing_data($op1, $op2, $customer_po){
				$current_timestamp = date("Y-m-d H:i:s");
				$date = new DateTime($current_timestamp);
				$date->modify('-2 day');
				$date = $date->format('Y-m-d');

				$sql = "SELECT * FROM (SELECT
					p.order_id,
					p.barcode,
					p.scan_date,
					p.qty,
					color.color_code,
					size.size_code,
					COUNT(CASE WHEN p.operation = ".$op1." THEN 1 ELSE NULL END) AS op1,
					COUNT(CASE WHEN p.operation = ".$op2." THEN 1 ELSE NULL END) AS op2
					FROM production p
					INNER JOIN color ON color.color_id = p.color
					INNER JOIN size ON size.size_id = p.size
					INNER JOIN order_head ON order_head.order_id = p.order_id
					WHERE (p.operation = ".$op1." OR p.operation = ".$op2.") AND order_head.customer_po = '".$customer_po."' AND p.scan_date <= '".$date."'
					AND p.scan_date >= '2022-05-01'
					GROUP BY p.barcode) AS tbl WHERE tbl.op1 > tbl.op2 ";
					//echo $sql;die();

					$query = $this->db->query($sql);
					return $query->result_array();
			}


			public function get_bundle_ageing_summery($op1, $op2){
				$current_timestamp = date("Y-m-d H:i:s");
				$date = new DateTime($current_timestamp);
				$date->modify('-2 day');
				$date = $date->format('Y-m-d');

				$sql = "SELECT
				tbl2.customer_po,
				tbl2.size_code,
				tbl2.color_code,
				tbl2.style_code,
				SUM(tbl2.qty) AS total_qty
				FROM (
					SELECT * FROM (
						SELECT
						p.order_id,
						p.barcode,
						p.qty,
						color.color_code,
						size.size_code,
						order_head.customer_po,
						style.style_code,
						COUNT(CASE WHEN p.operation = ".$op1." THEN 1 ELSE NULL END) AS op1,
						COUNT(CASE WHEN p.operation = ".$op2." THEN 1 ELSE NULL END) AS op2
						FROM production p
						INNER JOIN color ON color.color_id = p.color
						INNER JOIN size ON size.size_id = p.size
						INNER JOIN order_head ON order_head.order_id = p.order_id
						INNER JOIN style ON style.style_id = order_head.style
						WHERE (p.operation = ".$op1." OR p.operation = ".$op2.") AND p.scan_date <= '".$date."' AND p.scan_date >= '2022-05-01'
						GROUP BY p.barcode
					) AS tbl WHERE tbl.op1 > tbl.op2
				) AS tbl2
				GROUP BY tbl2.customer_po";
				//echo $sql;die();
				$query = $this->db->query($sql);
				return $query->result_array();
			}


			//incomplete laysheets----------------------------------------------------

			public function get_incomplete_laysheets(){
				$sql = "SELECT
				cut_laysheet.*,
				order_head.customer_po,
				order_head.order_code
				FROM cut_laysheet
				INNER JOIN order_head ON order_head.order_id = cut_laysheet.order_id
				WHERE is_completed IS NULL ORDER BY laysheet_no";
				$query = $this->db->query($sql);
				return $query->result_array();
			}

			//Cutting Reconciliation Report-------------------------------------------

			public function cutting_reconciliation_report_data($date, $customer_po){
				$str = '';
				$order_list = [];
				if($customer_po == null || $customer_po == ''){
					$order_list = $this->get_orders_from_cut_date($date);
				}
				else {
					$order_list = $this->get_orders_from_cut_date_and_po($date, $customer_po);
				}

				if($order_list == null || sizeof($order_list) <= 0){
					return [];
				}

				$arr = [];
				foreach ($order_list as $row) {
					array_push($arr, $row['order_id']);
				}
				$str = implode(",",$arr);

				$sql = "SELECT
				order_head.style,
				order_head.customer_po,
				order_head.color,
				style.style_code,
				color.color_code,
				(SELECT SUM(order_item_sizes.order_qty) FROM order_item_sizes WHERE order_item_sizes.order_id = order_head.order_id) AS order_qty,
				(
					SELECT
					SUM(cut_plan_detail.qty)
					FROM cut_plan_detail
					INNER JOIN cut_plan ON cut_plan.cut_plan_id = cut_plan_detail.cut_plan_id
					WHERE cut_plan.prod_ord_detail_id = order_head.order_id
				) AS pds_cut_qty,
				(
					SELECT
					SUM(cut_bundles_2.qty)
					FROM cut_bundles_2
					WHERE cut_bundles_2.order_id = order_head.order_id AND cut_bundles_2.date = '".$date."%'
				) AS cut_qty,
				(
					SELECT
					SUM(cut_bundles_2.qty)
					FROM cut_bundles_2
					WHERE cut_bundles_2.order_id = order_head.order_id AND cut_bundles_2.date <= '".$date." 23:59:59'
				) AS cum_cut_qty
				FROM order_head
				INNER JOIN style ON style.style_id = order_head.style
				INNER JOIN color ON color.color_id = order_head.color
				WHERE order_head.order_id IN (".$str.")";

				//echo $sql;die();
				$query = $this->db->query($sql);
				return $query->result_array();
			}


			public function get_orders_from_cut_date($date){
				$sql = "SELECT
					order_head.order_id
					FROM
					cut_bundles_2
					INNER JOIN order_head ON order_head.order_id = cut_bundles_2.order_id
					WHERE cut_bundles_2.date = '".$date."'
					GROUP BY cut_bundles_2.order_id,order_head.customer_po ";
					//echo $sql;die();
					$query = $this->db->query($sql);
					return $query->result_array();
			}

			public function get_orders_from_cut_date_and_po($date, $customer_po){
				$sql = "SELECT
					order_head.order_id
					FROM
					cut_bundles_2
					INNER JOIN order_head ON order_head.order_id = cut_bundles_2.order_id
					WHERE cut_bundles_2.date = '".$date."' AND order_head.customer_po = '".$customer_po."'
					GROUP BY cut_bundles_2.order_id,order_head.customer_po ";
					//echo $sql;die();
					$query = $this->db->query($sql);
					return $query->result_array();
			}


			//scan history line out report -------------------------------------------

			public function get_scan_history_lineout($user_id, $order_id, $barcode, $line_no, $size, $scan_date)
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
				production.prev_operation,
				production.shift,
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
				production.order_id IS NOT NULL AND production.operation = 4 AND production.created_by = ".$user_id;

				if ($order_id != null or $order_id != '') {
					$sql .= " AND production.order_id = '" . $order_id . "'";
				}
				if ($barcode != null or $barcode != '') {
					$sql .= " AND production.barcode = '" . $barcode . "'";
				}
				if ($line_no != null or $line_no != '') {
					$sql .= " AND production.line_no = " . $line_no;
				}
				if ($size != null or $size != '') {
					$sql .= " AND size.size_code = '" . $size."'";
				}
				if ($scan_date != null or $scan_date != '') {
					$sql .= " AND production.scan_date = '" . $scan_date."'";
				}


				$sql .= " ORDER BY
				production.laysheet_no ASC,
				production.bundle_no ASC,
				operation.seq ASC
				";
				//echo $sql;die();
				$query = $this->db->query($sql);

				$result = $query->result_array();
				//print_r($result);
				return $result;

			}

	//Order status report - line wise --------------------------------------------

	public function get_order_status_report_line_wise($customer, $style, $customer_po, $color,$size)
	{
		$query_parms = [];
		$customer_po = ($customer_po == 'NO') ? '' : $customer_po;

		$data = [];

		$sql1 = "SELECT
			order_head.*,
			style.style_code,
			customer.cus_name,
			color.color_code,
			order_item_sizes.size,
			order_item_sizes.order_qty AS s_ord_qty,
			order_item_sizes.planned_qty AS s_plan_qty,
			size.size_code,
			view_status_report.CUTTING_OUT,
			view_status_report.PREPARATION,
			view_status_report.SUPERMARKET_IN,
			view_status_report.SUPERMARKET_OUT,
			view_status_report.LINE_OUT,
			view_status_report.LINE_IN,
			view_status_report.line_no,
			line.line_code 
			FROM
			order_head
			INNER JOIN style ON order_head.style = style.style_id
			INNER JOIN customer ON order_head.customer = customer.id
			INNER JOIN color ON order_head.color = color.color_id
			INNER JOIN order_item_sizes ON order_head.order_id = order_item_sizes.order_id
			INNER JOIN size ON order_item_sizes.size = size.size_id
			LEFT JOIN view_status_report ON order_head.order_id = view_status_report.order_id AND size.size_id = view_status_report.size
			LEFT JOIN line ON line.line_id = view_status_report.line_no
			WHERE
			order_head.active = 'Y'";

		if($customer_po != ''){
				$sql1 .= " AND order_head.customer_po IN ?";
				$arr = explode(',', $customer_po);
				array_push($query_parms, $arr);
		}

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
		order_head.active = 'Y' GROUP BY view_status_report.line_no
		ORDER BY
		order_head.order_id DESC,
		size.seq ASC
		LIMIT 30
		";


		$query = $this->db->query($sql1, $query_parms);
		$orders = $query->result_array();

		foreach ($orders as $row) {
			$order_data = $row;


					$order_data['operations'] = [];


					$sql3 = "SELECT
						IFNULL(Sum(rejection.qty),0) rej_qty
						FROM `rejection`
						WHERE
						rejection.order_id =? AND
						rejection.size = ?";

					$query3 = $this->db->query($sql3, [$row['order_id'], $row['size']]);

					$rej_qty = $query3->row_array();

					$rej_qty = $rej_qty['rej_qty'];

					$order_data['rej_qty'] = $rej_qty;


					$sql4 = "SELECT IFNULL(SUM(qty),0) as qty FROM cut_bundles_2 WHERE order_id = ? AND cut_bundles_2.size=?";

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

					//get fg transferd qty (PO to PO transfer, B Stores Transfer)
					$sql7 = "SELECT IFNULL(SUM(qty),0) as qty
					FROM fg
					WHERE
					fg.order_id = ? AND
					fg.size = ? AND
					fg.operation NOT IN ('FG_RECEIVE', 'SHIPMENT')";

					$query7 = $this->db->query($sql7, [$row['order_id'], $row['size']]);
					$transfered_qty = $query7->row_array();
					$transfered_qty = $transfered_qty['qty'];
					$order_data['transfered_qty'] = $transfered_qty;

					//get fg wip, avaliable fg balance
					$sql8 = "SELECT IFNULL(SUM(qty),0) as qty FROM fg
					WHERE fg.order_id = ? AND	fg.size = ?";

					$query8 = $this->db->query($sql8, [$row['order_id'], $row['size']]);
					$fg_wip_qty = $query8->row_array();
					$fg_wip_qty = $fg_wip_qty['qty'];
					$order_data['fg_wip_qty'] = $fg_wip_qty;

					array_push($data, $order_data);
				}

				return $data;

			}



		}
