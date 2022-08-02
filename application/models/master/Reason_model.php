<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reason_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    // public function count_colors_from_code($color_code,$color_id)
    // {
		//     $this->db->where('color_code', $color_code);
		//     $this->db->where('color_id !=', $color_id);
		//     $this->db->from('color');
		//     return $this->db->count_all_results();
    // }


    public function add_reason($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('reason', $data);
		    return $this->db->insert_id();
	}


  public function update_reason($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('reason_id', $data['reason_id']);
	    $this->db->update('reason', $data);
	    return true;
  }

	public function get_reason($reason_id = 0)
	{
		$this->db->where('reason_id',$reason_id);
		$query = $this->db->get('reason');
		return $query->row_array();
	}

	public function destroy($reason_id)
  {
		$this->db->where('reason_id', $reason_id);
		$this->db->update('reason', array('active' => 'N'));
		return true;
  }

	public function get_reasons($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT reason_id,category,reason_text,active FROM reason WHERE reason_id LIKE ".$search_like." OR
				category LIKE ".$search_like." OR reason_text LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_reasons_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(reason_id) row_count FROM reason WHERE reason_id LIKE ".$search_like." OR
				category LIKE ".$search_like." OR reason_text LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('reason_id as id,reason_text as text,category');
    $this->db->from('reason');
    $this->db->like('reason_name', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all_categories(){
    $this->db->from('reason_category');
    $query = $this->db->get();
    return $query->result_array();
  }

}
