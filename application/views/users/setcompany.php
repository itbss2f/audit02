<div class="panel-body">
    <form action="<?php echo site_url('user/saveusercompany') ?>" method="post" name="formsavef" id="formsavef" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">                                                 
                    <label style="font-size: 12px;font-weight: bold;">Name: <?php echo $auditx['fullname'] ?></label>
                    <input type="hidden" value="<?php echo $auditx['user_id'] ?>" id="userx" name="userx">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <label style="font-size: 12px;font-weight: bold;">Company List</label>     
                <?php
                foreach ($companyx as $companyx) : ?>
                <?php 
                if(array_key_exists($companyx['id'], $usercompany)) :
                $check = "checked='checked';";
                else :
                $check = "";
                endif;  
                ?>
                <div class="form-group" style="font-size:12px">    
                    <input type="checkbox"  class="compxid" name="compxid[]" value="<?php echo $companyx['id'] ?>" <?php echo $check ?>/> <?php echo $companyx['name'] ?> 
                </div>    
                <?php endforeach; ?>      
            </div>    
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="savecom" name="savecom">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancelcom" name="cancelcom">Close</a>
        </div>   
    </form>  
</div>

<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#savecom").click(function() {

    var countValidate = 0;  
    var validate_fields = []; 
    

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
            alert("Successfully save")                                    
          $('#formsavef').submit(); 
           
    } else { 
           alert("Required fields must fill up");   
   
    } 
      
}); 

$("#cancelcom").click(function() {
    $("#modal_setcompany").dialog('close');
}); 

</script>

