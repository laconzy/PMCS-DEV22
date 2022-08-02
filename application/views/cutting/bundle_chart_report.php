<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PMCS | Bundle Chart Report</title>
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



  <section class="invoice" style="padding-right:20px;padding-left:20px">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> Bundle Chart Report | Order ID :  <?= $laysheet['order_id'] ?>
                <small class="pull-right">Date: <?= date("Y/m/d") ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row" style="font-size:13px">
            <div class="col-sm-3 invoice-col">
	
              <b>Laysheet No : </b> <?= $laysheet['laysheet_no'] ?><br>
              <b>Number Of Layers : </b> <?= $laysheet['lay_qty'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
		
              <b>Cut No : </b> <?= $laysheet['cut_no'] ?><br>
              <b>Item Code : </b> <?= $cut_plan['item_name'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
		
              <b>Cut Plan Serial : </b> <?= $cut_plan['cut_plan_id'] ?> <br>
              <b>Colour : </b> <?= $cut_plan['color_code'] ?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <!--<b>Factory : </b> <?= $cut_plan['site_name'] ?> --><br>
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
		  
		   <!-- Table row -->
          <div class="row" style="margin-top:15px">
            <div class="col-xs-6 table-responsive">
              <table class="table table-bordered" style="font-size:12px">
                <thead >
                  <tr>
                    <th>SIZE</th>
					<?php foreach($cut_details as $row) { ?>
                    <th><?= $row['size_code'] ?></td>
                      
                    </th>
                  <?php } ?>
                    
                  </tr>
                </thead>
                <tbody>
				<tr>
				<td>Ratio</td>
				<?php foreach($cut_details as $row2) { ?>
                    
                      
                      <td><?= $row2['ratio'] ?></td>
                      
                    
                  <?php } ?>
                </tr>  
				
				<tr>
				<td><strong>Qty</strong></td>
				<?php foreach($cut_details as $row3) { ?>
                    
                      
                      <td><strong><?= $row3['qty'] ?></strong></td>
                      
                    
                  <?php } ?>
                </tr>  
				
				
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
		  </br>

          <!-- Table row -->
          <div class="row" style="margin-top:15px">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped" style="font-size:12px">
                <thead>
                  <tr>
                    <th>Bundle No</th>
                    <th>Barcode</th>
                    <th>Size</th>
                    <th>Plies Count</th>
                    <th>Qty</th>
                  </tr>
                </thead>
                <tbody>
				
                  <?php 
				  $a=0;
				  foreach($bundle_chart as $row) { 
				  $a += $row['plies_count'];?>
                    <tr>
                      <td><?= $row['bundle_no'] ?></td>
                      <td><?= $row['barcode'] ?></td>
                      <td><?= $row['size_code'] ?></td>
                      <td><?= $a ?></td>
                      <td><?= $row['qty'] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->




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
