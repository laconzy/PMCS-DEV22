<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class rejection_Model extends CI_Model

{



  public function __construct()

  {

    parent::__construct();

    $this->load->database();

  }



    /**public function create($data) {

      $this->db->insert_batch('cut_bundles', $data);

    }*/







    /*public function destroy($order_id,$operation_id,$operation_point,$barcode) {

      $this->db->where('order_id', $order_id);

      $this->db->where('operation', $operation_id);

      $this->db->where('operation_point', $operation_point);

      $this->db->where('barcode', $barcode);

      $this->db->delete('production');

      return true;

    }*/

    public function get_size($order_id){

      $sql = "SELECT
      size.size_code,
      order_head.order_code,
      order_head.customer_po,
      order_item_sizes.size
      FROM
      order_item_sizes
      INNER JOIN size ON order_item_sizes.size = size.size_id
      INNER JOIN order_head ON order_item_sizes.order_id = order_head.order_id
      WHERE
      order_item_sizes.order_id =$order_id";

      $query = $this->db->query($sql);

      $result = $query->result_array();


      return $result;


    }





    public function get_bundle($order_id, $operation_id, $barcode){

      $this->db->select('production.*,size.size_code,item.item_code');

      $this->db->from('production');

      $this->db->join('size' , 'production.size = size.size_id');

      $this->db->join('item' , 'production.item = item.item_id');

      $this->db->where('production.order_id',$order_id);

      $this->db->where('production.operation',$operation_id);

      //$this->db->where('production.operation_point','IN');

      $this->db->where('production.barcode',$barcode);

      $query = $this->db->get();

      return $query->result_array();

    }





    public function is_rejected($order_id, $operation_id, $barcode){

      $this->db->where('order_id', $order_id);

      $this->db->where('operation', $operation_id);

      $this->db->where('barcode', $barcode);

      $this->db->from('rejected_bundles');

      if($this->db->count_all_results() > 0){

        return true;

      }

      else{

        return false;

      }

    }





    public function get_rejected_bundles($order_id, $operation_id){

      $this->db->select('rejected_bundles.*,size.size_code,item.item_code');

      $this->db->from('rejected_bundles');

      $this->db->join('size' , 'rejected_bundles.size = size.size_id');

      $this->db->join('item' , 'rejected_bundles.item = item.item_id');

      $this->db->where('rejected_bundles.order_id',$order_id);

    //  $this->db->where('rejected_bundles.operation',$operation_id);*/

      $query = $this->db->get();

      return $query->result_array();

    }





    public function save_bundle($data){

      $current_timestamp = date("Y-m-d H:i:s");

      $current_user = $this->session->userdata('user_id');

      $inser_data = [

        'order_id' => $data['order_id'],

        'laysheet_no' => $data['laysheet_no'],

        'bundle_no' => $data['bundle_no'],

        'barcode' => $data['barcode'],

        'item' => $data['item'],

        'size' => $data['size'],

        'qty' => $data['qty'],

        'operation' => $data['operation'],

        'rejected_qty' =>  $data['rejected_qty']

      ];

      $inser_data['created_date'] = $current_timestamp;

      $inser_data['created_by'] = $current_user;

      $this->db->insert('rejected_bundles', $inser_data);

    }





    public function remove_barcodes($order_id, $operation_id, $barcodes){

      $barcode_str = implode(',' , $barcodes);

      $sql = "DELETE FROM rejected_bundles WHERE order_id = ? AND operation = ? AND barcode IN (".$barcode_str.")";

      $this->db->query($sql , [$order_id , $operation_id]);

      return true;

    }



    public function save_data($order_id, $line_no, $hour, $size, $qty,$status,$shift,$op_name,$operation,$reason_code,$site_id = null){

      $current_timestamp = date("Y-m-d H:i:s");
      $date = date("Y-m-d");
      $date = $this->input->post('date');

      $current_user = $this->session->userdata('user_id');
      $qty = $this->input->post('qty');

      $style_id = null;
      $color_id = null;
      $order_data = $this->get_order($order_id);
      if($order_data != null){
        $style_id = $order_data['style'];
        $color_id = $order_data['color'];
      }

      $inser_data = [

        'order_id' => $order_id,
        'size' => $size,
        'operation' => $operation,
        'operation_name' => $op_name,
        'created_by' => $current_user,
        'created_date' => $current_timestamp,
        'status' => $status,
        'line_no' =>$line_no,
        'shift' =>$shift,
        'scan_date' =>$date,
        'qty' =>  $qty,
        'hour' =>  $hour,
        'reason_code' =>  $reason_code,
        'style_id' => $style_id,
        'color_id' => $color_id,
        'receive_location' => $site_id
      ];
    //  print_r( $inser_data);

      // $inser_data['created_date'] = $current_timestamp;

      // $inser_data['created_by'] = $current_user;

      $this->db->insert('rejection', $inser_data);

    }


    function load_qty($date,$shift,$line,$operation){

      $sql="SELECT
      Sum(rejection.qty) AS qty
      FROM `rejection`
      WHERE
      rejection.scan_date = '".$date."' AND
      rejection.line_no = '".$line."'  AND
      rejection.shift = '".$shift."' AND
      rejection.operation = '".$operation."'
      ";

      $query = $this->db->query($sql);
      $row = $query->row();
      return $row->qty;

    }


  function total_prod_qty($order_id, $size, $operation){

      $sql="SELECT
            Sum(production.qty) qty
            FROM `production`
            WHERE
            production.order_id = $order_id AND production.size = ".$size." AND
            production.operation = $operation";

        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->qty;

    }

 function reject_qty_po($order_id, $size){

      $sql="SELECT
            Sum(rejection.qty)AS qty
          FROM
            `rejection`
          WHERE
            rejection.order_id = $order_id AND rejection.size=".$size;

      $query = $this->db->query($sql);
      $row = $query->row();
      return $row->qty;

    }

    function load_reject_list_1($date){
      $date = $this->input->get('date');
    //  $line_no = $this->input->post('date');
      $status = $this->input->get('status');
     // $order_id = $this->input->post('date');



     $sql="SELECT
*,
size.size_code,
order_head.order_code,
line.line_code
FROM
rejection
INNER JOIN size ON rejection.size = size.size_id
INNER JOIN order_head ON rejection.order_id = order_head.order_id
INNER JOIN line ON rejection.line_no = line.line_id
WHERE
rejection.`status` = '".$status."'
AND
rejection.scan_date = '".$date."'
";

     $query = $this->db->query($sql);

      $result = $query->result_array();


      return $result;


    }


     function load_reject_list($date){
      $date = $this->input->get('date');



       $sql="SELECT
*,
size.size_code,
order_head.order_code,
line.line_code
FROM
rejection
INNER JOIN size ON rejection.size = size.size_id
INNER JOIN order_head ON rejection.order_id = order_head.order_id
INNER JOIN line ON rejection.line_no = line.line_id
WHERE
rejection.`status` = 'PENDING'
AND
rejection.scan_date = '".$date."'
";

     $query = $this->db->query($sql);

      $result = $query->result_array();


      return $result;


    }


public function destroy($id)
  {

    $this->db->where('id', $id);

    $this->db->delete('rejection');

    return true;
  }


    public function confirm($data) {
     $site_id = $this->input->post('site_id');
      for ($i=0; $i < sizeof($data); $i++) {
         $row['status'] = 'CONFIRMED';
         $row['confirmed_by'] = $this->session->userdata('user_id');
         $row['confirmed_date'] = date("Y-m-d H:i:s");
         $row['receive_location'] =$site_id;
         $this->db->update('rejection', $row);
        # code...
      }
      // foreach ($data as $row) {

      //   echo $row;
      // }

// foreach ($data as $row) {
//             $this->db->where('id', $row['id']);
//             $data['status'] = 'CONFIRMED';

//           $this->db->update('rejection', $data);
// }

        // $data['updated_at'] = date("Y-m-d H:i:s");

        // $data['updated_by'] = $this->session->userdata('user_id');



        // return $data['order_id'];

    }

    public function get_order($order_id){
    		$this->db->where('order_id', $order_id);
    		$query = $this->db->get('order_head');
    		return $query->row_array();
    }

  }
