<div class="breadcrumb pull-right" style="margin-right: 10px;">
    <li><i class="fa fa-home"></i>Home</li>
    <li class="active"><i class="fa fa-file"></i> Transaction</li>
    <li class="active"><i class="fa fa-plus-square"></i> Accepted Risks</li>
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
                                <a href="<?php echo site_url('entry_risk/listofAcceptedRisk')?>">
                                    Accepted Risks Records
                                </a>
                            </li>
                        </ul>                                                               
                    </div>          
                </div>
                <h4 class="panel-title">Accepted Risks - <?php echo $this->session->userdata('sess_company_name');?></h4>  
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('entry_risk/savenewacceptedrisk') ?>" method="POST" data-parsley-validate="true" name="form-wizard" id="formsave" class="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Business Concern / Issues </label> <!--Step 1-->                              
                            </li>
                            <li>
                                <label> Action Plan / Status </label> <!--Step 2-->
                            </li> 
                        </ol>
                        <!--begin wizard step-1-->
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input style="width: 200px;font-weight: bold;" class="form-control" type="text" id="entered_date" name="entered_date" value="<?php echo date('F j\, Y \ l')  ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;"></legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Code</label>
                                            <input class="form-control" type="text" id="bc_code" name="number" data-parsley-group="wizard-step-1" data-parsley-required="true" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"/>
                                        </div>    
                                    </div> 
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <Label>Business Concern:</label>
                                            <textarea class="textarea form-control" id="business_concern" name="business_concern" placeholder="Enter Business Concern ..." rows="8" data-parsley-group="wizard-step-1" data-parsley-required="true" required></textarea> 
                                        </div>
                                    </div> 
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend> 
                                <div class="row">
                                    <div class="form-group">
                                        <input class="form-control" type="hidden" id="company" name="company" value="<?php echo $this->session->userdata('sess_company');?>"/>    
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>   
                                            <select class="form-control" id="emp" name="emp" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true"/>
                                                <option value="">----</option>
                                                <?php foreach ($emp as $row) : ?>
                                                <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="v_department">
                                            <label>Department</label>   
                                            <select class="form-control" name="dept" id="dept" style="width: 436px;" data-parsley-group="wizard-step-1" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($dept as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="emp2" name="emp2" style="width: 408px;">
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
                                            <select class="form-control" id="project_id" name="project_id" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
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
                                            <select class="form-control" id="assigned_audit" name="assigned_audit" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($ap_users as $row) : ?>   
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['audit_staff'] ?></option>
                                                <?php endforeach; ?>
                                            </select>  
                                        </div>                                
                                    </div> 
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Issues</legend> 
                                <div class="row">
                                    <div class="col-md-8">  
                                        <div class="form-group">
                                            <Label>Issue Remarks:</label>
                                            <textarea class="textarea form-control" id="remarks" name="remarks" placeholder="Enter Remarks ..." rows="8"></textarea> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Issue</label>
                                            <select class="form-control" id="issue" name="issue">
                                            <option value="">----</option>
                                            <?php foreach ($ap_issue as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                            </fieldset>
                        </div>
                        <!-- end wizard step-1 -->  
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                        <fieldset>
                            <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Action Plan</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group" id="dynamicInput">
                                            <Label>Action Code:</label>
                                            <input class="form-control" type="text" id="code" name="number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width: 150px;"> 
                                            <textarea class="textarea form-control" id="action_plan" name="action_plan" placeholder="Enter Action Plan ..." rows="8" data-parsley-required="true" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <Label>Status</label>
                                            <select class="form-control" id="status" name="status" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_statusX as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                            <?php endforeach; ?>    
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="button" value="Add another Action Plan" onClick="addInput('dynamicInput');"> 
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risks</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Risk 1</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk1" name="risk1" style="width: 302px;" data-parsley-required="true">
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
                                            <select class="form-control" id="risk2" name="risk2" style="width: 302px;">
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
                                            <select class="form-control" id="risk3" name="risk3" style="width: 280px;">
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
                                    <div class="col-md-6">
                                        <label>Risk Rating</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk_rating" name="risk_rating" style="width: 408px;" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_risk_rating as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Impact/Value</label>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" style="width: 436px;" value="0.00" maxlength="16" placeholder="Enter Impact value"/>
                                        </div>         
                                    </div>          
                                </div>
                                <!-- end row -->
                                <div class="row">
                                    <div class="col-md-12" id="ximpact_remarks" style="display: none;">
                                        <div class="form-group">
                                            <label>Impact Computation Basis</label>
                                            <textarea class="textarea form-control" id="impact_remarks" name="impact_remarks" style="width: 908px;" placeholder="Enter Impact Computation ..." rows="5"></textarea>
                                        </div>         
                                    </div>         
                                </div>
                                <!--end row -->         
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-6" id="b_status">
                                        <div class="form-group">
                                            <Label>Status</label>
                                            <select class="form-control" id="bc_status" name="bc_status" style="width: 408px;" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_statusX as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                            <?php endforeach; ?>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Date tagged as Implemented</label> 
                                            <?php if ($ap_statusX == 2): ?>
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
                                    <div class="col-md-6" id="_due_date">
                                        <Label>Due Date</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control datepicker" id="due_date" name="due_date" style="width: 408px;" placeholder="mm-dd-yyyy" readonly="readonly" data-parsley-required="true">
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    
                                    <!-- begin col --> 
                                    <div class="col-md-4" id="_daterevised" style="display: none;">
                                        <label>Date Revised</label>
                                        <div class="input-group date">
                                            <input type="hidden" class="form-control datepicker" id="date_revised" name="date_revised" placeholder="mm-dd-yyyy"/>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <!-- begin col -->
                                    <div class="col-md-6" id="_date_implemented">
                                        <label>Date Implemented</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="xdate_implemented" id="xdate_implemented" style="width: 408px;" placeholder="mm-dd-yyyy" readonly="readonly" />
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- begin row -->
                                <div class="row-form-booking pull-right">
                                    <button type="save" class="btn btn-success btn-sm" id="saveentry" name="saveentry" value="saveentry" style="margin-top : 12px;">Save</button>
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

$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});  

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#saveentry").click(function() {
    var confirm = window.confirm('Do you want to save this Accepted Risks?');
    
    if(confirm)
    {
        //alert('press ok to save'); 
        $('#formsave').submit();
        return true;   
    }
    else {
        alert('Are you sure you want to cancel');
        redirect('entry_risk/new_entry');
    }
});

$("#impact_value").maskMoney(); 

$(document).ready(function(){   
    $("#impact_value").keydown(function () { 
         if($('#impact_value').val() == "") {
            $('#ximpact_remarks').hide();
        } else {
            $('#ximpact_remarks').show(); 
        } 
    });
}); 

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
 
$(document).ready(function(){
$("#b_status").change(function(){
        var $id = $("#bc_status").val();     
        $.ajax({
           url: "<?php echo site_url('entry/ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
                    if ($id != 2) {
                        $("#date_tag").val("");
                        $("#xdate_implemented").val("");
                        //$('.datedayspicker2').prop("readonly", true).next("button").prop("disabled", true);
                   }else{
                $("#date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                $('.datedayspicker2').datepicker({format: 'MM dd, yyyy DD'});
                $("#xdate_implemented").val('<?php echo date('d-m-Y')?>');
               }
           }
        })
    });
}); 

//Filtering of numbers:
$('input[name="number"]').keyup(function(e){
  if (/\D/g(this.value)){

    this.value = this.value.replace(/[^0-9\.]/g, '');
  }
});

$(function(){
    $('.datedayspicker').datepicker({
        format: 'MM dd, yyyy DD',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });
});
       
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



</script> 
