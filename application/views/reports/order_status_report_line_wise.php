<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Line Wise Order Status Report</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<!-- bootstrap datepicker -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/>-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>
	<!-- datatables -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/loadingModel/css/jquery.loadingModal.min.css">
</head>
<body>

<!-- Site wrapper -->
<!-- =============================================== -->
<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">
<div>
	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">ORDER STATUS REPORT - LINE WISE</h4>
	<div class="col-md-12" style="margin-bottom:20px">
		<div class="col-md-2">
			<label>Customer</label>
			<select type="text" class="form-control input-sm" id="customer">
				<option value="">-- Select Customer --</option>
				<?php foreach ($customers as $row) { ?>
					<option value="<?= $row['id'] ?>"><?= $row['cus_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Style</label>
			<select type="text" class="form-control input-sm" id="style">
				<option value="">-- Select Style --</option>
				<?php foreach ($styles as $row) { ?>
					<option value="<?= $row['style_id'] ?>"><?= $row['style_code'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2">
			<label>Customer PO</label>
			<input type="text" class="form-control input-sm" id="customer_po" value="">
		</div>
		<div class="col-md-2">
			<label>Color</label>
			<input type="text" class="form-control input-sm" id="color" value="">
		</div>
		<div class="col-md-1">
			<label>Size</label>
			<input type="text" class="form-control input-sm" id="size">
		</div>
		<div class="col-md-1">
			<button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_search">Search</button>
		</div>
		<div class="col-md-2">
			<button class="btn btn-success btn-sm" style="margin-top:20px" onclick="ExportToExcel('xlsx')">Export table to excel</button>
		</div>
	</div>

	<div class="col-md-12">
		<table id="data_table" class="display nowrap cell-border compact" cellspacing="0" width="100%">
			<thead style="background-color:#F5F5F5">
			<tr>
				<th>Order Id</th>
				<th>Order Code</th>
				<th>Delivery Date</th>
				<th>Syle</th>
				<th>Customer</th>
				<th>Customer PO</th>
				<th>Color</th>
				<th>Line No</th>
				<th>Size</th>
				<th>Order Qty</th>
				<th>Plan Qty</th>
				<th>Cut Qty</th>
				<th>Cut Out</th>
				<th>WIP</th>
				<!-- <th>PREP.</th> -->
				<!-- <th>SM IN</th>
				<th>WIP</th>
				<th>SM Out</th>
				<th>WIP</th> -->
				<th>Line IN</th>
				<th>Line Out</th>
				<th>WIP</th>
				<!-- <th>REJECT</th>
				<th>FG</th>
				<th>Transfered</th>
				<th>Shipped</th>
				<th>WIP</th> -->
			</tr>
			</thead>
			<tfoot>
			</tfoot>
		</table>
	</div>

	<div class="col-md-12" style="display:none">
		<table id="excel_table" class="display nowrap cell-border compact" cellspacing="0" width="100%">
			<thead style="background-color:#F5F5F5">
			<tr>
				<th>Order Id</th>
				<th>Order Code</th>
				<th>Delivery Date</th>
				<th>Syle</th>
				<th>Customer</th>
				<th>Customer PO</th>
				<th>Color</th>
				<th>Line No</th>
				<th>Size</th>
				<th>Order Qty</th>
				<th>Plan Qty</th>
				<th>Cut Qty</th>
				<th>Cut Out</th>
				<th>WIP</th>
				<!-- <th>PREP.</th> -->
				<!-- <th>SM IN</th>
				<th>WIP</th>
				<th>SM Out</th>
				<th>WIP</th> -->
				<th>Line IN</th>
				<th>Line Out</th>
				<th>WIP</th>
				<!-- <th>REJECT</th>
				<th>FG</th>
				<th>Transfered</th>
				<th>Shipped</th>
				<th>WIP</th> -->
			</tr>
			</thead>
			<tbody></tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>


</div>
</div>
</div>


<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>-->
<!-- <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script> -->
<!-- page js file -->
<!-- <script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script> -->
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script
<!-- jquery form validator plugin -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>
<!-- datatables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/loadingModel/js/jquery.loadingModal.min.js" type="text/javascript"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';
	var TABLE = null;
	var DATASET = [];

	$(document).ready(function () {

		$('#data_table thead tr')
			.clone(true)
			.addClass('filters')
			.appendTo('#data_table thead');

		init_table();



		$('#btn_search').click(function () {

			$('body').loadingModal({
		  position: 'auto',
		  text: '',
		  color: '#fff',
		  opacity: '0.5',
		  backgroundColor: 'rgb(0,0,0)',
		  animation: 'cubeGrid'
		});

			var customer = ($('#customer').val() == '') ? 0 : $('#customer').val();
			var style = ($('#style').val() == '') ? 0 : $('#style').val();
			var customer_po = ($('#customer_po').val().trim() == '') ? 'NO' : $('#customer_po').val().trim();
			var color = ($('#color').val().trim() == '') ? 'NO' : $('#color').val().trim();
			var size = ($('#size').val().trim() == '') ? 'NO' : $('#size').val().trim();

			appAjaxRequest({
				url: BASE_URL + 'index.php/report/order_status_report_line_wise_data',
				type: 'GET',
				dataType: 'json',
				//async: false,
				data: {
					'customer': customer,
					'style': style,
					'customer_po' : customer_po,
					'color' : color,
					'size' : size
				},
				success: function (res) {
					if(res.data != null){
						DATASET = res.data;
						//TABLE.destroy();
						//TABLE = null;
						init_table();
						$('body').loadingModal('destroy');
					}
				}
			});
		});

	$("#btn_export").click(
        function () {
            tableToExcel('data_table','test','Order Status Size Wise');
        }
    );


	});

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

  function ExportToExcel(type, fn, dl) {
		if(DATASET != null && DATASET.length > 0){
			//load data to hidden table
			let str = '';
			for(let x = 0 ; x < DATASET.length ; x++){
				let cut_qty = DATASET[x]['cut_qty'] == null ? 0 : parseInt(DATASET[x]['cut_qty']);
				let cut_out = DATASET[x]['CUTTING_OUT'] == null ? 0 : parseInt(DATASET[x]['CUTTING_OUT']);
				let supermarket_in = DATASET[x]['SUPERMARKET_IN'] == null ? 0 : parseInt(DATASET[x]['SUPERMARKET_IN']);
				let supermarket_out = DATASET[x]['SUPERMARKET_OUT'] == null ? 0 : parseInt(DATASET[x]['SUPERMARKET_OUT']);
				let line_in = DATASET[x]['LINE_IN'] == null ? 0 : parseInt(DATASET[x]['LINE_IN']);
				let line_out = DATASET[x]['LINE_OUT'] == null ? 0 : parseInt(DATASET[x]['LINE_OUT']);
				let ship_qty = DATASET[x]['ship_qty'] == null ? 0 : parseInt(DATASET[x]['ship_qty']);
				let fg_qty = DATASET[x]['fg_qty'] == null ? 0 : parseInt(DATASET[x]['fg_qty']);

				str += `<tr>
				<td>${DATASET[x]['order_id']}</td>
				<td>${DATASET[x]['order_code']}</td>
				<td>${DATASET[x]['delivary_date']}</td>
				<td>${DATASET[x]['style_code']}</td>
				<td>${DATASET[x]['cus_name']}</td>
				<td>${DATASET[x]['customer_po']}</td>
				<td>${DATASET[x]['color_code']}</td>
				<td>${DATASET[x]['line_code']}</td>
				<td>${DATASET[x]['size_code']}</td>
				<td>${DATASET[x]['s_ord_qty']}</td>
				<td>${DATASET[x]['s_plan_qty']}</td>
				<td>${cut_qty}</td>
				<td>${cut_out}</td>
				<td>${cut_qty - cut_out}</td>
				<td>${line_in}</td>
				<td>${line_out}</td>
				<td>${line_in - line_out}</td>
				</tr>`;
			}
			$('#excel_table tbody').html(str);

			var elt = document.getElementById('excel_table');
			var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
			return dl ?
					XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
					XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
		}
  }


	function init_table(){

		var columns = [
      { "data": "order_id"},
      { "data": "order_code" },
      { "data": "delivary_date" },
      { "data": "style_code" },
      { "data": "cus_name" },
      { "data": "customer_po" },
      { "data": "color_code" },
			{ "data": "line_code" },
			{ "data": "size_code" },
			{ "data": "s_ord_qty" },
			{ "data": "s_plan_qty" },
			{ "data": "cut_qty" },
			{ "data": "CUTTING_OUT" },
			{
				data: "order_id",
				render : function(data, type, full, meta ){
					let cut_qty = full['cut_qty'] == null ? 0 : parseInt(full['cut_qty']);
					let cut_out = full['CUTTING_OUT'] == null ? 0 : parseInt(full['CUTTING_OUT']);
					let str = `<span style="color:red">${cut_qty - cut_out}</span>`;
          return str;
				}
			},
			// { "data": "PREPARATION" },
			// { "data": "SUPERMARKET_IN", width:'1%' },
			// {
			// 	data: "order_id",
			// 	render : function(data, type, full, meta ){
			// 		let supermarket_in = full['SUPERMARKET_IN'] == null ? 0 : parseInt(full['SUPERMARKET_IN']);
			// 		let cut_out = full['CUTTING_OUT'] == null ? 0 : parseInt(full['CUTTING_OUT']);
			// 		let str = `<span style="color:red">${cut_out - supermarket_in}</span>`;
      //     return str;
			// 	}
			// },
			// { "data": "SUPERMARKET_OUT" },
			// {
			// 	data: "order_id",
			// 	render : function(data, type, full, meta ){
			// 		let supermarket_in = full['SUPERMARKET_IN'] == null ? 0 : parseInt(full['SUPERMARKET_IN']);
			// 		let supermarket_out = full['SUPERMARKET_OUT'] == null ? 0 : parseInt(full['SUPERMARKET_OUT']);
			// 		let str = `<span style="color:red">${supermarket_in - supermarket_out}</span>`;
      //     return str;
			// 	}
			// },
			{ "data": "LINE_IN" },
			{ "data": "LINE_OUT" },
			{
				data: "order_id",
				render : function(data, type, full, meta ){
					let line_in = full['LINE_IN'] == null ? 0 : parseInt(full['LINE_IN']);
					let line_out = full['LINE_OUT'] == null ? 0 : parseInt(full['LINE_OUT']);
					let rej_qty = full['rej_qty'] == null ? 0 : parseInt(full['rej_qty']);
					let str = `<span style="color:red">${line_in - (line_out + rej_qty)}</span>`;
          return str;
				}
			},
			// { "data": "rej_qty" },
			// { "data": "fg_qty" },
			// { "data": "transfered_qty" },
			// {
			// 	data: "ship_qty",
			// 	render : function(data){
			// 		str = `<span>${data * -1}</span>`;
      //     return str;
			// 	}
			// },
			// {
			// 	data: "fg_wip_qty",
			// }
    ];

		if(TABLE == null){



			TABLE = $('#data_table').DataTable( {
				//orderCellsTop: true,
        fixedHeader: true,
	      "scrollY": "450px",
			  "scrollX": true,
			  "scrollCollapse": true,
	      "autowidth":false,
			    /*"fixedColumns": {
				     leftColumns: 1
			  },*/
				paging: false,
			  //"searching": false,
				"sort": false,
			  "select": true,
	      "data" : DATASET,
	      "columns": columns,
				dom: 'lrt'
	    });

			var api = $( '#data_table' ).dataTable().api();
			// For each column
			api.columns().eq(0)
			.each(function (colIdx) {
					// Set the header cell to contain the input element
					var cell = $('.filters th').eq(
							$(api.column(colIdx).header()).index()
					);
					var title = $(cell).text();
					$(cell).html('<input type="text" class="form-control input-sm" placeholder="" />');
					// On every keypress in this input
					$('input',$('.filters th').eq($(api.column(colIdx).header()).index()))
							.off('keyup change')
							.on('keyup change', function (e) {
									e.stopPropagation();

									// Get the search value
									$(this).attr('title', $(this).val());
									var regexr = '({search})'; //$(this).parents('th').find('select').val();

									var cursorPosition = this.selectionStart;
									//Search the column for that value
									$( '#data_table' ).dataTable().api().column(colIdx).search($(this).val()).draw();
									$(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
							});
			});
		}
		else {
			TABLE.clear().rows.add(DATASET).draw();
		}
	}


	function format_data(_data){
		if(_data == undefined || _data == null){
			return '';
		}
		else {
			return _data;
		}
	}

</script>


</body>

</html>
