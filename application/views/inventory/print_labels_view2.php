	<html>
	<head>
		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title>PMCS | Print Labels</title>

		<!-- Tell the browser to be responsive to screen width -->

		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- Bootstrap 3.3.5 -->

		<!-- bootstrap datepicker -->

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

		</style>
	</head>
	<body>




	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/application/app.js"></script>

	<script>
	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function(){

		

	});

	function load_labels(barcodes){
		appAjaxRequest({
			url: BASE_URL + 'index.php/inventory/inventory/get_print_labels_data',
			type: 'post',
			dataType: 'json',
			data : {
				'barcodes' : barcodes
			},
			success : function(res){
				generate_labels(res.data);
			},
			error : function(err){
				console.error(err);
				alert('Barcode printing error');
			}
		});
	}


	function generate_labels(data){
		for(let x = 0 ; x < data.length ; x++){
			str = `<div class="sticker" align="center">
				<table width="100%" border="0" style="margin-top:2px;">
					<tr>
						<td colspan="2" class="status">${data[x].ins_status}</td>
					</tr>
					<tr>
						<td>Color</td>
						<td>${data[x].color}</td>
					</tr>
					<tr>
						<td class="part-no">LOT</td>
						<td class="part-no">${data[x].pi_no}</td>
					</tr>
					<tr>
						<td class="part-no">Roll No</td>
						<td class="part-no">${data[x].role_no} - QTY : ${data[x].actchchual}</td>
					</tr>
					<tr>
						<td colspan="2" class="barcode">
						<svg id="barcode_${data[x].item_code}"></svg>
						<br> <span>${data[x].item_code}</span>
						</td>
					</tr>
				</table>
				</div>
				<div class="pagebreak"></div>`;
				$('body').append(str);

				JsBarcode(`#barcode_${data[x].item_code}`, data[x].item_code, {
					width:2,
					height:30,
					fontSize: 5,
					displayValue: false,
					margin:0
				});
		}
	}

	</script>
	</body>
	</html>
