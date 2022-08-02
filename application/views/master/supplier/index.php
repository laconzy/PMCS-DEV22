<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Supplier</title>
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
                            <span><?= isset($supplier) ? 'Update Supplier' : 'New Supplier'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($supplier) ? 'Update Supplier' : 'New Supplier'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/supplier" target="_self">New Supplier</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/supplier/listing">Supplier List</a></li>
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
						            <input type="hidden" value="<?= isset($supplier) ? $supplier['supplier_id'] : 0;?>" id="supplier_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier Code</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter supplier Code"
										                    id="supplier_code" value="<?= isset($supplier) ? $supplier['supplier_code'] : ''; ?>">
                                </div>
								                <div class="form-group">
                                    <label>Supplier Name</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter supplier Name"
                                        id="supplier_name" value="<?= isset($supplier) ? $supplier['supplier_name'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>Supplier Address</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter supplier address"
                                        id="supplier_address" value="<?= isset($supplier) ? $supplier['supplier_address'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>Supplier Phone No</label>
                                    <input type="text" class="form-control input-sm" maxlength="10" placeholder="Enter supplier phone no"
                                        id="supplier_phone" value="<?= isset($supplier) ? $supplier['supplier_phone'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>Active</label> <br>
                                    <?php $checked = (isset($supplier) && $supplier['active'] == 'Y') ? 'checked' : ''; ?>
                                    <input type="checkbox" id="supplier_active" <?= $checked; ?>>
                                </div>
                            </div>

                        </div>

						<hr>


						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-primary" id="btn_save">
								Save Supplier Details <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/supplier/supplier.js"></script>
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
