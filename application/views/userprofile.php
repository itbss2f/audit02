
        <!-- begin #header -->
        <div id="header" class="table-responsive header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="javascript:;" class="navbar-brand">
                      <span><img alt="image" class="square" style="max-height: 62px; min-height: 62px ;max-width: 150px; min-width: 150px;" src="<?php echo base_url() ?>./themes/img/company/<?php echo $this->session->userdata('sess_company_id');?>/logos.png"/></span>
                    </a>
                      <!--<span><#?php echo $this->session->userdata('sess_company_name');?></span></a>-->
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->
                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right" style="margin-top: 15px;margin-right: 30px;">
                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <!--<img src="/uploads/photos/003038603/img0001.jpg" alt="" />-->
                            <span class="hidden-xs">
                                 <?php echo $this->session->userdata('sess_fullname');?>
                            </span><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                           <li><a id="edituserx" class="edituserx">Change Username and Password</a></li>
                            <!--<li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li> -->
                            <!--<li><a href="javascript:;">Calendar</a></li>-->
                            <!--<li><a href="javascript:;">Setting</a></li>-->
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo site_url('auth/logout') ?>">
                                    <i class="fa fa-power-off"></i>
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->

<div id="modal_add_userx" title="Change Username and Password"></div>

<script>

$(function() {
    $('#modal_add_userx').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 460,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.edituserx').click(function() {
        $.ajax({
          url: "<?php echo site_url('user/userchange') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_add_userx").html($response['userchange']).dialog('open');
              }
           });
        });
        return false;
    });

</script>
