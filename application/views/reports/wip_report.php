<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | WIP Reports</title>

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


	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">WIP</h4>


	<div class="col-md-12" style="margin-bottom:20px">

		<div class="col-md-3">

			<label>Shift</label>

			<select class="form-control input-sm" id="shift">

				<option value="X">-- Select Shift --</option>
				<option value="A">- A -</option>
				<option value="B">- B -</option>

			</select>

		</div>

		<div class="col-md-3">

			<label>Building </label>

			<select type="text" class="form-control input-sm" id="building">

				<option value="X">-- Select Module --</option>
				<option value="A">- A -</option>
				<option value="B">- B -</option>
				<option value="C">- C -</option>

			</select>

		</div>

		<div class="col-md-3">

			<label>Operation</label>

			<select class="form-control input-sm" id="operations">

				<option value="0">... Select Location ...</option>
				<option value="cut">Cut WIP</option>
				<option value="cut_smv">Cutting to Super Market</option>
				<option value="sm">Super Market WIP</option>
				<option value="line">Line WIP</option>
				<option value="fg">FG WIP</option>

			</select>

		</div>
		<div class="col-md-3">

			<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>

		</div>


	</div>

	

	</div>

	<div class="col-md-12" style="margin-bottom:20px">

		<div class="col-md-3">

			<label>From Date</label>

			<input type="hidden" class="form-control input-sm date"  id="date_from">

		</div>

		<div class="col-md-3">

			<!-- <label>To Date</label> -->

			<input type="hidden" class="form-control input-sm date" id="date_to">

		</div>

		
	</div>
<div class="col-md-2">

			
			<button onclick="ExportToExcel('xlsx')">Export table to excel</button>

		</div>

	<div class="col-md-12">


		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%">

			<thead>

			<tr>

				<th>Order ID</th>
				<th>Order Code</th>
				<th>Syle</th>
				<th>Customer PO</th>
				<th>Color</th>
				<th>Buy</th>
				<th>Qty</th>
				<th>Location</th>
				<th>Action</th>


			</tr>

			</thead>

			<tbody>













			</tbody>

		</table>

	</div>


</div>

</div>




</div>

 <div class="modal fade" id="myModal3" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
              <h4 class="modal-title" style="color: red;">View</h4>
              <small class="font-bold" id="fail_order" style="color: red;font-weight: bold;font-size: 18px;"></small>
            </div>
            <div class="modal-body">
              <div class="col-md-12" style="overflow: scroll;">

                    <table class="table table-bordered" id="model_table">
                      <thead>
                        <tr>
                          
                          <th>Bundle No</th>                      
                          <th>Barcode</th>                    
                          <th>Size</th>                      
                          <th>QTY</th>                      
                          <th>Location</th>                      
                            </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
                    </table>
                  </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            
           <!--    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn_reject">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- jQuery 2.1.4 -->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Bootstrap 3.3.5 -->

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

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
<script src="<?php echo base_url(); ?>assets/views/report/wip_report.js"></script>
<script type="text/javascript" src="https://unpkg.com/	xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';



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

