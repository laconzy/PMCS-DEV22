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

		$layshhe_details = $this->bundle_model_2->get_laysheet_details($laysheet_no);

		$cut_plan = $this->bundle_model_2->get_cut_plan($layshhe_details['cut_plan_id']);

		$this->generate_bundles($laysheet_no, $plies, $layshhe_details['order_id'], $cut_plan['style'], $cut_plan['color'], $cut_plan['item_id'], $cut_no,$site);

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

		$this->bundle_model_2->destroy($laysheet_no, $bundle_no);

		echo json_encode([
			'status' => 'success',
			'message' => 'Bundle removed successfully'
		]);
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

		$data = [
			'laysheet' => $laysheet,
			'cut_details' => $cut_details,
			'cut_plan' => $cut_plan,
			'bundle_chart' => $bundle_chart
		];

		$this->load->view('cutting/bundle_chart_report', $data);
	}

	public function print_barcode($laysheet_no,$components)
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

	private function generate_bundles($laysheet, $plies, $order_id, $style, $color, $item, $cut_no,$site)
	{

		$user = $this->session->userdata('user_id');

		$cur_date = date("Y-m-d H:i:s");

		$genarated_bundles = [];

		$sizeList = $this->bundle_model_2->get_laysheet_size_details($laysheet);

		$bundle_no = $this->bundle_model_2->get_laysheet_max_bundle_no($laysheet);

		$remaning_size_qty = $this->bundle_model_2->get_laysheet_remaning_qty($laysheet);


		foreach ($sizeList as $row) {

			$cut_qty = $remaning_size_qty[$row['size']];

			$bundled_qty = 0;

			//$barcode_no = '';

			$ration = $row['ratio'];
			//$qty = $row['ratio'] * $plies;
			for ($x = 0; $x < $row['ratio']; $x++) {


				// while ($bundled_qty < $cut_qty) {
				// $qty = 0;
				$barcode_no = 'A'.$laysheet . $bundle_no;
//
//                $balance = $cut_qty - $bundled_qty;
//
//                if ($balance >= $plies) {
//
//                    $bundled_qty += $plies;
//
//                    $qty = $plies;
//                } else {
//
//                    $bundled_qty += $balance;
//
//                    $qty = $balance;
//                }

				array_push($genarated_bundles, [
					'laysheet_no' => $laysheet,
					'order_id' => $order_id,
					'bundle_no' => $bundle_no,
					'barcode' => $barcode_no,
					'size' => $row['size'],
					'qty' => $plies,
					'created_by' => $user,
					'created_date' => $cur_date,
					'plies_count' => $plies,
					'style' => $style,
					'color' => $color,
					'item' => $item,
					'cut_no' => $cut_no,
					'site'=> $site
				]);

				$bundle_no++;
				//}
			}
		}

		$this->bundle_model_2->create($genarated_bundles);

		return $genarated_bundles;
	}

}
