<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Orders</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
    <!-- datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.css">
    <link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />



  </head>
  <body class="hold-transition skin-blue sidebar-mini light-shadow">


      <!-- main header -->
      <?php $this->load->view('common/header'); ?>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <?php $this->load->view('common/left_menu'); ?>

      <!-- =============================================== -->
         <!--<input type="hidden" id="user-view" value="<?php echo $USER_VIEW ?>">
          <input type="hidden" id="user-del" value="<?php echo $USER_DEL ?>"> -->

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
                            <span>Orders</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    Orders

                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url() . 'index.php/order/order' ?>" target="_blank">New Order</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Reload Table</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </div>



    <div class="content animate-panel">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">

                <div class="panel-body">
					<div class="row" style="margin-bottom:15px">
            <div class="col-md-3">
							<select type="text" class="form-control input-sm" id="filter-complete">
                <option value="">... Select Complete Status ...</option>
                <option value="1">Complete</option>
                <option value="0">Not Complete</option>
              </select>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="search-text" placeholder="Enter your keyword">
						</div>
						<div class="col-md-1">
							<button class="btn btn-primary btn-flat btn-sm" id="btn-search">Search</button>
						</div>
            <div class="col-md-3">
							<button class="btn btn-success btn-flat btn-sm" id="btn-export">Export To Excel</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table id="sites-table" class="display nowrap cell-border compact" cellspacing="0" width="100%">
								<thead style="background-color:#e8e2e2">
								<tr>
									<th>ID</th>
									<th>Order Code</th>
									<th>Style</th>
                  <th>Color</th>
                  <th>Customer PO</th>
                  <th>UOM</th>
                  <th>Country</th>
                  <th>Ship Method</th>
                  <th>Delivery Date</th>
                  <th>Season</th>
                  <th>Status</th>
                  <th>Complete</th>
									<th></th>
									<?php
									  /*  if($USER_VIEW == true)
											echo '<th>Edit</th>';
										if($USER_DEL == true)
											echo '<th>Delete</th>';*/
									?>
								</tr>
								</thead>
								<tfoot>

								</tfoot>
							</table>
						</div>
					</div>



          <table id="hidden_table" style="display:none">
            <thead>
            <tr>
              <th>ID</th>
              <th>Order Code</th>
              <th>Style</th>
              <th>Color</th>
              <th>Customer PO</th>
              <th>UOM</th>
              <th>Country</th>
              <th>Ship Method</th>
              <th>Delivery Date</th>
              <th>Season</th>
              <th>Status</th>
              <th>Complete</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('common/footer'); ?>





    </div><!-- ./wrapper -->

 <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
    <!-- page js file -->
    <script src="<?php echo base_url(); ?>assets/views/order/order_list.js?v1.1"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
    <!-- datatables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.js"></script>
    <!-- <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script> -->

  <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>





  </body>
</html>