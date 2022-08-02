<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | HOD Allocation</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->

    <!-- bootstrap datepicker -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">

	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />

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
                            <span><?= isset($allocation) ? 'Update HOD Allocation' : 'New HOD Allocation'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($allocation) ? 'Update HOD Allocation' : 'New HOD Allocation'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/hod_allocation/hod_allocation_new" target="_self">New HOD Allocation</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/hod_allocation">HOD Allocation List</a></li>
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
						            <input type="hidden" value="<?= isset($allocation) ? $allocation['id'] : 0;?>" id="id">
                        <input type="hidden" value="<?= isset($allocation) ? $allocation['user_id'] : 0;?>" id="user_id_hidden">
                        <input type="hidden" value="<?= isset($allocation) ? ($allocation['first_name'] .' '.$allocation['last_name']) : '';?>" id="user_full_name_hidden">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Site <span style="color:red">*</span></label>
                                    <select class="form-control input-sm" id="site_id">
                                      <option value="">...Select One...</option>
                                      <?php foreach ($sites as $row) { ?>
                                        <option value="<?= $row['id'] ?>" <?= (isset($allocation) && $allocation['site_id'] == $row['id']) ? 'selected' : '' ?>><?= $row['site_name'] ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
								               <div class="form-group">
                                    <label>Department <span style="color:red">*</span></label>
                                    <select class="form-control input-sm" id="department_id">
                                      <option value="">...Select One...</option>
                                      <?php foreach ($departments as $row) { ?>
                                        <option value="<?= $row['dep_id'] ?>" <?= (isset($allocation) && $allocation['department_id'] == $row['dep_id']) ? 'selected' : '' ?>><?= $row['dep_name'] ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                     <label>User <span style="color:red">*</span></label>
                                     <select class="form-control input-sm" id="user_id">
                                       <option value="">...Select One...</option>
                                     </select>
                                 </div>
                                <div class="form-group">
                                    <label>Active <span style="color:red">*</span></label> <br>
                                    <?php $checked = (isset($allocation) && $allocation['active'] == 'Y') ? 'checked' : ''; ?>
                                    <input type="checkbox" id="active" <?= $checked; ?>>
                                </div>
                            </div>

                        </div>

						<hr>


						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-primary" id="btn-save">Allocate HOD <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/hod_allocation/hod_allocation.js"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>

    <!-- <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script> -->
    <!-- jquery form validator plugin -->
    <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>



  </body>
</html>
