     
<!--Begin Modal-->
<div class="panel-body">
    <form action="<?php echo site_url('risk/updatefa/'.$data['id']) ?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Risk Code</label>                                                 
                    <input style="width: 120px;" class="form-control" type="text" name="code" id="code" value="<?php echo $data['code'] ?>" readonly="readonly"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Risk Description</label>
                    <textarea style="width: 300px;" class="form-control" id="description" name="description" rows="4" data-parsley-required="true" required><?php echo $data['description'] ?></textarea>
                </div> 
            </div>
        </div>
        <div class="modal-footer" style="margin-top: 12px;">
            <a href="javascript:;" class="btn btn-sm btn-success" id="r_save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="r_cancel" name="cancel">Close</a>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#r_save").click(function() {
    
    var description = $("#description").val();   

    var countValidate = 0;  
    var validate_fields = ['#description']; 
    

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

$("#r_cancel").click(function() {
    $("#modal_editRiskfa").dialog('close');
});  

 
</script>
