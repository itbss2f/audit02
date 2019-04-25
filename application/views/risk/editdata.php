
<div class="panel-body"> 
    <form action="<?php echo site_url('risk/update/'.$data['id']) ?>" class="form-horizontal form-bordered" method="post" data-parsley-validate="true" id="formsave" name="formsave">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Risk Code</label>
                    <input class="form-control" type="text" name="code" id="code" value="<?php echo $data['code'] ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Risk Description</label>
                    <textarea class="form-control" rows="4" title="description" id="description" name="description" data-parsley-required="true"><?php echo $data['description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="margin-top: 12px;">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save Update</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="close" name="close">Close</a>
        </div>
    </form>
</div>

            
<script> 

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save").click(function() {
    
    var code = $("#code").val();   
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
    if (countValidate == 0) {
            alert("Successfully update")                                    
          $('#formsave').submit();  
    } else {            
        alert("Required fields must fill up");   
    }    
}); 

$("#close").click(function() {
    $("#modal_editRisk").dialog('close');
});    
 
</script>
