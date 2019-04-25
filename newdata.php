<div class="breadcrumb pull-right" style="margin-right: 10px;">
    <li><i class="fa fa-home"></i>Home</li>
    <li class="active"><i class="fa fa-file"></i> Transaction</li>
    <li class="active"><i class="fa fa-plus-square"></i> Add Action Plan</li>
</div>
<div class="row">                       
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <button id="refresh" title="Reload" class="btn btn-xs fa fa-repeat btn-danger pull-right" style="height: 22px;width:30px;margin-bottom: 1px;"></button>
                    <div class="btn-group pull-right" style="margin-right: 1px;margin-top: 1px;">
                        <button type="button" class="btn btn-square btn-success btn-xs"><i class="fa fa-navicon"></i></button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="<?php echo site_url('entry/listofAction')?>">
                                    Audit Action Plan Records
                                </a>
                            </li>
                        </ul>
                    </div>          
                </div>
                <h4 class="panel-title">Audit Action Plan Form - <?php echo $this->session->userdata('sess_company_name');?></h4>  
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('entry/save') ?>" method="POST" data-parsley-validate="true" name="form-wizard" id="formsave" class="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Action Plan </label> <!--Step 1-->                              
                            </li>
                            <li>
                                <label> Issues / Status</label> <!--Step 2-->
                            </li> 
                        </ol>
                        <!--begin wizard step-1-->
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input style="width: 200px" class="btn btn-success btn-xs" type="text" id="entered_date" name="entered_date" value="<?php echo date('F j\, Y \ l'); ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Action Plan</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <Label>Action Plan:</label>
                                            <textarea class="textarea form-control" id="action_plan" name="action_plan" placeholder="Enter Action Plan ..." rows="8" data-parsley-group="wizard-step-1" data-parsley-required="true" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend> 
                                <div class="row">
                                        <div class="form-group block1">
                                            <input class="form-control" type="hidden" id="company" name="company" value="<?php echo $this->session->userdata('sess_company');?>"/>    
                                        </div>  
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>   
                                            <select class="form-control" id="emp" name="emp" data-parsley-group="wizard-step-1" data-parsley-required="true"/>
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>  
                                            <select class="form-control" name="dept" id="dept" data-parsley-group="wizard-step-1" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($dept as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="emp2" name="emp2">
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Project Name / Recurring</legend> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" id="project_id" name="project_id" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_project as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="recur" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly" disabled="disabled">
                                                     Recurring: 
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="1" name="recur" style="margin-top: 1px;"/>
                                                    YES
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="2" name="recur" style="margin-top: 1px;"/>
                                                    NO
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>Audit Staff</label>
                                            <select class="form-control" id="assigned_audit" name="assigned_audit" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                                <option value="">----</option>   
                                                <?php foreach ($ap_users as $row) : ?>
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['audit_staff'] ?></option>
                                                <?php endforeach; ?>    
                                            </select>  
                                        </div>                                
                                    </div> 
                                </div> 
                            </fieldset>
                        </div>
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                        <fieldset>
                            <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Issue Details</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Issue</label>
                                            <select class="form-control" id="issue" name="issue" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_issue as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <Label>Issue Remarks:</label>
                                            <textarea class="textarea form-control" id="remarks" name="remarks" placeholder="Enter Remarks ..." rows="8"></textarea> 
                                        </div>
                                    </div>     
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <Label>Business Concern:</label>
                                            <textarea class="textarea form-control" id="issue_remarks" name="issue_remarks" placeholder="Enter Business Concern ..." rows="8" data-parsley-required="true" required></textarea> 
                                        </div>
                                    </div> 
                                    <!-- end col -->
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risks</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Risk 1</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk1" name="risk1" data-parsley-required="true">
                                            <option value="">------</option>
                                            <?php foreach ($ap_risk as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- begin col -->
                                    <div class="col-md-4" id="_risk2" style="display: none;">
                                        <label>Risk 2</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk2" name="risk2">
                                            <option value="">------</option>
                                            <?php foreach ($ap_risk2 as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <!-- begin col -->
                                    <div class="col-md-4" id="_risk3" style="display: none;">
                                        <label>Risk 3</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk3" name="risk3">
                                            <option value="">------</option>
                                            <?php foreach ($ap_risk3 as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                                <!--<legend class="pull-left width-full" style="font-size: 14px;font-weight: bold;">Risk Rating</legend>-->  
                                <!-- begin row -->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risk Rating</legend> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Risk Rating</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk_rating" name="risk_rating" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_risk_rating as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Impact/Value</label>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" value="0.00" maxlength="16" placeholder="Enter Impact value"/>
                                        </div>         
                                    </div>          
                                </div>
                                <!-- end row -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Impact Computation Basis</label>
                                            <textarea class="textarea form-control" id="impact_remarks" name="impact_remarks" placeholder="Enter Impact Computation ..." rows="5"></textarea>
                                        </div>         
                                    </div>         
                                </div>
                                <!--end row -->         
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-4" id="_status">
                                        <div class="form-group">
                                            <Label>Status</label>
                                            <select class="form-control" id="status" name="status" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_status as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_name'] ?></option>
                                            <?php endforeach; ?>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Date tag as Implemented</label> 
                                            <?php if ($ap_status == 2): ?>
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="<?php echo date('F j\, Y \ l') ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="" readonly="readonly"/>  
                                            <?php endif; ?>
                                        </div>       
                                    </div>
                                </div>
                                <!-- end row -->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Due Dates</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <!-- begin col -->
                                    <div class="col-md-4">
                                        <Label>Due Date</label>
                                        <div class="input-group date">
                                            <input type="date" class="form-control" id="due_date" name="due_date" data-parsley-required="true">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <!-- begin col --> 
                                    <div class="col-md-4" id="_daterevised" style="display: none;">
                                        <label>Date Revised</label>
                                        <div class="input-group date">
                                            <input type="date" class="form-control" id="date_revised" name="date_revised" placeholder="   Select Revised Due Date"/>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <!-- begin col -->
                                    <div class="col-md-4" id="_dateimplement">
                                        <label>Date Implemented</label>
                                        <div class="input-group date">
                                            <input type="date" class="form-control" name="date_implemented" id="date_implemented" placeholder="   Select Date Implemented" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- begin row -->
                                <div class="row-form-booking pull-right">
                                    <button type="save" class="btn btn-success btn-sm" id="save" name="save" value="save" style="margin-top : 12px;">Save</button>
                                    <!--<button class="btn btn-success btn-sm" id="close" name="close" style="margin-top : 12px;" >Close</button>-->
                                </div>             
                        </fieldset>
                        </div>
                        <!-- end wizard step-2 -->
                    </div>
                </form>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- end row -->

<script>

$(function() {
    $('#risk1').change(function(){
         if($('#risk1').val() == '') {
            $('#_risk2').hide();
            $('#_risk3').hide();  
        } else {
            $('#_risk2').show(); 
        } 
    });
    $('#risk2').change(function(){
        if($('#risk2').val() == '') {
            $('#_risk3').hide(); 
        } else {
            $('#_risk3').show(); 
        }     
    });
});

$("#risk1").change(function() {
    var $id = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk1')?>",
        type: 'post',
        data: {id: $id}, 
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk2').empty();
            var option1 = $('<option>').val('').text('------');  
            $('#risk2').append(option1);                                             
            $.each($response['risk2'], function(x)                     
             {
                 var xitem = $response['risk2'][x];                 
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk2').append(option2);                                             
             });

            $('#risk3').empty();
            var option1 = $('<option>').val('').text('------'); 
            $('#risk3').append(option1);
            $.each($response['risk3'], function(x)                     
             {
                 var xitem = $response['risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk3').append(option2);                                             
             }); 
        } 
        
    });
    
});

$("#risk2").change(function() {
    var $id = $("#risk2").val();
    var $id3 = $("#risk3").val();
    var $id1 = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk2')?>",
        type: 'post',
        data: {id: $id, id1: $id1, id3: $id3}, 
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk3').empty();    
            var option1 = $('<option>').val('').text('------');  
            $('#risk3').append(option1);                                             
            $.each($response['risk3'], function(x)                     
             {
                 var xitem = $response['risk3'][x];                 
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk3').append(option2);                                             
             });
             
            //$('#risk1').empty();   
            var option1 = $('<option>').val('').text('------'); 
            $('#risk1').append(option1);
            $.each($response['risk1'], function(x)                     
             {
                 var xitem = $response['risk1'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk1').append(option2);                                             
             });
        } 
    });
}); 

