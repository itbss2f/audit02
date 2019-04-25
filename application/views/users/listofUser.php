
<div class="breadcrumb pull-right">
    <li class="active">
        <i class="fa fa-home"></i>
        Home
    </li>
    <li class="active">
        <i class="fa fa-lock"></i>
        Security
    </li>
    <li class="active">
        <i class="fa fa-wrench"></i>
        User and Access Control
    </li>
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
                <!--<div  class="panel-heading-btn">
                    <input class="form-control input-white pull-left" id="searchTerm" class="search_box" onkeyup="Search()" placeholder="Enter keywords here..." style="margin-left: 20px;height: 25px; width: 200px;margin-top: 1px;">
                    <i class="fa fa-search" style="margin-left: 5px;margin-top: 8px;"></i> Search
                </div>-->
                <h4 class="panel-title" style="margin-top: 5px;">User and Access Control</h4>
                <!--<span class="label label-theme m-l-5">NEW</span>-->
            </div>
            <div class="panel-body">
                <form method="post" onsubmit="return validate(this)">
                    <div class="table-responsive">
                        <table id="DataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="selectall" id="selectall"></th>
                                    <th width="3%">No.</th>
                                    <th width="5%">EmployeeID</th>
                                    <th width="30%">Name</th>
                                    <th width="20%">UserName</th>
                                    <th width="10%">Email</th>
                                    <th width="5%" style="display: none;"></th>
                                    <th colspan="4" width="13%" style="text-align: right;">
                                    <?php if ($canMULTI_DELETE) :?>
                                    <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple cancel"><i class="fa fa-times"></i></button>
                                    <?php endif;?>
                                    <?php if ($canADD):?>
                                    <button name="add" type="button" class="btn btn-sm btn-icon btn-circle btn-primary add" title="add"><i class="fa fa-plus-square"></i></button>
                                    <?php endif;?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php $no = 1;  ?>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="check_list" name="ids[]" id="check_list" value="<?php echo $row['user_id']; ?>"></td>
                                        <td style="text-align: left;" ><?php echo $no ?></td>
                                        <td style="text-align: left;" ><?php echo $row['employee_id'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['audit_staff'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['username'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['email'] ?></td>
                                        <td colspan="4" style="font-size: 15px;text-align: right;">
                                        <?php if ($canEDIT) :?>
                                        <a id="<?php echo $row['user_id'] ?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
                                        <?php endif;?>
                                        <a id="<?php echo $row['user_id'] ?>" title="Set Company" class="btn btn-xs btn-icon btn-circle btn-success setcompany"><i class="fa fa-asterisk"></i></a>
                                        <a id="<?php echo $row['user_id'] ?>" title="Set user_function" class="btn btn-xs btn-icon btn-circle btn-warning set"><i class="fa fa-map-marker"></i></a>
                                        <?php if ($canDELETE) :?>
                                        <a href="<?php echo site_url('user/removedata').'/'.$row['user_id']?>" title="remove" class="btn btn-xs btn-icon btn-circle btn-danger remove"><i class="fa fa-times"></i></a>
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

<div id="modal_editUserdata" title="Edit"></div>
<div id="modal_addUserdata" title="User Form"></div>
<div id="modal_setfunctionuserx" title="User Access"></div>
<div id="modal_setcompany" title="Company Access"></div>

<script>

/*$(document).ready(function () {
    $('#DataTable').dataTable({
      "aoColumnDefs" : [ {
          "bRetrieve": true,
          "bDestroy": true,
          "bSortable" : true,
          "aTargets" : [ 0 ]
      } ],
      "aaSorting": [[ 1, "asc" ]]
    });
});*/

$(function() {
    $('#modal_setcompany').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 500,
       show: "blind",
       hide: "explode",
       height: 500,
       modal: true,
       resizable: false
    });

    $('.setcompany').click(function() {
        var $user_id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('user/setcompany') ?>",
          type: "post",
          data: {user_id: $user_id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_setcompany").html($response['setcompany']).dialog('open');
              }
           });
        });
    return false;
});

$(function() {
    $('#modal_setfunctionuserx').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 500,
       show: "blind",
       hide: "explode",
       height: 500,
       modal: true,
       resizable: false
    });

    $('.set').click(function() {
        var $user_id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('user/setuserfunction') ?>",
          type: "post",
          data: {user_id: $user_id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_setfunctionuserx").html($response['setuserfunction']).dialog('open');
              }
           });
        });
    return false;
});

$(document).ready(function() {

    <?php if (!empty($message)): ?>
    <?php endif; ?>
});

$(function() {
    $('#modal_addUserdata').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 600,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.add').click(function() {
        $.ajax({
          url: "<?php echo site_url('user/userdata') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_addUserdata").html($response['userdata']).dialog('open');
              }
           });
        });
        return false;
});

$(function() {
    $('#modal_editUserdata').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 600,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.edit').click(function() {
        var $user_id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('user/editUserData') ?>",
          type: "post",
          data: {user_id: $user_id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_editUserdata").html($response['editUserData']).dialog('open');
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

    var ans = window.confirm("Are you sure you want to cancel")

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

    var ans = window.confirm("Are you sure you want multiple cancel")

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

        //If search term is not found in row data
        //then hide the row, else show
        if (rowData.toLowerCase().indexOf(searchText) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';

    }

}

</script>
