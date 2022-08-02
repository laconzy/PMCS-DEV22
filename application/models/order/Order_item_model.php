<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_Item_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data,$components,$sizes) {
      try{
          $user = $this->session->userdata('user_id');
          $cur_date = date("Y-m-d H:i:s");
          date_default_timezone_set("Asia/Colombo");
          unset($data['order_item_id']);
          $data['created_by'] = $user;
          $data['updated_by'] = $user;
          $data['created_at'] = $cur_date;
          $data['updated_at'] = $cur_date;

          $this->db->insert('order_items',$data);
          $order_item_id = $this->db->insert_id();

          $this->save_order_item_components($order_item_id , $data['order_id'] , $components);

          $this->save_order_sizes($order_item_id , $data['order_id'] , $sizes);

          return $order_item_id;
      } catch (Exception $ex) {
          return false;
      }
    }

    public function update($data,$components,$sizes) {
        $this->delete_item_data($data['order_item_id']);
        $order_item_id = $this->create($data,$components,$sizes);
        return $order_item_id;
    }

    public function get($id){
      $sql = "SELECT order_items.*, item.item_code, item.item_description, color.color_code, color.color_name,
          (SELECT SUM(order_qty) FROM order_item_sizes WHERE order_item_sizes.order_item_id=order_items.id) AS order_qty,
          (SELECT SUM(planned_qty) FROM order_item_sizes WHERE order_item_sizes.order_item_id=order_items.id) AS planned_qty
          FROM order_items
          INNER JOIN item ON order_items.item = item.item_id
          INNER JOIN color ON order_items.item_color = color.color_id
          WHERE order_items.id = " . $id;
          $query = $this->db->query($sql);
          return $query->row_array();
      /*$this->db->select('order_items.*,item.item_code,item.item_description,color.color_code,color.color_name');
      $this->db->from('order_items');
      $this->db->join('item','order_items.item = item.item_id');
      $this->db->join('color','order_items.item_color = color.color_id');
      $this->db->where('id',$id);
      $query = $this->db->get();
      return $query->row_array();*/
    }

    public function get_list($id)
  	{
      $sql = "SELECT order_items.*, item.item_code, item.item_description, color.color_code, color.color_name,
          (SELECT SUM(order_qty) FROM order_item_sizes WHERE order_item_sizes.order_item_id=order_items.id) AS order_qty,
          (SELECT SUM(planned_qty) FROM order_item_sizes WHERE order_item_sizes.order_item_id=order_items.id) AS planned_qty
          FROM order_items
          INNER JOIN item ON order_items.item = item.item_id
          INNER JOIN color ON order_items.item_color = color.color_id
          WHERE order_items.order_id = " . $id;
      /*$this->db->select('order_items.*,item.item_code,item.item_description,color.color_code,color.color_name');
      $this->db->from('order_items');
      $this->db->join('item','order_items.item = item.item_id');
      $this->db->join('color','order_items.color = color.color_id');
      $this->db->where('order_id',$id);
      $query = $this->db->get();*/
      $query = $this->db->query($sql);
      return $query->result_array();
  	}

  	public function get_count($id)
  	{
      $this->db->select('order_items.*,item.item_code,item.item_description,color.color_code,color.color_name');
      $this->db->from('order_items');
      $this->db->join('item','order_items.item = item.item_id');
      $this->db->join('color','order_items.color = color.color_id');
      $this->db->where('order_id',$id);
      $query = $this->db->get();
  		$count = $this->db->count_all_results();
  		return $count;
  	}

    public function destroy($id) {
      $this->delete_item_data($id);
      return true;
    }


    public function get_components($id = 0)
  	{
      $this->db->select('order_item_components.*,component.com_code,component.com_description,color.color_code,color.color_name');
      $this->db->from('order_item_components');
      $this->db->join('component' , 'order_item_components.item_component = component.com_id');
      $this->db->join('color','order_item_components.component_color = color.color_id');
  		$this->db->where('order_item_components.order_item_id',$id);
  		$query = $this->db->get();
  		return $query->result_array();
  	}


    public function get_sizes($id = 0)
  	{
      $this->db->select('order_item_sizes.*,size.size_code,size.size_name');
      $this->db->from('order_item_sizes');
      $this->db->join('size' , 'order_item_sizes.size = size.size_id');
  		$this->db->where('order_item_sizes.order_item_id',$id);
      $this->db->order_by('size.size_id');
  		$query = $this->db->get();
  		return $query->result_array();
  	}



    //................ order item section ......................................

    private function save_order_item_components($order_item_id,$order_id,$data){
        try
        {
            for($x = 0 ; $x < sizeof($data) ; $x++){
              $db_data = array(
                  'order_item_id' => $order_item_id,
                  'order_id' => $order_id,
                  'item_component' => $data[$x]['component_id'],
                  'component_color' => $data[$x]['color_id']
              );
              $this->db->insert('order_item_components',$db_data);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    private function save_order_sizes($order_item_id,$order_id,$data){
        try
        {
            for($x = 0 ; $x < sizeof($data) ; $x++){
              $balance = $data[$x]['planned_qty'] - $data[$x]['order_qty'];

              $db_data = array(
                  'order_item_id' => $order_item_id,
                  'order_id' => $order_id,
                  'size' => $data[$x]['size_id'],
                  'order_qty' => $data[$x]['order_qty'],
                  'planned_qty' => $data[$x]['planned_qty'],
                  'balance' => $balance
              );
              $this->db->insert('order_item_sizes',$db_data);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }


    private function delete_item_data($order_item_id){
      //delete size details
      $this->db->where('order_item_id',$order_item_id);
      $this->db->delete('order_item_sizes');

      //delete component details
      $this->db->where('order_item_id',$order_item_id);
      $this->db->delete('order_item_components');

      $this->db->where('id',$order_item_id);
      $this->db->delete('order_items');
    }


}
