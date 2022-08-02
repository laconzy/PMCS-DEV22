<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Scan History Reports</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/> -->
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
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">SCAN HISTORY REPORT</h4>
	<div class="col-md-12" style="margin-bottom:20px">
	</div>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>PO No</label>
			<div class="input-group date">
          <input type="text" class="form-control" autocomplete="off" id="po_no">
					<input type="hidden" class="form-control" autocomplete="off" id="po_no2">
					<span class="input-group-addon"><i class="glyphicon glyphicon-search" style="cursor:pointer" id="po_no_search"></i></span>
      </div>
		</div>
		<div class="col-md-3">
			<label>Order ID</label>
			<select class="form-control input-sm" id="order_id">
				<option value="all">All</option>
			</select>
		</div>
		<div class="col-md-2">
			<label>Cut No</label>
			<input type="text" class="form-control input-sm" id="cut_no">
		</div>
		<div class="col-md-3">
			<label>Operation</label>
			<select class="form-control input-sm" id="operation">
				<option value="all">All</option>
				<option value="1">CUTTING OUT</option>
				<option value="14">HEAT SEAL</option>
				<option value="15">BINDING</option>
				<option value="13">PLACKET</option>
				<option value="2">SUPERMARKET IN</option>
				<option value="3">SUPERMARKET OUT</option>
				<option value="9">LINE IN</option>
			</select>
		</div>
		<!-- <div class="col-md-2">
			<label>Barcode</label>
			<input type="text" class="form-control input-sm" id="barcode">
		</div> -->

	</div>
	<div class="col-md-12">
		<div class="col-md-3">
			<button class="btn btn-primary" id="btn_search">Search <i id="btn_search_i"></i></button>
		</div>
	</div>

	<div class="col-md-12" style="margin-top:15px">
		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
			<tr>
				<th>Order ID</th>
				<!-- <th>Barcode</th> -->
				<th>Bundle no</th>
				<th>Cut No</th>
				<th>Operation</th>
				<th>Scan Date</th>
				<th>Line No</th>
				<th>Scanned by</th>
				<th>Size</th>
				<th>QTY</th>
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
<!-- <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/views/report/scan_history2.js"></script>
<script>
	var BASE_URL = '<?php echo base_url(); ?>';
</script>
</body>
</html>
