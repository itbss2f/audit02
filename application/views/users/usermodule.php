
<!-- begin row -->
<div class="row">
    <div class="breadcrumb pull-right" style="margin-right: 10px;">
        <li class="active">
            <i class="fa fa-home"></i>
            Home
        </li>                  
        <li class="active">
            <i class="fa fa-wrench"></i>    
            Maintenance
        </li>
        <li>
            <a href="<?php echo site_url('user/listofUser') ?>">
                <i class="fa fa-user"></i>
                UserList
            </a>
        </li>
    </div>
    <!-- begin col-6 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title">User Module</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!--begin col-md-12-->
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" style="width: 300px;">
                            <li class="active"><a href="#maintenance" data-toggle="tab">Maintenance</a></li>
                            <li class=""><a href="#transaction" data-toggle="tab">Transaction</a></li>
                            <li class=""><a href="#reports" data-toggle="tab">Reports</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="maintenance">
                                <!--<h3 class="m-t-6"><i class="fa fa-cog"></i></h3> -->
                                <div class="table-responsive">  
                                    <table id="dataTable" cellpadding="0" cellspacing="0" width="100%" class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">Modules</th>                                                                                                                                           
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($data as $row) : ?>
                                                <tr> 
                                                    <td><?php echo $row['module_name'] ?></td>
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                </tr>           
                                        <?php endforeach; ?>                                  
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="transaction">
                                <!--<h3 class="m-t-6"><i class="fa fa-file"></i></h3>-->
                                <div class="table-responsive">  
                                    <table id="dataTable" cellpadding="0" cellspacing="0" width="100%" class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">Modules</th>
                                                <th width="2%">Add</th>                                                                                                                                           
                                                <th width="2%">Edit</th>                                                                                                                                           
                                                <th width="2%">Delete</th>                                                                                                                                           
                                                <th width="2%">View</th>                                                                                                                                           
                                                <th width="2%">Duplicate</th>                                                                                                                                           
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($trans as $row) : ?>
                                                <tr> 
                                                    <td><?php echo $row['module_name'] ?></td>
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                </tr>           
                                        <?php endforeach; ?>                                  
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reports">
                                <!--<h3 class="m-t-6"><i class="fa fa-envelope"></i></h3>-->
                                <div class="table-responsive">  
                                    <table id="dataTable" cellpadding="0" cellspacing="0" width="100%" class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">Modules</th>
                                                <th width="2%">Add</th>                                                                                                                                           
                                                <th width="2%">Edit</th>                                                                                                                                           
                                                <th width="2%">Delete</th>                                                                                                                                           
                                                <th width="2%">View</th>                                                                                                                                           
                                                <th width="2%">Duplicate</th>                                                                                                                                           
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($reports as $row) : ?>
                                                <tr> 
                                                    <td><?php echo $row['module_name'] ?></td>
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                    <td><input type="checkbox"></td> 
                                                </tr>           
                                        <?php endforeach; ?>                                  
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end of col-md-12-->
                    
                </div>
            </div>
        </div>
    </div>
</div>         

<script> 
var errorcssobj = {'background': '#E1CECE','border' : '1px solid #FF8989'};
var errorcssobj2 = {'background': '#E0ECF8','border' : '1px solid #D7D7D7'};

</script> 

<script type="text/javascript">

$(document).ready(function(){ 
 $('.add').on('change', function () {
    if (this.value == "1"){
        $(".add").val('checked');
    } else {
        $(".add").val('');
    }
  }); 
  
});

</script> 

  



    





        
    