
<div class="breadcrumb pull-right">
    <li>Home</li>
    <li>Inquiries</li>
    <li class="active">Approved Audit Action Plan</li>
</div>
<!-- begin row -->
<?php if (!empty($message)): ?>
<div id="message" class="btn btn-success btn-xs" title="Message" style="margin-left: 5px"><?php echo $message; ?></div>
<?php endif; ?>

<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <button class="btn btn-success fa fa-search btn-sm pull-right" style="height: 22px;width:30px;margin-top: 2px;" title="look-up" id="lookup"></button>
                    <!--<input class="form-control input-white pull-left" id="searchTerm" class="search_box" onkeyup="Search()" placeholder="Enter keywords here..." style="margin-left: 5px;height: 25px; width: 200px;margin-top: 1px;"> -->
                    <i class="fa fa-search" style="margin-left: 5px;margin-top: 8px;"></i> Search
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Approved Audit Action Plan - <div class="btn btn-success btn-xs">Total of <?php echo number_format($xtotal['total_actionplan'], 0, "", ","); ?> entries</div></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" onsubmit="return validate(this)">
                        <table id="DataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="selectall" id="selectall"></th>
                                    <th width="8%">No.</th>
                                    <th width="5%">Code</th>
                                    <th width="13%">Entered Date</th>
                                    <th width="25%">Action Plan</th>
                                    <th width="15%">Project Name</th>
                                    <th width="15%">Employee</th>
                                    <th width="5%">Status</th>
                                    <th width="2%" style="display: none;"></th>
                                    <th width="10%" colspan='3' style="text-align: right;">
                                    <!--<button name="submit" value="duplicate" type="submit" class="btn btn-info fa fa-gear duplicate" onmouseout="dupOut(this)" title="duplicate"></button>-->
                                    <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple cancel" onclick="if(!this.form.ids.checked){alert('You check atleast 1 checkbox.');return}else {$('#formsave').submit();}"/><i class="fa fa-times"></i></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php $no = 1;  ?>
                                    <?php foreach ($data as $row) : ?>
                                        <tr>
                                            <td><input type="checkbox" class="check_list" name="ids[]" id="check_list" value="<?php echo $row['id']; ?>"></td>
                                            <td style="text-align: left;"><?php echo $no ?>.</td>
                                            <td style="text-align: left;"><?php echo $row['code'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['entered_date'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['action_plan'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['project_name'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['fullname']?></td>
                                            <?php if ($row['status'] == 2) :?>
                                            <td style="text-align: center;"><div class="btn btn-success btn-xs"><?php echo $row['status_code']?></div></td>
                                            <?php elseif ($row['status'] == 8) : ?>
                                            <td style="text-align: center;"><div class="btn btn-danger btn-xs"><?php echo $row['status_code']?></div></td>
                                            <?php else: ?>
                                            <td style="text-align: center;"><?php echo $row['status_code']?></td>
                                            <?php endif; ?>
                                            <td colspan="3" style="text-align: right;font-size: 15px;">
                                            <!--<a href="<?#php echo site_url('entry/editAction').'/'.$row['id']?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a> -->
                                            <!--<a href="<?#php echo site_url('entry/removeAction').'/'.$row['id']?>" type="submit" title="cancel" class="btn btn-xs btn-icon btn-circle btn-danger remove"><i class="fa fa-times"></i></a>-->
                                            <?php if ($canVIEW):?>
                                            <a href="<?php echo site_url('entry/viewActionPlan').'/'.$row['id']?>" title="view" class="btn btn-xs btn-icon btn-circle btn-primary view"><i class="fa fa-folder-open"></i></a>
                                            <?php endif;?>
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
    </div>
</div>

<div id="modal_search" title="Look-up"></div>

<script type='text/javascript'>

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

$(function() {
    $('#modal_search').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 860,
       show: "blind",
       hide: "explode",
       height: 600,
       modal: true,
       resizable: false
    });

    $('#lookup').click(function() {
        $.ajax({
          url: "<?php echo site_url('entry/searchofaction') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_search").html($response['searchofaction']).dialog('open');
              }
           });
        });
        return false;
});

$(document).ready(function() {

    <?php if (!empty($message)): ?>
    <?php endif; ?>
});

function validate(f){
f = f.elements;
for (var c = 0, i = f.length - 1; i > -1; --i)
    if (f[i].name && f[i].checked) ++c;
        if (c < 2)
        alert('Please select at least two.');
return c > 1;
};

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

$(".remove").click(function(){

    var ans = window.confirm("Are you sure you want to cancel?")

    if (ans)
    {
    window.alert("Successfully cancel.");
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

$("._remove").click(function(){

    var ans = window.confirm("Are you sure you want multiple cancel?")

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

$('#selectall').click(function(event) {  //on click
    if(this.checked) { // check select status
        $('.check_list').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "check_list"
        });
    }else{
        $('.check_list').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "check_list"
        });
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
