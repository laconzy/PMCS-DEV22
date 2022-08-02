<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartoon_qty_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_cartoon_qty($qty, $qty_id)
    {
		    $this->db->where('qty', $qty);
		    $this->db->where('qty_id !=', $qty_id);
		    $this->db->from('cartoon_qty');
		    return $this->db->count_all_results();
    }


    public function add_cartoon_qty($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('cartoon_qty', $data);
		    return $this->db->insert_id();
	}


  public function update_cartoon_qty($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('qty_id', $data['qty_id']);
	    $this->db->update('cartoon_qty', $data);
	    return true;
  }

	public function get_cartoon_qty($qty_id = 0)
	{
		$this->db->where('qty_id',$qty_id);
		$query = $this->db->get('cartoon_qty');
		return $query->row_array();
	}

	public function destroy($qty_id)
  {
		$this->db->where('qty_id', $qty_id);
		$this->db->update('cartoon_qty', array('active' => 'N'));
		return true;
  }

	public function get_cartoon_qtys($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT qty_id,qty,active FROM cartoon_qty WHERE qty_id LIKE ".$search_like." OR
				qty LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_cartoon_qty_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(qty_id) row_count FROM cartoon_qty WHERE qty_id LIKE ".$search_like." OR
				qty LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('qty_id as id,qty as text');
    $this->db->from('cartoon_qty');
    $this->db->like('qty', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


}
