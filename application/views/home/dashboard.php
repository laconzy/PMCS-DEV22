<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Page title -->
	<title>HOMER | WebApp admin theme</title>

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

	<!-- Vendor styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/c3/c3.min.css" />

	<!-- App styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">

</head>
<body class="fixed-navbar sidebar-scroll">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
<?php $this->load->view('common/header'); ?>



<?php $this->load->view('common/left_menu'); ?>
<!-- Main Wrapper -->
<div id="wrapper">


	<div class="normalheader small-header ">
		<div class="hpanel">
			<div class="panel-body">
				<a class="small-header-action" href="">
					<div class="clip-header">
						<i class="fa fa-arrow-up"></i>
					</div>
				</a>

				<div id="hbreadcrumb" class="pull-right m-t-lg">
					<ol class="hbreadcrumb breadcrumb">
						<li><a href="index.html">Dashboard</a></li>
						<li>
							<span>Charts</span>
						</li>
						<li class="active">
							<span>Dashboard </span>
						</li>
					</ol>
				</div>
				<h2 class="font-light m-b-xs">
					C3 Charts
				</h2>
				<small>DTRT Apparel LTD</small>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="row">

			<!-- <img style='height: 100%; width: 100%; object-fit: contain;margin-bottom:20px' src="<?php echo base_url(); ?>assets/img/dashboard/dash1.jpeg"> -->
			<div class="col-lg-6">
				<div class="hpanel">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Efficiency|Yesterday
					</div>
					<div class="panel-body">
						<div>
							<div id="gauge"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="hpanel">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Efficiency|Today
					</div>
					<div class="panel-body">
						<div>
							<div id="gauge2"></div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Production
					</div>
					<div class="panel-body">
						<div>
							<div id="stocked"></div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>

	<!-- Right sidebar -->
	<!-- <div id="right-sidebar" class="animated fadeInRight">

		<div class="p-m">
			<button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
			</button>
			<div>
				<span class="font-bold no-margins"> Analytics </span>
				<br>
				<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
			</div>
			<div class="row m-t-sm m-b-sm">
				<div class="col-lg-6">
					<h3 class="no-margins font-extra-bold text-success">300,102</h3>

					<div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
				</div>
				<div class="col-lg-6">
					<h3 class="no-margins font-extra-bold text-success">280,200</h3>

					<div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
				</div>
			</div>
			<div class="progress m-t-xs full progress-small">
				<div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
					 class=" progress-bar progress-bar-success">
					<span class="sr-only">35% Complete (success)</span>
				</div>
			</div>
		</div>
		<div class="p-m bg-light border-bottom border-top">
			<span class="font-bold no-margins"> Social talks </span>
			<br>
			<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
			<div class="m-t-md">
				<div class="social-talk">
					<div class="media social-profile clearfix">
						<a class="pull-left">
							<img src="<?php echo base_url(); ?>assets/images/a1.jpg" alt="profile-picture">
						</a>

						<div class="media-body">
							<span class="font-bold">John Novak</span>
							<small class="text-muted">21.03.2015</small>
							<div class="social-content small">
								Injected humour, or randomised words which don't look even slightly believable.
							</div>
						</div>
					</div>
				</div>
				<div class="social-talk">
					<div class="media social-profile clearfix">
						<a class="pull-left">
							<img src="<?php echo base_url(); ?>assets/images/a3.jpg" alt="profile-picture">
						</a>

						<div class="media-body">
							<span class="font-bold">Mark Smith</span>
							<small class="text-muted">14.04.2015</small>
							<div class="social-content">
								Many desktop publishing packages and web page editors.
							</div>
						</div>
					</div>
				</div>
				<div class="social-talk">
					<div class="media social-profile clearfix">
						<a class="pull-left">
							<img src="<?php echo base_url(); ?>assets/images/a4.jpg" alt="profile-picture">
						</a>

						<div class="media-body">
							<span class="font-bold">Marica Morgan</span>
							<small class="text-muted">21.03.2015</small>

							<div class="social-content">
								There are many variations of passages of Lorem Ipsum available, but the majority have
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="p-m">
			<span class="font-bold no-margins"> Sales in last week </span>
			<div class="m-t-xs">
				<div class="row">
					<div class="col-xs-6">
						<small>Today</small>
						<h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
					</div>
					<div class="col-xs-6">
						<small>Last week</small>
						<h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<small>Today</small>
						<h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
					</div>
					<div class="col-xs-6">
						<small>Last week</small>
						<h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
					</div>
				</div>
			</div>
			<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
				Many desktop publishing packages and web page editors.
			</small>
		</div>

	</div> -->

	<!-- Footer-->
	<footer class="footer">
        <span class="pull-right">
            Example text
        </span>
		Company 2015-2020
	</footer>

