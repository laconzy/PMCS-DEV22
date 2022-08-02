<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Order_Model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }



    public function create($data) {

      //date_default_timezone_set("Asia/Colombo");

      $cur_date = date("Y-m-d H:i:s");

      $data['created_by'] = $this->session->userdata('user_id');

      $data['updated_by'] = $this->session->userdata('user_id');

      $data['created_at'] = $cur_date;

      $data['updated_at'] = $cur_date;



      $this->db->insert('order_head',$data);

      return $this->db->insert_id();

    }



    public function update($data) {

        $data['updated_at'] = date("Y-m-d H:i:s");

        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('order_id', $data['order_id']);

        $this->db->update('order_head', $data);

        return $data['order_id'];

    }



    public function get($id){

      $this->db->select('order_head.*,style.style_code,style.style_name,

        color.color_code,color.color_name,

        customer.cus_code,customer.cus_name as customer_name,

        season.season_name'

      );

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('season','order_head.season = season.season_id');

      $this->db->where('order_id',$id);

      $query = $this->db->get();

      return $query->row_array();

    }



    public function get_list($start,$limit,$search,$order)

  	{

      $this->db->select('order_head.*,style.style_name,color.color_name,customer.cus_name,season.season_name,country.country_name');

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('country','order_head.country = country.country_id');

      $this->db->join('season','order_head.season = season.season_id');

      $like_fields = [

        'order_id' => $search,

        'order_code' => $search,

        'style_name' => $search,

        'color_name' => $search,

        'cus_name' => $search,

        'season_name' => $search

      ];

      $this->db->or_like($like_fields);

  		$query = $this->db->get();
		$a=$this->db->last_query();
		//print_r($a);
  		return $query->result_array();

  	}



  	public function get_count($search)

  	{

    //  $this->db->select('order_head.*,style.style_name,color.color_name,customer.cus_name,season.season_name,country.country_name');

      $this->db->from('order_head');

      $this->db->join('style','order_head.style = style.style_id');

      $this->db->join('color','order_head.color = color.color_id');

      $this->db->join('customer','order_head.customer = customer.id');

      $this->db->join('country','order_head.country = country.country_id');

      $this->db->join('season','order_head.season = season.season_id');

      $like_fields = [

        'order_id' => $search,

        'order_code' => $search,

        'style_name' => $search,

        'color_name' => $search,

        'cus_name' => $search,

        'season_name' => $search

      ];

      $this->db->like($like_fields);

  		$count = $this->db->count_all_results();

  		return $count;

  	}



    public function destroy($id) {

      $this->db->where('order_id', $id);

      $this->db->update('order_head', array('active' => 'N'));

      return true;

    }



}

