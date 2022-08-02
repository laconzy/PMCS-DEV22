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
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">



</head>

<body>

<!-- Site wrapper -->


<!-- =============================================== -->

<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">


<div>


	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">SCAN HISTORY</h4>


	<div class="col-md-12" style="margin-bottom:20px">






	</div>

	<div class="col-md-12" style="margin-bottom:20px">


		<div class="col-md-3">
			<label>Barcode</label>
			<input type="text" class="form-control input-sm" id="barcode">
		</div>
		<div class="col-md-2">
			<label>Order ID</label>
			<input type="text" class="form-control input-sm " id="order_id">
		</div>
		<div class="col-md-3">
			<label>Operation</label>
			<select class="form-control input-sm " id="operation">
				<option value="">... Select One ...</option>
				<?php foreach ($operations as $row) { ?>
					<option value="<?= $row['operation_id'] ?>"><?= $row['operation_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Line No</label>
			<select class="form-control input-sm " id="line_no">
				<option value="">... Select One ...</option>
				<?php foreach ($lines as $row) { ?>
					<option value="<?= $row['line_id'] ?>"><?= $row['line_code'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Size</label>
			<input type="text" class="form-control input-sm " id="size">
		</div>
		<div class="col-md-3">
			<label>Scan Date</label>
			<input type="text" class="form-control input-sm " id="scan_date">
		</div>

		<div class="col-md-3">
			<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>
			<button class="btn btn-danger" id="btn_remove" style="margin-top:20px">Delete Selected Bundles <i id="btn-save-i"></i></button>
		</div>

	</div>


	<div class="col-md-12">


		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%">

			<thead>

			<tr>
				<th style="width:10px"><input type="checkbox" id="select_all"/></th>
				<th>Barcode</th>
				<th>Bundle no</th>
				<th>Cut No</th>
				<th>Operation</th>
				<th>Scan Date</th>
				<th>Line No</th>
				<th>Shift</th>
				<th>Scanned by</th>
				<th>Size</th>
				<th>QTY</th>
				<th>Action</th>
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
<script src="<?php echo base_url(); ?>assets/views/report/scan_history.js?v1.1"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>


</body>

</html>
