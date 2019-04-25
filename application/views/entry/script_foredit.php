<script type='text/javascript'>

//Business concern Impact with validation base in Impact value.
//If impact value is null impact_remarks is not required.
function reloading() {
    if($('#impact_value').val() == ""){
        $('#edit_impact_remarks').hide()
        $("#impact_remarks_2").attr('data-parsley-required', 'false');
        $("#impact_remarks_2").attr('data-parsley-validate', 'false');
        //$("#impact_remarks_2").val("");
        $('#xapimpact_remarks2').hide()
        $("#xap_impact_remarks2").attr('data-parsley-required', 'false');
        $("#xap_impact_remarks2").val("");
      } else {
        $('#edit_impact_remarks2').show()
        $('#x_impact_value').hide()
        }
    if($('#emp').val() == ""){
        $('#xx_emp2').hide()
        $('#xx_emp3').hide()
    } else {
        $('#xx_emp2').show()
        $('#xx_emp3').show()
      }
    if($('#emp2').val() == ""){
        $('#xx_emp3').hide()
    } else {
        $('#xx_emp3').show()
      }
    if($('#dept').val() == ""){
        $('#xx_dept2').hide()
        $('#xx_dept3').hide()
    } else {
        $('#xx_dept2').show()
        $('#xx_dept3').show()
      }
    if($('#dept2').val() == ""){
        $('#xx_dept3').hide()
    } else {
        $('#xx_dept3').show()
      }
    if($('#risk1').val() == ""){
        $('#_risk2').hide()
        $('#_risk3').hide()
    } else {
        $('#_risk2').show()
      }
    if($('#risk2').val() == ""){
        $('#_risk3').hide()
    } else {
        $('#_risk3').show()
      }

}
window.onload = reloading;
//end


//Validation of Impact value of Business Concern
//If impact value is null impact_remarks is not required.
$(document).ready(function(){
    $("#impact_value").keydown(function () {
        if($('#impact_value').val() == "0.00"){
              $('#edit_impact_remarks').hide()
              $("#impact_remarks").prop('disabled',true)
              $("#impact_remarks_2").attr('data-parsley-required', 'false');
              $("#impact_remarks_2").attr('data-parsley-validate', 'false');
              $("#edit_impact_remarks2").val("");
              $('#edit_impact_remarks2').hide()
          } else {
              $('#edit_impact_remarks2').show()
              $("#impact_remarks_2").attr('data-parsley-required', 'true');
              $("#impact_remarks_2").attr('data-parsley-group', 'wizard-step-1');
              $("#impact_remarks_2").attr('data-parsley-validate', 'true');
              $("#impact_remarks_2").prop('disabled',false);
              $('#edit_impact_remarks').hide()
              $("#impact_remarks").prop('disabled',true)
        }
    });
});
$(document).ready(function(){
    $("#impact_value2").keydown(function () {
        if($('#impact_value2').val() == "0.00"){
              $('#edit_impact_remarks').hide()
              $("#impact_remarks").prop('disabled',false)
              $("#impact_remarks_2").attr('data-parsley-required', 'false');
              $("#impact_remarks_2").attr('data-parsley-validate', 'false');
              $("#edit_impact_remarks2").val("");
              $('#edit_impact_remarks2').hide()
          } else {
            $('#edit_impact_remarks2').show()
            $("#impact_remarks_2").attr('data-parsley-required', 'true');
            $("#impact_remarks_2").attr('data-parsley-group', 'wizard-step-1');
            $("#impact_remarks_2").attr('data-parsley-validate', 'true');
            $("#impact_remarks_2").prop('disabled',false);
            $('#edit_impact_remarks').hide()
            $("#impact_remarks").prop('disabled',true)
          }
    });
});
//end

