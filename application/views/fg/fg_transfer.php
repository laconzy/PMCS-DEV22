<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | FG Transfer</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->



	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

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

							<span>FG Transfer</span>

						</li>

					</ol>

				</div>

				<h2 class="font-light m-b-xs text-success">
					FG TRANSFER <?= isset($transfer_id) ? ' - ' . $transfer_id : ''; ?>
				</h2>

				<div class="btn-group">

					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>

					<ul class="dropdown-menu">

						<li><a href="<?php echo base_url(); ?>index.php/fg/fg_transfer/new_transfer" target="_self">New FG Transfer</a></li>

						<li class="divider"></li>

						<li><a href="<?php echo base_url(); ?>index.php/fg/fg_transfer">Transfer List</a></li>

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


						<div class="row form-group">
							<div class="col-md-6">
								<label class="text-success" style="font-size:15px;">FROM ORDER</label>
							</div>
							<div class="col-md-6">
								<label class="text-success" style="font-size:15px;">TO ORDER</label>
							</div>
						</div>

						<?php if(isset($transfer_id) == false) { ?>
						<div class="row form-group">
							<div class="col-md-6">
								<label>Site</label>
								<select class="form-control input-sm"  id="from_site_id" <?= isset($transfer_id) ? 'disabled' : ''; ?>>
									<option value="">...Select One...</option>
									<?php
										foreach ($sites as $row) {
											echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label>Site</label>
								<select class="form-control input-sm"  id="to_site_id" disabled>
									<option value="">...Select One...</option>
									<?php
										foreach ($sites as $row) {
											echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<label>Line</label>
								<select class="form-control input-sm"  id="from_line_id" <?= isset($transfer_id) ? 'disabled' : ''; ?>>
								</select>
							</div>
							<div class="col-md-6">
								<label>Line</label>
								<select class="form-control input-sm"  id="to_line_id" disabled>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<label>Order ID</label>
								<div class="input-group date">
									<input type="text" class="form-control input-sm" placeholder="Enter laysheet no" id="from_order_id" value="<?= isset($from_order_id) ? $from_order_id : ''; ?>" <?= isset($transfer_id) ? 'disabled' : ''; ?>>
									<span class="input-group-addon"><i class="glyphicon glyphicon-search" style="cursor:pointer" <?= isset($transfer_id) ? '' : 'id="btn_from_order"'; ?>></i></span>
								</div>
							</div>
							<div class="col-md-6">
								<label>Order ID</label>
								<div class="input-group date">
									<input type="text" class="form-control input-sm" placeholder="Enter laysheet no" id="to_order_id" value="<?= isset($to_order_id) ? $to_order_id : ''; ?>" <?= isset($transfer_id) ? 'disabled' : ''; ?>>
									<span class="input-group-addon"><i class="glyphicon glyphicon-search" style="cursor:pointer" <?= isset($transfer_id) ? '' : 'id="btn_to_order"'; ?>></i></span>
								</div>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<label>Customer PO</label>
								<input type="text" class="form-control input-sm" id="from_cpo" disabled>
							</div>
							<div class="col-md-6">
								<label>Customer PO</label>
								<input type="text" class="form-control input-sm" id="to_cpo" disabled>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<label>Style</label>
								<input type="text" class="form-control input-sm" id="from_style" disabled>
							</div>
							<div class="col-md-6">
								<label>Style</label>
								<input type="text" class="form-control input-sm" id="to_style" disabled>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<label>Color</label>
								<input type="text" class="form-control input-sm" id="from_color" disabled>
							</div>
							<div class="col-md-6">
								<label>Color</label>
								<input type="text" class="form-control input-sm" id="to_color" disabled>
							</div>
						</div>

					<?php } ?>


					<?php if(isset($transfer_id) == true) { ?>
					<div class="row form-group">
						<div class="col-md-6">
							<label>Site</label>
							<input class="form-control input-sm" value="<?= $header_data['from_site_name'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Site</label>
							<input class="form-control input-sm" value="<?= $header_data['to_site_name'] ?>" disabled>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<label>Line</label>
							<input class="form-control input-sm" value="<?= $header_data['from_line_code'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Line</label>
							<input class="form-control input-sm" value="<?= $header_data['to_line_code'] ?>" disabled>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<label>Order ID</label>
							<input class="form-control input-sm" value="<?= $header_data['from_order_id'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Order ID</label>
							<input class="form-control input-sm" value="<?= $header_data['to_order_id'] ?>" disabled>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<label>Customer PO</label>
							<input class="form-control input-sm" value="<?= $header_data['from_customer_po'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Customer PO</label>
							<input class="form-control input-sm" value="<?= $header_data['to_customer_po'] ?>" disabled>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<label>Style</label>
							<input class="form-control input-sm" value="<?= $header_data['style_code'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Style</label>
							<input class="form-control input-sm" value="<?= $header_data['style_code'] ?>" disabled>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<label>Color</label>
							<input class="form-control input-sm" value="<?= $header_data['color_code'] ?>" disabled>
						</div>
						<div class="col-md-6">
							<label>Color</label>
							<input class="form-control input-sm" value="<?= $header_data['color_code'] ?>" disabled>
						</div>
					</div>

				<?php } ?>


						<hr>
						<div class="row">
							<div class="col-md-6" >
								<table id="tbl_from" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th></th>
										<th >Size</th>
										<th >Order QTY</th>
										<th >FG QTY</th>
										<th >Transfer QTY</th>
									</tr>
									</thead>
									<tbody>
										<?php if(isset($transfer_id) == true) {
											foreach ($from_order_stock as $row) { ?>
												<tr>
													<td></td>
													<td><?= $row['size_code'] ?></td>
													<td><?= $row['order_qty'] ?></td>
													<td><?= $row['fg_qty'] ?></td>
													<td><?= $row['fg_transfer_out_qty'] ?></td>
												</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-6" >
								<table id="tbl_to" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th >Size</th>
										<th >Order QTY</th>
										<th >FG QTY</th>
										<th >Transferd QTY</th>
									</tr>
									</thead>
									<tbody>
										<?php if(isset($transfer_id) == true) {
											foreach ($to_order_stock as $row) { ?>
												<tr>
													<td><?= $row['size_code'] ?></td>
													<td><?= $row['order_qty'] ?></td>
													<td><?= $row['fg_qty'] ?></td>
													<td><?= $row['fg_transfer_in_qty'] ?></td>
												</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
						<hr>

						<div class="row">
							<?php if(isset($transfer_id) == false) { ?>
							<div class="col-md-6" id="transfer_reason_div" style="display:none">
								<label>Transfer Reason</label>
								<select class="form-control input-sm" id="transfer_reason">
									<option value="">... Select Reason ...</option>
									<?php
									 	foreach ($transfer_reasons as $row) {
									 		echo '<option value="'.$row['reason_id'].'">'.$row['reason_text'].'</option>';
									 	}
									?>
								</select>
							</div>
							<?php } ?>

							<?php if(isset($transfer_id) == true) { ?>
							<div class="col-md-6" id="transfer_reason_div">
								<label>Transfer Reason</label>
								<input class="form-control input-sm" value="<?= $header_data['reason_text'] ?>" disabled>
							</div>
							<?php } ?>


							<div class="col-md-2">
								<button class="btn btn-primary btn-sm" id="btn_transfer" style="display:none;margin-top:20px">Transfer <i id="btn-transfer-i"></i></button>
								<?php if(isset($transfer_id)) { ?>
								<a class="btn btn-primary btn-sm" style="margin-top:20px" href="<?= base_url() . 'index.php/fg/fg_transfer/print_transfer/' . $transfer_id ?>" target="blank">Print</a>
								<?php } ?>
							</div>
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
<script src="<?php echo base_url(); ?>assets/views/fg/fg_transfer.js?v1.1"></script>
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
