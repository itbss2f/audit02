
<div class="col-md-12">
    <form action="<?php echo site_url('project/save') ?>" method="post" data-parsley-validate="true" name="form-wizard" id="formsave" name="formsave">
        <h5><b><?php echo date("F d, Y- l");?></b></h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input style="width: 200px;" class="form-control" type="hidden" id="company" name="company" data-parsley-group="wizard-step-1" value="<?php echo $this->session->userdata('sess_company_id'); ?>">
                </div>
                <div class="form-group">
                    <label>Project Code:</label>
                    <input style="width: 200px;" class="form-control" type="text" id="code" name="code" data-parsley-type="digits" readonly="readonly" placeholder="Code">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Project Description:</label>
                    <textarea style="width: 300px;" class="form-control" id="description" name="description" rows="5" data-parsley-required="true" placeholder="New Project"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Date Release:</label>
                    <input style="width: 230px;" class="form-control datedayspicker" type="text" id="date_release" name="date_release" data-parsley-validate="true" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Impact:</label>
                    <input style="width: 230px;" class="form-control" type="text" id="impact" name="impact" value="0.00" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" data-parsley-validate="true" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-sm btn-success" id="p_save" name="save">Save</a>
            <a href="javascript:;" class="btn btn-sm btn-white" id="p_cancel" name="close">Close</a>
        </div>
    </form>
</div>

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

$("#p_save").click(function() {

    var code = $("#code").val();
    var description = $("#description").val();
    var date_release = $("#date_release").val();
    var impact = $("#impact").val();
    var company = $("#company").val();

    var countValidate = 0;
    var validate_fields = ['#description', '#impact','#date_release'];

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

//filtering of numbers in action plan code:
$('input[name="code"]').keyup(function(e){
  if (/\D/g(this.value)){
    this.value = this.value.replace(/[^0-9\.]/g, '');
  }
});


$("#p_cancel").click(function() {
    $("#modal_add_Project").dialog('close');
});



</script>
