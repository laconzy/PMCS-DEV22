<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--		<title>PMCS | --><?//= $operation_name ?><!--</title>-->
    <title>PMCS | Inventory</title>
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
                                <span>Roll Issue</span>
                            </li>
                        </ol>
                    </div>

                    <h2 class="font-light m-b-xs text-success">
                       <span>Roll Issue</span>
                   </h2>
                   <div class="btn-group">
                       <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                       <ul class="dropdown-menu">
                           <li><a href="<?php echo base_url(); ?>index.php/inventory/inventory">New Packing List</a></li>
                           <li class="divider"></li>
                           <li><a href="<?php echo base_url(); ?>index.php/inventory/inventory/inventory_list">Packing Lists</a></li>
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

                              <?php
                                $confirmed = false;
                                if(isset($packing_id) && $header_data['stat'] == 'confirmed') {
                                  $confirmed = true;
                                }
                              ?>

                                <input type="hidden" value="<?= isset($packing_id) ? $packing_id : ''; ?>" id="packing_id">
                                <input type="hidden" value="<?= isset($packing_id) ? 'SANMAR' : 0; ?>" id="h_customer">
                                <input type="hidden" value="<?= isset($packing_id) ? 'ACCRA' : 0; ?>" id="h_location">
                                <input type="hidden" value="<?= isset($packing_id) ? '1' : 0; ?>" id="h_issue_location">
                                <input type="hidden" id="operation" value="">
                                <input type="hidden" id="previous_operation" value="">
                                <input type="hidden" id="confirmed" value="<?= ($confirmed == true) ? 'YES' : 'NO' ?>">



                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label>ID</label>
                                        <input type="text" class="form-control input-sm" id="pack" value="<?= isset($packing_id) ? $packing_id : '' ?>" disabled>
                                    </div>

                                    <div class="col-md-2">
                                        <label >Date</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <div class="input-group input-daterange">
                                                <input type="text" class="form-control input-sm date" value="<?= isset($packing_id) ? $header_data['date'] : date('Y-m-d'); ?>" id="scan_date" <?= isset($packing_id) ? 'disabled' : '' ?> >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Laysheet No</label>
                                        <input type="text" class="form-control input-sm" id="laysheet" value="<?= isset($packing_id) ? $header_data['laysheet_no'] : ''; ?>" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer</label>
                                        <select class="form-control input-sm" id="customer" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                            <option value="">... Select Customer ...</option>
                                            <?php foreach ($buyer_codes as $row) { ?>
                                              <option value="<?= $row['buyer_code'] ?>"><?= $row['buyer_code'] ?></option>
                                            <?php } ?>
                                            <!-- <option value="SANMAR">SANMAR</option>
                                            <option value="TCP">TCP</option>
                                            <option value="REDBULL">REDBULL</option>
                                            <option value="UNERARMOR">UNERARMOR</option> -->
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Style</label>
                                        <input type="text" class="form-control input-sm" id="style" value="<?= isset($packing_id) ? $header_data['style_no'] : ''; ?>" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                    </div>
                                    <!-- <div class="col-md-3">
                                       <label>Location</label>
                                       <select id="site" class="form-control input-sm" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                        <option value="">... Select Line ...</option>
                                        <?php foreach ($store as $row) { ?>
                                            <option value="<?= $row['main_location_name'] ?>"><?= $row['main_location_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> -->
                            </div>


                            <div class="row form-group">
                              <!-- <div class="col-md-3">
                                 <label>Issue Location</label>
                                 <select id="location" class="form-control input-sm" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                  <option value="">... Select location ...</option>
                                  <option value="1">Dignity DTRT</option>
                                  </select>
                              </div> -->

                              <!-- <div class="col-md-3">
                                  <label>Buyer PO</label>
                                  <input type="text" class="form-control input-sm" id="buyer_po" value="<?= isset($packing_id) ? $header_data['buyer_po'] : ''; ?>" <?= isset($packing_id) ? 'disabled' : '' ?>>
                              </div> -->
                              <div class="col-md-4">
                                  <label>Order Code</label>
                                  <input type="hidden" id="order_code_hidden" value="<?= isset($packing_id) ? $header_data['order_code'] : ''; ?>">
                                  <select class="form-control input-sm"  id="order_code" <?= isset($packing_id) ? 'disabled' : '' ?>>
                                  </select>
                              </div>

                              <div class="col-md-6">
                                  <label>Remarks</label>
                                  <input type="text" class="form-control input-sm" id="remarks" value="<?= isset($packing_id) ? $header_data['remarks'] : ''; ?>" <?= isset($packing_id) ? 'disabled' : '' ?>>
                              </div>

                              <?php if(isset($packing_id) == false) { ?>
                                <div class="col-md-2">
                                      <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_create">Create Packing List</button>
                                </div>
                              <?php } ?>
                            </div>

                            <div class="row form-group" id="div_barcode" style="<?= isset($packing_id) ? '' : 'display:none' ?>">

                                <?php if($confirmed == false) { ?>
                                <div class="col-md-5">
                                    <label>Barcode</label>
                                    <input type="text" class="form-control input-sm" placeholder="Enter barcode"  id="barcode">
                                </div>
                                <?php } ?>

                                <?php if($confirmed == false) { ?>
                                <div class="col-md-1">
                                    <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_add">Add</button>
                                </div>
                                <?php } ?>

                                <?php if(isset($packing_id)){ ?>
                                  <div  class="col-md-1">
                                    <a class="btn btn-primary btn-sm" style="margin-top:20px" href="<?= base_url() ?>index.php/inventory/inventory/inventory_print/<?= $packing_id ?>" target="_blank">Print</a>
                                  </div>

                                  <div  class="col-md-1">
                                    <a class="btn btn-primary btn-sm" style="margin-top:20px" href="<?= base_url() ?>index.php/inventory/inventory/packinglist_print/<?= $packing_id ?>" target="_blank">Print Label</a>
                                  </div>


                                  <?php if($confirmed == false) { ?>
                                  <div  class="col-md-1">
                                    <button class="btn btn-info btn-sm" style="margin-top:20px" id="btn_confirm">Confirm</button>
                                  </div>
                                  <?php } ?>

                                  <?php if($confirmed == true && $UNCONFIRM_PERMISSION == 'Y') { ?>
                                  <div  class="col-md-1">
                                    <button class="btn btn-info btn-sm" style="margin-top:20px" id="btn_unconfirm">Revoke</button>
                                  </div>
                                  <?php } ?>

                                <?php } ?>
                          </div>



                        <hr>



                        <div class="row">
                            <div class="col-md-12" >
                                <h4>Scanned Rolls</h4>
                                <table id="added_item_table" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10px"><input type="checkbox" id="select_all"/></th>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th>Batch No</th>
                                            <th>Roll No</th>
                                            <th>Barcode</th>
                                            <th>Qty</th>
                                            <th>Bin Location</th>
                                            <?php if($confirmed == false) { ?>
                                            <th width="5%">Actions</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php if(isset($packing_id)){
                                        foreach ($roles as $row) { ?>
                                        <tr>
                                        <td><input type="checkbox" data-details-id="<?= $row['pack_details_id'] ?>" /></td>
                                        <td><?= $row['item_no'] ?></td>
                                        <td><?= $row['description'] ?></td>
                                        <td><?= $row['batch_no'] ?></td>
                                        <td><?= $row['roll_no'] ?></td>
                                        <td><?= $row['item_code'] ?></td>
                                        <td><?= $row['actual'] ?></td>
                                        <td><?= $row['bin_location'] ?></td>
                                        <?php if($confirmed == false) { ?>
                                          <td><button data-details-id="<?= $row['pack_details_id'] ?>" class="btn btn-danger btn-xs">Delete</button></td>
                                        <?php } ?>
                                        </tr>
                                      <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row" id="div_btn_delete" <?= (isset($packing_id) && sizeof($roles) > 0) ? '' : 'style="display:none"' ?>>
                          <?php if($confirmed == false) { ?>
                            <div class="col-md-2">
                                <button class="btn btn-danger" id="btn_remove">Delete Selected Bundles <i id="btn-save-i"></i></button>
                            </div>
                          <?php } ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="model1" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="color-line"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Item Details</h4>
                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text.</small> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                         <table id="table_data" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Value</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                    </div>
                 <!-- <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="barcode">
                 </div></div>
                 <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="desc">
                 </div></div>

 <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="dye_lot">
                 </div></div>

                  <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="shade">
                 </div></div>

                  <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="desc">
                 </div></div>

                 <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="qty_rec">
                 </div></div>
                 <div class="row">
                    <div class="col-md-2">
                     <input type="text" name="" id="qty_ac">
                 </div></div> -->
             </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn_add_roll">Add Roll</button>
        </div>
    </div>
</div>
</div>






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
<script src="<?php echo base_url(); ?>assets/views/inventory/inventory.js?v1.4"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>



<script>

    var BASE_URL = '<?php echo base_url(); ?>';

</script>







</body>

</html>
