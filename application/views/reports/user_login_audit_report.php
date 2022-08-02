<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | User Login Audit Report</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
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
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">USER LOGIN AUDIT REPORT</h4>
	<div class="col-md-12" style="margin-bottom:20px">
	</div>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<div class="input-group date">
				  <label>Report Type</label>
          <select class="form-control input-sm" id="report_type">
						<option value="summery">Summery</option>
						<option value="details">Details</option>
					</select>
      </div>
		</div>
		<div class="col-md-2">
			<div class="input-group date">
					<label>Date</label>
          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="Enter date to search" id="selected_date">
					<input type="hidden" class="form-control" autocomplete="off" id="selected_date2">
      </div>
		</div>
		<div class="col-md-3">
			<button class="btn btn-primary btn-sm" style="margin-top:22px" id="btn_search">Search <i id="btn_search_i"></i></button>
			<button class="btn btn-success btn-sm" style="margin-top:22px" id="btn_export">Export To Excel <i id="btn_export_i"></i></button>
		</div>
	</div>

	<div class="col-md-12" style="margin-top:15px">
		<table id="data_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
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
<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/views/report/user_login_audit_report.js?v1.1"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<script>
	var BASE_URL = '<?php echo base_url(); ?>';
</script>
</body>
</html>
