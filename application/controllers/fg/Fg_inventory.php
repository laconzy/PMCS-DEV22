<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class  fg_inventory extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('login_model');
		$this->load->model('fg/fg_model');
		$this->load->model('order/order_model');
		$this->load->model('cutting/bundle_model');
	}



	public function index()

	{



		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication

		$data = array();

		$data['menus'] = $this->login_model->get_authorized_menus();
		//$data['site'] = $this->login_model->get_authorized_menus();

		$data['menu_code'] = 'MENU_FG';
		$data['site'] = $this->bundle_model->site();

		$this->load->view('fg/fg_packing_list', $data);

	}

	public function get_order_details($po)

	{

		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$data = array();
		//$po = $this->input->post('po');
		$order = $this->fg_model->get_order_details($po);
		//echo 12;

		//$cut_details = $this->bundle_model->get_cut_details_summery($laysheet_no);

		//$cut_plan = $this->bundle_model->get_cut_plan($laysheet['cut_plan_id']);

		$data = [
			//'laysheet' => $laysheet,
			//'cut_details' => $cut_details,
			'order_details' => $order
		];
		echo json_encode($data);

	}
	public function save()

	{

		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$data = array();
		//$po = $this->input->post('po');
		$id = $this->fg_model->save();
		//echo 12;

		//$cut_details = $this->bundle_model->get_cut_details_summery($laysheet_no);

		//$cut_plan = $this->bundle_model->get_cut_plan($laysheet['cut_plan_id']);

		$data = [
			//'laysheet' => $laysheet,
			'status' => 'Success',
			'id' => $id
		];
		echo json_encode($data);

	}

	public function save_details()

	{

		//$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication
		$data = array();
		//$po = $this->input->post('po');
		$id = $this->fg_model->save_details();
		//echo 12;

		//$cut_details = $this->bundle_model->get_cut_details_summery($laysheet_no);

		//$cut_plan = $this->bundle_model->get_cut_plan($laysheet['cut_plan_id']);

		$data = [
			//'laysheet' => $laysheet,
			'status' => 'Success',
			'id' => $id
		];
		echo json_encode($data);

	}

	public function get_saved_details($pack_id){

		$data = $this->fg_model->get_saved_details($pack_id);

		$data = [
			//'laysheet' => $laysheet,
			'status' => 'Success',
			'bundle_chart' => $data,
			'message' => 'Sucessfully Added'
		];

		echo json_encode($data);
	}

	public function packing_list_print($packing_id){

		$data = array();
		$data['data'] = $this->fg_model->get_print($packing_id);
		//$data['packing_id']=$packing_id;
		//print_r($data);
		$this->load->view('fg/packing_list_print', $data);
	}

public function destroy($line_item, $bundle_no) {

        $this->fg_model->destroy($line_item, $bundle_no);

        echo json_encode([
            'status' => 'success',
            'message' => 'Bundle removed successfully'
        ]);
    }

    public function update_fg(){


    }



}
