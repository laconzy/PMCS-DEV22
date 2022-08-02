<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Production extends CI_Controller {


     public function __construct()

    {

         parent::__construct();

         $this->load->model('login_model');

		     $this->load->model('master/color_model');
         $this->load->model('cutting/bundle_model');
         $this->load->model('fg/fg_model');
         $this->load->model(['production/production_model', 'master/line_model']);

    }



    public function index()

    {

    	   $this->login_model->user_authentication('MASTER_COLOUR');//check permission

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_MASTER';

        $this->load->view('master/colour/colour_list',$data);

    }

     public function cutting_out() {
        $this->login_model->user_authentication('PROD_CUT_OUT'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['operation'] = 1;
        $data['previous_operation'] = 0;
        $data['operation_name'] = 'Cutting Out';
        $data['lines'] = $this->login_model->get_authorized_lines();//$this->line_model->get_all();
        //$this->load->view('master/colour/colour_list',$data);
        $this->load->view('production/production', $data);
    }


     public function supermarket_in() {
        $this->login_model->user_authentication('PROD_SUPMKR_IN'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['operation'] = 2;
        $data['previous_operation'] = 13;
        $data['operation_name'] = 'Supermarket In';
        $data['lines'] = $this->login_model->get_authorized_lines();
        $this->load->view('production/production', $data);
    }


public function preparation() {

        $this->login_model->user_authentication('PROD_PREP'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 12;

        $data['previous_operation'] = 1;

        $data['operation_name'] = 'PREPARATION';

        $data['lines'] = $this->login_model->get_authorized_lines();

        $this->load->view('production/production', $data);
    }

    public function placket() {

        $this->login_model->user_authentication('PROD_PREP'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 13;

        $data['previous_operation'] = 15;

        $data['operation_name'] = 'PLACKET';

        $data['lines'] = $this->login_model->get_authorized_lines();

        $this->load->view('production/production', $data);
    }

     public function heat_seal() {

        $this->login_model->user_authentication('PROD_PREP'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 14;

        $data['previous_operation'] = 12;

        $data['operation_name'] = 'HEAT_SEAL';

        $data['lines'] = $this->line_model->get_all();

        $this->load->view('production/production', $data);
    }

    public function binding() {

        $this->login_model->user_authentication('PROD_PREP'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 15;

        $data['previous_operation'] = 14;

        $data['operation_name'] = 'FUSING';

        $data['lines'] = $this->login_model->get_authorized_lines();

        $this->load->view('production/production', $data);
    }

    public function supermarket_out() {

        $this->login_model->user_authentication('PROD_SUPMKR_OUT'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 3;

        $data['previous_operation'] = 2;

        $data['operation_name'] = 'Supermarket Out';

        $data['lines'] = $this->login_model->get_authorized_lines();

        $this->load->view('production/production', $data);
    }

    public function line_out() {

        $this->login_model->user_authentication('PROD_LINE_OUT'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['operation'] = 4;

        $data['previous_operation'] = 3;

        $data['operation_name'] = 'Line Out';

        $data['lines'] = $this->login_model->get_authorized_lines();

        $this->load->view('production/production', $data);
    }


    public function manual_line_out() {
        $this->login_model->user_authentication('PROD_M_LINE_OUT'); // user permission authentication\
         //$data['site'] = $this->bundle_model->site();
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['operation'] = 4;
        $data['previous_operation'] = 3;
        $data['operation_name'] = 'Line Out';
        $data['lines'] = $this->login_model->get_authorized_lines();
        $data['site'] = $this->line_model->site();
        $this->load->view('production/manual_line out', $data);
    }

    /*public function scan_barcode() {
        //$order_id = $this->input->post('order_id');
        $barcode = $this->input->post('barcode');
        $operation = $this->input->post('operation');
        //$operation_point = $this->input->post('operation_point');
        $previous_operation = null;//$this->input->post('previous_operation');
        $line_no = $this->input->post('line_no');
        $shift_no = $this->input->post('shift_no');
        $scan_date = $this->input->post('scan_date');
        $shift_type = $this->input->post('shift_type');

        if ($operation == 1) {//this is first operation and bundle get from cutting
            $bundle = $this->production_model->get_cut_bundle($barcode);
            //print_r($bundle2);
            if ($bundle == null && $bundle == false) {
                $bundle = $this->production_model->get_cut_bundle_2($barcode);
            }
            if ($bundle == null && $bundle == false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Incorrect barcode no'
                ]);
            } else {
                //$is_exists = $this->production_model->is_barcode_exists($order_id,$operation,$operation_point,$bundle['barcode']);
                $is_exists = $this->production_model->is_barcode_exists($operation, $bundle['barcode']);
                if ($is_exists) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Barcode already scanned'
                    ]);
                } else {

                    $order_data = $this->production_model->get_order($bundle['order_id']);
                    if($order_data != null && $order_data['is_complete'] == 1){
                      echo json_encode([
                          'status' => 'error',
                          'message' => 'Cannot scan barcode. Order was already completed.'
                      ]);
                      return;
                    }

                    //find previous operation
                    $previous_op_data = $this->production_model->get_previous_operation($bundle['style'], $operation);
                    if($previous_op_data != null){
                      $previous_operation = $previous_op_data['operation_id'];
                    }

                    //$this->production_model->add_item_to_production($bundle,$operation,$operation_point,$line_no);
                    $this->production_model->add_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$previous_operation, $shift_type);

                    if($previous_operation != null){
                      //complete previous operation
                      $this->production_model->complete_production_operation($barcode, $previous_operation);
                    }


                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Added successfully',
                        //'data' => $this->production_model->get_bundle_from_production($order_id,$operation,$operation_point,$bundle['barcode'])
                        'data' => $this->production_model->get_bundle_from_production($operation, $bundle['barcode'])
                    ]);
                }
            }
        } else { //not the first operation and bundle get from the production
          //find previous operation
          $previous_op_data = $this->production_model->get_previous_operation($bundle['style'], $operation);
          if($previous_op_data != null){
            $previous_operation = $previous_op_data['operation_id'];
          }

            $bundle = $this->production_model->get_bundle_from_production($previous_operation, $barcode);

            if ($bundle == null || $bundle == false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Incorrect barcode no'
                ]);
            } else {

                $is_exists = $this->production_model->is_barcode_exists($operation, $bundle['barcode']);

                if ($is_exists) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Barcode already scanned'
                    ]);
                } else {

                  if($bundle['is_order_complete'] == 1){
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Cannot scan barcode. Order was already completed.'
                    ]);
                    return;
                  }

                  $this->production_model->add_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$previous_operation);
                  if($previous_operation != null){
                    //complete previous operation
                    $this->production_model->complete_production_operation($barcode, $previous_operation);
                  }

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Added successfully',
                        'data' => $this->production_model->get_bundle_from_production($operation, $bundle['barcode'])
                    ]);
                }
            }
        }
    }*/

    public function scan_barcode() {
        $barcode = $this->input->post('barcode');
        $operation = $this->input->post('operation');
        $previous_operation = null;//$this->input->post('previous_operation');
        $line_no = $this->input->post('line_no');
        $shift_no = $this->input->post('shift_no');
        $scan_date = $this->input->post('scan_date');
        $shift_type = $this->input->post('shift_type');

        $bundle = $this->production_model->get_cut_bundle($barcode);
        if ($bundle == null && $bundle == false) {
            $bundle = $this->production_model->get_cut_bundle_2($barcode);
        }

        if ($bundle == null && $bundle == false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect barcode no'
            ]);
            return;
        }

        $operation_data = $this->production_model->get_style_operation($bundle['style'], $operation);
        if($operation_data == null){
          echo json_encode([
              'status' => 'error',
              'message' => 'This operation is not allocated to the scanned barcode style'
          ]);
          return;
        }

        $is_exists = $this->production_model->is_barcode_exists($operation, $bundle['barcode']);
        if ($is_exists) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Barcode already scanned'
            ]);
            return;
        }

        $order_data = $this->production_model->get_order($bundle['order_id']);
        if($order_data != null && $order_data['is_complete'] == 1){
          echo json_encode([
              'status' => 'error',
              'message' => 'Cannot scan barcode. Order was already completed.'
          ]);
          return;
        }

        //find previous operation
        $previous_op_data = $this->production_model->get_previous_operation($bundle['style'], $operation);
        //echo json_encode($previous_op_data);die();
        if($previous_op_data != null){ //has previous operation
          $previous_operation = $previous_op_data['operation_id'];

          $bundle = $this->production_model->get_bundle_from_production($previous_operation, $barcode);
          if ($bundle == null || $bundle == false) {
              echo json_encode([
                  'status' => 'error',
                  'message' => 'This barcode was still not scanned in the previous operation. So, cannot continue.'
              ]);
              return;
          }
          $this->production_model->add_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$previous_operation, $shift_type);
          $this->production_model->complete_production_operation($barcode, $previous_operation);//complete previous operation
        }
        else { //no previous operation
          $this->production_model->add_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$previous_operation, $shift_type);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Added successfully',
            'data' => $this->production_model->get_bundle_from_production($operation, $bundle['barcode'])
        ]);
    }



    //this function for manual barcode
    public function scan_manual_barcode() {

        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
        $barcode = $this->input->post('barcode');
        $operation = $this->input->post('operation');
        $previous_operation = null;//$this->input->post('previous_operation');
        $line_no = $this->input->post('line_no');
        $shift_no = $this->input->post('shift_no');
        $scan_date = $this->input->post('scan_date');
        $site = $this->input->post('site');
        $location = $this->input->post('location');
        $hour = $this->input->post('hour');
        $shift_type = $this->input->post('shift_type');

        //$bundle = $this->production_model->get_barcode_data($barcode);
        $bundle = $this->production_model->get_barcode_data2($barcode, $line_no);
        if ($bundle == null || $bundle == false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect barcode no'
            ]);
            return;
        }

	      $total_qty = $bundle[0]['out_qty'] + $bundle[0]['qty'];
				if($total_qty>$bundle[0]['qty_in']){
					echo json_encode([
						'status' => 'error',
						'message' => 'Cant Scan more than Line In QTY'
					]);
					return;
				}

        $is_exists = $this->production_model->is_barcode_exists($operation, $bundle[0]['barcode_no']);
        if ($is_exists) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Barcode already scanned'
            ]);
            return;
        }

        $order_data = $this->production_model->get_order($bundle[0]['order_id']);
        if($order_data != null && $order_data['is_complete'] == 1){
          echo json_encode([
            'status' => 'error',
            'message' => 'Cannot scan barcode. Order was already completed.'
          ]);
          return;
        }

        $this->production_model->add_manual_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$location,$site, $hour, $shift_type);

        echo json_encode([
            'status' => 'success',
            'message' => 'Added successfully',
            //'data' => $this->production_model->get_bundle_from_production($order_id,$operation,$operation_point,$bundle['barcode'])
            'data' => $this->production_model->get_bundle_from_production($operation, $bundle[0]['barcode_no'])
        ]);

    }


























    /*public function scan_manual_barcode() {

        $auth_data = $this->login_model->user_authentication_ajax(null);
        if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
        //$order_id = $this->input->post('order_id');
        $barcode = $this->input->post('barcode');
        $operation = $this->input->post('operation');
        //$operation_point = $this->input->post('operation_point');
        $previous_operation = null;//$this->input->post('previous_operation');
        $line_no = $this->input->post('line_no');
        $shift_no = $this->input->post('shift_no');
        $scan_date = $this->input->post('scan_date');
        $site = $this->input->post('site');
        $location = $this->input->post('location');
        $hour = $this->input->post('hour');
        $shift_type = $this->input->post('shift_type');

        if ($operation == 4) {//this is first operation and bundle get from barocode table
            $bundle = $this->production_model->get_barcode_data($barcode);
            //$bundle = $this->production_model->get_barcode_data2($barcode, $line_no);
            if ($bundle == null || $bundle == false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Incorrect barcode no'
                ]);
            }
            else {
				      $total_qty=$bundle[0]['out_qty']+$bundle[0]['qty'];
      				if($total_qty>$bundle[0]['qty_in']){
      					echo json_encode([
      						'status' => 'error',
      						'message' => 'Cant Scan more than Line In QTY'
      					]);
      					return;
      				}

              $is_exists = $this->production_model->is_barcode_exists($operation, $bundle[0]['barcode_no']);
              if ($is_exists) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Barcode already scanned'
                    ]);
                }
                else {

                    $order_data = $this->production_model->get_order($bundle[0]['order_id']);
                    if($order_data != null && $order_data['is_complete'] == 1){
                      echo json_encode([
                        'status' => 'error',
                        'message' => 'Cannot scan barcode. Order was already completed.'
                      ]);
                      return;
                    }

                    //find previous operation
                    $previous_op_data = $this->production_model->get_previous_operation($bundle['style'], $operation);
                    if($previous_op_data != null){
                      $previous_operation = $previous_op_data['operation_id'];
                    }

                    $this->production_model->add_manual_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$location,$site, $hour, $shift_type);

                    if($previous_operation != null){
                      //complete previous operation
                      $this->production_model->complete_production_operation($barcode, $previous_operation);
                    }

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Added successfully',
                        //'data' => $this->production_model->get_bundle_from_production($order_id,$operation,$operation_point,$bundle['barcode'])
                        'data' => $this->production_model->get_bundle_from_production($operation, $bundle[0]['barcode_no'])
                    ]);
                }
            }
        }
        else { //not the first operation and bundle get from the production
            //$bundle = $this->production_model->get_bundle_from_production($order_id,$previous_operation,'OUT',$barcode);
            $bundle = $this->production_model->get_bundle_from_production($previous_operation, $barcode);
            if ($bundle == null || $bundle == false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Incorrect barcode no'
                ]);
            }
            else {
                $is_exists = $this->production_model->is_barcode_exists($operation, $bundle['barcode']);
                if ($is_exists) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Barcode already scanned'
                    ]);
                }
                else {

                  if($bundle != null && $bundle['is_order_complete'] == 1){
                    echo json_encode([
                      'status' => 'error',
                      'message' => 'Cannot scan barcode. Order was already completed.'
                    ]);
                    return;
                  }

                  //find previous operation
                  $previous_op_data = $this->production_model->get_previous_operation($bundle['style'], $operation);
                  if($previous_op_data != null){
                    $previous_operation = $previous_op_data['operation_id'];
                  }

                  $this->production_model->add_item_to_production($bundle, $operation, 'OUT', $line_no, $scan_date,$shift_no,$previous_operation);

                  if($previous_operation != null){
                    //complete previous operation
                    $this->production_model->complete_production_operation($barcode, $previous_operation);
                  }

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Added successfully',
                        'data' => $this->production_model->get_bundle_from_production($operation, $bundle['barcode'])
                    ]);
                }
            }
        }
    }*/



    public function destroy() {
        $operation_id = $this->input->post('operation_id');
        $previous_operation_id = $this->input->post('previous_operation_id');
        $barcode = $this->input->post('barcode');
        $this->load->model('master/operation_model');

        //check this barcode moved to the next operation
        $operation = $this->operation_model->get_operation($operation_id);
        $operation_sequence = $operation['seq'];
        $next_operation_productions = $this->production_model->check_bundle_moved_to_next_operations($barcode, $operation_sequence);
        if($next_operation_productions != null && sizeof($next_operation_productions) > 0){
          echo json_encode([
              'status' => 'error',
              'message' => 'Cannot remove barcode. It is already moved to the next operations'
          ]);
        }
        else {
          $this->production_model->destroy($operation_id, $barcode);
          //$prod_data = $this->production_model->get_bundle_from_production($operation_id, $barcode);
          if($previous_operation_id != null && $previous_operation_id != ''){
            $this->production_model->incomplete_production_operation($barcode, $previous_operation_id);
          }

          echo json_encode([
              'status' => 'success',
              'message' => 'Barcode removed successfully'
          ]);
        }
    }

    public function destroy_list() {
        $operation_id = $this->input->post('operation_id');
        //$previous_operation_id = $this->input->post('previous_operation_id');
        $barcodes = $this->input->post('barcodes');
        $this->load->model('master/operation_model');
        $barcodes2 = $barcodes;
        $barcodes3 = [];

        for ($x = 0; $x < sizeof($barcodes); $x++) {
            $barcodes3[$x] = "'" . $barcodes[$x]['barcode'] . "'";
        }
        $barcode_str = implode(', ', $barcodes3);

        //check this barcode moved to the next operation
        $operation = $this->operation_model->get_operation($operation_id);
        $operation_sequence = $operation['seq'];
        $next_operation_productions = $this->production_model->check_bundle_list_moved_to_next_operations($barcode_str, $operation_sequence);

        if($next_operation_productions != null && sizeof($next_operation_productions) > 0){
          echo json_encode([
              'status' => 'error',
              'message' => 'Cannot remove barcodes. Barcode(s) is(are) already moved to the next operations'
          ]);
        }
        else {
          for ($x = 0; $x < sizeof($barcodes2); $x++) {
              //$this->production_model->destroy($order_id,$operation_id,$operation_point,$barcodes[$x]);
              $this->production_model->destroy($operation_id, $barcodes2[$x]['barcode']);

              if($barcodes2[$x]['previous_operation_id'] != null && $barcodes2[$x]['previous_operation_id'] != ''){
                $this->production_model->incomplete_production_operation($barcodes2[$x]['barcode'], $barcodes2[$x]['previous_operation_id']);
              }
          }
          echo json_encode([
              'status' => 'success',
              'message' => 'Barcodes removed successfully'
          ]);
        }
    }

    public function search() {

        $search_term = $this->input->get('term');

        $data = $this->color_model->search($search_term);

        echo json_encode([
            'results' => $data
        ]);
    }


    public function get_fg_locations(){
      $site = $this->input->get('site');
      $lines = $this->login_model->get_authorized_lines_by_site_and_category($site, 'FG');
      echo json_encode([
        'data' => $lines
      ]);
    }

}
