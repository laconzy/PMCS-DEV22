<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>PMCS | Daily Efficeiancy Report</title>

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
	<style type="text/css">
		.rpfont {
			font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;
			color: white;
			text-align: center;
		}

		.rpfont2 {
			font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;
			color: black;
			text-align: center;
			background-color: #FDFFD6;
		}

		.rpfont3 {
			font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;
			color: black;
			text-align: right;
		}


		@media print {
			.pagebreak {
				clear: both;
				page-break-after: always;
			}
		}
		@media print{
			.noprint{
				display:none;
			}
		}


		.td-special {
			font-weight:bold;
			background-color:#585858;
			color:#FFF"
		}

		.td-special {
			color : #FFF;
			background-color : #27ae60;
			font-size : 13px;
			text-align: left;
		}

		.tbl, .tbl2 {
			width:100%;
		}

		.tbl th {
			background-color : #27ae60;
			color : #FFF;
			font-size : 13px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl td {
			color : #000;
			font-size : 11px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl tr:nth-child(even) {
			background-color: #F0F0F0;
		}

		.tbl2 th {
			background-color : #ea6153;
			color : #FFF;
			font-size : 13px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl2 td {
			color : #000;
			font-size : 11px;
			border-style : solid;
			border-width : 1px;
			height : 18px;
			padding : 5px;
			border-color: #C0C0C0;
			text-align: center;
		}

		.tbl2 tr:nth-child(even) {
			background-color: #F0F0F0;
		}

		.td-summery {
			color : #000;
			font-weight: bold;
		}

	</style>


</head>

<body>

	<!-- Site wrapper -->


	<!-- =============================================== -->

	<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">

	<div class="row" style="margin-top:20px;">

		<div class="col-md-12">
			<h3 style="margin-bottom:20px;text-align:center;font-weight:bold;color:#ea6153">DAILY EFFICIENCY REPORT</h3>
		</div>

		<div class="col-md-10 col-md-offset-1 noprint" style="margin-bottom:20px" >
			<div class="row">
				<div class="col-md-3">
						<label >Site</label>
						<select id="site" class="form-control input-sm" >
								<option value="">--Select Site--</option>
								<?php
								foreach ($sites as $row) {
									$selected = (isset($site) && $site == $row['id']) ? 'selected' : '';
									echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['site_name'].'</option>';
								} ?>
						</select>
				</div>
				<div class="col-md-3" class="noprint">
					<label class="noprint">Date</label>
					<input type="" class="form-control input-sm date noprint " id="date_to" value="<?php echo $date; ?>">
				</div>
				<div class="col-md-3">
					<button class="btn btn-primary btn-sm noprint" style="margin-top:20px" id="btn_search">Search</button>
				</div>
			</div>
		</div>

		<?php
				$tbl_style_count = 1;

				function get_table_style_class(&$style_count){
					$class_name = '';
					if($style_count % 2 == 0){
						$class_name = 'tbl2';
					}
					else {
						$class_name = 'tbl';
					}
					$style_count++;
					return $class_name;
				}

				function load_daily_total($daily_total){
					$arr = [
						'line_count' => 'Number of lines',
						'direct_operators' => 'Sewing Operators',
						'operators_per_line' => 'Operators per line',
						'indirect_operators' => 'Helpers',
						'helpers_per_line' => 'Helpers per line',
						'out_qty' => 'Output : pcs packed',
						'plan_sah' => 'Plan SAH',
						'achieved_sah' => 'Achieved SAH',
						'sah_percentage' => '% of SAH Achieved',
						'average_sam' => 'Average SAM',
						'sewing_eff' => 'Sewing efficiency'
					];

					$summery = [
						'line_count' => 0,
						'direct_operators' => 0,
						'indirect_operators' => 0,
						'out_qty' => 0,
						'plan_sah' => 0,
						'minutes' => 0,
						'total_smv' => 0,
						'clock_hrs' => 0
					];

					for($x = 0 ; $x < sizeof($daily_total) ; $x++) {
						$summery['line_count'] += $daily_total[$x]['line_count'];
						$summery['direct_operators'] += $daily_total[$x]['direct_operators'];
						$summery['indirect_operators'] += $daily_total[$x]['indirect_operators'];
						$summery['out_qty'] += $daily_total[$x]['out_qty'];
						$summery['plan_sah'] += $daily_total[$x]['plan_sah'];
						$summery['minutes'] += $daily_total[$x]['minutes'];
						$summery['total_smv'] += $daily_total[$x]['total_smv'];
						$summery['clock_hrs'] += $daily_total[$x]['clock_hrs'];
					}


					foreach($arr as $key => $value) {
						echo '<tr> <td style="text-align:left">'.$value.'</td>';

						for($x = 0 ; $x < sizeof($daily_total) ; $x++) {

							if($key == 'operators_per_line'){
								$operators_per_line = $daily_total[$x]['direct_operators'] / $daily_total[$x]['line_count'];
								echo '<td>'.round($operators_per_line,2).'</td>';
							}
							else if($key == 'helpers_per_line'){
								$helpers_per_line = $daily_total[$x]['indirect_operators'] / $daily_total[$x]['line_count'];
								echo '<td>'.round($helpers_per_line,2).'</td>';
							}
							else if($key == 'plan_sah'){
								$plan_sah = round(($daily_total[$x]['plan_sah']/60),2);
								echo '<td>'.$plan_sah.'</td>';
							}
							else if($key == 'achieved_sah'){
								$achived_sah = number_format(round(($daily_total[$x]['minutes'])/60,2),1);
								echo '<td>'.$achived_sah.'</td>';
							}
							else if($key == 'sah_percentage'){
								$plan_sah = $daily_total[$x]['plan_sah'];
								$achived_sah = $daily_total[$x]['minutes'];
								$sah_percentage = 0;

								if($plan_sah != 0){ //number cannot devided by 0
									$sah_percentage = round((($achived_sah/$plan_sah)*100),2);
								}

								echo '<td>'.$sah_percentage.' %</td>';
							}
							else if($key == 'average_sam'){
								$total_smv = $daily_total[$x]['total_smv'];
								$total_lines = $daily_total[$x]['line_count'];
								$average_sam = $total_smv / $total_lines;
								echo '<td>'.round($average_sam, 2).'</td>';
							}
							else if($key == 'sewing_eff'){
								$minutes = $daily_total[$x]['minutes'];
								$clock_hrs = $daily_total[$x]['clock_hrs'];
								$efficeincy = round($minutes/$clock_hrs * 100, 2);
								echo '<td>'.$efficeincy.' %</td>';
							}
							else {
								$field_value = round($daily_total[$x][$key], 2);
								echo '<td>'.$field_value.'</td>';
							}
						}


						if($key == 'operators_per_line'){
							$operators_per_line_summery = $summery['direct_operators'] / $summery['line_count'];
							echo '<td class="td-summery">'.round($operators_per_line_summery,2).'</td>';
						}
						else if($key == 'helpers_per_line'){
							$helpers_per_line_summery = $summery['indirect_operators'] / $summery['line_count'];
							echo '<td class="td-summery">'.round($helpers_per_line_summery,2).'</td>';
						}
						else if($key == 'plan_sah'){
							$plan_sah_summery = round(($summery['plan_sah']/60),2);
							echo '<td class="td-summery">'.$plan_sah_summery.'</td>';
						}
						else if($key == 'achieved_sah'){
							$achived_sah_summery = number_format(round(($summery['minutes'])/60,2),1);
							echo '<td class="td-summery">'.$achived_sah_summery.'</td>';
						}
						else if($key == 'sah_percentage'){
							$plan_sah_summery = $summery['plan_sah'];
							$achived_sah_summery = $summery['minutes'];
							$sah_percentage_summery = 0;

							if($plan_sah_summery != 0){ //number cannot devided by 0
								$sah_percentage_summery = round((($achived_sah_summery/$plan_sah_summery)*100),2);
							}

							echo '<td class="td-summery">'.$sah_percentage_summery.' %</td>';
						}
						else if($key == 'average_sam'){
							$total_smv_summery = $summery['total_smv'];
							$total_lines_summery = $summery['line_count'];
							$average_sam_summery = $total_smv_summery / $total_lines_summery;
							echo '<td class="td-summery">'.round($average_sam_summery, 2).'</td>';
						}
						else if($key == 'sewing_eff'){
							$minutes_summery = $summery['minutes'];
							$clock_hrs_summery = $summery['clock_hrs'];
							$efficeincy_summery = round($minutes_summery/$clock_hrs_summery * 100, 2);
							echo '<td class="td-summery">'.$efficeincy_summery.' %</td>';
						}
						else {
							$field_value_summery = round($summery[$key], 2);
							echo '<td class="td-summery">'.$field_value_summery.'</td>';
						}

						echo '</tr>';
					}
				}
		?>



		<?php if($all_shift_daily_total != null || sizeof($all_shift_daily_total) != 0){ ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
					<table class="<?= get_table_style_class($tbl_style_count); ?>" style="max-width:700px">
						<thead>
								<?php
									$category_count = sizeof($all_shift_daily_total) + 2;

									echo '<tr><th colspan="'.$category_count.'" class="td-special" style="text-align: left;">DAILY TOTAL (SHIFT A + SHIFT B)</th></tr>';
									echo '<tr> <th class="td-special">CATEGORY</th>';

									for($x = 0 ; $x < sizeof($all_shift_daily_total) ; $x++) {
										echo '<th class="td-special">'.$all_shift_daily_total[$x]['category_name'].'</th>';
									}
									echo '<th style="color:#000">FACTORY TOTAL</th></tr>';
								?>
						</thead>
						<tbody>
							<?php
								//echo '<tr><td colspan="'.$category_count.'" style="height:2px"></td></tr>';
								load_daily_total($all_shift_daily_total);
							?>
						</tbody>
					</table>
			</div>
		</div>
	<?php } ?>


	<?php if($early_shift_daily_total != null || sizeof($early_shift_daily_total) != 0){ ?>
	<div class="row" style="margin-top:30px">
		<div class="col-md-10 col-md-offset-1">
				<table class="<?= get_table_style_class($tbl_style_count); ?>" style="max-width:700px">
					<thead>
							<?php
								$category_count = sizeof($early_shift_daily_total) + 2;

								echo '<tr><th colspan="'.$category_count.'" class="td-special" style="text-align: left;">SHIFT A</th></tr>';
								echo '<tr> <th class="td-special">CATEGORY</th>';

								for($x = 0 ; $x < sizeof($early_shift_daily_total) ; $x++) {
									echo '<th class="td-special">'.$early_shift_daily_total[$x]['category_name'].'</th>';
								}
								echo '<th style="color:#000">FACTORY TOTAL</th> </tr>';
							?>
					</thead>
					<tbody>
						<?php
							//echo '<tr><td colspan="'.$category_count.'" style="height:2px"></td></tr>';
							load_daily_total($early_shift_daily_total);
						?>
					</tbody>
				</table>
		</div>
	</div>
<?php } ?>

<?php if($late_shift_daily_total != null || sizeof($late_shift_daily_total) != 0){ ?>
<div class="row" style="margin-top:30px">
	<div class="col-md-10 col-md-offset-1">
			<table class="<?= get_table_style_class($tbl_style_count); ?>" style="max-width:700px">
				<thead>
						<?php
							$category_count = sizeof($late_shift_daily_total) + 2;

							echo '<tr><th colspan="'.$category_count.'" class="td-special" style="text-align: left;">SHIFT B</th></tr>';
							echo '<tr> <th class="td-special">CATEGORY</th>';

							for($x = 0 ; $x < sizeof($late_shift_daily_total) ; $x++) {
								echo '<th class="td-special">'.$late_shift_daily_total[$x]['category_name'].'</th>';
							}
							echo '<th style="color:#000">FACTORY TOTAL</th> </tr>';
						?>
				</thead>
				<tbody>
					<?php
						//echo '<tr><td colspan="'.$category_count.'" style="height:2px"></td></tr>';
						load_daily_total($late_shift_daily_total);
					?>
				</tbody>
			</table>
	</div>
</div>
<?php } ?>


		<!--<div class="row" style="margin-top:20px">
			<div class="col-md-10 col-md-offset-1">
					<table class="tbl2">
						<thead>
							<tr>
								<th>Product</th>
								<th>QTY</th>
								<th>SAH</th>
								<th>Clock H</th>
								<th>Efficiency</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$t_min=0;
								$t_qty=0;
								$t_clock=0;
								$nl=0;
								$eff_t=0;
								$eff=0;
								foreach ($eff_product as $row) {
									$t_min+=$row['minutes'];
									$t_qty+=$row['qty'];
									$nl+=$row['no_lines'];

									$t_clock+=$row['clock_minutes'];
									if($row['clock_minutes']==0){
										$eff_t=0;
										$eff=0;

									}else{
										$eff_t=round($t_min/$t_clock*100,2);
										$eff=round($row['minutes']/$row['clock_minutes']*100,2);
									}
									echo "<tr><td>".$row['style_name']."</td>";
									echo	"<td>".number_format($row['qty'])."</td>";
									echo	"<td>".number_format(round(($row['minutes']/60),2),1)."</td>";
									echo	"<td>".number_format(round(($row['clock_minutes'] / 60),2),1)."</td>";
									echo	"<td>".$eff."%</td></tr>";
								}

								echo "<tr><td>Total</td>";
								echo	"<td>".$t_qty."</td>";
								echo	"<td>".number_format(round(($t_min/60),2),1)."</td>";;
								echo	"<td>".number_format(round(($t_clock),2),1)."</td>";
								echo	"<td>".$eff_t."%</td></tr>";
							?>
						</tbody>
					</table>
				</div>
			</div>-->

			<div class="row" style="margin-top:20px">
				<div class="col-md-10 col-md-offset-1">
					<table id="order_table1" class="tbl">
						<thead>
							<tr>
								<th>Section</th>
								<th>Shift</th>
								<th>Direct</th>
								<th>Indirect</th>
								<th>No of Lines</th>
								<th>Plan QTY</th>
								<th>Produce QTY</th>
								<th>Plan SAH</th>
								<th>Produce SAH</th>
								<th>SAH Achivement</th>
								<th>Efficiency</th>
							</tr>
							<?php
							$t_min=0;
							$t_qty=0;
							$t_clock=0;
							$nl=0;
							$direct=0;
							$indirect=0;
							$p_qty=0;
							$p_sah=0;
							$sah_ach=0;
							foreach ($eff_section_wise as $row) {
								$t_min+=$row['minutes'];
								$t_qty+=$row['out_qty'];
								$nl+=($row['work_mins']/570);
								$direct+=$row['direct'];
								$indirect+=$row['indirect'];
								$p_qty+=$row['plan_qty'];
								$p_sah+=$row['plan_sah'];
								$sah=$row['plan_sah'];
								if($row['plan_sah']==0){
									$sah=1;
								}else{
									$sah=$row['plan_sah']/60;
								}
								$prod_sah=($row['minutes']/60);

									//$prod =$this->report_model->plan_qty($date,$shift,$line);
								$t_clock+=$row['clock_minutes'];
								echo "<tr><td>".$row['section']."</td>";
								echo	"<td>".$row['shift']."</td>";
								echo	"<td>".number_format(($row['direct']),2)."</td>";
								echo	"<td>".number_format(($row['indirect']),2)."</td>";
								echo	"<td>".number_format(round(($row['work_mins']/570)),1)."</td>";
								echo	"<td>".number_format(round(($row['plan_qty']),2),1)."</td>";
								echo	"<td>".number_format(round(($row['out_qty'])),1)."</td>";
								echo	"<td>".number_format(round(($row['plan_sah']/60),2),1)."</td>";
								echo	"<td>".number_format(round(($row['minutes'])/60,2),1)."</td>";
								echo	"<td>".round((($prod_sah/$sah)*100),2)."%</td>";
								echo	"<td>".round($row['minutes']/$row['clock_minutes']*100,2)."%</td></tr>";
							}
							echo "<tr><td>Total</td>";
							echo	"<td></td>";
							echo	"<td>".round(($direct),2)."</td>";;
							echo	"<td>".round(($indirect),2)."</td>";
							echo	"<td>".number_format(round(($nl)),1)."</td>";
							echo	"<td>".number_format(round(($p_qty),2),1)."</td>";
							echo	"<td>".number_format(round(($t_qty),2),1)."</td>";
							echo	"<td>".number_format(round(($p_sah/60),2),1)."</td>";
							echo	"<td>".number_format(round(($t_min)/60,2),1)."</td>";
							if($p_sah==0){
								$p_sah=1;
							}

							if($t_clock==0){
								$t_eff=0;
							}else{
								$t_eff=round($t_min/$t_clock*100,2);
							}

							if($sah_ach==0){
								$sah_ach=0;
							}else{
								$sah_ach=round((($t_min/60)/$p_sah)*100,2);
							}

							echo	"<td>".number_format(((($t_min/60)/($p_sah/60))*100),2)."%</td>";
							echo	"<td>".$t_eff."%</td></tr>";
							?>

						</thead>
					</table>
				</div>
			</div>

			<div class="row" style="margin-top:20px">
				<div class="col-md-10 col-md-offset-1">
					<table id="order_table2" class="tbl2">
						<thead>
							<tr>
								<th>Date</th>
								<th>Shift</th>
								<th>Building</th>
								<th>Line</th>
								<th>Cadre/D</th>
								<th>Cadre/IN</th>
								<th>Out QTY</th>
								<th>SMV</th>
								<th>Prod. Minutes</th>
								<th>Work Hours</th>
								<th>OT</th>
								<th>Eff</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								foreach ($eff_line_wise as $row2) {
									echo "<tr>
									<td>+</td>
									<td>".$row2['shift']."</td>
									<td>".$row2['section']."</td>
									<td>".$row2['line_code']."</td>
									<td>".$row2['direct']."</td>
									<td>".$row2['indirect']."</td>
									<td>".$row2['out_qty']."</td>
									<td>".round($row2['avg_smv'],2)."</td>
									<td>".number_format(round($row2['prod_minutes']),2)."</td>
									<td>".number_format(round($row2['work_mins']/60,1),2)."</td>
									<td>".round($row2['ot'])."</th>
									<td>".round(($row2['prod_minutes']/($row2['clock_hrs'])*100),2)."%</td>
									</td>";
									$i++;
									$prod =$this->report_model->efficeincy_data($date,$row2['shift'],$row2['line_id']);
									if(sizeof($prod) > 1){
										foreach ($prod as $row3) {
											echo "<tr>
											<td>-</td>
											<td></td>
											<td></th>
											<td>".$row3['style_code']."</td>
											<td>".$row2['direct']."</td>
											<td>".$row2['indirect']."</td>
											<td>".$row3['out_qty']."</td>
											<td>".round($row3['smv'],2)."</td>
											<td>".number_format(round($row3['minutes']),2)."</td>
											<td>".number_format(round($row3['work_mins']/60,1),2)."</td>
											<td>".round($row3['ot'])."</td>
											<td>".round(($row3['minutes']/($row3['clock_minutes'])*100),2)."%</td>
											</tr>";
										}
									}
								}
							?>
						</tbody>
					</table>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:50px">
		<div class="col-md-1">
		</div>
		<div class="col-md-2">
			<button id="confirm" class="btn btn-primary btn-sm">Send Email</button>
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
<!-- <script src="<?php echo base_url(); ?>assets/views/master/colour/colour.js"></script> -->
<script src="<?php echo base_url(); ?>assets/application/app.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script> -->
<!-- jquery form validator plugin -->
<!-- <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/views/report/line_wise_production.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

	$(document).ready(function () {
		$('#btn_search').click(function () {
			var date = ($('#date_to').val() == '') ? 0 : $('#date_to').val();
			var site = $('#site').val();
			if(date == 0 || site == ''){
				appAlertError('Please select date and site');
				return;
			}
			// var style = ($('#style').val() == '') ? 0 : $('#style').val();
			// var customer_po = ($('#customer_po').val().trim() == '') ? 'NO' : $('#customer_po').val().trim();
			// var color = ($('#color').val().trim() == '') ? 'NO' : $('#color').val().trim();
			// var size = ($('#size').val().trim() == '') ? 'NO' : $('#size').val().trim();
			var url = 'index.php/report/efficeincy/' + date + '/' + site;
			window.open(BASE_URL + url, '_self');
		});

		$('#confirm').click(function () {
			var date = ($('#date_to').val() == '') ? 0 : $('#date_to').val();
			var site = $('#site').val();

			if(date == 0 || site == ''){
				appAlertError('Please select date and site');
				return;
			}

			appAjaxRequest({
				url: BASE_URL + 'index.php/Emailcontroller/send_eff_report',
				'data': {'date': date, 'site' : site},
				async: false,
				success: function (response) {
					var obj = JSON.parse(response);
					alert(obj.results)
        }
      });
		});
	});
</script>

</body>
</html>
