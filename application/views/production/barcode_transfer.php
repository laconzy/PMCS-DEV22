<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Barcode Transfer</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/izitoast/css/iziToast.min.css">

	<style type="text/css">
		.tableFixHead          { overflow: auto;max-height: 600px;}
		.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
	</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<!-- main header -->
<?php $this->load->view('common/header'); ?>

<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<?php $this->load->view('common/left_menu'); ?>
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">

<div id="wrapper">
	<div class="normalheader ">
		<div class="hpanel">
			<div class="panel-body">
				<a class="small-header-action" href="">
					<div class="clip-header">
						<i class="fa fa-arrow-up"></i>
					</div>
				</a>

				<div id="hbreadcrumb" class="pull-right m-t-lg">
					<ol class="hbreadcrumb breadcrumb">
						<li><a href="home">Dashboard</a></li>
						<li>
							<span>Production</span>
						</li>
						<li class="active">
							<span>Barcode Transfert</span>
						</li>
					</ol>
				</div>

				<h2 class="font-light m-b-xs text-success">
					BARCODE TRANSFER <?= isset($transfer_id) ? ' - ' . $transfer_id : ''; ?>
				</h2>

				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url(); ?>index.php/production/barcode_transfer/new_transfer" target="_self">New Barcode Transfer</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/production/barcode_transfer">Barcode Transfer List</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>


	<div class="content animate-panel">
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					<div class="panel-body" id="data-form">
						<input type="hidden" value="<?= isset($request_id) ? $request_id : ''; ?>" id="request_id">

						<?php if(isset($request_id) == false){ ?>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Transfer Type</label>
									<select class="form-control input-sm" id="transfer_type">
										<option value="">... Select One ...</option>
										<option value="LINE">Line</option>
										<option value="SHIFT">Shift</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Operation</label>
									<select class="form-control input-sm" id="operation" disabled>
										<option value="">...Select One...</option>
										<?php foreach ($operations as $row) { ?>
											<option value="<?= $row['operation_id'] ?>" <?= $row['operation_name'] == $selected_operation ? 'selected' : '' ?>><?= $row['operation_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Barcode</label>
									<input type="text" class="form-control input-sm" id="barcode">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Transfer Line</label>
									<Select class="form-control input-sm" id="transfer_line">
										<option value="">...Select One...</option>
										<?php foreach ($lines as $row) { ?>
											<option value="<?= $row['line_id'] ?>"><?= $row['line_code'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Transfer Shift</label>
									<select class="form-control input-sm" id="transfer_shift">
										<option value="">...Select One...</option>
										<option value="A">A</option>
										<option value="B">B</option>
									</select>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group" style="margin-top:22px">
									<button class="btn btn-primary btn-sm" id="btn_transfer">Transfer</button>
								</div>
							</div>
						</div>
					<?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('common/footer'); ?>

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
<script src="<?php echo base_url(); ?>assets/views/production/barcode_transfer.js?v1.1"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/izitoast/js/iziToast.min.js" type="text/javascript"></script>

<script>
	var BASE_URL = '<?php echo base_url(); ?>';
</script>

</body>

</html>
