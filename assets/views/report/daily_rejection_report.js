$(document).ready(function () {

	$('#from_date,#to_date').datepicker({
			format: "yyyy-mm-dd",
			viewMode: "days",
			minViewMode: "days"
	});


	$('#btn_search').click(function () {
		var from_date = $('#from_date').val().trim();
		var to_date = $('#to_date').val().trim();

		if(from_date == null || from_date == '' || to_date == null || to_date == ''){
			iziToast.error({title: '',	message: 'Please select date range', position : 'topRight' });
			return;
		}

		$('#btn_search_i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_daily_redjection_data',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'from_date': from_date,
					'to_date' : to_date
				},
				success: function (res) {
					var results = res.data;
					var sizes = res.sizes;

					var str_th = `<tr>
					<th>DATE</th>
					<th>LINE</th>
					<th>PO</th>
					<th>STYLE</th>
					<th>COLOR</th>
					<th>REJECT TYPE</th>`;

					for(var x = 0 ; x < sizes.length ; x++){
						str_th += `<th>${sizes[x]['size_code']}</th>`;
					}

					str_th += `<th>TOTAL REJECTIONS</th>
					<th>DAILY OUTPUT</th>
					<th>PERCENTA GES</th>
					</tr>`;

					$('#data_table thead').html(str_th);


					var str = '';
					var qty = 0;
					var final_total_rjections = 0;
					var final_daily_output = 0;

					var previous_scan_date = null;
					var previous_line_code = null;
					var previous_customer_po = null;
					var previous_style_code = null;
					var previous_color_code = null;

					for (var x = 0; x < results.length; x++) {
						str += `<tr>
							<td>${results[x]['scan_date']}</td>
							<td>${results[x]['line_code']}</td>
							<td>${results[x]['customer_po']}</td>
							<td>${results[x]['style_code']}</td>
							<td>${results[x]['color_code']}</td>
							<td>${results[x]['rejection_name']}</td>`;

						let total_rejections = 0;
						for(var y = 0 ; y < sizes.length ; y++){
							var indexKey = 'size' + sizes[y].size;
							str += `<td style="text-align:center">${format_data(results[x][indexKey])}</td>`;

							let size_qty = (results[x][indexKey] == null) ? 0 : parseInt(results[x][indexKey]);
							if(sizes[y]['total_qty'] == undefined || sizes[y]['total_qty'] == null){
								sizes[y]['total_qty'] = 0;
							}
							sizes[y]['total_qty'] += size_qty;
							total_rejections += size_qty;
						}

						let daily_output = results[x]['daily_output'] == null ? 0 : parseInt(results[x]['daily_output']);
						let percenta = 0;
						if(daily_output > 0){
							percenta = (total_rejections / daily_output) * 100;
							percenta = Math.round((percenta + Number.EPSILON) * 100) / 100;//round number
						}

						final_total_rjections += total_rejections;

						if(previous_scan_date != results[x]['scan_date'] || previous_line_code != results[x]['line_code'] || previous_customer_po != results[x]['customer_po'] ||
								previous_style_code != results[x]['style_code'] || previous_color_code != results[x]['color_code']){
									final_daily_output += daily_output;
						}

						previous_scan_date = results[x]['scan_date'];
						previous_line_code = results[x]['line_code'];
						previous_customer_po = results[x]['customer_po'];
						previous_style_code = results[x]['style_code'];
						previous_color_code = results[x]['color_code'];

						str += `<td style="text-align:right">${total_rejections}</td>
							<td style="text-align:right">${format_data(results[x]['daily_output'])}</td>
							<td style="text-align:right">${format_data(percenta)}${percenta == 0 ? '' : '%'}</td>
							</tr>`;
					}

					str += `<td colspan="6">Total</td>`;
					for(var y = 0 ; y < sizes.length ; y++){
						str += `<td>${sizes[y]['total_qty']}</td>`;
					}
					str += `<td style="text-align:right">${final_total_rjections}</td>
					<td style="text-align:right">${final_daily_output}</td>
					<td></td>`;

					$('#data_table tbody').html(str);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				},
				error: function (err) {
					console.log(err);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				}
			});
		}, 200);
	});


	$('#btn_export').click(function(){
		ExportToExcel('xlsx');
	});


	function ExportToExcel(type, fn, dl) {
			var elt = document.getElementById('data_table');
			var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
			return dl ?
					XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
					XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
		}


		function getIEVersion()
		// Returns the version of Windows Internet Explorer or a -1
		// (indicating the use of another browser).
		{
		    var rv = -1; // Return value assumes failure.
		    if (navigator.appName == 'Microsoft Internet Explorer') {
		        var ua = navigator.userAgent;
		        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		        if (re.exec(ua) != null)
		            rv = parseFloat(RegExp.$1);
		    }
		    return rv;
		}

		function tableToExcel(table, sheetName, fileName) {
		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE ");
		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        return fnExcelReport(table, fileName);
		    }

		    var uri = 'data:application/vnd.ms-excel;base64,',
		        templateData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
		        base64Conversion = function (s) { return window.btoa(unescape(encodeURIComponent(s))) },
		        formatExcelData = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

		    $("tbody > tr[data-level='0']").show();

		    if (!table.nodeType)
		        table = document.getElementById(table)

		    var ctx = { worksheet: sheetName || 'Worksheet', table: table.innerHTML }

		    var element = document.createElement('a');
		    element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' + base64Conversion(formatExcelData(templateData, ctx)));
		    element.setAttribute('download', fileName);
		    element.style.display = 'none';
		    document.body.appendChild(element);
		    element.click();
		    document.body.removeChild(element);

		    $("tbody > tr[data-level='0']").hide();
		}

		function fnExcelReport(table, fileName) {
	    var tab_text = "<table border='2px'>";
	    var textRange;
	    if (!table.nodeType)
	        table = document.getElementById(table)

	    $("tbody > tr[data-level='0']").show();
	    tab_text =  tab_text + table.innerHTML;

	    tab_text = tab_text + "</table>";
	    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
	    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
	    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

	    txtArea1.document.open("txt/html", "replace");
	    txtArea1.document.write(tab_text);
	    txtArea1.document.close();
	    txtArea1.focus();
	    sa = txtArea1.document.execCommand("SaveAs", false, fileName + ".xlsx");
	    $("tbody > tr[data-level='0']").hide();
	    return (sa);
		}


	function format_data(_data){
		if(_data == undefined || _data == null || _data == 0){
			return '';
		}
		else {
			return _data;
		}
	}

});
