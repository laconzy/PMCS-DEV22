<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Style_Model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }





    public function count_styles_from_code($style_code,$style_id)

    {

		    $this->db->where('style_code', $style_code);

		    $this->db->where('style_id !=', $style_id);

		    $this->db->from('style');

		    return $this->db->count_all_results();

    }





    public function add_style($data)

    {

		    $current_timestamp = date("Y-m-d H:i:s");

		    $current_user = $this->session->userdata('user_id');

		    $data['created_at'] = $current_timestamp;

		    $data['updated_at'] = $current_timestamp;

		    $data['created_user'] = $current_user;

		    $data['updated_user'] = $current_user;

		    $this->db->insert('style', $data);

		    return $this->db->insert_id();

	}





  public function update_style($data)

  {

	    $data['updated_at'] = date("Y-m-d H:i:s");

	    $data['updated_user'] = $this->session->userdata('user_id');

	    $this->db->where('style_id', $data['style_id']);

	    $this->db->update('style', $data);

	    return true;

  }



	public function get_style($style_id = 0)

	{

		$this->db->where('style_id',$style_id);

		$query = $this->db->get('style');

		return $query->row_array();

	}

	public function get_style_cat()

	{

		//$this->db->where('style_id',$style_id);

		$query = $this->db->get('style_cat');

		$r= $query->result_array();
//print_r($r);
		 return($r);

	}



	public function destroy($style_id)

  {

		$this->db->where('style_id', $style_id);

		$this->db->update('style', array('active' => 'N'));

		return true;

  }



	public function get_styles($start,$limit,$search,$order)

	{

		$search_like = "'%".$search."%'";

		$sql = "SELECT style_id,style_code,style_name,active FROM style WHERE style_id LIKE ".$search_like." OR

				style_code LIKE ".$search_like." OR style_name LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;

		$query = $this->db->query($sql);

		return $query->result_array();

	}



	public function get_styles_count($search)

	{

		$search_like = "'%".$search."%'";

		$sql = "SELECT COUNT(style_id) row_count FROM style WHERE style_id LIKE ".$search_like." OR

				style_code LIKE ".$search_like." OR style_name LIKE ".$search_like;

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
    $query = $this->db->get('style');
    return $query->result_array();
  }

  public function get_all_active(){
    $this->db->where('active', 'Y');
    $query = $this->db->get('style');
    return $query->result_array();
  }


  //manage style operations-------------------------------------------------

  public function is_operation_already_added($style_id, $operation){
    $sql = "SELECT * FROM style_operations WHERE style_id = ".$style_id." AND operation_id = ".$operation;
    $query = $this->db->query($sql);
    $data = $query->result_array();
    if($data == null || sizeof($data) <= 0){
      return false;
    }
    else {
      return true;
    }
  }


  public function add_style_operation($style_id, $operation)
  {
      $current_timestamp = date("Y-m-d H:i:s");
      $current_user = $this->session->userdata('user_id');
      $data['created_at'] = $current_timestamp;
      $data['created_user'] = $current_user;
      $data['style_id'] = $style_id;
      $data['operation_id'] = $operation;
      $data['operation_order'] = $this->get_next_operation_order($style_id);
      $this->db->insert('style_operations', $data);
  }

  public function get_style_operations($style_id){
      $sql = "SELECT style_operations.*, operation.operation_name
      FROM style_operations
      INNER JOIN operation ON operation.operation_id = style_operations.operation_id
      WHERE style_operations.style_id = ".$style_id." ORDER BY operation_order";
      $query = $this->db->query($sql);
      return $query->result_array();
  }


  private function get_next_operation_order($style_id){
    $this->db->select_max('operation_order');
    $this->db->where('style_id',$style_id);
    $max = $this->db->get('style_operations')->row_array();
    return $max['operation_order']+1;
  }


  public function remove_style_operation($style_id, $operation_id, $seq){
    $this->db->where('style_id', $style_id);
    $this->db->where('operation_id', $operation_id);
    $this->db->delete('style_operations');

    $this->update_style_operation_seq($style_id, $seq);
  }


  public function update_style_operation_seq($style_id, $from_seq){
    $sql = "UPDATE style_operations SET operation_order = (operation_order - 1)
    WHERE style_id = ".$style_id." AND operation_order > ".$from_seq;
    $this->db->query($sql);
  }

}
