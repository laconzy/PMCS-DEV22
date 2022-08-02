$(document).ready(function () {

//alert(2);

	$('#scan_date').datepicker({
		format: "yyyy-mm-dd",
		viewMode: "days",
		minViewMode: "days"
	});


	$('#order_table tbody').on('click', 'button', function () {

		var ele = $(this);

		var barcode = ele.attr('data-bundle-no');
		var operation = ele.attr('data-operation');
		var prev_operation = ele.attr('data-prev-operation');

		appAlertConfirm('Do you want to delete selected bundle?', function () {
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/destroy',
				type: 'post',
				data : {
					'barcode' : barcode,
					'operation_id' : operation,
					'prev_operation_id' : prev_operation
				},
				dataType: 'json',
				success: function (res) {
					if (res.status == 'success') {
						ele.parent().parent().remove();
						appAlertSuccess(res.message);
					}
					if(res.status == 'error'){
						appAlertError(res.message);
					}
				},
				error: function (err) {
					alert(err);
				}
			});
		});
	});


	$('#btn_search').click(function () {
		var order_id = $('#order_id').val().trim();
		var barcode = $('#barcode').val().trim();
		var operation = $('#operation').val();
		var line_no = $('#line_no').val();
		var size = $('#size').val().trim();
		var scan_date = $('#scan_date').val();

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
				url: BASE_URL + 'index.php/report/get_scan_history',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'order_id': order_id,
					'barcode': barcode,
					'operation' : operation,
					'line_no' : line_no,
					'size' : size,
					'scan_date' : scan_date
				},
				success: function (res) {
					var results = res.results;
					var str = '';
					var qty = 0;
					for (var x = 0; x < results.length; x++) {
						qty+=parseInt(results[x]['qty']) ;
						str += '<tr>';
						str += '<td><input type="checkbox" data-barcode="' + results[x]['barcode'] + '" data-operation="' +  results[x]['operation'] + '" data-prev-operation="' +  results[x]['prev_operation'] + '"/></td>';
						str += '<td>' + results[x]['barcode'] + '</td>';
						str += '<td>' + results[x]['bundle_no'] + '</td>';
						str += '<td>' + results[x]['cut_no'] + '</td>';
						str += '<td>' + results[x]['operation_name'] + '</td>';
						str += '<td>' + results[x]['scan_date'] + '</td>';
						str += '<td>' + results[x]['line_code'] + '</td>';
						str += '<td>' + results[x]['shift'] + '</td>';
						str += '<td>' + results[x]['first_name'] + '</td>';
						str += '<td>' + results[x]['size_code'] + '</td>';
						str += '<td>' + results[x]['qty'] + '</td>';
						str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' +  results[x]['barcode'] + '" data-operation="' +  results[x]['operation'] + '" data-prev-operation="' +  results[x]['prev_operation'] + '">Delete</button></td>';
						str += '</tr>';
					}
					str += '<tr>';
					str += '<td colspan="10"></td>';

					str += '<td>' + qty + '</td>';
					str += '</tr>';

					$('#order_table tbody').html(str);
					$('body').loadingModal('destroy');
				},
				error: function (err) {
					console.log(err);
					$('body').loadingModal('destroy');
				}
			});
		}, 200);

	});



	$('#select_all').change(function () {
			$('#order_table tbody input:checkbox').prop('checked', this.checked);
	});


	$('#btn_remove').click(function () {
			var data = [];
			$('#order_table tbody input:checkbox').each(function () {
					if (this.checked == true) {
							data.push({
								'barcode' : $(this).attr('data-barcode'),
								'operation_id' : $(this).attr('data-operation'),
								'previous_operation_id' : $(this).attr('data-prev-operation')
							});
					}
			});

			if (data.length > 0) {
					appAlertConfirm('Do you want to remove selected barcodes?', function () {
							remove_barcodes_from_production(data);
					});
			}
	});


	function remove_barcodes_from_production(barcodes) {
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
				url: BASE_URL + 'index.php/report/destroy_list',
				type: 'POST',
				dataType: 'json',
				data: {
						'barcodes': barcodes
				},
				async: false,
				success: function (res) {
					if(res.status == 'success'){
						$('#order_table tbody input:checkbox').each(function () {
								if (this.checked == true) {
										$(this).parent().parent().remove();
								}
						});
					}
					else {
						appAlertError(res.message);
					}
					$('body').loadingModal('destroy');
				},
				error: function (err) {
						appAlertError('Process Error');
						console.log(err);
						$('body').loadingModal('destroy');
				}
		});
	},200);

	}

});
