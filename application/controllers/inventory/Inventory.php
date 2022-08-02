<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Inventory extends CI_Controller {


     public function __construct()  {
         parent::__construct();
         $this->load->model('login_model');
		     $this->load->model('master/color_model');
         $this->load->model('cutting/bundle_model');
         $this->load->model('fg/fg_model');
         $this->load->model(['production/production_model', 'master/line_model']);
         $this->load->model('inventory/inventory_model');
    }

    public function index() {
    	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        //$data['po'] = $this->inventory_model->get_po_number();
        //$data['store'] = $this->inventory_model->stores();
        $data['buyer_codes'] = $this->inventory_model->get_buyer_codes();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('inventory/inventory',$data);
    }


    public function inventory_list() {
    	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        $data['menu_code'] = 'MENU_MASTER';
        $this->load->view('inventory/inventory_list',$data);
    }

    public function inventory_view($id) {
    	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['menus'] = $this->login_model->get_authorized_menus();
        //$data['po'] = $this->inventory_model->get_po_number();
        //$data['store'] = $this->inventory_model->stores();
        $data['packing_id'] = $id;
        $data['header_data'] = $this->inventory_model->get_packing_list_header($id);
        $data['roles'] = $this->inventory_model->get_added_roles($id);
        $data['buyer_codes'] = $this->inventory_model->get_buyer_codes();
        $data['menu_code'] = 'MENU_MASTER';
        $data['UNCONFIRM_PERMISSION'] = ($this->login_model->has_permission('INV_UNCONFIRM') == true) ? 'Y' : 'N';
        $this->load->view('inventory/inventory',$data);
    }


    public function inventory_print($id) {
    	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['packing_id'] = $id;
        $data['header_data'] = $this->inventory_model->get_packing_list_header($id);
        $data['roles'] = $this->inventory_model->get_added_roles($id);
        $data['buyer_codes'] = $this->inventory_model->get_buyer_codes();
        $this->load->view('inventory/inventory_print',$data);
    }





    public function get_packing_lists()
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

          $list = $this->inventory_model->get_packing_lists($start,$length,$search,$order_column);
          $count = $this->inventory_model->get_packing_lists_count($search);
          echo json_encode(array(
              "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $list
          ));
      }



    public function create_packing_list(){
        //$barcode = $this->input->post('barcode');
        $scan_date = $this->input->post('scan_date');
        $laysheet = $this->input->post('laysheet');
        $customer = $this->input->post('customer');
        $style = $this->input->post('style');
        $order_code = $this->input->post('order_code');
        $remarks = $this->input->post('remarks');

        $result = $this->inventory_model->create_packing_list($scan_date, $laysheet, $customer, $style, $order_code, $remarks);
        echo json_encode([
            'status' => 'success',
            'message' => 'Packing list created successfully.',
            'id' => $result
        ]);


    }

     public function scan_barcode(){
        $data = array();
        $barcode = $this->input->post('barcode');
        $packing_id = $this->input->post('packing_id');

        $is_already_scanned = $this->inventory_model->is_already_scanned($packing_id, $barcode);
        if($is_already_scanned == true){
          echo json_encode([
              'status' => 'error',
              'message' => 'Barcode already scanned for this packing list',
              'data' => []
          ]);
        }
        else {
          $result = $this->inventory_model->get_barcode_data($barcode);
          if($result == null){
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect barcode details',
                'data' => []
            ]);
            return;
          }

          $actual_qty = ($result['actchchual'] == null) ? 0 : $result['actchchual'];
          $packed_qty = ($result['packed_qty'] == null) ? 0 : $result['packed_qty'];
          $remaning_qty = $actual_qty - $packed_qty;

          if($remaning_qty <= 0){
            echo json_encode([
                'status' => 'error',
                'message' => 'No stock available',
                'data' => []
            ]);
          }
          else {
            echo json_encode([
                'status' => 'success',
                'data' => $result
            ]);
          }
        }
     }


     public function add_role(){
       $barcode = $this->input->post('barcode');
       $qty = $this->input->post('qty');
       $pack_list_id = $this->input->post('pack_list_id');

       $is_already_scanned = $this->inventory_model->is_already_scanned($pack_list_id, $barcode);
       if($is_already_scanned == true){
         echo json_encode([
             'status' => 'error',
             'message' => 'Barcode already scanned for this packing list',
             'data' => []
         ]);
         return;
       }

       $result = $this->inventory_model->get_barcode_data($barcode);
       if($result == null){
         echo json_encode([
             'status' => 'error',
             'message' => 'Incorrect barcode details',
             'data' => []
         ]);
         return;
       }

       $actual_qty = ($result['actchchual'] == null) ? 0 : $result['actchchual'];
       $packed_qty = ($result['packed_qty'] == null) ? 0 : $result['packed_qty'];
       $remaning_qty = $actual_qty - $packed_qty;
       $remaning_qty = round($remaning_qty,4);

       if($remaning_qty <= 0){
         echo json_encode([
             'status' => 'error',
             'message' => 'No stock available',
             'data' => []
         ]);
         return;
       }

       if($remaning_qty < $qty){
         echo json_encode([
             'status' => 'error',
             'message' => 'Not enough stock available',
             'data' => []
         ]);
         return;
       }


       $inserted_id = $this->inventory_model->add_role($pack_list_id, $barcode, $qty);
       $role_details = $this->inventory_model->get_added_role($inserted_id);
       echo json_encode([
         'status' => 'success',
         'message' => 'Role added successfully',
         'data' => $role_details
       ]);
     }


     public function destroy(){
       $packing_id = $this->input->post('packing_id');
       $details_id = $this->input->post('item');
       $list = [$details_id];
       $this->inventory_model->destroy_list($packing_id, $list);
       echo json_encode([
         'status' => 'success',
         'message' => 'Removed successfully'
       ]);
     }


     public function destroy_list(){
       $packing_id = $this->input->post('packing_id');
       $details_ids = $this->input->post('items');
       $this->inventory_model->destroy_list($packing_id, $details_ids);
       echo json_encode([
         'status' => 'success',
         'message' => 'Removed successfully'
       ]);
     }


     public function confirm(){
       $packing_id = $this->input->post('packing_id');
       $this->inventory_model->confirm($packing_id);
       echo json_encode([
         'status' => 'success',
         'message' => 'Packing list confirmed successfully'
       ]);
     }


     public function unconfirm(){
       $packing_id = $this->input->post('packing_id');
       $this->inventory_model->unconfirm($packing_id);
       echo json_encode([
         'status' => 'success',
         'message' => 'Packing list revoked successfully'
       ]);
     }




     //report ------------------------------------------------------------------

     public function receiving() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['main_stores'] = $this->inventory_model->get_main_stores();
        $this->load->view('inventory/receiving',$data);
     }

     public function get_receiving_data(){
       $fabric_code = $this->input->get('fabric_code');
       $color = $this->input->get('color');
       $date_from = $this->input->get('date_from');
       $date_to = $this->input->get('date_to');
       $received_date_from = $this->input->get('received_date_from');
       $received_date_to = $this->input->get('received_date_to');
       $main_store = $this->input->get('main_store');
       $invoice = $this->input->get('invoice');
       $pi_no = $this->input->get('pi_no');
       $status = $this->input->get('status');

       $data = $this->inventory_model->get_receiving_data($fabric_code, $color, $date_from, $date_to, $received_date_from, $received_date_to, $main_store, $invoice, $pi_no, $status);
       echo json_encode([
         'data' => $data
       ]);
     }


     //report ------------------------------------------------------------------

     public function fabric_allocation() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['main_stores'] = $this->inventory_model->get_main_stores();
        $this->load->view('inventory/fabric_allocation',$data);
     }


     public function get_fabric_allocation_data(){
       $fabric_code = $this->input->get('fabric_code');
       $color = $this->input->get('color');
       $date_from = $this->input->get('date_from');
       $date_to = $this->input->get('date_to');
       $received_date_from = $this->input->get('received_date_from');
       $received_date_to = $this->input->get('received_date_to');
       $main_store = $this->input->get('main_store');
       $invoice = $this->input->get('invoice');
       $pi_no = $this->input->get('pi_no');
       $status = $this->input->get('status');
       $role_no = $this->input->get('role_no');

       $data = $this->inventory_model->get_fabric_allocation_data($fabric_code, $color, $date_from, $date_to, $received_date_from, $received_date_to, $main_store, $invoice, $pi_no, $status, $role_no);
       echo json_encode([
         'data' => $data
       ]);
     }

     public function allocate_customer_po(){
       $barcode_list = $this->input->post('barcode_list');
       $customer_po = $this->input->post('customer_po');

       $this->inventory_model->allocate_customer_po($customer_po, $barcode_list);
       echo json_encode([
         'status' => 'success',
         'message' => 'Customer PO allocated successfully'
       ]);
     }


     //fabric inspection -------------------------------------------------------

     public function fabric_inspection() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['main_stores'] = $this->inventory_model->get_main_stores();
        $this->load->view('inventory/fabric_inspection',$data);
     }


     public function change_inspection_status(){
       $barcode_list = $this->input->post('barcode_list');
       $status = $this->input->post('status');

       $is_issued = $this->inventory_model->is_role_issued($barcode_list);
       if($is_issued == true){
         echo json_encode([
           'status' => 'error',
           'message' => 'One or more selected roles were already issued'
         ]);
         return;
       }

       $this->inventory_model->change_inspection_status($status, $barcode_list);
       echo json_encode([
         'status' => 'success',
         'message' => 'Status changed successfully'
       ]);
     }


     public function change_width(){
       $barcode_list = $this->input->post('barcode_list');
       $width = $this->input->post('width');

       $is_issued = $this->inventory_model->is_role_issued($barcode_list);
       if($is_issued == true){
         echo json_encode([
           'status' => 'error',
           'message' => 'One or more selected roles were already issued'
         ]);
         return;
       }

       $this->inventory_model->change_width($width, $barcode_list);
       echo json_encode([
         'status' => 'success',
         'message' => 'Width changed successfully'
       ]);
     }


     public function change_shade(){
       $barcode_list = $this->input->post('barcode_list');
       $shade = $this->input->post('shade');

       $is_issued = $this->inventory_model->is_role_issued($barcode_list);
       if($is_issued == true){
         echo json_encode([
           'status' => 'error',
           'message' => 'One or more selected roles were already issued'
         ]);
         return;
       }

       $this->inventory_model->change_shade($shade, $barcode_list);
       echo json_encode([
         'status' => 'success',
         'message' => 'Shade changed successfully'
       ]);
     }


     //label prints ------------------------------------------------------------

     public function print_labels() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $data['main_stores'] = $this->inventory_model->get_main_stores();
        $this->load->view('inventory/print_labels',$data);
     }


     public function print_labels_view() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $this->load->view('inventory/print_labels_view',$data);
     }


     public function print_labels_view2() {
       	$this->login_model->user_authentication(null);//check permission
        $data = array();
        $this->load->view('inventory/print_labels_view2',$data);
     }


     public function get_print_labels_data(){
       $barcodes = $this->input->post('barcodes');
       $data = $this->inventory_model->get_print_labels_data($barcodes);
       echo json_encode([
         'data' => $data
       ]);
     }



   /*  public function get_packing_labels_data(){
      $barcodes = $this->input->post('barcodes');
       $data = $this->inventory_model->get_print_labels_data($barcodes);





       echo json_encode([
         'data' => $data
       ]);
     }*/





     public function packinglist_print($id) {
      $this->login_model->user_authentication(null);//check permission
      $data = array();
      $data['packing_id'] = $id;
      $data['header_data'] = $this->inventory_model->get_packing_list_header($id);
      $data['roles'] = $this->inventory_model->get_added_roles($id);
      $data['buyer_codes'] = $this->inventory_model->get_buyer_codes();
      $this->load->view('inventory/packinglist_print',$data);

      
        
    }

}
