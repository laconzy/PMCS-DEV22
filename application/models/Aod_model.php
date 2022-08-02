<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aod_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function create($data) {
      $cur_date = date("Y-m-d H:i:s");
      $data['created_by'] = $this->session->userdata('user_id');
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['created_at'] = $cur_date;
      $data['updated_at'] = $cur_date;

      $this->db->insert('aod_header',$data);
      $aod_no = $this->db->insert_id();
      return $aod_no;
    }


    public function update($data){
      $update_data = [
        'aod_date' => $data['aod_date']
      ];
      $cur_date = date("Y-m-d H:i:s");
      $update_data['updated_by'] = $this->session->userdata('user_id');
      $update_data['updated_at'] = $cur_date;
      $this->db->where('aod_no' , $data['aod_no']);
      $this->db->update('aod_header' , $update_data);
      return true;
    }


    public function get_aod($aod_no){
      $this->db->where('aod_no',$aod_no);
      $query = $this->db->get('aod_header');
      return $query->row_array();
    }


    public function get_pending_bundles($order_id,$operation){
      $sql = "SELECT production.*,item.item_code,size.size_code FROM production
          LEFT JOIN aod_details ON production.barcode = aod_details.barcode
          INNER JOIN item ON production.item = item.item_id
          INNER JOIN size ON production.size = size.size_id
          WHERE production.order_id = ? AND production.operation = ? AND production.operation_point = 'IN'
          AND production.barcode NOT IN (SELECT barcode FROM aod_details WHERE production.order_id = ? AND production.operation = ?)";
      $query = $this->db->query($sql , [$order_id , $operation , $order_id , $operation]);
      return $query->result_array();
    }


    public function get_added_bundles($aod_no){
      $sql = "SELECT aod_details.*,item.item_code,size.size_code FROM aod_details
          INNER JOIN item ON aod_details.item = item.item_id
          INNER JOIN size ON aod_details.size = size.size_id
          WHERE aod_details.aod_no = ?";
      $query = $this->db->query($sql , [$aod_no]);
      return $query->result_array();
    }


    public function add_selected_barcodes($order_id, $operation, $barcodes , $aod_no){
      $barcode_str = implode(',' , $barcodes);
      $cur_date = date("Y-m-d H:i:s");
      $user = $this->session->userdata('user_id');
      $sql = "INSERT INTO aod_details (order_id,laysheet_no,bundle_no,barcode,item,size,qty,operation,color,aod_no,created_date,created_by)
          SELECT order_id,laysheet_no,bundle_no,barcode,item,size,qty,operation,color,'".$aod_no."','".$cur_date."','".$user."'
          FROM   production WHERE order_id = ? AND operation = ? AND operation_point = 'IN' AND barcode IN (".$barcode_str.")";
      $query = $this->db->query($sql , [$order_id, $operation]);
      return true;
    }


    public function remove_barcodes($aod_no = 0, $barcodes){
      $this->db->where('aod_no' , $aod_no);
      $this->db->where_in($barcodes);
      $this->db->delete('aod_details');
      return true;
    }


    public function get_aods($start,$limit,$search,$order)
  	{
  		$search_like = "'%".$search."%'";
  		$sql = "SELECT * FROM aod_header WHERE aod_no LIKE ".$search_like." OR
  				contract_no LIKE ".$search_like." OR order_id LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
  		$query = $this->db->query($sql);
  		return $query->result_array();
  	}

  	public function get_aods_count($search)
  	{
  		$search_like = "'%".$search."%'";
  		$sql = "SELECT COUNT(aod_no) row_count FROM aod_header WHERE aod_no LIKE ".$search_like." OR
  				contract_no LIKE ".$search_like." OR order_id LIKE ".$search_like;
  		$query = $this->db->query($sql);
  		$result = $query->row_array();
  		return $result['row_count'];
  	}

    public function destroy($aod_no)
    {
  		$this->db->where('aod_no', $aod_no);
  		$this->db->update('aod_header', array('active' => 'N'));
  		return true;
    }

}
