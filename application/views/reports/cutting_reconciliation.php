<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PMCS | Cutting Reconciliation Report</title>
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
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">CUTTING RECONCILIATION REPORT</h4>
	<div class="col-md-12" style="margin-bottom:20px">
	</div>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-3">
			<label>Date</label>
			<input type="text" class="form-control input-sm" id="date">
		</div>
		<div class="col-md-3">
			<label>PO No</label>
      <input type="text" class="form-control input-sm" autocomplete="off" id="customer_po">
		</div>
		<div class="col-md-2">
			<button class="btn btn-primary btn-sm" id="btn_search" style="margin-top:20px">Search <i id="btn_search_i"></i></button>
			<button class="btn btn-success btn-sm" id="btn_export" style="margin-top:20px">Export To Excel</button>
		</div>
	</div>

	<div class="col-md-12" style="margin-top:15px">
		<table id="data_table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
			<tr>
				<th>STYLE</th>
				<th>PO</th>
				<th>COLOR</th>
				<th>ORDER QTY</th>
				<th>PDS CUT QTY</th>
				<th>PDS CUT %</th>
				<th style="background-color:#ffd9b3" id="tbl_date_label">CUT DATE</th>
				<th>CUM CUT</th>
				<th>BALANCE TO CUT</th>
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
<!-- <script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script> -->
<!-- jquery form validator plugin -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>

<script>
	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function(){

		$('#date').datepicker({
			format: "yyyy-mm-dd",
			viewMode: "days",
			minViewMode: "days"
		});

		$('#btn_search').click(function(){
			let date = $('#date').val();
			let customer_po = $('#customer_po').val().trim();

			if(date == null || date == ''){
				appAlertError('Incorrect date');
				return;
			}

			// if(customer_po == null || customer_po == ''){
			// 	appAlertError('Incorrect customer PO');
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
				$('#tbl_date_label').html('CUT DATE (' + date + ')');
				load_data(date, customer_po);
			}, 200);

		});


		$('#btn_export').click(function(){
			ExportToExcel('xlsx')
		});


		function load_data(date, customer_po){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/cutting_reconciliation_report_data',
				type: 'get',
				dataType: 'json',
				data: {
					'date': date,
					'customer_po': customer_po,
				},
				async : false,
				success: function (res) {
					if(res.data != undefined){
						let data = res.data;
						let str = ``;
						for(let x = 0 ; x < data.length ; x++){
							let pds_qty = (data[x]['pds_cut_qty'] == null) ? 0 : parseInt(data[x]['pds_cut_qty']);
							let order_qty = (data[x]['order_qty'] == null) ? 0 : parseInt(data[x]['order_qty']);
							let cum_cut = (data[x]['cum_cut_qty'] == null) ? 0 : parseInt(data[x]['cum_cut_qty']);
							let pdc_cut_percentage = ((pds_qty / order_qty) * 100) - 100;
							pdc_cut_percentage = Math.round((pdc_cut_percentage + Number.EPSILON) * 100) / 100;
							let balance = pds_qty - cum_cut;

							str += `<tr>
								<td>${data[x]['style_code']}</td>
								<td>${data[x]['customer_po']}</td>
								<td>${data[x]['color_code']}</td>
								<td>${format_data(data[x]['order_qty'])}</td>
								<td>${format_data(data[x]['pds_cut_qty'])}</td>
								<td>${pdc_cut_percentage}</td>
								<td>${format_data(data[x]['cut_qty'])}</td>
								<td>${format_data(data[x]['cum_cut_qty'])}</td>
								<td>${balance}</td>
							</tr>`;
						}
						$('#data_table tbody').html(str);
					}
					else {
						$('#data_table tbody').html('');
						appAlertError('Error occured while loading data');
					}
					$('body').loadingModal('destroy');
				},
				error : function(err){
					$('#data_table tbody').html('');
					appAlertError(err);
					$('body').loadingModal('destroy');
				}
			});
		}


		function ExportToExcel(type, fn, dl) {
			var elt = document.getElementById('data_table');
			var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
			return dl ?
					XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
					XLSX.writeFile(wb, fn || ('cutting_reconciliation_report.' + (type || 'xlsx')));
		}


		function format_data(_data){
			if(_data == undefined || _data == null){
				return '';
			}
			else {
				return _data;
			}
		}

	});


</script>
</body>
</html>
