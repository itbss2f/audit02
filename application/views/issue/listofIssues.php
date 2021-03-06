
<div class="breadcrumb pull-right">
    <li>Home</li>
    <li class="active">Issues</li>
    <?php if($canADD):?>
    <li class="active"><a></a>Issue Records</li>
    <?php endif;?>
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
                    <!--<i class="fa fa-search" style="margin-left: 5px;margin-top: 8px;"></i> Search-->
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Issue Records - <div class="btn btn-success btn-xs">Total of <?php echo number_format($total['total_issues'], 0, "", ","); ?> entries</div></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" onsubmit="return validate(this)">
                        <table id="DataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="selectall" id="selectall"></th>
                                    <th width="3%">No.</th>
                                    <th width="5%">Code</th>
                                    <th width="35%">Description</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Username</th>
                                    <th width="15%">Date Entered</th>
                                    <th width="15%" style="text-align: right;">
                                    <?php if($canMULTI_DELETE):?>
                                    <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple delete"><i class="fa fa-times"></i></button>
                                    <?php endif;?>
                                    <?php if($canADD):?>
                                    <button id="add" name="add" type="button" class="btn btn-sm btn-icon btn-circle btn-primary add" title="add"><i class="fa fa-plus-square"></i></button>
                                    <?php endif;?>
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;  ?>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="check_list" name="ids[]" id="check_list" value="<?php echo $row['id']; ?>"></td>
                                        <td style="text-align: left;" ><?php echo $no ?></td>
                                        <td style="text-align: left;" ><?php echo $row['code'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['description'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['status'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['username'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['user_d'] ?></td>
                                        <td style="font-size: 15px;text-align: right;">
                                        <?php if ($canEDIT):?>
                                        <a title="edit" id="<?php echo $row['id']; ?>" name="edit" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
                                        <?php endif;?>
                                        <?php if($canDELETE): ?>
                                        <a href="<?php echo site_url('issue/removedata').'/'.$row['id']?>" type="submit" title="delete" class="btn btn-xs btn-icon btn-circle btn-danger remove"><i class="fa fa-times"></i></a>
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

<div id="modal_editIssue" title="Edit Issue"></div>
<div id="modal_add_Issue" title="Add Issue"></div>


<script>

$(document).ready(function () {
    $('#DataTable').dataTable({
      "aoColumnDefs" : [ {
          "bRetrieve": true,
          "bDestroy": true,
          "bSortable" : false,
          "aTargets" : [ 0 ]
      } ],
      "aaSorting": [[ 1, "asc" ]]
    });
});

$(function() {
    $('#modal_editIssue').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 460,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.edit').click(function() {
        var $id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('issue/editdata') ?>",
          type: "post",
          data: {id: $id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_editIssue").html($response['editdata']).dialog('open');
              }
           });
        });
        return false;
});

$(function() {
    $('#modal_add_Issue').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 460,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.add').click(function() {
        $.ajax({
          url: "<?php echo site_url('issue/newdata') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_add_Issue").html($response['newdata']).dialog('open');
              }
           });
        });
        return false;
});

function validate(f){
f = f.elements;
for (var c = 0, i = f.length - 1; i > -1; --i)
    if (f[i].name && f[i].checked) ++c;
        if (c < 2)
        alert('Please select at least two.');
return c > 1;
};

$(".remove").click(function () {

    var ans = window.confirm("Are you sure you want to cancel?")

    if (ans)
    {
    window.alert("Successfully remove.");
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


        if (rowData.toLowerCase().indexOf(searchText) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';

    }

}

</script>
