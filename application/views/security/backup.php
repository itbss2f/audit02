
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry')?>">Home</a></li>
    <li class="active">Security</li>
    <li class="active">Backup</li>
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
                    <h4 class="panel-title">Backup - <?php echo $this->session->userdata('sess_company_name');?></h4>
                </div>
                <div class="panel-body"> 
                    <div class="row">
                        <div class="form-group block1">
                            <input class="form-control" type="hidden" id="user_company" name="user_company" value="<?php echo $this->session->userdata('sess_company_id');?>"/>    
                            <input class="form-control" type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata('sess_user_id');?>"/>    
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-1">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="datefrom" id="datefrom" placeholder="Trans Datefrom"/>
                            </div>
                        </div>
                        <div class="col-md-3">     
                            <div class="input-group" style="margin-left: 90px;">
                                <input type="text" class="form-control datepicker" name="dateto" id="dateto" placeholder="Trans Dateto"/>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group" style="margin-left: 15px;">
                                <button type="button" class="btn btn-success" name="generatereport" id="generatereport">Retrieve</button>
                            </div>
                        </div>
                        <div class="col-md-1" style="margin-left: 35px;">    
                            <div class="input-group">
                                <button type="button" class="btn btn-success backup" name="backup" id="backup">Backup</button> 
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
$(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
var errorcssobj = {'background': '#E1CECE','border' : '1px solid #FF8989'};
var errorcssobj2 = {'background': '#E0ECF8','border' : '1px solid #D7D7D7'}; 

$("#generatereport").click(function(response) {
    
    var datefrom = $("#datefrom").val();
    var dateto = $("#dateto").val();
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
    
    $("#source").attr('src', "<?php echo site_url('backup_c/generatereport') ?>/"+datefrom+"/"+dateto+"/"+user_company);          

    }
    
}); 

$('#backup').click(function(response) {

    var ans = window.confirm("Are you sure you want to backup?")
    
    var datefrom = $("#datefrom").val();
    var dateto = $("#dateto").val();
    var user_company = $("#user_company").val();
    var user_id = $("#user_id").val();
    
    
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

    if ((countValidate == 0) && (ans)) {                  
        
        $("#source").attr('src', "<?php echo site_url('backup_c/backupexecute') ?>/"+datefrom+"/"+dateto+"/"+user_company+"/"+user_id);          
        window.alert("Successfully backup.");

    } else {
        //window.alert("Are you sure you want to cancel?");
        return false;
    }
    

});

</script>


 

   

                          
            
                    
