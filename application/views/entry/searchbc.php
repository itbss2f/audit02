
<div class="row-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>Business Code</label>
                <input class="form-control" type="text" name="lookup_code" id="lookup_code" placeholder="Search Bc Code">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Business Concern</label>
                <input class="form-control" type="text" name="lookup_bc" id="lookup_bc" placeholder="Search Business Concern">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Project Name</label>
                <select class="form-control" id="lookup_project_id" name="lookup_project_id">
                    <option value="">Search by Project Name</option>
                    <?php foreach ($bc_project as $row) : ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['code'].' - '.$row['description'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <Label>Assigned Audit</label>
                <select class="form-control" id="lookup_assigned_audit" name="lookup_assigned_audit">
                    <option value="">Search by Assigned Audit</option>
                    <?php foreach ($bc_users as $row) : ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['employee_id'].' - '.$row['audit_staff'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <Label>Department</label>
                <select class="form-control" id="lookup_dept" name="lookup_dept">
                    <option value="">Search by Department</option>
                    <?php foreach ($bc_dept as $row) : ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['code'].' - '.$row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <Label>Person Responsible</label>
                <select class="form-control" id="lookup_person" name="lookup_person">
                    <option value="">Search by Person Responsible</option>
                    <?php foreach ($bc_emp as $row) : ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row pull-right">
        <button class="btn btn-sm btn-success" id="search" name="search">Search</button>
        <button class="btn btn-sm btn-success" id="excelbc" name="search">Excel</button>
    </div>
    <legend></legend>
</div>

<div class="row-fluid" style="overflow:auto;height:350px">
    <table cellpadding="0" cellspacing="0" style="white-space:nowrap;width:800px" class="table">
        <thead>
            <tr>
                <th width="5%"></th>
                <th width="5%">Code</th>
                <th width="20%">Business Concern</th>
                <th width="15%">Project</th>
                <th width="15%">Department</th>
                <th width="15%">DepartmentII</th>
                <th width="15%">DepartmentIII</th>
                <th width="15%">Person</th>
                <th width="15%">PersonII</th>
                <th width="15%">PersonIII</th>
                <th width="15%">Assigned Audit</th>
            </tr>
        </thead>
        <tbody class="search_detailsbc">
        </tbody>
    </table>
    <div class="clear"></div>
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#search").click(function() {
    var $lookup_code = $("#lookup_code").val();
    var $lookup_bc = $("#lookup_bc").val();
    var $lookup_assigned_audit = $("#lookup_assigned_audit").val();
    var $lookup_project_id = $("#lookup_project_id").val();
    var $lookup_dept = $("#lookup_dept").val();
    var $lookup_dept2 = $("#lookup_dept2").val();
    var $lookup_dept3 = $("#lookup_dept3").val();
    var $lookup_person = $("#lookup_person").val();
    var $lookup_person2 = $("#lookup_person2").val();
    var $lookup_person3 = $("#lookup_person3").val();
    $.ajax({
        url: "<?php echo site_url('entry/searchingbc')?>",
        type: "post",
        data: {lookup_code: $lookup_code, lookup_bc: $lookup_bc,lookup_assigned_audit:$lookup_assigned_audit,
              lookup_project_id: $lookup_project_id, lookup_dept: $lookup_dept,lookup_dept2: $lookup_dept2,
              lookup_dept3: $lookup_dept3, lookup_person: $lookup_person, lookup_person2: $lookup_person2,
              lookup_person3: $lookup_person3},
        success: function(response) {
            var $response = $.parseJSON(response);
            $(".search_detailsbc").html($response['search_detailsbc']);
        }
    });
});

$(document).ready( function() {

    $("#excelbc").die().live("click",function() {

        var lookup_code = $("#lookup_code").val();
        var lookup_bc = $("#lookup_bc").val();
        var lookup_assigned_audit = $("#lookup_assigned_audit").val();
        var lookup_project_id = $("#lookup_project_id").val();
        var lookup_dept = $("#lookup_dept").val();
        var lookup_person = $("#lookup_person").val();

        //alert ('Hoy'); exit;

        var countValidate = 0;  
        var validate_fields = ['#'];
        
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
        window.open("<?php echo site_url('searching/search_excel_bc/') ?>?lookup_code="+lookup_code+"&lookup_bc="+lookup_bc+"&lookup_assigned_audit="+lookup_assigned_audit+"&lookup_project_id="+lookup_project_id+"&lookup_dept="+lookup_dept+"&lookup_person="+lookup_person, '_blank');
            window.focus();
        }


    });
});




</script>
