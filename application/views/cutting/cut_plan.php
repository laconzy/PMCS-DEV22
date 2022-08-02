<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PMCS | Add/Edit Cut Plan</title>
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
        <!-- datatables -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.css">

        <link href="<?php echo base_url(); ?>assets/plugins/jquery_notification/alert/css/alert.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/jquery_notification/alert/themes/default/theme.css" rel="stylesheet" />
		
		<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->


        <!-- main header -->
        <?php $this->load->view('common/header'); ?>

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <?php $this->load->view('common/left_menu'); ?>

        <!-- =============================================== -->
        <input type="hidden" value="<?php echo $id; ?>" id="user-id">

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
                                    <span>Administration</span>
                                </li>
                                <li class="active">
                                    <span>New Cut Plan</span>
                                </li>
                            </ol>
                        </div>
                        <h2 class="font-light m-b-xs text-success">
                            New Cut Plan
                        </h2>

                    </div>
                </div>
            </div>



            <div class="content animate-panel">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hpanel">

                            <div class="panel-body">


                                <div class="col-lg-12" id="form">

                                    <input type="hidden" value="<?php echo $id; ?>" id="user-id">

                                    <div class="col-lg-3">

                                        <div class="form-group">
                                            <label>Order Id</label>
                                            <input type="text" class="form-control" placeholder="" id="cutplan-id" >
                                        </div>

                                        <div class="form-group">
                                            <label>Order Code</label>
                                            <input type="text" class="form-control" id="order-code" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Style</label>
                                            <input type="text" class="form-control" placeholder="Enter last name" id="style" disabled>
                                        </div>

                                    </div>
                                    <div class="col-lg-3">

                                        <div class="form-group">
                                            <label>Color</label>
                                            <input type="text" class="form-control" placeholder="" id="color" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Customer PO</label>
                                            <input type="text" class="form-control" placeholder="Enter Order Code" id="cpo" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Style Desc</label>
                                            <input type="text" class="form-control" placeholder="" id="style-desc" disabled>
                                        </div>

                                    </div>
                                    <div class="col-lg-3">

                                        <div class="form-group">
                                            <label>Customer</label>
                                            <input type="text" class="form-control" placeholder="" id="customer-code" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Sales Qty</label>
                                            <input type="text" class="form-control" placeholder="" id="sales-qty">
                                        </div>
                                        <div class="form-group" style="display:none">
                                            <label>Orig. Ord. Qty</label>
                                            <input type="text" class="form-control" placeholder="" id="oreder-qty">
                                        </div>
                                        <div class="form-group">
                                            <label>Referance</label>
                                            <input type="text" class="form-control" placeholder="" id="nic">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Season</label>
                                            <input type="site" class="form-control" placeholder="" id="season" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Site</label>
                                            <input type="site" class="form-control" placeholder="" id="conf-site" disabled>
                                        </div>



                                    </div>
                                    <div class="col-lg-12">
                                        <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="component">
                                            <thead>
                                                <tr>
                                                    <th>PART NO</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>Coponent</th>
                                                    <th>COLOR</th>
                                                    <th>GROUP</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="col-lg-12">
                                        <?php if ($id == 0 && $USER_ADD == true) { ?>
                                            <button class="btn btn-flat btn-primary" style="margin-right: 30px" id="btn-save">Save Details</button>
                                        <?php } else if ($id > 0 && $USER_EDIT == true) {
                                            ?>
                                            <button class="btn btn-flat btn-primary" style="margin-right: 30px" id="btn-save">Save Details</button>
                                        <?php } ?>
                                    </div>

                                    <div class="col-lg-12" style="margin-top: 20px;display: none" id="image-section">
                                        <div class="row">
                                            <hr>
                                            <div class="col-lg-2">
                                                <img src="" id="user-image" width="150">
                                            </div>
                                            <div class="col-lg-10">
                                                <?php echo form_open_multipart(base_url() . 'index.php/user/upload_image/' . $id); ?>
                                                <input type="file" name="userfile" size="20" />
                                                <br /><br />
                                                <input type="submit" value="upload" />
                                                </form>
                                                <?php echo $error; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="color-line"></div>
                                                    <div class="modal-header">
														<div class="col-lg-9">
                                                        <h4 class="modal-title">Cut Plan</h4>
                                                        <small class="font-bold">Create Cut Plan</small></div>
														<div class="col-lg-3" align='right;' ><select class="form-control input-sm" id="saved_cut_plan_id">
														  <option value="">- EDIT CUT PLAN -</option>
														  
														</select></div>
                                                    </div>
                                                    <div class="modal-body">
												
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label>Cut Plan ID</label>
                                                                    <input type="hidden" class="form-control input-sm" placeholder="" id="mdl-order-id" >
                                                                    <input type="text" class="form-control input-sm" placeholder="" id="mdl-cut-plan-id" disabled>
                                                                    <input type="hidden" class="form-control input-sm" placeholder="" id="item-id" >
                                                                    <input type="hidden" class="form-control input-sm" placeholder="" id="mdl-comp" >
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>No of Layers</label>
                                                                    <input type="number" class="form-control input-sm" placeholder="" id="mdl-lyers" value ="0">
                                                                </div>
                                                            </div>
															
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Style</label>
                                                                        <input type="hidden" class="form-control input-sm" placeholder="" id="mdl-style" >
                                                                        <input type="text" class="form-control input-sm" placeholder="" id="mdl-style2" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Length (Yds)</label>
                                                                        <input type="" class="form-control input-sm" placeholder="" id="mdl-yds" >
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Color</label>
                                                                    <input type="hidden" class="form-control input-sm" placeholder="" id="mdl-color" >
                                                                    <input type="text" class="form-control input-sm" placeholder="" id="mdl-color2" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Marker Ref</label>
                                                                    <input type="text" class="form-control input-sm" placeholder="" id="mdl-mkrRef" >
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label>Customer PO</label>
                                                                    <input type="text" class="form-control input-sm" placeholder="" id="mdl-cpo" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Width (Inch)</label>
                                                                    <input type="number" class="form-control input-sm" placeholder="" id="mdl-width" >
                                                                </div>
                                                                <!-- <div class="form-group">
                                                                    <label>Status</label>
                                                                   <select>
                                                                       <option value="0">Select Status</option>
                                                                       <option value="cut">Cut</option>
                                                                       <option value="recut">Recut</option>
                                                                   </select>
                                                                </div> -->

                                                            </div>
                                                            <div class="col-lg-2">
                                                                <!-- <div class="form-group">
                                                                    <label>Customer PO</label>
                                                                    <input type="text" class="form-control input-sm" placeholder="" id="mdl-cpo" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Width (Inch)</label>
                                                                    <input type="number" class="form-control input-sm" placeholder="" id="mdl-width" >
                                                                </div> -->
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                   <select class="form-control input-sm" id="status">
                                                                       <option value="0">Select Status</option>
                                                                       <option value="CUT">Cut</option>
                                                                       <option value="RECUT">Recut</option>
                                                                   </select>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="size-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Size</th>
                                                                    <th>Ratio</th>
                                                                    <th>Total Plies</th>
                                                                    <th>Plan Order Qty</th>
                                                                    <th>Completed Qty</th>
                                                                    <th>Remaining Qty</th>
                                                                </tr></thead>
                                                            <tbody></tbody>
                                                        </table>
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-3"><div class="form-group text-right"><button type="button" class="btn btn-info" id="mdl-btn-ratio">Add Ratio</button></div></div>

                                                        </div>
                                                        <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="mdl-tbl-ratio">
                                                            <thead>
                                                                <tr>
																	<th style="text-align: center">Cut No</th>
                                                                    <th style="text-align: center">Size</th>
                                                                    <th style="text-align: center">Ratio</th>
                                                                    <th style="text-align: center">Total Plies</th>
                                                                    <th style="text-align: center">Total Qty</th>
                                                                    <th style="text-align: center">Marker Ref.</th>
                                                                    <th style="text-align: center">Width</th>
                                                                    <th style="text-align: center">Length</th>
																	<th style="text-align: center"></th>
                                                                </tr></thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-clear">Clear Data</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <!--<button type="button" class="ladda-button btn btn-primary" id="mdl-btn-save"  data-style="zoom-in">Save changes</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
        <!-- page js file -->
        <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
        <!-- datatables -->
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.js"></script>
        <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
        <!-- jquery form validator plugin -->
        <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>

        <script src="<?php echo base_url(); ?>assets/plugins/jquery_notification/alert/js/alert.js"></script>
        <script src="<?php echo base_url(); ?>assets/application/app-2.js"></script>
        <script src="<?php echo base_url(); ?>assets/views/cutting/cut_plan.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>
        <script>
            var BASE_URL = '<?php echo base_url(); ?>';
        </script>



    </body>
</html>
