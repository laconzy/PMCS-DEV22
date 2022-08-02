<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval_proc extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model(['approval_proc_model']);
         $this->load->library('Email_Sender');
         $this->load->library('encryption');
    }

    public function index() {

    }


    public function user_tasks() { //open common user tasks page
      $this->login_model->user_authentication(null); // user permission authentication
      $data = [
        'menus' => $this->login_model->get_authorized_menus(),
        'menu_code' => null,
      ];
      $this->load->view('task/user_tasks',$data);
    }

    public function get_user_tasks(){
      $auth_data = $this->login_model->user_authentication_ajax(null);
      if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $data = $_POST;
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];
        $search = $data['searchText'];//$data['search']['value'];
        $status = 'PENDING';//$this->input->get('status');
        $order = $data['order'][0];
        $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

        $current_user = $this->session->userdata('user_id');

        $list = $this->approval_proc_model->get_user_tasks($start,$length,$search,$order_column, $current_user, $status);
        $count = $this->approval_proc_model->get_user_tasks_count($search, $current_user, $status);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $list
        ));
    }

    public function sending_fail_emails() { //open list of sending failed emails
      $this->login_model->user_authentication(null); // user permission authentication
      $data = [
        'menus' => $this->login_model->get_authorized_menus(),
        'menu_code' => null,
      ];
      $this->load->view('task/sending_fail_emails',$data);
    }

    public function get_sending_fail_emails(){
      $auth_data = $this->login_model->user_authentication_ajax(null);
      if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $data = $_POST;
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];
        $search = $data['searchText'];//$data['search']['value'];
        $status = 'PENDING';//$this->input->get('status');
        $order = $data['order'][0];
        $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

        $list = $this->approval_proc_model->get_sending_fail_emails($start,$length,$search,$order_column, $status);
        $count = $this->approval_proc_model->get_sending_fail_emails_count($search, $status);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $list
        ));
    }


    public function resend_email(){
      $task_id = $this->input->post('task_id');
      $proc_inst_id = $this->input->post('proc_inst_id');
      $task = $this->approval_proc_model->get_task_full_data($task_id);
      if($task != null){
        $send_status = $this->send_email($task, null, null);
        if($send_status == true){
          echo json_encode([
            'status' => 'success',
            'message' => 'Email send successfully'
          ]);
        }
        else {
          echo json_encode([
            'status' => 'error',
            'message' => 'Email not sent'
          ]);
        }
      }
      else {
        echo json_encode([
          'status' => 'error',
          'message' => 'Incorrect task data'
        ]);
      }
    }

    //core functions of approval process ---------------------------------------

    public function start_process()
    {
    	  $this->login_model->user_authentication(null); // user permission authentication
        $proc_code = $this->input->post('proc_code');
        $object_id = $this->input->post('object_id');

        $proc_data = $this->approval_proc_model->get_proc_def_from_code($proc_code);
        if($proc_data == null){
          echo json_encode([
  					'status' => 'error',
  					'message' => 'Incorrect process data'
  				]);
          return;
        }
        $proc_id = $proc_data['proc_id'];

  			$already_saved_process = $this->approval_proc_model->get_proc_from_proc_id_and_object_id($proc_id, $object_id);
  			if($already_saved_process != null && sizeof($already_saved_process) > 0){
  				echo json_encode([
  					'status' => 'error',
  					'message' => 'Approval process already started'
  				]);
  			}
  			else {
  				$data = [
  					'proc_id' => $proc_id,
  					'object_id' => $object_id
  				];
          $proc_inst_id = $this->approval_proc_model->start_process($data); //start process and get process instance data
          $proc_inst_data = $this->approval_proc_model->get_process_instance($proc_inst_id);

          $this->event_process_started($proc_data, $proc_inst_data);//after process start event

          $this->start_tasks(1, $proc_data, $proc_inst_data);//create tasks after start a process

  				echo json_encode([
  					'status' => 'success',
  					'message' => 'Approval process started successfully'
  				]);
  			}
    }


    public function process_user_response_from_email($code){
      //$this->login_model->user_authentication(null); // user permission authentication
      $decode_code = base64_decode($code);
      $decrypt_code = $this->encryption->decrypt($decode_code);
      $arr = explode("-",$decrypt_code);
      $proc_inst_id = $arr[0];
      $task_id = $arr[1];
      $status = $arr[2];
      $status = strtoupper($status);
      $res = $this->do_task($proc_inst_id, $task_id, $status);
      $this->load->view('task/email_approval_response',$res);
    }


    public function process_user_response(){
      $this->login_model->user_authentication(null); // user permission authentication
      $proc_inst_id = $this->input->post('proc_inst_id');
      $task_id = $this->input->post('task_id');
      $status = $this->input->post('status');
      $status = strtoupper($status);
      $res = $this->do_task($proc_inst_id, $task_id, $status);
      echo json_encode($res);
    }


    private function do_task($proc_inst_id, $task_id, $status){

      $process_instance = $this->approval_proc_model->get_process_instance($proc_inst_id);
      if($process_instance == null){
        return [
          'status' => 'error',
          'message' => 'Incorrect approval process data'
        ];
      }

      if($process_instance['status'] == 'COMPLETE'){
        return [
          'status' => 'error',
          'message' => 'Approval process already completed'
        ];
      }

      $proc_data = $this->approval_proc_model->get_proc_def($process_instance['proc_id']);
      $task = $this->approval_proc_model->get_task($task_id);
      if($task == null){
        return [
          'status' => 'error',
          'message' => 'Incorrect approval task'
        ];
      }

      if($task['status'] != 'PENDING'){
        return [
          'status' => 'error',
          'message' => 'Task already completed'
        ];
      }

      $current_timestamp = date("Y-m-d H:i:s");
      $update_task_data = [
        'end_date' => $current_timestamp,
        'status' => $status,
        'active' => 0
      ];
      $this->approval_proc_model->update_task($task_id, $update_task_data);
      $this->approval_proc_model->inactive_tasks($proc_inst_id, $task['level']);
      $this->event_task_completed($proc_data, $process_instance, $task);

      //check process rejected
      if($status == 'REJECT'){
        $this->approval_proc_model->end_process($proc_inst_id, $status);
        //process end event
        $process_instance = $this->approval_proc_model->get_process_instance($proc_inst_id);
        $this->event_process_end($proc_data, $process_instance);
      }
      else {
        //try to create next level user tasks, user list will be returned if tasks created. if no next level users,
        //null will be returned.
        $next_level_users = $this->start_tasks(($task['level'] + 1), $proc_data, $process_instance);
        if($next_level_users == null || sizeof($next_level_users) <= 0){ //no next level users, so process will be end
          $this->approval_proc_model->end_process($proc_inst_id, $status);
          //process end event
          $process_instance = $this->approval_proc_model->get_process_instance($proc_inst_id);
          $this->event_process_end($proc_data, $process_instance);
        }
      }

      return [
        'status' => 'success',
        'message' => 'Task completed successfully'
      ];
    }


    public function generate_content($base_text, $data){
      foreach ($data as $key => $value) {
        $base_text = str_replace("{{".$key."}}", $value, $base_text);
      }
      return $base_text;
    }



    public function send_email($task, $proc_data, $proc_inst_data){
      // $approve_code = $this->encryption->encrypt($task['proc_inst_id'].'-'.$task['task_id'].'-approve');
      // $reject_code = $this->encryption->encrypt($task['proc_inst_id'].'-'.$task['task_id'].'-reject');
      // $task['approve_link'] = base_url() .'index.php/approval_proc/process_user_response_from_email/'. $approve_code;
      // $task['reject_link'] = base_url() .'index.php/approval_proc/process_user_response_from_email/'. $reject_code;
      $send_status = false;
      //default email settings
      $arr = array(
           'to' => $task['task_user_email'],
           'subject' => $task['email_header'],
           'data' =>  $task,
           'attachments' => null,
           'email_view_path' => 'task/task_email'
       );

       $mail_arr = [];
       array_push($mail_arr, $arr);

       if($this->email_sender->send_mail($mail_arr)){
         $current_timestamp = date("Y-m-d H:i:s");
         $update_task_data = [
           'email_sent_date' => $current_timestamp,
           'email_sent' => 1
         ];
         $this->approval_proc_model->update_task($task['task_id'], $update_task_data);
         $send_status = true;
       }
       else { //if email not sent, chage status to -1. after those can be identifyed and resend again
         $update_task_data = [
           'email_sent' => -1
         ];
         $this->approval_proc_model->update_task($task['task_id'], $update_task_data);
       }
       return $send_status;
    }


    public function run_emails_queue(){
      $tasks = $this->approval_proc_model->get_task_for_emails(1);
      foreach ($tasks as $row) {
        $arr = array(
             'to' => 'chamila@dignitydtrt.com',
             'subject' => $row['email_header'],
             'data' =>  $row,
             'attachments' => null,
             'email_view_path' => 'task/task_email'
         );

         $mail_arr = [];
         array_push($mail_arr, $arr);

         if($this->email_sender->send_mail($mail_arr)){
           $current_timestamp = date("Y-m-d H:i:s");
           $update_task_data = [
             'email_sent_date' => $current_timestamp,
             'email_sent' => 1
           ];
           $this->approval_proc_model->update_task($row['task_id'], $update_task_data);
         }
      }
    }


    //private finctions --------------------------------------------------------

    private function start_tasks($level, $proc_data, $proc_inst_data){
      //get all approval persons belongs to selected process and level.
      //Then check which users are the eligible and start tasks fro them.
      $level_users = $this->approval_proc_model->get_proc_levels($proc_data['proc_id'], $level);
      if($level_users == null || sizeof($level_users) <= 0){ //no persons to start tasks
        return null;
      }

      foreach ($level_users as $row) {
        $can_start_task = false;

        if($row['user_selection_type'] == 'DYNAMIC'){ //no pre defined user, user id will get from a query or custom function
          $task_user_id = $this->get_dynamic_user_id($row, $proc_data, $proc_inst_data);
          $can_start_task = true;
        }
        else if($row['user_selection_type'] == 'STATIC' && $row['is_condition_based'] == 1) { //has predefined user, start task based on conditions
          $can_start_task = $this->condition_based_level_validation($row, $proc_data, $proc_inst_data);
          $task_user_id = $row['user_id'];
        }
        else if($row['user_selection_type'] == 'STATIC' && $row['is_condition_based'] == 0 ){//has pre defined user, no condition. tasks will be created for all users
          $can_start_task = true;
          $task_user_id = $row['user_id'];
        }
        else { //cannot start a task
          $can_start_task = false;
        }

        if($task_user_id == null){ //check user id has a valida value
          $can_start_task = false;
        }

        //if true, start a new task for the user
        if($can_start_task == true){
          $data = [
            'proc_inst_id' => $proc_inst_data['proc_inst_id'],
            'proc_id' => $proc_data['proc_id'],
            'level_id' => $row['id'],
            'level' => $level,
            'user_id' => $task_user_id,
            'object_id' => $proc_inst_data['object_id'],
            'active' => 1
          ];

          //will run before create a task
          $this->event_task_before_create($proc_data, $proc_inst_data, $data);

          $task_id = $this->approval_proc_model->start_task($data);
          $email_data = $this->approval_proc_model->get_task_full_data($task_id);
          $email_data['system_url'] = $this->config->item('public_url').'index.php/approval_proc/user_tasks';
          //generate approval link and reject link
          $approve_code = $this->encryption->encrypt($proc_inst_data['proc_inst_id'].'-'.$task_id.'-approve');
          $approve_code = base64_encode($approve_code);
          $reject_code = $this->encryption->encrypt($proc_inst_data['proc_inst_id'].'-'.$task_id.'-reject');
          $reject_code = base64_encode($reject_code);
          $email_data['approve_link'] = $this->config->item('public_url') .'index.php/approval_proc/process_user_response_from_email/'. $approve_code;
          $email_data['reject_link'] = $this->config->item('public_url') .'index.php/approval_proc/process_user_response_from_email/'. $reject_code;

          if($proc_data['custom_email_code'] != null){ //has a custom email format
            $custom_email_data = $this->get_custom_email_data($email_data, $proc_data, $proc_inst_data);
            if($custom_email_data != null){
              $email_data = array_merge($email_data, $custom_email_data);//merge default settings with custom data
            }
          }
          else {//no custom format, get formt from database
            $email_data['email_header'] = $this->generate_content($proc_data['email_header'], $email_data);
            $email_data['email_format'] = $this->generate_content($proc_data['email_format'], $email_data);
          }

          $update_task_data = [
            'email_header' => $email_data['email_header'],
            'email_format' => $email_data['email_format']
          ];
          $this->approval_proc_model->update_task($task_id, $update_task_data);

          //will run after create a task
          $this->event_task_after_create($proc_data, $proc_inst_data, $data);

          //chek mail queque status, if false, send email immediately
          if($proc_data['mail_queue'] == 0){
            $this->send_email($email_data, $proc_data, $proc_inst_data);
          }
        }
      }
      return $level_users;
    }


    private function condition_based_level_validation($level_data, $proc_data, $proc_inst_data){
      $can_start_task = false;

      if($level_data['condition_type'] == 'PRE_DEFINED'){//system defined validations

      }
      else if($level_data['condition_type'] == 'QUERY'){ //approval levels will be validate based on query result
        $result = $this->approval_proc_model->get_condition_query_result($level_data['condition_code'], $proc_data, $proc_inst_data);
        if($level_data['condition_value'] == $result['result']){
          $can_start_task = true;
        }
      }
      else if($level_data['condition_type'] == 'CUSTOM') {

      }
      return $can_start_task;
    }


    private function get_dynamic_user_id($level_data, $proc_data, $proc_inst_data){
      $user_id = null;

      if($level_data['user_selection_condition_type'] == 'QUERY'){
        $result = $this->approval_proc_model->get_condition_query_result($level_data['user_selection_condition_code'], $proc_data, $proc_inst_data);
        return ($result == null || $result['result'] == null) ? null : $result['result'];
      }
      else if($level_data['user_selection_condition_type'] == 'CUSTOM') {

      }
    }


    private function get_custom_email_data($task, $proc_data, $proc_inst_data){
      if($proc_data['custom_email_code'] == 'MANUAL_GP'){
        $this->load->model('gatepass_model');
        $gp = $this->gatepass_model->get_manual_gp($proc_inst_data['object_id']);

        $task['gp_header'] = $gp;
        $task['title'] = 'Approval Pending gatepass request - '.$proc_inst_data['object_id'];

        if($gp['type'] == 'laysheet transfer'){
          $task['gp_laysheets'] = $this->gatepass_model->get_manula_gp_laysheets($proc_inst_data['object_id']);
        }
        else {
          $task['gp_items'] = $this->gatepass_model->get_manula_gp_items($proc_inst_data['object_id']);
        }

        $email_format = $this->load->view('task/custom_email_formats/manual_gp_email', $task, TRUE);

        return [
          'email_header' => 'Approval Pending Manual Gatepass - ' . $proc_inst_data['object_id'],
          'email_format' =>  $email_format
        ];
      }
    }


    //process life sycle events ------------------------------------------------

    //will run after process start
    private function event_process_started($proc_data, $process_instance){

      if($proc_data['proc_code'] == 'M_GATEPASS_STYLE' || $proc_data['proc_code'] == 'M_GATEPASS_GENERAL' || $proc_data['proc_code'] == 'M_GATEPASS_LAYSHEET'){
        $sql = "UPDATE manual_gp_header SET status = ?, approved_date = ?, proc_inst_id = ? WHERE id = ?";
        $this->approval_proc_model->run_query($sql, [$process_instance['status'], null, $process_instance['proc_inst_id'], $process_instance['object_id']]);
      }
    }

    //will run before create a task
    private function event_task_before_create($proc_data, $process_instance, $task_data){

    }

    //will run after create a task
    private function event_task_after_create($proc_data, $process_instance, $task_data){

    }

    //will run before start a task
    private function event_task_before_start($proc_data, $process_instance, $task_data){

    }


    //will run after task complete
    private function event_task_completed($proc_data, $process_instance, $task_data){

    }


    //will run after process end
    private function event_process_end($proc_data, $process_instance){

      if($proc_data['proc_code'] == 'M_GATEPASS_STYLE' || $proc_data['proc_code'] == 'M_GATEPASS_GENERAL' || $proc_data['proc_code'] == 'M_GATEPASS_LAYSHEET'){
        $sql = "UPDATE manual_gp_header SET status = ?, approved_date = ? WHERE id = ?";
        $this->approval_proc_model->run_query($sql, [$process_instance['user_status'], $process_instance['end_date'], $process_instance['object_id']]);
      }

    }
}
