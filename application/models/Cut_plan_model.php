<?php


if (!defined('BASEPATH'))

	exit('No direct script access allowed');


class Cut_plan_model extends CI_Model
{


	public function __construct()
	{

		parent::__construct();

		$this->load->database();

	}


	public function get_order_head()
	{

		$ord_id = $this->input->post('ord_id');


		$sql = "SELECT

OH.order_id,

OH.order_code,

OH.style,

OH.color,

OH.customer_po,

OH.uom,

OH.customer,

OH.country,

OH.ship_method,

OH.delivary_date,

OH.pcd_date,

OH.planned_delivary_date,

OH.original_ord_qty,

OH.planned_qty,

OH.sales_qty,

OH.season,

OH.site,

OH.created_at,

OH.created_by,

OH.updated_at,

OH.updated_by,

OH.active,

style.style_code,

color.color_code,

style.style_name,

customer.cus_name,

season.season_name

FROM

order_head AS OH

INNER JOIN style ON OH.style = style.style_id

INNER JOIN color ON OH.color = color.color_id

INNER JOIN customer ON OH.customer = customer.id

INNER JOIN season ON OH.season = season.season_id

WHERE

  OH.order_id = " . $ord_id . "

";

		$query = $this->db->query($sql);

		return $result = $query->row_array();

	}


	public function get_cut_plan()
	{

		$ord_id = $this->input->post('ord_id');

		$sql = "SELECT

cut_plan.cut_plan_id,

cut_plan.prod_ord_detail_id,

cut_plan.order_code,

cut_plan.style,

cut_plan.color,

cut_plan.cust_po,

cut_plan.ord_qty,

cut_plan.plan_qty,

cut_plan.uom,

cut_plan.item_code,

cut_plan.item_description,

cut_plan.date,

cut_plan.`user`,

cut_plan.create_date,

cut_plan.remarks,

cut_plan.country,

cut_plan.adviced_by,

cut_plan.site,

cut_plan.item_id,

cut_plan.cmp_id,

style.style_code,

color.color_code,

color.color_name,

item.item_code,

item.item_description,

component.com_code,

component.com_description

FROM

cut_plan

INNER JOIN style ON cut_plan.style = style.style_id

INNER JOIN color ON cut_plan.color = color.color_id

INNER JOIN item ON cut_plan.item_id = item.item_id

INNER JOIN component ON cut_plan.cmp_id = component.com_id

WHERE

cut_plan.cut_plan_id = '" . $ord_id . "'

";

		$query = $this->db->query($sql);

		return $query->row_array();


	}


	public function get_cut_no()
	{

		$ord_id = $this->input->post('ord_id');

//        $this->db->select('*');

//        $this->db->from('cut_plan_detail');

//        //  $this->db->where('order_id', $ord_id);

//        $query = $this->db->get();


		$sql = "SELECT

/*cut_plan_detail.cut_plan_detail_id,*/

cut_plan_detail.cut_plan_id,

cut_plan_detail.line_no,

cut_plan_detail.ratio,

cut_plan_detail.plies,

cut_plan_detail.qty,

/*cut_plan_detail.cut_no,*/

cut_plan_detail.line_ref,

cut_plan_detail.marker_ref,

cut_plan_detail.lay_qty,

cut_plan_detail.width,

cut_plan_detail.size,

cut_plan_detail.marker_legth,

cut_plan_detail.marker_lenght2,

cut_plan_detail.marker_eff,

/*cut_plan_detail.total_qty,*/

cut_plan_detail.marker_uom,

cut_plan_detail.perimeter_int,

cut_plan_detail.perimeter_decimal,

cut_plan_detail.site,

cut_plan_detail.item_id,

cut_plan_detail.mdl_cmp,

cut_plan.prod_ord_detail_id ord_id,

(SELECT count(cut_laysheet.laysheet_no) 
FROM
	`cut_laysheet`
WHERE
	cut_laysheet.cut_plan_id = cut_plan_detail.cut_plan_id
AND cut_laysheet.cut_no = cut_plan_detail.line_no
) cut_count,
(SELECT cut_laysheet.laysheet_no
FROM
	`cut_laysheet`
WHERE
	cut_laysheet.cut_plan_id = cut_plan_detail.cut_plan_id
AND cut_laysheet.cut_no = cut_plan_detail.line_no
limit 1
) lay_sheet

FROM

cut_plan_detail

INNER JOIN cut_plan ON cut_plan_detail.cut_plan_id = cut_plan.cut_plan_id

WHERE

cut_plan_detail.cut_plan_id = " . $ord_id . "

GROUP BY

cut_plan_detail.line_no



   ";

		$query = $this->db->query($sql);

		return $query->result_array();

	}

