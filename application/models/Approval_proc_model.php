<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval_Proc_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //get user tasks of a specific user
    public function get_user_tasks($start,$limit,$search,$order, $user_id, $status){
      $search_like = "'%".$search."%'";
      $sql = "SELECT approval_level_run.*,
      approval_proc_def.proc_name,
      approval_proc_def.view_open_path,
      approval_proc_run.object_id,
      CONCAT(user.first_name,' ', user.last_name) AS started_user_name
      FROM approval_level_run
      INNER JOIN approval_proc_run ON approval_proc_run.proc_inst_id = approval_level_run.proc_inst_id
      INNER JOIN approval_proc_def ON approval_proc_def.proc_id = approval_proc_run.proc_id
      INNER JOIN user ON user.id = approval_proc_run.started_user_id
      WHERE (approval_level_run.user_id = ".$user_id." AND approval_level_run.status = '".$status."') AND
      (approval_level_run.level LIKE ".$search_like.")
      ORDER BY ".$order." LIMIT ".$start.",".$limit;

      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function get_user_tasks_count($search, $user_id, $status){
      $search_like = "'%".$search."%'";
      $sql = "SELECT COUNT(approval_level_run.task_id) row_count
      FROM approval_level_run
      INNER JOIN approval_proc_run ON approval_proc_run.proc_inst_id = approval_level_run.proc_inst_id
      INNER JOIN approval_proc_def ON approval_proc_def.proc_id = approval_proc_run.proc_id
      WHERE (approval_level_run.user_id = ".$user_id." AND approval_level_run.status = '".$status."') AND
      (approval_level_run.level LIKE ".$search_like.")";

      $query = $this->db->query($sql);
      $result = $query->row_array();
  		return $result['row_count'];
    }

    //get sending failed task emails
    public function get_sending_fail_emails($start,$limit,$search,$order, $status){
      $search_like = "'%".$search."%'";
      $sql = "SELECT approval_level_run.*,
      approval_proc_def.proc_name,
      approval_proc_def.view_open_path,
      approval_proc_run.object_id,
      CONCAT(user.first_name,' ', user.last_name) AS started_user_name
      FROM approval_level_run
      INNER JOIN approval_proc_run ON approval_proc_run.proc_inst_id = approval_level_run.proc_inst_id
      INNER JOIN approval_proc_def ON approval_proc_def.proc_id = approval_proc_run.proc_id
      INNER JOIN user ON user.id = approval_proc_run.started_user_id
      WHERE (approval_level_run.email_sent = -1 AND approval_level_run.status = '".$status."') AND
      (approval_level_run.level LIKE ".$search_like.")
      ORDER BY ".$order." LIMIT ".$start.",".$limit;

      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function get_sending_fail_emails_count($search, $status){
      $search_like = "'%".$search."%'";
      $sql = "SELECT COUNT(approval_level_run.task_id) row_count
      FROM approval_level_run
      INNER JOIN approval_proc_run ON approval_proc_run.proc_inst_id = approval_level_run.proc_inst_id
      INNER JOIN approval_proc_def ON approval_proc_def.proc_id = approval_proc_run.proc_id
      WHERE (approval_level_run.email_sent = -1 AND approval_level_run.status = '".$status."') AND
      (approval_level_run.level LIKE ".$search_like.")";

      $query = $this->db->query($sql);
      $result = $query->row_array();
  		return $result['row_count'];
    }



    //Core functions related to approval process -------------------------------

    public function get_all_process_def(){
      $this->db->where('active', 'Y');
      $this->db->from('approval_proc_def');
      $query = $this->db->get();
      return $query->result_array();
    }


    public function get_proc_def($proc_id)
    {
		    $this->db->where('proc_id', $proc_id);
		    $this->db->from('approval_proc_def');
		    $query = $this->db->get();
        return $query->row_array();
    }


    public function get_proc_def_from_code($proc_code)
    {
		    $this->db->where('proc_code', $proc_code);
		    $this->db->from('approval_proc_def');
		    $query = $this->db->get();
        return $query->row_array();
    }


    public function get_proc_levels($proc_id, $level){
      $this->db->where('proc_id', $proc_id);
      $this->db->where('level', $level);
      $this->db->from('approval_level_def');
      $query = $this->db->get();
      return $query->result_array();
    }

    /*public function get_proc_level($proc_id, $level){
      $this->db->where('proc_id', $proc_id);
      $this->db->where('level', $level);
      $this->db->from('approval_level_def');
      $query = $this->db->get();
      return $query->row_array();
    }*/


    /*public function get_proc_level_with_condition($proc_id, $level, $condition){
      $this->db->where('proc_id', $proc_id);
      $this->db->where('level', $level);
      $this->db->where('condition_data', $condition);
      $this->db->from('approval_level_def');
      $query = $this->db->get();
      return $query->row_array();
    }*/

    public function get_proc_from_proc_id_and_object_id($proc_id, $object_id){
      $this->db->where('proc_id', $proc_id);
      $this->db->where('object_id', $object_id);
      $this->db->from('approval_proc_run');
      $query = $this->db->get();
      return $query->result_array();
    }


    public function get_process_instance($proc_inst_id){
      $this->db->where('proc_inst_id', $proc_inst_id);
      $this->db->from('approval_proc_run');
      $query = $this->db->get();
      return $query->row_array();
    }


    public function get_task($task_id){
      $this->db->where('task_id', $task_id);
      $this->db->from('approval_level_run');
      $query = $this->db->get();
      return $query->row_array();
    }


    public function get_task_full_data($task_id){
      $sql = "SELECT approval_level_run.*,
      approval_proc_def.proc_name,
      approval_proc_def.view_open_path,
      approval_proc_run.object_id,
      u1.first_name AS started_user_first_name,
      u1.last_name AS started_user_last_name,
      CONCAT(u1.first_name,' ', u1.last_name) AS started_user_name,
      u1.email AS started_user_email,
      u2.first_name AS task_user_first_name,
      u2.last_name AS task_user_last_name,
      CONCAT(u2.first_name,' ', u2.last_name) AS task_user_name,
      u2.email AS task_user_email
      FROM approval_level_run
      INNER JOIN approval_proc_run ON approval_proc_run.proc_inst_id = approval_level_run.proc_inst_id
      INNER JOIN approval_proc_def ON approval_proc_def.proc_id = approval_proc_run.proc_id
      INNER JOIN user AS u1 ON u1.id = approval_proc_run.started_user_id
      INNER JOIN user AS u2 ON u2.id = approval_level_run.user_id
      WHERE approval_level_run.task_id = ".$task_id;

      $query = $this->db->query($sql);
      return $query->row_array();
    }


    public function get_task_for_emails($count){
      $sql = "SELECT approval_level_run.*,
      user.first_name AS started_user_first_name,
      user.last_name AS started_user_last_name,
      CONCAT(user.first_name,' ', user.last_name) AS started_user_name,
      user.email
      FROM approval_level_run
      INNER JOIN user ON user.id = approval_level_run.user_id
      WHERE approval_level_run.email_sent = 0 AND approval_level_run.active = 1
      LIMIT 0,".$count;

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    //-----------------------------



    public function start_process($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
		    $data['started_date'] = $current_timestamp;
        $data['started_user_id'] = $current_user;
        $data['current_level'] = 1;
        $data['status'] = 'PENDING';
		    $this->db->insert('approval_proc_run', $data);
		    return $this->db->insert_id();
	  }


    public function update_process($proc_inst_id, $data){
      $this->db->where('proc_inst_id', $proc_inst_id);
      $this->db->update('approval_proc_run', $data);
    }

    public function end_process($proc_inst_id, $status)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $current_user = $this->session->userdata('user_id');
        $data = [
          'end_date' => $current_timestamp,
          'status' => 'COMPLETE',
          'user_status' => $status
        ];
        $this->db->where('proc_inst_id', $proc_inst_id);
		    $this->db->update('approval_proc_run', $data);
	  }


    public function start_task($data)
    {
		    $current_timestamp = date("Y-m-d H:i:s");
		    $data['started_date'] = $current_timestamp;
        $data['status'] = 'PENDING';
		    $this->db->insert('approval_level_run', $data);
		    return $this->db->insert_id();
	  }

    public function update_task($task_id, $data){
      $this->db->where('task_id', $task_id);
      $this->db->update('approval_level_run', $data);
    }

    public function inactive_tasks($proc_inst_id, $level){
      $this->db->where('proc_inst_id', $proc_inst_id);
      $this->db->where('level', $level);
      $this->db->update('approval_level_run', ['active' => 0]);
    }

    //------------------------------------------------------------


    public function get_condition_query_result($code, $proc_data, $proc_inst_data){
      $sql = "";

      if($code == 'GP_SITE_SELECT'){
        $sql = "SELECT site AS result FROM manual_gp_header WHERE id = ".$proc_inst_data['object_id'];
      }
      else if($code == 'GP_USER_HOD'){
        $sql = "SELECT hod_allocation.user_id AS result FROM manual_gp_header
        INNER JOIN user ON user.id = manual_gp_header.created_by
        INNER JOIN hod_allocation ON hod_allocation.site_id = manual_gp_header.site AND hod_allocation.department_id = user.department
        WHERE manual_gp_header.id = ".$proc_inst_data['object_id'];
      }

      $query = $this->db->query($sql);
      return $query->row_array();
    }


    public function run_query($sql, $parms){
      $this->db->query($sql, $parms);
      return $this->db->affected_rows();
    }


    public function get_authorization_details($proc_inst_id){
      $sql = "SELECT
      approval_level_def.*,
      user.first_name,
      user.last_name,
      user.email,
      approval_level_run.status,
      approval_level_run.end_date
      FROM approval_level_def
      LEFT JOIN approval_level_run ON approval_level_run.level_id = approval_level_def.id
      LEFT JOIN user ON user.id = approval_level_run.user_id
      WHERE approval_level_run.proc_inst_id = ".$proc_inst_id."
      ORDER BY approval_level_run.level";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

}
