<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Line_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function count_lines_from_code($line_code,$line_id) {
		    $this->db->where('line_code', $line_code);
		    $this->db->where('line_id !=', $line_id);
		    $this->db->from('line');
		    return $this->db->count_all_results();
    }

    public function add_line($data) {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('line', $data);
		    return $this->db->insert_id();
	}

  public function update_line($data) {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('line_id', $data['line_id']);
	    $this->db->update('line', $data);
	    return true;
  }

	public function get_line($line_id = 0) {
		$this->db->where('line_id',$line_id);
		$query = $this->db->get('line');
		return $query->row_array();
	}


	public function destroy($line_id) {
		$this->db->where('line_id', $line_id);
		$this->db->update('line', array('active' => 'N'));
		return true;
  }


	public function get_lines($start,$limit,$search,$order) {
		$search_like = "'%".$search."%'";
		$sql = "SELECT line.*,site.site_code FROM line
    LEFT JOIN site ON site.id = line.location
    WHERE line_id LIKE ".$search_like." OR
				line_code LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function get_lines_count($search){
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(line_id) row_count FROM line WHERE line_id LIKE ".$search_like." OR
				line_code LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search) {
    $this->db->select('line_id as id,line_code as text');
    $this->db->from('line');
    $this->db->like('line_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all(){
    $this->db->where('active','Y');
    $query = $this->db->get('line');
    return $query->result_array();
  }


  public function site(){
		$sql = "SELECT
				site.site_code,
				site.id,
				site.site_name,
				site.description
				FROM `site`
				WHERE
				site.active = 'Y'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


  public function get_all_by_site($site_id){
    $this->db->where('active','Y');
    $this->db->where('location',$site_id);
    $query = $this->db->get('line');
    return $query->result_array();
  }

}
