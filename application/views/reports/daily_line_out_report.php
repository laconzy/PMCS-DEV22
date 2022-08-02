<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Line Out Reports</title>
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
  <body >
    <!-- Site wrapper -->




      <!-- =============================================== -->
		  <input type="hidden" value="<?php echo base_url(); ?>" id="base-url">

          <div >

            <h4 style="margin-bottom:20px;text-align:center;font-weight:bold">DAILY LINE OUT REPORT</h4>






          <div class="col-md-12" style="margin-bottom:20px">
            <div class="col-md-3">
                <label>Site</label>
                <select class="form-control input-sm" >
                  <option>-- Select Site --</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Order Code </label>
                <select type="text" class="form-control input-sm" >
                  <option>-- Select Customer --</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Customer PO</label>
                <select type="text" class="form-control input-sm" >
                  <option>-- Select Customer PO --</option>
                </select>
            </div>
          </div>
          <div class="col-md-12" style="margin-bottom:20px">
            <div class="col-md-3">
                <label>From Date</label>
                <input  type="text" class="form-control input-sm" value="2018-09-01">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input  type="text" class="form-control input-sm" value="2018-09-02">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" style="margin-top:20px">Search</button>
            </div>
          </div>

         




                          <div class="col-md-12" >

                            <table id="order_table" class="table table-striped table-bordered table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Order Code</th>
                                  <th>Syle</th>
                                  <th>Customer PO</th>
                                  <th>Component</th>
                                  <th>Color</th>
                                  <th>Size</th>
                                  <th>Ord Qty</th>
                                  <th>In Qty</th>
                                  <th>Out Qty</th>
                                  <th>Wip</th>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>41593</td>
                                  <td>RS1443O</td>
                                  <td>A3WU346346</td>
                                  <td>BRIEF</td>
                                  <td>RICH BLACK</td>
                                  <td>S</td>
                                  <td>200</td>
                                  <td>30</td>
                                  <td>30</td>
                                  <td>0</td>
                                </tr>

                                 <tr>
                                  <td>41593</td>
                                  <td>RS1443O</td>
                                  <td>A3WU346346</td>
                                  <td>BRIEF</td>
                                  <td>RICH BLACK</td>
                                  <td>M</td>
                                  <td>200</td>
                                  <td>30</td>
                                  <td>30</td>
                                  <td>0</td>
                                </tr>

                                 <tr>
                                  <td>41593</td>
                                  <td>RS1443O</td>
                                  <td>A3WU346346</td>
                                  <td>BRIEF</td>
                                  <td>RICH BLACK</td>
                                  <td>L</td>
                                  <td>200</td>
                                  <td>60</td>
                                  <td>30</td>
                                  <td>30</td>
                                </tr>

                                 <tr>
                                  <td>41593</td>
                                  <td>RS1443O</td>
                                  <td>A3WU346346</td>
                                  <td>BRIEF</td>
                                  <td>RICH BLACK</td>
                                  <td>XL</td>
                                  <td>200</td>
                                  <td>90</td>
                                  <td>30</td>
                                  <td>60</td>
                                </tr>
                                
                              </tbody>
                            </table>
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
    <script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script>
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
