<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Bundle Ageing Summery Report</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<!-- <link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">

	<style>

	@media print {
  #search_section * {
    visibility: hidden;
  }

	#data_content {
		position: absolute;
		top: 60px;
		width: 100%;
  }
}

.customer-po {
	color:blue;
	text-decoration: underline;
	cursor: pointer;
}

	</style>


</head>
<body>
<!-- Site wrapper -->
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">
<div>
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">BUNDLE AGEING SUMMERY REPORT</h4>

	<div class="col-md-12" style="margin-top:20px" id="search_section">
		<div class="col-md-3">
			<label>Operation</label>
			<select class="form-control input-sm" id="operation">
				<option value="ALL">...All...</option>
				<?php
					foreach ($operations as $row) {
						echo '<option value="'.$row['operation_id'].'">'.$row['operation_name'].'</option>';
					}
				?>
			</select>
		</div>
		<div class="col-md-1">
			<button class="btn btn-primary btn-sm" id="btn_search" style="margin-top:22px">Search</button>
		</div>
		<div class="col-md-1">
			<button class="btn btn-info btn-sm" id="btn_print" style="margin-top:22px">Print</button>
		</div>
	</div>



		<div class="col-md-12" style="margin-top:15px" id="data_content">
			<!-- <table class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
					<th>Barcode</th>
					<th>Bundle no</th>
					<th>Cut No</th>
					<th>Size</th>
					<th>CUTTING OUT</th>
					<th>HEAT SEAL</th>
					<th>FUSING</th>
					<th>PLACKET</th>
					<th>SUPERMARKET IN</th>
					<th>SUPERMARKET OUT</th>
					<th>LINE IN</th>
					<th>LINE OUT</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table> -->
		</div>
</div>
</div>
</div>

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script> -->
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>

<script>
	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function(){

			$('#btn_search').click(function(){

				$('body').loadingModal({
			  position: 'auto',
			  text: '',
			  color: '#fff',
			  opacity: '0.5',
			  backgroundColor: 'rgb(0,0,0)',
			  animation: 'cubeGrid'
			});

				var operation = $('#operation').val();
				appAjaxRequest({
		      url : BASE_URL + 'index.php/report/get_bundle_ageing_summery',
		      type: 'get',
		      dataType : 'json',
		      data : {
		        'operation' : operation
		      },
		      //async : false,
		      success : function(res){
		        load_wip_summery(res.operations, res.data);
						$('body').loadingModal('destroy');
		      },
		      error : function(err){
						$('body').loadingModal('destroy');
		        alert(err);
		      }
		    });
			});


			$('#btn_print').click(function(){
				window.print();
			});


			$('#data_content').on('click', '.customer-po', function(){
				let ele = $(this);
				let opearion = ele.attr('data-operation');
				let customer_po = ele.attr('data-customer-po');
				window.open(`${BASE_URL}index.php/report/bundle_ageing_details_report/${opearion}/${customer_po}`, '_blank');
			});

	});



	function load_wip_summery(operations, data){

		let str = '';
		for(let x = 0 ; x < operations.length ; x++){
			str += `<div class="col-md-12" style="margin-top:15px">
				<label>${operations[x]['operation_name']} WIP</label>
				<table class="table table-striped table-bordered table-hover" width="100%">
					<thead>
					<tr>
						<th>Customer PO</th>
						<th>Style</th>
						<th>Color</th>
						<th>Qty</th>
					</tr>
					</thead>
					<tbody>`;

			let bundle_data = data[operations[x]['operation_id']];
			for(let y = 0 ; y < bundle_data.length ; y++){
				str += `<tr>
					<td><span class="customer-po" data-operation="${operations[x]['operation_id']}" data-customer-po="${bundle_data[y]['customer_po']}">${bundle_data[y]['customer_po']}</span></td>
					<td>${bundle_data[y]['style_code']}</td>
					<td>${bundle_data[y]['color_code']}</td>
					<td>${bundle_data[y]['total_qty']}</td>
				</tr>`;
			}

			str += `</tbody>
				</table>
			</div>`;
		}

		$('#data_content').html(str);
	}



	// function load_wip_data(operations, data){
	//
	// 	let str = '';
	// 	for(let x = 0 ; x < operations.length ; x++){
	// 		str += `<div class="col-md-12" style="margin-top:15px">
	// 			<label>${operations[x]['operation_name']} WIP</label>
	// 			<table class="table table-striped table-bordered table-hover" width="100%">
	// 				<thead>
	// 				<tr>
	// 					<th>Order ID</th>
	// 					<th>Barcode</th>
	// 					<th>Color</th>
	// 					<th>Size</th>
	// 					<th>Qty</th>
	// 				</tr>
	// 				</thead>
	// 				<tbody>`;
	//
	// 		let bundle_data = data[operations[x]['operation_id']];
	// 		for(let y = 0 ; y < bundle_data.length ; y++){
	// 			str += `<tr>
	// 				<td>${bundle_data[y]['order_id']}</td>
	// 				<td>${bundle_data[y]['barcode']}</td>
	// 				<td>${bundle_data[y]['color_code']}</td>
	// 				<td>${bundle_data[y]['size_code']}</td>
	// 				<td>${bundle_data[y]['qty']}</td>
	// 			</tr>`;
	// 		}
	//
	// 		str += `</tbody>
	// 			</table>
	// 		</div>`;
	// 	}
	//
	// 	$('#data_content').html(str);
	// }


</script>
</body>
</html>
