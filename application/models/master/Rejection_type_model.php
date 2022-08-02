<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rejection_type_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_all()
    {
		    $query = $this->db->get('rejection_type');
		    return $query->result_array();
    }


    public function count_rejections_from_name($rej_name,$id)
    {
		    $this->db->where('rejection_name', $rej_name);
		    $this->db->where('id !=', $id);
		    $this->db->from('rejection_type');
		    return $this->db->count_all_results();
    }


    public function add_rejection($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('rejection_type', $data);
		    return $this->db->insert_id();
	}


  public function update_rejection($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('id', $data['id']);
	    $this->db->update('rejection_type', $data);
	    return true;
  }

	public function get_rejection($id = 0)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('rejection_type');
		return $query->row_array();
	}

	public function destroy($id)
  {
		$this->db->where('id', $id);
		$this->db->update('rejection_type', array('active' => 'N'));
		return true;
  }

	public function get_rejections($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT id,rejection_name,active FROM rejection_type WHERE id LIKE ".$search_like."
    OR rejection_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_rejections_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(id) row_count FROM rejection_type WHERE id LIKE ".$search_like."
     OR rejection_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


}
