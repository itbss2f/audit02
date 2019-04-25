
<div class="panel-body">
    <form action="<?php echo site_url('status/save') ?>" class="form-horizontal form-bordered" method="post" data-parsley-validate="true" id="formsave" name="formsave">
        <h5><b><?php echo date("F d, Y- l");?></b></h5>  
        <div class="row">
            <div class="col-md-4">
                <div class="form-group"> 
                    <label></label>
                    <input style="width: 80px;" class="form-control" type="hidden" id="status_code" name="status_code" data-parsley-required="true" data-parsley-type="digits"/>
                </div>
            </div>
        </div>
        <div class="row">                                                
            <div class="col-md-8"> 
                <div class="form-group">
                    <label>Status </label>
                    <textarea style="width: 300px;" class="form-control" id="description" name="description" rows="4" data-parsley-required="true" placeholder="New Status"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="margin-top: 12px;">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancel" name="close">Close</a>
        </div>
    </form>
</div>       

   
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save").click(function() {

    var status_code = $("#status_code").val();   
    var description = $("#description").val();   
       
    var countValidate = 0;  
    var validate_fields = [ '#status_code', '#description'];

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
        alert("Successfully save");
          $('#formsave').submit();  
    } 
    else {
        
        alert("Required fields must fill up");
    }              
       
});

$("#cancel").click(function() {
    $("#modal_add_Status").dialog('close');  
});

</script>



