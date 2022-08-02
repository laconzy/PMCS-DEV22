<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
			'login_model',
			'order/order_model',
			'master/season_model',
			'master/country_model',
			'master/operation_model',
			'order/order_operation_model'
		]);
    }

    public function index()
    {
        $this->login_model->user_authentication('ORDER_ADD'); // user permission authentication
        $data = [
          'order_id' => 0,
          'menus' => $this->login_model->get_authorized_menus(),
          'menu_code' => 'MENU_ORDER',
          'load_country' => $this->country_model->get('ALL'),
          'seasons' => $this->season_model->get_all_seasons(),
          'operations' => $this->operation_model->get_all()
        ];
        $this->load->view('order/index',$data);
    }


    public function listing(){
      $this->login_model->user_authentication('ORDER_VIEW'); // user permission authentication
      $data = [
        'menus' => $this->login_model->get_authorized_menus(),
        'menu_code' => 'MENU_ORDER',
      ];
      $this->load->view('order/order_list',$data);
    }


    public function show($id){
      $this->login_model->user_authentication('ORDER_VIEW'); // user permission authentication
      $order = $this->order_model->get($id);
      $data = [
        'order_id' => $id,
        'menus' => $this->login_model->get_authorized_menus(),
        'menu_code' => 'MENU_ORDER',
        'load_country' => $this->country_model->get('ALL'),
        'seasons' => $this->season_model->get_all_seasons(),
        'operations' => $this->operation_model->get_all(),
        'order' => $order
      ];
      $this->load->view('order/index',$data);
    }


    public function save()
    {
      $this->login_model->user_authentication(null); // user permission authentication
      $data = $this->input->post('data');
      $order = null;
      $customer_po = $data['customer_po'];
      $color = $data['color'];

      if($data['order_id'] <= 0){
        $prev_orders = $this->order_model->get_order_from_po_and_color($customer_po, $color);
        if($prev_orders != null && sizeof($prev_orders) > 0){
          echo json_encode([
            'status' => 'error',
            'message' => 'Order already exists for this customer po and color'
          ]);
          return;
        }

        $order_id = $this->order_model->create($data);
    		//get all operations and add them to order automatically
    		$operations = $this->operation_model->get_all();
    		foreach($operations as $row){
    			$order_operation_data = [
    				'order_id' => $order_id,
    				'operation' => $row['operation_id'],
    				'operation_type' => null
    			];
    			$this->order_operation_model->create($order_operation_data);
    		}
      }
      else {

        $prev_orders = $this->order_model->get_order_from_po_and_color($customer_po, $color);
        if($prev_orders != null && sizeof($prev_orders) > 0 && $prev_orders[0]['order_id'] != $data['order_id']){
          echo json_encode([
            'status' => 'error',
            'message' => 'Order already exists for this customer po and color'
          ]);
          return;
        }

        $order_id = $this->order_model->update($data);
      }
      $data = array(
        'status' => 'success',
        'message' => 'Header details saved successfully.',
        'order_id' => $order_id
      );
      echo json_encode($data);
    }


    public function get($type=null) {
      //$auth_data = $this->login_model->user_authentication_ajax(null);
      //if($auth_data != null){ echo json_encode($auth_data); return false;} // user permission athentication
      if($type == 'datatable'){
          $data = $_GET;
          $start = $data['start'];
          $length = $data['length'];
          $draw = $data['draw'];
          $search = $data['searchText'];//$data['search']['value'];
          $order = $data['order'][0];
          $order_column = $data['columns'][$order['column']]['data'].' '.$order['dir'];
          $complete_filter = $data['completeFilter'];

          $colors = $this->order_model->get_list($start,$length,$search,$order_column,$complete_filter);
          $count = $this->order_model->get_count($search,$complete_filter);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $colors
          ));
      }
      else if($type == null){
        $order_id = $this->input->get('order_id');
        echo json_encode([
          'data' => $this->order_model->get($order_id)
        ]);
      }
    }


    public function destroy($id) {
      $this->order_model->destroy($id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Order was deactivated successfully'
      ]);
    }


    public function export_data(){
        $search = $this->input->get('searchText');
        $complete_filter = $this->input->get('completeFilter');
        $data = $this->order_model->get_export_list($search,$complete_filter);
        echo json_encode(array(
            "data" => $data
        ));
    }


    //order upload -------------------------------------------------------------

    public function orders_upload(){
      $this->login_model->user_authentication('ORDER_VIEW'); // user permission authentication
      $data = [
        'menus' => $this->login_model->get_authorized_menus(),
        'menu_code' => 'MENU_ORDER',
      ];
      $this->load->view('order/order_upload',$data);
    }


    public function upload_excel(){
      $this->load->model('master/item_model');
      $this->load->model('master/size_model');
      $this->load->model('order/order_item_model');

      $curr_user = $this->session->userdata('user_id');
      $date = new DateTime();
      $timestamp = $date->getTimestamp();
      $file_name = $curr_user . '_' . $timestamp .'.xlsx';
      $file_path = 'assets/excel_files/';

	    $config['upload_path'] = $file_path;
      $config['allowed_types'] = 'xls|xlsx';
      $config['file_name'] = $file_name;
     // $config['max_size']	= '300';
      $config['overwrite'] = true;
      $this->load->library('upload', $config);
      $error = '';
	    $error = $this->upload->do_upload('excel_file');
      //print_r($error);die();

      if($error == false){
        print_r($error); die();
      }

      $row_count = -1;
      $columns = [
        'A' => 'Date',
        'B' => 'CUSTOMER',
        'C' => 'BUY',
        'D' => 'SEASON',
        'E' => 'STYLE',
        'F' => 'COUNTRY',
        'G' => 'SMV',
        'H' => 'CUSTOMER_PO',
        'I' => 'COLOR',
        'J' => 'ORDER_QTY',
        'K' => 'CUSTOMER_REQUESTED_DATE',
        'L' => 'AGREED_DELIVERY_DATE',
        'M' => 'SHIP_MODE',
        'N' => 'POSSIBLE_RM_INHOUSE_DATE',
        'O' => 'POSSIBLE_PCD',
        'P' => 'DELIVERY_SEQ'
      ];
      $sizes = [];
      $data = [];

      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      $spreadsheet = $reader->load($file_path . $file_name);
      $sheet = $spreadsheet->getSheet(0);
      //$data = $sheet->toArray();

      foreach ($sheet->getRowIterator() as $row) {
        $row_count++;
        //if($row_count == 0) { continue; }

        $cellIterator = $row->getCellIterator();
        $obj = ['sizes' => []];

        if($row_count == 0){ //first row in the excel sheet, check sizes
          $cc = -1;
          foreach ($cellIterator as $cell) {
            $cc++;
            if($cc <= sizeof($columns)) { continue; }

            if(trim($cell->getValue()) != ''){
              $sizes[$cell->getColumn()] = $cell->getValue();
            }
            else {
              break;
            }
          }
        }
        else {
          foreach ($cellIterator as $cell) {
              if(isset($columns[$cell->getColumn()])){
                $obj[$columns[$cell->getColumn()]] = $cell->getValue();
              }
              else if(isset($sizes[$cell->getColumn()])){
                $obj['sizes'][$sizes[$cell->getColumn()]] = $cell->getValue();
              }
          }
        }

        array_push($data, $obj);
        if($row_count > 3){ //limit readable rows count, for testing
          break;
        }
      }

      //get size wise details from size codes
      $size_objects = [];
      $has_size_errors = false;
      foreach ($sizes as $key => $value) {
        $s = $this->order_model->get_size_from_code($value);
        if($s != null){
          $size_objects[$value] = $s;
        }
        else {
          $has_size_errors = true;
          $this->log_errors('Error - Incorrect size : ' . $value);
          break;
        }
      }

      if($has_size_errors == true){
        return;
      }

      $header_data = [];
      $row_count = 0;
      unset($data[0]);// not contains any value
    //  echo json_encode($data[0]);die();
      foreach ($data as $row) {

        $row_count++;

        $style = $this->order_model->get_style_from_code($row['STYLE']);
        if($style == null){
          $this->log_errors("\n Row - ".$row_count." :: Incorrect style");
          continue;
        }

        $color = $this->order_model->get_color_from_code($row['COLOR']);
        if($color == null){
          $this->log_errors("\n Row - ".$row_count." :: Incorrect color");
          continue;
        }

        $country = $this->order_model->get_country_from_code($row['COUNTRY']);
        if($country == null){
          $this->log_errors("\n Row - ".$row_count." :: Incorrect country");
          continue;
        }

        $season = $this->order_model->get_season_from_code($row['SEASON']);
        if($season == null){
          $this->log_errors("\n Row - ".$row_count." :: Incorrect season");
          continue;
        }

        $customer = $this->order_model->get_customer_from_code($row['CUSTOMER']);
        if($customer == null){
          $this->log_errors("\n Row - ".$row_count." :: Incorrect style");
          continue;
        }

        if($style['item_id'] == null){
          $this->log_errors("\n Row - ".$row_count." :: Item not assigned for the style");
          continue;
        }

        $item_components = $this->item_model->get_item_components($style['item_id']);
        if($item_components == null || sizeof($item_components) <= 0){
          $this->log_errors("\n Row - ".$row_count." :: item components not avaliable");
          continue;
        }

        $user_id = $this->session->userdata('user_id');
        $cur_date = date("Y-m-d H:i:s");
        $order_code = $style['style_code'].'::'.$color['color_code'].'::'.$row['BUY'].'::'.$row['DELIVERY_SEQ'];

        $prev_orders = $this->order_model->get_order_from_po_and_color($row['CUSTOMER_PO'], $color['color_id']);
        if($prev_orders != null && sizeof($prev_orders) > 0){
          $this->log_errors("\n Row - ".$row_count." :: order already exists for this customer PO and color");
          continue;
        }

        $header_data['order_code'] = $order_code;
        $header_data['style'] = $style['style_id'];
        $header_data['color'] = $color['color_id'];
        $header_data['customer_po'] = $row['CUSTOMER_PO'];
        $header_data['uom'] = 'PCS';
        $header_data['customer'] = $customer['id'];
        $header_data['country'] = $country['country_id'];
        $header_data['season'] = $season['season_id'];
        $header_data['ship_method'] = $row['SHIP_MODE'];
        $header_data['delivary_date'] = $row['CUSTOMER_REQUESTED_DATE'];
        $header_data['planned_delivary_date'] = $row['AGREED_DELIVERY_DATE'];
        $header_data['pcd_date'] = $row['POSSIBLE_PCD'];
        $header_data['created_by'] = $user_id;
        $header_data['created_at'] = $cur_date;
        $header_data['updated_by'] = $user_id;
        $header_data['updated_at'] = $cur_date;
        $header_data['active'] = 'Y';
        $header_data['smv'] = $row['SMV'];
        $header_data['is_complete'] = 0;

        $order_id = $this->order_model->create($header_data);

        $item_data = [
          'order_id' => $order_id,
          'item' => $style['item_id'],
          'item_color' => $color['color_id'],
          'created_by' => $user_id,
          'created_at' => $cur_date,
          'updated_by' => $user_id,
          'updated_at' => $cur_date
        ];

        $components = [];
        foreach ($item_components as $ic) {
          $com = [
            'component_id' => $ic['component_id'],
            'color_id' => $color['color_id']
          ];
          array_push($components, $com);
        }

        $size_data = [];
        $total_size_qty = 0;
        foreach ($row['sizes'] as $key => $value) {
          if($value != null && $value != '' && $value > 0){
            $ss = [
             'size_id' => $size_objects[$key]['size_id'],
             'order_qty' => $value,
             'planned_qty' => $value
            ];
            array_push($size_data, $ss);
            $total_size_qty += $value;
          }
        }

        $this->order_item_model->create($item_data, $components, $size_data);

        //update order sales qty
        $sales_data = [
          'order_id' => $order_id,
          'sales_qty' => $total_size_qty
        ];
        $this->order_model->update($sales_data);

      }
      echo 'success';
      //echo json_encode($data);die();
    }


    private function log_errors($message){
      echo "\n ". $message." \n";
    }

