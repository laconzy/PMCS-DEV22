<html>


<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Bundle Chart Report</title>

	<!-- Tell the browser to be responsive to screen width -->

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.5 -->

	<!-- bootstrap datepicker -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css"/>
	<!-- App styles -->

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css"/>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">


</head>


<body>


<section class="invoice" style="padding-right:20px;padding-left:20px">

	<!-- title row -->

	<div class="row">

		<div class="col-xs-12">

			<h3 class="page-header">

				<i class="fa fa-globe"></i> Bundle Chart Report | Order : <?= $laysheet['order_code'] ?>

				<small class="pull-right">Date: <?= date("Y/m/d") ?></small>

			</h3>

		</div><!-- /.col -->

	</div>

	<!-- info row -->

	<div class="row" style="font-size:13px">

		<div class="col-sm-3 invoice-col">


			<b>Laysheet No : </b> <?= $laysheet['laysheet_no'] ?><br>

			<b>Number Of Layers : </b> <br>
			<!--			<b>Number Of Layers : </b> --><? //= $laysheet['lay_qty'] ?><!--<br>-->

		</div><!-- /.col -->

		<div class="col-sm-3 invoice-col">


			<b>Mark Ref : </b> <?= $laysheet['marker_ref'] ?><br>
<!--			<b>Cut No : </b> --><?//= $laysheet['cut_no'] ?><!--<br>-->

			<b>Item Code : </b> <?= $cut_plan['item_name'] ?><br>

		</div><!-- /.col -->

		<div class="col-sm-3 invoice-col">


			<b>Cut Plan Serial : </b> <?= $cut_plan['cut_plan_id'] ?> <br>

			<b>Colour : </b> <?= $cut_plan['color_code'] ?><br>

		</div><!-- /.col -->

		<div class="col-sm-3 invoice-col">

			<!--<b>Factory : </b> <?= $cut_plan['site_name'] ?> --><br>

		</div><!-- /.col -->

	</div><!-- /.row -->
	<!-- Table row -->

	<div class="row" style="margin-top:15px">

		<div class="col-xs-6">

			<table width="100%" style="font-size:10px;border: 1px solid #000000;">

				<thead>

				<tr style="height: 10px;">

					<th style="border: 1px solid #000000;text-align: center">SIZE</th>

					<?php foreach ($cut_details as $row) { ?>

						<th style="border: 1px solid #000000;text-align: center"><?= $row['size_code'] ?></td>


						</th>

					<?php } ?>

					<th style="border: 1px solid #000000;text-align: center">Total</th>

				</tr>

				</thead>

				<tbody>

				<tr>

					<td style="border: 1px solid #000000;text-align: center"><b>Ratio</b></td>

					<?php foreach ($cut_details as $row2) { ?>
						<td style="border: 1px solid #000000;text-align: right"><?= $row2['ratio'] ?></td>
					<?php } ?>
					<td style="border: 1px solid #000000;"></td>
				</tr>
				<tr>

					<td style="border: 1px solid #000000;text-align: center"><strong>Qty</strong></td>

					<?php
					$total = 0;
					foreach ($cut_details as $row3) { ?>

						<td style="border: 1px solid #000000;text-align: right"><strong><?= $row3['qty'] ?></strong>
						</td>

						<?php
						$total += $row3['qty'];
					} ?>
					<td style="border: 1px solid #000000;text-align: right"><strong><?= $total; ?></strong></td>
				</tr>
				<tr>
					<td style="border: 1px solid #000000;text-align: center"><strong>Cut Qty</strong></td>
					<?php
					$total = 0;
					foreach ($cut_details as $row3) { ?>
						<td style="border: 1px solid #000000;text-align: right"><strong><?= $row3['cut_qty'] ?></strong>
						</td>
						<?php
						$total += $row3['cut_qty'];
					} ?>
					<td style="border: 1px solid #000000;text-align: right"><strong><?= $total; ?></strong></td>
				</tr>
				</tbody>

			</table>

		</div><!-- /.col -->

	</div><!-- /.row -->


	</br>

	<div class="row" style="margin-top:15px">
		<?php
		//print_r($size_data);
		$i = 65;
		foreach ($size_data as $row) {


			?>
			<div class="col-xs-6 table-responsive">

				<table width="100%" class="" style="font-size:12px">

					<thead>
					<tr style="height: 15px;">

						<th style="border: 1px solid #000000;text-align: center"
							colspan="6"><?= $row['size_code'] . "(" . chr($row['letter']) . PHP_EOL . ")"; ?></th>

						<?php $i++; ?>


					</tr>
					<tr style="height: 15px;">

						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Bundle No</th>

						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Qty</th>

						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Plies Count</th>
						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Range</th>

						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Barcode</th>
						<th style="border: 1px solid #000000;text-align: center;font-weight: bold">Cut No</th>


					</tr>

					</thead>

					<tbody>


					<?php

					$a = 0;
					//print_r($arr);
					$arr = $this->bundle_model_2->get_bundle_data($laysheet['laysheet_no'], $row['size_id'], $row['diff']);
					//print_r($arr);
					foreach ($arr as $r) {
						//print_r($r)."<br>";
//echo $r[0]['qty'];
						//  $a += $row['plies_count'];?>

						<tr style="height: 10px;">

							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= $r['bundle_no']; ?></td>

							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= $r['qty']; ?></td>

							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= $r['plies_count']; ?></td>
							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= "(" . $r['start'] . "-" . $r['end'] . ")"; ?></td>

							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= $r['barcode']; ?></td>
							<td style="border: 1px solid #000000;text-align: center;font-weight: bold"><?= $r['cut_no']; ?></td>

						</tr>
					<?php } ?>

					</tbody>

				</table>

			</div><!-- /.col -->
		<?php } ?>
	</div>


</section>


<!-- jQuery 2.1.4 -->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>  <!-- Bootstrap 3.3.5 -->

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>


<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>


</body>


</html>