//Action Plan Impact with validation base in Impact value.
//If impact value is null impact_remarks is not required.
$(document).ready(function(){
    $("#ap_impact_value").keydown(function () {
         if($('#ap_impact_value').val() == "0.00") {
            $('#apimpact_remarks').hide()
            $("#ap_impact_remarks").prop('disabled',true)
            $('#xapimpact_remarks2').hide()
            $("#xap_impact_remarks2").attr('data-parsley-required', 'false');
            $("#xap_impact_remarks2").val("");
        } else {
            $('#xapimpact_remarks2').show()
            $("#xap_impact_remarks2").attr('data-parsley-required', 'true');
            $("#xap_impact_remarks2").prop('disabled',false);
            $('#apimpact_remarks').hide()
            $("#ap_impact_remarks").prop('disabled',true)
        }
    });
});
$(document).ready(function(){
    $("#ap_impact_value2").keydown(function () {
         if($('#ap_impact_value2').val() == "0.00") {
            $('#apimpact_remarks').hide()
            $("#ap_impact_remarks").prop('disabled',true)
            $('#xapimpact_remarks2').hide()
            $("#xap_impact_remarks2").attr('data-parsley-required', 'false');
            $("#xap_impact_remarks2").val("");
        } else {
            $('#xapimpact_remarks2').show()
            $("#xap_impact_remarks2").attr('data-parsley-required', 'true');
            $("#xap_impact_remarks2").prop('disabled',false);
            $('#apimpact_remarks').hide()
            $("#ap_impact_remarks").prop('disabled',true)
        }
    });
});
//end

//Validation for action status.
$(function(){
    $('select').on('change',function(){
        if($(this).val()== "" || $(this).val()== 2 || $(this).val()== 3 || $(this).val()== 5){
          $("#xdue_date2").hide();
          $("#xdue_date3").hide();
          $("#default_due_date").hide();
          $("#ap_due_date3").prop('disabled',true)
          $("#ap_due_date2").prop('disabled',true)
          $("#ap_due_date").prop("disabled", false);
          $("#xdue_date").show();
        }
    		if($(this).val()== 4){
        	$("#xdue_date2").show();
          $("#ap_due_date2").prop('disabled',false);
          $("#ap_due_date").prop("disabled", true)
          $("#ap_due_date3").prop('disabled',true)
          $("#xdue_date").hide();
          $("#xdue_date3").hide();
          $("#default_due_date").hide();
        }
        if($(this).val()== 1){
        	$("#xdue_date3").show();
          $("#ap_due_date3").prop('disabled',false);
          $("#ap_due_date").prop("disabled", true)
          $("#ap_due_date2").prop("disabled", true)
          $("#xdue_date").hide();
          $("#xdue_date2").hide();
          $("#default_due_date").hide();
        }
    });
});
//end

//3 Different Datepicker
$(function(){
    $('.datedayspicker').datepicker({
        dateFormat: 'mm-dd-yyyy',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });

    $('.datedayspicker2').datepicker({
        dateFormat: 'mm-dd-yyyy',
        startDate: '-0m'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('.datedayspicker2').data('date'));
        $('.datedayspicker2').datepicker('hide');
    });

    $('.datedayspicker3').datepicker({
        dateFormat: 'mm-dd-yyyy',
        endDate: '-0m'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('.datedayspicker3').data('date'));
        $('.datedayspicker3').datepicker('hide');
    });

});
//end

//Show and hide of Person and Dept in BC
$(function() {
    $('#emp').change(function(){
         if($('#emp').val() == '') {
            $('#xx_emp2').hide();
            $('#xx_emp3').hide();
        } else {
            $('#xx_emp2').show();
            $('#xx_emp3').hide();
        }
    });
    $('#emp2').change(function(){
        if($('#emp2').val() == '') {
            $('#xx_emp3').hide();
        } else {
            $('#xx_emp3').show();
        }
    });
});

$(function() {
    $('#dept').change(function(){
         if($('#dept').val() == '') {
            $('#xx_dept2').hide();
            $('#xx_dept3').hide();
        } else {
            $('#xx_dept2').show();
            $('#xx_dept3').hide();
        }
    });
    $('#dept2').change(function(){
        if($('#dept2').val() == '') {
            $('#xx_dept3').hide();
        } else {
            $('#xx_dept3').show();
        }
    });
});
//end

//Show and hide of Person and Dept in Action Plan
$(function() {
    $('#ap_emp').change(function(){
         if($('#ap_emp').val() == '') {
            $('#xx_ap_emp_2').hide();
        } else {
            $('#xx_ap_emp_2').show();
        }
    });
    $('#ap_dept').change(function(){
         if($('#ap_dept').val() == '') {
            $('#xx_ap_dept2').hide();
        } else {
            $('#xx_ap_dept2').show();
        }
    });
});
//end

$(function() {
    $('#risk1').change(function(){
         if($('#risk1').val() == '') {
            $('#_risk2').hide();
            $('#_risk3').hide();
        } else {
            $('#_risk2').show();
        }
    });
    $('#risk2').change(function(){
        if($('#risk2').val() == '') {
            $('#_risk3').hide();
        } else {
            $('#_risk2').show();
            $('#_risk3').show();
        }
    });
});

