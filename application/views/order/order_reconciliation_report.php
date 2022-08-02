<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Order Reconciliation Report</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">


	<style>

	table {
		border-spacing: 0;
		border-collapse: collapse;
}

		.td-special {
			font-weight:bold;
			background-color:#585858;
			color:#FFF;
			text-align: left;
		}

		.td-special {
			color : #FFF;
			background-color : #27ae60;
			font-size : 13px;
			text-align: left;
		}

		/* .tbl, .tbl2 {
			width:100%;
		} */

		.tbl th {
			background-color : #27ae60;
			color : #FFF;
			font-size : 13px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl td {
			color : #000;
			font-size : 11px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl tr:nth-child(even) {
			background-color: #F0F0F0;
		}

	</style>

</head>
<body>
<!-- Site wrapper -->
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">
<div>
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">ORDER RECONCILIATION REPORT</h4>
	<div class="col-md-12" style="margin-bottom:20px">
	</div>

	<input type="hidden" id="order_id" value="<?= $order['order_id'] ?>">

	<div class="col-md-12" style="margin-top:15px">
		<table id="order_table" class="tbl" width="100%">
			<thead>
			<tr>
				<th colspan="8" style="font-weight:bold;font-size:15px">Order Details</th>
			</tr>
			<tr>
				<td>Order ID</td>
				<td><?= $order['order_id'] ?></td>
				<td>Order Code</td>
				<td><?= $order['order_code'] ?></td>
				<td>Style Code</td>
				<td><?= $order['style_code'] ?></td>
				<td>Style Name</td>
				<td><?= $order['style_name'] ?></td>
			</tr>
			<tr>
				<td>Color Code</td>
				<td><?= $order['color_code'] ?></td>
				<td>Color Name</td>
				<td><?= $order['color_name'] ?></td>
				<td>Customer Code</td>
				<td><?= $order['cus_code'] ?></td>
				<td>Customer Name</td>
				<td><?= $order['customer_name'] ?></td>
			</tr>
			<tr>
				<td>Customer PO</td>
				<td><?= $order['customer_po'] ?></td>
				<td>UOM</td>
				<td><<?= $order['uom'] ?>/td>
				<td>Ship Method</td>
				<td><?= $order['ship_method'] ?></td>
				<td>Country</td>
				<td><?= $order['country_name'] ?></td>
			</tr>
			<tr>
				<td>Delivery Date</td>
				<td><?= $order['delivary_date'] ?></td>
				<td>Pcd Date</td>
				<td><?= $order['pcd_date'] ?></td>
				<td>Plan Deli Date</td>
				<td><?= $order['planned_delivary_date'] ?></td>
				<td>Season</td>
				<td><?= $order['season_name'] ?></td>
			</tr>
			<tr>
				<td>Sales Qty</td>
				<td><?= $order['sales_qty'] ?></td>
				<td>SMV</td>
				<td><?= $order['smv'] ?></td>
				<td>Status</td>
				<td><?= $order['active'] == 'Y' ? 'Active' : 'Deactive' ?></td>
				<td>Completed</td>
				<td><?= $order['is_complete'] == 1 ? 'Yes' : 'No' ?></td>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<div class="col-md-12" style="margin-top:15px">
		<?php
			foreach ($items as $item) {
				//order items
				echo '<table id="order_lines" class="tbl" width="100%" style="margin-top:15px">';
				echo '<tr>
							<th>Item Code</th>
							<th>Item Description</th>
							<th>Color</th>
							<th>Order Qty</th>
							<th>Planned Qty</th>
							</tr>';
				echo '<tr>
							<td>'.$item['item_code'].'</td>
							<td>'.$item['item_description'].'</td>
							<td>'.$item['color_code'].'</td>
							<td>'.$item['order_qty'].'</td>
							<td>'.$item['planned_qty'].'</td>
							</tr>';
				echo ' </table>';

				foreach ($item['components'] as $com) {
					echo '<table id="item_components" class="tbl" width="100%" style="margin-top:15px">';
					echo '<tr>
								<th>Component Code</th>
								<th>Component Description</th>
								<th>Color</th>
								</tr>';
					echo '<tr>
								<td>'.$com['com_code'].'</td>
								<td>'.$com['com_description'].'</td>
								<td>'.$com['color_code'].'</td>
								</tr>';
					echo ' </table>';
				}

				echo '<table class="tbl" width="100%" style="margin-top:15px"> <tr> <th></th>';
				foreach ($item['sizes'] as $size) {
					echo '<th>'.$size['size_code'].'</th>';
				}
				echo '<th>Total</th>';

				$total = 0;
				echo '</tr> <tr> <td style="text-align:left">Order Qty</td>';
				foreach ($item['sizes'] as $size) {
					$total += $size['order_qty'];
					echo '<td>'.$size['order_qty'].'</td>';
				}
				echo '<td>'.$total.'</td>';
				$total = 0;

				echo '</tr> <tr> <td style="text-align:left">Planned Qty</td>';
				foreach ($item['sizes'] as $size) {
					$total += $size['planned_qty'];
					echo '<td>'.$size['planned_qty'].'</td>';
				}
				echo '<td>'.$total.'</td>';
				$total = 0;

				echo '</tr>';
			}

			$operations = [
				'cut_qty' => 'Cut Qty',
				'CUTTING_OUT' => 'Cutting Out',
				'cut_out_wip' => 'WIP',
				'PREPARATION' => 'Preparation',
				'SUPERMARKET_IN' => 'SM IN',
				'sm_in_wip' => 'WIP',
				'SUPERMARKET_OUT' => 'SM OUT',
				'sm_out_wip' => 'WIP',
				'LINE_IN' => 'Line In',
				'LINE_OUT' => 'Line Out',
				'line_out_wip' => 'WIP',
				'rej_qty' => 'Reject',
				'fg_qty' => 'FG',
				'transfered_qty' => 'Transfered',
				'ship_qty' => 'Shipped',
				'fg_wip_qty' => 'WIP'
			];

			$has_wip = false;

			foreach ($operations as $key => $value) {
				echo '<tr> <td style="text-align:left">'.$value.'</td>';
				$total = 0;
				$color = 'black';
				foreach ($status_data as $row) {

					if($key == 'cut_out_wip'){
						$cut_out_wip = $row['cut_qty'] - $row['CUTTING_OUT'];
						$total += $cut_out_wip;
						if($cut_out_wip != null && $cut_out_wip > 0){
							$has_wip = true;
						}
						echo '<td style="color:red">'.$cut_out_wip.'</td>';
						$color = 'red';
					}
					else if($key == 'sm_in_wip'){
						$sm_in_wip = $row['CUTTING_OUT'] - $row['SUPERMARKET_IN'];
						$total += $sm_in_wip;
						if($sm_in_wip != null && $sm_in_wip > 0){
							$has_wip = true;
						}
						echo '<td style="color:red">'.$sm_in_wip.'</td>';
						$color = 'red';
					}
					else if($key == 'sm_out_wip'){
						$sm_out_wip = $row['SUPERMARKET_IN'] - $row['SUPERMARKET_OUT'];
						$total += $sm_out_wip;
						if($sm_out_wip != null && $sm_out_wip > 0){
							$has_wip = true;
						}
						echo '<td style="color:red">'.$sm_out_wip.'</td>';
						$color = 'red';
					}
					else if($key == 'line_out_wip'){
						$line_out_wip = $row['LINE_IN'] - $row['LINE_OUT'];
						$total += $line_out_wip;
						if($line_out_wip != null && $line_out_wip > 0){
							$has_wip = true;
						}
						echo '<td style="color:red">'.$line_out_wip.'</td>';
						$color = 'red';
					}
					else if($key == 'fg_wip_qty'){
						$fg_wip = $row['fg_qty'] - $row['ship_qty'];
						$total += $fg_wip;
						if($fg_wip != null && $fg_wip > 0){
							$has_wip = true;
						}
						echo '<td style="color:red">'.$fg_wip.'</td>';
						$color = 'red';
					}
					else {
						$qty = ($row[$key] == null || $row[$key] == '') ? 0 : $row[$key];
						$total += $qty;
						echo '<td>'.$row[$key].'</td>';
					}

				}
				if($color == 'red'){
					echo '<td style="color:red">'.$total.'</td>';
				}
				else {
					echo '<td>'.$total.'</td>';
				}
				echo '</tr>';
			}

			echo '</table>';
		?>
	</div>
	<div class="col-md-12" style="margin-top:15px">
		<input type="hidden" id="has_wip" value="<?= ($has_wip == true) ? 1 : 0 ?>">
		<?php if($order['is_complete'] == 0) { ?>
			<button class="btn btn-primary btn-sm" id="btn_complete">Complete & Send Email</button>
		<?php } ?>

		<?php if($order['is_complete'] == 1) { ?>
			<button class="btn btn-primary btn-sm" id="btn_not_complete">Mark As Not Complete</button>
		<?php } ?>

		<br><br><br><br>
	</div>

</div>
</div>
</div>

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script> -->
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>
<script>
	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function(){

		$('#btn_complete').click(function(){
			let order_id = $('#order_id').val();
			let has_wip = $('#has_wip').val();

			if(has_wip == 1 || has_wip == '1'){
				appAlertError('Cannot complete the order. There is wip avaliable');
				return;
			}

			appAlertConfirm('Do you want to complete this order?', function () {

				$('body').loadingModal({
				  position: 'auto',
				  text: '',
				  color: '#fff',
				  opacity: '0.5',
				  backgroundColor: 'rgb(0,0,0)',
				  animation: 'cubeGrid'
				});
				setTimeout(function(){
					appAjaxRequest({
						url: BASE_URL + 'index.php/order/order/complete_order',
						type: 'post',
						dataType: 'json',
						data : {
							'order_id' : order_id
						},
						success: function (res) {
							if (res.status == 'success') {
								appAlertSuccess(res.message, function(){
									location.reload();
								});
							}
							else {
								appAlertError(res.message);
							}
							$('body').loadingModal('destroy');
						},
						error: function (err) {
							$('body').loadingModal('destroy');
							alert(err);
						}
					});
				}, 200);
			});
		});


		$('#btn_not_complete').click(function(){
			let order_id = $('#order_id').val();

			appAlertConfirm('Do you want to mark this order as not complete?', function () {

				$('body').loadingModal({
				  position: 'auto',
				  text: '',
				  color: '#fff',
				  opacity: '0.5',
				  backgroundColor: 'rgb(0,0,0)',
				  animation: 'cubeGrid'
				});
				setTimeout(function(){
					appAjaxRequest({
						url: BASE_URL + 'index.php/order/order/not_complete_order',
						type: 'post',
						dataType: 'json',
						data : {
							'order_id' : order_id
						},
						success: function (res) {
							if (res.status == 'success') {
								appAlertSuccess(res.message, function(){
									location.reload();
								});
							}
							else {
								appAlertError(res.message);
							}
							$('body').loadingModal('destroy');
						},
						error: function (err) {
							$('body').loadingModal('destroy');
							alert(err);
						}
					});
				}, 200);
			});
		});


	});


</script>
</body>
</html>
