     
<!--Begin Modal-->
<div class="panel-body">
    <form action="<?php echo site_url('security/updatefunctionmodule/'.$data['id']) ?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Function Name:</label>                                                 
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $data['name'] ?>" data-parsley-required="true" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" data-parsley-required="true" required><?php echo $data['description'] ?></textarea>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="f_save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="f_cancel" name="cancel">Close</a>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#f_save").click(function() {
    
    var name = $("#name").val();   
    var description = $("#description").val();   

    var countValidate = 0;  
    var validate_fields = ['#name','#description']; 
    

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

$("#f_cancel").click(function() {
    $("#modal_editfunctionmodule").dialog('close');
});  

 
</script>