	public function get_order_detail()
	{

		$ord_id = $this->input->post('ord_id');

		$sql = "SELECT

order_item_components.id,

order_item_components.order_item_id,

order_item_components.order_id,

order_item_components.order_id order_detail_id,

order_item_components.item_component,

order_item_components.component_color,

component.com_description,

component.com_code,

color.color_code,

color.color_name,

item.item_code,

item.item_description,

item.item_id

FROM

order_item_components

INNER JOIN component ON order_item_components.item_component = component.com_id

INNER JOIN color ON order_item_components.component_color = color.color_id

INNER JOIN order_items ON order_item_components.order_item_id = order_items.id AND order_item_components.order_id = order_items.order_id

INNER JOIN item ON order_items.item = item.item_id

WHERE

order_item_components.order_id = '" . $ord_id . "'

";


		$query = $this->db->query($sql);

		// return $result = $query->row_array();

//   $this->db->from('product_order_detail');

//   $this->db->where('order_id',1);

//   $query=$this->db->get();

		return $query->result_array();

	}



	// public function get_order_detail() {

	//     $ord_id = $this->input->post('ord_id');

	//     $this->db->select('*');

	//     $this->db->from('product_order_detail');

	//     $this->db->where('order_id', $ord_id);

	//     $query = $this->db->get();

	//     return $query->result_array();

	// }


	public function load_cut_plan_data()
	{

		$this->db->select('*');

		$this->db->from('cut_plan');

		//  $this->db->where('order_id', $ord_id);

		$query = $this->db->get();

		return $query->result_array();

	}


	public function get_product_head_details()
	{

		$ord_id = $this->input->post('prod_ord_detail_id');

		$sql = "SELECT

OH.order_id,

OH.order_code,

OH.style,

OH.color,

OH.customer_po,

OH.uom,

OH.customer,

OH.country,

OH.ship_method,

OH.delivary_date,

OH.pcd_date,

OH.planned_delivary_date,

OH.original_ord_qty,

OH.planned_qty,

OH.sales_qty,

OH.season,

OH.site,

OH.created_at,

OH.created_by,

OH.updated_at,

OH.updated_by,

OH.active,

style.style_code,

style.style_name,

color.color_code,

color.color_name

FROM

order_head AS OH

INNER JOIN style ON OH.style = style.style_id

INNER JOIN color ON OH.color = color.color_id

WHERE

  OH.order_id = $ord_id

";

		$query = $this->db->query($sql);

		return $result = $query->result_array();

	}


	public function get_saved_cp_list()
	{


		$order_details_id = $this->input->post('order_details_id');

		$component_id = $this->input->post('component_id');


		$sql = "SELECT

				cut_plan.cut_plan_id

				FROM

				cut_plan

				WHERE

				cut_plan.prod_ord_detail_id = $order_details_id AND

				cut_plan.cmp_id = $component_id



		";

		$query = $this->db->query($sql);

		return $result = $query->result_array();


	}


	public function get_product_size_data()
	{

		$cut_plan_id = $this->input->post('cut_plan_id');

		$prod_ord_detail_id = $this->input->post('prod_ord_detail_id');

		$item_id = $this->input->post('item_id');

		$cmp_id = $this->input->post('cmp_id');


		$sql = "SELECT

		order_item_sizes.id,

		order_item_sizes.order_item_id,

		order_item_sizes.order_id,

		order_item_sizes.size AS size,

		order_item_sizes.order_qty AS prod_ord_qty,

		order_item_sizes.planned_qty AS prod_ord_plan_qty,

		size.size_code AS prod_ord_size,

		size.size_name,

		order_items.item,

		order_items.item_color,

		order_item_components.item_component

		FROM

		order_item_sizes

		INNER JOIN size ON order_item_sizes.size = size.size_id

		INNER JOIN order_items ON order_item_sizes.order_id = order_items.order_id

		INNER JOIN order_item_components ON order_item_sizes.order_id = order_item_components.order_id AND order_item_sizes.order_item_id = order_item_components.order_item_id

		WHERE

		order_item_sizes.order_id = $prod_ord_detail_id AND

		order_items.item =  $item_id

		AND

		order_item_components.item_component = $cmp_id

		";

		$query = $this->db->query($sql);

		return $result = $query->result_array();

	}


