<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_customer_from_code($cus_code,$cus_id)
    {
		$this->db->where('cus_code', $cus_code);
		$this->db->where('id !=', $cus_id);
		$this->db->from('customer');
		return $this->db->count_all_results();
    }


    public function add_customer($data)
    {
		$current_timestamp = date("Y-m-d H:i:s");
		$current_user = $this->session->userdata('user_id');
		$data['created_at'] = $current_timestamp;
		$data['updated_at'] = $current_timestamp;
		$data['created_user'] = $current_user;
		$data['updated_user'] = $current_user;
		$this->db->insert('customer', $data);
		return $this->db->insert_id();
	}


    public function update_customer($data)
    {
		$data['updated_at'] = date("Y-m-d H:i:s");
		$data['updated_user'] = $this->session->userdata('user_id');
		$this->db->where('id', $data['id']);
		$this->db->update('customer', $data);
		return true;
    }

	public function get_customer($id = 0)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('customer');
		return $query->row_array();
	}

	public function destroy($id)
    {
		$this->db->where('id', $id);
		$this->db->update('customer', array('active' => 'N'));
		return true;
    }

	public function get_customers($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT id,cus_code,cus_name,city,state,country,active,email FROM customer WHERE id LIKE ".$search_like." OR
				cus_code LIKE ".$search_like." OR cus_name LIKE ".$search_like." OR city LIKE ".$search_like." OR
				state LIKE ".$search_like." OR country LIKE ".$search_like." OR email LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_customers_count($search)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT COUNT(id) row_count FROM customer WHERE id LIKE ".$search_like." OR
				cus_code LIKE ".$search_like." OR cus_name LIKE ".$search_like." OR city LIKE ".$search_like." OR
				state LIKE ".$search_like." OR country LIKE ".$search_like." OR email LIKE ".$search_like;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('id as id,cus_code as text,cus_name');
    $this->db->from('customer');
    $this->db->like('cus_code', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all(){
    $query = $this->db->get('customer');
    return $query->result_array();
  }

}
