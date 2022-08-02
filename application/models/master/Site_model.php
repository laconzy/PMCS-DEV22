<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_sites_from_code($site_code,$site_id)
    {
		$this->db->where('site_code', $site_code);
		$this->db->where('id !=', $site_id);
		$this->db->from('site');
		return $this->db->count_all_results();
    }


    public function add_site($data)
    {
		$current_timestamp = date("Y-m-d H:i:s");
		$current_user = $this->session->userdata('user_id');
		$data['created_at'] = $current_timestamp;
		$data['updated_at'] = $current_timestamp;
		$data['created_user'] = $current_user;
		$data['updated_user'] = $current_user;
		$this->db->insert('site', $data);
		return $this->db->insert_id();
	}


    public function update_site($data)
    {
		$data['updated_at'] = date("Y-m-d H:i:s");
		$data['updated_user'] = $this->session->userdata('user_id');
		$this->db->where('id', $data['id']);
		$this->db->update('site', $data);
		return true;
    }

	public function get_site($id = 0)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('site');
		return $query->row_array();
	}

	public function destroy($id)
    {
		$this->db->where('id', $id);
		$this->db->update('site', array('active' => 'N'));
		return true;
    }

	public function get_sites($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT id,site_code,site_name,city,state,country,active FROM site WHERE id LIKE ".$search_like." OR
				site_code LIKE ".$search_like." OR site_name LIKE ".$search_like." OR city LIKE ".$search_like." OR
				state LIKE ".$search_like." OR country LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_sites_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(id) row_count FROM site WHERE id LIKE ".$search_like." OR
				site_code LIKE ".$search_like." OR site_name LIKE ".$search_like." OR city LIKE ".$search_like." OR
				state LIKE ".$search_like." OR country LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}

  public function get_all(){
    $this->db->select('id,site_code,site_name');
    $this->db->from('site');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all_active(){
    $this->db->select('id,site_code,site_name');
    $this->db->from('site');
    $this->db->where('active', 'Y');
    $query = $this->db->get();
    return $query->result_array();
  }

}
