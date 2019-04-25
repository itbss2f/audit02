     
<!--Begin Modal-->
<div class="panel-body">
    <form action="<?php echo site_url('security/updatemodule/'.$data['id']) ?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Main Module:</label>
                    <select class="form-control" name="module_name" id="module_name">
                        <option value="">--</option>
                        <?php foreach ($main as $main) : ?> 
                        <?php if ($main['id'] == $data['main_modules_id']) : ?>  
                        <option value="<?php echo $main['id'] ?>" selected="selected"><?php echo $main['name'] ?></option>    
                        <?php else: ?>
                        <option value="<?php echo $main['id'] ?>"><?php echo $main['name'] ?></option>        
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Module Name:</label>                                                 
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $data['name'] ?>"/>
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
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Path:</label>
                    <input type="text" class="form-control" id="path" name="path" value="<?php echo $data['segment_path'] ?>" data-parsley-required="true" required>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancel" name="cancel">Close</a>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save").click(function() {
    
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

$("#cancel").click(function() {
    $("#modal_editmodule").dialog('close');
});  

 
</script>
