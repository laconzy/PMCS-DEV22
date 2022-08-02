<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_user_from_username($username)
    {
        $query = $this->db->query("SELECT a.*,b.level_name,c.dep_name FROM user a "
                . "LEFT JOIN user_levels b ON a.user_level=b.level_id "
                . "LEFT JOIN departments c ON a.department=c.dep_id WHERE a.user_name='".$username."'");
        return $query->row_array();
    }


    public function get_user_from_email($email)
    {
        $query = $this->db->query("SELECT a.*,b.level_name,c.dep_name,p.group_name FROM user a "
                . "LEFT JOIN user_levels b ON a.user_level=b.level_id "
                . "LEFT JOIN permission_groups p ON a.permission_group=p.group_id "
                . "LEFT JOIN departments c ON a.department=c.dep_id WHERE a.email='".$email."'");
        return $query->row_array();
    }


    public function get_user_from_id($id)
    {
        $query = $this->db->query("SELECT a.*,b.level_name,c.dep_name FROM user a "
                . "LEFT JOIN user_levels b ON a.user_level=b.level_id "
                . "LEFT JOIN departments c ON a.department=c.dep_id WHERE a.id='".$id."'");
        return $query->row_array();
    }


	public function get_user_details_all($id)
    {
        $sql = "SELECT `user`.*,departments.dep_name,pmcs_designation.designation,site.site_name FROM user
          INNER JOIN departments ON `user`.department = departments.dep_id
          INNER JOIN pmcs_designation ON `user`.designation = pmcs_designation.des_id
          INNER JOIN site ON `user`.site = site.id
          WHERE `user`.id = ?";
        $query = $this->db->query($sql , [$id]);
        return $query->row_array();
    }




    public function get_users($start,$limit,$search,$order)
    {
      $sql = "SELECT user.id,user.first_name,user.last_name,user.email,user.contact_no,user.active,departments.dep_name,
              pmcs_designation.designation,permission_groups.group_name FROM user
              INNER JOIN departments ON user.department = departments.dep_id
              INNER JOIN pmcs_designation ON user.designation = pmcs_designation.des_id
              INNER JOIN permission_groups ON user.permission_group = permission_groups.group_id
              WHERE user.id LIKE '%".$search."%' OR user.first_name LIKE '%".$search."%' OR user.last_name LIKE '%".$search."%' OR user.email LIKE '%".$search."%' OR
              departments.dep_name LIKE '%".$search."%' OR pmcs_designation.designation LIKE '%".$search."%' OR permission_groups.group_name LIKE '%".$search."%'
              ORDER BY ".$order." LIMIT ".$start.",".$limit;
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function get_users_count($search)
    {
        $sql = "SELECT COUNT(user.id) row_count  FROM user
              INNER JOIN departments ON user.department = departments.dep_id
              INNER JOIN pmcs_designation ON user.designation = pmcs_designation.des_id
              INNER JOIN permission_groups ON user.permission_group = permission_groups.group_id
              WHERE user.id LIKE '%".$search."%' OR user.first_name LIKE '%".$search."%' OR user.last_name LIKE '%".$search."%' OR user.email LIKE '%".$search."%' OR
              departments.dep_name LIKE '%".$search."%' OR pmcs_designation.designation LIKE '%".$search."%' OR permission_groups.group_name LIKE '%".$search."%'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['row_count'];

    }


    /*public function insert_new_user($user_act)
    {
        try{
            $data = array(
                'user_name' => $this->input->post('user_name'),
                'password' => md5($this->input->post('password')),
                'user_level' => $this->input->post('user_level'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_no' => $this->input->post('contact_no'),
                'email' => $this->input->post('email'),
                'status' => 'active',
                'department' => $this->input->post('department'),
                'permission_group' => $this->input->post('permission_group'),
				'dtx_epfno' => $this->input->post('dtx_epfno'),
				'dtx_name_initials' => $this->input->post('dtx_name_initials'),
				'dtx_nic' => $this->input->post('dtx_nic'),
				'dtx_staff_cat' => $this->input->post('dtx_staff_cat'),
				'dtx_designation' => $this->input->post('dtx_designation'),
				'dtx_loc' => $this->input->post('dtx_loc'),
				'dtx_user_activity' => $user_act,
				'dtx_grade' => $this->input->post('dtx_grade'),
				'dtx_payrol_loc' => $this->input->post('dtx_payrol_loc')


            );
            $this->db->insert('user',$data);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }*/


    public function create($data)
    {
          $insert_data = array(
            'user_name' => $data['user_name'],
            'password' => md5($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_no' => $data['contact_no'],
            'email' => $data['email'],
            'active' => $data['active'],
            'department' => $data['department'],
            'permission_group' => $data['permission_group'],
    				'epf_no' => $data['epf_no'],
    				'nic' => $data['nic'],
    				'designation' => $data['designation'],
    				'site' => $data['site']
          );
          $this->db->insert('user',$insert_data);
          return $this->db->insert_id();
    }


    public function update($data)
    {
          $update_data = array(
            'user_name' => $data['user_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_no' => $data['contact_no'],
            'email' => $data['email'],
            'active' => $data['active'],
            'department' => $data['department'],
            'permission_group' => $data['permission_group'],
    				'epf_no' => $data['epf_no'],
    				'nic' => $data['nic'],
    				'designation' => $data['designation'],
    				'site' => $data['site']
          );
          if($data['password'] != null && $data['password'] != ''){
            $update_data['password'] = md5($data['password']);
          }
          $this->db->where('id',  $data['id']);
          $this->db->update('user',$update_data);
          return $this->db->insert_id();
    }


    public function destroy($id)
    {
  		$this->db->where('id', $id);
  		$this->db->update('user', array('active' => 'N'));
  		return true;
    }


    /*public function update_user($user_act)
    {
        try{
            $data = array(
                'user_name' => $this->input->post('user_name'),
                'user_level' => $this->input->post('user_level'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_no' => $this->input->post('contact_no'),
                'email' => $this->input->post('email'),
                'status' => 'active',
                'department' => $this->input->post('department'),
                'permission_group' => $this->input->post('permission_group'),
				'dtx_epfno' => $this->input->post('dtx_epfno'),
				'dtx_name_initials' => $this->input->post('dtx_name_initials'),
				'dtx_nic' => $this->input->post('dtx_nic'),
				'dtx_staff_cat' => $this->input->post('dtx_staff_cat'),
				'dtx_designation' => $this->input->post('dtx_designation'),
				'dtx_loc' => $this->input->post('dtx_loc'),
				'dtx_user_activity' => $user_act,
				'dtx_grade' => $this->input->post('dtx_grade'),
				'dtx_payrol_loc' => $this->input->post('dtx_payrol_loc')

            );
            if($this->input->post('password') != '')
                $data['password'] = md5($this->input->post('password'));

            $this->db->where('id',  $this->input->post('id'));
            $this->db->update('user',$data);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }*/



    public function update_user_account($data)
    {
          $insert_data = array(
              'first_name' =>$data['first_name'],
              'last_name' => $data['last_name'],
              'contact_no' => $data['contact_no'],
          );
          if($data['password'] != '')
              $insert_data['password'] = md5($data['password']);

          $this->db->where('id',  $data['id']);
          $this->db->update('user',$insert_data);
          return true;
    }


    /*public function delete_user($id)
    {
       try{
           $this->db->delete('user',array('id' => $id));
           return true;
       } catch (Exception $ex) {
           return false;
       }
    }*/





    public function get_all_users()
    {
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function search($search)
    {
      $this->db->select("id,CONCAT(first_name, ' ', last_name) as text");
      $this->db->from('user');
      $this->db->like('first_name', $search, 'after');
      $query = $this->db->get();
      return $query->result_array();
    }

}
