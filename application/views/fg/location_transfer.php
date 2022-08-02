<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>PMCS | FG To Left Over Transfer</title>
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
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/izitoast/css/iziToast.min.css">
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
                           <span>Location Transfer</span>
                        </li>
                     </ol>
                  </div>
                  <h2 class="font-light m-b-xs text-success">
                     LOCATION TO LOCATION TRANSFER <?= isset($transfer_id) ? ' - ' . $transfer_id : ''; ?>
                  </h2>
                  <div class="btn-group">
                     <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                     <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/fg/location_transfer/new_transfer" target="_self">New location Transfer</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/fg/location_transfer">Transfer List</a></li>
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

											 <input type="hidden" value="<?= isset($transfer_id) ? $transfer_id : ''; ?>" id="transfer_id">

											 <?php if(isset($transfer_id) == false) { ?>
													 <div class="row">
															 <div class="col-md-6">
																 <div class="row form-group">
																	 <label class="text-success" style="font-size:15px;">FROM LOCATION</label>
																 </div>
																 <div class="form-group">
																		<label>Site</label>
																		<select class="form-control input-sm" id="from_site_id">
																			<option value="">...Select One...</option>
																			<?php
																				foreach ($sites as $row) {
																					echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
																				}
																			?>
																		</select>
																 </div>
																 <div class="form-group">
																		<label>Line ID</label>
																		<select class="form-control input-sm" id="from_line_id"></select>
																 </div>
																 <div class="form-group">
																		<label>Style</label>
																		<select class="form-control input-sm" id="from_style_id">
																			<option value="">...Select One...</option>
																			<?php
																				foreach ($styles as $row) {
																					echo '<option value="'.$row['style_id'].'">'.$row['style_code'].'</option>';
																				}
																			?>
																		</select>
																 </div>
																 <div class="form-group">
																		<label>Color</label>
																		<select class="form-control input-sm" id="from_color_id"></select>
																 </div>
																 <div class="form-group">
																		<button class="btn btn-primary btn-sm" id="btn_search">Search</button>
																 </div>
																 <div class="form-group">
																		<label>Order ID</label>
																		<select class="form-control input-sm" id="from_order_id"></select>
																 </div>
															 </div>

															 <div class="col-md-6">
																 <div class="row form-group">
																	 <label class="text-success" style="font-size:15px;">TO LOCATION</label>
																 </div>
																 <div class="form-group">
																		<label>Site</label>
																		<select class="form-control input-sm" id="to_site_id" disabled>
																			<option value="">...Select One...</option>
																			<?php
																				foreach ($sites as $row) {
																					echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
																				}
																			?>
																		</select>
																 </div>
																 <div class="form-group">
																		<label>Line ID</label>
																		<select class="form-control input-sm" id="to_line_id"></select>
																 </div>
                                 <div class="form-group" id="div_to_order_id" style="display:none">
																		<label>Order ID</label>
																		<select class="form-control input-sm" id="to_order_id"></select>
																 </div>
															 </div>
												 		</div>
												<?php } ?>

												<?php if(isset($transfer_id) == true) { ?>
 													 <div class="row">
 															 <div class="col-md-6">
 																 <div class="row form-group">
 																	 <label class="text-success" style="font-size:15px;">FROM LOCATION</label>
 																 </div>
 																 <div class="form-group">
 																		<label>Site</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['from_site_name'] ?>" disabled>
 																 </div>
 																 <div class="form-group">
 																		<label>Line ID</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['from_line_code'] ?>" disabled>
 																 </div>
 																 <div class="form-group">
 																		<label>Style</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['style_code'] ?>" disabled>
 																 </div>
 																 <div class="form-group">
 																		<label>Color</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['color_code'] ?>" disabled>
 																 </div>
 																 <div class="form-group">
 																		<label>Order ID</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['from_order_id'] ?>" disabled>
 																 </div>
 															 </div>

 															 <div class="col-md-6">
 																 <div class="row form-group">
 																	 <label class="text-success" style="font-size:15px;">TO LOCATION</label>
 																 </div>
 																 <div class="form-group">
 																		<label>Site</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['to_site_name'] ?>" disabled>
 																 </div>
 																 <div class="form-group">
 																		<label>Line ID</label>
 																		<input type="text" class="form-control input-sm" value="<?= $header_data['to_line_code'] ?>" disabled>
 																 </div>
                                 <?php if($header_data['transfer_sub_type'] != null && $header_data['transfer_sub_type'] == 'LEFT_OVER_TO_FG') { ?>
                                   <div class="form-group">
  																		<label>Order ID</label>
  																		<input type="text" class="form-control input-sm" value="<?= $header_data['to_order_id'] ?>" disabled>
  																 </div>
                                 <?php } ?>
 															 </div>
 												 		</div>
 												<?php } ?>


                        <hr>
                        <div class="row">
                           <div class="col-md-8" >
                              <table id="tbl_from" class="table table-striped table-bordered table-hover" width="100%">
                                 <thead>
                                    <tr>
                                       <th></th>
                                       <th >Size</th>
                                       <th >Order Qty</th>
                                       <th >Planned Qty</th>
																			 <th >Location Qty</th>
																			 <th >Transfered Qty</th>
                                    </tr>
                                 </thead>
                                 <tbody>
																	 <?php if(isset($transfer_id) == true) {
																		 	foreach ($stock as $row) { ?>
                                        <tr>
																				<td></td>
																				<td><?= $row['size_code'] ?></td>
																				<td><?= isset($row['order_qty']) ? $row['order_qty'] : '' ?></td>
																				<td><?= isset($row['planned_qty']) ? $row['planned_qty'] : '' ?></td>
																				<td><?= $row['fg_qty'] ?></td>
																				<td><?= $row['transfered_qty'] ?></td>
                                      </tr>
																	 <?php } } ?>
                                 </tbody>
                              </table>
                           </div>
                           <!-- <div class="col-md-6" >
                              <table id="tbl_to" class="table table-striped table-bordered table-hover" width="100%">
                                 <thead>
                                    <tr>
                                       <th >Size</th>
                                       <th >Order QTY</th>
                                       <th >FG QTY</th>
                                       <th >Transferd QTY</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div> -->
                        </div>
                        <hr>
                        <div class="row">
                          <?php if(isset($transfer_id) == false) { ?>
            							<div class="col-md-6" id="transfer_reason_div" style="display:none">
            								<label>Transfer Reason</label>
            								<select class="form-control input-sm" id="transfer_reason">
            									<option value="">... Select Reason ...</option>
            									<?php
            									 	foreach ($transfer_reasons as $row) {
            									 		echo '<option value="'.$row['reason_id'].'">'.$row['reason_text'].'</option>';
            									 	}
            									?>
            								</select>
            							</div>
            							<?php } ?>

                          <?php if(isset($transfer_id) == true) { ?>
                         <div class="col-md-6" id="transfer_reason_div">
                           <label>Transfer Reason</label>
                           <input class="form-control input-sm" value="<?= $header_data['reason_text'] ?>" disabled>
                         </div>
                         <?php } ?>

                           <div class="col-md-2">
                              <button class="btn btn-primary btn-sm" id="btn_transfer" style="display:none;margin-top:20px">Transfer <i id="btn-transfer-i"></i></button>
                              <?php if(isset($transfer_id)) { ?>
                              <a class="btn btn-primary btn-sm" style="margin-top:20px" href="<?= base_url() . 'index.php/fg/location_transfer/print_transfer/' . $transfer_id ?>" target="blank">Print</a>
                              <?php } ?>
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
      <script src="<?php echo base_url(); ?>assets/views/fg/location_transfer.js?v1.1"></script>
      <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
      <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
      <!-- jquery form validator plugin -->
      <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
      <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/plugins/izitoast/js/iziToast.min.js" type="text/javascript"></script>
      <script>
         var BASE_URL = '<?php echo base_url(); ?>';
      </script>
   </body>
</html>
