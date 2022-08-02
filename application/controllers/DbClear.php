<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DbClear extends CI_Controller {

    public function __construct()
    {
         parent::__construct();
         $this->load->model('db_clear_model');
    }

    public function index()
    {
      //get orders
      $date = '2022-01-01 00:00:00';
      $today = date("Y-m-d H-i-s");
      $logfile = fopen($today .".txt", "w");
      $limit = 2;

      $this->add_log($logfile, 'Strat cleaning process - ' . $date." \n");

      $orders = $this->db_clear_model->get_expired_orders($date, 10);
      if($orders != null && sizeof($orders) > 0){
        foreach ($orders as $row) {

          $this->add_log($logfile, "\n Order ID - " . $row['order_id']);
          $this->add_log($logfile, "------------------------------------------------------------- \n");

          // $row_count = 1;
          // $this->add_log($logfile, 'Deleteing cut bundles');
          // while($row_count == 0){
          //   $row_count =
          //   $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          // }

          //delete from cut_bundles
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing cut bundles');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_cut_bundles($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }

          //delete from cut_bundles_2
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing cut bundles 2');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_cut_bundles2($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from cut_laysheet
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing cut laysheet');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_cut_laysheet($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from production
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing production');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_production($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from fg
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing FG');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_fg($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from barcode, fg_barcode, fg_barcode_header
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing Barcodes');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_barcodes($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }

          $row_count = 1;
          $this->add_log($logfile, 'Deleteing FG Barcode Head');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_fg_barcode_head($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }

          $row_count = 1;
          $this->add_log($logfile, 'Deleteing FG Barcode');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_fg_barcode($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }

          //delete from rejection
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing Rejection');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_rejection($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from order_item_components
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing Item Components');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_item_components($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from order_item_sizes
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing Item Sizes');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_item_sizes($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from order_items
          $row_count = 1;
          $this->add_log($logfile, 'Deleteing Items');
          while($row_count > 0){
            $row_count = $this->db_clear_model->delete_order_items($row['order_id'], $limit);
            $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          }


          //delete from order_head
          // $row_count = 1;
          // $this->add_log($logfile, 'Deleteing Order');
          // while($row_count > 0){
          //   $row_count = $this->db_clear_model->delete_order_head($row['order_id'], $limit);
          //   $this->add_log($logfile, 'Affected Rows - ' . $row_count);
          // }

        }
      }

    }


    public function add_log($logfile, $msg){
     fwrite($logfile, $msg);
     fwrite($logfile, "\n");
    }



}
