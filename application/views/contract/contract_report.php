<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PMCS | Contract</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />  <!-- App styles -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">

</head>

<body>



  <section class="invoice" style="padding-right:20px;padding-left:20px;padding-bottom:50px">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> Contract - Hela Clothing(pvt) Ltd
                <small class="pull-right">Date: <?= date("Y/m/d") ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row" style="font-size:13px">
            <div class="col-sm-3 invoice-col">
              <b>Contract No : </b> <?= $contract['contract_no'] ?><br>
              <b>Operation : </b> <?= $contract['operation_name'] ?><br>
              <b>Delivery Date : </b> <?= $contract['delivery_date'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Supplier PO : </b> <?= $contract['supplier_po'] ?><br>
              <b>Supplier PO Price : </b> <?= $contract['supplier_po_price'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Currency : </b> <?= $contract['currency'] ?><br>
              <b>Supplier : </b> <?= $contract['supplier'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Item Component : </b> <?= $contract['com_code'] ?><br>
              <b>Embellishment Type : </b> <?= $contract['emb_name'] ?><br>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row" style="margin-top:15px">

            <div class="col-md-12">
              <span style="font-weight:bold"><u>Sample /workmanship</u></span> <br>
              Sample to be submitted prior to production, for approval & approved sample must be strictly followed in production
              <br>
              <br>
              <span style="font-weight:bold"><u>Quality Inspection</u></span> <br>
 	              Our quality controllers will inspect production as and when thought necessary by us and they should be allowed To
                inspect production without hindrance. And any samplesasked for should be handed over to our quality controllers.
              <br>
            </br>
            <span style="font-weight:bold"><u>Payment</u></span> <br>
 	          Payment will be made within .30 working days of delivery provided all balance rawmaterials are sent back on that day
            <br>
            <br>
            <span style="font-weight:bold"><u>General</u></span> <br>
1. Any discrepancies of raw materials supplied byHela Clothing must be brought to the notice within 24 hours. The cost of subsequent request for
replacementOf raw materials / damages during production and defiicience to finish garments will be charged to the sub-contractor. <br><br>
2. Any quality issue with regard to raw materials must be brought to notice of Hela Clothing (Pvt) ltd. before commencing production.<br><br>
3. Certificate of inspection signed by representative of Hela Clothing (Pvt) ltd. Or buyer's representative will be required prior to delivery.<br><br>
4. Sub - contractor , shall be responsible for any and all air-freight charges , arising from failure to deliver the finished products on the agreed ex-factory dates stated as above.<br><br>
5. Sub - contractor must make every effort to keep the defect rate below 1 % any excess over & above this will be charged Full F.O.B. price.<br><br>
6. Bundle - you will be getting cut in bundle form. Generally 20 pcs perbundle Also bundle information sheet will be going with daily cut issue to relevent plant.You are requred to follow bundle no.<br><br>
Sequence according to the bundle information sheet.Violating this procedure factory has to face major losses.Therefore following bundle system is a must.<br><br>
7. Any changes in the above terms & conditions will be valid only if agreed in writting by the Sub Contractor and Hela Clothing (Pvt) Ltd.<br><br>
8. Please confirm your acceptance by signing and returning the duplicate of this contract prior tocollection of raw materials.please contact our office for any further clarifications.<br><br>
            </div>




            <div class="col-xs-12 table-responsive">
              <table class="table table-striped" style="font-size:12px">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Contract Qty</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($contract_details as $row) { ?>
                    <tr>
                      <td><?= $row['item_code'] ?></td>
                      <td><?= $row['color_code'] ?></td>
                      <td><?= $row['size_code'] ?></td>
                      <td><?= $row['contract_qty'] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->


          <div class="col-sm-3">
            .............................................<br>
              Subcontract executive
          </div>
          <div class="col-sm-3">
            ..............................................<br>
             Merchandiser
          </div>
          <div class="col-sm-3">
            ..............................................<br>
            Factory Manager
          </div>
          <div class="col-sm-3">
            ..............................................<br>
            Operation Director
          </div>

          <div class="col-md-6" style="margin-top:30px">
            ..............................................<br>
            Subcontractor	<br>
 	 	 	      Signature Of Director / Partner <br>
            Rubber Stamp
          </div>

        </section>





  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>  <!-- Bootstrap 3.3.5 -->
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

  <script>
      var BASE_URL = '<?php echo base_url(); ?>';
  </script>

</body>


</html>
