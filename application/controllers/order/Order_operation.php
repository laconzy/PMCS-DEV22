<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_operation extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('order/order_operation_model');
    }

    public function save(){
      $this->login_model->user_authentication(null); // user permission authentication
      $data = $this->input->post('data');
      $order_item_id = $this->order_operation_model->create($data);
      $data = array(
        'status' => 'success',
        'message' => 'Order operation was saved successfully.',
        'operation' => $this->order_operation_model->get($data['order_id'] , $data['operation'])
      );
      echo json_encode($data);
    }


    public function get($id = 0 , $type = null ) {
      if($type == 'all'){
        echo json_encode([
          'data' => $this->order_operation_model->get_list($id)
        ]);
      }
      else if($type == 'external'){
        echo json_encode([
          'data' => $this->order_operation_model->get_external_list($id)
        ]);
      }
      else if($type == null){
        echo json_encode([
        /*  'data' => $this->order_item_model->get($id),
          'components' => $this->order_item_model->get_components($id),
          'sizes' => $this->order_item_model->get_sizes($id)*/
        ]);
      }
    }


    public function destroy($order_id=0,$operation=0) {
      $this->order_operation_model->destroy($order_id,$operation);
      echo json_encode([
        'status' => 'success',
        'message' => 'Operation deleted successfully'
      ]);
    }


}
