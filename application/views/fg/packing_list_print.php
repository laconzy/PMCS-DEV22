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
							<td width="60%" colspan="2" style="text-align: center"><b>PACKING LIST</b></td>
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

					<td style="width:30%"><b>:<?php //echo $record['style_code']; ?></b></td>
					<td style="width:30%"><b>CPO #</b></td>
					<td style="width:30%"><b>:<?php echo $data[0]['customer_po']; ?></b></td>

				</tr>

				<tr>
					<td style="width:20%"><label><b>Color </b> </label></td>

					<td style="width:30%"><b>:<?php echo $data[0]['style_code']; ?></b></td>
					<td style="width:30%"><b></b></td>

					<?php
//echo $data[0]['order_id'];
$ord_qty=$this->fg_model->get_ord_qty($data[0]['order_id']);
					?>
					<td style="width:30%"><b>:</b></td>

				</tr>
				<tr>
					<td style="width:20%"><label><b>Order QTY </b> </label></td>

					<td style="width:30%"><b>:<?php echo $ord_qty; ?></b></td>
					<td style="width:30%"><b>Ship QTY #</b></td>
					<td style="width:30%"><b>:<?php //echo $record['customer_po']; ?></b></td>

				</tr>

				<!-- <tr>

					<td style="width:20%"><label><b>CutPlan/laysheet No</b> </label></td>

					<td style="width:30%"> : <?php //echo $record['cut_plan_id'] . "/" . $record['laysheet_no']; ?></td>

					<td style="width:20%"><label><b>Customer</b> </label></td>

					<td style="width:30%"> :<?php //echo $record['cus_name']; ?> </td>

				</tr>

				<tr>

					<td style="width:20%"><label><b>Cut No</b> </label></td>

					<td style="width:30%"> : <?php //echo $record['cut_no']; ?></td>

					<td style="width:20%"><label><b>Color</b> </label></td>

					<td style="width:30%"> :<?php //echo $record['color_code']; ?> </td>

				</tr>

				<tr>

					<td style="width:20%"><label><b>Item Code</b> </label></td>

					<td style="width:30%"> : <?php //echo $record['item_code']; ?></td>

					<td style="width:20%"><label><b>Lay Qty</b> </label></td>

					<td style="width:30%"> :<?php //echo $record['lay_qty']; ?> </td>

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

				</tr> -->


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


			

			<table style="width:100%;margin-top: 25px;line-height: 12px;font-family: Verdana, Geneva, sans-serif;font-size: 9px;border: black;"
				   id="gpp-items">

				<thead>

				<tr style=" border: 1px solid #000000;width: 5px;">

					<th width="5%"
						style="border: 1px solid #000000;;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						From
					</th>
					<th width="5%"
						style="border: 1px solid #000000;;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						to
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Style
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Color
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Code
					</th>


					<!--                    <th width="10%" style="border: 1px solid black;text-align: center;font-family: Verdana, Geneva, sans-serif">COLOR</th>-->

					<!--                    <th width="10%" style="border: 1px solid black;text-align: center;font-family: Verdana, Geneva, sans-serif">REFERANCE</th>-->
					<?php
					$size_data3=$this->fg_model->get_size_data($data[0]['order_id']);

					foreach ($size_data3 as $row3) {
					?>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						<?php  echo $row3['size_code']; ?>
					</th>
					<?php
					}
					?>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Total PCS.
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Total CTN.
					</th>

					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Total N.N.W
					</th>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						N.W.
					</th>
					<th width="5%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						G.W
					</th>
					<th width="50%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						CBM
					</th>

					<th width="50%"
						style="border: 1px solid #000000;text-align: center;font-family: Verdana, Geneva, sans-serif;font-size: 9px;">
						Mesurement
					</th>

				</tr>

				</thead>

				<tbody>
<?php
//print_r($data);
// foreach ($data as $row) {

// 	echo $row['ctn_qty'];
// }


$i=1;
foreach ($data as $row) {
$size_data=$this->fg_model->get_size_data($row['order_id']);
	
?>
				<tr style="font-family: Verdana, Geneva, sans-serif;font-size: 11px;height: 20px;">

					<td style="text-align: right"><?php echo $i;?></td>

					<td style="text-align: center"><?php echo $i+$row['ctn_qty']-1;;?></td>

					<?php  $i=$i+$row['ctn_qty'];?>

					<td><?php echo $row['style_code'];?></td>

					<td><?php echo $row['color_code'];?></td>

					<td><?php echo $row['color_code'];?></td>
					<?php
					foreach ($size_data as $row2) {
//echo $row['size_id'];
						$pcs =$this->fg_model->get_pcs_for_ctn($row2['size'],$row['packing_list_id'],$row['line_item']);
						//echo $pcs;
					?>
					<td><?php echo $pcs;?></td>
					<?php
					}
					?>
					<td><?php echo $row['pcs_per_ctn']*$row['ctn_qty'];?></td>
					<td><?php echo $row['ctn_qty'];?></td>

					<td><?php ?></td>
					<td><?php ?></td>
					<td><?php ?></td>
					<td><?php ?></td>
					<td><?php ?></td>
				</tr>
			
						<?php
				}
						?>		


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
				<!-- <tr>
					<td style="width:16%;">Cutter</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Commenced At</td>
					<td style="width:16%;">......................</td>
				</tr>
				<tr>
					<td style="width:16%;">Finished At</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Finished At</td>
					<td style="width:16%;">......................</td>
				</tr>
				<tr>
					<td style="width:16%;">Marker & Lay Checked</td>
					<td style="width:16%;">......................</td>
					<td style="width:16%;">Commenced At</td>
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
 -->

			</table>

		</div>

	</div>

</div>

<script>

	//window.print();

</script>

</body>

</html>

