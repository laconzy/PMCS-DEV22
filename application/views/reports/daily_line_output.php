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

		<h4 style="margin-bottom:20px;text-align:center;font-weight:bold">DAILY PRODUCTION REPORT</h4>


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


	<div class="col-md-12">


		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%" style="max-width: 1600px;max-height: 600px;">

			<thead>
				<tr bgcolor="#660000" style="font-weight:bold;color:white">				
					<th style="text-align: center;font-size:px;" colspan="9">Hourly Production</th>
					
					<th style="text-align: center;" colspan="12">Hour</th>


				</tr>
			</thead>
			<tbody>
				<?php 
//print_r($linea);


				if($date != ""){
					$style_name="";
					$section='X';
					$total=0;
					$section_total=0;
					$section_variance=0;

				$count=0;
				$Plan_total=0	;
				$commited_total=0	;
				$output_total=0	;
				$variance_total=0;	
foreach ($linea as $row) {	//echo ;
	$out_qty =$this->report_model->daily_production($row['line_id'],'A',$date);
	$style =$this->report_model->get_the_style_running($row['line_id'],$date);
	//echo $row['section'];
	if($section == 'X'){
		//echo 'X';
		$section=$row['section'];


		echo '<tr style="text-align: center;font-weight:bold;color:white; font-size:15px;" >';
		echo '<td bgcolor="#660000">Building - '.$section.'</td>';
		echo '<td bgcolor="#660000">Section</td>';
		echo '<td bgcolor="#660000">Module</td>';
		echo '<td bgcolor="#660000">Style</td>';
		echo '<td bgcolor="#660000">Plan</td>';
		echo '<td bgcolor="#660000">Commited</td>';
		echo '<td bgcolor="#660000">PCS/HR</td>';
		echo '<td bgcolor="#660000">QTY</td>';
		echo '<td bgcolor="#660000">Variance</td>';
		echo '<td bgcolor="#660000">1</td>';
		echo '<td bgcolor="#660000">2</td>';
		echo '<td bgcolor="#660000">3</td>';
		echo '<td bgcolor="#660000">4</td>';
		echo '<td bgcolor="#660000">5</td>';
		echo '<td bgcolor="#660000">6</td>';
		echo '<td bgcolor="#660000">7</td>';
		echo '<td bgcolor="#660000">8</td>';
		echo '<td bgcolor="#660000">9</td>';
		echo '<td bgcolor="#660000">10</td>';
		echo '<td bgcolor="#660000">11</td>';
		echo '<td bgcolor="#660000">12</td>';
		echo '</tr>';

	}

	if($style_name != $style['style_name']){
if($count!=0){

	$bgcolor='black';
	$font_color='black';
if($variance_total<0){
	$bgcolor='black';
	$font_color='red';
}

		echo '<tr style="text-align: center;font-weight:bold;color:black">';		
		echo '<td bgcolor="#F5B041" colspan="4"></td>';
		echo '<td bgcolor="#F5B041">'.$Plan_total.'</td>';
		echo '<td bgcolor="#F5B041">'.$commited_total.'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041">'.$output_total.'</td>';
		echo '<td bgcolor="#F5B041" style="color:'.$font_color.'" >'.round($variance_total).'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';

		echo '</tr>';

		$Plan_total=0	;
				$commited_total=0	;
				$output_total=0	;
				$variance_total=0;
}
		$count=1;
		$style_name=$style['style_name'];
}

	if($section != $row['section']){


		echo '<tr bgcolor="#660000" style="font-weight:bold;color:white;text-align:center">';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000"  style="text-align: center;font-weight;" >'.$section_total.'</td>';
		echo '<td bgcolor="#660000" >'.round($section_variance).'</td>';
		for ($i=1; $i <= 12; $i++) { 
			$hour_qty =$this->report_model->daily_production_hourly_total($section,'A',$date,$i);
			echo '<td style="text-align: center;font-weight:bold;color:white" bgcolor="#660000" >'.$hour_qty.'</td>';
		}
		echo '</tr>';
		echo '<tr style="text-align: center;font-weight:bold;color:white">';
		echo '<td bgcolor="#660000">Building - '.$row['section'].'</td>';
		echo '<td bgcolor="#660000">Section</td>';
		echo '<td bgcolor="#660000">Module</td>';
		echo '<td bgcolor="#660000">Style</td>';
		echo '<td bgcolor="#660000">Plan</td>';
		echo '<td bgcolor="#660000">Commited</td>';
		echo '<td bgcolor="#660000">PCS/HR</td>';
		echo '<td bgcolor="#660000">QTY</td>';
		echo '<td bgcolor="#660000">Variance</td>';
		echo '<td bgcolor="#660000">1</td>';
		echo '<td bgcolor="#660000">2</td>';
		echo '<td bgcolor="#660000">3</td>';
		echo '<td bgcolor="#660000">4</td>';
		echo '<td bgcolor="#660000">5</td>';
		echo '<td bgcolor="#660000">6</td>';
		echo '<td bgcolor="#660000">7</td>';
		echo '<td bgcolor="#660000">8</td>';
		echo '<td bgcolor="#660000">9</td>';
		echo '<td bgcolor="#660000">10</td>';
		echo '<td bgcolor="#660000">11</td>';
		echo '<td bgcolor="#660000">12</td>';

		echo '</tr>';
		$section_total=0;
		$section_variance=0;
	}

	$section = $row['section'];
	$section_total+=$out_qty;
	$plan_qty =$this->report_model->get_plan_qty($row['line_id'],$date,'A');
	$commited =$this->report_model->get_commietd_qty($row['line_id'],$date,'A');
	$hrs =$this->report_model->get_working_hours($row['line_id'],$date,'A');
	$max_hour =$this->report_model->max_hour_per_day($row['line_id'],$date,'A');
				$Plan_total +=$plan_qty	;
				$commited_total +=$commited	;
				$output_total +=$out_qty	;
					
	//echo $max_hour;
	$pcs_per_hr=0;
	$variance=0;
	$upto_now=0;
	//$style_now="";
	if($commited <=0){
		$pcs_per_hr=0;
	}else{
		$pcs_per_hr=$commited/$hrs;	

		$upto_now =$commited/$hrs;
		$upto_now=$upto_now*$max_hour;
		$variance=$out_qty-$upto_now;
	}
	$bgcolor='black';
	$font_color='black';
	if($variance<0){
		$bgcolor='red';
		$font_color='red';
	}
$variance_total +=$variance;
$section_variance+=$variance;

	
	echo '<tr style="font-weight:bold;text-align:center;color:black">';

	echo '<td style="text-align: center;">'.$date.'</td>';
	echo '<td style="text-align: center;">'.$style['style_name'].'</td>';
	echo '<td style="text-align: center;">'.$row['line_code'].'</td>';
	echo '<td style="text-align: center;">'.$style['style'].'</td>';
	echo '<td style="text-align: center;">'.$plan_qty.'</td>';
	echo '<td style="text-align: center;">'.$commited.'</td>';
	echo '<td style="text-align: center;">'.round($pcs_per_hr).'</td>';

	//echo '<td style="text-align: center;">A</td>';
	echo '<td style="text-align: center;font-weight:bold">'.$out_qty.'</td>';
	echo '<td style="text-align: center;color:'.$font_color.';font-weight:bold;" >'.round($variance).'</td>';
	for ($i=1; $i <= 12; $i++) { 

	
		
		$hour_qty =$this->report_model->daily_production_hourly($row['line_id'],'A',$date,$i);
		$col='Blue';
		if($hour_qty<round($pcs_per_hr)){
		$col='#FF5733';
		}
		echo '<td style="text-align: center;font-weight:bold;color:'.$col.'" >'.$hour_qty.'</td>';
	}
	echo '</tr>';



}

//if($style_name != $style['style_name']){
//if($count!=0){

		echo '<tr style="font-weight:bold;text-align:center;color:black">';		
		echo '<td bgcolor="#F5B041" colspan="4"></td>';
		echo '<td bgcolor="#F5B041">'.$Plan_total.'</td>';
		echo '<td bgcolor="#F5B041">'.$commited_total.'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041">'.$output_total.'</td>';
		echo '<td bgcolor="#F5B041">'.round($variance_total).'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';

		echo '</tr>';
//}
		$count=1;
		$style_name=$style['style_name'];
//}
echo '<tr bgcolor="#660000" style="font-weight:bold;color:white;text-align:center">';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000">'.$section_total.'</td>';
echo '<td  bgcolor="#660000">'.round($section_variance).'</td>';
for ($i=1; $i <= 12; $i++) { 
	$hour_qty =$this->report_model->daily_production_hourly_total($section,'A',$date,$i);
	echo '<td style="text-align: center;font-weight:bold" bgcolor="#660000" >'.$hour_qty.'</td>';
}
echo '</tr>';
}
?>

