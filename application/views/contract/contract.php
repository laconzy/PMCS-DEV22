<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Supplier Contract</title>
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
      <input type="hidden" value="<?= isset($contract_no) ? $contract_no : 0 ?>" id="contract_no">

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
                            <span>New Cotract</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    Supplier Contract - <span id="title_contract_no"><?= isset($contract_no) ? $contract_no : ''?></span>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/contract" target="_self">New Contract</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/contract/listing">Contract List</a></li>
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

                          <div class="row">
                            <div class="col-md-2">
                                <label>Order</label>
                                <input type="text" class="form-control input-sm" placeholder="Enter order id"
								                    id="order_id" >
                            </div>
                            <div class="col-md-1">
                              <buttion class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_search">Search</button>
                            </div>
                            <div class="col-md-3">
                                <label>External Operation</label>
                                <select class="form-control input-sm" id="external_operation">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Style</label>
                                <input type="text" class="form-control input-sm" id="style" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Customer PO</label>
                                <input type="text" class="form-control input-sm" id="customer_po" disabled>
                            </div>
                          </div>

                          <div class="row" style="margin-top:15px">
                            <div class="col-md-3">
                                <label>Supplier PO</label>
                                <input type="text" class="form-control input-sm" id="supplier_po">
                            </div>
                            <div class="col-md-3">
                                <label>Supplier PO Price</label>
                                <input type="number" class="form-control input-sm" id="supplier_po_price">
                            </div>
                            <div class="col-md-3">
                                <label>Currency</label>
                                <input type="text" class="form-control input-sm" id="currency">
                            </div>
                            <div class="col-md-3">
                                <label>Supplier</label>
                                <select class="form-control input-sm" id="supplier">
                                  <option value="">... Select Supplier ...</option>
                                  <?php foreach ($suppliers as $sup) { ?>
                                      <option value="<?= $sup['supplier_id'] ?>"><?= $sup['supplier_name'] ?></option>
                                  <?php } ?>
                                </select>
                            </div>
                          </div>

                          <div class="row" style="margin-top:15px">
                            <div class="col-md-3">
                                <label>Item Component</label>
                                <select class="form-control input-sm" id="item_component">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Embellishment Type</label>
                                <select class="form-control input-sm" id="emb_type">
                                  <option value="">... Select Embellishment Type ...</option>
                                  <?php foreach ($emb_types as $emb) { ?>
                                      <option value="<?= $emb['emb_id'] ?>"><?= $emb['emb_name'] ?></option>
                                  <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Delivery Date</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <div class="input-group input-daterange">
                                    <input type="text" class="form-control input-sm date" value="" id="delivery_date" >
                                  </div>
                                </div>
                            </div>
                          </div>


                        <hr>

                        <div class="row">
                          <div class="col-md-12" >
                            <h4>Order Details</h4>
                            <table id="order_details_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Item</th>
                                  <th>Color</th>
                                  <th>Size</th>
                                  <th>Planned Qty</th>
                                  <th width="15%">Contract Qty</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                        </div>

            						<div class="row">
            							<div class="col-md-12">
            								<button class="btn btn-primary" id="btn_save">Save Contract Details <i id="btn-save-i"></i></button>
                            <button class="btn btn-info" id="btn_print">Print Contract <i id="btn-save-i"></i></button>
            							</div>
            						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('common/footer'); ?>


</div>



<?php $this->load->view('common/script'); ?>

<!--<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/spin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/ladda.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/ladda/dist/ladda.jquery.min.js"></script>-->

<script src="<?php echo base_url(); ?>assets/views/contract/contract.js"></script>
<!-- bootstrap calendar -->
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>-->


    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>



  </body>
</html>
