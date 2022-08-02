<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit User</title>
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
                            <span>New Site</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($site) ? 'Update Site' : 'New Site'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/site/site_new" target="_self">New Site</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/site">Site List</a></li>
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

						<input type="hidden" value="<?= isset($site) ? $site['id'] : 0;?>" id="site-id">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Site Code</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Site Code"
										id="site-code" value="<?= isset($site) ? $site['site_code'] : ''; ?>">
                                </div>
								<div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control input-sm" placeholder="Enter Description"
									  id="description"><?= isset($site) ? $site['description'] : '';?></textarea>
                                </div>
                            </div>
							<div class="col-md-4">
								<div class="form-group">
                                    <label>Site Name</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Site Name"
										id="site-name" value="<?= isset($site) ? $site['site_name'] : '';?>">
                                </div>
								<div class="form-group">
                                    <label>Active</label> <br>
									<?php $checked = (isset($site) && $site['active'] == 'Y') ? 'checked' : ''; ?>
                                    <input type="checkbox" id="site-active" <?= $checked; ?>>
                                </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
                                    <label>Other</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Other Details"
										id="site-other" value="<?= isset($site) ? $site['site_other'] : '';?>">
                                </div>
							</div>
                        </div>

						<hr>

						<div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address Line 1</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Address Line 1"
										id="address-line1" value="<?= isset($site) ? $site['address_line1'] : '';?>">
                                </div>

                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Address Line 2"
										id="address-line2" value="<?= isset($site) ? $site['address_line2'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter City"
										id="city" value="<?= isset($site) ? $site['city'] : '';?>">
                                </div>
                            </div>
							<div class="col-md-4">
								<div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter State"
										id="state" value="<?= isset($site) ? $site['state'] : '';?>">
                                </div>
								<div class="form-group">
									<label>Country</label>
									<Select class="form-control input-sm" id="country">
									<option value="">- SELECT LOCATION -</option>
										<?php foreach ($countries as $country) {
												$selected = (isset($site) && ($site['country'] == $country['country_name'])) ? 'selected' : '';
										?>
											<option value="<?php echo $country['country_name']; ?>" <?= $selected ?>>
												<?php echo $country['country_name']; ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter email"
										id="email" value="<?= isset($site) ? $site['email'] : '';?>">
                                </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
                  <label>Phone 1</label>
                  <input type="text" class="form-control input-sm" placeholder="Enter pone number"
										id="phone1" value="<?= isset($site) ? $site['phone1'] : '';?>" maxlength="10">
                </div>
								<div class="form-group">
                  <label>Phone 2</label>
                  <input type="text" class="form-control input-sm" placeholder="Enter pone number"
										id="phone2" value="<?= isset($site) ? $site['phone2'] : '';?>" maxlength="10">
                </div>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-primary" id="btn-save">
								Save Site Details <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/site/site.js"></script>
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
