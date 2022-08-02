<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PMCS | Production Dashboard</title>

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
<style type="text/css">
    .font1{
        font-family: CenturyGothic, sans-serif;
        font-size: 20px;
        font-variant: normal;
        font-weight: 700;
        color: white;
        text-align: center;
    }
    .font2{
        font-family: CenturyGothic, sans-serif;
        font-size: 20px;
        font-variant: normal;
        font-weight: 700;
        color: black;
        text-align: center;
    }

    .font_blue{
        font-family: CenturyGothic, sans-serif;
        font-size: 20px;
        font-variant: normal;
        font-weight: 700;
        color: blue;
        text-align: center;
    }

    .font_red{
        font-family: CenturyGothic, sans-serif;
        font-size: 20px;
        font-variant: normal;
        font-weight: 700;
        color: red;
        text-align: center;
    }


</style>
<body style="background: black">


    <!-- Site wrapper -->


    <!-- =============================================== -->

    <input type="hidden" value="<?php echo base_url(); ?>" id="base-url">




        <!-- <h4 style="margin-bottom:20px;text-align:center;font-weight:bold">Dashboard : </h4> -->


        <div class="col-md-12" style="margin-bottom:20px">
           <div class="row">
               <div class="col-md-3"><!--<input type="hidden" name="" value="<?php echo $section;?>" id="section">--></div>
               <div class="col-md-3"></div>
               <div class="col-md-3"></div>
               <div class="col-md-3"></div>
               <div class="col-md-3"></div>
           </div>


           <div class="row" style="margin-left: auto;margin-top: auto;margin-bottom: auto;margin-right: auto;" >
             <!--  <div class="col-md-1 "></div> -->
             <div class="col-md-12 " style="margin-right: auto; margin-left: auto;">
                <table class="table table-bordered" id="table_production"  style="background: white" >
                    <thead>
                        <tr class="font1" bgcolor="black">
                            <td class="font1" colspan="8">Hourly Production Status</td>
                            <td colspan="10">Hour</td>

                        </tr>
                        <tr class="font1" bgcolor="black">
                            <td class="font1"></td>
                            <!--<td>Supervisor</td>-->
                            <td>Module</td>
                            <td>Style</td>
                            <td>Plan</td>
                            <td>Commited</td>
                            <td>PCS/HR</td>
                            <td>Prod.QTY</td>
                            <td>Variance</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font2">
                            <td style="text-align: center;color: white" class="font2">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>
                            <td style="text-align: center;color: white">0</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <!--  <div class="col-md-1"></div> -->
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

    <script src="<?php echo base_url(); ?>assets/views/dashboard/dashboard_a.js?v1.1"></script>

    <script src="<?php echo base_url(); ?>assets/application/app.js"></script>


    <script src="<?php echo base_url(); ?>assets/application/waiting_dialogbox.js"></script>

    <!-- jquery form validator plugin -->

    <script src="<?php echo base_url(); ?>/assets/application/form_validator_v3.js"></script>


    <script src="<?php echo base_url(); ?>assets/vendor/alert/jquery-confirm.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/views/report/wip_report.js"></script>

    <script>

        var BASE_URL = '<?php echo base_url(); ?>';

    </script>


</body>

</html>
