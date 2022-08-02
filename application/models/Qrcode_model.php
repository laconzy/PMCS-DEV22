<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qrcode_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_qr_info(){
      $sql = "SELECT * FROM qr_info";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

}
