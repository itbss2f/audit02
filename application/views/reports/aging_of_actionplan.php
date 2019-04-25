

<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry')?>">Home</a></li>
    <li class="active">Reports</li>
    <li class="active">Aging of Action Plan</li>
</div>
    <!-- begin row -->
    <!-- begin page-header -->
    <!--<h1 class="page-header">IES - Audit Action Plan </h1>-->
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <!--Begin Header-->
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <!--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
                    </div>
                    <h4 class="panel-title">Aging of Action Plan - <?php echo $this->session->userdata('sess_company_name');?></h4>
                </div>
                <!--End of Header-->
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group block1">
                            <input class="form-control" type="hidden" id="user_company" name="user_company" value="<?php echo $this->session->userdata('sess_company_id');?>"/>
                        </div>
                        <div class="col-md-1" id="date_as" style="display: none;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="datefrom_as" id="datefrom_as" placeholder="Date as of"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" id="date_period" style="display: none;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="datefrom" id="datefrom" placeholder="Date from"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" id="date_period2" style="margin-left: 75px;display: none;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="dateto" id="dateto" placeholder="to"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="input-group" style="margin-top:12px;">
                                <label class="control-label">Reporting Period</label>
                                <select class="form-control" name="report_period" id="report_period" style="width:150px;">
                                <option value="">-----</option>
                                <option value="1">As of</option>
                                <option value="2">Date Period</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 70px;">
                                <label class="control-label">Project Name</label>
                                <select class="form-control" name="project_name" id="project_name" style="width:210px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_project as $row) : ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 100px;">
                                <label class="control-label">Departments</label>
                                <select class="form-control" name="dept" id="dept" style="width:250px;">
                                <option value="0">All</option>
                                <?php foreach ($dept as $row) : ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 170px;">
                                <label class="control-label">Report Type</label>
                                <select class="form-control" name="reporttype" id="reporttype" style="width:150px;">
                                <option value="1">All</option>
                                <option value="2">Aging by Department</option>
                                <option value="3">Aging by Project</option>
                                <option value="4">Aging by Company</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="generate">
                            <div class="input-group" style="margin-top :34px;margin-left: 140px;">
                                <button type="button" class="btn btn-success" name="generatereport" id="generatereport">Generate</button>
                            </div>
                        </div>
                        <div class="col-md-2" id="export">
                            <div class="input-group" style="margin-top :34px;margin-left: 50px;">
                                <button type="button" class="btn btn-success" name="export_aging" id="export_aging_1">Export</button>
                            </div>
                        </div>
                        <div class="col-md-2" id="generate2" style="display: none;">
                            <div class="input-group" style="margin-top :34px;margin-left: 140px;">
                                <button type="button" class="btn btn-success" name="generatereport2" id="generatereport2">Generate</button>
                            </div>
                        </div>
                        <!--<div class="col-md-2" id="export2" style="display: none;">
                            <div class="input-group" style="margin-top :34px;margin-left: 10px;">
                                <button type="button" class="btn btn-success" name="export_aging" id="export_aging">Export</button>
                            </div>
                        </div>-->
                    </div>
                    <div class="report_generator" style="height:800px;margin-top:5px"><iframe style="width:99%;height:99%" id="source"></iframe></div>
                </div>
            </div>
        </div>
        <div class="dr"><span></span></div>
    </div>

<script>
$(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
var errorcssobj = {'background': '#E1CECE','border' : '1px solid #FF8989'};
var errorcssobj2 = {'background': '#E0ECF8','border' : '1px solid #D7D7D7'};


$("#generatereport").click(function(response) {

    var datefrom_as = $("#datefrom_as").val();
    var report_period = $("#report_period").val();
    var reporttype = $("#reporttype").val();
    var dept = $("#dept").val();
    var project_name = $("#project_name").val();
    var user_company = $("#user_company").val();


    var countValidate = 0;
    var validate_fields = ['#datefrom_as','#report_period'];

    for (x = 0; x < validate_fields.length; x++) {
        if($(validate_fields[x]).val() == "") {
            $(validate_fields[x]).css(errorcssobj);
              countValidate += 1;
        } else {
              $(validate_fields[x]).css(errorcssobj2);
        }

    }

    if (countValidate == 0) {

        $("#source").attr('src', "<?php echo site_url('actionplan_report/generatereport') ?>/"+datefrom_as+"/"+reporttype+"/"+dept+"/"+project_name+"/"+user_company+"/"+report_period);

    }

});

$("#generatereport2").click(function(response) {

    //var datefrom_as = $("#datefrom_as").val();
    var datefrom = $("#datefrom").val();
    var dateto = $("#dateto").val();
    var report_period = $("#report_period").val();
    var reporttype = $("#reporttype").val();
    var status = $("#status").val();
    var dept = $("#dept").val();
    var project_name = $("#project_name").val();
    var user_company = $("#user_company").val();

    var countValidate = 0;
    var validate_fields = ['#datefrom','#dateto','#report_period'];

    for (x = 0; x < validate_fields.length; x++) {
        if($(validate_fields[x]).val() == "") {
            $(validate_fields[x]).css(errorcssobj);
              countValidate += 1;
        } else {
              $(validate_fields[x]).css(errorcssobj2);
        }

    }

    if (countValidate == 0) {

        $("#source").attr('src', "<?php echo site_url('actionplan_report/generatereport2') ?>/"+datefrom+"/"+dateto+"/"+reporttype+"/"+status+"/"+dept+"/"+project_name+"/"+user_company+"/"+report_period);

    }

});

$(document).ready( function() {

    $("#export_aging_1").die().live("click",function() {

        var datefrom_as = $("#datefrom_as").val();
        var report_period = $("#report_period").val();
        var reporttype = $("#reporttype").val();
        var dept = $("#dept").val();
        var project_name = $("#project_name").val();
        var user_company = $("#user_company").val();

        //alert ('Hoy'); exit;

        var countValidate = 0;  
        var validate_fields = ['#datefrom_as','#report_period'];
        
        for (x = 0; x < validate_fields.length; x++) {            
            if($(validate_fields[x]).val() == "") {                        
                $(validate_fields[x]).css(errorcssobj);          
                  countValidate += 1;
            } else {        
                  $(validate_fields[x]).css(errorcssobj2);       
            }        
          
        }
        if (countValidate == 0)
        
        { 
        window.open("<?php echo site_url('actionplan_report/aging_excelreport/') ?>?datefrom_as="+datefrom_as+"&report_period="+report_period+"&reporttype="+reporttype+"&dept="+dept+"&project_name="+project_name+"&user_company="+user_company, '_blank');
            window.focus();
        }


    });
});

</script>

<?php include('script_forreport.php'); ?>
