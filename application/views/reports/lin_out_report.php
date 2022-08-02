<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Line In Reports</title>

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


		<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">DAILY PRODUCTION REPORT</h4>


		<div class="col-md-12" style="margin-bottom:20px">

			<div class="col-md-3">

				<label>Shift</label>

				<select class="form-control input-sm" id="shift">

					<option value="X">-- Select Shift --</option>
					<option value="A">- A -</option>
					<option value="B">- B -</option>

				</select>

			</div>

			<div class="col-md-3">

				<label>Building </label>

				<select type="text" class="form-control input-sm" id="building">

					<option value="X">-- Select Module --</option>
					<option value="A">- A -</option>
					<option value="B">- B -</option>
					<option value="C">- C -</option>

				</select>

			</div>

			<div class="col-md-3">

				<label>Operation</label>

				<select class="form-control input-sm" id="operations">

					<option value="0">... Select Line ...</option>
					<option value="20">Cut QTY</option>

					<?php foreach ($operations as $row) { ?>

						<option value="<?= $row['operation_id'] ?>"><?= $row['operation_name'] ?></option>

					<?php } ?>

				</select>

			</div>

		</div>

		<div class="col-md-12" style="margin-bottom:20px">

			<div class="col-md-3">

				<label>From Date</label>

				<input type="" class="form-control input-sm date"  id="date_from">

			</div>

			<div class="col-md-3">

				<label>To Date</label>

				<input type="" class="form-control input-sm date" id="date_to">

			</div>

			<div class="col-md-3">

				<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>

			</div>

		</div>
		<div class="row">
			<div class="col-md-2">
				<button onclick="ExportToExcel('xlsx')">Export table to excel</button>

			</div>
		</div>
		<div class="col-md-12">


			<table id="order_table" class="table table-striped table-bordered table-hover" width="100%">

				<thead>

					<tr>

						<th>Order Code</th>
						<th>Date</th>
						<th>Syle</th>
						<th>Customer PO</th>
						<th>Color</th>
						<th>Size</th>
						<th>Module</th>
						<th>Qty</th>


					</tr>

				</thead>

				<tbody>













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
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>


<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

<!-- page js file -->

<script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script>

<script src="<?php echo base_url(); ?>assets/application/app.js"></script>


<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

<!-- jquery form validator plugin -->

<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/views/report/daily_production.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/xlsx/xlsx.full.min.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

	function ExportToExcel(type, fn, dl) {
		var elt = document.getElementById('order_table');
		var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
		return dl ?
		XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
		XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
	}


</script>


</body>

</html>

