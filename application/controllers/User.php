<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(['user_model','login_model','master/department_model','master/designation_model','master/site_model']);
         $this->load->model('permission_group_model');
         //$this->load->model('user_level_model');
         $this->load->helper('form');
    }

    public function index()
    {
        $this->login_model->user_authentication('USER_VIEW'); // user permission authentication

        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_ADMIN';
        $data['USER_VIEW'] = true;
        $data['USER_DEL'] = $this->login_model->has_permission('USER_DEL');
        $this->load->view('admin/users/users',$data);
    }

    public function new_user()
    {
        $this->login_model->user_authentication('USER_ADD'); // user permission authentication
        $data = [
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_ADMIN',
          'permission_groups' => $this->permission_group_model->get_all_permission_groups(),
          'designations' => $this->designation_model->get_all(),
          'departments' => $this->department_model->get_all(),
          'sites' => $this->site_model->get_all()
        ];
        $data['USER_ADD'] = true;
        $data['USER_EDIT'] = false;
        $this->load->view('admin/users/new_user',$data);

    }


    public function show_user($user_id)
    {
        $this->login_model->user_authentication('USER_VIEW'); // user permission authentication
        $data = [
          'user' => $this->user_model->get_user_from_id($user_id),
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_ADMIN',
          'permission_groups' => $this->permission_group_model->get_all_permission_groups(),
          'designations' => $this->designation_model->get_all(),
          'departments' => $this->department_model->get_all(),
          'sites' => $this->site_model->get_all()
        ];
        $data['USER_ADD'] = false;
        $data['USER_EDIT'] = $this->login_model->has_permission('USER_EDIT');
        $this->load->view('admin/users/new_user',$data);

    }


    /*public function open_user($id = 0)
    {
        $this->login_model->user_authentication('USER_VIEW'); // user permission authentication
        $user_levels = $this->user_level_model->get_all_user_levels();
        $departments = $this->user_model->get_departments();
        $data = [
          'id' => $id,
          'menus' => $this->login_model->get_authorized_menus(),
          'permission_groups' => $this->permission_group_model->get_all_permission_groups(),
          'designations' => $this->designation_model->get_all(),
          'departments' => $this->department_model->get_all(),
          'sites' => $this->site_model->get_all()
        ];

        $data['USER_ADD'] = false;
        $data['USER_EDIT'] = $this->login_model->has_permission('USER_EDIT');
        $this->load->view('admin/users/new_user',$data);
    }*/


    /*public function get_user()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $id = $this->input->post('id');
        $user = $this->user_model->get_user_from_id($id);
        echo json_encode($user);
    }*/


    public function get_users()
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

        $users = $this->user_model->get_users($start,$length,$search,$order_column);
        $count = $this->user_model->get_users_count($search);
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $users
        ));
    }


    public function is_username_exists()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $username = $this->input->post('value');
        $id = $this->input->post('id');
        $user = $this->user_model->get_user_from_username($username);
        $data = array();
        if($user == null || $user == false)
            $data['status'] = true;
        else
        {
            if($id == $user['id'])
                $data['status'] = true;
            else
            {
                $data['status'] = false;
                $data['message'] = 'Username already exists in the system.';
            }
        }
        echo json_encode($data);
    }


    public function is_email_exists()
    {
        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $email = $this->input->post('value');
        $id = $this->input->post('id');
        $user = $this->user_model->get_user_from_email($email);
        $data = array();
        if($user == null || $user == false)
            $data['status'] = true;
        else
        {
            if($id == $user['id'])
                $data['status'] = true;
            else
            {
                $data['status'] = false;
                $data['message'] = 'Email already exists in the system.';
            }
        }
        echo json_encode($data);
    }


    public function save_user()
    {
       // $save_status = $this->input->post('save_status');
	    //date_default_timezone_set("Asia/Kolkata");

        $data = $this->input->post('data');
        $user_id = 0;
        if($data['id'] > 0){
          $this->user_model->update($data);
          $user_id = $data['id'];
        }
        else{
          $user_id = $this->user_model->create($data);
        }

        echo json_encode([
          'status' => 'success',
          'message' => 'User details saved successfully',
          'id' => $user_id
        ]);
        //$permission = 'USER_EDIT';
        //$auth_data = $this->login_model->user_authentication_ajax($permission);
        //if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication


    }


    public function save_user_account()
    {
      /*  $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

        $data = $this->input->post('data');
        $this->user_model->update_user_account($data);

        echo json_encode([
          'status' => 'success',
          'message' => 'User details saved successfully'
        ]);
    }


    /*public function delete_user($id = 0)
    {
        $auth_data = $this->login_model->user_authentication_ajax('USER_DEL');
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

        $status = $this->user_model->delete_user($id);
        $data = array('status' => $status);
        if($status == true)
        {
            $data['message'] = 'User was deleted successfully.';
        }
        else {
            $data['message'] = 'User deleting process failed.';
        }
        echo json_encode($data);
    }*/


    public function user_account()
    {
        $this->login_model->user_authentication('USER_PROFILE');
      /*  if($auth_status != 'success'){ redirect ($auth_status); } // user permission authentication*/
        $id = $this->session->userdata('user_id');
        if($id > 0)
        {
            $departments = $this->department_model->get_all();
            $data = array('departments' => $departments);
            $data['menus'] = $this->login_model->get_authorized_menus();
            $data['profile'] = $this->user_model->get_user_details_all($id);
            $data['id'] = $id;
            $data['error'] = '';
           // $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
            $this->load->view('admin/users/user_account',$data);
        }
        else
        {
            redirect('login');
        }
    }



    private function new_user_email($username,$password)
    {
        $this->load->library('Email_Sender');

        $mail_arr = array();
        $data = array();
        $data['header1'] = 'FDN WEB';
        $data['header2'] = '';
        $data['header_text'] = 'FDN WEB New User Account';
        $data['content1'] = '<h6>Your Account Details<h6><p> Username - '.$username.' '
                . '<br> Password - '.$password.'</p>'
                . '<p><a href="'.base_url().'index.php">Click here to login</a></p>';
        $data['content2'] = '';

        $arr = array(
            'to' => $username,
            'subject' => 'FDN WEB New User Account',
            'html_data' => $data,
            'attachments' => null
        );
        array_push($mail_arr,$arr);
        return $this->email_sender->send_mail($mail_arr);
    }


    /*function upload_image($id=0)
    {
        $config['upload_path'] = 'assets/img/users/';
        //$config['allowed_types'] = 'gif|jpg|png';
        $config['allowed_types'] = 'jpg';
        $config['file_name'] = $id.'.jpg';
        $config['max_size']	= '300';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        $error = '';
        $data = array();

        if ( ! $this->upload->do_upload())
        {
                $error = $this->upload->display_errors();//array('error' => $this->upload->display_errors());
                //$this->load->view('upload_form', $error);
        }
        else
        {
            $this->user_model->update_image_name($id,$id.'.jpg');

        }

        $this->load->model('permission_group_model');
        $user_levels = $this->user_level_model->get_all_user_levels();
        $departments = $this->user_model->get_departments();
        $data = array('user_levels' => $user_levels , 'departments' => $departments);
        $data['menu'] = $this->login_model->get_menu();
        $data['id'] = $id;
        //$data['image'] = '1.jpg';
        $data['error'] = $error;
        $data['permission_groups'] = $this->permission_group_model->get_all_permission_groups();
        $this->load->view('admin/users/new_user',$data);
    }*/


    public function destroy($id){
      $this->user_model->destroy($id);
      echo json_encode([
        'status' => 'success',
        'message' => 'User deactivated successfully'
      ]);
    }

    public function search()
    {
      $search_term = $this->input->get('term');
      $data = $this->user_model->search($search_term);
      echo json_encode([
        'results' => $data
        ]);
    }

}
