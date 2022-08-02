<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_Group extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
         $this->load->model('permission_group_model');
    }

    public function index()
    {
        $this->login_model->user_authentication('PERM_GRP_VIEW'); //user authentication

        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_ADMIN';
        $data['PERM_GRP_VIEW'] = true;
        $data['PERM_GRP_DEL'] = $this->login_model->has_permission('PERM_GRP_DEL');
        $this->load->view('admin/permissions/permission_groups',$data);
    }


    public function new_permission_group()
    {
        $this->login_model->user_authentication('PERM_GRP_ADD'); //user authentication

        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_ADMIN';
        $data['all_permissions'] = [];
        $data['line_permissions'] = [];
        $data['group_id'] = 0;
        $data['group_name'] = '';
        $data['PERM_GRP_ADD'] = true;
        $data['PERM_GRP_EDIT'] = false;
        $this->load->view('admin/permissions/new_permission_group',$data);
    }



    public function open_permission_group($id)
    {
        $this->login_model->user_authentication('PERM_GRP_VIEW'); //user authentication
        $this->load->model('master/line_model');

        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_ADMIN';
        $data['group'] =  $this->permission_group_model->get_permission_group($id);
        $data['all_permissions'] = $this->permission_group_model->get_all_permissions($id);
        $data['line_permissions'] = $this->permission_group_model->get_all_line_permissions($id);
        $data['PERM_GRP_ADD'] = false;
        $data['PERM_GRP_EDIT'] = $this->login_model->has_permission('PERM_GRP_EDIT');
        $this->load->view('admin/permissions/new_permission_group',$data);
    }


    public function is_group_exists(){
  		try{
  			$group_name = $this->input->post('data_value');
  			$group_id = $this->input->post('group_id');
  			$group_count = $this->permission_group_model->count_groups_from_name($group_name,$group_id);
  			if($group_count > 0){
  				echo json_encode(array(
  					'status' => 'error',
  					'message' => 'Group name already exists'
  				));
  			}
  			else{
  				echo json_encode(array(
  					'status' => 'success',
  					'message' => ''
  				));
  			}
  		}
  		catch(Exception $e){
  			echo json_encode(array(
  				'status' => 'error',
  				'message' => 'System process error'
  			));
  		}
  	}


    /*public function get_permissions_group()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $id = $this->input->post('group_id');
        $data = array();
        $data['group_details'] = $this->permission_group_model->get_permission_group($id);
        $data['group_permissions'] = $this->permission_group_model->get_group_permissions($id);
        echo json_encode($data);
    }*/

    public function get_permissions($id)
    {
        echo json_encode([
          'data' => $this->permission_group_model->get_group_permissions($id)
        ]);
    }


    public function get_permissions_groups()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $data = $_GET;
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];
        $search = $data['search']['value'];
        $order = $data['order'][0];
        $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

        $groups = $this->permission_group_model->get_permissions_groups($start,$length,$search,$order_column);
        $count = $this->permission_group_model->get_permissions_groups_count($search);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $groups
        ));
    }


    public function save_permission_group()
    {
        $data = $this->input->post('data');
        $group_id = 0;
        if($data['group_id'] > 0){
          $this->permission_group_model->update($data);
          $group_id = $data['group_id'];
        }
        else{
          $group_id = $this->permission_group_model->create($data);
        }

        /*$permission = $group_id > 0 ? 'PERM_GRP_EDIT' : 'PERM_GRP_ADD';
        $auth_data = $this->login_model->user_authentication_ajax($permission);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

        echo json_encode([
          'status' => 'success',
          'message' => 'Permission group details saved successfully',
          'group_id' => $group_id
        ]);
    }


    /*public function get_menu_list()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $data = $this->permission_group_model->get_all_menu_list();
        echo json_encode($data);
    }*/


    /*public function get_all_permission_groups()
    {
        $auth_data = $this->login_model->user_authentication(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission authentication

        $data = $this->permission_group_model->get_all_permission_groups();
        echo json_encode($data);
    }*/


    public function destroy($group_id){
      $this->permission_group_model->destroy($group_id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Permission group deactivated successfully'
      ]);
    }

    //**********************************************************************

    public function get_all_permissions()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $data = $this->permission_group_model->get_all_permissions();
        echo json_encode($data);
    }


    public function modify_permissions()
    {
        /*$auth_data = $this->login_model->user_authentication('PERM_GRP_EDIT');
        if($auth_data != null){ echo json_encode($auth_data);return false;} // user permission authentication*/

        $id = $this->input->get('group_id');
        $status = $this->input->get('status');
        $permission_code = $this->input->get('permission_code');
        $data = array('status' => '');
        $res = $this->permission_group_model->modify_permissions($id,$permission_code,$status);
        if($res == true)
            $data['status'] = 'success';
        else
            $data['status'] = 'error';
        echo json_encode($data);
    }


    public function modify_line_permissions()
    {
        $id = $this->input->get('group_id');
        $status = $this->input->get('status');
        $line_id = $this->input->get('line_id');
        $data = array('status' => '');
        $res = $this->permission_group_model->modify_line_permissions($id,$line_id,$status);
        if($res == true)
            $data['status'] = 'success';
        else
            $data['status'] = 'error';
        echo json_encode($data);
    }

}
