<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Bundle_2 extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('login_model');

		$this->load->model('cutting/bundle_model_2');
	}

	public function index()
	{

		$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication

		$data = array();

		$data['menus'] = $this->login_model->get_authorized_menus();

		$data['menu_code'] = 'MENU_PRODUCTION';
		$data['site'] = $this->bundle_model_2->site();

		$this->load->view('cutting/bundle_creation_2', $data);
	}


	public function search()
	{

		$search_term = $this->input->get('term');

		$data = $this->color_model->search($search_term);

		echo json_encode([
			'result' => $data
		]);
	}

	public function fg_bundle()
	{
		$this->login_model->user_authentication('PROD_BUND_CHART'); // user permission authentication

		$data = array();

		$data['menus'] = $this->login_model->get_authorized_menus();

		$data['menu_code'] = 'MENU_PRODUCTION';

		$this->load->view('cutting/fg_bundle_creation_2', $data);
	}

	public function get_laysheet_details($laysheet_no)
	{

		$laysheet = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_details = $this->bundle_model_2->get_cut_details_summery($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan
		];

		echo json_encode($data);
	}

	public function get_order_details($laysheet_no)
	{

		$laysheet = $this->bundle_model_2->get_order_details($laysheet_no);

		$cut_details = $this->bundle_model_2->get_order_item_details($laysheet_no);

		//$cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);
		$cut_plan = $this->bundle_model_2->get_cut_plan(30);

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan
		];

		echo json_encode($data);
	}

	public function save()
	{

		$laysheet_no = $this->input->post('laysheet_no');

		$plies = $this->input->post('plies');
		$cut_no = $this->input->post('cut_no');
		$site = $this->input->post('site');
		$date = $this->input->post('date');
		$shift = $this->input->post('shift');

		$layshhe_details = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($layshhe_details['cut_plan_id']);

		$this->generate_bundles($laysheet_no, $plies, $layshhe_details['order_id'], $cut_plan['style'], $cut_plan['color'], $cut_plan['item_id'], $cut_no, $site,$date,$shift);

		$bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet_no);

		echo json_encode([
			'bundle_chart' => $bundle_chart
		]);
	}

	public function get_saved_details($laysheet_no)
	{
		//$laysheet_no = $this->input->post('laysheet_no');
		$bundle_chart = $this->bundle_model_2->get_saved_details($laysheet_no);

		echo json_encode([
			'bundle_chart' => $bundle_chart
		]);
	}

	public function save_fg_bundle()
	{

		$ord_id = $this->input->post('ord_id');

		$items = $this->input->post('items');

		$id = $this->bundle_model_2->save_fg_barcode($ord_id);
		$result = $this->bundle_model_2->save_fg_barcode_detail($id);

		echo json_encode([
			'bundle_chart' => $result
		]);
	}

	public function destroy($laysheet_no, $bundle_no)
	{
		$bundle_data = $this->bundle_model_2->get_bundle($laysheet_no, $bundle_no);
		if($bundle_data != null && $bundle_data != false){
			//chek bundle already scanned
			$can_delete = $this->bundle_model_2->can_delete_bundle($bundle_data['barcode']);
			if($can_delete == true){
				//delete bundle
				$this->bundle_model_2->destroy($laysheet_no, $bundle_no);
				echo json_encode([
					'status' => 'success',
					'message' => 'Bundle removed successfully'
				]);
			}
			else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Cannot delete bundle. It is already scanned.'
				]);
			}


		}
		else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Incorrect Bundle Details'
			]);
		}

	}

	public function print_data($bundle_no, $qty)
	{

		$start = $this->bundle_model_2->print_data($bundle_no, $qty);

		echo json_encode([
			'status' => 'success',
			'message' => 'Bundle removed successfully',
			'start' => $start
		]);
	}

	public function destroy_all($laysheet_no)
	{

		$this->bundle_model_2->destroy_all($laysheet_no);

		echo json_encode([
			'status' => 'success',
			'message' => 'Bundles removed successfully'
		]);
	}

	public function get_bundle_chart($laysheet)
	{

		$bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet);

		echo json_encode([
			'bundle_chart' => $bundle_chart
		]);
	}

	public function print_bundlechart($laysheet_no)
	{

		$laysheet = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_details = $this->bundle_model_2->get_cut_details_summery($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);

		$bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet_no);
		$b_chart_size = $this->bundle_model_2->size_data_for_bundle_chart($laysheet_no);
		//print_r($b_chart_size);
		$arr = array();
		foreach ($b_chart_size as $row) {
			//print_r($row);

			$a = $this->bundle_model_2->get_bundle_data($laysheet_no, $row['size_id'], $row['diff']);
			array_push($arr, $a);

		}
		//print_r($arr);

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan,
			'bundle_chart' => $bundle_chart,
			'arr' => $arr,
			'size_data' => $b_chart_size

		];

		$this->load->view('cutting/bundle_chart_report_2', $data);
	}

	public function print_barcode($laysheet_no, $components)
	{
//echo $components;
		$laysheet = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_details = $this->bundle_model_2->get_cut_details_summery($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);

		$bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet_no);

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan,
			'bundle_chart' => $bundle_chart,
			'component' => $components
		];

		$this->load->view('cutting/bundle_barcode_2', $data);
	}

	public function print_barcode_2($laysheet_no, $components)
	{
//echo $components;
		$laysheet = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_details = $this->bundle_model_2->get_cut_details_summery($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);

		$bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet_no);

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan,
			'bundle_chart' => $bundle_chart,
			'component' => $components
		];

		$this->load->view('cutting/bundle_barcode_2_part', $data);
	}

	public function print_fg_barcode($id, $start)
	{

		$barcode = $this->bundle_model_2->get_barcode_details($id, $start);
//        $laysheet = $this->bundle_model_2->get_laysheet_details($laysheet_no);
//f
//        $cut_details = $this->bundle_model_2->get_cut_details_summery($laysheet_no);
//
//        $cut_plan = $this->bundle_model_2->get_cut_plan($laysheet['cut_plan_id']);
//        $bundle_chart = $this->bundle_model_2->get_bundle_chart($laysheet_no);
//
//        $data = [
//            'laysheet' => $laysheet,
//            'cut_details' => $cut_details,
//            'cut_plan' => $cut_plan,
//            'bundle_chart' => $bundle_chart
//        ];

		$data = [
			'barcode' => $barcode
		];
//
		$this->load->view('cutting/fg_barcode', $data);
	}

	//**************************************************


	private function generate_barcode($laysheet, $bundle_no)
	{

		return $laysheet . $bundle_no;
	}

	private function generate_bundles($laysheet, $plies, $order_id, $style, $color, $item, $cut_no, $site,$date,$shift=null)
	{

		$user = $this->session->userdata('user_id');

		$cur_date = date("Y-m-d H:i:s");

		$genarated_bundles = [];

		$sizeList = $this->bundle_model_2->get_laysheet_size_details($laysheet);

		$bundle_no = $this->bundle_model_2->get_laysheet_max_bundle_no($laysheet, $order_id);
		$bundle_qty = $this->bundle_model_2->get_laysheet_max_bundle_qty($laysheet, $sizeList[0]['cut_plan_id']);

		$remaning_size_qty = $this->bundle_model_2->get_laysheet_remaning_qty($laysheet);
		$get_max_letter = $this->bundle_model_2->get_max_letter($cut_no, $order_id);

		$qty = explode(",", $plies);
		$arrsize = sizeof($qty);
		//print_r($qty);
		//echo $arrsize;
		if ($get_max_letter['letter'] == 0) {
			$letrcode = 65;
		} else {
			$letrcode = $get_max_letter['letter'] + 1;
		}

		$s = 0;
		$d = 0;
		foreach ($sizeList as $row) {

			$cut_qty = $remaning_size_qty[$row['size']];

			$bundled_qty = 0;

			//$barcode_no = '';

			$ration = $row['ratio'];
			//$qty = $row['ratio'] * $plies;
			$i = 1;
			for ($x = 0; $x < $row['ratio']; $x++) {

				for ($v = 0; $v < $arrsize; $v++) {
					if ($s == 0) {
						$s = $row['size'];
						$d = $x;
					} else if ($s != $row['size'] || $d != $x) {
						$letrcode++;
						$s = $row['size'];
						$d = $x;
					}
//echo $qty[$v]."/";
					$bundle_no=sprintf('%05d', $bundle_no);
					$barcode_no = 'A' . $laysheet . $bundle_no;

					array_push($genarated_bundles, [
						'laysheet_no' => $laysheet,
						'order_id' => $order_id,
						'bundle_no' => $bundle_no,
						'barcode' => $barcode_no,
						'size' => $row['size'],
						'qty' => $qty[$v],
						'created_by' => $user,
						'created_date' => $cur_date,
						'plies_count' => ($bundle_qty + $qty[$v] - 1),
						'style' => $style,
						'color' => $color,
						'item' => $item,
						'cut_no' => $cut_no,
						'site' => $site,
						'diff' => $i,
						'start' => $bundle_qty,
						'end' => ($bundle_qty + $qty[$v] - 1),
						'letter' => $letrcode,
						'date' => $date,
						'shift' => $shift
					]);
					$bundle_qty += $qty[$v];
					$bundle_no++;

				}
				$i++;
			}

		}

		$this->bundle_model_2->create($genarated_bundles);

		return $genarated_bundles;
	}


	public function complete_laysheet(){
		$complete_date = $this->input->post('complete_date');
		$superviser = $this->input->post('superviser');
		$laysheet = $this->input->post('laysheet_no');
		$this->bundle_model_2->change_complete_status($laysheet, $complete_date, $superviser, 'complete');
		echo json_encode([
			'status' => 'success',
			'message' => 'Laysheet completed successfully'
		]);
	}


	public function incomplete_laysheet(){
		$laysheet = $this->input->post('laysheet_no');
		//check barcodes already scanned
		$is_scanned = $this->bundle_model_2->is_laysheet_barcodes_scanned($laysheet);
		if($is_scanned == true){
			echo json_encode([
				'status' => 'error',
				'message' => 'Cannot incomplete laysheet. Because one or more barcodes already scanned'
			]);
		}
		else {
			$this->bundle_model_2->change_complete_status($laysheet, null, null, 'incomplete');
			echo json_encode([
				'status' => 'success',
				'message' => 'Laysheet incompleted successfully'
			]);
		}
	}

}