$("#risk1").change(function() {
    var $id = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk1')?>",
        type: 'post',
        data: {id: $id},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk2').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk2').append(option1);
            $.each($response['risk2'], function(x)
             {
                 var xitem = $response['risk2'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk2').append(option2);
             });

            $('#risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk3').append(option1);
            $.each($response['risk3'], function(x)
             {
                 var xitem = $response['risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk3').append(option2);
             });
        }

    });

});

$("#risk2").change(function() {
    var $id = $("#risk2").val();
    var $id3 = $("#risk3").val();
    var $id1 = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk2')?>",
        type: 'post',
        data: {id: $id, id1: $id1, id3: $id3},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk3').append(option1);
            $.each($response['risk3'], function(x)
             {
                 var xitem = $response['risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk3').append(option2);
             });

            //$('#risk1').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk1').append(option1);
            $.each($response['risk1'], function(x)
             {
                 var xitem = $response['risk1'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk1').append(option2);
             });
        }
    });
});


//for business concern STATUS validation:
$(document).ready(function(){
    $("#b_status").change(function(){
        var $id = $("#bc_status").val();
        $.ajax({
           url: "<?php echo site_url('entry/ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
          if ($id != 10) {
              $("#date_tag").val("");
              $("#d_implemented1").show();
              $("#xdate_implemented").attr("disabled", true);
              $("#d_implemented2").hide();
           }  else {
                $("#date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                $("#d_implemented2").show();
                $("#xdate_implemented2").attr('data-parsley-required', 'true');
                $("#d_implemented1").hide();
                $("#xdate_implemented").attr("disabled", false);
               }
           }
        })
    });
});

$("#_status").change(function(){
        var $id = $("#ap_status").val();
        $.ajax({
           url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
            if ($id != 2) {
              $("#ap_date_tag").val("");
              $("#ap_date_implemented1").show();
              $("#ap_date_implemented").attr("disabled", true);
              $("#ap_date_implemented2").hide();
            } else {
                  $("#ap_date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                  $("#ap_date_implemented2").show();
                  $("#ap_date_implementedx").attr('data-parsley-required', 'true');
                  $("#ap_date_implemented1").hide();
                  $("#ap_date_implemented").attr("disabled", false);
               }
           }
        })
    });

$("#impact_value").maskMoney();
$("#impact_value2").maskMoney();
$("#ap_impact_value").maskMoney();
$("#ap_impact_value2").maskMoney();
$("#ap_impact_valuex").maskMoney();

//filtering of numbers in action plan code:
$('input[name="code"]').keyup(function(e){
  if (/\D/g(this.value)){
    this.value = this.value.replace(/[^0-9\.]/g, '');
  }
});

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#refresh").click(function() {
    var confirm = window.confirm('Are you sure you want to Reload');

    if(confirm)
    {
        //alert('System will reload press ok');
        window.location.reload()
    }
    else {
        alert('Are you sure you want to cancel');
    }
});

$(document).ready(function() {

    var codeValidators = {
            row: '.col-md-12',
            validators: {
                notEmpty: {
                    message: 'The code is required'
                }
            }
        },
        actionplanValidators = {
            row: '.col-md-12',
            validators: {
                notEmpty: {
                    message: 'The action is required'
                },
                action: {
                    message: 'The action is not valid'
                }
            }
        },

        bookIndex = 0;


        // Add button click handler
        $("#addButton").click(function() {
            bookIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);

            // Update the name attributes
                $clone

                .find('[name="code"]').attr('name', 'book[' + bookIndex + '][code]').end()
                .find('[name="action_plan"]').attr('name', 'book[' + bookIndex + '][action_plan]').end()



            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
            $('#formsave')
                .formValidation('addField', 'book[' + bookIndex + '][code]', codeValidators)
                .formValidation('addField', 'book[' + bookIndex + '][action_plan]', actionplanValidators)
        })

        // Remove button click handler
        $("#removeButton").click(function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');

            // Remove fields
            $('#formsave')
                .formValidation('removeField', $row.find('[name="book[' + index + '][code]"]'))
                .formValidation('removeField', $row.find('[name="book[' + index + '][action_plan]"]'))

            // Remove element containing the fields
            $row.remove();
        });
});

</script>
