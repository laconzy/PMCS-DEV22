<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function user_authentication($permission = null)
    {
        $username = $this->session->userdata('username');
        $logedin = $this->session->userdata('loged_in');
        if($username == null || $username == false || $logedin == false)
            redirect('login');

        if($permission != null){
            $status = $this->has_permission($permission);
            if($status == false)
                redirect('login/error_403');
        }
    }


    public function user_authentication_ajax($permission = null)
    {
        $username = $this->session->userdata('username');
        $logedin = $this->session->userdata('loged_in');
        if($username == null || $username == false || $logedin == false) {
            return array('status'=>'error','message'=>'Session Expired. You must login again.');
        }
        if($permission != null){
            $status = $this->has_permission($permission);
            if($status == false)
                return array('status'=>'error','message'=>'Access Denied');
        }
        return null;
    }



    public function find_user_by_username($username = '',$password = '')
    {
       $query = $this->db->query("SELECT a.*,b.level_name,c.dep_name,p.group_name FROM user a "
                . "LEFT JOIN user_levels b ON a.user_level=b.level_id "
                . "LEFT JOIN permission_groups p ON a.permission_group=p.group_id "
                . "LEFT JOIN departments c ON a.department=c.dep_id WHERE a.user_name='".$username."' AND a.password=MD5('".$password."')");
       return $query->row_array();
    }


    public function find_user_by_email($email = '',$password = '')
    {
        $query = $this->db->query("SELECT a.*,b.level_name,c.dep_name,p.group_name FROM user a "
                . "LEFT JOIN user_levels b ON a.user_level=b.level_id "
                . "LEFT JOIN permission_groups p ON a.permission_group=p.group_id "
                . "LEFT JOIN departments c ON a.department=c.dep_id WHERE a.email='".$email."' AND a.password=MD5('".$password."')");
       return $query->row_array();
    }



    public function has_permission($permission) {
        $group_id = $this->session->userdata('permission_group_id');
        $this->db->where('group_id', $group_id);
        $this->db->where('permission_code', $permission);
        $this->db->from('permission_group_permissions');
        $count = $this->db->count_all_results();
        if($count > 0)
            return true;
        else
            return false;
    }


    public function get_authorized_menus()
    {
        $group_id = $this->session->userdata('permission_group_id');
        $query = $this->db->query('SELECT * FROM menu ORDER BY order_no');
        $menus = $query->result_array();
        for($x = 0 ; $x < sizeof($menus) ; $x++) {
            $sql = "SELECT ms.sub_menu_code,ms.sub_menu_name,ms.sub_menu_url,ms.sub_menu_parent,ms.sub_menu_icon "
                    . "FROM menu_sub AS ms INNER JOIN permission_group_permissions AS pg "
                    . "ON ms.sub_menu_permission = pg.permission_code WHERE pg.group_id = " . $group_id
                    . " AND ms.sub_menu_parent = '". $menus[$x]['menu_code'] ."' ORDER BY ms.order_no ASC
";
            $query = $this->db->query($sql);
            $sub_menu = $query->result_array();
            $menus[$x]['sub_menus'] = $sub_menu;

        }
        //echo json_encode($menus);
        return $menus;
    }


    public function save_user_login_audit($data){
      if($data != null && $data != false){
        $this->db->insert('user_login_audit', $data);
      }
    }


    public function get_authorized_lines(){
      $group_id = $this->session->userdata('permission_group_id');
      $sql = "SELECT
      permission_group_line_permissions.*,
      line.line_code
      FROM permission_group_line_permissions
      INNER JOIN line ON line.line_id = permission_group_line_permissions.line_id
      WHERE permission_group_line_permissions.group_id = ".$group_id;
      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function get_authorized_lines_by_site_and_category($site_id, $category){
      $group_id = $this->session->userdata('permission_group_id');
      $sql = "SELECT
      permission_group_line_permissions.*,
      line.line_code
      FROM permission_group_line_permissions
      INNER JOIN line ON line.line_id = permission_group_line_permissions.line_id
      WHERE permission_group_line_permissions.group_id = ".$group_id." AND line.location = ".$site_id." AND line.category = '".$category."'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function get_authorized_lines_by_site_and_category_list($site_id, $category){
      $group_id = $this->session->userdata('permission_group_id');
      $sql = "SELECT
      permission_group_line_permissions.*,
      line.line_code
      FROM permission_group_line_permissions
      INNER JOIN line ON line.line_id = permission_group_line_permissions.line_id
      WHERE permission_group_line_permissions.group_id = ".$group_id." AND line.location = ".$site_id." AND line.category IN ('".$category."')";
      $query = $this->db->query($sql);
      return $query->result_array();
    }


}
