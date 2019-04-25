<html>
<head>
    
    
    <script type='text/javascript' src='http://localhost/newproject//assets/js/jquery-1.7.1.min.js'></script>
    <script type='text/javascript' src='http://localhost/newproject/assets/js/jquery-ui-1.8.13.custom.min.js'></script> 
    
</head>
    <body>
    
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('risk/listofrisk')?>">Home</a></li>    
    <li class="active">Risk Rating</li>
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
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Edit Risk Rating</h4>
                    </div> 
                    <div class="panel-body"> 
                        <form action="<?php echo site_url('risk_rating/update/'.$data['id']) ?>" class="form-horizontal form-bordered" method="post" data-parsley-validate="true" id="formsave" name="formsave">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group block1" style="margin-top: 12px;">
                                        <label>Code</label>
                                        <input class="form-control" type="text" name="code" id="code" value="<?php echo $data['code'] ?>" data-parsley-validate="true" disabled="disabled" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group block1" style="margin-top: 10px;">
                                        <label>Risk Rating Description</label>
                                        <textarea class="form-control" rows="4" title="description" id="description" name="description" data-parsley-required="true"><?php echo $data['description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row-form-booking">
                                <div class="span3" style="margin-top: 10px;" ><button class="btn btn-success" type="button" name="save" id="save">Save Update</button></div>        
                                <div class="clear"></div>        
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>     

<script> 
var errorcssobj = {'background': '#E1CECE','border' : '1px solid #FF8989'};
var errorcssobj2 = {'background': '#E0ECF8','border' : '1px solid #D7D7D7'}; 

$("#save").click(function() {
    
    var code = $("#code").val();   
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
    if (countValidate == 0) {
            alert("Successfully update")                                    
          $('#formsave').submit();  
    } else {            
        alert("Required fields must fill up");    
    }    
});  
 
</script>