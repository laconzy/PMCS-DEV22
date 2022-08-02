<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_designation_from_code($des_name,$des_id)
    {
		    $this->db->where('designation', $des_name);
		    $this->db->where('des_id !=', $des_id);
		    $this->db->from('pmcs_designation');
		    return $this->db->count_all_results();
    }


    public function add_designation($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('pmcs_designation', $data);
		    return $this->db->insert_id();
	}


  public function update_designation($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('des_id', $data['des_id']);
	    $this->db->update('pmcs_designation', $data);
	    return true;
  }

	public function get_designation($des_id = 0)
	{
		$this->db->where('des_id',$des_id);
		$query = $this->db->get('pmcs_designation');
		return $query->row_array();
	}

	public function destroy($des_id)
  {
		$this->db->where('des_id', $des_id);
		$this->db->update('pmcs_designation', array('active' => 'N'));
		return true;
  }

	public function get_designations($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT des_id,designation,active FROM pmcs_designation WHERE des_id LIKE ".$search_like." OR
				designation LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_designations_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(des_id) row_count FROM pmcs_designation WHERE des_id LIKE ".$search_like." OR
				designation LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('des_id as id,designation as text');
    $this->db->from('pmcs_designation');
    $this->db->like('designation', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all(){
    $this->db->select('des_id,designation');
    $this->db->from('pmcs_designation');
    $query = $this->db->get();
    return $query->result_array();
  }


}
