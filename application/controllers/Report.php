<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Report extends CI_Controller {



  public function __construct()

  {

   parent::__construct();

   $this->load->model('login_model');

   $this->load->model('report_model');

   $this->load->model('master/operation_model');

   $this->load->model('master/customer_model');

   $this->load->model('master/style_model');
   $this->load->model('master/line_model');

 }



 public function summery_reports() {
   $this->login_model->user_authentication(null);
   $data = array();
   $data['menus'] = $this->login_model->get_authorized_menus();
   $this->load->view('reports/summery_reports',$data);
 }

 public function order_status_report_3($customer = 0, $style = 0, $customer_po = 'NO',$color='NO',$size='NO')

 {

  $this->login_model->user_authentication(null);

  $data = array();

		//$data['menus'] = $this->login_model->get_authorized_menus();

  $data['data'] = $this->report_model->get_order_status_report_2($customer , $style , $customer_po,urlencode($color),$size);

  $ops = $this->operation_model->get_all();

  $operations = [];

  foreach ($ops as $row) {

   $operations[$row['operation_id']] = $row['operation_name'];

 }

 $data['operations'] = $operations;

 $data['customers'] = $this->customer_model->get_all();

 $data['styles'] = $this->style_model->get_all();

 if($customer_po!='NO'){
  $data['cpo']=$customer_po;
}else{
 $data['cpo']="";
}
if($color!='NO'){
  $data['color']=$color;
}else{
 $data['color']="";
}

		//echo json_encode($data['data']);die();

$this->load->view('reports/order_status_report_2',$data);

}

public function order_status_report_s($customer = 0, $style = 0, $customer_po = 'NO',$color='NO',$size='NO')

 {

  $this->login_model->user_authentication(null);

  $data = array();

    //$data['menus'] = $this->login_model->get_authorized_menus();

  $data['data'] = $this->report_model->get_order_status_report_3($customer , $style , $customer_po,urlencode($color),$size);

  $ops = $this->operation_model->get_all();

  $operations = [];

  foreach ($ops as $row) {

   $operations[$row['operation_id']] = $row['operation_name'];

 }

 $data['operations'] = $operations;

 $data['customers'] = $this->customer_model->get_all();

 $data['styles'] = $this->style_model->get_all();

 if($customer_po!='NO'){
  $data['cpo']=$customer_po;
}else{
 $data['cpo']="";
}
if($color!='NO'){
  $data['color']=$color;
}else{
 $data['color']="";
}

    //echo json_encode($data['data']);die();

$this->load->view('reports/order_status_report_3',$data);

}

public function order_status_report($customer = 0, $style = 0, $customer_po = 'NO',$color ='NO', $order_status = 'NO', $date_from = '', $date_to = '')
{
  $this->login_model->user_authentication(null);
  $data = array();
  //$data['menus'] = $this->login_model->get_authorized_menus();
  $data['data'] = $this->report_model->get_order_status_report($customer , $style , $customer_po,$color, $order_status, $date_from, $date_to);
  $ops = $this->operation_model->get_all();
  $operations = [];

  foreach ($ops as $row) {
    $operations[$row['operation_id']] = $row['operation_name'];
  }

  $data['operations'] = $operations;
  $data['customers'] = $this->customer_model->get_all();
  $data['styles'] = $this->style_model->get_all();

  if($customer_po!='NO'){
    $data['cpo']=$customer_po;
  }else{
   $data['cpo']="";
  }
  if($color!='NO'){
    $data['color']=$color;
  }else{
    $data['color']="";
  }

  $data['customer'] = $customer;
  $data['style'] = $style;
  $data['customer_po'] = $customer_po == 'NO' ? '' : $customer_po;
  $data['color'] = $color == 'NO' ? '' : $color;
  $data['order_status'] = $order_status;
  $data['date_from'] = $date_from;
  $data['date_to'] = $date_to;
  //echo json_encode($data['data']);die();
  $this->load->view('reports/order_status_report',$data);
}


public function order_status_report_view(){
  $this->login_model->user_authentication(null);
  $data = array();
  $data['data'] = [];
  $ops = $this->operation_model->get_all();
  $operations = [];

  foreach ($ops as $row) {
    $operations[$row['operation_id']] = $row['operation_name'];
  }

  $data['operations'] = $operations;
  $data['customers'] = $this->customer_model->get_all();
  $data['styles'] = $this->style_model->get_all();
  $data['cpo']="";
  $data['color']="";

  $data['customer'] = '';
  $data['style'] = '';
  $data['customer_po'] = '';
  $data['color'] = '';
  $data['order_status'] = '';
  $data['date_from'] = '';
  $data['date_to'] = '';
  $this->load->view('reports/order_status_report',$data);
}


public function production_summery_report()

{

  $this->login_model->user_authentication(null);

  $data = array();

  $data['menus'] = $this->login_model->get_authorized_menus();

  $this->load->view('reports/production_summery_report',$data);

}





public function cutting_reports()

{

  $this->login_model->user_authentication(null);

  $data = array();

  $data['menus'] = $this->login_model->get_authorized_menus();

  $this->load->view('reports/cutting_reports',$data);

}



public function daily_cutting_wip_report()

{

  $this->login_model->user_authentication(null);

  $data = array();

  $data['menus'] = $this->login_model->get_authorized_menus();

  $this->load->view('reports/daily_cutting_wip_report',$data);

}







public function is_color_code_exists(){

  try{

   $color_code = $this->input->post('data_value');

   $color_id = $this->input->post('color_id');

   $color_count = $this->color_model->count_colors_from_code($color_code,$color_id);

   if($color_count > 0){

    echo json_encode(array(

     'status' => 'error',

     'message' => 'Color code already exists'

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





public function color_save(){

  try

  {

   $auth_data = $this->login_model->user_authentication_ajax(null);

  			if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication

  			$data = $this->input->post('form_data');

  			$color_id = $data['color_id'];

  			if($color_id > 0){ //update

  				$this->color_model->update_color($data);

  			}

  			else{ //insert

  				$color_id = $this->color_model->add_color($data);

  			}

  			echo json_encode(array(

  				'status' => 'success',

  				'message' => 'Color details saved successfully.',

  				'color_id' => $color_id

  			));

  		}

  		catch(Exception $e){

  			echo json_encode(array(

  				'status' => 'error',

  				'message' => 'System process error',

  				'color_id' => 0

  			));

  		}

  	}





    public function color_view($id = 0)

    {

      $this->login_model->user_authentication(null);

      $data = array();

      $data['menus'] = $this->login_model->get_authorized_menus();

      $data['color'] = $this->color_model->get_color($id);

      if($data['color'] == null || $data['color'] == false){

        $this->load->view('common/404',array(

          'heading' => 'Resqested Color Not Found')

      );

      }

      else

        $this->load->view('master/colour/colour',$data);

    }





    public function get_colors()

    {

     $auth_data = $this->login_model->user_authentication_ajax(null);

          if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication



          $data = $_POST;

          $start = $data['start'];

          $length = $data['length'];

          $draw = $data['draw'];

          $search = $data['searchText'];//$data['search']['value'];

          $order = $data['order'][0];

          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];



          $colors = $this->color_model->get_colors($start,$length,$search,$order_column);

          $count = $this->color_model->get_colors_count($search);

          echo json_encode(array(

            "draw" => $draw,

            "recordsTotal" => $count,

            "recordsFiltered" => $count,

            "data" => $colors

          ));

        }





        public function search()

        {

          $search_term = $this->input->get('term');

          $data = $this->color_model->search($search_term);

          echo json_encode([

            'results' => $data

          ]);

        }

        public function get_daily_report()
        {
          $date_from = $this->input->get('date_from');
          $date_to = $this->input->get('date_to');
          $operation = $this->input->get('operations');
          $building = $this->input->get('building');
          $shift = $this->input->get('shift');
          $site = $this->input->get('site');

          if($operation==20){
            $data = $this->report_model->get_daily_production_cutting($date_from,$date_to,$operation,$building, $site);

          }else{
            $data = $this->report_model->get_daily_production($date_from,$date_to,$operation,$building,$shift, $site);
          }


          echo json_encode([
           'results' => $data

         ]);

        }




    // 02



        public function daily_line_in_report()
        {
          $this->load->model('master/site_model');
          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();
          $data['sites'] = $this->site_model->get_all_active();

          $this->load->view('reports/daily_line_in_report',$data);
        }

        public function scan_history()
        {
          $this->login_model->user_authentication(null);
          $data = array();
          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();
          $data['lines'] = $this->line_model->get_all();

          $this->load->view('reports/scan_history',$data);

        }

        public function get_scan_history()
        {
          $order_id = $this->input->get('order_id');
          $barcode = $this->input->get('barcode');
          $operation = $this->input->get('operation');
          $line_no = $this->input->get('line_no');
          $size = $this->input->get('size');
          $scan_date = $this->input->get('scan_date');

          $this->login_model->user_authentication(null);

          $data = array();
//echo $cut_plan;
//echo $barcode;
          $data['menus'] = $this->login_model->get_authorized_menus();
          $data = $this->report_model->get_scan_history($order_id, $barcode, $operation, $line_no, $size, $scan_date);

          echo json_encode([
           'results' => $data
         ]);

        }


        public function destroy()
        {
          $barcode = $this->input->post('barcode');
          $operation_id = $this->input->post('operation_id');
          $prev_operation_id = $this->input->post('prev_operation_id');
          $this->load->model('master/operation_model');
          $this->load->model('production/production_model');

          //check this barcode moved to the next operation
          $operation = $this->operation_model->get_operation($operation_id);
          $operation_sequence = $operation['seq'];
          $next_operation_productions = $this->production_model->check_bundle_moved_to_next_operations($barcode, $operation_sequence);
          if($next_operation_productions != null && sizeof($next_operation_productions) > 0){
            echo json_encode([
                'status' => 'error',
                'message' => 'Cannot remove barcode. It is already moved to the next operations'
            ]);
            return;
          }

          $this->report_model->destroy($barcode, $operation_id);

          if($prev_operation_id != null && $prev_operation_id != ''){
            $this->production_model->incomplete_production_operation($barcode, $prev_operation_id);
          }

          echo json_encode([
           'status' => 'success',
           'message' => 'Bundle removed successfully'
         ]);
        }



        public function destroy_list() {
          $this->load->model('master/operation_model');
          $this->load->model('production/production_model');
          $barcodes = $this->input->post('barcodes');
          $barcodes2 = [];
          $has_errors = false;

          for ($x = 0; $x < sizeof($barcodes); $x++) {
              //$barcodes2[$x] = "'" . $barcodes[$x]['barcode'] . "'";
              //check this barcode moved to the next operation
              $operation = $this->operation_model->get_operation($barcodes[$x]['operation_id']);
              $operation_sequence = $operation['seq'];
              $barcode_str = "'".$barcodes[$x]['barcode']."'";
              $next_operation_productions = $this->production_model->check_bundle_list_moved_to_next_operations($barcode_str, $operation_sequence);

              if($next_operation_productions != null && sizeof($next_operation_productions) > 0){
                $has_errors = true;
                break;
              }
          }
          //$barcode_str = implode(', ', $barcodes2);
          if($has_errors){
            echo json_encode([
                'status' => 'error',
                'message' => 'Cannot remove barcodes. Barcode(s) is(are) already moved to the next operations'
            ]);
          }
          else {
            for ($x = 0; $x < sizeof($barcodes); $x++) {
                $this->report_model->destroy($barcodes[$x]['barcode'], $barcodes[$x]['operation_id']);

                if($barcodes[$x]['previous_operation_id'] != null && $barcodes[$x]['previous_operation_id'] != ''){
                  $this->production_model->incomplete_production_operation($barcodes[$x]['barcode'], $barcodes[$x]['previous_operation_id']);
                }
            }
            echo json_encode([
                'status' => 'success',
                'message' => 'Barcodes removed successfully'
            ]);
          }
        }



        public function daily_line_out_report()
        {
          $this->login_model->user_authentication(null);
          $data = array();
          $data['menus'] = $this->login_model->get_authorized_menus();
          $this->load->view('reports/daily_line_out_report',$data);
        }

    // 04



        public function daily_sewing_rej_report()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();

          $this->load->view('reports/daily_sewing_rej_report',$data);

        }



    // 04



        public function daily_fg_in_report()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();

          $this->load->view('reports/daily_fg_in_report',$data);

        }



        public function production_reports()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();

          $this->load->view('reports/production_reports',$data);

        }

        public function line_in_report()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();

          $this->load->view('reports/daily_line_in_report',$data);

        }
//dai;y line wise output//

        public function daily_line_wise_report($date = 0)

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();
      //  $data['line'] = $this->line_model->get_all();
          $data['linea'] = $this->report_model->line_data('Y','A','PROD','%');
          $data['lineb'] = $this->report_model->line_data('Y','B','PROD',1);
          if ($date == 0) {

            $data['date']="";
          }else
          {
           $data['date']=$date;
         }


         $this->load->view('reports/daily_line_output',$data);

       }


       public function get_line_wise_report()

       {

        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $operation = $this->input->get('operations');
        $building = $this->input->get('building');
        $shift = $this->input->get('shift');

        $data = $this->report_model->line_wise_report_a($date_from,$date_to,$operation,$building,$shift);
        $data2 = $this->report_model->line_wise_report_b($date_from,$date_to,$operation,$building,$shift);


        echo json_encode([
          'results' => $data,
          'results2' => $data2

        ]);

      }

      public function wip_report($date = 0)

      {

        $this->login_model->user_authentication(null);

        $data = array();


        $this->load->view('reports/wip_report',$data);

      }
      public function get_wip()

      {

        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $operation = $this->input->get('operations');
        $building = $this->input->get('building');
        $shift = $this->input->get('shift');
        $data="";
        if($operation == 'cut'){

        }
        if($operation == 'sm'){
          $data = $this->report_model->get_super_market_wip();
        }

    if($operation == 'cut'){
          $data = $this->report_model->get_cutting_wip();
        }
        if($operation == 'line'){
          $data = $this->report_model->get_line_wip();
        }

         if($operation == 'cut_smv'){
          $data = $this->report_model->get_cutting_to_sm_wip();
        }
        if($operation == 'fg'){
//$data = $this->report_model->get_line_wip();
        }

        echo json_encode([
          'results' => $data

        ]);

      }

      public function get_wip_by_order($order_id,$operation)

      {


        // $operation = $this->input->get('operations');
        // $order_id = $this->input->get('order_id');

        $data="";
        if($operation == 'cut'){

        }
        if($operation == 'sm'){
          $data = $this->report_model->get_super_market_wip_detail($order_id);
        }

    if($operation == 'cut'){
          $data = $this->report_model->get_cutting_wip_detail($order_id);
        }
        if($operation == 'line'){
          $data = $this->report_model->get_line_wip();
        }

         if($operation == 'cut_smv'){
          $data = $this->report_model->get_cut_to_sm_detail($order_id);
        }
        if($operation == 'fg'){
//$data = $this->report_model->get_line_wip();
        }

        echo json_encode([
          'results' => $data

        ]);

      }

        public function line_out_report()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();

          $this->load->view('reports/line_out_report',$data);

        }


         public function get_line_out_report()

        {

          $date_from = $this->input->get('date_from');
          $date_to = $this->input->get('date_to');
          $operation = $this->input->get('operations');
          $building = $this->input->get('building');
          $shift = $this->input->get('shift');

         // if($operation==20){
           // $data = $this->report_model->get_daily_production_cutting($date_from,$date_to,$operation,$building);

         // }else{
            $data = $this->report_model->get_production_out($date_from,$date_to,$operation,$building,$shift);
         // }


          echo json_encode([
           'results' => $data

         ]);

        }

        // public function efficeincy($date=0)

        // {

        //   // $date_from = $this->input->get('date_from');
        //   // $date_to = $this->input->get('date_to');
        //   // $operation = $this->input->get('operations');
        //   // $building = $this->input->get('building');
        //   // $shift = $this->input->get('shift');

        //  // if($operation==20){
        //    // $data = $this->report_model->get_daily_production_cutting($date_from,$date_to,$operation,$building);

        //  // }else{
        //     $data= array();
        //     $data['efficeincy'] = $this->report_model->efficeincy_data($date)
        //    // $data = $this->report_model->efficeincy_production($date);
        //  // }


        //   $this->load->view('reports/efficeincy_report',$data);
        // }

         public function efficeincy($date = 0,$site = '') {

          $this->load->model('master/site_model');
          $this->login_model->user_authentication(null);
          $data= array();

          if ($date == 0) {
            $data['date']="";
          }
          else {
           $data['date']=$date;
         }
          //$data['efficeincy'] = $this->report_model->efficeincy_data($date);
          if($date != '' && $site != ''){
            $data['eff_product'] = $this->report_model->eff_product_wise($date, $site);
            $data['eff_line_wise'] = $this->report_model->eff_line_wise($date, $site);
            $data['eff_section_wise'] = $this->report_model->eff_section_wise($date, $site);

            $data['all_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, null);
            $data['early_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, 'A');
            $data['late_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, 'B');
          }
          else {
            $data['eff_product'] = [];
            $data['eff_line_wise'] = [];
            $data['eff_section_wise'] = [];
            $data['all_shift_daily_total'] = [];
            $data['early_shift_daily_total'] = [];
            $data['late_shift_daily_total'] = [];
          }

          $data['sites'] = $this->site_model->get_all_active();
          $data['site'] = $site;

         $this->load->view('reports/efficeincy_report',$data);
         //$this->load->view('reports/efficeincy_report_email',$data);

       }

        public function efficeincy_email()

        {

          $this->login_model->user_authentication(null);

          $date = $this->input->post('date');
          $data= array();
          //$data['date']=$date;
         //  if ($date == 0) {

         //    $data['date']="";
         //  }else
         //  {
         //   $data['date']=$date;
         // }
          //$data['efficeincy'] = $this->report_model->efficeincy_data($date);
          $data['eff_product'] = $this->report_model->eff_product_wise($date);
          $data['eff_line_wise'] = $this->report_model->eff_line_wise($date);
          $data['eff_section_wise'] = $this->report_model->eff_section_wise($date);

         $this->load->view('reports/efficeincy_report',$data);

       }


       public function scan_history2() {
         $this->login_model->user_authentication(null);
         $data = array();
        // $data['menus'] = $this->login_model->get_authorized_menus();
         $data['operations'] = $this->operation_model->get_all();
         $this->load->view('reports/scan_history2',$data);
       }

       public function get_scan_history2()  {
         $po_no = $this->input->get('po_no');
         $order_id = $this->input->get('order_id');
         $cut_no = $this->input->get('cut_no');
         $operation = $this->input->get('operation');
         $barcode = null;//$this->input->get('barcode');

         $order_id = ($order_id == 'all') ? null : $order_id;
         $operation = ($operation == 'all') ? null : $operation;

         $this->login_model->user_authentication(null);
         $data = array();
         //$data['menus'] = $this->login_model->get_authorized_menus();
         $data = $this->report_model->get_scan_history2($po_no, $order_id, $cut_no, $operation, $barcode);
         echo json_encode([
          'data' => $data
        ]);
       }

       public function get_order_details_from_customer_po($po_no){
         $this->load->model('fg/fg_transfer_model');
         $orders = $this->fg_transfer_model->get_orders_from_customer_po($po_no);
         echo json_encode([
           'data' => $orders
         ]);
       }


       public function barcode_tracking() {
         $this->login_model->user_authentication(null);
         $data = array();
        // $data['menus'] = $this->login_model->get_authorized_menus();
        // $data['operations'] = $this->operation_model->get_all();
         $this->load->view('reports/barcode_tracking',$data);
       }

       public function get_barcode_tracking()  {
         $po_no = null;//$this->input->get('po_no');
         $order_id = $this->input->get('order_id');
         $cut_no = $this->input->get('cut_no');
         //$operation = $this->input->get('operation');
         //$barcode = null;//$this->input->get('barcode');

         //$order_id = ($order_id == 'all') ? null : $order_id;
         //$operation = ($operation == 'all') ? null : $operation;

         $this->login_model->user_authentication(null);
         $data = array();
         $data = $this->report_model->get_barcode_tracking($cut_no, $order_id);
         echo json_encode([
          'data' => $data
        ]);
       }


       //User Login Audit Report -----------------------------------------------

       public function user_login_audit_report(){
         $this->load->view('reports/user_login_audit_report',null);
       }

       public function get_user_login_audit_summery(){
         $date = $this->input->get("selected_date");
         $data = $this->report_model->get_user_login_audit_summery($date);
         echo json_encode([
           'data' => $data
         ]);
       }


       public function get_user_login_audit_details(){
         $date = $this->input->get("selected_date");
         $data = $this->report_model->get_user_login_audit_details($date);
         echo json_encode([
           'data' => $data
         ]);
       }

       //Daily rejection report ------------------------------------------------

       public function daily_rejection_report(){
         $this->load->view('reports/daily_rejection_report',null);
       }

       public function get_daily_redjection_data(){
         $from_date = $this->input->get("from_date");
         $to_date = $this->input->get("to_date");
         $sizes = $this->report_model->get_rejection_sizes($from_date, $to_date);
         $data = [];
         if($sizes != null && sizeof($sizes) > 0){
           $data = $this->report_model->get_daily_redjection_data($from_date, $to_date, $sizes);
         }
         echo json_encode([
           'data' => $data,
           'sizes' => $sizes
         ]);
       }


       //Order status report - size wise ---------------------------------------

     public function order_status_report_size_wise(/*$customer = 0, $style = 0, $customer_po = 'NO',$color='NO',$size='NO'*/) {

         $this->login_model->user_authentication(null);
         $data = array();
         $data['data'] = [];
         $data['customers'] = $this->customer_model->get_all();
          $data['styles'] = $this->style_model->get_all();
       //   $data['data'] = $this->report_model->get_order_status_report_3($customer , $style , $customer_po,urlencode($color),$size);
       //   $ops = $this->operation_model->get_all();
       //   $operations = [];
       //
       //   foreach ($ops as $row) {
       //    $operations[$row['operation_id']] = $row['operation_name'];
       //  }
       //
       //  $data['operations'] = $operations;
       //
       //
       //
       //  if($customer_po!='NO'){
       //   $data['cpo']=$customer_po;
       // }else{
       //  $data['cpo']="";
       // }
       // if($color!='NO'){
       //   $data['color']=$color;
       // }else{
       //  $data['color']="";
       // }

       $this->load->view('reports/order_status_report_3',$data);
       }


     public function order_status_report_size_wise_data() {
          $customer = $this->input->get('customer');
          $style = $this->input->get('style');
          $customer_po = $this->input->get('customer_po');
          $color = $this->input->get('color');
          $size = $this->input->get('size');

         $data = $this->report_model->get_order_status_report_3($customer , $style , $customer_po,urlencode($color),$size);
         echo json_encode([
           'data' =>   $data
         ]);
     }

     // FG stock report ........................................................

   public function fg_stock_report() {
       $this->login_model->user_authentication(null);
       $this->load->model('master/color_model');
       $this->load->model('master/size_model');

       $data = array();
       $data['data'] = [];
       $data['styles'] = $this->style_model->get_all();
       $data['sizes'] = $this->size_model->get_all_active();
       $data['colors'] = $this->color_model->get_all_active();
       $this->load->view('reports/fg_stock_report',$data);
  }


  public function get_fg_stock_data() {
      $style_id = $this->input->get('style_id');
      $color_id = $this->input->get('color_id');
      $size_id = $this->input->get('size_id');
      $data = $this->report_model->get_fg_stock_data($style_id, $color_id, $size_id);
      echo json_encode([
        'data' =>   $data
      ]);
  }


  //Bundle ageing report --------------------------------------------------------

  public function bundle_ageing_summery_report() {
      $this->login_model->user_authentication(null);
      $operations = $this->report_model->get_operations('ALL');
      unset($operations[sizeof($operations) - 1]);
      $data = [
        'operations' => $operations
      ];
      $this->load->view('reports/bundle_ageing_summery', $data);
 }

 public function bundle_ageing_details_report($operation, $customer_po) {
     $this->login_model->user_authentication(null);
     $wip_data = [];
     $wip_bundles = [];

     $op1 = $this->report_model->get_operation($operation);
     $op2 = $this->report_model->get_operation_by_seq($op1['seq'] + 1);
     $wip_bundles = $this->report_model->get_bundle_ageing_data($op1['operation_id'], $op2['operation_id'], $customer_po);

     if($wip_bundles == null){
       $wip_bundles = [];
     }

     $data = [
       'data' => $wip_bundles,
       'operation' => $op1,
       'customer_po' => $customer_po
     ];

     $this->load->view('reports/bundle_ageing_details', $data);
}


 public function get_bundle_ageing_summery(){
    $operation = $this->input->get('operation');
    $wip_data = [];
    $operations = [];
    $wip_bundles = [];

    if($operation == 'ALL'){
      $operations = $this->report_model->get_operations();

      for ($x = 0 ; $x < sizeof($operations) ; $x++) {
        $wip_bundles = $this->report_model->get_bundle_ageing_summery($operations[$x]['operation_id'], $operations[$x+1]['operation_id']);

        if($wip_bundles == null){
          $wip_data[$operations[$x]['operation_id']] = [];
        }
        else {
          $wip_data[$operations[$x]['operation_id']] = $wip_bundles;
        }

        if($operations[$x]['operation_name'] == 'LINE IN'){
          break;
        }
      }
      unset($operations[sizeof($operations) - 1]);
    }
    else {
      $op1 = $this->report_model->get_operation($operation);
      $op2 = $this->report_model->get_operation_by_seq($op1['seq'] + 1);
      array_push($operations, $op1);
      $wip_bundles = $this->report_model->get_bundle_ageing_summery($op1['operation_id'], $op2['operation_id']);

      if($wip_bundles == null){
        $wip_data[$op1['operation_id']] = [];
      }
      else {
        $wip_data[$op1['operation_id']] = $wip_bundles;
      }
    }

    $data = [
      'data' => $wip_data,
      'operations' => $operations
    ];
    echo json_encode($data);
 }


 // public function get_bundle_ageing_data(){
 //   $operation = $this->input->get('operation');
 //   $wip_data = [];
 //   $operations = [];
 //   $wip_bundles = [];
 //
 //   if($operation == 'ALL'){
 //     $operations = $this->report_model->get_operations();
 //
 //     for ($x = 0 ; $x < sizeof($operations) ; $x++) {
 //       $wip_bundles = $this->report_model->get_bundle_ageing_data($operations[$x]['operation_id'], $operations[$x+1]['operation_id']);
 //
 //       // if($x == 4){
 //       //   echo json_encode($wip_bundles);die();
 //       // }
 //       if($wip_bundles == null){
 //         $wip_data[$operations[$x]['operation_id']] = [];
 //       }
 //       else {
 //         $wip_data[$operations[$x]['operation_id']] = $wip_bundles;
 //       }
 //
 //       if($operations[$x]['operation_name'] == 'LINE IN'){
 //         break;
 //       }
 //     }
 //     unset($operations[sizeof($operations) - 1]);
 //   }
 //   else {
 //     $op1 = $this->report_model->get_operation($operation);
 //     $op2 = $this->report_model->get_operation_by_seq($op1['seq'] + 1);
 //     array_push($operations, $op1);
 //     $wip_bundles = $this->report_model->get_bundle_ageing_data($op1['operation_id'], $op2['operation_id']);
 //
 //     if($wip_bundles == null){
 //       $wip_data[$op1['operation_id']] = [];
 //     }
 //     else {
 //       $wip_data[$op1['operation_id']] = $wip_bundles;
 //     }
 //   }
 //
 //   $data = [
 //     'data' => $wip_data,
 //     'operations' => $operations
 //   ];
 //
 //   echo json_encode($data);
 // }


 public function incomplete_laysheets() {
     $this->login_model->user_authentication(null);
     $data = [
       'data' => $this->report_model->get_incomplete_laysheets()
     ];

     $this->load->view('reports/incomplete_laysheets', $data);
}



//Cutting Reconciliation Report ---------------------------------------------------------------------

public function cutting_reconciliation_report(){
  $this->login_model->user_authentication(null);
  $data = [];
  $this->load->view('reports/cutting_reconciliation', $data);
}


public function cutting_reconciliation_report_data(){
  $date = $this->input->get('date');
  $customer_po = $this->input->get('customer_po');
  $data = $this->report_model->cutting_reconciliation_report_data($date, $customer_po);
  echo json_encode([
    'data' => $data
  ]);
}

//scan history line out report -------------------------------------------------

public function scan_history_lineout()
{
  $this->login_model->user_authentication(null);
  $data = array();
  $data['lines'] = $this->line_model->get_all();
  $this->load->view('reports/scan_history_lineout',$data);
}

public function get_scan_history_lineout()
{
  $this->login_model->user_authentication(null);

  $order_id = $this->input->get('order_id');
  $barcode = $this->input->get('barcode');
  $operation = $this->input->get('operation');
  $line_no = $this->input->get('line_no');
  $size = $this->input->get('size');
  $scan_date = $this->input->get('scan_date');
  $user_id = $this->session->userdata('user_id');

  $data = $this->report_model->get_scan_history_lineout($user_id, $order_id, $barcode, $line_no, $size, $scan_date);
  echo json_encode([
   'results' => $data
 ]);

}


//order status report - line wise ----------------------------------------------

public function order_status_report_line_wise() {
    $this->login_model->user_authentication(null);
    $data = array();
    $data['data'] = [];
    $data['customers'] = $this->customer_model->get_all();
     $data['styles'] = $this->style_model->get_all();
     $this->load->view('reports/order_status_report_line_wise',$data);
  }


public function order_status_report_line_wise_data() {
     $customer = $this->input->get('customer');
     $style = $this->input->get('style');
     $customer_po = $this->input->get('customer_po');
     $color = $this->input->get('color');
     $size = $this->input->get('size');

    $data = $this->report_model->get_order_status_report_line_wise($customer , $style , $customer_po,urlencode($color),$size);
    echo json_encode([
      'data' =>   $data
    ]);
}

}
