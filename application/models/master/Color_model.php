<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Color_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_colors_from_code($color_code,$color_id)
    {
		    $this->db->where('color_code', $color_code);
		    $this->db->where('color_id !=', $color_id);
		    $this->db->from('color');
		    return $this->db->count_all_results();
    }


    public function add_color($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('color', $data);
		    return $this->db->insert_id();
	}


  public function update_color($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('color_id', $data['color_id']);
	    $this->db->update('color', $data);
	    return true;
  }

	public function get_color($color_id = 0)
	{
		$this->db->where('color_id',$color_id);
		$query = $this->db->get('color');
		return $query->row_array();
	}

	public function destroy($color_id)
  {
		$this->db->where('color_id', $color_id);
		$this->db->update('color', array('active' => 'N'));
		return true;
  }

	public function get_colors($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT color_id,color_code,color_name,active FROM color WHERE color_id LIKE ".$search_like." OR
				color_code LIKE ".$search_like." OR color_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_colors_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(color_id) row_count FROM color WHERE color_id LIKE ".$search_like." OR
				color_code LIKE ".$search_like." OR color_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('color_id as id,color_code as text,color_name');
    $this->db->from('color');
    $this->db->like('color_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_all_active()
  {
    $this->db->from('color');
    $this->db->where('active', 'Y');
    $query = $this->db->get();
    return $query->result_array();
  }

}
