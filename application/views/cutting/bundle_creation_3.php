<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Add/Edit Colour</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->


	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

	<!-- App styles -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">


	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>


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

							<span>Bundel Creation</span>

						</li>

					</ol>

				</div>

				<h2 class="font-light m-b-xs text-success">

					<?= isset($site) ? 'End Bits Mini Bundle Chart' : 'End Bits Mini Bundle Chart'; ?>

				</h2>

				<div class="btn-group">

					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">
						Action <span class="caret"></span></button>

					<ul class="dropdown-menu">

						<li><a href="<?php echo base_url(); ?>index.php/master/site/site_new" target="_self">New
								Colour</a></li>

						<li class="divider"></li>

						<li><a href="<?php echo base_url(); ?>index.php/master/colour">Colour List</a></li>

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

						<input type="hidden" value="<?= isset($color) ? $color['color_id'] : 0; ?>" id="color-id">


						<div class="row form-group">

							<div class="col-md-2">

								<label>Cut Plan Number</label>

								<input type="text" class="form-control input-sm" placeholder="Enter laysheet no"
									   id="laysheet_no">

							</div>

							<div class="col-md-1">

								<button class="btn btn-primary" style="margin:20px;margin-left:-15px"
										id="btn_laysheet_search">Search
								</button>

							</div>

							<div class="col-md-3">

								<label>Factory</label>

								<input type="text" class="form-control input-sm" id="factory" disabled>

							</div>

							<div class="col-md-3">

								<label>Cut Plan Serial</label>

								<input type="text" class="form-control input-sm" id="cut_plan_id" disabled>

							</div>

							<div class="col-md-3">

								<label>Cut Number</label>

								<input type="text" class="form-control input-sm" id="cut_no">

							</div>

							<!--<div class="col-md-3">

								<label>Docket</label>

								<input type="text" class="form-control input-sm">

							</div>-->

							<!--<div class="col-md-3">

							  <label>QA Status</label>

							  <select class="form-control input-sm" >

								<option >APPROVE</option>

								<option>REJECT</option>

							  </select>

							</div>-->

						</div>


						<div class="row form-group">

							<!--<div class="col-md-3">

                                <label>Maker Type</label>

                                <input type="text" class="form-control input-sm" placeholder="Enter colour Code"

								                    id="color-code" value="<?= isset($color) ? $color['color_code'] : ''; ?>">

                            </div>-->

							<div class="col-md-3">

								<label>Colour</label>

								<input type="text" class="form-control input-sm" id="color" disabled>

							</div>

							<div class="col-md-3">

								<label>Item</label>

								<input type="text" class="form-control input-sm" id="item" disabled>

							</div>

							<div class="col-md-3">

								<label>Number Of Layers</label>

								<input type="text" class="form-control input-sm" id="lay_qty">

							</div>

							<div class="col-md-3">

								<label>Bundle to Plies</label>

								<input type="text" class="form-control input-sm" placeholder="Enter plies count"

									   id="no_of_plies" value="">

							</div>

						</div>


						<div class="row form-group">


							<!--							<div class="col-md-3">-->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!--							</div>-->

							<div class="col-md-3">
								<label>Site</label>
								<select id="myselect" class="form-control input-sm">
									<option value="0">-Select Site-</option>
									<?php foreach ($site as $row) { ?>

										<option value="<?php echo $row['id']; ?>"><?php echo $row['site_name']; ?></option>

									<?php } ?>
								</select>


							</div>
							<div class="col-md-2">

                                        <label >Date</label>

                                        <div class="input-group">

                                            <div class="input-group-addon">

                                                <i class="fa fa-calendar"></i>

                                            </div>

                                            <div class="input-group input-daterange">

                                                <input type="text" class="form-control input-sm date" value="<?= date('Y-m-d'); ?>" id="scan_date" >

                                            </div>

                                        </div>

                                    </div>

																		<div class="col-md-3">
																			<label>Shift</label>
																			<select id="shift" class="form-control input-sm">
																				<option value="">...Select Shift...</option>
																				<option value="A">A</option>
																				<option value="B">B</option>
																			</select>


																		</div>
						</div>


						</div>


						<div class="row" style="margin-top:20px">

							<div class="col-md-12">

								<h4>Cutting Summery</h4>

								<table id="summery_table" class="table table-striped table-bordered table-hover"
									   width="100%">

									<thead>

									<tr>
										<th>Select</th>
										<th>Size</th>
										<th>Ratio</th>
										<th>Order QTy</th>
										<th>Planned Qty</th>
<!--										<th>Cut Qty</th>-->
<!---->
<!--										<th>Bundle Qty</th>-->
<!---->
<!--										<th width="15%">Remaning</th>-->

									</tr>

									</thead>

									<tbody>


									</tbody>

								</table>

							</div>

						</div>


						<div class="row">

							<div class="col-md-2">

								<button class="btn btn-primary" id="btn_create_bundles">

									Create Bundles <i id="btn-save-i"></i></button>

							</div>

						</div>


						<hr>


						<div class="row">

							<div class="col-md-12">

								<h4>Bundle Chart</h4>

								<table id="bundle_chart_table" class="table table-striped table-bordered table-hover"
									   width="100%">

									<thead>

									<tr>

										<th>Bundle No</th>

										<th>Barcode</th>

										<th>Size</th>

										<th>Qty</th>

										<th width="15%">Actions</th>

									</tr>

									</thead>

									<tbody>


									</tbody>

								</table>

							</div>

						</div>


						<div class="row">

							<div class="col-md-6">

								<button class="btn btn-danger" id="btn_delete_all">Delete All Bundles <i
											id="btn-save-i"></i></button>

								<button class="btn btn-info" id="btn_print"> Bundle Chart <i id="btn-save-i"></i>
								</button>

								<button class="btn btn-info" id="btn_print_barcode">Barcode <i
											id="btn-save-i"></i></button>
								<button class="btn btn-info" id="btn_print_barcode_2">3Ply Print <i
											id="btn-save-i"></i></button>

							</div>
							<div class="col-md-6">

								<input type="checkbox" id="Front" checked> <label>Front</label>
								<input type="checkbox" id="Back"> <label>Back</label>
								<input type="checkbox" id="Sleeve"> <label>Sleeve</label>
								<input type="checkbox" id="Placket"> <label>Placket</label>
								<input type="checkbox" id="Collar"> <label>Collar</label>
								<input type="checkbox" id="Pocket"> <label>Pocket</label>
								<input type="checkbox" id="Yoke"> <label>Yoke</label>
								<input type="checkbox" id="Cuff"> <label>Cuff</label>
								<input type="checkbox" id="NeckBand"> <label>NeckBand</label>
								<input type="checkbox" id="Hood"> <label>Hood</label>
								<input type="checkbox" id="WaistBand"> <label>WaistBand</label>
							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>





</div>


<!-- jQuery 2.1.4 -->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Bootstrap 3.3.5 -->

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>


<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
 <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- page js file -->

<script src="<?php echo base_url(); ?>assets/views/cutting/bundle_creation_3.js?v1.2"></script>

<script src="<?php echo base_url(); ?>assets/application/app.js"></script>


<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

<!-- jquery form validator plugin -->

<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>


</body>

</html>
