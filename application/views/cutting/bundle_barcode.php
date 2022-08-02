<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Bundle Barcods</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->

	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">


	<!-- jQuery 2.1.4 -->

	<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

	<!-- Bootstrap 3.3.5 -->

	<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>
	<style>
		@media print {
			.pagebreak {
				clear: both;
				page-break-after: always;
			}
		}

	</style>


</head>


<body>


<?php foreach ($bundle_chart as $row) { ?>

	<?php
	//$arr = array('CUTTING', 'PREPERATION', 'INPUT', 'LINE IN', 'LINE OUT');
	$arr = array('CUTTING', 'PREPERATION', 'INPUT', 'LINE IN', 'SCAN TAG');
	//$arr = array('CUTTING', 'INPUT');
	foreach ($arr as &$value) {
		?>

		<div style="width:6.1cm;height:3.5cm;border: solid 1px;font-family:Verdana, Geneva, sans-serif;font-size:12px;float:left;margin-left:2px;margin-top:2px;"
			 align="center">
			<!--                <div style="width:5cm;height:4.1cm;border: solid 1px;font-family:Verdana, Geneva, sans-serif;font-size:12px;float:left;margin-left:2px;margin-top:2px;" align="center" >
							  -->

			<table width="100%" border="0" style="margin-top:5px;">

				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:10px;">

					<td colspan="10" style="font-weight:bold;background-color:#FFF;color:#000"
						align="center"><?php echo $value; ?><br></td>
				</tr>
				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:10px;">

					<td colspan="10" style="font-weight:bold;background-color:#FFF;color:#000"
						align="center"><?= $laysheet['order_code'] ?><br></td>
				</tr>

				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:7px;">

					<td><label>&nbsp;&nbsp;LS#/CP</label></td>

					<td>:</td>

					<td><strong><?= $laysheet['laysheet_no'].'/'.$cut_plan['cut_plan_id'] ?></strong></td>

					<td><label>Barcode</label></td>

					<td>:</td>

					<td><strong><?= $row['barcode'] ?></strong></td>

				</tr>
				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:7px;">

					<td><label>&nbsp;&nbsp;Size </label></td>

					<td>:</td>

					<td><strong><?= $row['size_code'] ?></strong></td>

					<td><label>Cut.No </label></td>

					<td>:</td>

					<td><strong><?= $row['cut_no'] ?></strong></td>

				</tr>
				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:7px;">

					<td><label>&nbsp;&nbsp;QTY </label></td>

					<td>:</td>

					<td><strong><?= $row['qty'] ?></strong></td>

					<td><label>Bundel# </label></td>

					<td>:</td>

					<td><strong><?= $row['bundle_no'] ?></strong></td>
				</tr>

				<script>

					$(function () {



						<?php echo "JsBarcode('.barcode2" . $row['bundle_no'] . "', '" . $row['barcode'] . "',{

        width:1.5,

        height:20, 

        fontSize: 5,

        displayValue: false,

        margin:0
      });"; ?>

					});

				</script>


				<tr>
					<td colspan="6" style="padding:10px;">
						<center>
							<div style="height: 20px;">
								<svg class="barcode2<?= $row['bundle_no'] ?>"></svg>
							</div>
						</center>
					</td>
				</tr>
				<div><?php //echo $row['barcode']; ?></div>
				<!--                        <tr><td colspan="6" style="font-size:8px;"><center><?php //echo $row['barcode']; ?></center></td></tr>-->
			</table>
		</div>
		<div class="pagebreak"></div>
		<?php
		//$value = $value * 2;
	}
	?>


<?php } ?>


<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';


	//document.getElementById("footer").style.pageBreakBefore = "always";


</script>


</body>

</html>

