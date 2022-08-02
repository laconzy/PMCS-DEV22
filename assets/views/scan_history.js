$(document).ready(function () {

//alert(2);

	$('.date').datepicker({

		format: "yyyy-mm-dd",

		viewMode: "days",

		minViewMode: "days"

	});


	$('#order_table tbody').on('click', 'button', function () {

		var ele = $(this);

		var barcode = ele.attr('data-bundle-no');
		var operation = ele.attr('data-operation');

		appAlertConfirm('Do you want to delete selected bundle?', function () {

			appAjaxRequest({

				url: BASE_URL + 'index.php/report/destroy/' + barcode + '/' + operation,

				type: 'post',

				dataType: 'json',

				success: function (res) {

					if (res.status == 'success') {

						ele.parent().parent().remove();

						appAlertSuccess(res.message);

						//reload_summery_table(LAYSHEET_NO);

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

		var cut_plan = $('#cut_plan').val();
		var barcode = $('#barcode').val();
		//alert('ok');
		appAjaxRequest({

			url: BASE_URL + 'index.php/report/get_scan_history',

			type: 'GET',

			dataType: 'json',

			async: false,

			data: {

				'cut_plan': cut_plan,
				'barcode': barcode

			},

			success: function (res) {

				var results = res.results;
				var str = '';
				var qty = 0;
				for (var x = 0; x < results.length; x++) {
					//	qty+=parseInt(results[x]['qty']) ;
					str += '<tr>';
					str += '<td>' + results[x]['barcode'] + '</td>';
					str += '<td>' + results[x]['bundle_no'] + '</td>';
					str += '<td>' + results[x]['cut_no'] + '</td>';
					str += '<td>' + results[x]['operation_name'] + '</td>';
					str += '<td>' + results[x]['created_date'] + '</td>';
					str += '<td>' + results[x]['first_name'] + '</td>';
					str += '<td>' + results[x]['size_code'] + '</td>';
					str += '<td>' + results[x]['qty'] + '</td>';
					str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' +  results[x]['barcode'] + '" data-operation="' +  results[x]['operation'] + '">Delete</button></td>';
					str += '</tr>';

				}
				str += '<tr>';
				str += '<td colspan="7"></td>';

				str += '<td>' + qty + '</td>';
				str += '</tr>';

				$('#order_table tbody').html(str);

			},

			error: function (err) {

				console.log(err);

			}

		});

	});


});
