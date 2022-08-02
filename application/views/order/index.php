<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Page title -->
	<title>PMSC - Add Order Details</title>

	<?php $this->load->view('common/head'); ?>

	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/messagebox/messagebox.min.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/jquery_notification/alert/themes/default/theme.css" rel="stylesheet" />
	<!-- select 2 plugin -->
	<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap/select2-bootstrap.css" />-->
	<link href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
</head>
<body>

	<!-- hidden data fields -->
	<input type="hidden" id="base-url" value="<?= base_url() ?>">

	<?php $this->load->view('common/header'); ?>

	<?php $this->load->view('common/left_menu'); ?>

	<!-- Main Wrapper -->
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
								<span>Order</span>
							</li>
							<li class="active">
								<span>Add Order Details</span>
							</li>
						</ol>
					</div>
					<h2 class="font-light m-b-xs text-success">
						Add Order Details
					</h2>
					<small>Add Order Details.</small>
				</div>
			</div>
		</div>

		<div class="content animate-panel ">
			<div class="row">
				<div class="col-lg-12">
					<div class="hpanel hgreen">
						<div class="panel-body">
							<div class="wrapper wrapper-content animated fadeIn">
								<div class="row">
									<div class="col-lg-12">
										<div class="tabs-container">
											<ul class="nav nav-tabs">
												<li class="active"><a data-toggle="tab" href="#tab-1"><strong>Order Details</strong></a></li>
												<li id="tab_head_2" class="" style="display:<?= (isset($order_id) && $order_id > 0) ? '' : 'none' ?>"><a data-toggle="tab" href="#tab-2"><strong>Item Details</strong></a></li>
												<li id="tab_head_3" class="" style="display:<?= (isset($order_id) && $order_id > 0) ? '' : 'none' ?>"><a data-toggle="tab" href="#tab-3"><strong>Order Operations</a></strong></li>
											</ul>
											<div class="tab-content">

												<div id="tab-1" class="tab-pane active">
														<?php $this->load->view('order/order_details'); ?>
												</div>

												<div id="tab-2" class="tab-pane" style="display:<?= (isset($order_id) && $order_id > 0) ? '' : 'none' ?>">
														<?php $this->load->view('order/item_details'); ?>
												</div>

												<div id="tab-3" class="tab-pane" style="display:<?= (isset($order_id) && $order_id > 0) ? '' : 'none' ?>">
														<?php $this->load->view('order/operations'); ?>
												</div>

											</div>

										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<?php $this->load->view('order/item_model'); ?>

			<?php $this->load->view('common/footer'); ?>

		</div>

	</div>

	<?php $this->load->view('common/script'); ?>

	<!--<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/spin.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/ladda.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/ladda.jquery.min.js"></script>-->

	<script src="<?php echo base_url(); ?>assets/views/order/order.js"></script>
	<!-- bootstrap calendar -->
	<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- jquery form validator plugin -->
	<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
	<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>

</body>
</html>
