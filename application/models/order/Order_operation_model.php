<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_Operation_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data) {
      try{
          $data['operation_order'] = $this->get_next_operation_order($data['order_id']);
          $this->db->insert('order_operations',$data);
          return true;
      } catch (Exception $ex) {
          return false;
      }
    }

    public function update($data) {
        /*$data['updated_at'] = date("Y-m-d H:i:s");
        $data['updated_by'] = $this->session->userdata('user_id');
        $this->db->where('order_id', $data['order_id']);
        $this->db->update('order_head', $data);
        return true;*/
    }

    public function get($order_id,$operation_id){
        $this->db->select('order_operations.*,operation.*');
        $this->db->from('order_operations');
        $this->db->join('operation','operation.operation_id = order_operations.operation');
        $this->db->where('order_operations.order_id',$order_id);
        $this->db->where('order_operations.operation',$operation_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_list($id)
  	{
      $this->db->select('order_operations.*,operation.*');
      $this->db->from('order_operations');
      $this->db->join('operation','order_operations.operation = operation.operation_id');
      $this->db->where('order_operations.order_id',$id);
      $query = $this->db->get();
      return $query->result_array();
  	}


    public function get_external_list($id)
  	{
      $this->db->select('order_operations.*,operation.*');
      $this->db->from('order_operations');
      $this->db->join('operation','order_operations.operation = operation.operation_id');
      $this->db->where('order_operations.order_id',$id);
      $this->db->where('operation.operation_type','EXTERNAL');
      $query = $this->db->get();
      return $query->result_array();
  	}


    public function destroy($order_id,$operation) {
      $this->db->where('order_id', $order_id);
      $this->db->where('operation', $operation);
      $this->db->delete('order_operations');
      return true;
    }

    private function get_next_operation_order($id){
      $this->db->select_max('operation_order');
      $this->db->where('order_id',$id);
      $max = $this->db->get('order_operations')->row_array();
      return $max['operation_order']+1;
    }


}
