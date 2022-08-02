<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Reason</title>
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
                            <span><?= isset($reason) ? 'Update Reason' : 'New Reason'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($reason) ? 'Update Reason' : 'New Reason'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/reason/reason_new" target="_self">New Reason</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/reason">Reason List</a></li>
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
						            <input type="hidden" value="<?= isset($reason) ? $reason['reason_id'] : 0;?>" id="reason_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control input-sm" id="category" value="<?= isset($reason) ? $reason['category'] : ''; ?>">
                                      <option value="">... Select One ...</option>
                                      <?php
                                        foreach ($categories as $row) {
                                          if(isset($reason) && $row['category'] == $reason['category']){
                                            echo '<option value="'.$row['category'].'" selected>'.$row['category'].'</option>';
                                          }
                                          else {
                                            echo '<option value="'.$row['category'].'">'.$row['category'].'</option>';
                                          }
                                        }
                                       ?>
                                    </select>
                                </div>
								                <div class="form-group">
                                    <label>Reason</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter reason"
                                        id="reason_text" value="<?= isset($reason) ? $reason['reason_text'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>Active</label> <br>
                                    <?php $checked = (isset($reason) && $reason['active'] == 'Y') ? 'checked' : ''; ?>
                                    <input type="checkbox" id="reason-active" <?= $checked; ?>>
                                </div>
                            </div>

                        </div>

						<hr>


						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-primary" id="btn-save">
								Save Reason Details <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/reason/reason.js"></script>
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
