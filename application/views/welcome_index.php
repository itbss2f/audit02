<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<meta http-equiv="refresh" content="30" />  -->

    <title> IES - Audit Monitoring System</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
                <!-- ==== BEGIN JS === -->

    <script src="<?php echo base_url() ?>themes/js/jquery-1.11.2.min.js"></script>
    <script src="<?php echo base_url() ?>themes/js/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>themes/js/jquery.maskMoney.js"></script>

    <!--<script src='<?#php echo base_url() ?>themes/js/jquery.js'></script>-->
    <!--<script src='<?#php echo base_url() ?>themes/js/jquery.mockjax.js'></script>-->
    <!--<script src='<?#php echo base_url() ?>themes/js/dist/jquery.validate.js'></script>-->

                <!-- ========= BEGIN PLUGINS ========= -->
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/theme/default.css" rel="stylesheet" id="theme" />
    <link href="<?php echo base_url() ?>themes/plugins/DataTables-1.9.4/css/data-table.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/fonts.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/morris/morris.css" rel="stylesheet" />


    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?php echo base_url() ?>themes/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />

    <!-- ================== END PAGE LEVEL STYLE ================== -->
</head>
<body>

    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
<div id="my_page">
    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- begin #sidebar -->
        <div id="sidebar" class="sidebar" style="padding-top: 0px;margin-top: 70px;">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile" style="width: 220px;">
                         <div class="info" style="font-size: 12px;">
                            <br>Welcome! Today is</br>
                            <?php echo date("l jS \of F Y ") ?>
                        </div>
                        <div class="dropdown profile-element"><span>
                            <img alt="image" class="img-circle" width="50%" style="width:100px;height: 100px;margin-left: 35px;" src="http://erm.inquirer.com.ph/data/uploads/photos/<?php echo $this->session->userdata('sess_emp_id');?>/img0001.jpg"/>
                            </span>
                        </div>
                        <div class="info" style="margin-top: 7px;font-size: 12px;margin-left: 20px;">
                            <?php echo $this->session->userdata('sess_fullname');?>
                        </div>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <?php echo $navigation;?>
                <!-- begin sidebar minify button -->
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
                <!-- end sidebar minify button -->

                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
        </div>

        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->


        <!-- begin #content -->
        <div class="content">

            <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
            </div>
            <?php include('userprofile.php'); ?>
            <?php echo $content; ?>

        </div>
        <!-- end content -->
        <div id="footer" class="footer">
        @<?php echo date("Y") ?> Development of IES - Audit Monitoring System
        </div>

       <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
</div>
    <div id="alert_dialog" title="Notification"></div>


        <!-- ================== BEGIN BASE JS ================== -->
    <script src='<?php echo base_url() ?>assets/js/jquery-1.7.1.min.js'></script>
    <script src='<?php echo base_url() ?>assets/js/jquery-ui-1.8.13.custom.min.js'></script>

    <script src="<?php echo base_url() ?>themes/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>

    <script src="<?php echo base_url() ?>themes/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url() ?>themes/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <script src="<?php echo base_url() ?>themes/plugins/parsley/dist/parsley.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/bootstrap-wizard/js/bwizard.js"></script>
    <script src="<?php echo base_url() ?>themes/js/form-wizards-validation.min.js"></script>
    <script src="<?php echo base_url() ?>themes/js/apps.min.js"></script>
    <script src="<?php echo base_url() ?>themes/js/ui-modal-notification.demo.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo base_url() ?>themes/js/dashboard.min.js"></script>

    <script src="<?php echo base_url() ?>themes/plugins/DataTables-1.9.4/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/DataTables-1.9.4/js/data-table.js"></script>

    <!--<script src='<?#php echo base_url() ?>assets/js/1.10.1/js/jquery.dataTables.js'></script>-->
    <!--<script src='<?#php echo base_url() ?>assets/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
    <!-- ================== END PAGE LEVEL JS ================== -->


    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url() ?>themes/plugins/masked-input/masked-input.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url() ?>themes/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->



<script type='text/javascript'>
$(function(){

    $.extend($.gritter.options, {

       //position: 'bottom-right',

       fade_in_speed: 1000,

       fade_out_speed: 500,

       time: 6000

    });

});
</script>

<script>
    $(document).ready(function() {
        App.init();
        FormWizardValidation.init();
        //FormPlugins.init();
});

/*setInterval(function(){
   $('#my_page').load('');
}, 30000)*/
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
