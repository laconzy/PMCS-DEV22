<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_Clear_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_expired_orders($date, $limit){
      $sql = "SELECT * FROM order_head WHERE created_at < '".$date."' ORDER BY order_id LIMIT 0,".$limit;
      $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function delete_cut_bundles($order_id, $limit){
      $sql = "DELETE FROM cut_bundles WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
      return $this->db->affected_rows();
    }

    public function delete_cut_bundles2($order_id, $limit){
      $sql = "DELETE FROM cut_bundles_2 WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }


    public function delete_cut_laysheet($order_id, $limit){
      $sql = "DELETE FROM cut_laysheet WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }


    public function delete_production($order_id, $limit){
      $sql = "DELETE FROM production WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_fg($order_id, $limit){
      $sql = "DELETE FROM fg WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_rejection($order_id, $limit){
      $sql = "DELETE FROM rejection WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_item_components($order_id, $limit){
      $sql = "DELETE FROM order_item_components WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_item_sizes($order_id, $limit){
      $sql = "DELETE FROM order_item_sizes WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_order_items($order_id, $limit){
      $sql = "DELETE FROM order_items WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }


    public function delete_order_head($order_id, $limit){
      $sql = "DELETE FROM order_head WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }


    // public function get_brcode_ids($order_id){
    //   $sql = "SELECT * FROM fg_barcode WHERE order_id = ".$order_id;
    //   $query = $this->db->query($sql);
    //   return $query->result_array();
    // }

    public function delete_barcodes($order_id, $limit){
      $sql = "DELETE FROM barcode WHERE id IN (SELECT id FROM fg_barcode WHERE order_id = ".$order_id.") LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_fg_barcode_head($order_id, $limit){
      $sql = "DELETE FROM fg_barcode_head WHERE id IN (SELECT id FROM fg_barcode WHERE order_id = ".$order_id.") LIMIT ".$limit;
      $this->db->query($sql);
    }

    public function delete_fg_barcode($order_id, $limit){
      $sql = "DELETE FROM fg_barcode WHERE order_id = ".$order_id." LIMIT ".$limit;
      $this->db->query($sql);
    }
}
