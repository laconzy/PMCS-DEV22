<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
         $this->load->helper('form');
    }

    public function index()
    {
        $data = array();
        //$data['menu'] = $this->login_model->get_menu();
        $data['err_message'] = '';
        $this->load->view('login/login',$data);
    }

    public function error_403()
    {
        $this->load->view('common/403');
    }

    public function user_login()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() == FALSE)
        {
            $data = array('err_message' => 'Username and password cannot be empty.');
            $this->load->view('login/01_login',$data);
        }
        else
        {
            $email = $this->input->post('username');
            $password = $this->input->post('password');

           // $arr = explode('@', $email);
           // if(sizeof($arr) <= 1)
           //    $email = $email.'@helaclothing.com';

           /// $user_details = $this->login_model->find_user_by_username($username,$password);
            $user_details = $this->login_model->find_user_by_email($email,$password);
            $size = is_array($user_details);
            $data = array('login_status' => false);
            if($size > 0)
            {
                $this->session->set_userdata('username',$user_details['user_name']);
                $this->session->set_userdata('user_id',$user_details['id']);
                $this->session->set_userdata('user_level',$user_details['user_level']);
                $this->session->set_userdata('level_name',$user_details['level_name']);
                $this->session->set_userdata('department',$user_details['department']);
                $this->session->set_userdata('dep_name',$user_details['dep_name']);
                $this->session->set_userdata('permission_group_id',$user_details['permission_group']);
                $this->session->set_userdata('permission_group_name',$user_details['group_name']);
				        $this->session->set_userdata('image_name',$user_details['image_name']);
                $this->session->set_userdata('loc',$user_details['dtx_loc']);
                $this->session->set_userdata('first_name',$user_details['first_name']);
                $this->session->set_userdata('last_name',$user_details['last_name']);
                $this->session->set_userdata('site',$user_details['site']);
                $this->session->set_userdata('loged_in',true);

                $this->load->library('user_agent');
                $agent_string = $this->agent->agent_string();
                $ip_address = $this->input->ip_address();

                $audit_data = [
                  'user_id' => $user_details['id'],
                  'login_timestamp' => date("Y-m-d H:i:s"),
                  'user_agent_details' => $agent_string,
                  'ip_address' => $ip_address
                ];
                $this->login_model->save_user_login_audit($audit_data);

                $permission_group = $user_details['permission_group'];
                $this->load->model('permission_group_model');
                redirect('main');
            }
            else {
                $data = array('err_message' => 'Incorrect Email or password');
                $this->load->view('login/login',$data);
            }
        }
    }


    public function user_logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }


    public function forgot_password()
    {
        $this->load->view('login/forgot_password');
    }

    public function reset_password()
    {
        $this->load->view('login/reset_password');
    }
}
