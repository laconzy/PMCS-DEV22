<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit Permissions</title>
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
  <body >
    <!-- Site wrapper -->


      <!-- main header -->
      <?php $this->load->view('common/header'); ?>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <?php $this->load->view('common/left_menu'); ?>

      <!-- =============================================== -->


      <input type="hidden" id="base_url" value="<?= base_url() ?>">


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
                            <span><?= isset($group) ? 'Update Permission Group' : 'New Permission Group'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                    <?= isset($group) ? 'Update Permission Group' : 'New Permission Group'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url() ?>index.php/permission_group/new_permission_group">New Permission Group</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url() ?>index.php/permission_group">Permission Groups</a></li>
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

                    <div class="col-lg-12">
                    <div class="col-lg-6" id="data-form">
                        <div class="form-group">

                          <input type="hidden" value="<?= isset($group) ? $group['group_id'] : 0 ?>" id="group_id">

                            <label>Permission Group ID</label>
                            <input type="text" class="form-control"  value="<?= isset($group) ? $group['group_id'] : 0 ?>" id="display_group_id" disabled="disabled">
                        </div>
                        <div class="form-group">
                            <label>Permission Group Name</label>
                            <input type="text" class="form-control" placeholder="Enter group name"
                                   value="<?= isset($group) ? $group['group_name'] : '' ?>" id="group_name" >
                        </div>
                        <?php
                            if((!isset($group) && $PERM_GRP_ADD == true) || $PERM_GRP_EDIT == true)
                                echo '<button class="btn btn-primary btn-flat" style="margin-top: 20px" id="pg-btn-save">Save Changes</button>';
                          //  else if($group_id > 0 && $PERM_GRP_EDIT == true)
                              //  echo '<button class="btn btn-primary btn-flat" style="margin-top: 20px" id="pg-btn-save">Save Changes</button>';
                        ?>
                        <?php if(isset($group)) { ?>
                          <div class="row">
                              <div class="col-md-12" style="margin-top:25px" id="line-permission-div">
                                <label>Line Permission</label><br><br>
                                <?php
                                  foreach($line_permissions as $lp){
                                      $checked = $lp['permission_status'] > 0 ? "checked" : "";
                                      echo '<span style="cursor: pointer;margin-bottom: 20px">';
                                      echo '<input type="checkbox" class="flat-red permission" '.$checked.'
                                       data-line-id="'.$lp['line_id'].'"> '.$lp['line_code'];
                                       echo '<span id="'.$lp['line_id'].'" style="font-weight: bold;padding-left: 15px"></span><br>';
                                  }
                                ?>
        	        	           </div>
                          </div>
                        <?php } ?>
                    </div>


                    <!-- permissions section -->

                    <?php if(isset($group)) { ?>
                    <div class="col-md-5">
                        <label>Permissions</label>
	                <?php  foreach($all_permissions as $per_cat){ ?>
                            <div id="permission-div">
                                <label style="color:green;font-size: 15px;"><u><?php echo $per_cat['cat_name'] ?></u></label> <br>
                                    <?php  if(sizeof($per_cat['permissions']) > 0) {
                                            foreach($per_cat['permissions'] as $permission) {
                                            $checked = $permission['permission_status'] > 0 ? "checked" : "";
                                    ?>
                                    <span style="cursor: pointer;margin-bottom: 20px">
                                    <input type="checkbox" class="flat-red permission" <?php echo $checked ?>
                                        data-permission-code="<?php echo $permission['permission_code'] ?>" > <?php echo $permission['permission_name'] ?>
                                    </span><span id="<?php echo $permission['permission_code'] ?>" style="font-weight: bold;padding-left: 15px"></span><br>
                                    <?php  }

                                    }  ?>
                            </div>
                            <?php }  ?>
	        	</div>
                        <?php } ?>



                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('common/footer'); ?>


</div>


    <!-- jQuery 2.1.4 -->

     <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
    <!-- page js file -->
    <script src="<?php echo base_url(); ?>assets/views/admin/permissions/new_permission_group.js"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
    <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>



  </body>
</html>