	public function get_product_size_data2($cut_plan_id, $prod_ord_detail_id)
	{

		// $cut_plan_id= $this->input->post('cut_plan_id');

		// $prod_ord_detail_id= $this->input->post('prod_ord_detail_id');


		/*$sql = "SELECT

		  product_ord_size.product_ord_id,

		  product_ord_size.prod_ord_size,

		  product_ord_size.prod_ord_qty,

		  product_ord_size.prod_ord_plan_qty,

		  (SELECT IFNULL( (SELECT SUM(CPD.qty)  FROM cut_plan_detail AS CPD

		  WHERE  CPD.cut_plan_id = '" . $cut_plan_id . "' AND   CPD.size = product_ord_size.prod_ord_size) ,0)) AS cut_plan_qty,

		  product_ord_size.site

		  FROM `product_ord_size`

		  WHERE

		  product_ord_size.product_ord_id = 1

		  ";

		  */


		$sql = "SELECT

					S.size_code AS prod_ord_size,

					IFNULL(Sum(CPD.qty),0) AS cut_plan_qty,

					IFNULL(O.planned_qty,0) AS prod_ord_plan_qty

					FROM

					cut_plan_detail AS CPD

					INNER JOIN size AS S ON CPD.size = S.size_id

					INNER JOIN cut_plan AS CP ON CPD.cut_plan_id = CP.cut_plan_id

					INNER JOIN order_item_sizes AS O ON CP.prod_ord_detail_id = O.order_id AND CPD.size = O.size

					WHERE

					CPD.cut_plan_id = '" . $cut_plan_id . "' AND
					CPD.ratio <> 0

					GROUP BY

					S.size_code";


		$query = $this->db->query($sql);

		return $result = $query->result_array();

	}


	function load_cut_plan_no()
	{

		$prod_ord_detail_id = 0;

		$cut_plan_id = $this->input->post('cut_plan_id');

		$sql = "SELECT * FROM cut_plan_detail WHERE cut_plan_detail.cut_plan_id = $cut_plan_id";

		$query = $this->db->query($sql);

		//return $result = $query->result_array();

		$order_size_data = $this->get_product_size_data2($cut_plan_id, $prod_ord_detail_id);

		$response['detail'] = $query->result_array();

		$response['order_size_data'] = $order_size_data;


		return $response;


	}


	function load_save_cut_plan_ratio()
	{


		try {

			$cut_plan_id = $this->input->post('cp_number');

			$order_id = $this->input->post('order_id');


			$detail = $this->load_save_cut_plan_detail($cut_plan_id);

			$order_size_data = $this->get_product_size_data2($cut_plan_id, $order_id);


			$response['cut_plan_id'] = $cut_plan_id;

			$response['detail'] = $detail;

			$response['order_size_data'] = $order_size_data;

			return $response;


		} catch (Exception $e) {

			return false;

		}

	}


