<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dash_model extends CI_Model

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

public function get_production_detail()
  {
      $section = $this->input->get('section');
        $cur_date = date("Y-m-d");
        $cur_time = date("H:i:s");
        $startTime = strtotime('19:00:00');
        $shift='A';
        if($cur_time>$startTime){
            $shift='B';

        }
     $sql = "SELECT
            production_dashboard.qty,
            production_dashboard.line_no,
            production_dashboard.date,
            production_dashboard.line_code,
            production_dashboard.category,
            production_dashboard.seq,
            production_dashboard.shift,
            production_dashboard.section,
            production_dashboard.commited,
            production_dashboard.plan_qty,
            production_dashboard.hrs,
            production_dashboard.commited_by,
            production_dashboard.style_name,
            production_dashboard.style_cat,
            production_dashboard.per_hour,
            IFNULL(production_dashboard.`1`,0) '1',
            IFNULL(production_dashboard.`2`,0) '2',
            IFNULL(production_dashboard.`3`,0) '3',
            IFNULL(production_dashboard.`4`,0) '4',
            IFNULL(production_dashboard.`5`,0) '5',
            IFNULL(production_dashboard.`6`,0) '6',
            IFNULL(production_dashboard.`7`,0) '7',
            IFNULL(production_dashboard.`8`,0) '8',
            IFNULL(production_dashboard.`9`,0) '9',
            IFNULL(production_dashboard.`10`,0) '10',
           IFNULL(production_dashboard.`11`,0) '11',
            IFNULL(production_dashboard.`12`,0) '12'
            FROM production_dashboard
            WHERE
            production_dashboard.date = '".$cur_date."' AND
            production_dashboard.section = '".$section."' AND
            production_dashboard.shift = '".$shift."'
            ORDER BY
            production_dashboard.style_cat ASC, 
            production_dashboard.line_no ASC 
            ";
    $query = $this->db->query($sql);


    return $query->result_array();
  }


}

