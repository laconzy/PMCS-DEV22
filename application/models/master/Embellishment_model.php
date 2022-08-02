<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Embellishment_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_embellishments_from_name($emb_name,$emb_id)
    {
		    $this->db->where('emb_name', $emb_name);
		    $this->db->where('emb_id !=', $emb_id);
		    $this->db->from('embellishment_type');
		    return $this->db->count_all_results();
    }


    public function add_embellishment($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('embellishment_type', $data);
		    return $this->db->insert_id();
	}


  public function update_embellishment($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('emb_id', $data['emb_id']);
	    $this->db->update('embellishment_type', $data);
	    return true;
  }

	public function get_embellishment($emb_id = 0)
	{
		$this->db->where('emb_id',$emb_id);
		$query = $this->db->get('embellishment_type');
		return $query->row_array();
	}

	public function destroy($emb_id)
  {
		$this->db->where('emb_id', $emb_id);
		$this->db->update('embellishment_type', array('active' => 'N'));
		return true;
  }

	public function get_embellishments($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT emb_id,emb_name,active FROM embellishment_type WHERE emb_id LIKE ".$search_like."
    OR emb_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_embellishments_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(emb_id) row_count FROM embellishment_type WHERE emb_id LIKE ".$search_like."
     OR emb_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function get_all(){
    $query = $this->db->get('embellishment_type');
    return $query->result_array();
  }

}
