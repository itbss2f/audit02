     
<!--Begin Modal-->
<div class="moda-body">
    <form action="<?php echo site_url('issue/approved/'.$data['id']) ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label></label>                                                   
                    <!--<input class="form-control" type="text" name="code" id="code" readonly="readonly"/> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Issue Description</label>
                    <textarea style="width: 300px;" class="form-control" id="description" name="description" rows="4" readonly="readonly"><?php echo $data['description'] ?></textarea>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-success i_submit" name="save">Approved</button>
            <button class="btn btn-sm btn-success i_cancel" type="cancel">Dissapproved</button>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$('.i_submit').click(function() {
    
      var description = $("#description").val();
      var ans = window.confirm("Are you sure you want to approved?")  
    
    if(ans) {
        alert("Successfully approved");
        $('#formsave').submit();                                            
        
    }else
    {
        $("#modal_viewdata").dialog('close');  
        return false;    
    } 
     
}); 

$('.i_cancel').click(function(){
    
    var ans = window.confirm("Are you sure you want to Dissapproved?")  
    
    if(ans) {
        alert("Successfully dissapproved");
        window.location = "<?php echo site_url('issue/cancelData/'.$data['id']) ?>";
    }
    else
    {
        $("#modal_viewdata").dialog('close');  
        return false;    
    }
});


 
</script>
