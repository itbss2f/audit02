
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry')?>">Home</a></li>
    <li class="active">Report</li>
    <li class="active">Monitoring of Status Due</li>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <!--Begin Header-->
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <h4 class="panel-title">Monitoring of Status Due - <?php echo $this->session->userdata('sess_company_name');?></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group block1">
                            <input class="form-control" type="hidden" id="user_company" name="user_company" value="<?php echo $this->session->userdata('sess_company_id');?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="input-group" style="margin-left: 15px;">
                                <button type="button" class="btn btn-success change" name="change" id="change">Change</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group" style="margin-left: 15px;">
                                <button type="button" class="btn btn-success" name="generatereport" id="generatereport">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="report_generator" style="height:800px;margin-top:5px"><iframe style="width:99%;height:99%;margin-right: 5px;" id="source"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>

<script>


$(".change").click(function() {

    var user_company = $("#user_company").val();
    var ans = confirm("Are you sure you want to change? NYD to Due?");

    if (ans) {
        alert ("Successfully change");
        window.location = "<?php echo site_url('status/changeofstatus') ?>/"+user_company;
    }

});


$("#generatereport").click(function(response) {

    var user_company = $("#user_company").val();

    var countValidate = 0;
    var validate_fields = [];

    for (x = 0; x < validate_fields.length; x++) {
        if($(validate_fields[x]).val() == "") {
            $(validate_fields[x]).css(errorcssobj);
              countValidate += 1;
        } else {
              $(validate_fields[x]).css(errorcssobj2);
        }

    }

    if (countValidate == 0) {

    $("#source").attr('src', "<?php echo site_url('status/generatereport') ?>/"+user_company);

    }

});


</script>
