<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Order Status Report</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->


	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>

</head>

<body>

	<!-- Site wrapper -->


	<!-- =============================================== -->

	<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">


	<div>


		<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">ORDER STATUS REPORT</h4>


		<div class="col-md-12" style="margin-bottom:20px">
			<div class="col-md-2">
				<label>Customer</label>
				<select type="text" class="form-control input-sm" id="customer">
					<option value="">-- Select Customer --</option>
					<?php foreach ($customers as $row) { ?>
						<option value="<?= $row['id'] ?>" <?= ($customer == $row['id']) ? 'selected' : '' ?> ><?= $row['cus_name'] ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-2">
				<label>Style</label>
				<select type="text" class="form-control input-sm" id="style">
					<option value="">-- Select Style --</option>
					<?php foreach ($styles as $row) { ?>
						<option value="<?= $row['style_id'] ?>" <?= ($style == $row['style_id']) ? 'selected' : '' ?>><?= $row['style_code'] ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-2">
				<label>Customer PO</label>
				<input type="text" class="form-control input-sm" id="customer_po" value="<?php echo $customer_po;?>">
			</div>
			<div class="col-md-2">
				<label>Color</label>
				<input type="text" class="form-control input-sm" id="color" value="<?php echo $color;?>">
			</div>
			<div class="col-md-2">
				<label>Order Status</label>
				<select class="form-control input-sm" id="order_status">
					<option value="">...Select One...</option>
					<option value="open" <?= ($order_status == 'open') ? 'selected' : '' ?>>Open</option>
					<option value="complete" <?= ($order_status == 'complete') ? 'selected' : '' ?>>Complete</option>
				</select>
			</div>
		</div>

		<div class="col-md-12" style="margin-bottom:20px">
			<div class="col-md-2">
				<label>Delivery Date From</label>
				<input type="text" class="form-control input-sm" id="date_from" value="<?php echo $date_from;?>">
			</div>
			<div class="col-md-2">
				<label>Delivery Date To</label>
				<input type="text" class="form-control input-sm" id="date_to" value="<?php echo $date_to;?>">
			</div>
			<div class="col-md-1">
				<input type="hidden" class="form-control input-sm" id="size">
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_search">Search</button>
				<button class="btn btn-success btn-sm" style="margin-top:20px" id="btn_excel">Export To Excel</button>
			</div>
		</div>

	<!--<div class="col-md-12" style="margin-bottom:20px">

	  <div class="col-md-3">

		  <label>Delivery From</label>

		  <input  type="text" class="form-control input-sm" value="2018-08-01">

	  </div>

	  <div class="col-md-3">

		  <label>Delivery To</label>

		  <input type="text" class="form-control input-sm" value="2018-10-01">

	  </div>

	  <div class="col-md-3">

		  <button class="btn btn-primary" style="margin-top:20px">Search</button>

	  </div>

	</div>-->


	<div class="col-md-12" style="overflow: scroll;">


		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%"
		style="font-family: Verdana, Geneva, sans-serif;font-size: 10px;">

		<thead>

			<tr style="text-align: center;">

				<!--<th>Progress</th>-->

				<th width="5%">Order Id</th>
				<th width="30%">Order Code</th>
				<th width="10%">Delivery Date</th>
				<th width="5%">Syle</th>
				<th width="5%">Customer</th>
				<th width="5%">Customer PO</th>
				<th width="10%">Color</th>
				<!-- <th width="3%">Size</th> -->
				<th width="5%">Order Qty</th>
				<th width="5%">Plan Qty</th>
				<th width="5%">Cut Qty</th>

				<?php
				$wip="";
				foreach ($operations as $key => $value) {
					if($value != 'PREPERATION'){ //no need to show preperation operation
						echo '<th>'.$value.'</th>';
						echo '<th>WIP</th>';
					}
			 } ?>

			 <th width="5%">Reject</th>
			 <th width="5%">FG</th>
			 <th width="5%">Transfered</th>
			 <th width="5%">Shipped</th>
			 <th width="5%">WIP</th>
			</tr>

		</thead>

		<tbody>

			<?php foreach ($data as $row) { ?>


				<tr style="">


					<td><?= $row['order_id'] ?></td>

					<td><?= $row['order_code'] ?></td>

					<td><?= $row['delivary_date'] ?></td>

					<td><?= $row['style_code'] ?></td>

					<td><?= $row['cus_name'] ?></td>

					<td><?= $row['customer_po'] ?></td>

					<td><?= $row['color_code'] ?></td>

					<td><?= $row['s_ord_qty'] ?></td>
					<td><?= $row['s_plan_qty'] ?></td>

					<td><?= $row['cut_qty'] ?></td>


					<?php
					$wip=$row['cut_qty'] ;
					$cuting_out_id = null;

					foreach ($operations as $key => $value) {

						if($value == 'CUTTING OUT'){
							$cuting_out_id = $key;
						}

						$qty = isset($row['operations'][$key]) ? $row['operations'][$key] : 0;
						$variance = 0;
						$op_arr = ['SUPERMARKET IN', 'PREPERATION', 'HEAT SEAL', 'FUSING', 'PLACKET'];
						if(in_array($value, $op_arr)){
							$variance = $row['operations'][$cuting_out_id]-$qty;
						}
						else {
							$variance = $wip-$qty;
						}

						$color ="";
						if($variance > 0){
							$color ='color:red';
						}

						?>

						<?php
							if($value != 'PREPERATION'){ //no need to show preperation operation
								echo '<td>'.$qty.'</td>';
								echo '<td style="'.$color.'">'.$variance.'</td>';
							}
						?>


						<?php

						$wip=$qty;
					} ?>

					<td><?= $row['rej_qty'] ?></td>
					<td><?= $row['fg_qty'] ?></td>
					<td><?= $row['transfered_qty'] ?></td>
					<td><?= (-1 * $row['ship_qty']) ?></td>
					<td><?= $row['fg_wip_qty'] ?></td>
				</tr>


			<?php } ?>


		</tbody>

	</table>

</div>


</div>

</div>


</div>


<!-- jQuery 2.1.4 -->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<!-- page js file -->
<!-- <script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script> -->
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';


	$(document).ready(function () {

		$('#date_from, #date_to').datepicker({
			format: "yyyy-mm-dd",
			viewMode: "days",
			minViewMode: "days"
		});


		$('#btn_search').click(function () {

			var customer = ($('#customer').val() == '') ? 0 : $('#customer').val();
			var style = ($('#style').val() == '') ? 0 : $('#style').val();
			var customer_po = ($('#customer_po').val().trim() == '') ? 'NO' : $('#customer_po').val().trim();
			var color = ($('#color').val().trim() == '') ? 'NO' : $('#color').val().trim();
			//var size = ($('#size').val().trim() == '') ? 'NO' : $('#size').val().trim();
			var order_status = ($('#order_status').val().trim() == '') ? 'NO' : $('#order_status').val().trim();
			var date_from = $('#date_from').val().trim();
			var date_to = $('#date_to').val().trim();

			if(customer_po == 'NO' && (date_from == '' || date_to == '')){
				appAlertError('Please select valid delivery date range');
				return;
			}

			var url = 'index.php/report/order_status_report/' + customer + '/' + style + '/' + customer_po + '/' + color+ '/' + order_status + '/' + date_from + '/' + date_to;

			window.open(BASE_URL + url, '_self');

		});


		$('#btn_excel').click(function(){
				tableToExcel('order_table','test','Order Status');
		});


	});


	function tableToExcel(table, sheetName, fileName) {
	    var ua = window.navigator.userAgent;
	    var msie = ua.indexOf("MSIE ");
	    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
	    {
	        return fnExcelReport(table, fileName);
	    }

	    var uri = 'data:application/vnd.ms-excel;base64,',
	        templateData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
	        base64Conversion = function (s) { return window.btoa(unescape(encodeURIComponent(s))) },
	        formatExcelData = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

	    $("tbody > tr[data-level='0']").show();

	    if (!table.nodeType)
	        table = document.getElementById(table)

	    var ctx = { worksheet: sheetName || 'Worksheet', table: table.innerHTML }

	    var element = document.createElement('a');
	    element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' + base64Conversion(formatExcelData(templateData, ctx)));
	    element.setAttribute('download', fileName);
	    element.style.display = 'none';
	    document.body.appendChild(element);
	    element.click();
	    document.body.removeChild(element);

	    $("tbody > tr[data-level='0']").hide();
	}


</script>


</body>

</html>
