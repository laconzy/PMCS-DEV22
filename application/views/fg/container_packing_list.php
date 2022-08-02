<!DOCTYPE html>
<html>
<head>

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">

</head>

<body style="display: block">
<div class="container" style="position: relative;">

	<div class="col-md-10 col-md-offset-1">
		<div style="width:100%">
			<div style="width:100%">
				<table style="margin-top: 10px;width:100%" id="tst">
				</table>
			</div>

			<div class="row" style="margin-top:20px">
				<div class="col-md-4">
					<label>Container No</label>
					<input type="text" class="form-control input-sm" id="container_no">
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary btn-sm" style="margin-top:22px" id="btn_search">Search <i id="btn_search_i"></i></button>
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary btn-sm" style="margin-top:22px" id="btn_print">Print</button>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="print_div">
					<table class="table table-striped table-bordered table-hover" id="tbl_data">
						<thead>
							<tr>
								<th colspan="7" style="text-align: center">SHIPMENT SUMMARY : <?= $current_date ?></th>
							</tr>
							<tr>
								<th colspan="7" style="text-align: center">CONTAINER NO : <span id="title_container_no"></span> </th>
							</tr>
							<tr>
								<th>NO</th>
								<th>PO #</th>
								<th>STYLE</th>
								<th>COLOUR</th>
								<th>QTY IN PCS</th>
								<th>CTN QTY</th>
								<th>CBM</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

					<table style="margin-top:20px;width:100%">
						<tr>
							<td style="width:16%;">Printed By</td>
							<td style="width:16%;">...........................................</td>
							<td style="width:16%;height:40px">Checked by</td>
							<td style="width:16%;">...........................................</td>
						</tr>
						<tr>
							<td style="width:16%;">Printed Date</td>
							<td style="width:16%;">...........................................</td>
							<td style="width:16%;height:40px""> Date</td>
							<td style="width:16%;">...........................................</td>
						</tr>
					</table>
			</div>



		</div>

	</div>

</div>

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

	$('#btn_search').click(function(){
		let container_no = document.getElementById('container_no').value.trim();
		if(container_no != null && container_no != ''){

			$('#title_container_no').html(container_no);

			$('#btn_search_i').addClass('fa fa-spinner fa-spin');
			setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/packing_list/fg_container_packing_list_data',
					type: 'post',
					data: {
						'container_no' : container_no
					},
					dataType: 'json',
					success: function (res) {
						let data = res.data;
						let str = '';
						if(data != null){
							let pcs_total = 0;
							let ctn_total = 0;
							for(let x = 0 ; x < data.length ; x++){
								str += `<tr>
									<td>${x+1}</td>
									<td>${data[x]['customer_po']}</td>
									<td>${data[x]['style_code']}</td>
									<td>${data[x]['color_code']}</td>
									<td>${data[x]['qty_in_pcs']}</td>
									<td>${data[x]['ctn_qty']}</td>
									<td></td>
								</tr>`;
								pcs_total += parseInt(data[x]['qty_in_pcs']);
								ctn_total += parseInt(data[x]['ctn_qty']);
							}
							str += `<tr>
								<td colspan="4" style="text-align:center;font-weight:bold">TOTAL</td>
								<td style="font-weight:bold">${pcs_total}</td>
								<td style="font-weight:bold">${ctn_total}</td>
								<td style="font-weight:bold"></td>
							</tr>`;
						}
						$('#tbl_data tbody').html(str);
						$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
					},
					error : function(err){
						console.log(err);
					}
				});
			}, 200);
		}
	});


	$('#btn_print').click(function(){
	//	$("#print_div").printElement();
		var mywindow = window.open('', 'PRINT', 'height=600,width=800');
    mywindow.document.write(`<html><head>
		<title>${document.title}</title>
		<link rel="stylesheet" href="${BASE_URL}assets/vendor/bootstrap/dist/css/bootstrap.css" />
		<link rel="stylesheet" href="${BASE_URL}assets/styles/style.css">`);
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('print_div').innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
  	//  mywindow.close();
  	//  return true;
	});

</script>

</body>

</html>
