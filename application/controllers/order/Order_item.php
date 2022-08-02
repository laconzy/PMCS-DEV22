<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_item extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('order/order_item_model');
    }

    public function index()
    {
    }


    public function listing(){

    }


    public function show($id){

    }


    public function save(){
      $this->login_model->user_authentication(null); // user permission authentication
      $data = $this->input->post('data');
      $components = $this->input->post('components');
      $sizes = $this->input->post('sizes');
      $order_item_id = 0;
      if($data['order_item_id'] <= 0){
        $order_item_id = $this->order_item_model->create($data , $components , $sizes);
      }
      else {
        $order_item_id = $this->order_item_model->update($data , $components , $sizes);
      }
      $data = array(
        'status' => 'success',
        'message' => 'Order item was saved successfully.',
        'order_item' => $this->order_item_model->get($order_item_id)
      );
      echo json_encode($data);
    }


    public function get($id = 0 , $type = null ) {
      if($type == 'all'){
        echo json_encode([
          'data' => $this->order_item_model->get_list($id)
        ]);
      }
      else if($type == null){
        echo json_encode([
          'data' => $this->order_item_model->get($id),
          'components' => $this->order_item_model->get_components($id),
          'sizes' => $this->order_item_model->get_sizes($id)
        ]);
      }
    }


    public function destroy($id) {
      $this->order_item_model->destroy($id);
      echo json_encode([
        'status' => 'success',
        'message' => 'Item was deleted successfully'
      ]);
    }


}
