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
                            <span>New Colour</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($site) ? 'Update Bundle Chart' : 'Create Bundle Chart'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/site/site_new" target="_self">New Colour</a></li>
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
						            <input type="hidden" value="<?= isset($color) ? $color['color_id'] : 0;?>" id="color-id">

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Laysheet Number</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter colour Code"
								                    id="color-code" value="<?= isset($color) ? $color['color_code'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Factory</label>
                                <input type="text" class="form-control input-sm" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Docket</label>
                                <input type="text" class="form-control input-sm">
                            </div>
                            <div class="col-md-3">
                              <label>QA Status</label>
                              <input type="text" class="form-control input-sm" >
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Maker Type</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter colour Code"
								                    id="color-code" value="<?= isset($color) ? $color['color_code'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Cut Plan Serial</label>
                                <input type="text" class="form-control input-sm" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Cut Number</label>
                                <input type="text" class="form-control input-sm">
                            </div>
                            <div class="col-md-3">
                              <label>Number Of Layers</label>
                              <input type="text" class="form-control input-sm" >
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Bundle to Plies</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter colour Code"
								                    id="color-code" value="<?= isset($color) ? $color['color_code'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Remarks</label>
                                <input type="text" class="form-control input-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Garment Component</label>
                                <input type="text" class="form-control input-sm" disabled>
                            </div>
                            <div class="col-md-3">
                              <label>Colour</label>
                              <input type="text" class="form-control input-sm" disabled>
                            </div>
                        </div>

                        <div class="row" style="margin-top:20px">
                          <div class="col-md-12">
                            <h4>Cutting Summery</h4>
                              <table id="order_table" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                  <tr>
                                    <th>Size</th>
                                    <th>Ratio</th>
                                    <th>Planned Qty</th>
                                    <th>Cut Qty</th>
                                    <th>Bundle Qty</th>
                                    <th width="15%">Remaning</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>S</td>
                                    <td>2</td>
                                    <td>16000</td>
                                    <td>150</td>
                                    <td>1500</td>
                                    <td>16000</td>
                                  </tr>
                                  <tr>
                                    <td>M</td>
                                    <td>3</td>
                                    <td>18000</td>
                                    <td>1500</td>
                                    <td>150</td>
                                    <td>16000</td>
                                  </tr>
                                  <tr>
                                    <td>L</td>
                                    <td>t</td>
                                    <td>15000</td>
                                    <td>15000</td>
                                    <td>180</td>
                                    <td>16000</td>
                                  </tr>
                                </tbody>
                              </table>
                          </div>
                        </div>

                        <div class="row">
            							<div class="col-md-2">
            								<button class="btn btn-primary" id="btn-save">
            								Create Bundles <i id="btn-save-i"></i></button>
            							</div>
            						</div>

                        <hr>

                        <div class="row">
                          <div class="col-md-12" >
                            <h4>Bundle Chart</h4>
                            <table id="order_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Bundle No</th>
                                  <th>Barcode</th>
                                  <th>Qty</th>
                                  <th width="15%">Order Qty</th>
                                  <th width="15%">Planned Qty</th>
                                  <th width="15%">Goup</th>
                                  <th width="15%">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>PRO001</td>
                                  <td>Polo Shirt</td>
                                  <td>RED</td>
                                  <td>15000</td>
                                  <td>16000</td>
                                  <td>1</td>
                                  <td>
                                    <button class="btn btn-danger btn-xs">Delete</button>
                                  </td>
                                </tr>
                                <tr>
                                  <td>PRO001</td>
                                  <td>Polo Shirt</td>
                                  <td>RED</td>
                                  <td>15000</td>
                                  <td>16000</td>
                                  <td>1</td>
                                  <td>
                                    <button class="btn btn-danger btn-xs">Delete</button>
                                  </td>
                                </tr>
                                <tr>
                                  <td>PRO001</td>
                                  <td>Polo Shirt</td>
                                  <td>RED</td>
                                  <td>15000</td>
                                  <td>16000</td>
                                  <td>1</td>
                                  <td>
                                    <button class="btn btn-danger btn-xs">Delete</button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>

            						<div class="row">
            							<div class="col-md-2">
            								<button class="btn btn-danger" id="btn-save">
            								Delete All Bundles <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script>
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
