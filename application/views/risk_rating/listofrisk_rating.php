<html>
<head>
     
        <script type='text/javascript' src='http://localhost/newproject//assets/js/jquery-1.7.1.min.js'></script>
        <script type='text/javascript' src='http://localhost/newproject/assets/js/jquery-ui-1.8.13.custom.min.js'></script>  
          
</head>
 <body>
     
    <div class="breadcrumb pull-right">
        <li><a href="<?php echo site_url('risk_rating/newdata')?>">Home</a></li>    
        <li class="active">Risk Rating Records</li>
    </div>
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Risk Rating Records</h4>
                </div>      
                <div class="block-fluid table-sorting">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                    <thead>
                        <tr>
                            <th width="3%">No.</th>
                            <th width="5%">Code</th>                    
                            <th width="10%">Description</th>                                                                  
                            <th width="2%">Edit</th>                                                                
                            <th width="2%">Remove</th>                                                                                                                                
                        </tr>
                    </thead>
                    <tbody>
                       <?php $no = 1;  ?>
                        <?php foreach ($data as $row) : ?>
                            <tr> 
                                <td style="text-align: left;" ><?php echo $no ?></td>                    
                                <td style="text-align: left;" ><?php echo $row['code'] ?></td>
                                <td style="text-align: left;" ><?php echo $row['description'] ?></td>
                                <td style="text-align: left;" >
                                <a href="<?php echo site_url('risk_rating/editdata').'/'.$row['id']?>" class="edit"> Edit </a>  
                                </td> 
                                <td style="text-align: left;">
                                <a href="<?php echo site_url('risk_rating/removedata').'/'.$row['id']?>" class="remove">Remove</a>
                                </td>         
                            </tr>
                            <?php $no += 1; ?>
                        <?php endforeach; ?> 
                         </tbody> 
                    </table>
                    <!--<div  id="add" class="span1" style="width:50px;margin-top: 10px;"><button type="button" class="btn-success" title="add">Add</button></div>-->
                </div> 
            </div> 
        </div> 
    </div> 
                       
</body>     
</html>             
<script>

$(".edit").click(function () {
    
    var ans = window.confirm("Are you sure you want to edit")

    if (ans)
    {
    window.alert("Click ok to proceed.");
    return true;   
    }
    else
    {
    window.alert("Are you sure you want to cancel?");
    return false;    
    }
    

});

$(".remove").click(function () {
    
    var ans = window.confirm("Are you sure you want to remove")

    if (ans)
    {
    window.alert("Successfully remove.");
    return true;   
    }
    else
    {
    window.alert("Are you sure you want to cancel?");
    return false;    
    }
    

});

/*$("#add").live('click', function () {
    
    var ans = confirm("Are you sure you want to add new issues")
      
    if (ans)
    {
    window.location = "<?php echo site_url('risk_rating/newdata')?>/";
    
    }
   else {
       
    alert("Are you sure you want to cancel");        
   } 

}); 
 */

</script>
       
