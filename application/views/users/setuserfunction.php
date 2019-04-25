   
<div class="panel-body">
    <form action="<?php echo site_url('user/savefunctionuser') ?>" method="post" name="formsavef" id="formsavef" data-parsley-validate="true">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label style="font-size: 12px;font-weight: bold;">Main Module </label>
                    <select class="form-control" name="mainx" id="mainx" style="width: 250px;">
                        <option value="">----</option>
                        <?php foreach ($main as $main) : ?>
                        <option value="<?php echo $main['id']?>"><?php echo $main['name'] ?></option>
                        <?php endforeach; ?> 
                    </select>                                                                                                 
                </div>
            </div>
            <div class="clear"></div> 
        </div>
        <div class="block-fluid table-sorting pull-left" style="overflow:auto;width: 450px; height:450px">
            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                <tbody class="user_company_list">
                </tbody>
            </table>
            <div class="clear"></div>
            <!--<input type="button" class="btn btn-success pull-right" value="save">-->
        </div>
    </form>  
</div>
   
    
<script>

$("#mainx").change(function(){
    var $mainx = $("#mainx").val();
    var $user_id = "<?php echo $user_id ?>";
    $.ajax({
        url: "<?php echo site_url('user/user_company_listview') ?>",
        type: "post",
        data: {mainx: $mainx, user_id: $user_id},
        success: function(response) {
            $response = $.parseJSON(response);
            $(".user_company_list").html($response['user_company_listview']);
        }
    });
}); 

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
</script>



