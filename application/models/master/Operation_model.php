<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Operation_Model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }





    public function count_operations_from_code($operation_name,$operation_id)

    {

		    $this->db->where('operation_name', $operation_name);

		    $this->db->where('operation_id !=', $operation_id);

		    $this->db->from('operation');

		    return $this->db->count_all_results();

    }





    public function add_operation($data)

    {

		    $current_timestamp = date("Y-m-d H:i:s");

		    $current_user = $this->session->userdata('user_id');

		    $data['created_at'] = $current_timestamp;

		    $data['updated_at'] = $current_timestamp;

		    $data['created_user'] = $current_user;

		    $data['updated_user'] = $current_user;

		    $this->db->insert('operation', $data);

		    return $this->db->insert_id();

	}





  public function update_operation($data)

  {

	    $data['updated_at'] = date("Y-m-d H:i:s");

	    $data['updated_user'] = $this->session->userdata('user_id');

	    $this->db->where('operation_id', $data['operation_id']);

	    $this->db->update('operation', $data);

	    return true;

  }



	public function get_operation($operation_id = 0)

	{

		$this->db->where('operation_id',$operation_id);

		$query = $this->db->get('operation');

		return $query->row_array();

	}



	public function destroy($operation_id)

  {

		$this->db->where('operation_id', $operation_id);

		$this->db->update('operation', array('active' => 'N'));

		return true;

  }



	public function get_operations($start,$limit,$search,$order)

	{

		$search_like = "'%".$search."%'";

		$sql = "SELECT operation_id,operation_name,active FROM operation WHERE operation_id LIKE ".$search_like."

    OR operation_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;

		$query = $this->db->query($sql);

		return $query->result_array();

	}



	public function get_operations_count($search)

	{

		$search_like = "'%".$search."%'";

		$sql = "SELECT COUNT(operation_id) row_count FROM operation WHERE operation_id LIKE ".$search_like."

     OR operation_name LIKE ".$search_like;

		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result['row_count'];

	}





  public function get_all(){

	  		$this->db->order_by("seq","ASC");

    $query = $this->db->get('operation');

    return $query->result_array();

  }



}

