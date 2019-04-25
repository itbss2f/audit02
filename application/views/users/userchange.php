 
 
 <!--Begin Modal-->
    <div class="moda-body">
        <form action="<?php echo site_url('user/updatePassword')?>" method="post" name="formsave" id="formsave" data-parsley-validate="true">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>                                                 
                        <input class="form-control" type="text" name="username" id="username" value="<?php echo $users['username'] ?>" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password *</label>
                        <input class="form-control" type="password" name="userpass" id="userpass" data-parsley-range="[8,20]" required/>
                    </div>
                </div>   
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password *</label>
                        <input class="form-control" type="password" name="confirm" id="confirm" data-parsley-range="[8,20]" required/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-success" id="save" name="save">Save Update</a>
                <a href="javascript:;" class="btn btn-sm btn-white" id="cancel" name="close">Close</a>  
            </div>
        </form>    
    </div>
    <!--end-->        
        
        
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};


$(document).ready(function(){
    $("#save").click(function() {
        
        var userpass = $("#userpass").val();   
        var confirm = $("#confirm").val();   
        var username = $("#username").val();   
       
        
        var countValidate = 0;  
        var validate_fields = ['#username', '#userpass', '#confirm']; 

        for (x = 0; x < validate_fields.length; x++) {            
            if($(validate_fields[x]).val() == "") {                        
                $(validate_fields[x]).css(errorcssobj);          
                  countValidate += 1;
            } else {        
                  $(validate_fields[x]).css(errorcssobj2);       
            }        
        }
       
        var pass1 = $("#userpass").val();
        var pass2 = $("#confirm").val(); 
        
        if (pass1 != pass2) {
            
            alert('Password not match');
        }
          
        else if (countValidate == 0) 
        {
            
            //alert("Successfully update")                                                
              $('#formsave').submit();  
        } else { 
            //alert("Required fields must fill up")           
            return false;
        }     
          
    });
});

$("#cancel").click(function() {
    $("#modal_change_userx").dialog('close');
});

        
</script>        