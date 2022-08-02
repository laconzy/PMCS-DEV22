<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get($data = 'ALL')
    {
        if($data == 'ALL'){
          $query = $this->db->get('country');
      		return $query->result_array();
        }
		    else{
          $this->db->where('id',$data);
      		$query = $this->db->get('country');
      		return $query->row_array();
        }
    }

}
