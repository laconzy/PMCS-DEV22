	<html>
	<head>
		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title>PMCS | Generate QR Codes</title>

		<!-- Tell the browser to be responsive to screen width -->

		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- Bootstrap 3.3.5 -->

		<!-- bootstrap datepicker -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/> -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/> -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/> -->
		<!-- App styles -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css"> -->
		<!-- jQuery 2.1.4 -->
		<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<!-- <script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script> -->
		<script src="<?php echo base_url(); ?>assets/plugins/qrcode/qrcode.min.js"></script>
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


	<?php foreach ($qr_data as $row) {
		$str = $row['fabrication'].'||'.$row['color'].'||'.$row['qty'];
		?>

		<div style="width:6.4cm;height:3.7cm;border: solid 1px;font-family:Verdana, Geneva, sans-serif;font-size:12px;float:left;margin-left:2px;margin-top:2px;"
			 align="center">
			<table width="100%" border="0">

				<!-- <tr style="font-family:Verdana, Geneva, sans-serif;font-size:10px;">
					<td colspan="10" style="font-weight:bold;background-color:#FFF;color:#000"
						align="center"><br><?=  $value ; ?></br></td>
				</tr>
				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:10px;">
					<td colspan="10" style="font-weight:bold;background-color:#FFF;color:#000"
						align="center"><?= $row['order_code']; ?><br></td>
				</tr>

				<tr style="font-family:Verdana, Geneva, sans-serif;font-size:7px;">
					<td><label>Size </label></td>
					<td>:</td>
					<td><strong><?= $row['size_code']; ?></strong></td>
					<td><label>Order ID </label></td>
					<td>:</td>
					<td><strong><?= $row['ord_id']; ?></strong></td>
				</tr> -->
				<!-- <tr style="font-family:Verdana, Geneva, sans-serif;font-size:7px;">
					<td><label>QTY </label></td>
					<td>:</td>
					<td><strong><?= $row['qty']; ?></strong></td>
					<td><label>No </label></td>
					<td>:</td>
					<td><strong><?= $row['no']; ?></strong></td>
				</tr> -->

				<script>
					$(function () {

					var qrcode = new QRCode("qr_<?= $row['id'] ?>", {
					    text: '<?= $row["link"] ?>',
					    width: 70,
					    height: 70,
					    colorDark : "#000000",
					    colorLight : "#ffffff",
					    correctLevel : QRCode.CorrectLevel.H
					});

					});

				</script>

				<tr>
					<!-- <td colspan="6" style="padding:10px;">
						<center>
							<svg class="barcode2<?= $row['barcode_no']; ?>" id="barcode_<?= $row['barcode_no']; ?>"></svg>
						</center>
					</td> -->
					<td style="font-size:12px;width:60%">
						<label>Color : <?= $row['color'] ?></label> <br>
						<label>Qty(yd) : <?= $row['qty'] ?></label>
					</td>
					<td style="padding:5px;width:40%">
							<div id="qr_<?= $row['id']; ?>"></div>
					</td>
				</tr>
				<tr>
					<td style="font-size:9px;text-align:left;white-space: pre-wrap;word-break: break-word;" colspan="2"><?= trim($row['fabrication']); ?></td>
				</tr>

				<!-- <tr>
					<td colspan="6" style="font-size:8px;">
						<center><?php echo $row['barcode_no']; ?></center>
					</td>
				</tr> -->
			</table>
		</div>
		<div class="pagebreak"></div>
		<?php	 } ?>

	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

	<script>
	var BASE_URL = '<?php echo base_url(); ?>';
	</script>
	</body>
	</html>