// ORDER RECONCILIATION REPORT -------------------------------------------------

    public function reconciliation_report($order_id){
      $this->login_model->user_authentication('ORDER_VIEW');
      $this->load->model('order/order_item_model');
      $data = $this->get_order_data($order_id);
      $this->load->view('order/order_reconciliation_report',$data);
      //$this->load->view('order/order_reconciliation_report_email',$data);
    }


    public function complete_order(){
      $this->load->library('Email_Sender');
      $this->load->model('order/order_item_model');
      $order_id = $this->input->post('order_id');
      $this->order_model->complete_order($order_id);
      $this->order_model->complete_order_productions($order_id);
      $data = $this->get_order_data($order_id);

      $arr = array(
         'to' => 'chamila@dignitydtrt.com',
         'subject' => 'Order Reconciliation For : '. $order_id,
         'data' =>  $data,
         'attachments' => null,
         'email_view_path' => 'order/order_reconciliation_report_email'
      );

   $mail_arr = [];
   array_push($mail_arr,$arr);
   if($this->email_sender->send_mail($mail_arr)){
     echo json_encode([
       'status' => 'success',
       'message' => 'Order was completed successfully'
     ]);
   }
    else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Email sending fail'
      ]);
    }

    }


    public function not_complete_order(){
      $this->load->library('Email_Sender');
      $this->load->model('order/order_item_model');
      $order_id = $this->input->post('order_id');
      $this->order_model->not_complete_order($order_id);
      $this->order_model->not_complete_order_productions($order_id);
      $data = $this->get_order_data($order_id);

      $arr = array(
         'to' => 'chamila@dignitydtrt.com',
         'subject' => 'Order Reconciliation Revised For : '. $order_id,
         'data' =>  $data,
         'attachments' => null,
         'email_view_path' => 'order/order_reconciliation_report_email'
      );

    $mail_arr = [];
    array_push($mail_arr,$arr);
    if($this->email_sender->send_mail($mail_arr)){
     echo json_encode([
       'status' => 'success',
       'message' => 'Order was mark as not completed successfully'
     ]);
    }
    else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Email sending fail'
      ]);
    }

    }



    public function get_order_data($order_id){
      $data = [];
      $data['order'] = $this->order_model->get($order_id);
      $data['items'] = $this->order_item_model->get_list($order_id);
      for($x = 0 ; $x < sizeof($data['items']) ; $x++) {
        $data['items'][$x]['components'] = $this->order_item_model->get_components($data['items'][$x]['id']);
        $data['items'][$x]['sizes'] = $this->order_item_model->get_sizes($data['items'][$x]['id']);
      }
      $data['status_data'] = $this->order_model->get_order_status_data($order_id);
      return $data;
    }


    public function order_code_search()
    {
      $search_term = $this->input->get('term');
      $data = $this->order_model->order_code_search($search_term);
      echo json_encode([
        'results' => $data
        ]);
    }
}
