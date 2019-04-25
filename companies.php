<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<head>

    <title>Company Profile</title>
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="<?php echo base_url() ?>themes/css/fonts.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>themes/plugins/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/plugins/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>themes/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid" style="height: 80px;">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="#" class="navbar-brand"><h1 style="font-size:17px;width:500px;margin-top  : 20px;">CHOOSE COMPANY</h1></a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->
                
                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right" style="margin-top: 15px;margin-right: 20px;">
                    <!--<li>
                        <form class="navbar-form full-width">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter keyword" />
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </li>      -->
                    <li class="dropdown">
                       <!-- <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                            <i class="fa fa-bell-o"></i>
                            <span class="label">5</span>
                        </a>  -->
                        <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                            <!--<li class="dropdown-header">Notifications (5)</li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="pull-left media-object bg-red"><i class="fa fa-bug"></i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">Server Error Reports</h6>
                                        <div class="text-muted">3 minutes ago</div>
                                    </div>
                                </a>
                            </li>   -->
                        </ul>
                    </li>
                    <li class="dropdown navbar-user">
                        <li>
                            <a href="<?php echo site_url('auth/logout') ?>">
                                <i class="fa fa-power-off"></i>
                                Log Out
                            </a>
                        </li>
                    </li>
                </ul>
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->
        
        <!-- begin #content -->
        <div id="content" class="content" style="margin-left: 180px;margin-right: 180px;margin-top: 80px;">
            <!-- begin superbox --> 
            <div class="col-lg-10 col-lg-offset-1 text-center" class="company">
                <div class="row">
                    <div class="col-md-4" id="pdi">
                        <div class="superbox-list" style="width: 235px;">
                            <a href="<?php echo site_url('entry') ?>">
                                <img src="<?php echo base_url() ?>themes/img/company/pdilogo.jpg" alt="" class="superbox-img" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <a href="<?php echo site_url('entry') ?>"> 
                                <img src="<?php echo base_url() ?>themes/img/company/icmlogo.jpg" alt="" class="superbox-img" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <a href="<?php echo site_url('entry') ?>">  
                                <img src="<?php echo base_url() ?>themes/img/company/hiplogo.jpg" alt="" class="superbox-img" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3px;">
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <a href="#">
                                <img src="" alt="" class="superbox-img" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3px;">
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3px;">
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="superbox-list" style="width: 235px;">
                            <img src="" alt="" class="superbox-img" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- end superbox -->
        </div>
        <!-- end #content -->
        
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url() ?>themes/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>themes/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url() ?>themes/plugins/superbox/js/superbox.js"></script>
    <script src="<?php echo base_url() ?>themes/js/gallery-v2.demo.min.js"></script>
    <script src="<?php echo base_url() ?>themes/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function() {
            App.init();
            Gallery.init();
        });
    </script>    
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-53034621-1', 'auto');
      ga('send', 'pageview');
    
    </script>
    
    <script>
    $("#pdi").click(function() {
       
       alert("Hello pdi");
        
        
    });
    </script>
</body>
</html>

