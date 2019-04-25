
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry')?>">Home</a></li>
    <li class="active">Reports</li>
    <li class="active">Status of Issues</li>
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
                    <h4 class="panel-title">Status of Issues - <?php echo $this->session->userdata('sess_company_name');?></h4>
                </div>
                <div class="panel-body"> 
                    <div class="row">
                        <div class="form-group block1">
                            <input class="form-control" type="hidden" id="user_company" name="user_company" value="<?php echo $this->session->userdata('sess_company_id');?>"/>    
                        </div>
                        <div class="col-md-1" id="date_period" style="display: none;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="datefrom" id="datefrom" placeholder="Date from"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" id="date_period2" style="display: none;margin-left: 75px;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="dateto" id="dateto" placeholder="Date to"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" id="date_as" style="display: none;">
                            <div class="input-group">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="datefrom_as" id="datefrom_as" placeholder="Date as of"/>
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
                            <div class="input-group" style="margin-top:12px;margin-left: 75px;">
                                <label class="control-label">Status</label>  
                                <select class="form-control" name="status" id="status" style="width:215px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_status as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'].' - '.$row['status_name'] ?></option>
                                <?php endforeach; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 135px;">
                                <label class="control-label">Departments</label>
                                <select class="form-control" name="dept" id="dept" style="width:270px;">
                                <option value="0">All</option>
                                <?php foreach ($dept as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 250px;">
                                <label class="control-label">Risk</label>   
                                <select class="form-control" name="risk" id="risk" style="width:230px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_risk as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description']?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="input-group" style="margin-top:12px;">
                                <label class="control-label">Project Name</label>  
                                <select class="form-control" name="project_name" id="project_name" style="width:150px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_project as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description']?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 75px;">
                                <label class="control-label">Issue</label>  
                                <select class="form-control" name="issue" id="issue" style="width:220px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_issue as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description']?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 140px;">
                                <label class="control-label">Report Type</label>  
                                <select class="form-control" name="reporttype" id="reporttype" style="width:210px;">                                                                                                                
                                <option value="6">All</option>                                                                                           
                                <option value="1">Status of Issues by Status</option>                                                                                           
                                <option value="2">Status of Issues by Department</option>                                                                                           
                                <option value="3">Status of Issues by Risk</option>                                                                                           
                                <option value="4">Status of Issues by Issue</option>                                                                                           
                                <option value="5">Status of Issues by Project Name</option>                                                                                           
                                </select>
                            </div>      
                        </div>
                        <div class="col-md-1" id="generate">
                            <div class="input-group" style="margin-top :34px;margin-left: 195px;">
                                <button type="button" class="btn btn-success" name="generatereport" id="generatereport">Generate</button>
                            </div>
                        </div>
                        <div class="col-md-2" id="export">    
                            <div class="input-group" style="margin-top :34px;margin-left: 210px;">
                                <button type="button" class="btn btn-success" name="export_aging" id="export_aging">Export</button> 
                            </div>       
                        </div>
                        <div class="col-md-1" id="generate2" style="display: none;">
                            <div class="input-group" style="margin-top :34px;margin-left: 195px;">
                                <button type="button" class="btn btn-success" name="generatereport2" id="generatereport2">Generate</button>
                            </div>       
                        </div>
                        <div class="col-md-2" id="export2" style="display: none;">    
                            <div class="input-group" style="margin-top :34px;margin-left: 210px;">
                                <button type="button" class="btn btn-success" name="export_aging" id="export_aging">Export</button> 
                            </div>       
                        </div>              
                    </div>
                    <div class="report_generator" style="height:800px;margin-top:5px"><iframe style="width:99%;height:99%" id="source"></iframe> 
                    </div>
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
    var reporttype = $("#reporttype").val();
    var status = $("#status").val();
    var dept = $("#dept").val();
    var risk = $("#risk").val();
    var issue = $("#issue").val();
    var project_name = $("#project_name").val();
    var user_company = $("#user_company").val();
    

    var countValidate = 0;  
    var validate_fields = ['#datefrom_as'];  
    
    for (x = 0; x < validate_fields.length; x++) {            
        if($(validate_fields[x]).val() == "") {                        
            $(validate_fields[x]).css(errorcssobj);          
              countValidate += 1;
        } else {        
              $(validate_fields[x]).css(errorcssobj2);       
        }  
              
    } 
   
    if (countValidate == 0) {
    
    $("#source").attr('src', "<?php echo site_url('issue_report/generatereport') ?>/"+datefrom_as+"/"+reporttype+"/"+status+"/"+dept+"/"+risk+"/"+issue+"/"+project_name+"/"+user_company);          

    }
    
}); 

$("#generatereport2").click(function(response) {
    
    var datefrom = $("#datefrom").val();
    var dateto = $("#dateto").val();
    var reporttype = $("#reporttype").val();
    var status = $("#status").val();
    var dept = $("#dept").val();
    var risk = $("#risk").val();
    var issue = $("#issue").val();
    var project_name = $("#project_name").val();
    var user_company = $("#user_company").val();
    

    var countValidate = 0;  
    var validate_fields = ['#datefrom', '#dateto'];  
    
    for (x = 0; x < validate_fields.length; x++) {            
        if($(validate_fields[x]).val() == "") {                        
            $(validate_fields[x]).css(errorcssobj);          
              countValidate += 1;
        } else {        
              $(validate_fields[x]).css(errorcssobj2);       
        }  
              
    } 
   
    if (countValidate == 0) {
    
    $("#source").attr('src', "<?php echo site_url('issue_report/generatereport2') ?>/"+datefrom+"/"+dateto+"/"+reporttype+"/"+status+"/"+dept+"/"+risk+"/"+issue+"/"+project_name+"/"+user_company);          

    }
    
});

</script> 

<?php include('script_forreport.php'); ?> 



 

   

                          
            
                    
