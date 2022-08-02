<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Customer</title>
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
                            <span><?= isset($customer) ? 'Update Customer' : 'New Customer'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($customer) ? 'Update Customer' : 'New Customer'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/master/customer/customer_new" target="_self">New Customer</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/master/customer">Customer List</a></li>
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
						            <input type="hidden" value="<?= isset($customer) ? $customer['id'] : 0;?>" id="cus_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter customer Code"
										                          id="cus_code" value="<?= isset($customer) ? $customer['cus_code'] : ''; ?>">
                                </div>
								                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control input-sm" placeholder="Enter Description"
									                           id="description"><?= isset($customer) ? $customer['description'] : '';?></textarea>
                                </div>
                            </div>
							              <div class="col-md-4">
								                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter customer name"
										                     id="cus_name" value="<?= isset($customer) ? $customer['cus_name'] : '';?>">
                                </div>
								                <div class="form-group">
                                    <label>Active</label> <br>
									                      <?php $checked = (isset($customer) && $customer['active'] == 'Y') ? 'checked' : ''; ?>
                                    <input type="checkbox" id="cus_active" <?= $checked; ?>>
                                </div>
							              </div>
							              <div class="col-md-4">
								                <div class="form-group">
                                    <label>Other</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Other Details"
										                    id="cus_other" value="<?= isset($customer) ? $customer['cus_other'] : '';?>">
                                </div>
							             </div>
                        </div>

						           <hr>

						          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address Line 1</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Address Line 1"
										                     id="address-line1" value="<?= isset($customer) ? $customer['address_line1'] : '';?>">
                                </div>

                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Address Line 2"
										                     id="address-line2" value="<?= isset($customer) ? $customer['address_line2'] : '';?>">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter City"
										                    id="city" value="<?= isset($customer) ? $customer['city'] : '';?>">
                                </div>
                            </div>
							              <div class="col-md-4">
								                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter State"
										                    id="state" value="<?= isset($customer) ? $customer['state'] : '';?>">
                                </div>
								            <div class="form-group">
            									<label>Country</label>
            									<Select class="form-control input-sm" id="country">
            									<option value="">- SELECT LOCATION -</option>
            										<?php foreach ($countries as $country) {
            												$selected = (isset($customer) && ($customer['country'] == $country['country_name'])) ? 'selected' : '';
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
										                    id="email" value="<?= isset($customer) ? $customer['email'] : '';?>">
                                </div>
							         </div>
          							<div class="col-md-4">
          								<div class="form-group">
                            <label>Phone 1</label>
                            <input type="text" class="form-control input-sm" placeholder="Enter pone number"
          										id="phone1" value="<?= isset($customer) ? $customer['phone1'] : '';?>" maxlength="10">
                          </div>
          								<div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" class="form-control input-sm" placeholder="Enter pone number"
          										id="phone2" value="<?= isset($customer) ? $customer['phone2'] : '';?>" maxlength="10">
                          </div>
          							</div>
                    </div>
        						<div class="row">
        							<div class="col-md-2">
        								<button class="btn btn-primary" id="btn-save">
        								Save Customer Details <i id="btn-save-i"></i></button>
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
    <script src="<?php echo base_url(); ?>assets/views/master/customer/customer.js"></script>
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
