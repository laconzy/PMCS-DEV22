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



 public function summery_reports()

 {

   $this->login_model->user_authentication(null);

   $data = array();

   $data['menus'] = $this->login_model->get_authorized_menus();

   $this->load->view('reports/summery_reports',$data);

 }

 public function order_status_report_s($customer = 0, $style = 0, $customer_po = 'NO',$color='NO',$size='NO')

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



public function order_status_report($customer = 0, $style = 0, $customer_po = 'NO',$color ='NO')

{

  $this->login_model->user_authentication(null);

  $data = array();

    //$data['menus'] = $this->login_model->get_authorized_menus();

  $data['data'] = $this->report_model->get_order_status_report($customer , $style , $customer_po,$color);

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

          if($operation==20){
            $data = $this->report_model->get_daily_production_cutting($date_from,$date_to,$operation,$building);

          }else{
            $data = $this->report_model->get_daily_production($date_from,$date_to,$operation,$building,$shift);
          }


          echo json_encode([
           'results' => $data

         ]);

        }




    // 02



        public function daily_line_in_report()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();

          $this->load->view('reports/daily_line_in_report',$data);

        }

        public function scan_history()

        {

          $this->login_model->user_authentication(null);

          $data = array();

          $data['menus'] = $this->login_model->get_authorized_menus();
          $data['operations'] = $this->operation_model->get_all();

          $this->load->view('reports/scan_history',$data);

        }

        public function get_scan_history()

        {
          $cut_plan = $this->input->get('cut_plan');
          $barcode = $this->input->get('barcode');
          $this->login_model->user_authentication(null);

          $data = array();
//echo $cut_plan;
//echo $barcode;
          $data['menus'] = $this->login_model->get_authorized_menus();
          $data = $this->report_model->get_scan_history($cut_plan,$barcode);

          echo json_encode([

           'results' => $data

         ]);

        }


        public function destroy($barcode, $bundle_no)
        {

		//$count=$this->bundle_model->count_scan($barcode, $bundle_no);

//		if($count['c_qty']>0){
//			echo json_encode([
//				'status' => 'error',
//				'message' => 'Cannot Remove the bundle.already Scanned!'
//			]);
//			return false;
//			exit();
//		}


          $this->report_model->destroy($barcode, $bundle_no);

          echo json_encode([
           'status' => 'success',
           'message' => 'Bundle removed successfully'
         ]);
        }
    // 03



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

        if($operation == 'line'){
          $data = $this->report_model->get_line_wip();
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

         public function efficeincy($date = 0)

        {

          $this->login_model->user_authentication(null);

          
          $data= array();
          //$data['date']=$date;
          if ($date == 0) {

            $data['date']="";
          }else
          {
           $data['date']=$date;
         }
          //$data['efficeincy'] = $this->report_model->efficeincy_data($date);
          $data['eff_product'] = $this->report_model->eff_product_wise($date);
          $data['eff_line_wise'] = $this->report_model->eff_line_wise($date);
          $data['eff_section_wise'] = $this->report_model->eff_section_wise($date);

         $this->load->view('reports/efficeincy_report',$data);

       }

    }

    $config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.example.com', 
    'smtp_port' => 465,
    'smtp_user' => 'system@dtrtapparel.com',
    'smtp_pass' => 'DTRT-FR1234',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);

    <?php

defined('BASEPATH') OR exit('No direct script access allowed');