</tbody>
</table>

</div>
<div class="col-md-12">


	
		<table id="order_table" class="table table-striped table-bordered table-hover" width="100%" style="max-width: 1600px;max-height: 600px;">

			<thead>
				<tr bgcolor="#660000" style="font-weight:bold;color:white">				
					<th style="text-align: center;font-size:px;" colspan="9">Hourly Production</th>
					
					<th style="text-align: center;" colspan="12">Hour</th>


				</tr>
			</thead>
			<tbody>
				<?php 
//print_r($linea);


				if($date != ""){
					$style_name="";
					$section='X';
					$total=0;
					$section_total=0;
					$section_variance=0;

				$count=0;
				$Plan_total=0	;
				$commited_total=0	;
				$output_total=0	;
				$variance_total=0;	
foreach ($lineb as $row) {	//echo ;
	$out_qty =$this->report_model->daily_production($row['line_id'],'B',$date);
	$style =$this->report_model->get_the_style_running($row['line_id'],$date);
	//echo $row['section'];
	if($section == 'X'){
		//echo 'X';
		$section=$row['section'];


		echo '<tr style="text-align: center;font-weight:bold;color:white; font-size:15px;" >';
		echo '<td bgcolor="#660000">Building - '.$section.'</td>';
		echo '<td bgcolor="#660000">Section</td>';
		echo '<td bgcolor="#660000">Module</td>';
		echo '<td bgcolor="#660000">Style</td>';
		echo '<td bgcolor="#660000">Plan</td>';
		echo '<td bgcolor="#660000">Commited</td>';
		echo '<td bgcolor="#660000">PCS/HR</td>';
		echo '<td bgcolor="#660000">QTY</td>';
		echo '<td bgcolor="#660000">Variance</td>';
		echo '<td bgcolor="#660000">1</td>';
		echo '<td bgcolor="#660000">2</td>';
		echo '<td bgcolor="#660000">3</td>';
		echo '<td bgcolor="#660000">4</td>';
		echo '<td bgcolor="#660000">5</td>';
		echo '<td bgcolor="#660000">6</td>';
		echo '<td bgcolor="#660000">7</td>';
		echo '<td bgcolor="#660000">8</td>';
		echo '<td bgcolor="#660000">9</td>';
		echo '<td bgcolor="#660000">10</td>';
		echo '<td bgcolor="#660000">11</td>';
		echo '<td bgcolor="#660000">12</td>';
		echo '</tr>';

	}

	if($style_name != $style['style_name']){
if($count!=0){

	$bgcolor='black';
	$font_color='black';
if($variance_total<0){
	$bgcolor='black';
	$font_color='red';
}

		echo '<tr style="text-align: center;font-weight:bold;color:black">';		
		echo '<td bgcolor="#F5B041" colspan="4"></td>';
		echo '<td bgcolor="#F5B041">'.$Plan_total.'</td>';
		echo '<td bgcolor="#F5B041">'.$commited_total.'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041">'.$output_total.'</td>';
		echo '<td bgcolor="#F5B041" style="color:'.$font_color.'" >'.round($variance_total).'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';

		echo '</tr>';

		$Plan_total=0	;
				$commited_total=0	;
				$output_total=0	;
				$variance_total=0;
}
		$count=1;
		$style_name=$style['style_name'];
}

	if($section != $row['section']){


		echo '<tr bgcolor="#660000" style="font-weight:bold;color:white;text-align:center">';
		echo '<td  bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td bgcolor="#660000" ></td>';
		echo '<td style="text-align: center;font-weight;"  bgcolor="#660000" >'.$section_total.'</td>';
		echo '<td bgcolor="#660000" >'.round($section_variance).'</td>';
		for ($i=1; $i <= 12; $i++) { 
			$hour_qty =$this->report_model->daily_production_hourly_total($section,'B',$date,$i);
			echo '<td style="text-align: center;font-weight:bold;color:white">'.$hour_qty.'</td>';
		}
		echo '</tr>';
		echo '<tr style="text-align: center;font-weight:bold;color:white">';
		echo '<td bgcolor="#660000">Building - '.$row['section'].'</td>';
		echo '<td bgcolor="#660000">Section</td>';
		echo '<td bgcolor="#660000">Module</td>';
		echo '<td bgcolor="#660000">Style</td>';
		echo '<td bgcolor="#660000">Plan</td>';
		echo '<td bgcolor="#660000">Commited</td>';
		echo '<td bgcolor="#660000">PCS/HR</td>';
		echo '<td bgcolor="#660000">QTY</td>';
		echo '<td bgcolor="#660000">Variance</td>';
		echo '<td bgcolor="#660000">1</td>';
		echo '<td bgcolor="#660000">2</td>';
		echo '<td bgcolor="#660000">3</td>';
		echo '<td bgcolor="#660000">4</td>';
		echo '<td bgcolor="#660000">5</td>';
		echo '<td bgcolor="#660000">6</td>';
		echo '<td bgcolor="#660000">7</td>';
		echo '<td bgcolor="#660000">8</td>';
		echo '<td bgcolor="#660000">9</td>';
		echo '<td bgcolor="#660000">10</td>';
		echo '<td bgcolor="#660000">11</td>';
		echo '<td bgcolor="#660000">12</td>';

		echo '</tr>';
		$section_total=0;
		$section_variance=0;
	}

	$section = $row['section'];
	$section_total+=$out_qty;
	$plan_qty =$this->report_model->get_plan_qty($row['line_id'],$date,'B');
	$commited =$this->report_model->get_commietd_qty($row['line_id'],$date,'B');
	$hrs =$this->report_model->get_working_hours($row['line_id'],$date,'B');
	$max_hour =$this->report_model->max_hour_per_day($row['line_id'],$date,'B');
				$Plan_total +=$plan_qty	;
				$commited_total +=$commited	;
				$output_total +=$out_qty	;
					
	//echo $max_hour;
	$pcs_per_hr=0;
	$variance=0;
	$upto_now=0;
	//$style_now="";
	if($commited <=0){
		$pcs_per_hr=0;
	}else{
		$pcs_per_hr=$commited/$hrs;	

		$upto_now =$commited/$hrs;
		$upto_now=$upto_now*$max_hour;
		$variance=$out_qty-$upto_now;
	}
	$bgcolor='black';
	$font_color='black';
	if($variance<0){
		$bgcolor='red';
		$font_color='red';
	}
$variance_total +=$variance;
$section_variance+=$variance;

	
	echo '<tr style="font-weight:bold;text-align:center;color:black">';

	echo '<td style="text-align: center;">'.$date.'</td>';
	echo '<td style="text-align: center;">'.$style['style_name'].'</td>';
	echo '<td style="text-align: center;">'.$row['line_code'].'</td>';
	echo '<td style="text-align: center;">'.$style['style'].'</td>';
	echo '<td style="text-align: center;">'.$plan_qty.'</td>';
	echo '<td style="text-align: center;">'.$commited.'</td>';
	echo '<td style="text-align: center;">'.round($pcs_per_hr).'</td>';

	//echo '<td style="text-align: center;">A</td>';
	echo '<td style="text-align: center;font-weight:bold">'.$out_qty.'</td>';
	echo '<td style="text-align: center;color:'.$font_color.';font-weight:bold;" >'.round($variance).'</td>';
	for ($i=1; $i <= 12; $i++) { 

	
		
		$hour_qty =$this->report_model->daily_production_hourly($row['line_id'],'B',$date,$i);
		$col='Blue';
		if($hour_qty<round($pcs_per_hr)){
		$col='#FF5733';
		}
		echo '<td style="text-align: center;font-weight:bold;color:'.$col.'" >'.$hour_qty.'</td>';
	}
	echo '</tr>';



}

//if($style_name != $style['style_name']){
//if($count!=0){

		echo '<tr style="font-weight:bold;text-align:center;color:black">';		
		echo '<td bgcolor="#F5B041" colspan="4"></td>';
		echo '<td bgcolor="#F5B041">'.$Plan_total.'</td>';
		echo '<td bgcolor="#F5B041">'.$commited_total.'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041">'.$output_total.'</td>';
		echo '<td bgcolor="#F5B041">'.round($variance_total).'</td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';
		echo '<td bgcolor="#F5B041"></td>';

		echo '</tr>';
//}
		$count=1;
		$style_name=$style['style_name'];
//}
echo '<tr bgcolor="#660000" style="font-weight:bold;color:white;text-align:center" >';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000"></td>';
echo '<td  bgcolor="#660000">'.$section_total.'</td>';
echo '<td  bgcolor="#660000">'.round($section_variance).'</td>';
for ($i=1; $i <= 12; $i++) { 
	$hour_qty =$this->report_model->daily_production_hourly_total($section,'B',$date,$i);
	echo '<td style="text-align: center;font-weight:bold" bgcolor="#660000">'.$hour_qty.'</td>';
}
echo '</tr>';
}
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

			var url = 'index.php/report/daily_line_wise_report/' + date

			window.open(BASE_URL + url, '_self');

		});


	});


</script>



</body>

</html>

