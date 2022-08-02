<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bundle_Model_4 extends CI_Model
{

	public function __construct()
	{

		parent::__construct();

		$this->load->database();
	}

	public function create($data)
	{

		$this->db->insert_batch('cut_bundles', $data);
	}

	public function destroy($laysheet_no, $bundle_no)
	{

		$this->db->where('laysheet_no', $laysheet_no);

		$this->db->where('bundle_no', $bundle_no);

		$this->db->delete('cut_bundles');

		return true;
	}


	public function destroy_all($laysheet_no)
	{

		$this->db->where('laysheet_no', $laysheet_no);

		$this->db->delete('cut_bundles');

		return true;
	}

	public function get_laysheet_details($laysheet)
	{

		$sql = "SELECT
cut_laysheet.laysheet_no,
cut_laysheet.cut_plan_id,
cut_laysheet.cut_no,
cut_laysheet.lay_qty,
cut_laysheet.marker_length,
cut_laysheet.order_id,
cut_laysheet.item_id,
cut_laysheet.printed_date,
cut_laysheet.printed_by,
order_head.order_code
 FROM
cut_laysheet
INNER JOIN order_head ON cut_laysheet.order_id = order_head.order_id
 WHERE
cut_laysheet.laysheet_no = " . $laysheet;
		$query = $this->db->query($sql);

		return $query->row_array();
	}


	public function get_barcode_details($id, $start)
	{

		$sql = "SELECT
fg_barcode_head.ord_id,
fg_barcode_head.created_by,
fg_barcode_head.created_date,
fg_barcode_head.id,
size.size_code,
color.color_code,
item.item_code,
barcode.barcode_no,
barcode.`no`,
barcode.printed_by,
barcode.printed_date,
order_head.order_code,
order_head.style,
order_head.customer_po,
style.style_code,
style.style_name,
fg_barcode.qty
FROM
fg_barcode_head
INNER JOIN fg_barcode ON fg_barcode_head.id = fg_barcode.id
INNER JOIN size ON fg_barcode.size_id = size.size_id
INNER JOIN color ON fg_barcode.color = color.color_id
INNER JOIN item ON fg_barcode.item_id = item.item_id
INNER JOIN barcode ON fg_barcode_head.id = barcode.id
INNER JOIN order_head ON fg_barcode.order_id = order_head.order_id
INNER JOIN style ON order_head.style = style.style_id
WHERE
 fg_barcode_head.id = $id AND
 barcode.`no` >= $start
";

		$query = $this->db->query($sql);


		return $query->result_array();
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

	public function get_cut_plan($cut_plan_id)
	{

		$sql = " SELECT cut_plan.*,style.style_code,color.color_code,item.item_code as item_name FROM cut_plan

           INNER JOIN style ON cut_plan.style = style.style_id

           INNER JOIN color ON cut_plan.color = color.color_id

           INNER JOIN item ON cut_plan.item_id = item.item_id

           WHERE cut_plan_id = ?";


		$query = $this->db->query($sql, [$cut_plan_id]);

		return $query->row_array();
	}

	public function get_cut_details_summery($laysheet)
	{
		$sql = "SELECT
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
order_item_sizes.size,
order_item_sizes.order_qty,
order_item_sizes.planned_qty,
order_item_sizes.balance,
size.size_code
FROM
order_head
INNER JOIN order_item_sizes ON order_head.order_id = order_item_sizes.order_id
INNER JOIN size ON order_item_sizes.size = size.size_id
WHERE
order_head.order_id = $laysheet
";
		$query = $this->db->query($sql, [$laysheet, $laysheet, $laysheet,$laysheet]);
		return $query->result_array();
	}

	public function get_order_item_details($laysheet)
	{

		$sql = "SELECT
 order_items.item,
order_items.item_color,
order_items.id,
order_items.order_id,
order_item_sizes.size,
order_item_sizes.order_qty,
order_item_sizes.planned_qty,
size.size_code,
color.color_code,
item.item_code
 FROM
 order_items
 INNER JOIN order_item_sizes ON order_items.order_id = order_item_sizes.order_id AND order_items.id = order_item_sizes.order_item_id
 INNER JOIN size ON order_item_sizes.size = size.size_id
 INNER JOIN color ON order_items.item_color = color.color_id
 INNER JOIN item ON order_items.item = item.item_id
 WHERE
	order_items.order_id = $laysheet";

		$query = $this->db->query($sql, [$laysheet, $laysheet, $laysheet]);

		return $query->result_array();
	}

	public function get_laysheet_size_details($laysheet)
	{

		$this->db->select('cut_plan_detail.*');

		$this->db->from('cut_plan_detail');

		$this->db->where('laysheet_no', $laysheet);

		$this->db->order_by('size', 'ASC');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_laysheet_max_bundle_no($laysheet_no,$order_id)
	{

		$this->db->select_max('bundle_no');

		$this->db->where('order_id', $order_id);

		$query = $this->db->get('cut_bundles');

		$data = $query->row_array();

		if ($data['bundle_no'] == null || $data['bundle_no'] == false)
			return 1;
		else
			return ($data['bundle_no'] + 1);
	}

	public function get_laysheet_max_bundle_qty($laysheet_no,$cut_plan_no)
	{

		 $sql = "SELECT
cut_laysheet.cut_plan_id,
Max(cut_bundles.`end`) end,
Max(cut_bundles.`start`) start
FROM
cut_bundles
INNER JOIN cut_laysheet ON cut_bundles.laysheet_no = cut_laysheet.laysheet_no
WHERE
cut_laysheet.cut_plan_id = $cut_plan_no
GROUP BY
cut_laysheet.cut_plan_id";

		$query = $this->db->query($sql);

		$data= $query->row_array();

		if ($data['start'] == null || $data['start'] == false)
			return 1;
		else
			return ($data['end'] + 1);
	}
public function get_max_letter($cut_no,$order_id){
	$sql = "SELECT
IFNULL(Max(cut_bundles.letter),0) letter
FROM `cut_bundles`
WHERE
cut_bundles.order_id = $order_id AND
cut_bundles.cut_no = $cut_no
";

	$query = $this->db->query($sql);

	return $query->row_array();
}
	public function get_laysheet_remaning_qty($laysheet_no)
	{

		$sql = ' select cut_plan_detail.size,cut_plan_detail.qty,

        (cut_plan_detail.qty - IFNULL(SUM(cut_bundles.qty),0)) as remaning_qty

         from cut_plan_detail

         left join cut_bundles on cut_plan_detail.laysheet_no=cut_bundles.laysheet_no and cut_plan_detail.size=cut_bundles.size

         where cut_plan_detail.laysheet_no = ? group by cut_plan_detail.size';

		$query = $this->db->query($sql, [$laysheet_no]);

		$result = $query->result_array();

		$data = [];

		foreach ($result as $row) {

			$data[$row['size']] = $row['remaning_qty'];
		}


		return $data;
	}

	public function get_bundle_chart($laysheet)
	{

		$this->db->select('`cut_bundles`.*, `size`.`size_code` size_code');

		$this->db->join('size', 'size.size_id = cut_bundles.size');

		$this->db->from('cut_bundles');

		$this->db->where('cut_bundles.laysheet_no', $laysheet);
		$this->db->order_by('cut_bundles.bundle_no ASC,size.seq ASC');
		$query = $this->db->get();
//echo $this->db->last_query();
		return $query->result_array();
	}

	public function save_fg_barcode($ord_id)
	{
		$ord_id = $this->input->post('ord_id');
		$data = array(
			'ord_id' => $ord_id,
			'created_by' => $this->session->userdata('user_id')
		);
		$this->db->insert('fg_barcode_head', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function save_fg_barcode_detail($id)
	{
		$ord_id = $this->input->post('ord_id');
		$items = $this->input->post('items');

		$arr = array();
		foreach ($items as $key => $value) {
			$items[$key]['id'] = $id;
		}


		$this->db->insert_batch('fg_barcode', $items);
		$sql = " SELECT
 fg_barcode_head.id,
 fg_barcode_head.ord_id,
 fg_barcode_head.created_by,
 fg_barcode_head.created_date,
 `user`.first_name
 FROM
 fg_barcode_head
 INNER JOIN `user` ON fg_barcode_head.created_by = `user`.id
 WHERE
 fg_barcode_head.ord_id =$ord_id ";
		$query = $this->db->query($sql);
		return $query->result_array();

	}

	public function size_data_for_bundle_chart($laysheet)
	{

		$sql = "SELECT
	CONCAT(size.size_code,\"(\",cut_bundles.diff,\")\") size,
		cut_bundles.diff,
		size.size_code,
		cut_bundles.size size_id,
cut_bundles.letter
		FROM
		cut_bundles
		INNER JOIN size ON cut_bundles.size = size.size_id
		WHERE
		cut_bundles.laysheet_no = $laysheet
		GROUP BY
		cut_bundles.size,
		cut_bundles.diff
ORDER BY
size.seq ASC,
cut_bundles.diff ASC

		";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_bundle_data($laysheet, $size, $diff)
	{
		$sql = "SELECT
cut_bundles.qty,
cut_bundles.plies_count,
cut_bundles.diff,
cut_bundles.`start`,
cut_bundles.`end`,
cut_bundles.barcode,
cut_bundles.bundle_no
FROM `cut_bundles`
WHERE
cut_bundles.laysheet_no = $laysheet AND
cut_bundles.size = $size AND
cut_bundles.diff = $diff";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_saved_details($ord_id)
	{
		$sql = "SELECT
 fg_barcode_head.id,
fg_barcode_head.ord_id,
fg_barcode_head.created_by,
fg_barcode_head.created_date,
`user`.first_name
 FROM
 fg_barcode_head
 INNER JOIN `user` ON fg_barcode_head.created_by = `user`.id
 WHERE
 fg_barcode_head.ord_id =$ord_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function print_data($bundle_no, $qty)
	{

		$sql = "SELECT
 IFNULL(max(no),0) maxno
 FROM `barcode`
 WHERE
 barcode.id =" . $bundle_no . "";
		$query = $this->db->query($sql);
		$result = $query->row_array();

		$start = $result['maxno'] + 1;
		$end = $qty + $start;


		for ($index = $start; $index < $end; $index++) {
			$data = [
				'id' => $bundle_no,
				'barcode_no' => 'M' . $bundle_no . $index,
				'printed_by' => $this->session->userdata('user_id'),
				'no' => $index
			];
			$this->db->insert('barcode', $data);
		}
		return $start;
	}

	public function get_order_details($laysheet)
	{

		$sql = "SELECT
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
order_head.season,
order_head.site,
order_head.created_at,
order_head.created_by,
order_head.updated_at,
order_head.updated_by,
order_head.active,
order_head.smv,
customer.cus_code,
customer.cus_name,
style.style_code,
style.style_name,
color.color_code,
color.color_name
 FROM
 order_head
 INNER JOIN customer ON order_head.customer = customer.id
 INNER JOIN style ON order_head.style = style.style_id
 INNER JOIN color ON order_head.color = color.color_id
 WHERE
 order_head.order_id = " . $laysheet . "";
		$query = $this->db->query($sql);


		return $query->row_array();
	}

	public function get_bundle($laysheet, $bundle_no){
		$this->db->from('cut_bundles');
		$this->db->where('cut_bundles.laysheet_no', $laysheet);
		$this->db->where('cut_bundles.bundle_no', $bundle_no);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function can_delete_bundle($barcode){
		$this->db->from('production');
		$this->db->where('production.barcode', $barcode);
		$query = $this->db->get();
		$result = $query->result_array();
		if($result != null && sizeof($result) > 0){
			return false;
		}
		else{
			return true;
		}
	}


	public function can_delete_all_bundles($laysheet){
		$sql = "SELECT production.* FROM production WHERE production.barcode IN (
			SELECT cut_bundles.barcode FROM cut_bundles WHERE cut_bundles.laysheet_no = ".$laysheet."
		)";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if($result != null && sizeof($result) > 0){
			return false;
		}
		else{
			return true;
		}
	}


}



//

//

//

//


//}
