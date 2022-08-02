<html>
  <head>
    	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
  </head>
  <body>
    <?php if($status == 'success') { ?>
      <div class="alert alert-success">
        <strong>Success!</strong> <?= $message ?>
      </div>
    <?php } ?>

    <?php if($status == 'error') { ?>
      <div class="alert alert-danger">
        <strong>Error!</strong> <?= $message ?>
      </div>
    <?php } ?>

  </body>
</html>
