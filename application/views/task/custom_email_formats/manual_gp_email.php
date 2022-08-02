<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Manual Gate Pass</title>

<style>

/* -------------------------------------
		GLOBAL
------------------------------------- */
* {
	margin:0;
	padding:0;
}
* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

img {
	max-width: 100%;
}
.collapse {
	margin:0;
	padding:0;
}
body {
	-webkit-font-smoothing:antialiased;
	-webkit-text-size-adjust:none;
	width: 100%!important;
	height: 100%;
}


/* -------------------------------------
		ELEMENTS
------------------------------------- */
a { color: #2BA6CB;}

.btn {
	text-decoration:none;
	color: #FFF;
	background-color: #666;
	padding:10px 16px;
	font-weight:bold;
	margin-right:10px;
	text-align:center;
	cursor:pointer;
	display: inline-block;
}

p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
/* 	padding:15px; */
	background-color: #ebebeb;

}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn {
	display:block;
	width:100%;
}

/* -------------------------------------
		HEADER
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* -------------------------------------
		BODY
------------------------------------- */
table.body-wrap { width: 100%;}


/* -------------------------------------
		FOOTER
------------------------------------- */
table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;

}


/* -------------------------------------
		TYPOGRAPHY
------------------------------------- */
h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul {
	margin-bottom: 10px;
	font-weight: normal;
	font-size:14px;
	line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
	margin-left:5px;
	list-style-position: inside;
}

/* -------------------------------------
		SIDEBAR
------------------------------------- */
ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
	text-decoration:none;
	color: #666;
	padding:10px 16px;
/* 	font-weight:bold; */
	margin-right:10px;
/* 	text-align:center; */
	cursor:pointer;
	border-bottom: 1px solid #777777;
	border-top: 1px solid #FFFFFF;
	display:block;
	margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* ---------------------------------------------------
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure.
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
	padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block;
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap {
	padding:0!important;
	margin:0 auto;
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }

/* -------------------------------------------
		PHONE
		For clients that support media queries.
		Nothing fancy.
-------------------------------------------- */
/* @media only screen and (max-width: 600px) {

	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}

	table.social div[class="column"] {
		width:auto!important;
	}
} */

#tbl1, #tbl2 {
  width:100%;
}

#tbl1 th {
	font-size : 12px;
	height : 18px;
	padding : 5px;
	text-align: left;
}

#tbl1 td {
	font-size : 11px;
	height : 18px;
	padding : 5px;
	text-align: left;
}

#tbl2 td {
  color : #000;
	font-size : 11px;
	border-style : solid;
	border-width : 1px;
	height : 15px;
	padding : 5px;
	border-color: #C0C0C0;
	text-align: center;
}

#tbl2 th {
  background-color : #27ae60;
	color : #FFF;
	font-size : 13px;
	border-style : solid;
	border-width : 1px;
	height : 15px;
	padding : 5px;
	border-color: #C0C0C0;
	text-align: center;
}

#soc-btn-approve {
  border: solid 10px #3B5998;
	font-size:13px;
	color: #FFF;
  font-weight:bold;
	text-align:center;
  background-color: #3B5998;
}

#soc-btn-reject {
  border: solid 10px #DB4A39;
	font-size:13px;
	color: #FFF;
  font-weight:bold;
	text-align:center;
  background-color: #DB4A39;
}

</style>

</head>

<body bgcolor="#FFFFFF" style="text-align:center">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#27ae60" style="width:70%;text-align:center">
	<tr>
		<td></td>
		<td class="header container" >

				<div class="content">
				<table bgcolor="#27ae60">
					<tr>
						<!-- <td><img style="width:50%;" src="" /></td> -->
						<td style="text-align:center"><h4 class="collapse">MANUAL GATE PASS</h4></td>
					</tr>
				</table>
				</div>

		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap" style="width:70%;text-align:center">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
						<!-- <h3>Hi <?= $task_user_first_name ?>,</h3>
						<p class="lead"><?= $title ?></p> -->
						<p>
              <table id="tbl1">
                <tr>
                  <th>Gate pass no</th>
                  <td>: <?= $gp_header['id']; ?></td>
                  <th>Gate pass type</th>
                  <td>: <?= ucfirst($gp_header['type']); ?></td>
                </tr>
                <tr>
                  <th>Gate pass to</th>
                  <td>: <?= $gp_header['to_address']; ?></td>
                  <th>REF / Style</th>
                  <td>: <?= $gp_header['style']; ?></td>
                </tr>
                <tr>
                  <th>Attention</th>
                  <td>: <?= $gp_header['attention']; ?></td>
                  <th>Through</th>
                  <td>: <?= $gp_header['through']; ?></td>
                </tr>
                <tr>
                  <th>Remarks</th>
                  <td>: <?= $gp_header['remarks']; ?></td>
                  <th>Instructed By</th>
                  <td>: <?= $gp_header['instructed_by']; ?></td>
                </tr>
                <tr>
                  <th>Date</th>
                  <td>: <?= $gp_header['date']; ?></td>
                  <th>Special Instruction</th>
                  <td>: <?= $gp_header['special_instruction']; ?></td>
                </tr>
                <tr>
                  <th>Return Status</th>
                  <td>: <?= ucfirst($gp_header['return_status']); ?></td>
                  <th>Status</th>
                  <td>: <?= $gp_header['status']; ?></td>
                </tr>
								<tr>
                  <th>Requested By</th>
                  <td>: <?= $started_user_first_name ?> <?= $started_user_last_name ?></td>
                  <th></th>
                  <td></td>
                </tr>
              </table>
            </p>

            <p>
              <?php if($gp_header['type'] != 'laysheet transfer') { ?>
        			<table id="tbl2">
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
        						foreach ($gp_items as $row) {
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
        		<?php } ?>

        		<?php if($gp_header['type'] == 'laysheet transfer') { ?>
        		<div class="col-lg-12" style="margin-top: 20px">
        			<table id="tbl2">
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
        						foreach ($gp_laysheets as $row) {
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
            </p>

						<!-- Callout Panel -->
						<p class="callout">
							Hi <?= $task_user_first_name ?>, You can approve or reject this gate pass using below action buttion or log in to the system for more details.
              <br><a href="<?= base_url() ?>index.php/approval_proc/user_tasks">Click Here To Login &raquo;</a>
						</p><!-- /Callout Panel -->

						<!-- social & contact -->
						<table class="social" width="100%">
							<tr>
								<td>

									<!-- column 1 -->
									<table align="left" class="column">
										<tr>
											<td>
												<h5 class="">Approval Actions</h5>
												<p class="">
                          <a href="<?= $approve_link ?>" id="soc-btn-approve">Approve</a>
                          <a href="<?= $reject_link ?>" id="soc-btn-reject">Reject </a>
                        </p>
											</td>
										</tr>
									</table><!-- /column 1 -->

									<!-- column 2 -->
									<table align="left" class="column">
										<tr>
											<td>
												<p class="">This is a system generated email. Please don't reply.</p>
												<p>Dignity DTRT<br/></p>
											</td>
										</tr>
									</table><!-- /column 2 -->

									<span class="clear"></span>

								</td>
							</tr>
						</table><!-- /social & contact -->

					</td>
				</tr>
			</table>
			</div><!-- /content -->

		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">

				<!-- content -->
				<div class="content">

				</div><!-- /content -->

		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>
