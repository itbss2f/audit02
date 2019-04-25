
<div class="panel-body">        
    <form action="<?php echo site_url('project/update/'.$data['id']) ?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-4">                   
                <div class="form-group">
                    <label>Project Code:</label>
                    <input style="width: 200px;" class="form-control" type="text" id="code" name="code" value="<?php echo $data['code'] ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">    
                <div class="form-group">
                    <label>Project Name:</label>
                    <textarea style="width: 300px;" class="form-control" id="description" name="description" rows="5" data-parsley-required="true" placeholder="New Project"><?php echo $data['description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group"> 
                    <label>Date Release:</label>
                    <input style="width: 230px;" class="form-control datepicker" type="text" id="date_release" name="date_release" value="<?php echo date('m-d-Y', strtotime($data['date_release'])) ?>" data-parsley-validate="true" required>
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group"> 
                    <label>Impact:</label>
                    <input style="width: 230px;" class="form-control" type="text" id="impact" name="impact" value="<?php echo $data['impact'] ?>" data-parsley-type="digits" data-parsley-validate="true" required>
                </div>    
            </div>    
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancel" name="cancel">Close</a>
        </div>
    </form>
</div>
            
<script>

$(".datepicker").datepicker({dateFormat: 'm-d-YYYY'});   
 
var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save").click(function() {
    
    var code = $("#code").val();   
    var description = $("#description").val();   
    
    
    var countValidate = 0;  
    var validate_fields = [ '#code', '#description']; 

    for (x = 0; x < validate_fields.length; x++) {            
        if($(validate_fields[x]).val() == "") {                        
            $(validate_fields[x]).css(errorcssobj);          
              countValidate += 1;
        } else {        
              $(validate_fields[x]).css(errorcssobj2);       
        }        
    }   
    if (countValidate == 0) {
            alert("Successfully update");                                    
          $('#formsave').submit();  
    } else {
            alert("Required fields must fill up");            
       
    }    
});

$("#cancel").click(function() {
    $("#modal_editProject").dialog('close');
});   
 
</script>