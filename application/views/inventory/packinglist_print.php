<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
		<!-- App styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">		<!-- jQuery 2.1.4 -->
		<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>
		<!-- <script src="<?php echo base_url(); ?>assets/plugins/qrcode/qrcode.min.js"></script> -->

		<style>
			@media print {
				.pagebreak {
					clear: both;
					page-break-after: always;
				}
			}

			body {
				color : #000;
			}

			.sticker {
				/* width:6.4cm;
				height:3.7cm; */
				width:64mm;
				height:37mm;
				/* border: solid 1px; */
				font-family:Verdana, Geneva, sans-serif;
				font-size:12px;
				float:left;
				margin-left:2px;
				margin-top:2px;
			}

			.status {
				font-size : 20px;
				font-weight: bold;
				text-align:center;
			}

			.barcode {
				padding : 8px;
			}

			td {
				font-size : 12px;
				border-style : solid;
				border-width : 1px;
				padding-left : 2px;
			}

		
.vl {
  border-left: 1px solid green;
  height: 5px;
}

		</style>

</head>
<body>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/application/app.js"></script>

			<?php if(isset($packing_id)){
							$x = 0;
							$issue_total = 0;

							// for($x = 0 ; $x < 200 ; $x++){
							foreach ($roles as $row) {
								$x++;
								$issue_total += $row['issue']; ?>
								<div class="sticker" align="center" style="margin: 5px;">
								<table max-width="241px" height="130px" border="0" >
										
						
<tr>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
										<tr>
						<td colspan="2" class="status" style="font-size:9px">FABRIC RELAX DETAILS</td>
					</tr>
							<tr >
							
							
							
							<td colspan="2" class="" style="font-size:60%;"><b><?= $header_data['order_code'] ?></b></td>
							
							</tr>

							
							<tr>
					
							<td class="part-no" style="font-size:9px;">Date:</td>
							
							<td class="" style="font-size:9px;"><?= $header_data['date'] ?>

							<!-- <div class="vl"></div>	 -->
							<span><label>Dye Lot:</label> 
										<?= $row['pi_no'] ?></span>
							</td>
						
							</tr>
							<tr>
					
							<td class="part-no" style="font-size:9px;">Start Time</td>
							
							<td class="part-no">

			
							</td>
							
							</tr>
							<tr>
					
							<td class="part-no" style="font-size:9px;">Finish Time</td>
							
							<td class="part-no"></td>
							
							</tr>

							<!-- <tr>
					
							<td class="part-no" style="font-size:9px;">Yard</td>
							
							<td class="part-no" style="font-size:9px;"><?= $row['issue'] ?></td>
							
							</tr> -->

							<tr>
					
							<td class="part-no" style="font-size:9px;">Layering Opr</td>
							<td class="part-no" style="font-size:9px;">
							<span><label>Yard:</label> 
							<?= $row['issue'] ?></span>
						</td>
							
							</tr>

							<tr>
					
							<td class="part-no" style="font-size:9px;">QA</td>
							
							<td class="part-no" style="font-size:9px;"></td>
							
							</tr>
						
					
					
			</table>
							</div>
							<div class="pagebreak"></div>

			<?php } ?>
							
						<?php } ?>
		


		




<script>

	window.print();

</script>

</body>

</html>
