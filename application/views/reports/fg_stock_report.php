<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | FG Stock Report</title>
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
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">FG STOCK REPORT</h4>
	<div class="col-md-12" style="margin-bottom:20px">
	</div>
	<div class="col-md-10 col-md-offset-1" style="margin-bottom:20px">
		<!-- <div class="col-md-3">
			<label>Site</label>
      <select class="form-control input-sm" id="style">
				<option value="">...Select One...</option>
				<?php
				foreach ($styles as $row) {
					echo '<option value="'.$row['style_id'].'">'.$row['style_code'].'</option>';
				} ?>
			</select>
		</div> -->
		<div class="col-md-3">
			<label>Style</label>
      <select class="form-control input-sm" id="style">
				<option value="">...Select One...</option>
				<?php
				foreach ($styles as $row) {
					echo '<option value="'.$row['style_id'].'">'.$row['style_code'].'</option>';
				} ?>
			</select>
		</div>
		<div class="col-md-3">
			<label>Color</label>
      <select class="form-control input-sm" id="color">
				<option value="">...Select One...</option>
				<?php
				foreach ($colors as $row) {
					echo '<option value="'.$row['color_id'].'">'.$row['color_code'].'</option>';
				} ?>
			</select>
		</div>
		<div class="col-md-3">
			<label>Size</label>
      <select class="form-control input-sm" id="size">
				<option value="">...Select One...</option>
				<?php
				foreach ($sizes as $row) {
					echo '<option value="'.$row['size_id'].'">'.$row['size_code'].'</option>';
				} ?>
			</select>
		</div>
		<div class="col-md-1">
			<button class="btn btn-primary btn-sm" style="margin-top:22px" id="btn_search">Search <i id="btn_search_i"></i></button>
		</div>
		<div class="col-md-2">
			<button class="btn btn-success btn-sm" style="margin-top:22px" onclick="ExportToExcel('xlsx')">Excel Download</i></button>
		</div>

	<div class="col-md-12" style="margin-top:15px">
		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
			<tr>
				<th>Style</th>
				<th>Color</th>
				<th>PO No</th>
				<th>Order Id</th>
				<th>Size</th>
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
<!-- <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<!-- jquery form validator plugin -->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/views/report/fg_stock_report.js"></script>
<script>
	var BASE_URL = '<?php echo base_url(); ?>';
</script>
</body>
</html>
