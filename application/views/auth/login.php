<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>IES - Audit Monitoring System</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
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
    <div class="login-cover">
        <!--<div class="login-cover-image"><img src="assets/img/login-bg/bg-1.jpg" data-id="login-cover-image" alt="" /></div>-->
        <div class="login-cover-bg"></div>
    </div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated flipInX">
            <div class="login-content">
                <form action="<?php echo site_url('auth/validate') ?>" method="POST" class="margin-bottom-0" data-parsley-validate="true" class="formsave" id="formsave">
                    <div class="brand" style="margin-bottom: 5px;color: white; margin-left: 80px;">
                        <!--<img src="/themes/img/logo.jpg" style="width: 20px;height: 10px;margin-right: 5px;margin-bottom: 30px;"></img>-->
                        IES - AUDIT MONITORING SYSTEM
                        <small></small>
                    </div>
                    <div class="form-group m-b-20">
                        <input autocomplete="off" type="text" class="form-control" name="username" id="username" placeholder="Username" maxlength="30" data-parsley-required="true"/>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" class="form-control" name="userpass" id="userpass" placeholder="Password" maxlength="30" data-parsley-required="true"/>
                    </div>
                    <div class="form-group m-b-20">
                        <label style="font-size: 12px;font-weight: bold;">Company</label>
                        <select class="form-control" id="company_id" name="company_id" data-parsley-required="true" required/>
                        <option value="">----</option>
                        <?#php foreach ($xcompany as $row) :?>
                        <option value="<?#php echo $row['id']?>"><?#php echo $row['name'] ?></option>
                        <?#php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group btn-danger"><center><?php echo $this->session->flashdata('error_login'); ?></center>
                        <div class="login-buttons">
                            <button type="submit" name="submit" id="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
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
    <script src="<?php echo base_url() ?>themes/plugins/parsley/dist/parsley.js"></script>
	<script src="<?php echo base_url() ?>themes/js/login-v2.demo.min.js"></script>
	<script src="<?php echo base_url() ?>themes/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $("#submit").click(function() {
            $('#formsave').submit();
        return true;
        });

        $("#username").keyup(function(){
        var $username = $("#username").val();
        $.ajax({
            url: "<?php echo site_url('auth/ajaxCompany')?>",
            type: 'post',
            data: {username: $username},
            success: function(response) {

                var $response = $.parseJSON(response);
                $('#company_id').empty();
                var option1 = $('<option>').val('').text('------');
                $('#company_id').append(option1);
                $.each($response['company_id'], function(x)
                 {
                     var xitem = $response['company_id'][x];
                     var option2 = $('<option>').val(xitem['company_id']).text(xitem['name']);
                     $('#company_id').append(option2);
                 });
                }
            });
        });
    </script>
	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
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

</body>
</html>
