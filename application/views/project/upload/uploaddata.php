<div class="breadcrumb pull-right">
    <li class="active">Home</li>
    <li class="active">Project Name</li>
    <li><a href="<?php echo site_url('project/listofProject')?>">Project Records</a></li>
</div>
<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <!--<input class="form-control input-white pull-left" id="searchTerm" class="search_box" onkeyup="Search()" placeholder="Enter keywords here..." style="margin-left: 20px;height: 25px; width: 200px;margin-top: 1px;">-->
                    <!--<i class="fa fa-search" style="margin-left: 5px;margin-top: 8px;"></i> Search -->
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Project Data Uploading </h4>
            </div>
            <div class="panel-body">
                <?php echo $error;?> <!-- Error Message will show up here -->
                <?php echo form_open_multipart('project/uploading');?>  
                <form action = "" method = "">
                    <div class="row">
                        <div class="col-md-2"> 
                            <input type="hidden" id="projectid" name="projectid" value="<?php echo $infodata['id'] ?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"> 
                            <div class="form-group"> 
                                <label style="font-size: 12px;font-weight: bold;">Project Code:</label>
                                <input class="form-control" type="text" id="project_code" name="project_code" value="<?php echo $infodata['code'] ?>" readonly="readonly"/>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-size: 12px;font-weight: bold;">Project Description:</label>
                                <div><?php echo $infodata['description']?></div>
                                <div class="clear"></div>
                            </div> 
                        </div>  
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="font-size: 12px;font-weight: bold;">Date Release:</label>
                                <div><?php echo $infodata['date_release']?></div>
                                <div class="clear"></div>
                            </div> 
                        </div>  
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="font-size: 12px;font-weight: bold;">Impact:</label>
                                <div><?php echo $infodata['impact']?></div>
                                <div class="clear"></div>
                            </div> 
                        </div>             
                        <div class="clear"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"> 
                            <?#php if ($canADD) : ?>
                            <input class="btn btn-success btn-sm" type="file" name="userfile" id="userfile" size="20"/>
                            <span style="color: red"><blink><?php echo $this->session->flashdata('errorupload'); ?></blink></span>
                            <?#php endif; ?> 
                        </div>
                        <div class="col-md-1">
                            <button type="save" class="btn btn-success btn-sm uploaddata" id="uploaddata" name="upload" value="upload">Upload</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" onsubmit="return validate(this)">
                        <table id="DataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%"></th>
                                    <th width="3%"></th>
                                    <th width="10%">Filename</th>
                                    <th width="30%">Filetype</th>
                                    <th width="5%">Username</th>
                                    <th width="15%">Date Entered</th>
                                </tr>
                            </thead>
                            <?php if (empty($list)) : ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
                                </tr>

                            <?php endif; ?>

                            <?php 
                            $atts = array(
                                          'width'      => '3000',
                                          'height'     => '3000',
                                          'scrollbars' => 'yes',
                                          'status'     => 'yes',
                                          'resizable'  => 'yes',
                                          'screenx'    => '0',
                                          'screeny'    => '0'
                                        );

                                        #echo anchor_popup('/C:xampp/htdocs/audit/uploading/1_100417071326_inquirer_job_market_fc.png', 'Click Me!', $atts);        
                            ?>
                            <?php foreach ($list as $list) : ?>
                            <tr>
                                <td><?php echo anchor_popup('project/viewprojectdatafile/'.$list['id'], 'View', $atts) ?></td>
                                <td>
                                <?#php if ($canDELETE) : ?>
                                <a href="#" class="delete" id="<?php echo $list['id'].'/'.$list['projectid'] ?>" name="delete">Delete</a>
                                <?#php endif; ?>
                                </td>
                                <td><?php echo $list['filename'] ?></td>
                                <td><?php echo $list['filetype'] ?></td>
                                <td><?php echo $list['username'] ?></td>
                                <td><?php echo $list['uploaddate'] ?></td>
                            </tr>
                            <?php endforeach; ?>
    
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'}; 
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$(".delete").click(function () {
    
    var $id = $(this).attr('id');
    var ans = window.confirm("Are you sure you want to delete?")

    if (ans)
    {
    window.location = "<?php echo site_url('project/removeDataUpload') ?>/"+$id; 
    return true;
    }
    else
    {
    window.alert("Are you sure you want to cancel?");
    return false;    
    }
    
});

$("#uploaddata").click(function () {
    
    var projectid = $("#projectid").val();   
    var userfile = $("#userfile").val();   
    var ans = window.confirm("Are you sure you want to upload?");
    
    if (ans) {
    
        var countValidate = 0;  
        var validate_fields = ['#projectid', '#userfile']; 

        for (x = 0; x < validate_fields.length; x++) {            
            if($(validate_fields[x]).val() == "") {                        
                $(validate_fields[x]).css(errorcssobj);          
                  countValidate += 1;
            } else {        
                  $(validate_fields[x]).css(errorcssobj2);       
            }        
        }
     
        if (countValidate == 0) {
            
            //window.alert("Successfully upload.");                                                  
        } 
        else { 
            
            window.alert("Required fields must fill up");           
            return false;
        }   
    } else {
        return false;
    } 
    
});

</script>