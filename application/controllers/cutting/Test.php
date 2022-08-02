<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Test extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->load->model('login_model');

        $this->load->model('cutting/bundle_model');
    }

    public function index() {

        $this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $this->load->view('cutting/bundle_creation', $data);
    }
}