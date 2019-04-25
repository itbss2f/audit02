 
<div class="panel-body"> 
    <form action="<?php echo site_url('status/update/'.$data['id']) ?>" class="form-horizontal form-bordered" method="post" data-parsley-validate="true" id="formsave" name="formsave">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status Code</label>
                    <input style="width: 80px;" class="form-control" type="text" name="status_code" id="status_code" value="<?php echo $data['status_code'] ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 12px;">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Status Description</label>
                    <textarea style="width: 300px;" class="form-control" rows="4" title="description" id="description" name="description" data-parsley-required="true"><?php echo $data['status_name'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="margin-top: 12px;">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancel" name="close">Close</a>
        </div>
    </form>
</div>
     
            
            
<script>

var errorcssobj = {'background': '#E1CECE','border' : '1px solid #FF8989'};
var errorcssobj2 = {'background': '#E0ECF8','border' : '1px solid #D7D7D7'}; 


$("#save").click(function() {
    
    var status_code = $("#status_code").val();   
    var description = $("#description").val();   
    
    
    var countValidate = 0;  
    var validate_fields = ['#status_code', '#description']; 
    

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
            alert("Successfully update")                                    
          $('#formsave').submit();  
    } else { 
           alert("Required fields must fill up");   
   
    } 
     
      
});

$("#cancel").click(function() {
    $("#modal_editStatus").dialog('close');
});  
 
</script>