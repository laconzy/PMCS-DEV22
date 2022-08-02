<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Fabric Allocation</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
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
</head>
<body>
<!-- Site wrapper -->
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">
<div>
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">FABRIC ALLOCATION</h4>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>Date From</label>
      <input type="text" class="form-control input-sm date" autocomplete="off" id="date_from">
		</div>
		<div class="col-md-2">
			<label>Date To</label>
		  <input type="text" class="form-control input-sm date" autocomplete="off" id="date_to">
		</div>
		<div class="col-md-2">
			<label>Received Date From</label>
			<input type="text" class="form-control input-sm date" autocomplete="off" id="received_date_from">
		</div>
		<div class="col-md-2">
			<label>Received Date To</label>
			<input type="text" class="form-control input-sm date" autocomplete="off" id="received_date_to">
		</div>
		<div class="col-md-2">
			<label>Main Store</label>
		  <select class="form-control input-sm" autocomplete="off" id="main_store">
				<option value="">...Select One...</option>
				<?php foreach ($main_stores as $row) { ?>
					<option value="<?= $row['main_location_name'] ?>"><?= $row['main_location_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Invoice</label>
		  <input type="text" class="form-control input-sm" autocomplete="off" id="invoice">
		</div>
	</div>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>Dyelot No</label>
		  <input type="text" class="form-control input-sm" autocomplete="off" id="pi_no">
		</div>
		<div class="col-md-2">
			<label>Fabric Code</label>
			<input type="text" class="form-control input-sm" autocomplete="off" id="fabric_code">
		</div>
		<div class="col-md-3">
			<label>Color</label>
			<input type="text" class="form-control input-sm" autocomplete="off" id="color_id">
		</div>
		<div class="col-md-2">
			<label>Status</label>
			<select class="form-control input-sm" autocomplete="off" id="status">
				<option value="Received" selected>Received</option>
				<option value="Transit">Transit</option>
			</select>
		</div>
		<div class="col-md-3">
			<button class="btn btn-primary btn-sm" id="btn_search" style="margin-top:22px">Search <i id="btn_search_i"></i></button>
			<button class="btn btn-success btn-sm" id="btn_export" style="margin-top:22px">Export To Excel</button>
		</div>
	</div>

	<div class="col-md-12">
		<div class="col-md-2">
			<label>Customer PO</label>
			<input type="text" class="form-control input-sm" autocomplete="off" id="customer_po">
		</div>
		<div class="col-md-3">
			<button class="btn btn-primary btn-sm" id="btn_allocate" style="margin-top:22px">Allocate Customer PO <i id="btn_search_i"></i></button>
		</div>
	</di>


	<div class="col-md-12" style="margin-top:15px;display: block;overflow-x: auto;white-space: nowrap;overflow-y: auto;max-height:450px">
		<table id="data_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
			<tr>
				<th>ID</th>
				<th>Invoice</th>
				<th>PO No</th>
				<th>Part No</th>
				<th>Description</th>
				<th>Date</th>
				<th>Fab Composion</th>
				<th>Color</th>
				<th>Dyelot No</th>
				<th>Batch No</th>
				<th>Role No</th>
				<th>Received Qty</th>
				<th>Item Code</th>
				<th>Original Cus. PO</th>
				<th>Customer PO</th>
				<th></th>
				<th>Bin</th>
				<th>Width</th>
				<th>Shade</th>
				<th>Comment</th>
				<th>Ins. Status</th>
				<th>Ins. Pass By</th>
				<th>Container No</th>

				<!-- <th>Factory Name</th>
				<th>Line No</th>
				<th>Release No</th>
				<th>Style</th>
				<th>Actual Received Date</th>
				<th>Main Store</th>
				<th>Sub Store</th>
				<th>Bin Location</th>
				<th>Bin Code</th>
				<th>UOM</th>
				<th>Status</th>
				<th>Actual Qty</th>
				<th>Item Code</th>
				<th>Ins. Date</th> -->
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
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<!-- page js file -->
<script src="<?php echo base_url(); ?>assets/views/inventory/fabric_allocation.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>


<script>
	var BASE_URL = '<?php echo base_url(); ?>';

</script>
</body>
</html>
