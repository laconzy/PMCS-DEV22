<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gatepass_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function create_manual_gp($data) {
      $cur_date = date("Y-m-d H:i:s");
      $data['created_by'] = $this->session->userdata('user_id');
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['created_at'] = $cur_date;
      $data['updated_at'] = $cur_date;
      $data['status'] = 'NEW';

      $this->db->insert('manual_gp_header',$data);
      $id = $this->db->insert_id();
      return $id;
    }


    public function update_manual_gp($data){
      $update_data = [
        'to_address' => $data['to_address'],
        'attention' => $data['attention'],
        'remarks' => $data['remarks'],
        'type' => $data['type'],
        'style' => $data['style'],
        'through' => $data['through'],
        'instructed_by' => $data['instructed_by'],
        'special_instruction' => $data['special_instruction'],
        'return_status' => $data['return_status']
      ];
      $cur_date = date("Y-m-d H:i:s");
      $update_data['updated_by'] = $this->session->userdata('user_id');
      $update_data['updated_at'] = $cur_date;
      $this->db->where('id' , $data['id']);
      $this->db->update('manual_gp_header' , $update_data);
      return true;
    }


    public function get_manual_gp($id){
      $this->db->where('id',$id);
      $query = $this->db->get('manual_gp_header');
      return $query->row_array();
    }


    public function add_manual_gp_item($data){
      $cur_date = date("Y-m-d H:i:s");
      $data['created_by'] = $this->session->userdata('user_id');
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['created_at'] = $cur_date;
      $data['updated_at'] = $cur_date;
      $data['type'] = 'ITEM';

      //$count = $this->get_manual_gp_item_count($data['header_id']);
      //$data['line_no'] = $count + 1;

      $this->db->insert('manual_gp_details',$data);
      $id = $this->db->insert_id();
      return $id;
    }


    public function update_manual_gp_item($data){
      $cur_date = date("Y-m-d H:i:s");
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['updated_at'] = $cur_date;

      $this->db->where('id', $data['id']);
      $this->db->update('manual_gp_details',$data);
      $id = $this->db->insert_id();
      return $id;
    }


    public function get_manula_gp_item($item_id){
      $this->db->where('id',$item_id);
      $query = $this->db->get('manual_gp_details');
      return $query->row_array();
    }


    private function get_manual_gp_item_count($id){
      $this->db->where('header_id',$id);
      $query = $this->db->get('manual_gp_details');
      $data = $query->result_array();
      if($data == null){
        return 0;
      }
      else {
        return sizeof($data);
      }
    }

    public function get_manula_gp_items($id){
      $this->db->where('header_id',$id);
      $this->db->where('type', 'ITEM');
      $this->db->order_by('id ASC');
      $query = $this->db->get('manual_gp_details');
      return $query->result_array();
    }


    public function delete_manual_gp_item($item_id){
      $this->db->where('id', $item_id);
      $this->db->delete('manual_gp_details');
    }


    public function update_manual_gp_status($id, $status, $date){
      $this->db->where('id', $id);
      $this->db->update('manual_gp_header', ['status' => $status, 'approved_date' => $date]);
    }


    // public function manual_gp_approval_details_for_print($id, $site){
    //   $sql = "SELECT
    //   approval_level_def.*,
    //   user.first_name,
    //   user.last_name,
    //   user.email,
    //   approval_level_run.status,
    //   approval_level_run.end_date
    //   FROM approval_level_def
    //   LEFT JOIN approval_level_run ON approval_level_run.level_id = approval_level_def.id AND approval_level_run.object_id = ".$id."
    //   INNER JOIN approval_proc_def ON  approval_proc_def.proc_id = approval_level_def.proc_id
    //   INNER JOIN user ON user.id = approval_level_def.user_id
    //   WHERE approval_proc_def.proc_code = 'M_GATEPASS' AND approval_level_def.condition_data = '".$site."'";
    //   $query = $this->db->query($sql);
    //   return $query->result_array();
    // }   


    public function get_manual_gp_list($start,$limit,$search,$order)
  	{
  		$search_like = "'%".$search."%'";
  		$sql = "SELECT manual_gp_header.*,site.site_name FROM manual_gp_header
      INNER JOIN site ON site.id = manual_gp_header.site
      WHERE manual_gp_header.id LIKE ".$search_like." OR
  				site.site_name LIKE ".$search_like." OR manual_gp_header.to_address LIKE ".$search_like." OR manual_gp_header.attention LIKE ".$search_like."
          OR manual_gp_header.style LIKE ".$search_like." ORDER BY ".$order." LIMIT ".$start.",".$limit;
  		$query = $this->db->query($sql);
  		return $query->result_array();
  	}

  	public function get_manual_gp_count($search)
  	{
  		$search_like = "'%".$search."%'";
  		$sql = "SELECT COUNT(manual_gp_header.id) row_count FROM manual_gp_header
      INNER JOIN site ON site.id = manual_gp_header.site
      WHERE manual_gp_header.id LIKE ".$search_like." OR
  				site.site_name LIKE ".$search_like." OR manual_gp_header.to_address LIKE ".$search_like." OR manual_gp_header.attention LIKE ".$search_like."
          OR manual_gp_header.style LIKE ".$search_like;
  		$query = $this->db->query($sql);
  		$result = $query->row_array();
  		return $result['row_count'];
  	}


    public function add_manual_gp_laysheet($data){
      $cur_date = date("Y-m-d H:i:s");
      $data['created_by'] = $this->session->userdata('user_id');
      $data['updated_by'] = $this->session->userdata('user_id');
      $data['created_at'] = $cur_date;
      $data['updated_at'] = $cur_date;
      $data['type'] = 'LAYSHEET';

      $this->db->insert('manual_gp_details',$data);
      $id = $this->db->insert_id();
      return $id;
    }


    public function get_manula_gp_laysheets($id){
      $sql = "SELECT
      manual_gp_details.*,
      cut_laysheet.order_id,
      cut_laysheet.cut_no,
      order_head.order_code
      FROM manual_gp_details
      INNER JOIN cut_laysheet ON cut_laysheet.laysheet_no = manual_gp_details.laysheet_no
      INNER JOIN order_head ON order_head.order_id = cut_laysheet.order_id
      WHERE manual_gp_details.header_id = ".$id." AND type = 'LAYSHEET' ORDER BY id ASC";
    //  echo $sql;die();
      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function get_laysheet_details($laysheet){
      $this->db->where('laysheet_no', $laysheet);
      $this->db->from('cut_laysheet');
      $query = $this->db->get();
      return $query->row_array();
    }


    public function receive_manual_gp($id){
      $cur_date = date("Y-m-d H:i:s");
      $user_id = $this->session->userdata('user_id');
      $data = [
        'status' => 'RECEIVED',
        'received_by' => $user_id,
        'received_date' => $cur_date
      ];
      $this->db->where('id', $id);
      $this->db->update('manual_gp_header', $data);
    }

}
