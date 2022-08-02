<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
	<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>

<style>

.td1 {
	border : 1px solid #ddd;
	padding : 3px;
	font-size : 11px;
}

#tbl1,#tbl2,#tbl3 {
	width: 100%;
}

#tbl1 tr {
	height: 20px;
}

#tbl2 tr {
	height: 20px;
}

#tbl3 tr {
	height: 20px;
}

#footer-content {
	width:100%;font-size:12px;margin-top:20px
}

#footer-content td{
	border-style: none !important;
	border-color : #FFF !important;
}

#footer-content tr {
	height:25px
}

#watermark {
	position: fixed;
	 top: 50%;
	left: 10%;
	z-index:999;
	font-size: 55px;
	color:red;
	opacity: 0.1;
	font-weight: 900;
	-ms-transform: rotate(-45deg); /* IE 9 */
  transform: rotate(-45deg);
}

</style>


</head>
<body>
<div class="container">

	<div class="row">

		<h4 style="font-weight:bold;text-align:center"><i class="fa fa-truck"></i> GENERAL GATE PASS - <?= $gp['id'] ?></h4>

		<div style="text-align:center">
		<table style="width:100%">
			<tr>
				<td width="30%"></td>
				<td style="width:20%">
					<img style="width:90%;" src="data:image/png;base64,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"/>
				</td>
				<td style="width:20%;text-align:left;">
					<h4 style="font-weight:bold">Dignity DTRT</h4>
					<img id="barcode"/>
				</td>
				<td width="30%"></td>
			</tr>
		</table>
	</div>

		<div class="row" style="margin-top:20px">
        <div class="col-sm-12">
          <table class="table">
            <tr>
              <th>Gate pass no</th>
              <td>: <?= $gp['id']; ?></td>
              <th>Gate pass type</th>
              <td>: <?= ucfirst($gp['type']); ?></td>
            </tr>
            <tr>
              <th>Gate pass to</th>
              <td>: <?= $gp['to_address']; ?></td>
              <th>REF / Style</th>
              <td>: <?= $gp['style']; ?></td>
            </tr>
            <tr>
              <th>Attention</th>
              <td>: <?= $gp['attention']; ?></td>
              <th>Through</th>
              <td>: <?= $gp['through']; ?></td>
            </tr>
            <tr>
              <th>Remarks</th>
              <td>: <?= $gp['remarks']; ?></td>
              <th>Instructed By</th>
              <td>: <?= $gp['instructed_by']; ?></td>
            </tr>
            <tr>
              <th>Date</th>
              <td>: <?= $gp['date']; ?></td>
              <th>Special Instruction</th>
              <td>: <?= $gp['special_instruction']; ?></td>
            </tr>
						<tr>
              <th>Return Status</th>
              <td>: <?= ucfirst($gp['return_status']); ?></td>
              <th>Status</th>
              <td>: <?= $gp['status']; ?></td>
            </tr>
          </table>
        </div>
      </div>

			<?php if($gp['type'] != 'laysheet transfer') { ?>
			<div class="col-md-12">
				<table id="gp_items" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
								<tr>
										<th>No</th>
										<th>Details</th>
										<th>Unit</th>
										<th>Qty</th>
								</tr>
						</thead>
						<?php
						$x = 0;
						foreach ($items as $row) {
						$x++; ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $row['description'] ?></td>
								<td><?= $row['unit'] ?></td>
								<td><?= $row['qty'] ?></td>
							</tr>
						<?php } ?>
						<tbody>
						</tbody>
				</table>
		</div>
		<?php } ?>

		<?php if($gp['type'] == 'laysheet transfer') { ?>
		<div class="col-lg-12" style="margin-top: 20px">
			<table id="gp_laysheets" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
							<tr>
									<th>No</th>
									<th>Laysheet No</th>
									<th>Item Code</th>
									<th>Cut No</th>
							</tr>
					</thead>
					<tbody>
						<?php
						$x = 0;
						foreach ($laysheets as $row) {
						$x++; ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $row['laysheet_no'] ?></td>
								<td><?= $row['order_code'] ?></td>
								<td><?= $row['cut_no'] ?></td>
							</tr>
						<?php } ?>
					</tbody>
			</table>
	</div>
	<?php } ?>

	<?php if($gp['status'] != 'NEW') { ?>
	<div class="col-md-12" style="margin-top:20px">
		<label style="font-size:13px;">Authorization</label>
		<table class="table table-striped table-bordered table-hover" style="width:100%">
				<tr>
					<th style="width:20%">Level</th>
					<th style="width:35%">Approved By</th>
					<th style="width:20%">Status</th>
					<th style="width:25%">Date & Time</th>
				</tr>
			<?php foreach ($approval_data as $row) {
					$status = '';
					if($row['status'] == 'APPROVE'){
						$status = 'APPROVED';
					}
					else if($row['status'] == 'REJECT'){
						$status = 'REJECTED';
					}
					else {
						$status = $row['status'];
					}
				?>
				<tr>
					<td>Level <?= $row['level'] ?></td>
					<td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
					<td><?= $status ?></td>
					<td><?= $row['end_date'] ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td>Security Check</td>
				<td colspan="3"></td>
			</tr>
		</table>
	</div>
	<?php } ?>

		</div>
	</div>
</div>

<?php if($gp['status'] == null || $gp['status'] == 'NEW' || $gp['status'] == 'PENDING') { ?>
	<div id="watermark">APPROVAL PENDING</div>
<?php }
else if($gp['status'] == 'REJECT'){ ?>
	<div id="watermark">REJECTED</div>
<?php } ?>

<script>

let opt = {
	width:2.5,
	height:25,
	fontSize: 5,
	displayValue: false,
	margin:0
	};

	JsBarcode('#barcode', '<?= $gp['id'] ?>', opt);
	window.print();

</script>

</body>

</html>
