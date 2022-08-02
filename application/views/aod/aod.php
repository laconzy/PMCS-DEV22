<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Supplier AOD</title>
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
      <input type="hidden" value="<?= isset($aod_no) ? $aod_no : 0 ?>" id="aod_no">

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
                            <span><?= isset($aod_no) ? 'Update Supplier AOD' : 'New Supplier AOD' ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($aod_no) ? 'Update Supplier AOD' : 'New Supplier AOD' ?> <span id="title_aod_no"></span>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/aod" target="_self">New Supplier AOD</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/aod/listing">Supplier AOD List</a></li>
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
						            <input type="hidden" value="<?= isset($color) ? $color['color_id'] : 0;?>" id="aod_no">

                          <div class="row">
                            <div class="col-md-2">
                                <label>Order</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter order id"
								                    id="order_id">
                            </div>
                            <div class="col-md-1">
                              <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_search">Search</button>
                            </div>
                            <div class="col-md-3">
                                <label>Contract</label>
                                <select type="text" class="form-control input-sm" id="contract">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>operation</label>
                                <input type="text" class="form-control input-sm" value="" id="operation" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Contract Qty</label>
                                <input type="number" style="text-align:right" class="form-control input-sm" value="0" disabled>
                            </div>
                          </div>

                          <div class="row" style="margin-top:15px">
                            <div class="col-md-3">
                                <label>AOD Qty</label>
                                <input type="number" style="text-align:right" class="form-control input-sm" value="0" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Supplier</label>
                                <input type="text" class="form-control input-sm" id="supplier" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Embellishment Type</label>
                                <input type="text" class="form-control input-sm" id="emb_type" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>AOD Date</label>
                                <input type="text" class="form-control input-sm" id="aod_date">
                            </div>
                          </div>

                          <div class="row" style="margin-top:20px">
              							<div class="col-md-6">
              								<button class="btn btn-primary" id="btn_save_aod">	Save AOD <i id="btn-save-i"></i></button>
              							</div>
              						</div>


                        <hr>

                        <div class="row" style="display:none" id="div_pending_bundles">
                          <div class="col-md-12" >
                            <h4>Pending Bundles</h4>
                            <table id="pending_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th><input type="checkbox" id="select_all"></th>
                                  <th>Item</th>
                                  <th>Bundle No</th>
                                  <th>Barcode</th>
                                  <th>Size</th>
                                  <th>Qty</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>


              							<div class="col-md-6">
              								<button class="btn btn-primary" id="btn_add">	Add Selected Bundles <i id="btn-save-i"></i></button>
              							</div>


                          <hr>

                        </div>





                        <div class="row" style="display:none" id="div_aod_bundles">
                          <div class="col-md-12" >
                            <h4>AOD Bundles</h4>
                            <table id="added_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th><input type="checkbox" id="select_all2"></th>
                                  <th>Item</th>
                                  <th>Bundle No</th>
                                  <th>Barcode</th>
                                  <th>Size</th>
                                  <th>Qty</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>


              							<div class="col-md-6">
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

    <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
    <!-- page js file -->
    <script src="<?php echo base_url(); ?>assets/views/aod/aod.js"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- jquery form validator plugin -->
    <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>



  </body>
</html>
