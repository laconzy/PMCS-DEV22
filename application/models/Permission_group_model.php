<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_Group_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_all_permission_groups()
    {
        $this->db->select('*');
        $this->db->from('permission_groups');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_menu_list()
    {
        $this->db->select('*');
        $this->db->from('menu_list');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function count_groups_from_name($group_name,$group_id){
      $this->db->where('group_name', $group_name);
      $this->db->where('group_id !=', $group_id);
      $this->db->from('permission_groups');
      return $this->db->count_all_results();
    }


    public function create($data)
    {
        $current_timestamp = date("Y-m-d H:i:s");
        $current_user = $this->session->userdata('user_id');
        $data['created_at'] = $current_timestamp;
        $data['updated_at'] = $current_timestamp;
        $data['created_user'] = $current_user;
        $data['updated_user'] = $current_user;
        $this->db->insert('permission_groups',$data);
        return $this->db->insert_id();
    }


    public function update($data)
    {
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['updated_user'] = $this->session->userdata('user_id');
        $this->db->where('group_id',$data['group_id']);
        $this->db->update('permission_groups',$data);
        return true;
    }


    public function destroy($id)
    {
       try{
          $this->db->where('group_id' , $id);
           $this->db->update('permission_groups',array('active' => 'N'));
           return true;
       } catch (Exception $ex) {
           return false;
       }
    }


    public function get_permission_group($id)
    {
        $this->db->select('*');
        $this->db->from('permission_groups');
        $this->db->where('group_id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function get_group_permissions($id)
    {
        /*$this->db->select('*');
        $this->db->from('group_permissions');
        $this->db->where('group_id',$id);
        $query = $this->db->get();*/
        /*$query = $this->db->query("SELECT a.*,b.menu_text FROM group_permissions a,menu_list b WHERE a.group_id=".$id." AND "
                . "a.menu_id=b.menu_id");*/
        $query = $this->db->query("SELECT a.menu_id,a.menu_text,b.permission_status,b.group_id FROM menu a "
                . "LEFT JOIN permission_group_permissions b ON a.menu_id=b.menu_id AND b.group_id=".$id);
        return $query->result_array();
    }


    public function get_permissions_groups($start,$length,$search,$order_column)
    {
        $query = $this->db->query("SELECT * FROM permission_groups WHERE group_id LIKE '%".$search."%' OR group_name LIKE '%".$search."%' "
                . "ORDER BY ".$order_column." LIMIT ".$start.",".$length);
        return $query->result_array();
    }


    public function get_permissions_groups_count($search)
    {
        $query = $this->db->query("SELECT COUNT(group_id) AS row_count FROM permission_groups WHERE group_id LIKE '%".$search."%' OR group_name LIKE '%".$search."%'");
        $res = $query->row_array();
        return $res['row_count'];
    }



	//  ----------   DTX ---------------------


	public function get_all_designations()
    {
        $this->db->select('*');
        $this->db->from('pmcs_designation');
		$this->db->order_by('pmcs_designation.designation ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

	public function get_all_staff_category()
    {

        $this->db->select('*');
        $this->db->from('pmcs_staff_category');
        $query = $this->db->get();
        return $query->result_array();
    }


	public function hela_location_load()
    {
        $this->db->select('*');
        $this->db->from('pmcs_location');
        $query = $this->db->get();
        return $query->result_array();
    }

	//  ----------   DTX ---------------------



    public function get_all_permissions($group_id)
    {
        $query = $this->db->query('SELECT * FROM permission_category');
        $cats = $query->result_array();
        for($x = 0 ; $x < sizeof($cats) ; $x++){
            if($group_id == 0){
                $sql = "SELECT p.*,0 as permission_status FROM permission AS p "
                        . "WHERE p.permission_category = '" . $cats[$x]['cat_code']."'";
            }
            else{
                $sql = "SELECT p.*,(
                    SELECT COUNT(pg.group_id) FROM permission_group_permissions pg
                    WHERE pg.permission_code=p.permission_code AND pg.group_id = ".$group_id."
                    ) AS permission_status
                    FROM permission AS p WHERE p.permission_category = '" . $cats[$x]['cat_code'] . "'";
            }
            $query = $this->db->query($sql);
            $permissions = $query->result_array();
            $cats[$x]['permissions'] = $permissions;
        }
        return $cats;
    }


    public function modify_permissions($id,$permission_code,$status){
        try{
            if($status == 'ADD'){
                $arr = array(
                    'group_id' => $id,
                    'permission_code' => $permission_code
                );
                $this->db->insert('permission_group_permissions', $arr);
            }
            else if($status == 'REMOVE'){
                $this->db->where('group_id', $id);
                $this->db->where('permission_code', $permission_code);
                $this->db->delete('permission_group_permissions');
               /* $this->db->delete('permission_group_permissions', $arr); */
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }


    public function get_all_line_permissions($group_id)
    {
        $sql = "SELECT line.*,(
          SELECT COUNT(lp.group_id) FROM permission_group_line_permissions lp
          WHERE lp.line_id=line.line_id AND lp.group_id = ".$group_id."
          ) AS permission_status
          FROM line";
        $query = $this->db->query($sql);
        $permissions = $query->result_array();
        return $permissions;
    }


    public function modify_line_permissions($id,$line_id,$status){
        try{
            if($status == 'ADD'){
                $arr = array(
                    'group_id' => $id,
                    'line_id' => $line_id
                );
                $this->db->insert('permission_group_line_permissions', $arr);
            }
            else if($status == 'REMOVE'){
                $this->db->where('group_id', $id);
                $this->db->where('line_id', $line_id);
                $this->db->delete('permission_group_line_permissions');          
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

}
