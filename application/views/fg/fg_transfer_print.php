<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

</head>
<body>
<div class="container">

	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div style="text-align: center;">
				<h4 style="font-weight:bold">FG TRANSFER</h4>
				<hr>

			</div>
			<table style="width:100%;font-family: Verdana, Geneva, sans-serif;font-size: 11px;">

				<tr style="height:20px">
					<td style="width:20%"><b>Transfer ID </b></td>
					<td style="width:30%"><b> : <?= $transfer_data['id'] ?></b></td>
					<td style="width:20%"><b>Date</b></td>
					<td style="width:30%"><b> : <?= $transfer_data['transfered_date'] ?></b></td>
				</tr>
				<tr style="height:20px">
					<td style="width:20%"><b>From Order </b></td>
					<td style="width:30%"><b> : <?= $transfer_data['from_order_id'] ?></b></td>
					<td style="width:20%"><b>To Order </b></td>
					<td style="width:30%"><b> : <?= $transfer_data['to_order_id'] ?></b></td>
				</tr>
				<tr>
					<td style="width:20%"><b>Transfered User</b></td>
					<td style="width:30%"><b> : <?= $transfer_data['first_name'] . ' ' . $transfer_data['last_name'] ?></b></td>
				</tr>
			</table>

			<table class="table table-bordered" style="font-size:10px;margin-top:15px">
				<thead>
					<tr>
						<th>Size</th>
						<th>Qty</th>
					</tr>
				</thead>
				<tbody>
		    <?php foreach ($transfer_details as $row) {	?>
				<tr>
					<td><?php echo $row['size_code'];?></td>
					<td><?php echo $row['qty'];?></td>
				</tr>
				<?php } ?>
			</tbody>
			</table>


			<table style="width:100%;font-size:12px">
				<tr style="height:25px">
					<td style="width:20%">Printed By</td>
					<td style="width:40%"><?php echo $printed_by; ?></td>
					<td style="width:10%"></td>
					<td style="width:30%">Checked by</td>
					<td style="width:40%">................................................</td>
				</tr>
				<tr style="height:25px">
					<td style="width:30%">Printed Date</td>
					<td style="width:20%"><?php echo $printed_date; ?></td>
					<td style="width:10%"></td>
					<td style="width:30%">Date</td>
					<td style="width:20%">................................................</td>
				</tr>
			</table>

		</div>
	</div>
</div>

<script>

	//window.print();

</script>

</body>

</html>
