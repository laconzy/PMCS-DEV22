<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PMCS | Add/Edit Style</title>

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

                            <span>New Style</span>

                        </li>

                    </ol>

                </div>

                <h2 class="font-light m-b-xs text-success">

                    <?= isset($site) ? 'Update Style' : 'New Style'; ?>

                </h2>

                <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>

                    <ul class="dropdown-menu">

                        <li><a href="<?php echo base_url(); ?>index.php/master/style/style_new" target="_self">New Style</a></li>

                        <li class="divider"></li>

                        <li><a href="<?php echo base_url(); ?>index.php/master/style">Style List</a></li>

                    </ul>

                </div>

            </div>

        </div>

        </div>







    <div class="content animate-panel">
        <div class="row">
          <div class="hpanel">
              <div class="panel-body" id="data-form">
  	            <input type="hidden" value="<?= isset($style) ? $style['style_id'] : 0;?>" id="style-id">

                <div class="col-md-6">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Style Code</label>
                              <input type="text" class="form-control input-sm" placeholder="Enter style Code"
    					                    id="style-code" value="<?= isset($style) ? $style['style_code'] : ''; ?>">
                          </div>
    			                <div class="form-group">
                              <label>Style Name</label>
                              <input type="text" class="form-control input-sm" placeholder="Enter style Name"
                                  id="style-name" value="<?= isset($style) ? $style['style_name'] : '';?>">
                          </div>

                          <div class="form-group">
                            <label>Style Category</label>
                             <select type="text" class="form-control input-sm" id="style_cat">
                               <option value="0">... Select Category  ...</option>
                               <?php foreach ($style_cat as $row) { ?>
                                 <option value="<?= $row['id'] ?>"
                                  <?php if(isset($style) && $row['id']==$style['style_cat']){ echo "selected"; } ?> ><?= $row['category'] ?>
                                  </option>
                               <?php } ?>
                             </select>
                          </div>

                          <div class="form-group">
                            <label>Item</label>
                             <select type="text" class="form-control input-sm" id="item_id">
                               <option value="">... Select Item  ...</option>
                               <?php foreach ($items as $row) { ?>
                                 <option value="<?= $row['item_id'] ?>"
                                  <?php if(isset($style) && $row['item_id']==$style['item_id']){ echo "selected"; } ?>><?= $row['item_code'] ?>
                                  </option>
                               <?php } ?>
                             </select>
                          </div>

                          <div class="form-group">
                              <label>Active</label> <br>
                              <?php $checked = (isset($style) && $style['active'] == 'Y') ? 'checked' : ''; ?>
                              <input type="checkbox" id="style-active" <?= $checked; ?>>
                          </div>
                      </div>
                  </div>
                  <hr>

                  <div class="row">
      							<div class="col-md-2">
      								<button class="btn btn-primary" id="btn-save">
      								Save Style Details <i id="btn-save-i"></i></button>
      							</div>
      						</div>

                </div>


                <div class="col-md-6" style="<?= isset($style) ? '' : 'display:none' ?>">
                  <div class="row" style="margin-top:20px">
                    <div class="col-md-12 form-group">
                      <label class="control-label">Operation</label>
                      <select type="text" class="form-control input-sm" id="operation">
                        <?php foreach ($operations as $operation) { ?>
                          <option value="<?= $operation['operation_id'] ?>"><?= $operation['operation_name'] ?></option>
                        <?php } ?>
                        <select>
                    </div>
                    <div class="col-md-12 form-group">
                      <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_add_operation">Add Operation</button>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <table id="operation_table" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                          <tr>
                            <th>Operation</th>
                            <th>Order</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if(isset($style)) {
                          foreach ($saved_operations as $row) { ?>
                            <tr>
                      			<td><?= $row['operation_name'] ?></td>
                      			<td><?= $row['operation_order'] ?></td>
                      			<td> <button class="btn btn-danger btn-xs" data-id="<?= $row['operation_id'] ?>" data-seq="<?= $row['operation_order'] ?>">Delete</button> </td>
                      			</tr>
                          <?php } } ?>
                        </tbody>
                      </table>
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

    <script src="<?php echo base_url(); ?>assets/views/master/style/style.js?v1.1"></script>

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
