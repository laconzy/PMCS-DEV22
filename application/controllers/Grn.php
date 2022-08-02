<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grn extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('grn_model');
    }

    public function index()
    {
    	  $this->login_model->user_authentication('PROD_EMB_GRN'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $this->load->view('grn/grn',$data);
    }


    public function show($id = 0)
    {
      	$this->login_model->user_authentication('PROD_EMB_GRN'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['grn_no'] = $id;
        $this->load->view('grn/grn',$data);
    }


    public function listing()
    {
      	$this->login_model->user_authentication('PROD_EMB_GRN'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $this->load->view('grn/grn_list',$data);
    }


    public function get_contract_aods($contract_no)
    {
      echo json_encode([
        'data' => $this->grn_model->get_contract_aods($contract_no)
      ]);
    }


    public function save(){
        /*$auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

        $data = $this->input->post('form_data');
        $grn_no = 0;
        if($data['grn_no'] > 0){ //update
          $this->grn_model->update($data);
          $grn_no = $data['grn_no'];
        }
        else{ //insert
          $grn_no = $this->grn_model->create($data);
        }
        echo json_encode(array(
          'status' => 'success',
          'message' => 'GRN details saved successfully.',
          'grn' => $this->grn_model->get_grn($grn_no)
        ));
    }


    public function get_aod_bundles($aod_no){
      echo json_encode([
        'data' => $this->grn_model->get_aod_bundles($aod_no)
      ]);
    }


    public function get_grn_bundles($grn_no){
      echo json_encode([
        'data' => $this->grn_model->get_grn_bundles($grn_no)
      ]);
    }


    public function add_selected_barcodes(){
      $barcodes = $this->input->post('barcodes');
      $grn_no = $this->input->post('grn_no');
      $aod_no = $this->input->post('aod_no');
      $this->grn_model->add_selected_barcodes($grn_no , $aod_no , $barcodes);
      echo json_encode([
        'status' => 'success',
        'message' => 'Bundles successfully added to grn'
      ]);
    }


    public function remove_barcodes(){
      $barcodes = $this->input->post('barcodes');
      $grn_no = $this->input->post('grn_no');
      $this->grn_model->remove_barcodes($grn_no, $barcodes);
      echo json_encode([
        'status' => 'success',
        'message' => 'Bundles successfully removed from grn'
      ]);
    }


    public function get_grn($grn_no = 0){
      echo json_encode([
        'data' => $this->grn_model->get_grn($grn_no)
      ]);

    }


    public function get_grns()
    {
       /* $auth_data = $this->login_model->user_authentication_ajax(null);
          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication*/

          $data = $_POST;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];

          $grns = $this->grn_model->get_grns($start,$length,$search,$order_column);
          $count = $this->grn_model->get_grns_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $grns
          ));
      }


      public function destroy($grn_no){
        $this->grn_model->destroy($grn_no);
        echo json_encode([
          'status' => 'success',
          'message' => 'Embellishment GRN deactivated successfully'
        ]);
      }


      public function search()
      {
        $search_term = $this->input->get('term');
        $data = $this->color_model->search($search_term);
        echo json_encode([
          'results' => $data
          ]);
      }

}
