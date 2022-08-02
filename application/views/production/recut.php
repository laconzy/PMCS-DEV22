<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Recut Request</title>
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
							<span>Master</span>
						</li>
						<li class="active">
							<span>Recut Request</span>
						</li>
					</ol>
				</div>

				<h2 class="font-light m-b-xs text-success">
					RECUT REQUEST <?= isset($request_id) ? ' - ' . $request_id : ''; ?>
				</h2>

				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url(); ?>index.php/production/recut/new_request" target="_self">New Recut Request</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/production/recut">Recut List</a></li>
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
							<div class="col-md-3">
								<div class="form-group">
									<label>Order Id</label>
									<input type="text" class="form-control input-sm" id="order_id">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Style</label>
									<input type="text" class="form-control input-sm" id="style" disabled>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Color</label>
									<input type="text" class="form-control input-sm" id="color" disabled>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer PO</label>
									<input type="text" class="form-control input-sm" id="customer_po" disabled>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group" style="margin-top:22px">
									<button class="btn btn-primary btn-sm" id="btn_search">Search</button>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if(isset($request_id) == true){ ?>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Order Id</label>
								<input type="text" class="form-control input-sm" value="<?= $header_data['order_id'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Style</label>
								<input type="text" class="form-control input-sm" value="<?= $order_data['style_code'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Color</label>
								<input type="text" class="form-control input-sm" value="<?= $order_data['color_code'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Customer PO</label>
								<input type="text" class="form-control input-sm" value="<?= $order_data['customer_po'] ?>" disabled>
							</div>
						</div>
					</div>
				<?php } ?>

						<hr>
						<div class="row">
							<div class="col-md-6" >
								<label class="text-success">Rejection Stock</label>
								<table id="tbl_stock" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th></th>
										<th >Size</th>
										<th >Rejection Type</th>
										<th >Rejection QTY</th>
										<th >Requested QTY</th>
									</tr>
									</thead>
									<tbody>
										<?php if(isset($request_id) == true){
											foreach ($stock as $row) {
												$rejection_qty = $row['rejection_qty'];
												$requested_qty = $row['requested_qty'];
												$all_requested_qty = $row['all_requested_qty'];
												$rejection_balance = $rejection_qty - $all_requested_qty;
												?>
												<tr>
													<td></td>
													<td><?= $row['size_code'] ?></td>
													<td><?= $row['rejection_name'] ?></td>
													<td><?= $rejection_balance ?></td>
													<td><?= $requested_qty ?></td>
												</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>

						<?php if(isset($request_id) == false){ ?>
						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-primary btn-sm" id="btn_save">Save Request<i id="btn-save-i"></i></button>
							</div>
						</div>
						<?php } ?>

						<?php if(isset($request_id) == true){ ?>
						<div class="row">
							<div class="col-md-1">
								<a class="btn btn-primary btn-sm" href="<?= base_url() . 'index.php/production/recut/print_request/' . $request_id ?>" target="blank">Print</a>
							</div>
							<?php if($header_data['status'] == 'ACTIVE' && $proc_inst == null) { ?>
								<div class="col-md-2">
									<button class="btn btn-info btn-sm" id="btn_send">Send For Approval<i id="btn-send-i"></i></button>
								</div>
							<?php } ?>
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
<script src="<?php echo base_url(); ?>assets/views/production/recut.js?v1.1"></script>
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
