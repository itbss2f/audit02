
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry')?>">Home</a></li>
    <li class="active">Reports</li>
    <li class="active">Recurring of Action Plans</li>
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
                    <h4 class="panel-title">Recurring of Action Plans</h4>
                </div>
                <!--End of Header-->
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group block1">
                            <input type="hidden" class="form-control" name="user_companyx" id="user_companyx" value="<?php echo $this->session->userdata('sess_company_id');?>"/> 
                        </div>  
                        <div class="col-md-1">
                            <div class="input-group" style="margin-top: 12px;">
                                <label class="control-label">Date Entered</label>
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control datepicker" name="datefrom" id="datefrom" placeholder="Date as of"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left:80px;">
                                <label class="control-label">Status</label>   
                                <select class="form-control" name="status" id="status" style="width: 190px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_status as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'].' - '.$row['status_name'] ?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 115px;">
                                <label class="control-label">Project Name</label>  
                                <select class="form-control" name="project_name" id="project_name" style="width:225px;">
                                <option value="0">All</option>
                                <?php foreach ($ap_project as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;margin-left: 185px;">
                                <label class="control-label">Departments</label>  
                                <select class="form-control" name="dept" id="dept" style="width:205px;">
                                <option value="0">All</option>
                                <?php foreach ($dept as $row) : ?>  
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group" style="margin-top:12px;margin-left: 235px;">
                                <label class="control-label">Recurring</label>
                                <select class="form-control" name="recur" id="recur" style="width:150px;">                                                                                                                
                                <option value="0">All</option>                                                                                           
                                <option value="1">YES</option>                                                                                           
                                <option value="2">NO</option>                                                                                                                                                                                      
                                </select>
                            </div>      
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group" style="margin-top:12px;">
                                <label class="control-label">Report Type</label>
                                <select class="form-control" name="reporttype" id="reporttype" style="width:255px;">                                                                                                                
                                <option value="1">All</option>                                                                                           
                                <option value="2">Recurring by Department</option>                                                                                           
                                <option value="3">Recurring by Project</option>                                                                                                                                                                                      
                                </select>
                            </div>      
                        </div>
                        <div class="col-md-1">
                            <div class="input-group" style="margin-top :34px;margin-left: 100px;">
                                <button type="button" class="btn btn-success" name="generatereport" id="generatereport">Generate</button>
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
    
    var datefrom = $("#datefrom").val();
    //var dateto = $("#dateto").val();
    var reporttype = $("#reporttype").val();
    var status = $("#status").val();
    var dept = $("#dept").val();
    var project_name = $("#project_name").val();
    var recur = $("#recur").val();
    var user_companyx = $("#user_companyx").val(); 
    

    var countValidate = 0;  
    var validate_fields = ['#datefrom'];
    
    for (x = 0; x < validate_fields.length; x++) {            
        if($(validate_fields[x]).val() == "") {                        
            $(validate_fields[x]).css(errorcssobj);          
              countValidate += 1;
        } else {        
              $(validate_fields[x]).css(errorcssobj2);       
        }  
              
    } 
   
    if (countValidate == 0) {
    
    $("#source").attr('src', "<?php echo site_url('recurring/generatereport') ?>/"+datefrom+"/"+reporttype+"/"+status+"/"+dept+"/"+project_name+"/"+recur+"/"+user_companyx);          

    }
    
}); 

</script>    

                          
            
                    
