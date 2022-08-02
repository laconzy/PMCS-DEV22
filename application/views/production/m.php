<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | <?= $operation_name ?></title>
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
                            <span><?= $operation_name ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= $operation_name ?>
                </h2>
                <!--<div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/site/site_new" target="_self">New Colour</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/colour">Colour List</a></li>
                    </ul>
                </div>-->
            </div>
        </div>
        </div>



    <div class="content animate-panel">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body" id="data-form">
						            <input type="hidden" value="<?= isset($color) ? $color['color_id'] : 0;?>" id="color-id">

                        <div class="row form-group">
                            <!--<div class="col-md-2">
                                <label>Order Id</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter order id"
								                    id="order_id" value="<?= isset($color) ? $color['color_code'] : ''; ?>">
                            </div>-->
                            <!--<div class="col-md-1">
                                <button class="btn btn-primary" style="margin-top:20px;margin-left:-15px" id="btn_search">Search</button>
                            </div>-->
                            <div class="col-md-3">
                                <label>Operation</label>
                                <!--<select type="text" class="form-control input-sm" id="operations">
                                </select>-->
								<input type="text" class="form-control input-sm" value="<?= $operation_name; ?>" disabled>
								<input type="hidden" id="operation" value="<?= $operation; ?>">
								<input type="hidden" id="previous_operation" value="<?= $previous_operation; ?>">
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
							<div class="col-md-2">
                              <label>Line No</label>
                              <select class="form-control input-sm" id="line_no">
                                <option value="">... Select Line ...</option>
                                <?php foreach ($lines as $row) { ?>
                                  <option value="<?= $row['line_id'] ?>"><?= $row['line_code'] ?></option>
                                <?php } ?>
                              </select>
                          </div>
						  <div class="col-md-2">
                              <label>Shift</label>
                              <select class="form-control input-sm" id="shift_no">
                                <option value="">... Select Shift ...</option>
                                <option value="A">A</option>
								<option value="B">B</option>
                              </select>
                          </div>
                            <!--<div class="col-md-3">
                                <label>Operation Point</label>
                                <select type="text" class="form-control input-sm" id="operation_point">
                                  <option value="">... Select Point ...</option>
                                  <option value="IN">Operation In</option>
                                  <option value="OUT">Operation Out</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Operation Type</label>
                                <input type="text" class="form-control input-sm" id="operation_type" disabled>
                            </div>-->
                        </div>

                        <!--<div class="row form-group">
                          <div class="col-md-3">
                              <label>UOM IN</label>
                              <input type="text" class="form-control input-sm" id="uom_in" disabled>
                          </div>
                          <div class="col-md-3">
                              <label>UOM Out</label>
                              <input type="text" class="form-control input-sm" id="uom_out" disabled>
                          </div>
                          <div class="col-md-3">
                              <label>Previous Operation</label>
                              <input type="text" class="form-control input-sm" id="previous_operation" disabled>
                          </div>
                          <div class="col-md-3">
                              <label>Next Operation</label>
                              <input type="text" class="form-control input-sm" id="next_operation" disabled>
                          </div>
                        </div>-->

                        <div class="row form-group">
                          
                            <div class="col-md-5">
                                <label>Barcode</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter barcode"  id="barcode">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" style="margin-top:20px" id="btn_add">Add</button>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                          <div class="col-md-12" >
                            <h4>Scanned Bundles</h4>
                            <table id="added_item_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th style="width:10px"><input type="checkbox" id="select_all"/></th>
                                  <th>Item</th>
                                  <th>Color</th>
                                  <th>Bundle No</th>
                                  <th>Barcode</th>
                                  <th>Size</th>
                                  <th>Qty</th>
                                  <th>Line</th>
                                  <th width="15%">Actions</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                        </div>

            						<div class="row">
            							<div class="col-md-2">
            								<button class="btn btn-danger" id="btn_remove">Delete Selected Bundles <i id="btn-save-i"></i></button>
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
	<!-- bootstrap calendar -->
	<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
    <!-- page js file -->
    <script src="<?php echo base_url(); ?>assets/views/production/production.js"></script>
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
