<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PMCS | Summery Reports</title>

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

                            <span>Reports</span>

                        </li>

                        <li class="active">

                            <span>Summery Reports</span>

                        </li>

                    </ol>

                </div>

                <h2 class="font-light m-b-xs text-success">

                  Summery Reports

                </h2>



            </div>

        </div>

        </div>







    <div class="content animate-panel">

        <div class="row">

            <div class="col-lg-12">

                <div class="hpanel">

                    <div class="panel-body" id="data-form">



                      <div class="dd" id="nestable2">

                    <ol class="dd-list">

                        <li class="dd-item" data-id="1">

                            <div class="dd-handle">

                                <span class="label h-bg-navy-blue"><i class="fa fa-users"></i></span>

                                <a href="<?= base_url() ?>index.php/report/order_status_report_view" target="_blank">ORDER STATUS REPORT</a>

                            </div>

                        </li>
						<li class="dd-item" data-id="1">
							<div class="dd-handle">
								<span class="label h-bg-navy-blue"><i class="fa fa-users"></i></span>
								<a href="<?= base_url() ?>index.php/report/order_status_report_size_wise" target="_blank">ORDER STATUS REPORT(Size Wise)</a>
							</div>
						</li>
            <li class="dd-item" data-id="1">
							<div class="dd-handle">
								<span class="label h-bg-navy-blue"><i class="fa fa-users"></i></span>
								<a href="<?= base_url() ?>index.php/report/order_status_report_line_wise" target="_blank">ORDER STATUS REPORT(Line Wise)</a>
							</div>
						</li>

                        <li class="dd-item" data-id="2">

                            <div class="dd-handle">

                                <span class="pull-right"> </span>

                                <span class="label h-bg-navy-blue"><i class="fa fa-cog"></i></span><a href="<?= base_url() ?>index.php/report/wip_report" target="_blank"> WIP REPORT</a>

                            </div>

                        </li>

                        <li class="dd-item" data-id="4">

                            <div class="dd-handle">

                                <span class="label h-bg-navy-blue"><i class="fa fa-laptop"></i></span> <a href="<?php echo base_url(); ?>index.php/report/production_reports" target="_blank"> PRODUCTION SUMMERY REPORT</a>

                            </div>

                        </li>

                        <li class="dd-item" data-id="4">

                            <div class="dd-handle">

                                <span class="label h-bg-navy-blue"><i class="fa fa-laptop"></i></span> <a href="<?php echo base_url(); ?>index.php/report/efficeincy/" target="_blank"> Efficiency Report</a>

                            </div>

                        </li>

                    </ol>

                </div>





                    </div>

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
