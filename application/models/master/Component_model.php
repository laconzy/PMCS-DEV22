<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_component_from_code($component_code,$component_id)
    {
		    $this->db->where('com_code', $component_code);
		    $this->db->where('com_id !=', $component_id);
		    $this->db->from('component');
		    return $this->db->count_all_results();
    }


    public function add_component($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('component', $data);
		    return $this->db->insert_id();
	}


  public function update_component($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('com_id', $data['com_id']);
	    $this->db->update('component', $data);
	    return true;
  }

	public function get_component($component_id = 0)
	{
		$this->db->where('com_id',$component_id);
		$query = $this->db->get('component');
		return $query->row_array();
	}

	public function destroy($component_id)
  {
		$this->db->where('com_id', $component_id);
		$this->db->update('component', array('active' => 'N'));
		return true;
  }

	public function get_components($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT com_id,com_code,com_description,active FROM component WHERE com_id LIKE ".$search_like." OR
				com_code LIKE ".$search_like." OR com_description LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_components_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(com_id) row_count FROM component WHERE com_id LIKE ".$search_like." OR
				com_code LIKE ".$search_like." OR com_description LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}

  public function search($search)
  {
    $this->db->select('com_id as id,com_code as text');
    $this->db->from('component');
    $this->db->like('com_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }

}