/*$("#risk3").change(function() {
    var $idx = $("#risk3").val();
    var $id2 = $("#risk2").val();
    var $id1 = $("#risk1").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxgetRisk3')?>",
        type: 'post',
        data: {id: $idx, id2: $id2, id1: $id1}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            if ($idx == $id2) {
            $('#risk2').empty();
            } 
            var option1 = $('<option>').val('').text('------');  
            $('#risk2').append(option1);                                             
            $.each($response['risk2'], function(x)                     
             {
                 var xitem = $response['risk2'][x];                 
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk2').append(option2);                                             
             });
             
            if ($idx == $id1) {
            $('#risk1').empty();     
            }
            var option1 = $('<option>').val('').text('------'); 
            $('#risk1').append(option1);
            $.each($response['risk1'], function(x)                     
             {
                 var xitem = $response['risk1'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk1').append(option2);                                             
             });
        } 
    });
});   */


$("#emp").change(function() {
    var $user_id = $("#emp").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxEmployees')?>",
        type: 'post',
        data: {user_id: $user_id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#dept').empty();
            $.each($response['dept'], function(i)
             {
                 var zitem = $response['dept'][i];
                 var option = $('<option>').val(zitem['id']).text(zitem['name']);
                 $('#dept').append(option);                                             
             });
             
            $('#emp2').empty();
            var option1 = $('<option>').val('').text('------');  
            $('#emp2').append(option1);                                             
            $.each($response['person2'], function(i){
                var zitem1 = $response['person2'][i];
                var option = $('<option>').val(zitem1['user_id']).text(zitem1['fullname']);
                $('#emp2').append(option);                                                 
            });
             
        } 
        
    });

});

