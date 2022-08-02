<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_supplier_from_code($supplier_code,$supplier_id)
    {
		    $this->db->where('supplier_code', $supplier_code);
		    $this->db->where('supplier_id !=', $supplier_id);
		    $this->db->from('supplier');
		    return $this->db->count_all_results();
    }


    public function create($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('supplier', $data);
		    return $this->db->insert_id();
	}


  public function update($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('supplier_id', $data['supplier_id']);
	    $this->db->update('supplier', $data);
	    return true;
  }

	public function get($supplier_id = 0)
	{
		$this->db->where('supplier_id',$supplier_id);
		$query = $this->db->get('supplier');
		return $query->row_array();
	}

	public function destroy($supplier_id)
  {
		$this->db->where('supplier_id', $supplier_id);
		$this->db->update('supplier', array('active' => 'N'));
		return true;
  }

	public function get_list($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT supplier_id,supplier_code,supplier_name,supplier_address,supplier_phone,active FROM supplier WHERE supplier_id LIKE ".$search_like." OR
				supplier_code LIKE ".$search_like." OR supplier_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_list_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(supplier_id) row_count FROM supplier WHERE supplier_id LIKE ".$search_like." OR
				supplier_code LIKE ".$search_like." OR supplier_name LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('style_id as id,style_code as text,style_name');
    $this->db->from('style');
    $this->db->like('style_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all(){
		$query = $this->db->get('supplier');
		return $query->result_array();
  }

}
