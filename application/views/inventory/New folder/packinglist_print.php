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
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
 
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers td {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}

table {
    border: 5px solid #CCC;
    border-collapse: collapse;
}

td {
    border: none;
}









.td1 {
	border : 1px solid #ddd;
	padding : 3px;
	font-size : 11px;
}

#tbl1,#tbl2,#tbl3 {
	width: 100%;
}

#tbl1 tr {
	height: 20px;
}

#tbl2 tr {
	height: 20px;
}

#tbl3 tr {
	height: 20px;
}

#footer-content {
	width:100%;font-size:12px;margin-top:20px
}

#footer-content td{
	border-style: none !important;
	border-color : #FFF !important;
}

#footer-content tr {
	height:25px
}

#watermark {
	position: fixed;
	/* top: 48%;
	left: 10%; */
	z-index:999;
	font-size: 72px;
	color:red;
	opacity: 0.1;
	font-weight: 900;
	-ms-transform: rotate(-45deg); /* IE 9 */
  transform: rotate(-45deg);
}



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
				width:4in;
				height:3in;
				/* border: solid 1px; */
				font-family:Verdana, Geneva, sans-serif;
				font-size:12px;
				float:left;
				margin-left:2px;
				margin-top:2px;
			}

			.status {
				font-size : 14px;
				font-weight: bold;
				text-align:center;
			}

			.part-no {
				font-size : 14px;
				font-weight: bold;
				text-align:left;
			}

			.po-no {
				font-weight: bold;
			}

			.barcode {
				padding : 8px;
			}

			

</style>
<script>
				$('body').append(str);

				JsBarcode(`#barcode_${data[x].item_code}`, data[x].item_code, {
					width:2,
					height:30,
					fontSize: 5,
					displayValue: false,
					margin:0
				});

</script>

<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>

</head>
<body>
<div class="container">

	<div class="row">

		
	<?php if(isset($packing_id)){
							$x = 0;
							$issue_total = 0;

							// for($x = 0 ; $x < 200 ; $x++){
							foreach ($roles1 as $row) {
								$x++;
								$issue_total += $row['issue']; ?>
				<table id="customer" width="341.88976378px" height ="158.50393701px" style="margin-bottom:30px;margin-top:30px; text-align:left;" >
				
					<tr style="margin-left: 15px">
					
					
								<td style="width:40%" style="border:none; font-size:80% ;" class="po-no">Order Code:</td>	
							
						<td class="part-no" style="font-size:100%"><?= $row['color_code'] ?></td>
					</tr>

					<tr>			
				<td style="width:200px" class="po-no">Date:</td>	
		<td class="part-no"><?= $row['color_code'] ?></td>
	</tr>

	<tr>			
				<td style="width:200px" class="po-no">Start Time:</td>	
		<td class="part-no"><?= $row['po_no'] ?></td>
	</tr>

	<tr>			
				<td style="width:200px" class="po-no">Finish Time:</td>	
		<td class="part-no"><?= $row['item_no'] ?></td>
	</tr>
	<tr>			
				<td style="width:200px" class="po-no">Yard:</td>	
		<td class="part-no"><?= $row['item_no'] ?></td>
	</tr>

	<tr>			
				<td style="width:200px" class="po-no">Laying OPr:</td>	
		<td class="part-no"><?= $row['item_no'] ?></td>
	</tr>


					
</table>
<?php } ?>
				

				<?php } ?>	



</div>

</div>


			
<script>
window.print();
</script>

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
</body>

</html>