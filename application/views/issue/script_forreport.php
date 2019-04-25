<script>

$('#report_period').change(function() {
    var report_period = $(this).val();
    $('#date_period').hide(); 
    $('#date_period2').hide(); 
    $('#date_as').hide(); 
    
    if (report_period == 1) {
        $('#date_as').show();
        $('#generate').show(); 
        $('#export').show(); 
        $('#date_period').hide(); 
        $('#date_period2').hide();
        $('#generate2').hide();
        $('#export2').hide(); 
    }  else if (report_period == 2 ){
        $('#date_period').show();
        $('#date_period2').show(); 
        $('#generate2').show();
        $('#export2').show();
        $('#date_as').hide(); 
        $('#generate').hide(); 
        $('#export').hide(); 
    } else {
        $('#generate').show(); 
        $('#export').show(); 
         $('#generate2').hide(); 
         $('#export2').hide(); 
    }  
});

</script>