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
		}

		.rpfont3 { 
			font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
			color: black;
			text-align: right;
		}
	</style>


</head>

<body>

	<!-- Site wrapper -->


	<!-- =============================================== -->

	<input type="hidden" value="<?php echo base_url(); ?>" id="base-url">


	<div>
		<?php
//$date="";
//if (isset($this->input->get('date'))) {
	//$date = $this->input->get('date');
//}
			//echo $date;
		?>

		<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">DAILY Efficeiancy REPORT</h4>


		<div class="col-md-12" style="margin-bottom:20px">

			<div class="col-md-3">
<!-- 
			<label>Shift</label>

			<select class="form-control input-sm" id="shift">

				<option value="X">-- Select Shift --</option>
				<option value="A">- A -</option>
				<option value="B">- B -</option>

			</select> -->

		</div>

		<div class="col-md-3">

			<!-- <label>Building </label>

			<select type="text" class="form-control input-sm" id="building">

				<option value="X">-- Select Module --</option>
				<option value="A">- A -</option>
				<option value="B">- B -</option>
				<option value="C">- C -</option>

			</select> -->

		</div>

		<div class="col-md-3">


		</div>

	</div>

	<div class="col-md-12" style="margin-bottom:20px">

		
		<div class="col-md-3">

			<label>To Date</label>

			<input type="" class="form-control input-sm date" id="date_to" value="<?php echo $date; ?>">

		</div>

		<div class="col-md-3">

			<button class="btn btn-primary" style="margin-top:20px" id="btn_search">Search</button>

		</div>

	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-6">


			<table id="order_table" class="table  table-bordered table-hover" width="100%" >

				<thead>

					<tr bgcolor="#010a5c">

						<th class="rpfont">Product</th>
						<th class="rpfont">QTY</th>
						<th class="rpfont">SAH</th>
						<th class="rpfont">No Of Lines</th>
						<th class="rpfont">Clock H</th>

						<th style="color: white;text-align: center;font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; ">Efficiency</th>

					</tr>
					<?php
					$t_min=0;
					$t_qty=0;
					$t_clock=0;
					$nl=0;
					foreach ($eff_product as $row) {
						$t_min+=$row['minutes'];
						$t_qty+=$row['qty'];
						$nl+=$row['no_lines'];
									//$prod =$this->report_model->plan_qty($date,$shift,$line);
						$t_clock+=$row['clock_minutes'];
						// if($row['clock_minutes']==0){
						// 	continue;
						// }
						echo "<tr><th  class='rpfont2'>".$row['style_name']."</th>";
						echo	"<th class='rpfont2'>".number_format($row['qty'])."</th>";
						echo	"<th class='rpfont2'>".number_format(round(($row['minutes']/60),2),1)."</th>";
						echo	"<th class='rpfont2'>".number_format(round(($row['no_lines']),2),1)."</th>";
						echo	"<th class='rpfont2'>".number_format(round(($row['clock_minutes']),2),1)."</th>";
						echo	"<th class='rpfont2'>".round($row['minutes']/$row['clock_minutes']*100,2)."%</th></tr>";
					}

					// if($t_clock==0){
					// 		continue;
					// 	}
					echo "<tr><th  class='rpfont2'>Total</th>";
					echo	"<th class='rpfont2'>".$t_qty."</th>";
					echo	"<th class='rpfont2'>".number_format(round(($t_min/60),2),1)."</th>";;
					echo	"<th class='rpfont2'>".number_format(round(($nl),2),1)."</th>";
					echo	"<th class='rpfont2'>".number_format(round(($t_clock),2),1)."</th>";
					echo	"<th class='rpfont2'>".round($t_min/$t_clock*100,2)."%</th></tr>";

					?>

				</thead>
			</table>
		</div>
		<div class="col-md-5">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-6">


			<table id="order_table" class="table  table-bordered table-hover" width="100%">

				<thead>

					<tr bgcolor="#010a5c" style="color: white;text-align: center;">

						<th  class='rpfont'>Section</th>
						<th  class='rpfont'>Shift</th>
						<th  class='rpfont'>Direct</th>
						<th  class='rpfont'>Indirect</th>
						<th  class='rpfont'>No of Lines</th>
						<th  class='rpfont'>Plan QTY</th>
						<th  class='rpfont'>Produce QTY</th>					
						<th  class='rpfont'>Plan SAH</th>
						<th  class='rpfont'>Produce SAH</th>
						<th  class='rpfont'>SAH Achivement</th>
						<th  class='rpfont'>Efficiecncy</th>

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
					foreach ($eff_section_wise as $row) {
						$t_min+=$row['minutes'];
						$t_qty+=$row['out_qty'];
						$nl+=($row['work_mins']/570);
						$direct+=$row['direct'];
						$indirect+=$row['indirect'];
						$p_qty+=$row['plan_qty'];
						$p_sah+=$row['plan_sah'];
						$plan_sah=$row['plan_sah'];
						if($row['plan_sah']==0){
							$plan_sah=1;
						}
									//$prod =$this->report_model->plan_qty($date,$shift,$line);
						$t_clock+=$row['clock_minutes'];
						// echo "<tr><th  class='rpfont2'>".$row['section']."</th>";
						// echo	"<th  class='rpfont2'>".$row['shift']."</th>";
						// echo	"<th  class='rpfont2'>".number_format(($row['direct']),2)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(($row['indirect']),2)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(round(($row['work_mins']/570),2),1)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(round(($row['plan_qty']),2),1)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(round(($row['out_qty'])),1)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(round(($row['plan_sah']),2),1)."</th>";
						// echo	"<th  class='rpfont2'>".number_format(round(($row['minutes'])/60,2),1)."</th>";
						// echo	"<th  class='rpfont2'>".round(($row['minutes']/60)/$plan_sah*100,2)."%</th>";
						// echo	"<th  class='rpfont2'>".round($row['minutes']/$row['clock_minutes']*100,2)."%</th></tr>";
					}
					// echo "<tr><th  class='rpfont2'>Total</th>";
					// echo	"<th  class='rpfont2'></th>";
					// echo	"<th  class='rpfont2'>".round(($direct),2)."</th>";;
					// echo	"<th  class='rpfont2'>".round(($indirect),2)."</th>";
					// echo	"<th  class='rpfont2'>".round(($nl),2)."</th>";
					// echo	"<th  class='rpfont2'>".number_format(round(($p_qty),2),1)."</th>";
					// echo	"<th  class='rpfont2'>".number_format(round(($t_qty),2),1)."</th>";			
					// echo	"<th  class='rpfont2'>".number_format(round(($p_sah),2),1)."</th>";
					// echo	"<th  class='rpfont2'>".number_format(round(($t_min)/60,2),1)."</th>";
					if($p_sah==0){
						$p_sah=1;
					}
				// 	echo	"<th  class='rpfont2'>".round(($t_min/60)/$p_sah*100,2)."%</th>";
				// //echo	"<th  class='rpfont2'>".round($t_min/$t_clock*100,2)."%</th></tr>";
				// 	echo	"<th  class='rpfont2'>%</th></tr>";

					?>

				</thead>
			</table>
		</div>
		<div class="col-md-5">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">


			<table id="order_table" class="table  table-bordered table-hover" width="100%">

				<thead>

					<tr bgcolor="#010a5c">

						<th  class='rpfont'>Date</th>
						<th  class='rpfont'>Shift</th>
						<th  class='rpfont'>Building</th>
						<th  class='rpfont'>Line</th>
						<th  class='rpfont'>Cardre/D</th>
						<th  class='rpfont'>Carder/IN</th>
						<th  class='rpfont'>Out QTY</th>
						<th  class='rpfont'>AVG SMV</th>
						<th  class='rpfont'>Prod. Minutes</th>
						<th  class='rpfont'>Work Hours</th>
						<th  class='rpfont'>OT</th>

						<th  class='rpfont'>Eff</th>

					</tr>

				</thead>

				<tbody>
					<?php
					$i=0;



					foreach ($eff_line_wise as $row2) {
						// echo "<tr bgcolor='#FDFFD4'>
						// <th  class='rpfont2'>+</th>
						// <th  class='rpfont2'>".$row2['shift']."</th>
						// <th  class='rpfont2'>".$row2['section']."</th>
						// <th  class='rpfont2'>".$row2['line_code']."</th>					
						// <th  class='rpfont3'>".$row2['direct']."</th>
						// <th  class='rpfont3'>".$row2['indirect']."</th>
						// <th  class='rpfont3'>".$row2['out_qty']."</th>
						// <th  class='rpfont3'>".round($row2['avg_smv'],2)."</th>
						// <th  class='rpfont3'>".number_format(round($row2['prod_minutes']),2)."</th>
						// <th  class='rpfont3'>".number_format(round($row2['work_mins']/60,1),2)."</th>					
						// <th  class='rpfont3'>".round($row2['ot'])."</th>					
						// <th  class='rpfont3'>".round(($row2['prod_minutes']/($row2['clock_hrs'])*100),2)."%</th>
						// </tr>";
						// $i++;
						$prod =$this->report_model->efficeincy_data($date,$row2['shift'],$row2['line_id']);
						foreach ($prod as $row3) {
							// echo "<tr>
							// <td class='rpfont2'>-</td>
							// <td></td>
							// <td></th>
							// <td style='text-align:center' >".$row3['style_code']."</td>					
							// <td style='text-align:right'>".$row2['direct']."</td>
							// <td style='text-align:right'>".$row2['indirect']."</td>
							// <td style='text-align:right'>".$row2['out_qty']."</td>
							// <td style='text-align:right'>".round($row3['smv'],2)."</td>
							// <td style='text-align:right'>".number_format(round($row3['minutes']),2)."</td>
							// <td style='text-align:right'>".number_format(round($row3['work_mins']/60,1),2)."</td>					
							// <td style='text-align:right'>".round($row3['ot'])."</td>					
							// <td style='text-align:right'>".round(($row3['minutes']/($row3['clock_minutes'])*100),2)."%</td>
							// </tr>";
						}
					}


					?>
				</tbody>

			</table>

		</tbody>
	</table>
</div>
<div class="col-md-1"></div>
</div>

<div class="row">

	<div class="col-md-2">

		

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
<script src="<?php echo base_url(); ?>assets/views/report/line_wise_production.js"></script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';

</script>

<script>

	var BASE_URL = '<?php echo base_url(); ?>';


	$(document).ready(function () {


		$('#btn_search').click(function () {

			var date = ($('#date_to').val() == '') ? 0 : $('#date_to').val();

			// var style = ($('#style').val() == '') ? 0 : $('#style').val();

			// var customer_po = ($('#customer_po').val().trim() == '') ? 'NO' : $('#customer_po').val().trim();
			// var color = ($('#color').val().trim() == '') ? 'NO' : $('#color').val().trim();
			// var size = ($('#size').val().trim() == '') ? 'NO' : $('#size').val().trim();

			var url = 'index.php/report/efficeincy/' + date

			window.open(BASE_URL + url, '_self');

		});


	});


</script>



</body>

</html>

