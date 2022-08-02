$(document).ready(function () {

	// $('.date').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	viewMode: "days",
	// 	minViewMode: "days"
	// });


	$('#btn_search').click(function () {
		var po_no = $('#po_no2').val().trim();
		var order_id = $('#order_id').val();
		var cut_no = $('#cut_no').val().trim();
		var operation = $('#operation').val();
		//var barcode = $('#barcode').val().trim();

		if(po_no == null || po_no == ''){
			appAlertError('Please enter po no');
			return;
		}

		$('#btn_search_i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_scan_history2',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'po_no': po_no,
					'order_id': order_id,
					'cut_no' : cut_no,
					'operation' : operation,
					//'barcode' : barcode
				},
				success: function (res) {
					var results = res.data;
					var str = '';
					var qty = 0;
					for (var x = 0; x < results.length; x++) {
						str += '<tr>';
						str += '<td>' + results[x]['order_id'] + '</td>';
						//str += '<td>' + results[x]['barcode'] + '</td>';
						str += '<td>' + results[x]['bundle_no'] + '</td>';
						str += '<td>' + (results[x]['cut_no'] == null ? '' : results[x]['cut_no']) + '</td>';
						str += '<td>' + results[x]['operation_name'] + '</td>';
						str += '<td>' + results[x]['created_date'] + '</td>';
						str += '<td>' + results[x]['line_code'] + '</td>';
						str += '<td>' + results[x]['first_name'] + '</td>';
						str += '<td>' + results[x]['size_code'] + '</td>';
						str += '<td>' + results[x]['qty'] + '</td>';
						str += '</tr>';
					}
					str += '<tr>';
					str += '<td colspan="7"></td>';
					str += '<td>' + qty + '</td>';
					str += '</tr>';

					$('#order_table tbody').html(str);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				},
				error: function (err) {
					console.log(err);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				}
			});
		}, 200);
	});


	$('#po_no_search').click(function(){
		let po_no = $('#po_no').val();
		if(po_no != ''){
			$('#po_no2').val(po_no);//set searched po no value

			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_order_details_from_customer_po/' + po_no,
				type: 'GET',
				dataType: 'json',
				//async: false,
				success: function (res) {
					let data = res.data;
					let str = `<option value="all">All</option>`;
					if(data != undefined && data != null){
						for(let x = 0 ; x < data.length ; x++){
							str += `<option value="${data[x].order_id}">${data[x].order_id} - ${data[x].color_code}</option>`;
						}
					}
					$('#order_id').html(str);
				}
			});
		}
	});

});
