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
		return;
		appAjaxRequest({

			url: BASE_URL + 'index.php/report/get_line_wise_report',

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
				var results2 = res.results2;
				//console.log(results2)
				var str = '';
				var str2 = '';
				var qty=0;
				for (var x = 0; x < results.length; x++) {
					console.log('hr'+results[x]['hr10'])
					qty+=parseInt(results[x]['qty']) ;
					str += '<tr>';
					str += '<td>' + results[x]['scan_date'] + '</td>';
					str += '<td>' + results[x]['shift'] + '</td>';
					str += '<td>' + results[x]['line_code'] + '</td>';
					str += '<td>' + results[x]['qty'] + '</td>';	
					str += '<td>' + results[x]['hr1'] + '</td>';	
					str += '<td>' + results[x]['hr2'] + '</td>';	
					str += '<td>' + results[x]['hr3'] + '</td>';	
					str += '<td>' + results[x]['hr4'] + '</td>';	
					str += '<td>' + results[x]['hr5'] + '</td>';	
					str += '<td>' + results[x]['hr6'] + '</td>';	
					str += '<td>' + results[x]['hr7'] + '</td>';	
					str += '<td>' + results[x]['hr8'] + '</td>';	
					str += '<td>' + results[x]['hr9'] + '</td>';	
					str += '<td>' + results[x]['hr10'] + '</td>';	
					str += '<td>' + results[x]['hr11'] + '</td>';	
					str += '<td>' + results[x]['hr12'] + '</td>';	
					str += '</tr>';

				}

				for (var i = 0; i < results2.length; i++) {
					qty+=parseInt(results2[i]['qty']) ;
					str2 += '<tr>';
					str2 += '<td>' + results2[i]['scan_date'] + '</td>';
					str2 += '<td>' + results2[i]['shift'] + '</td>';
					str2 += '<td>' + results2[i]['line_code'] + '</td>';
					str2 += '<td>' + results2[i]['qty'] + '</td>';
					str2 += '<td>' + results2[i]['hr1'] + '</td>';	
					str2 += '<td>' + results2[i]['hr2'] + '</td>';	
					str2 += '<td>' + results2[i]['hr3'] + '</td>';	
					str2 += '<td>' + results2[i]['hr4'] + '</td>';	
					str2 += '<td>' + results2[i]['hr5'] + '</td>';	
					str2 += '<td>' + results2[i]['hr6'] + '</td>';	
					str2 += '<td>' + results2[i]['hr7'] + '</td>';	
					str2 += '<td>' + results2[i]['hr8'] + '</td>';	
					str2 += '<td>' + results2[i]['hr9'] + '</td>';	
					str2 += '<td>' + results2[i]['hr10'] + '</td>';	
					str2 += '<td>' + results2[i]['hr11'] + '</td>';	
					str2 += '<td>' + results2[i]['hr12'] + '</td>';	
					str2 += '</tr>';

				}
				console.log(str)
				//alert(str)

				$('#order_table tbody').html(str);
				$('#order_table_2 tbody').html(str2);

			},

			error: function (err) {

				console.log(err);

			}

		});

	});


});
