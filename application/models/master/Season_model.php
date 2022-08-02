<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_seasons_from_code($season_name,$season_id)
    {
		    $this->db->where('season_name', $season_name);
		    $this->db->where('season_id !=', $season_id);
		    $this->db->from('season');
		    return $this->db->count_all_results();
    }


    public function add_season($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('season', $data);
		    return $this->db->insert_id();
	}


  public function update_season($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('season_id', $data['season_id']);
	    $this->db->update('season', $data);
	    return true;
  }

	public function get_season($season_id = 0)
	{
		$this->db->where('season_id',$season_id);
		$query = $this->db->get('season');
		return $query->row_array();
	}

	public function destroy($season_id)
  {
		$this->db->where('season_id', $season_id);
		$this->db->update('season', array('active' => 'N'));
		return true;
  }

	public function get_seasons($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT season_id,season_name,active FROM season WHERE season_id LIKE ".$search_like."
    OR season_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_seasons_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(season_id) row_count FROM season WHERE season_id LIKE ".$search_like."
     OR season_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}

  public function get_all_seasons(){
    $query = $this->db->get('season');
    return $query->result_array();
  }

}
