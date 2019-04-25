    
<div class="panel-body">  
    <form action="<?php echo site_url('user/updateUser/'.$data['user_id']) ?>" data-parsley-validate="true" method="POST" id="formsave" required="">
        <div class="row">
            <fieldset> 
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Employee ID*</label>                                                 
                        <input class="form-control" type="text" name="employee_id" id="inputDefault" value="<?php echo $data['employee_id'] ?>" required=""/>
                    </div>
                </div>       
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Account Expiration*</label>                                                 
                        <input class="form-control" type="date" name="account_ex" id="inputDefault" value="<?php echo $data['expiration_date'] ?>" required=""/>
                    </div>
                </div>
            </fieldset>    
        </div>
        <div class="row">
            <fieldset>
                <div class="col-lg-4"> 
                    <div class="form-group">
                        <label>First Name*</label>
                        <input class="form-control" type="text" name="firstname" id="inputDefault" value="<?php echo $data['firstname'] ?>" required=""/>
                    </div>         
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Last Name*</label>
                        <input class="form-control" type="text" name="lastname" id="inputDefault" value="<?php echo $data['lastname'] ?>" required="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Middle Name*</label>
                        <input class="form-control" type="text" name="middlename" id="inputDefault" value="<?php echo $data['middlename'] ?>" required=""/>
                    </div>
                </div>
            </fieldset>    
        </div>
        <div class="row">
            <fieldset>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username*</label>
                        <input class="form-control" type="text" name="username" id="inputDefault" value="<?php echo $data['username'] ?>" required=""/> 
                    </div>         
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email*</label>  
                        <input class="form-control" type="email" name="email" id="inputDefault" value="<?php echo $data['email'] ?>" required="">
                        <small>Ex: josh@inquirer.com.ph</small>
                    </div>         
                </div>
                <div class="modal-footer">
                        <button class="btn btn-success" type="submit" id="e_save" name="save">Save Update</button>
                        <button type="button" class="btn btn-default" id="e_cancel">Close</button>
                </div>
            </fieldset>
        </div>                                                          
    </form>
</div> 

<script>

//$(".datedayspicker").datepicker({dateFormat: 'MM dd, yy DD'});

$(function(){
    $('.datedayspicker').datepicker({
        format: 'MM dd, yyyy DD',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });

}); 
 
var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$(document).ready(function(){                                 
    $("#e_save").click(function() {
        
        var firstname = $("#firstname").val();   
        var lastname = $("#lastname").val();   
        var middlename = $("#middlename").val();   
        var employee_id = $("#employee_id").val();   
        var username = $("#username").val(); 
        var email = $("#email").val(); 
        
        var countValidate = 0;  
        var validate_fields = [ '#employee_id'];

        for (x = 0; x < validate_fields.length; x++) { 
               
            if($(validate_fields[x]).val() == "") {                        
                $(validate_fields[x]).css(errorcssobj);          
                  countValidate += 1;
            } else {        
                  $(validate_fields[x]).css(errorcssobj2);       
            }        
        }
           
        if (countValidate == 0) {
            var email = $("#email").val();   
            var username = $("#username").val();
    
          } else if (username != ""){
                alert("Successfully save");
                $('#formsave').submit(); 
          }    
    });   

    $("#e_cancel").click(function() {
        $("#modal_editUserdata").dialog('close');
    }); 
    
});     
  
 
</script>


