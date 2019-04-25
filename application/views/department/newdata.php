

<div class="panel-body">
    <form action="<?php echo site_url('department/save') ?>" method="post" data-parsley-validate="true" name="formsave" id="formsave">                   
        <h5><b><?php echo date("F d, Y- l");?></b></h5>    
        <div class="row">
            <div class="col-md-2">                   
                <div class="form-group">
                    <label></label>
                    <input class="form-control" type="hidden" id="company_id" name="company_id" value="<?php echo $this->session->userdata('sess_company_id'); ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">                   
                <div class="form-group">
                    <label>Department Code</label>
                    <input class="form-control" type="text" id="code" name="code"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">    
                <div class="form-group">
                    <label>Department</label>
                    <textarea class="form-control" id="name" name="name" rows="4" data-parsley-range="[10,255]" data-parsley-required="true" placeholder="New Department"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="margin-top: 12px;">
            <a href="javascript:;" class="btn btn-sm btn-success" id="save_depart" name="save">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="cancel_depart" name="close">Close</a>
        </div>
    </form>
</div>
       
   
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#save_depart").click(function() {

    var code = $("#code").val();      
    var description = $("#description").val();      
       
    var countValidate = 0;  
    var validate_fields = ['#code','#description'];

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
          alert("Successfully save new dapartment");
          $('#formsave').submit();  
    } 
    else {
        
        alert("Required fields must fill up");
    }    
       
});

$("#cancel_depart").click(function() {
    $("#modal_add_depart").dialog('close');  
});


</script>



