<div class="breadcrumb pull-right">
    <li>Home</li>
    <li class="active">Business Concern for Approval</li>
</div>
<!-- begin row -->
<?php if (!empty($message)): ?>
<div id="message" class="btn btn-success btn-xs" title="Message" style="margin-left: 5px"><?php echo $message; ?></div>
<?php endif; ?>
<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <!--<div class="panel-heading-btn">
                    <input class="form-control input-white pull-left" id="searchTerm" class="search_box" onkeyup="Search()" placeholder="Enter keywords here..." style="margin-left: 5px;height: 25px; width: 200px;margin-top: 1px;">
                    <i class="fa fa-search" style="margin-left: 5px;margin-top: 8px;"></i> Search
                </div>  -->
                <h4 class="panel-title" style="margin-top: 5px;">Business Concern for Approval - <div class="btn btn-success btn-xs">Total of <?php echo number_format($bcforapproval['bcforapproval'], 0, "", ","); ?> entries</div></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" onsubmit="return validate(this)">
                        <table id="DataTable" class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="selectall" id="selectall"></th>
                                    <th width="5%">No.</th>
                                    <th width="18%">Entered Date</th>
                                    <th width="5%">Code</th>
                                    <th width="25%">Business Concern</th>
                                    <th width="25%">Assigned Audit</th>
                                    <th width="20%">Employee</th>
                                    <th width="10%">Audit</th>
                                    <th width="1%" style="display: none;"></th>
                                    <th width="1%" style="display: none;"></th>
                                    <th width="20%" colspan="3" style="text-align: right;">
                                        <?php if ($canMULTI_DELETE) :?>
                                        <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple cancel"/><i class="fa fa-times"></i></button>
                                        <?php endif ;?>
                                        <?php if ($canMULTI_APPROVED) :?>
                                        <button id="_approved" name="submit" value="multi_approved" type="submit" class="btn btn-sm btn-icon btn-circle btn-warning _approved" title="multiple approved"/><i class="fa fa-thumbs-up"></i></button>
                                        <?php endif;?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;  ?>
                                <?php foreach ($data as $row) : ?>
                                <tr>
                                    <td><input type="checkbox" class="check_list" name="ids[]" id="check_list" value="<?php echo $row['id']; ?>"></td>
                                    <td style="text-align: left;"><?php echo $no ?>.</td>
                                    <td style="text-align: left;"><?php echo $row['entered_date'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['bc_code'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['bc_concern'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['audit'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['fullnameBCI'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['audit_name'] ?></td>
                                    <td style="text-align: left;display: none;"></td>
                                    <td style="font-size: 15px;text-align: right;">
                                    <?php if ($canEDIT) :?>
                                    <a href="<?php echo site_url('entry/editbcfa').'/'.$row['id']?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
                                    <?php endif;?>
                                    <?#php if ($canVIEW):?>
                                    <!--<a href="<?#php echo site_url('entry/viewbc').'/'.$row['id']?>" title="view" class="btn btn-xs btn-icon btn-circle btn-primary view"><i class="fa fa-folder-open"></i></a>-->
                                    <?#php endif;?>
                                    <?php if($canAPPROVED):?>
                                    <a href="<?php echo site_url('entry/approvedbc').'/'.$row['id'].'/'.$row['bc_code']?>" type="submit" title="approved" class="btn btn-xs btn-icon btn-circle btn-warning approved"><i class="fa fa-thumbs-up"></i></a>
                                    <?php endif ;?>
                                    <?php if($canDISAPPROVED):?>
                                    <a href="<?php echo site_url('entry/disapprovedbc').'/'.$row['id']?>" title="disapproved" class="btn btn-xs btn-icon btn-circle btn-danger disapproved"><i class="fa fa-thumbs-down"></i></a>
                                    <?php endif ;?>
                                    </td>
                                </tr>
                                <?php $no += 1; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- end row -->

<script>

$(document).ready(function () {
    $('#DataTable').dataTable({
      "aoColumnDefs" : [ {
          "bRetrieve": true,
          "bDestroy": true,
          "bSortable" : false,
          "aTargets" : [ 0 ] } ],
      "aaSorting": [[ 1, "asc" ]]

    });
});



$(document).ready(function() {

    <?php if (!empty($message)): ?>
    <?php endif; ?>
});

$(".edit").click(function () {

    var ans = window.confirm("Are you sure you want to edit?")

    if (ans)
    {
        //window.alert("Click ok to proceed.");
        return true;
    }
    else
    {
        //window.alert("Are you sure you want to cancel?");
        return false;
    }

});

$(".view").click(function(){

    var ans = window.confirm("Are you sure you want to view?")

    if (ans)
    {
    //window.alert("Successfully cancel.");
    return true;
    }
    else
    {
    //window.alert("Are you sure you want to cancel?");
    return false;
    }

});

$(".disapproved").click(function () {

    var ans = window.confirm("Are you sure you want to disapproved?")

    if (ans)
    {
        window.alert("Successfully disapproved.");
        return true;
    }
    else
    {
        //window.alert("Are you sure you want to cancel?");
        return false;
    }

});

$("._remove").click(function () {

    var ans = window.confirm("Are you sure you want multiple cancel?")

    if (ans)
    {
    return true;
    }
    else
    {
    //window.alert("Are you sure you want to cancel?");
    return false;
    }
});

function validate(f){
f = f.elements;
for (var c = 0, i = f.length - 1; i > -1; --i)
    if (f[i].name && f[i].checked) ++c;
        if (c < 2)
        alert('Please select at least two.');
return c > 1;
};

$("._approved").click(function() {

    var ans = window.confirm("Are you sure you want multiple approved?")

    if (ans)
    {
        //window.alert("Successfully approved.");
        return true;
    }
    else
    {
        //window.alert("Are you sure you want to cancel?");
        return false;
    }
    /*End*/
});

$(".approved").click(function() {
    /*Approve 1 by 1 item*/

    var ans = window.confirm("Are you sure you want to Approved?")

    if (ans)
    {
        window.alert("Successfully approved.");
        return true;
    }
    else
    {
        //window.alert("Are you sure you want to cancel?");
        return false;
    }
    /*End*/
});

$('#selectall').click(function(event) {  //on click
    if(this.checked) { // check select status
        $('.check_list').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }else{
        $('.check_list').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});

$(".duplicate").click(function(){

    var ans = window.confirm("Are you sure you want to duplicate this Action Plan?")

    if (ans)
    {
    //window.alert("Successfully cancel.");
    return true;
    }
    else
    {
    //window.alert("Are you sure you want to cancel?");
    return false;
    }

});

function Search() {
    var searchText = document.getElementById('searchTerm').value;
    var targetTable = document.getElementById('dataTable');
    var targetTableColCount;

    //Loop through table rows
    for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
        var rowData = '';

        //Get column count from header row
        if (rowIndex == 0) {
           targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
           continue; //do not execute further code for header row.
        }

        //Process data rows. (rowIndex >= 1)
        for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
            rowData += targetTable.rows.item(rowIndex).cells.item(colIndex).textContent;
        }

        //If search term is not found in row data
        //then hide the row, else show
        if (rowData.toLowerCase().indexOf(searchText) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';
        }

    }

</script>
