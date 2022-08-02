$(document).ready(function () {

//alert(2);

	$('.date').datepicker({

		format: "yyyy-mm-dd",

		viewMode: "days",

		minViewMode: "days"

	});


	$('#btn_search').click(function () {
		var date_from   = $('#date_from').val();
		var date_to   = $('#date_to').val();
		var operations   = $('#operations').val();
		var building   = $('#building').val();
		//alert(building);
		appAjaxRequest({

			url: BASE_URL + 'index.php/report/get_daily_report',

			type: 'GET',

			dataType: 'json',

			async: false,

			data: {

				'date_from': date_from,
				'date_to': date_to,
				'building': building,
				'operations': operations

			},

			success: function (res) {

				var results = res.results;
				var str = '';
var qty=0;
				for (var x = 0; x < results.length; x++) {
					qty+=parseInt(results[x]['qty']) ;
					str += '<tr>';
					str += '<td>' + results[x]['order_code'] + '</td>';
					str += '<td>' + results[x]['scan_date'] + '</td>';
					str += '<td>' + results[x]['style_code'] + '</td>';
					str += '<td>' + results[x]['customer_po'] + '</td>';
					str += '<td>' + results[x]['color_name'] + '</td>';
					str += '<td>' + results[x]['size_code'] + '</td>';
					str += '<td>' + results[x]['line_code'] + '</td>';
					str += '<td>' + results[x]['qty'] + '</td>';
					str += '</tr>';

				}
				str += '<tr>';
				str += '<td colspan="7"></td>';

				str += '<td>' + qty+ '</td>';
				str += '</tr>';

				$('#order_table tbody').html(str);

			},

			error: function (err) {

				console.log(err);

			}

		});

	});


});
