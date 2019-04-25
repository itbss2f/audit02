<html>
<head>
    
    <script type='text/javascript' src='http://localhost/newproject//assets/js/jquery-1.7.1.min.js'></script>
    <script type='text/javascript' src='http://localhost/newproject/assets/js/jquery-ui-1.8.13.custom.min.js'></script>   


</head>
    <body>
    
<div class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active">Maintenance</li>
    <li><a href="<?php echo site_url('risk_rating/listofrisk_rating')?>">Risk Rating</a></li>
</div>
<!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <!--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                        <!--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>-->
                    </div>
                    <h4 class="panel-title">Risk Rating Form</h4>
                </div>    
                <div class="panel-body">
                    <form action="<?php echo site_url('risk_rating/save') ?>" class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="formsave">              
                        <h5><b><?php echo date("F d, Y- l");?></b></h5>
                        <div class="row">
                            <div class="col-md-2">                   
                                <div class="form-group block1" style="margin-top: 12px;">
                                    <label> Code</label>
                                    <input class="form-control" type="text" id="code" name="code" data-parsley-required="true" data-parsley-type="digits"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">    
                                <div class="form-group block1" style="margin-top: 12px;">
                                    <label>Risk Rating</label>
                                    <textarea class="form-control" id="description" name="description" rows="8" data-parsley-range="[10,255]" data-parsley-required="true" placeholder="New Risk Rating"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group block1" style="margin-top: 12px;">
                                    <button type="save" class="btn btn-success" id="save" name="save" >Save</button>
                                </div>
                            </div>
                        </div>               
                      <!--  <div class="span3" style="width:150px;margin-top: 10px;"><button class="btn btn-success" type="button" name="list" id="list">List of Risk Rating</button></div> -->               
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 
   
<script>
var errorcssobj = {};
var errorcssobj2 = {};
   
$("#save").click(function() {
    
    var description = $("#description").val();   
    
    var countValidate = 0;  
    var validate_fields = ['#description'];
    
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
        
        //alert("Required fields must fill up");
    }    
       
});

/*$("#list").live('click', function () {
    
    var ans = confirm("Are you sure you want leave this page");
      
    if (ans)
    {
    window.location = "<?php echo site_url('risk_rating/listofrisk_rating')?>/";
    
    }
   else {
       
    alert("Are you sure you want to cancel");        
   } 

});*/

</script>



