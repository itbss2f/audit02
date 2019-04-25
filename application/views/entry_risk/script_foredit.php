<script type='text/javascript'>

$(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});  

 $(function(){
    $('.datedayspicker2').datepicker({
        format: 'mm-dd-yyyy',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker2').datepicker('hide');
    });
});        

/*$("#dept").change(function() {
    var $id = $("#dept").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxDept')?>",
        type: 'post',
        data: {id: $id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#emp').empty();
            $.each($response['emp'], function(i)
             {
                 var xitem = $response['emp'][i];
                 var option = $('<option>').val(xitem['user_id']).text(xitem['emp_code'] + ' - ' +xitem['fullname']);
                 $('#emp').append(option);                                             
             });
            
        }
        
    });
}); */

/*$("#dept").change(function() {
    var $id = $("#dept").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxDept2')?>",
        type: 'post',
        data: {id: $id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#emp2').empty();
            $.each($response['emp2'], function(i)
             {
                 var xxitem = $response['emp2'][i];
                 var option = $('<option>').val(xxitem['user_id']).text(xxitem['emp_code'] + ' - ' +xxitem['fullname']);
                 $('#emp2').append(option);                                             
             });
        }
    });
});*/
    
/*$("#emp").change(function() {
    var $user_id = $("#emp").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxEmployees')?>",
        type: 'post',
        data: {user_id: $user_id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#dept').empty();
            $.each($response['dept'], function(i)
             {
                 var zitem = $response['dept'][i];
                 var option = $('<option>').val(zitem['id']).text(zitem['code'] + ' - ' +zitem['name']);
                 $('#dept').append(option);                                             
             });
        }
        
    });
});*/
               
/*$("#emp2").change(function() {
    var $user_id = $("#emp2").val();
    $.ajax({
        url: "<?#php echo site_url('entry/ajaxEmployees')?>",
        type: 'post',
        data: {user_id: $user_id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#dept').empty();
            $.each($response['dept'], function(i)
             {
                 var zitem = $response['dept'][i];
                 var option = $('<option>').val(zitem['id']).text(zitem['code'] + ' - ' +zitem['name']);
                 $('#dept').append(option);                                             
             });
        }
        
    });
}); */

$("#risk1").change(function() {
    var $id = $("#risk1").val();
    var $id2 = $("#risk2").val();
    var $id3 = $("#risk3").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk1')?>",
        type: 'post',
        data: {id: $id, id2: $id2, id3: $id3}, 
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
            //$('#risk3').empty();
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

$("#risk3").change(function() {
    var $idx = $("#risk3").val();
    var $id2 = $("#risk2").val();
    var $id1 = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk3')?>",
        type: 'post',
        data: {id: $idx, id2: $id2, id1: $id1}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            if ($risk3 = risk2) {
            //$('#risk2').empty(); 
            var option1 = $('<option>').val('').text('------');  
            $('#risk2').append(option1); 
            }                                            
            $.each($response['risk2'], function(x)                     
             {
                 var xitem = $response['risk2'][x];                 
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);                                             
                 $('#risk2').append(option2);                                             
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

$("#emp").change(function() {
    var $user_id = $("#emp").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxEmployees')?>",
        type: 'post',
        data: {user_id: $user_id}, 
        success: function(response) {
            var $response = $.parseJSON(response); 
            $('#dept').empty();
            $.each($response['dept'], function(i)
             {
                 var zitem = $response['dept'][i];
                 var option = $('<option>').val(zitem['id']).text(zitem['name']);
                 $('#dept').append(option);                                             
             });
             
            $('#emp2').empty();
            var option1 = $('<option>').val('').text('------');  
            $('#emp2').append(option1);                                             
            $.each($response['person2'], function(i){
                var zitem1 = $response['person2'][i];
                var option = $('<option>').val(zitem1['user_id']).text(zitem1['fullname']);
                $('#emp2').append(option);                                                 
            });
             
        } 
        
    });

});

$("#impact_value").maskMoney();

$(document).ready(function(){
$("#b_status").change(function(){
        var $id = $("#bc_status").val();     
        $.ajax({
           url: "<?php echo site_url('entry/ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
                    if ($id != 2) {
                        $("#date_tag").val("");
                        $("#date_implemented").val(""); 
                        //$('.datedayspicker2').prop("readonly", true).next("button").prop("disabled", true);
                   }else{
                $("#date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                $('.datedayspicker2').datepicker({format: 'mm-dd-yyyy'});
                $("#date_implemented").val('<?php echo date('m-d-Y')?>');
               } 
           }
        })
    });
});

/* change condition <select name="streettype" class="listenChange">...</select>
<select name="storey" class="listenChange">...</select>
And then handle like so

$("select.listenChange").change(function(){
    var name $(this).attr("name"),
        newValue = $(this).val();
    switch (name) {
        case 'streettype':
            //..
            break;
        case 'storey':
            //..
            break;
    }
});  */

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

/*$(function(){
    $('.datedayspicker').datepicker({
        format: 'MM dd, yyyy DD',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });

}); */

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

$("#save").click(function() {
    
    var entered_date = $("#entered_date").val();   
    var company = $("#company").val();
    var emp = $("#emp").val();   
    var emp2 = $("#emp2").val();
    var dept = $("#dept").val();        
    var project_id = $("#project_id").val();   
    var recur = $("#recur").val();  
    var issue = $("#issue").val(); 
    var assigned_audit = $("#assigned_audit").val();   
    var remarks = $("#remarks").val();   
    var issue_remarks = $("#issue_remarks").val();   
    var risk1 = $("#risk1").val();   
    var risk2 = $("#risk2").val();   
    var risk3 = $("#risk3").val();   
    var risk_rating = $("#risk_rating").val();
    var impact_value = $("#impact_value").val();
    var impact_remarks = $("#impact_remarks").val();
    var status = $("#status").val();  
    var date_tag = $("#date_tag").val();     
    var due_date = $("#due_date").val();   
    var date_implemented = $("#date_implemented").val();   
    var date_revised = $("#date_revised").val(); 
     
    var countValidate = 0;  
    var validate_fields = ['#issue', '#risk1', '#risk_rating', '#status', '#due_date', '#dept','#issue_remarks']; 

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
        alert("Successfully update Action Plan");            
        $('#formsave').submit();  
    } 
       
});

$('input[name="number"]').keyup(function(e){
  if (/\D/g(this.value)){
    // Filter non-digits from input value.
    this.value = this.value.replace(/[^0-9\.]/g, '');
  }
});

</script>