/*$("#emp2").change(function() {
    var $user_id = $("#emp").val();
    var $id = $("#dept").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxEmpDept')?>",
        type: 'post',
        data: {user_id: $user_id, id: $id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#emp2').empty();
            $.each($response['emp2'], function(x)
             {
                 var xitem = $response['emp2'][x];
                 var option = $('<option>').val(xitem['user_id']).text(xitem['fullname']);
                 $('#emp2').append(option);                                             
             });
        }
        
    });
}); */
$("#impact_value").maskMoney();
$(document).ready(function(){
$("#_status").change(function(){
        var $id = $("#status").val();     
        $.ajax({
           url: "<?php echo site_url('entry/ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
                    if ($id != 2) {
                        $("#date_tag").val("");
                        $("#date_implemented").val(""); 
                        $('.datedayspicker2').prop("readonly", true).next("button").prop("disabled", true);
                   }else{
                $("#date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                $('.datedayspicker2').datepicker({format: 'MM dd, yyyy DD'});
                $("#date_implemented").val('<?php echo date('Y-m-d')?>');
               } 
           }
        })
    });
}); 

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

/*
script for datepicker without previous month 
$(function(){
    $('.datedayspicker').datepicker({
        format: 'MM dd, yyyy DD',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });
});*/

$("#refresh").click(function() {
    var confirm = window.confirm('Are you sure you want to Reload');
    
    if(confirm)
    {
        //alert('System will reload press ok');
        window.location.reload()  
    }
    else {
        alert('Are you sure you want to cancel');
    }
});

$("#save").click(function() {
    
    var issue = $("#issue").val();   
    var risk1 = $("#risk1").val();   
    var risk2 = $("#risk2").val();   
    var risk_rating = $("#risk_rating").val();   
    var status = $("#status").val();       
    var due_date = $("#due_date").val();   
    var dept = $("#dept").val();   
    var issue_remarks = $("#issue_remarks").val();   
    var emp = $("#emp").val();   
    var emp2 = $("#emp2").val();   
    
    var countValidate = 0;  
    var validate_fields = ['#issue', '#risk1', '#risk_rating', '#status', '#due_date', '#dept','#issue_remarks'];
    
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
        alert ("Successfully save");            
        $('#formsave').submit(); 
        
    }
    return true;
    
      
});

$(window).bind('beforeunload', function () {
    return 'Please save your setting before leaving the page.';
});  

    

</script> 



      
