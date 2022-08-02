<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_item_from_code($item_code,$item_id)
    {
		    $this->db->where('item_code', $item_code);
		    $this->db->where('item_id !=', $item_id);
		    $this->db->from('item');
		    return $this->db->count_all_results();
    }


    public function add_item($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('item', $data);
		    return $this->db->insert_id();
	}


  public function update_item($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('item_id', $data['item_id']);
	    $this->db->update('item', $data);
	    return true;
  }

	public function get_item($item_id = 0)
	{
		$this->db->where('item_id',$item_id);
		$query = $this->db->get('item');
		return $query->row_array();
	}

	public function delete_item($item_id)
  {
		$this->db->where('item_id', $item_id);
		$this->db->update('item', array('active' => 'N'));
		return true;
  }

	public function get_items($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT item_id,item_code,item_description,active FROM item WHERE item_id LIKE ".$search_like." OR
				item_code LIKE ".$search_like." OR item_description LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_items_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(item_id) row_count FROM item WHERE item_id LIKE ".$search_like." OR
				item_code LIKE ".$search_like." OR item_description LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}

  //Item components...............................................................

  public function add_item_component($data){
    $this->db->insert('item_components', $data);
    return true;
  }

  public function delete_item_component($data){
    $this->db->where($data);
    $this->db->delete('item_components');
    return true;
  }

  public function get_item_components($item_id){
    $this->db->select('item_components.*,component.com_code,component.com_description');
    $this->db->from('item_components');
    $this->db->join('component' , 'component.com_id = item_components.component_id');
    $this->db->where('item_components.item_id', $item_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function search($search)
  {
    $this->db->select('item_id as id,item_code as text,item_description');
    $this->db->from('item');
    $this->db->like('item_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_all(){
    $this->db->from('item');
    $query = $this->db->get();
    return $query->result_array();
  }


}
