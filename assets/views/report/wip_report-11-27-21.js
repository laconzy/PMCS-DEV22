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
		var shift   = $('#shift').val();
		//alert(building);
		appAjaxRequest({

			url: BASE_URL + 'index.php/report/get_wip',

			type: 'GET',

			dataType: 'json',

			async: false,

			data: {

				'date_from': date_from,
				'date_to': date_to,
				'building': building,
				'operations': operations,
				'shift': shift

			},

			success: function (res) {

				var results = res.results;
				var str = '';
var qty=0;
				for (var x = 0; x < results.length; x++) {
					qty+=parseInt(results[x]['tty_sum']) ;
					str += '<tr>';
					var order_code=results[x]['order_code'];
					arr=order_code.split('::')
					str += '<td>' + results[x]['order_code'] + '</td>';
					str += '<td>' + arr[0] + '</td>';
					str += '<td>' + arr[1] + '</td>';
					str += '<td>' + arr[2] + '</td>';
					str += '<td>' + arr[3] + '</td>';
					str += '<td>' + results[x]['tty_sum'] + '</td>';
					str += '</tr>';

				}
				str += '<tr>';
				str += '<td colspan="5"></td>';

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
