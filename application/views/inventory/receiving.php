<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Receiving</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">
</head>
<body>
<!-- Site wrapper -->
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">
<div>
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">RECEIVING</h4>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>Date From</label>
      <input type="text" class="form-control input-sm date" autocomplete="off" id="date_from">
		</div>
		<div class="col-md-2">
			<label>Date To</label>
		  <input type="text" class="form-control input-sm date" autocomplete="off" id="date_to">
		</div>
		<div class="col-md-2">
			<label>Received Date From</label>
			<input type="text" class="form-control input-sm date" autocomplete="off" id="received_date_from">
		</div>
		<div class="col-md-2">
			<label>Received Date To</label>
			<input type="text" class="form-control input-sm date" autocomplete="off" id="received_date_to">
		</div>
		<div class="col-md-2">
			<label>Main Store</label>
		  <select class="form-control input-sm" autocomplete="off" id="main_store">
				<option value="">...Select One...</option>
				<?php foreach ($main_stores as $row) { ?>
					<option value="<?= $row['main_location_name'] ?>"><?= $row['main_location_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Invoice</label>
		  <input type="text" class="form-control input-sm" autocomplete="off" id="invoice">
		</div>
	</div>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>Dyelot No</label>
		  <input type="text" class="form-control input-sm" autocomplete="off" id="pi_no">
		</div>
		<div class="col-md-2">
			<label>Fabric Code</label>
			<input type="text" class="form-control input-sm" autocomplete="off" id="fabric_code">
		</div>
		<div class="col-md-3">
			<label>Color</label>
			<input type="text" class="form-control input-sm" autocomplete="off" id="color_id">
		</div>
		<div class="col-md-2">
			<label>Status</label>
			<select class="form-control input-sm" autocomplete="off" id="status">
				<option value="Received" selected>Received</option>
				<option value="Transit">Transit</option>
			</select>
		</div>
		<div class="col-md-3">
			<button class="btn btn-primary btn-sm" id="btn_search" style="margin-top:22px">Search <i id="btn_search_i"></i></button>
			<button class="btn btn-success btn-sm" id="btn_export" style="margin-top:22px">Export To Excel</button>
		</div>
	</div>


	<div class="col-md-12" style="margin-top:15px;display: block;overflow-x: auto;white-space: nowrap;">
		<table id="data_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
			<tr>
				<th>ID</th>
				<th>Invoice</th>
				<th>PO No</th>
				<th>Part No</th>
				<th>Composion</th>
				<th>Color</th>
				<th>Factory Name</th>
				<th>Line No</th>
				<th>Release No</th>
				<th>Style</th>
				<th>FNG</th>
				<th>Actual Received Date</th>
				<th>Main Store</th>
				<th>Sub Store</th>
				<th>Bin Location</th>
				<th>Bin Code</th>
				<th>UOM</th>
				<th>Status</th>
				<th>Dyelot No</th>
				<th>Batch No</th>
				<th>Role No</th>
				<th>Received Qty</th>
				<th>Actual Qty</th>
				<th>Width</th>
				<th>Shade</th>
				<th>Item Code</th>
				<th>Ins. Status</th>
				<th>Ins. Date</th>
				<th>Ins. Pass By</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>


<script>
	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function(){

		$('.date').datepicker({
				format: "yyyy-mm-dd",
				viewMode: "days",
				minViewMode: "days"
		});

		$('#btn_search').click(function(){
			let fabric_code = $('#fabric_code').val().trim();
			let color = $('#color_id').val().trim();
			let date_from = $('#date_from').val().trim();
			let date_to = $('#date_to').val().trim();
			let received_date_from = $('#received_date_from').val().trim();
			let received_date_to = $('#received_date_to').val().trim();
			let main_store = $('#main_store').val().trim();
			let invoice = $('#invoice').val().trim();
			let pi_no = $('#pi_no').val().trim();
			let status = $('#status').val().trim();

			// if(fabric_code == '' || color == ''){
			// 	appAlertError('Please enter fabric code and color');
			// 	return;
			// }

			$('body').loadingModal({
				position: 'auto',
				text: '',
				color: '#fff',
				opacity: '0.5',
				backgroundColor: 'rgb(0,0,0)',
				animation: 'cubeGrid'
			});

			setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/inventory/inventory/get_receiving_data',
					type: 'get',
					dataType: 'json',
					data : {
						'fabric_code' : fabric_code,
						'color' : color,
						'date_from' : date_from,
						'date_to' : date_to,
						'received_date_from' : received_date_from,
						'received_date_to' : received_date_to,
						'main_store' : main_store,
						'invoice' : invoice,
						'pi_no' : pi_no,
						'status' : status
					},
					async : false,
					success: function (res) {
						if(res.data != undefined){
							let data = res.data;
							let str = '';
							for(let x = 0 ; x < data.length ; x++){
								str += `<tr>
								<td>${data[x]['id']}</td>
								<td>${data[x]['invoice']}</td>
								<td>${data[x]['po_no']}</td>
								<td>${data[x]['part_no']}</td>
								<td>${data[x]['fab_composion']}</td>
								<td>${data[x]['color']}</td>
								<td>${data[x]['factory_name']}</td>
								<td>${data[x]['line_no']}</td>
								<td>${data[x]['release_no']}</td>
								<td>${data[x]['style']}</td>
								<td>${data[x]['fng_no']}</td>
								<td>${format_data(data[x]['actual_received_date'])}</td>
								<td>${data[x]['main_stores']}</td>
								<td>${data[x]['sub_stores']}</td>
								<td>${data[x]['bin_location']}</td>
								<td>${data[x]['bin_code']}</td>
								<td>${data[x]['uom']}</td>
								<td>${data[x]['status']}</td>
								<td>${data[x]['pi_no']}</td>
								<td>${data[x]['batch_no']}</td>
								<td>${data[x]['role_no']}</td>
								<td>${data[x]['recieved']}</td>
								<td>${data[x]['actchchual']}</td>
								<td>${data[x]['width']}</td>
								<td>${data[x]['shade']}</td>
								<td>${data[x]['item_code']}</td>
								<td>${data[x]['ins_status']}</td>
								<td>${data[x]['inspection_date']}</td>
								<td>${data[x]['ins_pass_by']}</td>
								</tr>`;
							}
							$('#data_table tbody').html(str);
						}
						$('body').loadingModal('destroy');
					},
					error: function (err) {
						$('body').loadingModal('destroy');
						appAlertError(err);
						console.log(err);
					}
				});
			}, 200);

		});


		$('#btn_export').click(function(){
			ExportToExcel('xlsx');
		});

	});


	function ExportToExcel(type, fn, dl) {
		var elt = document.getElementById('data_table');
		var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
		return dl ?
				XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
				XLSX.writeFile(wb, fn || ('report.' + (type || 'xlsx')));
	}


	function format_data(_val){
		if(_val == null){
			return '';
		}
		else {
			return _val;
		}
	}

</script>
</body>
</html>
