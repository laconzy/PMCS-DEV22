$(document).ready(function () {


	$('#btn_search').click(function () {
		var style_id = $('#style').val().trim();
		var color_id = $('#color').val().trim();
		var size_id = $('#size').val().trim();

		// if(order_id == null || order_id == ''){
		// 	appAlertError('Please select order id');
		// 	return;
		// }

		$('#btn_search_i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_fg_stock_data',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'style_id': style_id,
					'color_id' : color_id,
					'size_id' : size_id
				},
				success: function (res) {
					var results = res.data;
					var str = '';
					var qty = 0;
					for (var x = 0; x < results.length; x++) {
						str += '<tr>';
						str += '<td>' + results[x]['style_code'] + '</td>';
						str += '<td>' + results[x]['color_code'] + '</td>';
						str += '<td>' + results[x]['customer_po'] + '</td>';
						str += '<td>' + results[x]['order_id'] + '</td>';
						str += '<td>' + results[x]['size_code'] + '</td>';
						str += '<td>' + format_data(results[x]['total_qty']) + '</td>';
						str += '</tr>';
					}

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








	function format_data(_data){
		if(_data == undefined || _data == null){
			return '';
		}
		else {
			return _data;
		}
	}

});

function ExportToExcel(type, fn, dl) {
	var elt = document.getElementById('order_table');
	var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
	return dl ?
			XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
			XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
}
