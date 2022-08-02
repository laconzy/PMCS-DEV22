<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Line In Reports</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->


	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css" />

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


	<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">SCAN HISTORY</h4>


	<div class="col-md-12" style="margin-bottom:20px">






	</div>

	<div class="col-md-12" style="margin-bottom:20px">


		<div class="col-md-3">

			<input type=button value="Copy to Clipboard" class="btn-success btn-sm" onClick="copytable('order_table')" id="btn_copy">

			<!-- <input type="text" class="form-control input-sm" id="barcode"> -->

		</div>
		<div class="col-md-3">

			<label>Order ID</label>

			<input type="text" class="form-control input-sm " id="cut_plan">

		</div>

		<div class="col-md-3">

			<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>

		</div>

	</div>


	<div class="col-md-12" style="overflow: scroll;height: 500px;">

<?php
//print_r($order);
?>
		<table id="order_table" class="table table-striped table-bordered table-hover;" width="100%">

			<thead>

			<tr>
				<th>Order Code</th>
				<th>PO Issue Date</th>
				<th>Status</th>
				<th>PO</th>
				<th>Color</th>
				<th>Style</th>
				<th>C/O</th>
				<th>Order Qty in DZ</th>
				<th>QTY in pCS</th>
				<th>Ship Mode</th>
				<th>SanMar's Requested/Recap Ship Date</th>
				<th>DTRT Confirmed Ship Date</th>
				<th>DTRT Confirmed Ship Date vs SanMar Requestd Ship Date</th>
				<th>Last week's confirmed ex-factory date</th>
				<th>This week's confirmed ex-factory date</th>
				<th>Week Over Week Change x-frty</th>
				<th>DTRT Allocated Ship Date vs. This Weeks Confirmed X-Frty  Date</th>
				<th>DTRT This Week Confirmed Ship Date vs SanMar Orig Requested Date</th>
				<th>"ContainerRef #"</th>
				<th>XS</th>
				<th>S</th>
				<th>M</th>
				<th>L</th>
				<th>XL</th>
				<th>2X</th>
				<th>XXL</th>
				<th>3X</th>
				<th>4X</th>
				<th>Update/New</th>
				<th>COMMENT</th>
				<th>TOTAL cbm for PO</th>
				<th>Total est cbm to be shipped</th>
				<th>Body Fabric Plan In hse date & Actual  In hse date</th>
				<th>"F/K Collar Plan In hse date & Actual  In hse date 
				(for ST640, ST641, YST640 only)"</th>
				<th>Plan / Actual Cut Date</th>
				<th>Plan / Actual Sewn Date</th>
				<th>Plan / Actual Pack Date</th>
				<th>Cut Qty (Dz)</th>
				<th>Sewn Qty (Dz)</th>
				<th>Packed Qty (Dz)</th>
				<th>no. of production line</th>
				<th>"Total Daily Output (Pcs) 
				(All Lines)"</th>
				<th>Plan / Actual Final Inspection Date Offer to SMQA</th>

			</tr>

			</thead>

			<tbody>

				<?php
foreach ($order as $row) {
$size_arr = array("1", "2", "3","4", "5", "6","36","37");


?>

<tr>
<td><?= $row['order_code'] ?></td>
<td></td>
<td>original PO qty</td>
<td><?= $row['customer_po'] ?></td>
<td><?= $row['color_code'] ?></td>
<td><?= $row['style_code'] ?></td>
<td>Ghana</td>
<td><?= round($row['order_qty']/12) ?></td>
<td><?= $row['order_qty'] ?></td>
<td>SEA</td>
<td><?= $row['delivary_date'] ?></td>
<td><?= $row['delivary_date'] ?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<?php
for ($i=0; $i < sizeof($size_arr) ; $i++) { 
	$qty =$this->mss_model->get_size_ord_qty($row['order_id'],$size_arr[$i]);

	echo '<td>'.$qty.'</td>';
}

?>

<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><?= $row['cut_qty'] ?></td>
<td><?= $row['saw_qty'] ?></td>
<td><?= $row['saw_qty'] ?></td>
<td></td>
<td></td>
<td></td>
</tr>
<?php

$results2 =$this->mss_model->shipment_data($row['order_id']);
foreach ($results2 as $row2) {
	# code...

?>

<tr>
<td><?= $row['order_code'] ?></td>
<td></td>
<td>shipped</td>
<td><?= $row['customer_po'] ?></td>
<td><?= $row['color_code'] ?></td>
<td><?= $row['style_code'] ?></td>
<td>Ghana</td>
<td><?= round($row['ship_qty']/12) ?></td>
<td><?= $row['ship_qty'] ?></td>
<td>SEA</td>
<td><?= $row['delivary_date'] ?></td>
<td><?= $row['delivary_date'] ?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><?= $row2['container'] ?></td>
<?php
for ($i=0; $i < sizeof($size_arr) ; $i++) { 
	$qty =$this->mss_model->shipment_size_data($row2['order_id'],$row2['container'],$size_arr[$i]);
	echo '<td>'.$qty.'</td>';
}

?>

<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><?= $row['ship_qty'] ?></td>
<td><?= $row['ship_qty'] ?></td>
<td><?= $row['ship_qty'] ?></td>
<td></td>
<td></td>
<td></td>
</tr>



<?php
}
?>
<tr>
<td><?= $row['order_code'] ?></td>
<td></td>
<td>need to ship</td>
<td><?= $row['customer_po'] ?></td>
<td><?= $row['color_code'] ?></td>
<td><?= $row['style_code'] ?></td>
<td>Ghana</td>
<td><?= round(($row['order_qty']-$row['ship_qty'])/12) ?></td>
<td><?= ($row['order_qty']-$row['ship_qty']) ?></td>
<td>SEA</td>
<td><?= $row['delivary_date'] ?></td>
<td><?= $row['delivary_date'] ?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<?php
for ($i=0; $i < sizeof($size_arr) ; $i++) { 
	$qty =$this->mss_model->balance_qty($row['order_id'],$size_arr[$i]);
	echo '<td>'.$qty.'</td>';
}

?>

<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><?= $row['cut_qty']-$row['ship_qty'] ?></td>
<td><?= $row['saw_qty']-$row['ship_qty'] ?></td>
<td><?= $row['saw_qty']-$row['ship_qty'] ?></td>
<td></td>
<td></td>
<td></td>
</tr>

<?php
}
//}

?>







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
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script>

<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>

<!-- page js file -->

<script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script>

<script src="<?php echo base_url(); ?>assets/application/app.js"></script>


<script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

<!-- jquery form validator plugin -->

<script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/views/report/mss.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>


</body>

<script type="text/javascript">

function copytable(el) {
    var urlField = document.getElementById(el)   
    var range = document.createRange()
    range.selectNode(urlField)
    window.getSelection().addRange(range) 
    document.execCommand('copy')

}


</script>

</html>

