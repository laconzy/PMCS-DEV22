<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_departments_from_code($dep_name,$dep_id)
    {
		    $this->db->where('dep_name', $dep_name);
		    $this->db->where('dep_id !=', $dep_id);
		    $this->db->from('departments');
		    return $this->db->count_all_results();
    }


    public function add_department($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('departments', $data);
		    return $this->db->insert_id();
	}


  public function update_department($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('dep_id', $data['dep_id']);
	    $this->db->update('departments', $data);
	    return true;
  }

	public function get_department($dep_id = 0)
	{
		$this->db->where('dep_id',$dep_id);
		$query = $this->db->get('departments');
		return $query->row_array();
	}

	public function destroy($dep_id)
  {
		$this->db->where('dep_id', $dep_id);
		$this->db->update('departments', array('active' => 'N'));
		return true;
  }

	public function get_departments($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT dep_id,dep_name,active FROM departments WHERE dep_id LIKE ".$search_like." OR
				dep_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_departments_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(dep_id) row_count FROM departments WHERE dep_id LIKE ".$search_like." OR
				dep_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('dep_id as id,dep_name as text');
    $this->db->from('departments');
    $this->db->like('dep_name', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all(){
    $this->db->select('dep_id,dep_name');
    $this->db->from('departments');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_hod_list(){
    $sql = "SELECT user.id,user.first_name,user.last_name
    FROM hod
    INNER JOIN user ON user.id = hod.user_id
    WHERE hod.active = 'Y'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }


}
