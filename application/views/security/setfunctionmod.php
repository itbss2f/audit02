   
<div class="panel-body">
    <form action="<?php echo site_url('security/savefunctionmodule') ?>" method="post" name="formsavef" id="formsavef" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label style="font-size: 12px;font-weight: bold;">Functions List </label>                                                 
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label style="font-size: 12px;font-weight: bold;">Module: <?php echo $module['name'] ?></label>
                    <input type="hidden" value="<?php echo $module['id'] ?>" id="_module" name="_module">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">     
                <?php
                foreach ($function as $function) : ?>
                <?php 
                if(array_key_exists($function['id'], $modfunc)) :
                $check = "checked='checked';";
                else :
                $check = "";
                endif;  
                ?>
                <div class="form-group" style="font-size:12px">    
                    <input type="checkbox"  class="funct" name="funct[]" value="<?php echo $function['id'] ?>" <?php echo $check ?>/> <?php echo $function['name'] ?> 
                </div>    
                <?php endforeach; ?>      
            </div>    
        </div> 
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancelmod" name="cancelmod">Close</a>
        </div>   
    </form>  
</div>
   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save").click(function() {

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

$("#cancelmod").click(function() {
    $("#modal_setfunctionmodx").dialog('close');
});  
</script>



