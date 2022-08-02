<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Commitments_Model extends CI_Model
{

	public function __construct()
	{

		parent::__construct();

		$this->load->database();
	}

	public function create($data)
	{

		$this->db->insert_batch('cut_bundles', $data);
	}


public function load_line_data($date,$shift){
$s="";
if($shift == 'A'){
$s='%';
}else{
	$s=1;
}

 $sql="SELECT
line.line_id,
line.line_code,
line.active,
line.created_at,
line.created_user,
line.updated_at,
line.updated_user,
line.section,
line.seq,
line.category,
line.location,
line.double_shift,
(SELECT
L1.plan_qty
FROM
line_commitments AS L1
WHERE
L1.date = '".$date."' AND
L1.line = line.line_id AND
L1.shift = '".$shift."'
) plan_qty,
(SELECT
L2.commited
FROM
line_commitments AS L2
WHERE
L2.date = '".$date."' AND
L2.line = line.line_id AND
L2.shift = '".$shift."') com_qty,
(SELECT
IFNULL(L2.commited_by,'-')
FROM
line_commitments AS L2
WHERE
L2.date = '".$date."' AND
L2.line = line.line_id AND
L2.shift = '".$shift."') commited_by
FROM `line`
WHERE
line.category = 'PROD' AND
line.active = 'Y' AND
line.double_shift like '".$s."'
";

$query = $this->db->query($sql);

return $query->result_array();

}


public function load_single_line_data($date, $shift, $line_no){
$s="";
if($shift == 'A'){
$s='%';
}else{
	$s=1;
}

 $sql="SELECT
line.line_id,
line.line_code,
line.active,
line.created_at,
line.created_user,
line.updated_at,
line.updated_user,
line.section,
line.seq,
line.category,
line.location,
line.double_shift,
(SELECT
L1.plan_qty
FROM
line_commitments AS L1
WHERE
L1.date = '".$date."' AND
L1.line = line.line_id AND
L1.shift = '".$shift."'
) plan_qty,
(SELECT
L2.commited
FROM
line_commitments AS L2
WHERE
L2.date = '".$date."' AND
L2.line = line.line_id AND
L2.shift = '".$shift."') com_qty,
(SELECT
IFNULL(L2.commited_by,'-')
FROM
line_commitments AS L2
WHERE
L2.date = '".$date."' AND
L2.line = line.line_id AND
L2.shift = '".$shift."') commited_by
FROM `line`
WHERE
line.category = 'PROD' AND
line.active = 'Y' AND
line.double_shift like '".$s."' AND
line.line_id = ".$line_no;
//echo $sql;die();
$query = $this->db->query($sql);
$result = $query->result_array();
return ($result == null) ? null : $result[0];

}



public function load_data($date,$shift,$line){
$s="";
if($shift == 'A'){
$s='%';
}else{
	$s=1;
}

  $sql="SELECT
view_line_out.ttl_qty,
view_line_out.style_code,
view_line_out.style_name,
view_line_out.shift,
view_line_out.line_code,
view_line_out.scan_date,
view_line_out.smv,
view_line_out.produced_min,
view_line_out.line_id,
view_line_out.location,
view_line_out.seq,
view_line_out.section,
view_line_out.active,
view_line_out.style,
view_line_out.style_category,
style_cat.category
FROM `view_line_out`
INNER JOIN style_cat ON style_cat.id = view_line_out.style_category
WHERE
view_line_out.line_id = '".$line."' AND
view_line_out.shift = '".$shift."' AND
view_line_out.scan_date = '".$date."'";

$query = $this->db->query($sql);

return $query->result_array();

}

public function save_all($data){

	$date = $data['date'];
	$shift = $data['shift'];
	$line = $data['line'];

	$sql = "DELETE FROM line_commitments WHERE date = ? AND shift = ? AND line = ?";
	$this->db->query($sql, [$date, $shift, $line]);

	$this->db->insert('line_commitments', $data);
}

public function save_eff($data){
	//print_r($data);
	$date = $this->input->post('date');
	$line = $this->input->post('line');
	$shift = $this->input->post('shift');
	//$shift=$data[0]['shift'];
	$sql = "DELETE FROM eff_report WHERE date = ? and shift = ? AND line_id = ?";

	$this->db->query($sql, [$date, $shift, $line]);

	$this->db->insert_batch('eff_report', $data);
}


public function load_data_from_line_commitments($date,$shift,$line){
	// $this->db->select('line_commitments.*','line.line_code');
	// $this->db->from('line_commitments');
	// $this->db->join('line', 'line.line_id','line_commitments.line');
	// $this->db->where('date', $date);
	// $this->db->where('shift', $shift);
	// $this->db->where('line', $line);
	$sql = "SELECT line_commitments.*,line.line_code
	FROM line_commitments
	INNER JOIN line ON line.line_id = line_commitments.line
	WHERE date = '".$date."' AND shift = '".$shift."' AND line = ".$line;
	$query = $this->db->query($sql);
	$result = $query->result_array();
	return ($result == null) ? null : $result[0];
}


public function get_style_from_code($style_code){
	$this->db->from('style');
	$this->db->where('style_code', $style_code);
	$query = $this->db->get();
	return $query->row_array();;
}

public function get_style_categories(){
	$this->db->from('style_cat');
	$query = $this->db->get();
	return $query->result_array();;
}

}



//

//

//

//


//}
