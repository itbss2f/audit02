     
<!--Begin Modal-->
<div class="moda-body">
    <form action="<?php echo site_url('project/approvedProject/'.$data['id']) ?>" method="post">
        <h5><b><?php echo date("F d, Y- l");?></b></h5>
        <div class="row">
            <div class="col-md-4">                   
                <div class="form-group">
                    <label>Project Code:</label>
                    <input class="form-control" type="text" id="code" name="code" data-parsley-group="wizard-step-1" data-parsley-type="digits" value="<?php echo $data['code'] ?>" data-parsley-validate="true" readonly="readonly" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">    
                <div class="form-group">
                    <label>Project Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="5" data-parsley-required="true" placeholder="New Project"><?php echo $data['description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group"> 
                    <label>Date Release:</label>
                    <input class="form-control datedayspicker" type="text" id="date_release" name="date_release" value="<?php echo $data['date_release'] ?>" data-parsley-validate="true" required>
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group"> 
                    <label>Impact:</label>
                    <input class="form-control" type="text" id="impact" name="impact" data-parsley-type="digits" value="<?php echo $data['impact'] ?>" data-parsley-validate="true" required>
                </div>    
            </div>    
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-success p_submit" name="save">Approved</button>
            <button class="btn btn-sm btn-success p_cancel" type="cancel">Dissapproved</button>
        </div>
    </form>  
</div>
<!--end-->   
    
<script>
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

$('.p_submit').click(function() {
    
      var description = $("#description").val();
      var ans = window.confirm("Are you sure you want to approved?")  
    
    if(ans) {
        alert("Successfully approved");
        $('#formsave').submit();                                            
        
    }else
    {
        $("#modal_viewProjectfa").dialog('close');  
        return false;    
    } 
     
}); 

$('.p_cancel').click(function(){
    
    var ans = window.confirm("Are you sure you want to Dissapproved?")  
    
    if(ans) {
        alert("Successfully dissapproved");
        window.location = "<?php echo site_url('project/cancelData/'.$data['id']) ?>";
    }
    else
    {
        $("#modal_viewProjectfa").dialog('close');  
        return false;    
    }
});


 
</script>