</div>

<!-- Vendor scripts -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/sparkline/index.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/d3/d3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/c3/c3.min.js"></script>

<!-- App scripts -->
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>


<script>

	$(function () {

		// Wait until all panels will be render
		// Remove setTimeout if you don't use animate-panel effect

		c3.generate({
			bindto: '#lineChart',
			data:{
				columns: [
					['data1', 30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250],
					['data2', 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40]
				],
				colors:{
					data1: '#62cb31',
					data2: '#BABABA'
				}
			}
		});

		c3.generate({
			bindto: '#areaChart',
			data:{
				columns: [
					['data1', 300, 350, 300, 0, 0, 0],
					['data2', 130, 100, 140, 200, 150, 50]
				],
				types: {
					data1: 'area',
					data2: 'area-spline'
				},
				colors:{
					data1: '#62cb31',
					data2: '#BABABA'
				}
			}
		});

		c3.generate({
			bindto: '#scatter',
			data:{
				xs:{
					data1: 'data1_x',
					data2: 'data2_x'
				},
				columns: [
					["data1_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8],
					["data2_x", 3.3, 2.7, 3.0, 2.9, 3.0, 3.0, 2.5, 2.9, 2.5, 3.6, 3.2, 2.7, 3.0, 2.5, 2.8, 3.2, 3.0, 3.8, 2.6, 2.2, 3.2, 2.8, 2.8, 2.7, 3.3, 3.2, 2.8, 3.0, 2.8, 3.0, 2.8, 3.8, 2.8, 2.8, 2.6, 3.0, 3.4, 3.1, 3.0, 3.1, 3.1, 3.1, 2.7, 3.2, 3.3, 3.0, 2.5, 3.0, 3.4, 3.0],
					["data1", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
					["data2", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8]
				],
				colors:{
					data1: '#62cb31',
					data2: '#BABABA'
				},
				type: 'scatter'
			}
		});

		c3.generate({
			bindto: '#stocked',
			data:{
				columns: [
					['data1', 30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250,30, 200, 100, 400, 150, 250]
				//	['data2', 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25, 50, 20, 10, 40]

				],
				colors:{
					data1: '#DC143C'
				},
				type: 'bar',
				groups: [
					['data1']
				]
			}
		});

		c3.generate({
			bindto: '#gauge',
			data:{
				columns: [
					['data', 60.4]
				],

				type: 'gauge'
			},
			color:{
				pattern: ['#62cb31', '#BABABA']

			}
		});

		c3.generate({
			bindto: '#gauge2',
			data:{
				columns: [
					['data', 51.4]
				],

				type: 'gauge'
			},
			color:{
				pattern: ['#62cb31', '#BABABA']

			}
		});

		c3.generate({
			bindto: '#pie',
			data:{
				columns: [
					['data1', 30],
					['data2', 120]
				],
				colors:{
					data1: '#62cb31',
					data2: '#CFCFCF'
				},
				type : 'pie'
			}
		});




	});

</script>

</body>
</html>
