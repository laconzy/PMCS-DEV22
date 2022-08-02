<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | B Stores Transfer</title>
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
							<span>B Stores Transfer</span>
						</li>
					</ol>
				</div>

				<h2 class="font-light m-b-xs text-success">
					B STORES TRANSFER <?= isset($transfer_id) ? ' - ' . $transfer_id : ''; ?>
				</h2>

				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url(); ?>index.php/fg/bstores_transfer/new_transfer" target="_self">New B Stores Transfer</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/fg/bstores_transfer">Transfer List</a></li>
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
						<input type="hidden" value="<?= isset($transfer_id) ? $transfer_id : ''; ?>" id="transfer_id">

						<?php if(isset($transfer_id) == false){ ?>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Transfer Type</label>
									<select class="form-control input-sm" id="transfer_type">
										<option value="">...Select One...</option>
										<option value="FG_TRANSFER">FG TRANSFER</option>
										<option value="WRITEOFF">WRITE OFF</option>
										<option value="LEFT_OVER">LEFT OVER TRANSFER</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Site</label>
									<select class="form-control input-sm" id="site_id">
										<option value="">...Select One...</option>
										<?php
											foreach ($sites as $row) {
												echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Style</label>
									<select class="form-control input-sm" id="style_id">
										<option value="">...Select One...</option>
										<?php
											foreach ($styles as $row) {
												echo '<option value="'.$row['style_id'].'">'.$row['style_code'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Color</label>
									<select class="form-control input-sm" id="color_id">
										<option value="">...Select One...</option>
									</select>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group" style="margin-top:22px">
									<button class="btn btn-primary btn-sm" id="btn_search">Search</button>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-3" id="order_id_div">
								<label>Order ID</label>
								<div class="form-group">
									<select type="text" class="form-control input-sm"  id="order_id">
									</select>
								</div>
							</div>
							<div class="col-md-3" id="line_id_div" style="display:none">
								<label>Line ID</label>
								<div class="form-group">
									<select type="text" class="form-control input-sm"  id="line_id">
									</select>
								</div>
							</div>
							<div class="col-md-5" id="transfer_reason_div">
								<label>Transfer Reason</label>
								<div class="form-group">
									<select type="text" class="form-control input-sm"  id="transfer_reason">
									</select>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group" style="margin-top:22px">
									<button class="btn btn-primary btn-sm" id="btn_transfer">Transfer <i id="btn-transfer-i"></i></button>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if(isset($transfer_id) == true){ ?>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Transfer Type</label>
								<input type="text" class="form-control input-sm" value="<?= $transfer_data['transfer_type'] ?>" id="transfer_type" disabled>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Site</label>
								<input type="text" class="form-control input-sm" value="<?= $transfer_data['site_name'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Style</label>
								<input type="text" class="form-control input-sm" value="<?= $style['style_code'] ?>" disabled>
								<input type="hidden" id="style_id" value="<?= $transfer_data['style_id'] ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Color</label>
								<input type="text" class="form-control input-sm" value="<?= $color['color_code'] ?>" disabled>
								<input type="hidden" id="color_id" value="<?= $transfer_data['color_id'] ?>">
							</div>
						</div>

					</div>
					<div class="row">
						<?php if($transfer_data['transfer_type'] == 'FG_TRANSFER') { ?>
							<div class="col-md-2" >
								<label>Order ID</label>
								<div class="form-group">
									<input type="text" class="form-control input-sm" value="<?= $transfer_data['transfer_order_id'] ?>" id="order_id" disabled>
								</div>
							</div>
						<?php } ?>
						<?php if($transfer_data['transfer_type'] == 'LEFT_OVER' || $transfer_data['transfer_type'] == 'FG_TRANSFER') { ?>
							<div class="col-md-2" >
								<label>Line ID</label>
								<div class="form-group">
									<input type="text" class="form-control input-sm" value="<?= $transfer_data['line_details']['line_code'] ?>" id="line_id" disabled>
								</div>
							</div>
						<?php } ?>
						<div class="col-md-5">
							<label>Transfer Reason</label>
							<div class="form-group">
								<input type="text" class="form-control input-sm" value="<?= $transfer_reason['reason_text'] ?>" disabled>
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group" style="margin-top:22px">
								<a class="btn btn-primary btn-sm" href="<?= base_url() . 'index.php/fg/bstores_transfer/print_transfer/' . $transfer_id ?>" target="blank">Print</a>
							</div>
						</div>
					</div>
				<?php } ?>

						<hr>
						<div class="row">
							<div class="col-md-6" >
								<label class="text-success">B Stores</label>
								<table id="tbl_bstores_stock" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th></th>
										<th >Size</th>
										<th >B Stores QTY</th>
										<th >Transfer QTY</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<?php if(isset($transfer_id) == false || $transfer_data['transfer_type'] == 'FG_TRANSFER') { ?>
							<div class="col-md-6" id="tbl_order_stock_div">
								<label class="text-success">Order Details</label>
								<table id="tbl_order_stock" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th >Size</th>
										<th >Order QTY</th>
										<th >FG QTY</th>
										<th >Balance QTY</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						<?php } ?>
						</div>
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
<script src="<?php echo base_url(); ?>assets/views/fg/bstores_transfer.js?v1.2"></script>
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
