 	<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PMCS | Plan & Commitments</title>
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
                                    <span>Efficiency</span>
                                </li>
                                <li class="active">
                                    <span>Plan & Commitments</span>
                                </li>
                            </ol>
                        </div>
                        <h2 class="font-light m-b-xs text-success">
                            <?= isset($site) ? 'Plan & Commitments' : 'Plan & Commitments'; ?>
                        </h2>

                    </div>
                </div>
            </div>

            <div class="content animate-panel">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hpanel">
                            <div class="panel-body" id="data-form">
                                <input type="hidden" value="<?= isset($color) ? $color['color_id'] : 0; ?>" id="color-id">
                                <div class="row form-group">
                                    <div class="col-md-2">
                                   <label >Shift</label>
                                    <select id="shift" class="form-control" >
                                        <option value="">--Select Shift--</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label >Date</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <div class="input-group input-daterange">
                                              <input type="text" class="form-control input-sm date" value="<?= date('Y-m-d'); ?>" id="scan_date" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label >Site</label>
                                        <select id="site" class="form-control input-sm" >
                                            <option value="">--Select Site--</option>
                                            <?php
                                            foreach ($sites as $row) {
                                              echo '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label >Line</label>
                                        <select id="line_no" class="form-control input-sm" >
                                            <option value="">--Select Line No--</option>
                                            <?php
                                              //foreach ($lines as $row) {
                                              //echo '<option value="'.$row['line_id'].'">'.$row['line_code'].'</option>';
                                              //} 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                      <!--   <button class="btn btn-primary" style="margin:20px;margin-left:-15px" id="btn_laysheet_search">Search</button> -->
                                    </div>
                                </div>
                                <div class="row form-group">
                                </div>

                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-12" style="overflow: scroll;">
                                        <h4>Data</h4>
                                        <table id="summery_table" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Line</th>
                                                    <th>Plan QTY</th>
                                                    <th>Plan SAH</th>
                                                    <th>Commited QTY</th>
                                                    <th>PCS/HR</th>
                                                    <th>Commited By</th>
                                                    <th>Work Minutes</th>
                                                    <th>O/T</th>
                                                    <th>Direct</th>
                                                    <th>Indirect</th>
                                                    <th>Operator Avail</th>
                                                    <!-- <th>Produced QTY</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" id="btn_save">
                                            Save Data <i id="btn-save-i"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
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
        <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
        <!-- page js file -->
        <script src="<?php echo base_url(); ?>assets/views/production/commitments.js"></script>
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