	function save_cut_plan_ratio()
	{

		try {

			$cut_plan_id = $this->input->post('formData')['cut_plan_id'];

			$prod_ord_detail_id = $this->input->post('formData')['prod_ord_detail_id'];

			//$plies= $this->input->post('formData')['plies'];

			$data = $this->input->post('formData');

			$ratio = $this->input->post('ratio');

			if ($cut_plan_id == '') {

				$this->db->set($data);

				$this->db->insert('cut_plan');

				$cut_plan_id = $this->db->insert_id();


				for ($i = 0; $i < count($ratio); $i++) {

					$ratio[$i]['cut_plan_id'] = $cut_plan_id;

					$ratio[$i]['line_no'] = 1;

				}

				$detail = $this->save_cut_plan_detail($cut_plan_id, $ratio);

				$order_size_data = $this->get_product_size_data2($cut_plan_id, $prod_ord_detail_id);

				$response['messege'] = 'sucsess';

				$response['cut_plan_id'] = $cut_plan_id;

				$response['detail'] = $detail;

				$response['order_size_data'] = $order_size_data;

				return $response;

			} else {

				//update max id for line #

				$maxId = $this->get_max_id($cut_plan_id) + 1;

				for ($i = 0; $i < count($ratio); $i++) {

					$ratio[$i]['cut_plan_id'] = $cut_plan_id;

					$ratio[$i]['line_no'] = $maxId;

				}

				$this->db->where('cut_plan_id', $cut_plan_id);

				$this->db->update('cut_plan', $data);

				$detail = $this->save_cut_plan_detail($cut_plan_id, $ratio);

				$order_size_data = $this->get_product_size_data2($cut_plan_id, $prod_ord_detail_id);

				$response['messege'] = 'sucsess';

				$response['cut_plan_id'] = $cut_plan_id;

				$response['detail'] = $detail;

				$response['order_size_data'] = $order_size_data;

				return $response;

			}

		} catch (Exception $e) {

			return false;

		}

	}


	function load_save_cut_plan_detail($cp_id)
	{

		$this->db->select('*');

		$this->db->from('cut_plan_detail');

		$this->db->join('size', 'size.size_id = cut_plan_detail.size');

		$this->db->where('cut_plan_id', $cp_id);

		$query = $this->db->get();

		return $query->result_array();


	}


	function save_cut_plan_detail($cp_id, $data)
	{


		$this->db->insert_batch('cut_plan_detail', $data);


		$this->db->select('*');

		$this->db->from('cut_plan_detail');

		$this->db->join('size', 'size.size_id = cut_plan_detail.size');

		$this->db->where('cut_plan_id', $cp_id);

		$query = $this->db->get();

		return $query->result_array();

	}


	function get_max_id($cp_id)
	{

		$this->db->select_max('line_no');

		$this->db->where('cut_plan_id', $cp_id);

		$query = $this->db->get('cut_plan_detail')->row();

		return $query->line_no;

	}


	function get_updated_qty()
	{

		$this->db->select_max('line_no');

		$this->db->where('cut_plan_id', $cp_id);

		$query = $this->db->get('cut_plan_detail')->row();

		return $query->line_no;

	}


	public function get_laysheet()
	{

		$cut_plan = $this->input->post('cut_plan');

		$cut_no = $this->input->post('cut_no');


		$sql = "SELECT

cut_laysheet.laysheet_no

FROM `cut_laysheet`

WHERE

cut_laysheet.cut_plan_id = '" . $cut_plan . "' AND

cut_laysheet.cut_no = '" . $cut_no . "'

";

		$query = $this->db->query($sql);


		$result = $query->row_array();

		return $result['laysheet_no'];

		//     return $result = $query->row_array();

	}


