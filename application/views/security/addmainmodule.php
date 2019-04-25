     
<!--Begin Modal-->
<div class="panel-body">
    <form action="<?php echo site_url('security/savemainmodule') ?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Module Name:</label>                                                 
                    <input class="form-control" type="text" name="name_main" id="name_main" data-parsley-required="true" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" data-parsley-required="true" required/></textarea>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="savemain" name="save">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancelmain" name="cancel">Close</a>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#savemain").click(function() {
    
    var name_main = $("#name_main").val();   
    var description = $("#description").val();   

    var countValidate = 0;  
    var validate_fields = ['#name_main','#description']; 
    

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
            alert("Successfully save new main module")                                    
          $('#formsave').submit(); 
           
    } else { 
           alert("Required fields must fill up");   
   
    } 
      
});

$("#cancelmain").click(function() {
    $("#modal_addmainmodule").dialog('close');
});  

 
</script>
