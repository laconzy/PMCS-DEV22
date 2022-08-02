<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

</head>
<body style="display: block">
<div class="container" style="position: relative;">

	<div class="row">
		<div style="width:100%">
			<div style="width:100%">
				<table style="margin-top: 10px;width:100%" id="tst">
				</table>
			</div>
			<div style="text-align: center;">
				<h4 style="font-weight:bold">SHIPMENT RETURN NOTE</h4>
				<hr>
				<!-- <div style="width: 100%;background-color: ;">
					<table width="100%" style="font-size: 12px;font-family: Verdana, Geneva, sans-serif;">
						<tr style="height: 20px;text-align: left">
							<td width="20%"><img src="../../../assets/img/logo.png" width="50" height="35"
												 style="float:left;"></td>
							<td width="20%"></td>
						</tr>
						<tr style="height: 20px;text-align: left">
							<td width="20%" style="font-size: 10px;">DTRT APAPPAREL LTD</td>
							<td width="60%" colspan="2" style="text-align: left"></td>
							<td width="20%"></td>
						</tr>
					</table>
					<hr>
				</div> -->
			</div>
			<table style="width:100%;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">

				<tr>
					<td style="width:20%"><label><b>Style </b> </label></td>
					<td style="width:30%"><b> : <?php echo $data[0]['style_code']; ?></b></td>
					<td style="width:30%"><b>CPO #</b></td>
					<td style="width:30%"><b> : <?php echo $data[0]['customer_po']; ?></b></td>
				</tr>
				<!-- <tr>
					<td style="width:20%"><label><b>Color </b> </label></td>
					<td style="width:30%"><b> : <?php echo $data[0]['color_code']; ?></b></td>
					<td style="width:30%"><b>Ship QTY #</b></td>
					<td style="width:30%"><b> : <?php echo $total_ship_qty; ?></b></td>
				</tr>-->
				<!-- <tr>
					<td style="width:20%"><label><b>Order QTY </b> </label></td>
					<td style="width:30%"><b> : <?php echo $total_orders_qty; ?></b></td>
				</tr> -->
				<tr>
					<td><label> </label></td>
					<td></td>
					<td><label> </label></td>
				</tr>
				<tr>
					<td><label> </label></td>
					<td></td>
					<td><label> </label></td>
					<td></td>
				</tr>
			</table>

			<table class="table table-bordered" style="font-size:9px" id="gpp-items">
				<thead>
					<tr>
						<!-- <th colspan="2" rowspan="2">CARTON NUMBER FROM  -  TO</th> -->
						<th rowspan="2">Style No</th>
						<th rowspan="2">Color Name</th>
						<th rowspan="2">Color Code</th>
						<th colspan="<?php echo sizeof($sizes); ?>" style="text-align:center">SIZE (PIECES PER CARTON)</th>
						<!-- <th rowspan="2">Total PCS.</th>
						<th rowspan="2">Total CTN.</th>
						<th colspan="3" style="text-align:center">Total (kg)</th>
						<th rowspan="2">CBM</th>
						<th rowspan="2">Mesurement (cm)</th> -->
					</tr>
					<tr>

						<?php	foreach ($sizes as $row3) {	?>
						<th width="5%">
							<?php  echo $row3['size_code']; ?>
						</th>
					  <?php	}	?>
						<!-- <th width="5%">N.N.W</th>
						<th width="5%">N.W.</th>
						<th width="5%">G.W</th> -->
				</tr>
				</thead>
				<tbody>
		    <?php
					$i=1;
					foreach ($data as $row) {
					//	$size_data=$this->fg_model->get_size_data($row['order_id']);
				?>
				<tr>
					<!-- <td style="text-align: right"><?php echo $i;?></td>
					<td style="text-align: center"><?php echo $i+$row['ctn_qty']-1;;?></td> -->
					<?php  $i=$i+$row['ctn_qty'];?>
					<td><?php echo $row['style_code'];?></td>
					<td><?php echo $row['color_name'];?></td>
					<td><?php echo $row['color_code'];?></td>
					<?php
					foreach ($sizes as $row2) {
						if($row['size_id'] == $row2['size']){
							echo '<td>'. $row['return_qty'].'</td>';
						}
						else {
							echo '<td></td>';
						}
					}
					?>
					<!-- <td><?php echo $row['pcs_per_ctn']*$row['ctn_qty'];?></td>
					<td><?php echo $row['ctn_qty'];?></td>
					<td><?php  ?></td>
					<td><?php echo $row['weight_net']; ?></td>
					<td><?php ?></td>
					<td><?php ?></td>
					<td><?php ?></td> -->
				</tr>

						<?php
				}
						?>


				</tbody>

			</table>


			<table style="width:100%;font-size:12px">
				<tr style="height:25px">
					<td style="width:20%">Printed By</td>
					<td style="width:20%"><?php echo $printed_by; ?></td>
					<td style="width:40%"></td>
					<td style="width:20%">Checked by</td>
					<td style="width:20%">.....................................................................</td>
				</tr>
				<tr style="height:25px">
					<td style="width:20%">Printed Date</td>
					<td style="width:20%"><?php echo $printed_date; ?></td>
					<td style="width:40%"></td>
					<td style="width:20%">Date</td>
					<td style="width:20%">.....................................................................</td>
				</tr>
			</table>

			<!-- <table style="margin-top: 40px;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
				<tr>
					<td style="width:33%;text-align: center">
					</td>
					<td style="width:33%;text-align: center">
					</td>
					<td style="width:33%"></td>
				</tr>
				<tr>
					<td style="width:16%;">Printed By</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Checked by</td>
					<td style="width:16%;">......................</td>
				</tr>
				<tr>
					<td style="width:16%;">Printed Date</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;"> Date</td>
					<td style="width:16%;">......................</td>
				</tr>
			</table> -->
		</div>
	</div>
</div>

<script>

	//window.print();

</script>

</body>

</html>
