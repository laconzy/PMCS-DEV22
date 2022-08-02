<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Size_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_sizes_from_code($size_code,$size_id)
    {
		    $this->db->where('size_code', $size_code);
		    $this->db->where('size_id !=', $size_id);
		    $this->db->from('size');
		    return $this->db->count_all_results();
    }


    public function add_size($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('size', $data);
		    return $this->db->insert_id();
	}


  public function update_size($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('size_id', $data['size_id']);
	    $this->db->update('size', $data);
	    return true;
  }

	public function get_size($size_id = 0)
	{
		$this->db->where('size_id',$size_id);
		$query = $this->db->get('size');
		return $query->row_array();
	}

	public function destroy($size_id)
  {
		$this->db->where('size_id', $size_id);
		$this->db->update('size', array('active' => 'N'));
		return true;
  }

	public function get_sizes($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT size_id,size_code,size_name,active FROM size WHERE size_id LIKE ".$search_like." OR
				size_code LIKE ".$search_like." OR size_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_sizes_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(size_id) row_count FROM size WHERE size_id LIKE ".$search_like." OR
				size_code LIKE ".$search_like." OR size_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}

  public function search($search)
  {
    $this->db->select('size_id as id,size_code as text,size_name');
    $this->db->from('size');
    $this->db->like('size_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all_active()
  {
    $this->db->from('size');
    $this->db->where('active', 'Y');
    $query = $this->db->get();
    return $query->result_array();
  }

}
