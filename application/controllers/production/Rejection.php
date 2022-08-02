<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Rejection extends CI_Controller {



  public function __construct()

  {

   parent::__construct();

   $this->load->model('login_model');

   $this->load->model(['production/rejection_model' , 'master/rejection_type_model']);
   $this->load->model(['production/production_model', 'master/line_model']);

 }



 public function index()

 {

    	  $this->login_model->user_authentication('PROD_REJ'); // user permission authentication

        $data = array();

        $data['menus'] = $this->login_model->get_authorized_menus();

        $data['menu_code'] = 'MENU_PRODUCTION';

        $data['rejection_types'] = $this->rejection_type_model->get_all();
        $data['lines'] = $this->login_model->get_authorized_lines();//$this->line_model->get_all();

        $this->load->view('production/rejection',$data);

      }


      public function rejection_receive(){
        $this->load->model('master/site_model');
        $this->login_model->user_authentication('PROD_REJ'); // user permission authentication
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_PRODUCTION';
        $data['rejection_types'] = $this->rejection_type_model->get_all();
        $data['sites'] = $this->site_model->get_all_active();

        $this->load->view('production/rejection_receive',$data);

      }



      public function get_bundle(){

        $order_id = $this->input->get('order_id');

        $operation_id = $this->input->get('operation_id');

        $barcode = $this->input->get('barcode');

        $bundle = $this->rejection_model->get_bundle($order_id, $operation_id, $barcode);



        if($bundle == null || $bundle == false || sizeof($bundle) <= 0){

          echo json_encode([

            'status' => 'error',

            'message' => 'Incorrect barcode no'

          ]);

        }

        else{



          if(sizeof($bundle) > 1){

            echo json_encode([

              'status' => 'error',

              'message' => 'Bundle already out from operation'

            ]);

            exit;

          }

          $bundle = $bundle[0];

          $is_rejected = $this->rejection_model->is_rejected($order_id, $operation_id, $barcode);

          if($is_rejected){

            echo json_encode([

              'status' => 'error',

              'message' => 'This bundle already rejected'

            ]);

          }

          else{

            echo json_encode([

              'status' => 'success',

              'data' => $bundle

            ]);

          }

        }

      }





      public function get_rejected_bundles(){

        $order_id = $this->input->get('order_id');

        $operation_id = $this->input->get('operation_id');

        echo json_encode([

          'data' => $this->rejection_model->get_rejected_bundles($order_id, $operation_id)

        ]);

      }


      public function confirm(){
        $data = $this->input->post('data');
       // $operation_id = $this->input->get('operation_id');
        $this->rejection_model->confirm($data);
        echo json_encode([
          'status' => 'success'
        ]);
    }



      public function save_bundle(){

        $data = $this->input->post('data');

        $this->rejection_model->save_bundle($data);

        echo json_encode([

          'status' => 'success',

          'message' => 'Rejection was saved successfully.'

        ]);

      }


      public function get_size(){

        $order_id = $this->input->post('order_id');

      // $operation_id = $this->input->post('operation_id');

      // $barcodes = $this->input->post('barcodes');

        $size =$this->rejection_model->get_size($order_id);

        echo json_encode([

          'size' => $size,

          'message' => 'Bundles removed from rejection'

        ]);

      }


      public function remove_barcodes(){

        $order_id = $this->input->post('order_id');

        $operation_id = $this->input->post('operation_id');

        $barcodes = $this->input->post('barcodes');

        $this->rejection_model->remove_barcodes($order_id, $operation_id, $barcodes);

        echo json_encode([

          'status' => 'success',

          'message' => 'Bundles removed from rejection'

        ]);

      }

      public function save_data(){

        $order_id = $this->input->post('order_id');

        $line_no = $this->input->post('line_no');

        $hour = $this->input->post('hour');
        $size = $this->input->post('size');
        $qty = $this->input->post('qty');
        $shift = $this->input->post('shift');

      //  $this->rejection_model->save_data($order_id, $line_no, $hour, $size, $qty,'PASS',$shift,'PASS','P','');
        $line_data = $this->line_model->get_line($line_no);
        $site_id = null;
        if($line_data != null){
          $site_id = $line_data['location'];
        }
        $this->rejection_model->save_data($order_id, $line_no, $hour, $size, $qty,'DEFECT',$shift,'DEFECT','D','',$site_id);

        echo json_encode([

          'status' => 'success',

          'message' => 'Save Data'

        ]);

      }

      public function save_reject(){

        $order_id = $this->input->post('order_id');
        $line_no = $this->input->post('line_no');
        $hour = $this->input->post('hour');
        $size = $this->input->post('size');
        $qty = $this->input->post('qty');
        $shift = $this->input->post('shift');
        $reason_code = $this->input->post('reason_code');


        $line_in=$this->rejection_model->total_prod_qty($order_id, $size, 3);
        $line_out=$this->rejection_model->total_prod_qty($order_id, $size, 4);
        $reject_qty=$this->rejection_model->reject_qty_po($order_id, $size);
        $qty=$line_out+$reject_qty;
        if($line_in<$qty){
        echo json_encode([
          'status' => 'error',
          'message' => 'QTY mismatch! Lin IN =Line OUT + Rejection'
        ]);
        return false;
        }

        $line_data = $this->line_model->get_line($line_no);
        $site_id = null;
        if($line_data != null){
          $site_id = $line_data['location'];
        }

        $this->rejection_model->save_data($order_id, $line_no, $hour, $size, $qty,'PENDING',$shift,'FAIL','F',$reason_code, $site_id);

        echo json_encode([

          'status' => 'success',

          'message' => 'Save Data'

        ]);

      }


      public function load_reject(){

        $line_no = $this->input->post('line_no');
        $shift = $this->input->post('shift');
        $date = $this->input->post('date');
        $qty_r= $this->rejection_model->load_qty($date,$shift,$line_no,'F');
        $qty_p= $this->rejection_model->load_qty($date,$shift,$line_no,'P');

        echo json_encode([
          'qty_reject' =>$qty_r,
          'qty_pass' =>$qty_p,

        ]);

      }

      public function load_reject_list(){

        $date = $this->input->post('date');
        $rejection= $this->rejection_model->load_reject_list($date);

        echo json_encode([
          'rejection' =>$rejection

        ]);

      }

        public function load_reject_list_1(){

        $date = $this->input->post('date');
        $rejection= $this->rejection_model->load_reject_list_1($date);

        echo json_encode([
          'rejection' =>$rejection

        ]);

      }
      public function destroy($id)
  {

    // $count=$this->bundle_model->count_scan($laysheet_no, $bundle_no);

    // if($count['c_qty']>0){
    //   echo json_encode([
    //     'status' => 'error',
    //     'message' => 'Cannot Remove the bundle.already Scanned!'
    //   ]);
    //   return false;
    //   exit();
    // }
// $id = $this->input->post('id');
// echo $

    $this->rejection_model->destroy($id);

    echo json_encode([
      'status' => 'success',
      'message' => 'Item removed successfully'
    ]);
  }

  public function get_lines($site_id = 0){
    $this->load->model('master/line_model');
    $lines = $this->line_model->get_all_by_site($site_id);
    echo json_encode([
      'data' => $lines
    ]);
  }

    }
