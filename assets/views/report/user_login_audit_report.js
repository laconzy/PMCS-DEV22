$(document).ready(function () {

	$('#selected_date').datepicker({
			format: "yyyy-mm-dd",
			viewMode: "days",
			minViewMode: "days"
	});


	$('#btn_search').click(function () {
		var selected_date = $('#selected_date').val().trim();
		var report_type = $('#report_type').val();

		if(selected_date == null || selected_date == ''){
			appAlertError('Please select date');
			return;
		}

		if(report_type == 'summery'){
			load_summery_report(selected_date);
		}
		else {
			load_details_report(selected_date);
		}
	});


	$("#btn_export").click(
        function () {
            tableToExcel('data_table','details','user_login_audit');
        }
    );


	function load_summery_report(selected_date){
		$('#btn_search_i').addClass('fa fa-spinner fa-spin');
		//set table headers
		let str_head = `<tr>
				<th>User ID</th>
				<th>User Name</th>
				<th>Full Name</th>
				<th>Last Login Timestamp</th>
				<th>Login Count</th>
			</tr>`;
			$('#data_table thead').html(str_head);

		setTimeout(function(){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_user_login_audit_summery',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'selected_date': selected_date
				},
				success: function (res) {
					var results = res.data;
					var str = '';
					var qty = 0;
					for (var x = 0; x < results.length; x++) {
						str += '<tr>';
						str += '<td>' + results[x]['user_id'] + '</td>';
						str += '<td>' + results[x]['user_name'] +'</td>';
						str += '<td>' + results[x]['first_name'] + ' ' + results[x]['last_name'] + '</td>';
						str += '<td>' + results[x]['last_timestamp'] + '</td>';
						str += '<td>' + results[x]['login_count'] + '</td>';
						str += '</tr>';
					}
					$('#data_table tbody').html(str);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				},
				error: function (err) {
					console.log(err);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				}
			});
		}, 200);
	}


	function load_details_report(selected_date){
		$('#btn_search_i').addClass('fa fa-spinner fa-spin');
		let str_head = `<tr>
				<th>User ID</th>
				<th>Full Name</th>
				<th>Department</th>
				<th>Timestamp</th>
			</tr>`;
			$('#data_table thead').html(str_head);

		setTimeout(function(){
			appAjaxRequest({
				url: BASE_URL + 'index.php/report/get_user_login_audit_details',
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					'selected_date': selected_date
				},
				success: function (res) {
					var results = res.data;
					var str = '';
					var qty = 0;
					for (var x = 0; x < results.length; x++) {
						str += '<tr>';
						str += '<td>' + results[x]['user_id'] + '</td>';
						str += '<td>' + results[x]['first_name'] + ' ' + results[x]['last_name'] + '</td>';
						str += '<td>' + results[x]['dep_name'] + '</td>';
						str += '<td>' + results[x]['login_timestamp'] + '</td>';
						str += '</tr>';
					}
					$('#data_table tbody').html(str);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				},
				error: function (err) {
					console.log(err);
					$('#btn_search_i').removeClass('fa fa-spinner fa-spin');
				}
			});
		}, 200);
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
		if(_data == undefined || _data == null){
			return '';
		}
		else {
			return _data;
		}
	}

});
