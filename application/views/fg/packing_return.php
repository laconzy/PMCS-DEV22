<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | FG Packing Return</title>

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

							<span>Cartoon Return</span>

						</li>

					</ol>

				</div>

				<h2 class="font-light m-b-xs text-success">
					FG CARTOON RETURN
				</h2>

				<div class="btn-group">

					<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>

					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url(); ?>index.php/fg/packing_list/packing_return" target="_self">Cartoon Return</a></li>
						<!-- <li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/master/colour">Colour List</a></li> -->
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

						<div class="row form-group">
							<div class="col-md-3">
								<label>Packing List ID#</label>
								<div class="input-group date">
									<input type="text" class="form-control input-sm" placeholder="Enter packing list ID" id="laysheet_no">
									<span class="input-group-addon"><i class="glyphicon glyphicon-search" style="cursor:pointer" id="btn_laysheet_search"></i></span>
								</div>
							</div>

							<div class="col-md-2">
								<label>Packing List #</label>
								<input type="text" class="form-control input-sm" id="packing_list_id" disabled>
							</div>
							<div class="col-md-2">
								<label>PO#</label>
								<input type="text" class="form-control input-sm" id="customer_po" disabled>
							</div>
							<div class="col-md-2">
								<label>Style</label>
								<input type="text" class="form-control input-sm" id="style" disabled>
							</div>
							<div class="col-md-2">
								<label>Customer</label>
								<input type="text" class="form-control input-sm" id="customer" value="" disabled>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-2">
								<label>Conatainer No</label>
								<input type="text" class="form-control input-sm" id="container" disabled>
							</div>
							<div class="col-md-2">
								<label>Ref</label>
								<input type="text" class="form-control input-sm" id="ref_1" disabled>
							</div>
							<div class="col-md-2">
								<label>Ref 2</label>
								<input type="text" class="form-control input-sm" id="ref_2" disabled>
							</div>
							<div class="col-md-2">
								<label>Ref 3</label>
								<input type="text" class="form-control input-sm" placeholder="Enter plies count" id="ref_3" value="" disabled>
							</div>
							<div class="col-md-3">
								<label>Site</label>
								<select id="site" class="form-control input-sm" disabled>
									<option value="0">-Select Site-</option>
									<?php foreach ($site as $row) { ?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['site_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<!-- <div class="row form-group">
							<div class="col-md-2">
								<button class="btn btn-primary btn-sm" id="btn_save" style="display:none">Save <i id="btn-save-i"></i></button>
							</div>
						</div> -->



						<div class="row">
							<div class="col-md-2">
								<!-- <button class="btn btn-primary" id="btn_create_bundles">
									Create Bundles <i id="btn-save-i"></i></button> -->
							</div>
						</div>

						<div class="row">
							<!-- <div class="col-md-3">
								<div class="form-group">
									<label>Order ID</label>
									<select class="form-control input-sm" id="order_id">
										<option value="">... Select One ...</option>
									</select>
								</div>
							</div> -->
							<!-- <div id="div_barcode" style="display:none">
								<div class="col-md-3">
									<div class="form-group">
										<label>Barcode</label>
										<input type="text" class="form-control input-sm" placeholder="Enter barcode" id="barcode" value="" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<button class="btn btn-primary btn-sm" style="margin-top:22px" id="btn-add-barcode">Scan Barcode</button>
								</div>
							</div> -->
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12" >
								<h4>Return Cartoon List</h4>
								<table id="bundle_chart_table" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
									<tr>
										<th ></th>
										<th >Color</th>
										<th >Size</th>
										<th >PCS PER CTN</th>
										<th >CTN QTY </th>
										<th >Total QTY </th>
										<!-- <th >Return CTN QTY </th> -->
										<th >Total Return QTY </th>
										<th>QTY To Return</th>
										<!-- <th >N.N.W(KG) </th>
										<th >N.W(KG) </th> -->
										<th id="td_action" style="display:none">Action </th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
									<button class="btn btn-info btn-sm" id="btn_return" style="display:none">Save Return Items<i id="btn-confirm-i"></i></button>
									<button class="btn btn-primary btn-sm" id="print_report" style="display:none">Print <i id="btn-save-i"></i></button>
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
<script src="<?php echo base_url(); ?>assets/views/fg/packing_return.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>

<script>
	var BASE_URL = '<?php echo base_url(); ?>';
</script>

</body>

</html>
