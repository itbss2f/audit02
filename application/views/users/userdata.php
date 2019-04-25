
<div class="panel-body">
    <form action="<?php echo site_url('user/saveUser') ?>" data-parsley-validate="true" method="POST" id="formsave" required="">
        <div class="row">
            <fieldset>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>EmployeeID</label>
                        <input class="form-control" id="inputDefault" name="employee_id" type="text" required="">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <fieldset>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input class="form-control" id="inputDefault" name="firstname" type="text" required="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Lastname</label>
                        <input class="form-control" id="inputDefault" name="lastname" type="text" required="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Middlename</label>
                        <input class="form-control" id="inputDefault" name="middlename" type="text" required="">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <fieldset>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" id="inputDefault" name="username" type="text" required="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" id="inputDefault" name="email" type="email" required="">
                    </div>
            </fieldset>
        </div>
        <div class="row">
            <fieldset>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" id="inputDefault" name="userpass" type="password" required="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" id="inputDefault" name="confirm" type="password" required="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit" id="save" name="save">Save</button>
                        <button type="button" class="btn btn-default" id="cancel">Close</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>

<script>

var error = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var complete = {'background': '#cee','border' : '1px solid #00acac'};

$(document).ready(function(){
    $("#save").click(function() {

        var employee_id = $("#employee_id").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var pass1 = $("#userpass").val();
        var pass2 = $("#confirm").val();

        var countValidate = 0;
        var validate_fields = [ '#description'];

        for (x = 0; x < validate_fields.length; x++) {

        if($(validate_fields[x]).val() == "") {
            $(validate_fields[x]).css(errorcssobj);
              countValidate += 1;
        } else {
              $(validate_fields[x]).css(errorcssobj2);
        }
    }

    if (countValidate == 0) {
        var pass1 = $("#userpass").val();
        var pass2 = $("#confirm").val();

      } else if (pass1 == pass2){
            alert("Successfully save");
            $('#formsave').submit();
      } else {
            alert("Password not match");
      }
  });

    $("#cancel").click(function() {
        $("#modal_addUserdata").dialog('close');
    });


});

</script>
