<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function create($data , $details) {
      $cur_date = date("Y-m-d H:i:s");
      $data['created_by'] = $this->session->userdata('user_id');
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['created_at'] = $cur_date;
      $data['updated_at'] = $cur_date;

      $this->db->insert('contract_header',$data);
      $contract_no = $this->db->insert_id();

      for($x = 0 ; $x < sizeof($details) ; $x++){
        $details[$x]['contract_no'] = $contract_no;
      }
      $this->db->insert_batch('contract_details', $details);
      return $contract_no;
    }


    public function get_list($start,$limit,$search,$order)
    {
      $search_like = "'%".$search."%'";
      $sql = "SELECT contract_header.*,operation.operation_name,supplier.supplier_name,component.com_code,embellishment_type.emb_name FROM contract_header
            INNER JOIN operation ON operation.operation_id = contract_header.operation
            INNER JOIN supplier ON supplier.supplier_id = contract_header.supplier
            INNER JOIN component ON component.com_id = contract_header.item_component
            INNER JOIN embellishment_type ON embellishment_type.emb_id = contract_header.emb_type WHERE contract_no LIKE ".$search_like." OR
          order_id LIKE ".$search_like." OR supplier_po LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function get_list_count($search)
    {
      $search_like = "'%".$search."%'";
      $sql = "SELECT COUNT(contract_no) AS row_count FROM contract_header
            INNER JOIN operation ON operation.operation_id = contract_header.operation
            INNER JOIN supplier ON supplier.supplier_id = contract_header.supplier
            INNER JOIN component ON component.com_id = contract_header.item_component
            INNER JOIN embellishment_type ON embellishment_type.emb_id = contract_header.emb_type WHERE contract_no LIKE ".$search_like." OR
          order_id LIKE ".$search_like." OR supplier_po LIKE ".$search_like;
      $query = $this->db->query($sql);
      $result = $query->row_array();
      return $result['row_count'];
    }

    /*public function destroy($order_id,$operation_id,$operation_point,$barcode) {
      $this->db->where('order_id', $order_id);
      $this->db->where('operation', $operation_id);
      $this->db->where('operation_point', $operation_point);
      $this->db->where('barcode', $barcode);
      $this->db->delete('production');
      return true;
    }*/



    public function get_order_item_components($order_id){
      $sql = "SELECT DISTINCT order_item_components.item_component,component.com_code,component.com_description FROM order_item_components
        INNER JOIN component ON order_item_components.item_component = component.com_id
        WHERE order_item_components.order_id = ?";
      $query = $this->db->query($sql , [$order_id]);
      return $query->result_array();
    }


    public function get_emb_types(){
      $query = $this->db->get('embellishment_type');
      return $query->result_array();
    }

    public function get_order_size_wise_summery($order_id){
      $sql = "SELECT order_item_sizes.*,SUM(order_item_sizes.planned_qty) As total,item.item_id,item.item_code,color.color_id,color.color_code,size.size_code FROM order_item_sizes
          INNER JOIN order_items ON order_items.id = order_item_sizes.order_item_id
          INNER JOIN item ON order_items.item = item.item_id
          INNER JOIN color ON order_items.item_color = color.color_id
          INNER JOIN size ON order_item_sizes.size = size.size_id
          WHERE order_item_sizes.order_id = ? group by order_item_sizes.size";
      $query = $this->db->query($sql , [$order_id]);
      return $query->result_array();
    }

    public function get_order_contracts($order_id = 0){
      $this->db->where('order_id' , $order_id);
      $query = $this->db->get('contract_header');
      return $query->result_array();
    }


    public function get($contract_no){
      $this->db->select('contract_header.*,operation.operation_name,supplier.supplier_name,embellishment_type.emb_name,component.com_code');
      $this->db->join('operation','contract_header.operation=operation.operation_id');
      $this->db->join('supplier','contract_header.supplier=supplier.supplier_id');
      $this->db->join('component','contract_header.item_component=component.com_id');
      $this->db->join('embellishment_type','contract_header.emb_type=embellishment_type.emb_id');
      $this->db->where('contract_header.contract_no' , $contract_no);
      $query = $this->db->get('contract_header');
      return $query->row_array();
    }


    public function get_contract_item_details($order_id,$contract_no){
      $sql = "SELECT order_item_sizes.*,SUM(order_item_sizes.planned_qty) As total,
      item.item_id,
      item.item_code,
      color.color_id,
      color.color_code,
      size.size_code,
      (SELECT contract_qty FROM contract_details where contract_no = ? AND size = order_item_sizes.size) as contract_qty
      FROM order_item_sizes
          INNER JOIN order_items ON order_items.id = order_item_sizes.order_item_id
          INNER JOIN item ON order_items.item = item.item_id
          INNER JOIN color ON order_items.item_color = color.color_id
          INNER JOIN size ON order_item_sizes.size = size.size_id
          WHERE order_item_sizes.order_id = ? group by order_item_sizes.size";
      $query = $this->db->query($sql , [$contract_no , $order_id]);
      return $query->result_array();
    }


}
