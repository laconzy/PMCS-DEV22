<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCS | Add/Edit User</title>
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

    <link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet" />

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
                            <span><?= isset($user) ? 'Update User' : 'New User'; ?></span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs text-success">
                      <?= isset($user) ? 'Update User' : 'New User'; ?>
                </h2>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url() ?>index.php/user/new_user">New user</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url() ?>index.php/user" >User List</a></li>
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



                        <div class="col-lg-12" id="data-form">

                    <input type="hidden" value="<?= isset($user) ? $user['id'] : 0 ?>" id="id">

                    <div class="col-lg-6">

                        <div class="form-group">
                            <label>EPF No</label>
                            <input type="text" class="form-control inpit-sm" placeholder="Enter EPF No"
                              value="<?= isset($user) ? $user['epf_no'] : '' ?>" id="epf_no" >
                        </div>

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="Enter first name"
                                value="<?= isset($user) ? $user['first_name'] : '' ?>" id="first_name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter last name"
                              value="<?= isset($user) ? $user['last_name'] : '' ?>" id="last_name">
                        </div>
                        <!--<div class="form-group">
                            <label>Name with Initials</label>
                            <input type="text" class="form-control" placeholder="Enter Name with Initials" id="05-initials-name">
                        </div>-->
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" maxlength="10" class="form-control" placeholder="Enter phone number"
                              value="<?= isset($user) ? $user['contact_no'] : '' ?>" id="contact_no">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter email address"
                              value="<?= isset($user) ? $user['email'] : '' ?>" id="email">
                        </div>
                        <div class="form-group">
                            <label>Permission Group</label>
                            <Select class="form-control" id="permission_group">

                                <?php foreach ($permission_groups as $row) { ?>
                                    <option value="<?php echo $row['group_id']; ?>"
                                      <?= (isset($user) && $row['group_id'] == $user['permission_group']) ? 'selected' : '' ?>  ><?php echo $row['group_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!--<div class="form-group">
                            <label>Payroll Location</label>
                            <Select class="form-control" id="05-hela-payrollloc">
                            <option value="">- SELECT LOCATION -</option>
                                <?php foreach ($hela_location as $row) { ?>
                                    <option value="<?php echo $row['hela_loc_code']; ?>"><?php echo $row['hela_location']; ?></option>
                                <?php } ?>
                            </select>
                        </div> -->
                    </div>

                    <div class="col-lg-6">
                        <!--<div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Enter username" id="05-username">
                        </div>-->
                        <div class="form-group">
                            <label>Location</label>
                            <Select class="form-control" id="site">
                            <option value="">- SELECT LOCATION -</option>
                                <?php foreach ($sites as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"
                                      <?= (isset($user) && $row['id'] == $user['site']) ? 'selected' : '' ?> ><?php echo $row['site_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Enter passsword" id="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm your password" id="conf_password">
                        </div>

                        <div class="form-group">
                            <label>NIC</label>
                            <input type="text" class="form-control" placeholder="Enter National Identity Card"
                              value="<?= isset($user) ? $user['nic'] : '' ?>" id="nic">
                        </div>


                        <!--<div class="form-group">
                            <label>Staff Category</label>
                            <select class="form-control" id="05-staf_cat">
                            <option value="">- SELECT CATEGORY -</option>
                                <?php foreach ($dtx_staff_category as $row) { ?>
                                    <option value="<?php echo $row['staff_cat']; ?>"><?php echo $row['staff_category_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>-->


                        <div class="form-group">
                            <label>Designation</label>
                            <select class="form-control" id="designation">
                            <option value="">- SELECT DESIGNATION -</option>
                                <?php foreach ($designations as $row) { ?>
                                    <option value="<?php echo $row['des_id']; ?>"
                                      <?= (isset($user) && $row['des_id'] == $user['designation']) ? 'selected' : '' ?> ><?php echo $row['designation']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control" id="department">
                            <option value="">- SELECT DEPARTMENT -</option>
                                <?php foreach ($departments as $row) { ?>
                                    <option value="<?php echo $row['dep_id']; ?>"
                                      <?= (isset($user) && $row['dep_id'] == $user['department']) ? 'selected' : '' ?>  ><?php echo $row['dep_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!--<div class="form-group">
                            <label>User Level</label>
                            <Select class="form-control" id="05-user-level">
                                <?php foreach ($user_levels as $row) { ?>
                                    <option value="<?php echo $row['level_id']; ?>"><?php echo $row['level_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>-->

                         <!--<div class="form-group">
                            <label>Grade</label>
                            <Select class="form-control" id="05-hela-grade">
                            <option value="">- SELECT LOCATION -</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>

                            </select>
                        </div>-->



                         <div class="form-group">
                            <label>Active Status</label>
                            <div class="">
                            <label>
                              <?php $checked = (isset($user) && $user['active'] == 'Y') ? 'checked' : ''; ?>
                              <input type="checkbox" id="user_active" width="20" <?= $checked ?> />
                            </label>
                          </div>
                        </div>


                    </div>

                    <div class="col-lg-12">
                        <?php if($USER_EDIT == 1 || $USER_ADD) { ?>
                            <button class="btn btn-flat btn-primary" style="margin-right: 30px" id="btn_save">Save Details</button>
                        <?php } ?>
                    </div>

                    <!--<div class="col-lg-12" style="margin-top: 20px;display: none" id="05-image-section">
                        <div class="row">
                            <hr>
                            <div class="col-lg-2">
                                <img src="" id="05-user-image" width="150">
                            </div>
                            <div class="col-lg-10">
                                <?php echo form_open_multipart(base_url().'index.php/user/upload_image/'.$id);?>
                                    <input type="file" name="userfile" size="20" />
                                    <br /><br />
                                    <input type="submit" value="upload" />
                                </form>
                                <?php echo $error;?>
                            </div>
                        </div>
                    </div>-->
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
    <script src="<?php echo base_url(); ?>assets/views/admin/users/new_user.js"></script>
    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>
    <!-- datatables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.js"></script>
    <script  src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
    <!-- jquery form validator plugin -->
    <script src="<?php echo base_url(); ?>/assets/application/form_validator.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
    </script>



  </body>
</html>
