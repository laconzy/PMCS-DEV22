<!DOCTYPE html>

<html>

<head>

	<style>

		.container {
			width: 650px;
		}


		.row {
			width: 100%;
		}


		#gpp-items {

			border-spacing: 0;

			border-collapse: collapse;

		}


		#gpp-items tr {
			height: 35px;
		}


		#gpp-items td {

			border: 1px solid #000000;

			text-align: center;

			height: 15px;


		}


		#gpp-items th {

			/*                border: 1px solid #000000;*/

			text-align: center;

			font-family: Verdana, Geneva, sans-serif;

			font-size: 11px;

		}


		.body-back {

			background-color: #ffffff;

			/*background-repeat: repeat-y;

			background-size: 700px 1000px*/

		}

	</style>


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
				<hr>
				<div style="width: 100%;background-color: ;">
					<table width="100%" style="font-size: 12px;font-family: Verdana, Geneva, sans-serif;">
						<tr style="height: 20px;text-align: left">
							<td width="20%"><img src="../../../assets/img/logo.png" width="50" height="35"
												 style="float:left;"></td>
							<td width="60%" colspan="2" style="text-align: center"><b>LAYERING SHEET</b></td>
							<td width="20%"></td>
						</tr>
						<tr style="height: 20px;text-align: left">
							<td width="20%" style="font-size: 10px;">DTRT APAPPAREL LTD</td>
							<td width="60%" colspan="2" style="text-align: left"></td>
							<td width="20%"></td>
						</tr>


					</table>
					<hr>
				</div>

			</div>
			<table style="width:100%;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">

				<tr>
					<td style="width:20%"><label><b>Style </b> </label></td>

					<td style="width:30%"><b>:<?php echo $record['style_code']; ?></b></td>
					<td style="width:30%"><b>CPO #</b></td>
					<td style="width:30%"><b>:<?php echo $record['customer_po']; ?></b></td>

				</tr>

				<tr>

					<td style="width:20%"><label><b>CutPlan/laysheet No</b> </label></td>

					<td style="width:30%"> : <?php echo $record['cut_plan_id'] . "/" . $record['laysheet_no']; ?></td>

					<td style="width:20%"><label><b>Customer</b> </label></td>

					<td style="width:30%"> :<?php echo $record['cus_name']; ?> </td>

				</tr>

				<tr>

					<td style="width:20%"><label><b>Cut No</b> </label></td>

					<td style="width:30%"> : <?php echo $record['cut_no']; ?></td>

					<td style="width:20%"><label><b>Color</b> </label></td>

					<td style="width:30%"> :<?php echo $record['color_code']; ?> </td>

				</tr>

				<tr>

					<td style="width:20%"><label><b>Item Code</b> </label></td>

					<td style="width:30%"> : <?php echo $record['item_code']; ?></td>

					<td style="width:20%"><label><b>Lay Qty</b> </label></td>

					<td style="width:30%"> :<?php echo $record['lay_qty']; ?> </td>

				</tr>
				<tr>

					<td style="width:20%"><label><b>Marker Length</b> </label></td>

					<td style="width:30%"> : ...............</td>

					<td style="width:20%"><label><b>Actual Length</b> </label></td>

					<td style="width:30%"> : ...............</td>

				</tr>
				<tr>

					<td style="width:20%"><label><b>Marker Ref</b> </label></td>

					<td style="width:30%"> : ...............</td>

					<td style="width:20%"><label><b></b> </label></td>

					<td style="width:30%"></td>

				</tr>


				<tr>

					<td><label> </label></td>

					<td></td>

					<td><label> </label></td>

					<!--                            <td> : </td>-->

				</tr>

				<tr>

					<td><label> </label></td>

					<td></td>

					<td><label> </label></td>

					<td></td>

				</tr>

				<!--                        <tr>-->
				<!---->
				<!--                            <td><label><b>Printed Date </b></label></td>-->
				<!---->
				<!--                            <td> :  --><?php //echo date('Y-m-d'); ?><!--</td>-->
				<!---->
				<!--                            <td><label></label></td>-->
				<!---->
				<!--                            <td>  </td>-->
				<!---->
				<!--                        </tr>-->

			</table>


			<table width="100%" style="margin-top: 25px;line-height: 10px;" id="gpp-items">

				<thead>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 10px;height: 5px;background-color: lightgrey">
					<th width=""
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
						Size
					</th> <?php
					foreach ($ratio as $row) {
						?>
						<td style="text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
							<b><?php echo $row['size_code']; ?></b></td>

						<?php
					}
					?>
					<th width=""
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
						Total
					</th>
				</tr>
				</thead>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 10px;height: 5px;">
					<th width=""
						style="border: 1px solid #000000;;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
						Ratio
					</th>
					<?php

					foreach ($ratio as $row) {
						?>

						<td style="text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;"><?php echo $row['ratio']; ?></td>
						<?php # code...

					}
					?>
					<td style="text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;"></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 10px;height: 5px;">
					<th width=""
						style="border: 1px solid #000000;;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">
						Qty
					</th>
					<?php
					$t = 0;
					foreach ($ratio as $row) {
						?>

						<td style="text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;"><?php echo $row['qty']; ?></td>
						<?php # code...
						$t += $row['qty'];
					}

					?>
					<td style="text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 10px;"><?php echo $t; ?></td>
				</tr>
			</table>

			<table style="width:100%;margin-top: 25px;line-height: 12px;font-family: Verdana, Geneva, sans-serif;font-size: 9px;border: black;"
				   id="gpp-items">

				<thead>

				<tr style=" border: 1px solid #000000;width: 5px;">

					<th width="5%"
						style="border: 1px solid #000000;;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						No
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						DYELOT
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						SHADE
					</th>

					<!--                    <th width="10%" style="border: 1px solid black;text-align: center;font-family: Verdana, Geneva, sans-serif">COLOR</th>-->

					<!--                    <th width="10%" style="border: 1px solid black;text-align: center;font-family: Verdana, Geneva, sans-serif">REFERANCE</th>-->

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						ROLL NO
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						YARDAGE
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						PLIES
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						UTILIZE
					</th>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						ACTUAL
					</th>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						EXCESS/LESS
					</th>
					<th width="50%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						REMARKS
					</th>

				</tr>

				</thead>

				<tbody>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>

					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 15px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>

				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"></td>

					<td style="text-align: center"></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>

					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">
					<td style="text-align: right"></td>
					<td style="text-align: center"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>


				</tbody>

			</table>


			<table style="margin-top: 40px;font-family: Verdana, Geneva, sans-serif;font-size: 10px;">

				<tr>

					<td style="width:33%;text-align: center">


					</td>

					<td style="width:33%;text-align: center">


					</td>

					<td style="width:33%"></td>

				</tr>

				<tr>
				
					<td style="width:16%;">Layering Start/End[Plan]</td>
					<td style="width:16%;">.........../...........</td>
					<td style="width:16%;">Spread By/Start/End</td>
					<td style="width:16%;">........./......./......</td>
						<td style="width:16%;"></td>
					
				</tr>
				<tr>
					<td style="width:16%;">Cutting Start/End[Plan]</td>
					<td style="width:16%;">.........../...........</td>
					<td style="width:16%;">Cutter/Start/End</td>
					<td style="width:16%;">........./......./......</td>
				</tr>

				
				<tr>
					<td style="width:16%;">Marker & Lay Checked</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Time</td>
					<td style="width:16%;">......................</td>
				</tr>
				<tr>
					<td style="width:16%;">Table Number</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Cut Date</td>
					<td style="width:16%;">......................</td>
				</tr>
				<tr>
					<td style="width:16%;">Quality</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Supervisor</td>
					<td style="width:16%;">......................</td>
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