	public function laysheetcont()
	{

		$cut_plan = $this->input->post('cut_plan');

		$cut_no = $this->input->post('cut_no');

		$query = $this->db->query("SELECT

count(cut_laysheet.laysheet_no) lay_count

FROM `cut_laysheet`

WHERE

cut_laysheet.cut_plan_id = '" . $cut_plan . "' AND

cut_laysheet.cut_no = '" . $cut_no . "'

");

		$result = $query->row_array();

		return $result['lay_count'];

	}


	public function create_lay_sheet()
	{

		$cut_plan = $this->input->post('cut_plan');

		$cut_no = $this->input->post('cut_no');

		$item_id = $this->input->post('item_id');

		$ord_id = $this->input->post('ord_id');

		$plies = $this->input->post('plies');

		$data = array(

			//'ord_no' => $this->input->post('ord_no'),

			'cut_plan_id' => $cut_plan,

			'cut_no' => $cut_no,

			'order_id' => $ord_id,

			'item_id' => $item_id,

			'lay_qty' => $plies,

			'printed_by' => $this->session->userdata('user_id')

			// 'created_by' => $this->session->userdata('user_id')

		);

		$this->db->insert('cut_laysheet', $data);

		$insert_id = $this->db->insert_id();

		$this->db->where('cut_plan_id', $cut_plan);

		$this->db->where('line_no', $cut_no);

		$this->db->update('cut_plan_detail', ['laysheet_no' => $insert_id]);


		return $insert_id;

	}

	public function cutplan_ratio($id)
	{

		$sql = "SELECT
cut_plan_detail.size,
cut_plan_detail.ratio,
size.size_code,
cut_plan_detail.qty
FROM
cut_plan_detail
INNER JOIN cut_laysheet ON cut_plan_detail.cut_plan_id = cut_laysheet.cut_plan_id AND cut_plan_detail.line_no = cut_laysheet.cut_no
INNER JOIN size ON cut_plan_detail.size = size.size_id
WHERE

cut_plan_detail.ratio > 0 AND

cut_laysheet.laysheet_no = '" . $id . "'";

		$query = $this->db->query($sql);

		return $query->result_array();


	}

	public function get_lay_sheet_data($id)
	{


		$sql = "SELECT
cut_laysheet.cut_plan_id,
cut_laysheet.cut_no,
cut_laysheet.lay_qty,
cut_laysheet.marker_length,
cut_laysheet.order_id,
cut_laysheet.item_id,
cut_laysheet.printed_date,
cut_laysheet.laysheet_no,
item.item_code,
item.item_description,
order_head.order_code,
order_head.style,
order_head.color,
order_head.customer_po,
order_head.uom,
order_head.customer,
style.style_code,
style.style_name,
color.color_code,
customer.id,
customer.cus_code,
customer.cus_name,
(SELECT
cut_plan_detail.marker_ref
from cut_plan_detail
WHERE
cut_plan_detail.laysheet_no = cut_laysheet.laysheet_no
LIMIT 1) as mark_ref
FROM
cut_laysheet
INNER JOIN item ON cut_laysheet.item_id = item.item_id
INNER JOIN order_head ON cut_laysheet.order_id = order_head.order_id
INNER JOIN style ON order_head.style = style.style_id
INNER JOIN color ON order_head.color = color.color_id
INNER JOIN customer ON order_head.customer = customer.id
WHERE
cut_laysheet.laysheet_no =" . $id . "";

//echo $sql;die();

		$query = $this->db->query($sql);

		return $query->row_array();

	}


	public function get_cut_plans($start, $limit, $search, $order)

	{

		$search_like = "'%" . $search . "%'";

		 $sql = "SELECT
cut_plan.cut_plan_id,
cut_plan.order_code,
cut_plan.style,
cut_plan.color,
cut_plan.cust_po,
cut_plan.ord_qty,
cut_plan.plan_qty,
cut_plan.uom,
cut_plan.item_code,
cut_plan.item_description,
cut_plan.date,
cut_plan.`user`,
cut_plan.create_date,
cut_plan.remarks,
cut_plan.country,
cut_plan.adviced_by,
cut_plan.site,
cut_plan.prod_ord_detail_id,
cut_plan.item_id,
cut_plan.cmp_id,
style.style_code,
color.color_code,
order_head.customer_po,
order_head.customer,
order_head.sales_qty
FROM
cut_plan
INNER JOIN style ON cut_plan.style = style.style_id
INNER JOIN color ON cut_plan.color = color.color_id
INNER JOIN order_head ON cut_plan.prod_ord_detail_id = order_head.order_id
WHERE
cut_plan.cut_plan_id LIKE " . $search_like . " OR
style.style_code LIKE " . $search_like . " OR
color.color_code LIKE " . $search_like . " OR
order_head.customer_po LIKE " . $search_like . " 
ORDER BY " . $order . "
 LIMIT " . $start . "," . $limit;

		$query = $this->db->query($sql);

		return $query->result_array();

	}


	public function get_cut_plans_count($search)

	{

		$search_like = "'%" . $search . "%'";

		$sql = "SELECT COUNT(cut_plan.cut_plan_id) AS row_count FROM cut_plan

    INNER JOIN style ON cut_plan.style = style.style_id

    INNER JOIN color ON cut_plan.color = color.color_id WHERE cut_plan.cut_plan_id LIKE " . $search_like . " OR

       style.style_code LIKE " . $search_like . " OR color.color_code LIKE " . $search_like;

		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result['row_count'];

	}


	public function get_cut_plan_size_count($cut_plan_id)

	{


		$sql = "SELECT DISTINCT cut_plan_detail.size FROM cut_plan_detail WHERE

           cut_plan_detail.cut_plan_id = " . $cut_plan_id . "";

		$query = $this->db->query($sql);

		$result = $query->num_rows();


		return $result;

	}


	public function get_cut_plan_size($cut_plan_id)

	{


		$sql = "SELECT DISTINCT size.size_code,size.size_id FROM cut_plan_detail 

           INNER JOIN size ON cut_plan_detail.size = size.size_id

           WHERE cut_plan_detail.cut_plan_id = " . $cut_plan_id . "";

		$query = $this->db->query($sql);

		$result = $query->result_array();


		return $result;

	}


	public function get_cut_plan_details($cut_plan_id, $sizes)

	{

		//echo json_encode( $sizes);

		$sql = " SELECT DISTINCT

              cut_plan_detail.line_no,

              cut_plan_detail.marker_ref,

              cut_plan_detail.plies,

              GROUP_CONCAT(cut_plan_detail.ratio) AS ratio

              FROM

                cut_plan_detail

              WHERE

                cut_plan_detail.cut_plan_id = " . $cut_plan_id . "

              GROUP BY

              cut_plan_detail.line_no";

		$query = $this->db->query($sql);


		$result['A'] = $query->result_array();

		return $result;

	}


	public function destroy($plan_id)

	{

		$sql1 = "DELETE FROM cut_laysheet WHERE cut_plan_id = ?";

		$this->db->query($sql1, [$plan_id]);


		$sql2 = "DELETE FROM cut_plan_detail WHERE cut_plan_id = ?";

		$this->db->query($sql2, [$plan_id]);


		$sql3 = "DELETE FROM cut_plan WHERE cut_plan_id = ?";

		$this->db->query($sql3, [$plan_id]);


		return true;

	}


	public function destroy_cp_detail_id($cp_detail_id)

	{

		$sql1 = "DELETE FROM cut_plan_detail WHERE detail_id = ?";

		$this->db->query($sql1, [$cp_detail_id]);

		return true;

	}


	public function can_delete_cut_plan($plan_id)
	{

		$sql = "SELECT laysheet_no FROM cut_laysheet WHERE cut_plan_id = ?";

		$query = $this->db->query($sql, [$plan_id]);

		$laysheets = $query->result_array();


		if (sizeof($laysheets) <= 0) {

			return true;

		} else {

			$laysheets_arr = [];

			foreach ($laysheets as $row) {

				array_push($laysheets_arr, $row['laysheet_no']);

			}


			$laysheets_str = implode(',', $laysheets_arr);

			$sql2 = "SELECT COUNT(*) AS row_count FROM cut_bundles WHERE laysheet_no IN (" . $laysheets_str . ")";

			$query2 = $this->db->query($sql2);

			$result = $query2->row_array();

			if ($result['row_count'] > 0) {

				return false;

			} else {

				return true;

			}

		}

	}


	public function can_delete_cut_plan_detail_line($cp_detail_id)
	{

		$sql = "SELECT

			cut_plan_detail.detail_id,
       cut_laysheet.laysheet_no
			FROM

			cut_laysheet

			INNER JOIN cut_plan_detail ON cut_laysheet.cut_plan_id = cut_plan_detail.cut_plan_id

			WHERE

			cut_plan_detail.detail_id = $cp_detail_id";
//echo $sql;
		$query = $this->db->query($sql, [$cp_detail_id]);

		$laysheets = $query->result_array();


		if (sizeof($laysheets) <= 0) {

			return true;

		} else {

			$laysheets_arr = [];

			foreach ($laysheets as $row) {
//echo $row['laysheet_no'];
				array_push($laysheets_arr, $row['laysheet_no']);

			}


			$laysheets_str = implode(',', $laysheets_arr);

			$sql2 = "SELECT COUNT(*) AS row_count FROM cut_bundles WHERE laysheet_no IN (" . $laysheets_str . ")";

			$query2 = $this->db->query($sql2);

			$result = $query2->row_array();

			if ($result['row_count'] > 0) {

				return false;

			} else {

				return true;

			}

		}

	}


}

