<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Manual Gate Pass</title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">

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
                            <span>Gate Pass</span>
                        </li>
                        <li class="active">
                            <span><?= isset($gp) ? 'Update Manual Gate Pass' : 'New Manual Gate Pass'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($gp) ? 'Update Manual Gate Pass' : 'New Manual Gate Pass'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/gatepass/manual_gatepass" target="_self">New Manual Gate Pass</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/gatepass/manual_gatepass_list">Gate Pass List</a></li>
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
						            <input type="hidden" value="<?= isset($gp) ? $gp['id'] : 0;?>" id="id">
                        <input type="hidden" value="<?= isset($gp) ? $gp['status'] : 'NEW';?>" id="gp_status">

                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label>Gate pass no</label>
                                  <input type="text" class="form-control input-sm" id="no" value="<?= isset($gp) ? $gp['id'] : '' ?>" disabled>
                              </div>
                              <div class="form-group">
                                <label>Company</label>
                                <select class="form-control input-sm" type="text" id="company" disabled>
                                  <option value="">... Select ...</option>
                                  <?php foreach ($sites as $site) {
                                    if($user_site != null && $user_site == $site['id']){
                                      echo '<option value="'.$site['id'].'" selected>'.$site['site_name'].'</option>';
                                    }
                                    else {
                                      echo '<option value="'.$site['id'].'">'.$site['site_name'].'></option>';
                                    }
                                   } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                  <label>Gate Pass To <span style="color:red">*</span></label>
                                  <input type="text" class="form-control input-sm" id="to_address" value="<?= isset($gp) ? $gp['to_address'] : '' ?>">
                              </div>
                              <div class="form-group">
                                  <label>Attention <span style="color:red">*</span></label>
                                  <input type="text" class="form-control input-sm" id="attention" value="<?= isset($gp) ? $gp['attention'] : '' ?>">
                              </div>
                              <div class="form-group">
                                  <label>Remarks <span style="color:red">*</span></label>
                                  <input type="text" class="form-control input-sm" id="remarks" value="<?= isset($gp) ? $gp['remarks'] : '' ?>">
                              </div>
                              <div class="form-group">
                                  <label>Date</label>
                                  <input type="text" class="form-control input-sm" id="date" value="<?= isset($gp) ? $gp['date'] : $current_date ?>" disabled>
                              </div>
                              <div class="form-group">
                                  <label>Gate Pass Type</label>
                                  <select class="form-control input-sm" type="text" id="gp_type">
                                      <option value="style" <?= (isset($gp) && $gp['type'] == 'style') ? 'selected' : '' ?>>Style</option>
                                      <option value="general" <?= (isset($gp) && $gp['type'] == 'general') ? 'selected' : '' ?>>General</option>
                                      <option value="laysheet transfer" <?= (isset($gp) && $gp['type'] == 'laysheet transfer') ? 'selected' : '' ?>>Laysheet Transfer</option>
                                  </select>
                              </div>
                            </div>


                            <div class="col-md-6">
                              <div class="form-group">
                                <label>REF / Style <span style="color:red">*</span></label>
                                <input type="text" class="form-control input-sm" id="ref_style" value="<?= isset($gp) ? $gp['style'] : '' ?>">
                              </div>
                              <div class="form-group">
                                <label>Through <span style="color:red">*</span></label>
                                <input type="text" class="form-control input-sm" id="through" value="<?= isset($gp) ? $gp['through'] : '' ?>">
                              </div>
                              <div class="form-group">
                                <label>Instructed By <span style="color:red">*</span></label>
                                <input type="text" class="form-control input-sm" id="instructed_by" value="<?= isset($gp) ? $gp['instructed_by'] : '' ?>">
                              </div>
                              <div class="form-group">
                                <label>Special Instruction</label>
                                <input type="text" class="form-control input-sm" id="special_instruction" value="<?= isset($gp) ? $gp['special_instruction'] : '' ?>">
                              </div>
                              <div class="form-group">
                                  <label>Return Status <span style="color:red">*</span></label>
                                  <select class="form-control input-sm" id="return_status">
                                      <option value="">...Select One...</option>
                                      <option value="returnable"  <?= (isset($gp) && $gp['return_status'] == 'returnable') ? 'selected' : '' ?>>Returnable</option>
                                      <option value="non returnable" <?= (isset($gp) && $gp['return_status'] == 'non returnable') ? 'selected' : '' ?>>Non Returnable</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control input-sm" value="<?= isset($gp) ? $gp['status'] : '' ?>" disabled>
                              </div>
                              <!-- <div class="form-group">
                                <label>Approval Person</label>
                                <input type="text" class="form-control input-sm">
                              </div> -->
                            </div>

                            <div class="col-md-12" style="text-align: left">
                              <?php if(isset($gp) == false || (isset($gp) == true && $gp['status'] == 'NEW')) { ?>
                                <button class="btn btn-primary btn-sm" id="btn_save">Save</button>
                              <?php } ?>

                              <?php if(isset($gp) && $gp['status'] == 'NEW') { ?>
                                <button class="btn btn-primary btn-sm" id="btn_add">Add</button>
                              <?php } ?>

                              <?php if(isset($gp) && $gp['status'] == 'APPROVE') { ?>
                                <button class="btn btn-warning btn-sm" id="btn_receive">Receive</button>
                              <?php } ?>

                              <?php if(isset($gp)) { ?>
                                <button class="btn btn-info btn-sm" id="btn_print">Print</button>
                              <?php } ?>
                            </div>

                            <?php if(isset($gp) && $gp['type'] != 'laysheet transfer') { ?>
                            <div class="col-lg-12" style="margin-top: 20px">
                              <table id="gp_items" class="table table-striped table-bordered table-hover" width="100%">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Details</th>
                                          <th>Unit</th>
                                          <th>Qty</th>
                                          <?php if($gp['status'] == 'NEW') { ?>
                                            <th>Action</th>
                                          <?php } ?>
                                      </tr>
                                  </thead>
                                  <!-- <?php foreach ($items as $row) { ?>
                                    <tr>
                                      <td><?= $row['line_no'] ?></td>
                                			<td><?= $row['description'] ?></td>
                                			<td><?= $row['unit'] ?></td>
                                			<td><?= $row['qty'] ?></td>
                                			<td><?= $row['status'] ?></td>
                                			<td>
                                        <button class="btn btn-success btn-sm" data-id="<?= $row['id'] ?>" data-header-id="<?= $row['header_id'] ?>" data-type="edit">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-id="<?= $row['id'] ?>" data-header-id="<?= $row['header_id'] ?>" data-type="delete">Delete</button>
                                      </td>
                                    </tr>
                                  <?php } ?> -->
                                  <tbody>
                                  </tbody>
                              </table>
                          </div>
                          <?php } ?>


                          <?php if(isset($gp) && $gp['type'] == 'laysheet transfer') { ?>
                          <div class="col-lg-12" style="margin-top: 20px">
                            <table id="gp_laysheets" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Laysheet No</th>
                                        <th>Item Code</th>
                                        <th>Cut No</th>
                                        <?php if($gp['status'] == 'NEW') { ?>
                                          <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>

                          <div class="col-md-12" style="text-align: left">
                            <?php if(isset($gp) && $gp['status'] == 'NEW') { ?>
                              <button class="btn btn-success btn-sm" id="btn_approval">Send For Approval</button>
                            <?php } ?>
                          </div>

                          <?php if(isset($gp) && $gp['status'] != 'NEW') { ?>
                          <div class="col-md-12" style="margin-top:20px">
                      			<label style="font-size:13px;">Authorization</label>
                      			<table class="table table-striped table-bordered table-hover" style="width:100%">
                                <tr>
                                  <th style="width:20%">Level</th>
                                  <th style="width:40%">Approved By</th>
                                  <th style="width:20%">Status</th>
                                  <th style="width:20%">Date & Time</th>
                                </tr>
                      				<?php foreach ($approval_data as $row) {
                                  $status = '';
                        					if($row['status'] == 'APPROVE'){
                        						$status = 'APPROVED';
                        					}
                        					else if($row['status'] == 'REJECT'){
                        						$status = 'REJECTED';
                        					}
                        					else {
                        						$status = $row['status'];
                        					}
                                ?>
                      					<tr>
                      						<td>Level <?= $row['level'] ?></td>
                      						<td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                      						<td><?= $status ?></td>
                      						<td><?= $row['end_date'] ?></td>
                      					</tr>
                      				<?php } ?>
                      			</table>
                      		</div>
                          <?php } ?>

                        </div>

						            <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="item_model" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="gp-new-item-title">  </h4>
      </div>
      <div class="modal-body">

          <div id="gp-items-form">

              <input type="hidden" value="-1" id="gp-item-arr-index">

              <input type="hidden" value="0" id="item_id">

              <div class="form-group">
                  <label>Details</label>
                  <input type="text" class="form-control" id="item_details">
              </div>
              <div class="form-group">
                  <label>Unit</label>
                  <input type="text" class="form-control" id="item_unit">
              </div>
              <div class="form-group">
                  <label>Qty</label>
                  <input type="number" class="form-control" id="item_qty">
              </div>
          </div>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn_item_add">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="ls_model" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="ls_model_title">Add Laysheet</h4>
      </div>
      <div class="modal-body">
          <div id="gp-laysheet-form">
              <!-- <input type="hidden" value="-1" id="gp-item-arr-index"> -->
              <!-- <input type="hidden" value="0" id="item_id"> -->
              <div class="form-group">
                  <label>Lasyheet No</label>
                  <input type="text" class="form-control" id="laysheet_no">
              </div>
          </div>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn_ls_add">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script src="<?php echo base_url(); ?>assets/views/gatepass/manual_gatepass.js"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>

    <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
    <!-- jquery form validator plugin -->
    <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>



  </body>
</html>
