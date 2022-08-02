<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PMCS | Rejection</title>

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

              <span>Bundle Rejection</span>

            </li>

          </ol>

        </div>

        <h2 class="font-light m-b-xs text-success">

          Bundle Rejection

        </h2>

                <!--<div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>

                    <ul class="dropdown-menu">

                        <li><a href="<?php echo base_url(); ?>index.php/master/site/site_new" target="_self">New Colour</a></li>

                        <li class="divider"></li>

                        <li><a href="<?php echo base_url(); ?>index.php/master/colour">Colour List</a></li>

                    </ul>

                  </div>-->

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

                        <div class="col-md-2">

                          <label>Line No</label>

                          <select class="form-control input-sm" id="line_no">

                            <option value="">... Select Line ...</option>

                            <?php foreach ($lines as $row) { ?>

                              <option value="<?= $row['line_id'] ?>"><?= $row['line_code'] ?></option>

                            <?php } ?>

                          </select>

                        </div>
                        <div class="col-md-2">


                          <label>Shift</label>

                          <select type="text" class="form-control input-sm" id="shift">
                            <option value="0">-Select Shift-</option>
                            <option value="A">A</option>
                            <option value="B">B</option>

                          </select>

                        </div>

                        <div class="col-md-2">


                          <label>Date</label>

                          <input type="text" class="form-control input-sm date" value="<?= date('Y-m-d'); ?>" id="scan_date" >

                        </div>
                        <div class="col-md-2">


                          <label>Hour</label>

                          <select type="text" class="form-control input-sm" id="hour">
                            <option value="1">1</option>
                            <option value="1">2</option>
                            <option value="1">3</option>
                            <option value="1">4</option>
                            <option value="1">5</option>
                            <option value="1">6</option>
                            <option value="1">7</option>
                            <option value="1">8</option>
                            <option value="1">9</option>
                            <option value="1">10</option>

                          </select>

                        </div>
                        <div class="col-md-2">

                          <label>Order Id</label>

                          <input type="text" class="form-control input-sm" placeholder="Enter order id"  id="order_id" >

                        </div>


                      </div>

                      <div class="row form-group">


                        <div class="col-md-6">

                         <!--  <button class="btn btn-primary btn-block" style="margin-top:20px" id=""  data-target="#myModal6">Pass</button> -->
                         <button type="button" class="btn btn-warning  btn-block form-control" data-toggle="modal" data-target="#myModal1" id="btn_pass">
                          Deffect
                        </button>
                      </div>
                      <div class="col-md-6">
                       <button type="button" class="btn  btn-block btn-danger form-control" data-toggle="modal" data-target="#myModal2" id="reject">
                        Reject
                      </button>
                      <!-- <button class="btn btn-block btn w-xs btn-danger" style="margin-top:20px" id="btn_find">Reject</button> -->

                    </div>

                  </div>



                  <div class="col-md-6">
                    <div class="hpanel fbyellow">
                      <div class="panel-body">
                        <div class="text-center">
                          <h3>Defects</h3>
                          <p class="text-big font-light" id="qty_pass">
                            0
                          </p>
                          <small>

                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6" target="#myModal3" id="delete_reject">
                    <div class="hpanel hbgred">
                      <div class="panel-body">
                        <div class="text-center">
                          <h3>FAIL</h3>
                          <p class="text-big font-light" id="qty_rej">
                            0
                          </p>
                          <small>

                          </small>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>



                <div class="row form-group">

                       <!--  <div class="col-md-3">

                          <label>Barcode</label>

                          <input type="text" class="form-control input-sm" placeholder="Enter barcode" id="barcode">

                        </div>

                        <div class="col-md-3">

                          <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_find">Find</button>

                        </div>
                         <div class="col-md-3">

                          <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_find">Find</button>

                        </div> -->

                      </div>



                      <hr>



                     <!--  <div class="row form-group">

                        <div class="col-md-12">

                          <table id="barcode_details" class="table table-striped table-bordered table-hover" width="100%">

                            <thead>

                              <tr>

                                <th>Item</th>

                                <th>Bundle No</th>

                                <th>Barcode</th>

                                <th>Size</th>

                                <th>Bundle Qty</th>

                                <th>Reject Qty</th>

                              </tr>

                            </thead>

                            <tbody>

                              <td id="barcode_item"></td>

                              <td id="barcode_bundle"></td>

                              <td id="barcode_no"></td>

                              <td id="barcode_size"></td>

                              <td id="barcode_qty"></td>

                              <td><input type="number" class="form-control input-sm" id="rejection_qty" ></td>

                            </tbody>

                          </table>

                        </div>

                        <div class="col-md-12">

                          <button class="btn btn-primary btn-sm" id="btn_save">Save Rejection</button>

                        </div>

                      </div>



                      <hr>



                      <div class="row">

                        <div class="col-md-12" >

                          <h4>Rejected Bundles</h4>

                          <table id="rejected_table" class="table table-striped table-bordered table-hover" width="100%">

                            <thead>

                              <tr>

                                <th><input type="checkbox" id="select_all"></th>

                                <th>Item</th>

                                <th>Bundle No</th>

                                <th>Barcode</th>

                                <th>Size</th>

                                <th>Bundle Qty</th>

                                <th>Reject Qty</th>

                              </tr>

                            </thead>

                            <tbody>



                            </tbody>

                          </table>

                        </div>

                      </div>
                    -->


                    <div class="row">

                     <div class="col-md-2">

                    <!--   <button class="btn btn-danger" id="btn_remove">Delete Selected Bundles <i id="btn-save-i"></i></button> -->

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="color-line"></div>
              <div class="modal-header">
                <h4 class="modal-title" style="color: blue">Quality Pass</h4>
                <small class="font-bold" id="pass_order" style="color: blue;font-weight: bold;font-size: 18px;"></small>
              </div>
              <div class="modal-body">
                <div class="col-md-3">

                    <label>SIZE</label>

                    <select type="text" class="form-control input-sm" id="size">

                      <option value="">... Select Size ...</option>

                    </select>

                  </div>
                  <div class="col-md-3">

                    <label>QTY</label>

       <input type="number" id="qty" name="qty" class="form-control input-sm" value="1">


                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_data">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
              <h4 class="modal-title" style="color: red;">Reject</h4>
              <small class="font-bold" id="fail_order" style="color: red;font-weight: bold;font-size: 18px;"></small>
            </div>
            <div class="modal-body">
              <div class="col-md-3">

                    <label>Rejection Type</label>

                    <select type="text" class="form-control input-sm" id="rejection_type">

                      <option value="0">... Select Rejection Type ...</option>

                      <?php foreach ($rejection_types as $row) { ?>

                        <option value="<?= $row['id'] ?>"><?= $row['rejection_name'] ?></option>

                      <?php } ?>

                    </select>

                  </div>
                  <div class="col-md-3">

                    <label>SIZE</label>

                    <select type="text" class="form-control input-sm" id="size_r">

                      <option value="">... Select Size ...</option>

                    </select>

                  </div>

                  <div class="col-md-3">

                    <label>QTY</label>

       <input type="number" id="qty_reject" name="qty" class="form-control input-sm" value="1">

                  </div>
            </div>
            <div class="modal-footer">

              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn_reject">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>

          <!-- <?php //$this->load->//view('common/footer'); ?>
        -->


 <div class="modal fade" id="myModal3" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
              <h4 class="modal-title" style="color: red;">Reject</h4>
              <small class="font-bold" id="fail_order" style="color: red;font-weight: bold;font-size: 18px;"></small>
            </div>
            <div class="modal-body">
              <div class="col-md-12" style="overflow: scroll;">

                    <table class="table table-bordered" id="rejection_list">
                      <thead>
                        <tr>

                          <th>ID</th>
                          <th>Order</th>
                          <th>Order Code</th>
                          <th>Size</th>
                          <th>QTY</th>
                          <th>Action</th>
                            </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

           <!--    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn_reject">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>


      </div>







      <!-- jQuery 2.1.4 -->

      <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

      <!-- Bootstrap 3.3.5 -->

      <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

      <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

      <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

      <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>



      <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

      <!-- page js file -->

      <script src="<?php echo base_url(); ?>assets/views/production/rejection.js"></script>

      <script src="<?php echo base_url(); ?>assets/application/app.js"></script>



      <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

      <!-- jquery form validator plugin -->

      <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>



      <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>









    </body>

    </html>
