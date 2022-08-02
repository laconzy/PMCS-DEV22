<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Add/Edit GRN</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->


	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>


	<!-- App styles -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">


	<link href="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.css" rel="stylesheet"/>


</head>

<body>

<!-- Site wrapper -->


<!-- =============================================== -->

<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">


<div>


	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">ORDER STATUS REPORT</h4>


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

			<input type="text" class="form-control input-sm" id="customer_po" value="<?php echo $cpo;?>">

		</div>
		<div class="col-md-2">

			<label>Color</label>

			<input type="text" class="form-control input-sm" id="color" value="<?php echo urldecode($color);?>">

		</div>
		<div class="col-md-1">

			<label>Size</label>

			<input type="text" class="form-control input-sm" id="size">

		</div>

		<div class="col-md-2">

			<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>

		</div>

		<div class="col-md-2">

			
			<button onclick="ExportToExcel('xlsx')">Export table to excel</button>

		</div>


	</div>

	<!--<div class="col-md-12" style="margin-bottom:20px">

	  <div class="col-md-3">

		  <label>Delivery From</label>

		  <input  type="text" class="form-control input-sm" value="2018-08-01">

	  </div>

	  <div class="col-md-3">

		  <label>Delivery To</label>

		  <input type="text" class="form-control input-sm" value="2018-10-01">

	  </div>

	  <div class="col-md-3">

		  <button class="btn btn-primary" style="margin-top:20px">Search</button>

	  </div>

	</div>-->


	<div class="col-md-12" style="overflow: scroll;">


		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%"
			   style="font-family: Verdana, Geneva, sans-serif;font-size: 10px;">

			<thead>

			<tr style="height: 20px;text-align: center;">

				<!--<th>Progress</th>-->

				<th width="5%">Order Id</th>
				<th width="30%">Order Code</th>
				<th width="10%">Delivery Date</th>
				<th width="5%">Syle</th>
				<th width="5%">Customer</th>
				<th width="5%">Customer PO</th>
				<th width="10%">Color</th>
				<th width="3%">Size</th>
				<th width="5%">Order Qty</th>
				<th width="5%">Plan Qty</th>
				<th width="5%">Cut Qty</th>

				<?php 
$wip="";
				foreach ($operations as $key => $value) { ?>

					<th><?= $value ?></th>
					<th>WIP</th>
					

				<?php } ?>
				<th>FG</th>
				<th>Shipped</th>
			</tr>

			</thead>

			<tbody>

			<?php foreach ($data as $row) { ?>


				<tr style="height: 10px;">


					<td><?= $row['order_id'] ?></td>

					<td><?= $row['order_code'] ?></td>

					<td><?= $row['delivary_date'] ?></td>

					<td><?= $row['style_code'] ?></td>

					<td><?= $row['cus_name'] ?></td>

					<td><?= $row['customer_po'] ?></td>

					<td><?= $row['color_code'] ?></td>
					<td><?= $row['size_code'] ?></td>
					<td style="text-align: right;"><?= $row['s_ord_qty'] ?></td>
					<td style="text-align: right;"><?= $row['s_plan_qty'] ?></td>

					<td style="text-align: right;"><?= $row['cut_qty'] ?></td>


					<?php 
					$wip=$row['cut_qty'] ;
					foreach ($operations as $key => $value) {

						$qty = isset($row['operations'][$key]) ? $row['operations'][$key] : 0;
					$variance = $wip-$qty;
					$color ="";
					if($variance > 0){
						$color ='color:red';
					}

						?>

						<td style="text-align: right;"><?= $qty ?></td>
						<td style="<?php echo $color ;?>;text-align: right;"><?= $variance ?></td>

					<?php

$wip=$qty;
					 } ?>
			<td style="text-align: right;"><?= $row['fg_qty'] ?></td>
			<td style="text-align: right;"><?= ($row['ship_qty']*-1); ?></td>
				</tr>


			<?php } ?>


			</tbody>

		</table>

	</div>


</div>

</div>


</div>


<!-- jQuery 2.1.4 -->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Bootstrap 3.3.5 -->

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>


<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

<!-- page js file -->

<script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script>

<script src="<?php echo base_url(); ?>assets/application/app.js"></script>


<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

<!-- jquery form validator plugin -->

<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/	xlsx@0.15.1/dist/xlsx.full.min.js"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';


	$(document).ready(function () {


		$('#btn_search').click(function () {

			var customer = ($('#customer').val() == '') ? 0 : $('#customer').val();

			var style = ($('#style').val() == '') ? 0 : $('#style').val();

			var customer_po = ($('#customer_po').val().trim() == '') ? 'NO' : $('#customer_po').val().trim();
			var color = ($('#color').val().trim() == '') ? 'NO' : $('#color').val().trim();
			var size = ($('#size').val().trim() == '') ? 'NO' : $('#size').val().trim();

			var url = 'index.php/report/order_status_report_s/' + customer + '/' + style + '/' + encodeURI(customer_po) + '/' + color+ '/' + size;

			window.open(BASE_URL + url, '_self');

		});

	$("#btn_export").click(
            function () {
                tableToExcel('order_table','test','Order Status Size Wise');
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
            var elt = document.getElementById('order_table');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
        }

</script>


</body>

</html>

