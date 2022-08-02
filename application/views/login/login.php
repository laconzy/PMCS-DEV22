<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>PMCS | Login</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/styles/style.css">
     <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/iCheck/square/blue.css">

    <style>

	.fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-image: url(<?php echo base_url(); ?>/assets/img/login.jpg);
    background-repeat:repeat;
  }

  </style>
</head>
<body class="fullscreen_bg">



<div class="color-line"></div>



<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md" style="color:#FFF">
                <h3 style="font-weight:bold">Production Management <br>& <br>Monitoring System</h3>
                <small>Sign in to start your session!</small>
            </div>
            <div class="hpanel">
                <div class="panel-body" >

		<?php $attributes = array('method' => 'post','onsubmit' => 'return user_login()'); ?>

        <?php echo form_open(base_url().'index.php/login/user_login',$attributes); ?>

           <div id="01-login-form">

				<div class="form-group">
					<label class="control-label" for="username">Username</label>
					<input type="text" placeholder="example@gmail.com" title="Please enter you username" required  
					name="username" id="01-username" 
					value="<?php set_value('username') ?>" class="form-control">
					<span class="help-block small" >Your unique username to app</span>
				</div>
				<div class="form-group">
					<label class="control-label" for="password">Password</label>
					<input type="password" title="Please enter your password" placeholder="******" required  
					name="password" id="01-password" class="form-control">
					<span class="help-block small" >Your strong password</span>
				</div>
				<div class="checkbox icheck">
					<label> <input type="checkbox"> Remember Me </label>
					<p class="help-block small" >(if this is a private computer)</p>
				</div>
				<input type="submit" class="btn btn-success btn-block" value="Login"/>
	
				<div class="col-xs-10">
				<label style="color:red" id="01-login-err-label"><?php echo $err_message; ?></label>
				</div>

           </form> 
		   </div>
		   
		   
		   
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Vendor scripts -->
	<script src="<?php echo base_url(); ?>/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/vendor/sparkline/index.js"></script>
<!-- iCheck -->
    <script src="<?php echo base_url(); ?>/assets/plugins/iCheck/icheck.min.js"></script>
<!-- base application js file -->
    <script src="<?php echo base_url(); ?>/assets/application/app.js"></script>
    <!-- page js file -->
    <script src="<?php echo base_url(); ?>/assets/views/login/01_login.js"></script>
    <!-- jquery form validator plugin -->
    <script src="<?php echo base_url(); ?>/assets/application/form_validator.js"></script>
<!-- App scripts -->
<script src="<?php echo base_url(); ?>/assets/scripts/homer.js"></script>

</body>
</html>
