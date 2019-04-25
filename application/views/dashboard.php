
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li>Home</li>
    <li class="active">Dashboard</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Dashboard <small></small></h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green-darker">
            <div class="stats-icon"><i class="fa fa-desktop"></i></div>
            <div class="stats-info">
                <h4>TOTAL ACTION PLAN</h4>
                <p><?php echo number_format($total['total_action'], 0, "", ","); ?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo site_url('entry/actionplan')?>">View Details <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
            <div class="stats-info">
                <h4>FOR APPROVAL OF ACTION PLAN</h4>
                <p><?php echo number_format($actionforapproval['actionforapproval'], 0, "", ","); ?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo site_url('entry/actionplanforapproval')?>">
                View Details <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-purple-darker">
            <div class="stats-icon"><i class="fa fa-users"></i></div>
            <div class="stats-info">
                <h4>OVERALL FOR APPROVAL</h4>
                <p><?php echo number_format($total_approval['total'], 0, "", ","); ?></p>
            </div>
            <div class="stats-link">
                <a href="javascript:;"> <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
            <div class="stats-info">
                <h4>TIME ON SITE</h4>
                <p><?php echo date("H:i:s"); ?></p>
            </div>
            <div class="stats-link">
                <a href="javascript:;"> <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->
