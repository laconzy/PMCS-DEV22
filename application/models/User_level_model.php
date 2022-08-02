<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_Level_Model extends CI_Model 
{     
    public function __construct() 
    { 
        parent::__construct(); 
        $this->load->database(); 
    } 
    
    public function get_all_user_levels()
    {
        $this->db->select('*');
        $this->db->from('user_levels');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}