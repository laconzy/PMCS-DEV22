<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hod_Allocation_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_allocation_from_site_and_department($site_id, $department_id)
    {
		    $this->db->where('site_id', $site_id);
		    $this->db->where('department_id', $department_id);
		    $this->db->from('hod_allocation');
		    $query = $this->db->get();
        return $query->row_array();
    }


    public function add_allocation($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('hod_allocation', $data);
		    return $this->db->insert_id();
	}


  public function update_allocation($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('id', $data['id']);
	    $this->db->update('hod_allocation', $data);
	    return true;
  }

	public function get_allocation($id = 0)
	{
    $this->db->select('hod_allocation.*, user.first_name, user.last_name');
		$this->db->where('hod_allocation.id',$id);
    $this->db->join('user', 'user.id = hod_allocation.user_id');
		$query = $this->db->get('hod_allocation');
		return $query->row_array();
	}

	public function destroy($id)
  {
		$this->db->where('id', $id);
		$this->db->update('hod_allocation', array('active' => 'N'));
		return true;
  }

	public function get_allocations($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT hod_allocation.*,site.site_code,site.site_name,departments.dep_name, user.first_name,user.last_name
    FROM hod_allocation
    INNER JOIN site ON site.id = hod_allocation.site_id
    INNER JOIN departments ON departments.dep_id = hod_allocation.department_id
    INNER JOIN user ON user.id = hod_allocation.user_id
    WHERE hod_allocation.id LIKE ".$search_like." OR site.site_code LIKE ".$search_like." OR departments.dep_name LIKE ".$search_like."
    OR user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_allocations_count($search)
	{
		$search_like = "'%".$search."%'";
    $sql = "SELECT COUNT(hod_allocation.id) row_count
    FROM hod_allocation
    INNER JOIN site ON site.id = hod_allocation.site_id
    INNER JOIN departments ON departments.dep_id = hod_allocation.department_id
    INNER JOIN user ON user.id = hod_allocation.user_id
    WHERE hod_allocation.id LIKE ".$search_like." OR site.site_code LIKE ".$search_like." OR departments.dep_name LIKE ".$search_like."
    OR user.first_name LIKE ".$search_like." OR user.last_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


}
