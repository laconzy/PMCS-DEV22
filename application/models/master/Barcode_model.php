<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function count_barcodes($style, $color, $size, $qty, $barcode_id)
    {
        //echo $qty;die();
		    $this->db->where('style', $style);
		    $this->db->where('color', $color);
        $this->db->where('size', $size);
        $this->db->where('cartoon_qty', $qty);
        $this->db->where('barcode_id !=', $barcode_id);
		    $this->db->from('master_barcode');
		    return $this->db->count_all_results();
    }

    public function is_barcode_exists($barcode, $barcode_id)
    {
		    $this->db->where('barcode', $barcode);
		    $this->db->where('barcode_id !=', $barcode_id);
		    $this->db->from('master_barcode');
		    $count = $this->db->count_all_results();
        return ($count > 0) ? true : false;
    }


    public function add_barcode($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['created_at'] = $current_timestamp;
		    $data['updated_at'] = $current_timestamp;
		    $data['created_user'] = $current_user;
		    $data['updated_user'] = $current_user;
		    $this->db->insert('master_barcode', $data);
		    return $this->db->insert_id();
	}


  public function update_barcode($data)
  {
	    $data['updated_at'] = date("Y-m-d H:i:s");
	    $data['updated_user'] = $this->session->userdata('user_id');
	    $this->db->where('barcode_id', $data['barcode_id']);
	    $this->db->update('master_barcode', $data);
	    return true;
  }

	public function get_barcode($barcode_id = 0)
	{
		$this->db->where('barcode_id',$barcode_id);
		$query = $this->db->get('master_barcode');
		return $query->row_array();
	}

  public function get_barcode_full_data($barcode_id = 0) {
    $sql = "SELECT
    master_barcode.*,
    style.style_code,
    style.style_name,
    color.color_code,
    color.color_name,
    size.size_code,
    size.size_name,
    cartoon_qty.qty
    FROM master_barcode
    INNER JOIN style ON style.style_id = master_barcode.style
    INNER JOIN color ON color.color_id = master_barcode.color
    INNER JOIN size ON size.size_id = master_barcode.size
    INNER JOIN cartoon_qty ON cartoon_qty.qty_id = master_barcode.cartoon_qty
    WHERE master_barcode.barcode_id = ".$barcode_id;
    $query = $this->db->query($sql);
		return $query->row_array();
	}

	public function destroy($barcode_id)
  {
		$this->db->where('barcode_id', $barcode_id);
		$this->db->update('master_barcode', array('active' => 'N'));
		return true;
  }

	public function get_barcodes($start,$limit,$search,$order)
	{
		$search_like = "'%".$search."%'";
		$sql = "SELECT
    master_barcode.*,
    style.style_code,
    style.style_name,
    color.color_code,
    color.color_name,
    size.size_code,
    size.size_name,
    cartoon_qty.qty
    FROM master_barcode
    INNER JOIN style ON style.style_id = master_barcode.style
    INNER JOIN color ON color.color_id = master_barcode.color
    INNER JOIN size ON size.size_id = master_barcode.size
    INNER JOIN cartoon_qty ON cartoon_qty.qty_id = master_barcode.cartoon_qty
    WHERE master_barcode.barcode_id LIKE ".$search_like." OR style.style_code LIKE ".$search_like." OR
    color.color_code LIKE ".$search_like." OR size.size_code LIKE ".$search_like." OR  cartoon_qty.qty LIKE ".$search_like."
    ORDER BY ".$order." LIMIT ".$start.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_barcodes_count($search)
	{
		$search_like = "'%".$search."%'";
    $sql = "SELECT
    COUNT(barcode_id) AS row_count
    FROM master_barcode
    INNER JOIN style ON style.style_id = master_barcode.style
    INNER JOIN color ON color.color_id = master_barcode.color
    INNER JOIN size ON size.size_id = master_barcode.size
    INNER JOIN cartoon_qty ON cartoon_qty.qty_id = master_barcode.cartoon_qty
    WHERE master_barcode.barcode_id LIKE ".$search_like." OR style.style_code LIKE ".$search_like." OR
    color.color_code LIKE ".$search_like." OR size.size_code LIKE ".$search_like." OR  cartoon_qty.qty LIKE ".$search_like;

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['row_count'];
	}


  public function search($search)
  {
    $this->db->select('barcode_id as id,barcode as text');
    $this->db->from('master_barcode');
    $this->db->like('barcode', $search, 'after');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_barcode_from_code($barcode = '')
	{
    $this->db->select('master_barcode.*,cartoon_qty.qty');
    $this->db->join('cartoon_qty','master_barcode.cartoon_qty = cartoon_qty.qty_id');
		$this->db->where('barcode',$barcode);
		$query = $this->db->get('master_barcode');
		return $query->row_array();
	}

}
