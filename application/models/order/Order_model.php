<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Order_Model extends CI_Model
{


    public function __construct() {
        parent::__construct();
        $this->load->database();
    }



    public function create($data) {

      //date_default_timezone_set("Asia/Colombo");

      $cur_date = date("Y-m-d H:i:s");

      $data['created_by'] = $this->session->userdata('user_id');

      $data['updated_by'] = $this->session->userdata('user_id');

      $data['created_at'] = $cur_date;

      $data['updated_at'] = $cur_date;



      $this->db->insert('order_head',$data);

      return $this->db->insert_id();

    }



    public function update($data) {

        $data['updated_at'] = date("Y-m-d H:i:s");

        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('order_id', $data['order_id']);

        $this->db->update('order_head', $data);

        return $data['order_id'];

    }



    public function get($id){

      $this->db->select('order_head.*,style.style_code,style.style_name,

        color.color_code,color.color_name,

        customer.cus_code,customer.cus_name as customer_name,

        season.season_name,country.country_name'

      );

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('season','order_head.season = season.season_id');
      $this->db->join('country','order_head.country = country.country_id');

      $this->db->where('order_id',$id);

      $query = $this->db->get();

      return $query->row_array();

    }



    public function get_list($start,$limit,$search,$order,$complete_filter)

  	{

      $this->db->select('order_head.*,style.style_name,color.color_name,customer.cus_name,season.season_name,country.country_name');

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('country','order_head.country = country.country_id');

      $this->db->join('season','order_head.season = season.season_id');

      $like_fields = [

        'order_id' => $search,

        'order_code' => $search,

        'style_name' => $search,

        'color_name' => $search,

        'cus_name' => $search,

        'season_name' => $search

      ];

      if($complete_filter != ''){
        $this->db->where('is_complete', $complete_filter)->group_start()->or_like($like_fields)->group_end();
      }
      else {
        $this->db->or_like($like_fields);
      }

      $this->db->limit($limit, $start);
  		$query = $this->db->get();
  		return $query->result_array();

  	}



  	public function get_count($search, $complete_filter)

  	{

    //  $this->db->select('order_head.*,style.style_name,color.color_name,customer.cus_name,season.season_name,country.country_name');

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('country','order_head.country = country.country_id');

      $this->db->join('season','order_head.season = season.season_id');

      $like_fields = [

        'order_id' => $search,

        'order_code' => $search,

        'style_name' => $search,

        'color_name' => $search,

        'cus_name' => $search,

        'season_name' => $search

      ];

      if($complete_filter != ''){
        $this->db->where('is_complete', $complete_filter)->group_start()->or_like($like_fields)->group_end();
      }
      else {
        $this->db->or_like($like_fields);
      }

      $count = $this->db->count_all_results();
  		return $count;
  	}



    public function destroy($id) {

      $this->db->where('order_id', $id);

      $this->db->update('order_head', array('active' => 'N'));

      return true;

    }


    public function get_export_list($search,$complete_filter)	{

      $this->db->select('order_head.*,style.style_name,color.color_name,customer.cus_name,season.season_name,country.country_name');
      $this->db->from('order_head');
      $this->db->join('style','order_head.style = style.style_id');
      $this->db->join('color','order_head.color = color.color_id');
      $this->db->join('customer','order_head.customer = customer.id');
      $this->db->join('country','order_head.country = country.country_id');
      $this->db->join('season','order_head.season = season.season_id');

      $like_fields = [
        'order_id' => $search,
        'order_code' => $search,
        'style_name' => $search,
        'color_name' => $search,
        'cus_name' => $search,
        'season_name' => $search
      ];

      if($complete_filter != ''){
        $this->db->where('is_complete', $complete_filter)->group_start()->or_like($like_fields)->group_end();
      }
      else {
        $this->db->or_like($like_fields);
      }

  		$query = $this->db->get();
  		return $query->result_array();

  	}

    // ORDER RECONCILIATION REPORT -------------------------------------------------


    public function get_order_status_data($order_id) {


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
order_head.order_id = ".$order_id;

  $query = $this->db->query($sql1);
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


    public function complete_order($order_id){
      $cur_date = date("Y-m-d H:i:s");
      $user_id = $this->session->userdata('user_id');
      $this->db->where('order_id', $order_id);
      $this->db->update('order_head', array('is_complete' => 1, 'completed_at' => $cur_date, 'completed_by' => $user_id));
      return true;
    }

    public function complete_order_productions($order_id){
      $this->db->where('order_id', $order_id);
      $this->db->update('production', array('is_order_complete' => 1));
      return true;
    }

    public function not_complete_order($order_id){
      $cur_date = date("Y-m-d H:i:s");
      $user_id = $this->session->userdata('user_id');
      $this->db->where('order_id', $order_id);
      $this->db->update('order_head', array('is_complete' => 0, 'completed_at' => null, 'completed_by' => null));
      return true;
    }

    public function not_complete_order_productions($order_id){
      $this->db->where('order_id', $order_id);
      $this->db->update('production', array('is_order_complete' => 0));
      return true;
    }

    public function get_order_from_po_and_color($customer_po, $color){
      $this->db->where('customer_po', $customer_po);
      $this->db->where('color', $color);
      $this->db->where('active', 'Y');
      $this->db->from('order_head');
      $query = $this->db->get();
      return $query->result_array();
    }


    //order upload -------------------------------------------------------------

    public function get_style_from_code($code){
      $this->db->where('style_code', $code);
      $this->db->from('style');
      $query = $this->db->get();
      return $query->row_array();
    }

    public function get_color_from_code($code){
      $this->db->where('color_code', $code);
      $this->db->from('color');
      $query = $this->db->get();
      return $query->row_array();
    }

    public function get_country_from_code($code){
      $this->db->where('country_name', $code);
      $this->db->from('country');
      $query = $this->db->get();
      return $query->row_array();
    }


    public function get_season_from_code($code){
      $this->db->where('season_name', $code);
      $this->db->from('season');
      $query = $this->db->get();
      return $query->row_array();
    }

    public function get_customer_from_code($code){
      $this->db->where('cus_code', $code);
      $this->db->from('customer');
      $query = $this->db->get();
      return $query->row_array();
    }

    public function get_size_from_code($code){
      $this->db->where('size_code', $code);
      $this->db->from('size');
      $query = $this->db->get();
      return $query->row_array();
    }


    public function order_code_search($search)
    {
      $this->db->select('order_code as id,order_code as text');
      $this->db->from('order_head');
      $this->db->like('order_code', $search, 'after');
      $query = $this->db->get();
      return $query->result_array();
    }

}
