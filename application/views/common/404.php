<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>PMCS | 404</title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>

<div class="color-line"></div>

<div class="back-link">
    <a href="/index.php" class="btn btn-primary">Back to Dashboard</a>
</div>
<div class="error-container">
    <i class="pe-7s-way text-success big-icon"></i>
    <h1>404</h1>
    <strong>
		<?php if(isset($heading)) {
				echo $heading; 
			}
			else{
				echo 'Page Not Found';
			}
		?>
	</strong>
    <p><?php if(isset($message)) {
				echo $message; 
			}
			else{
				echo 'Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.';
			}
		?>
    </p>
    <a href="/index.php" class="btn btn-xs btn-success">Go back to dashboard</a>
</div>


</body>
</html>
