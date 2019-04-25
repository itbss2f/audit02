
<div class="breadcrumb pull-right">
    <li>Home</li>
    <li>Inquiries</li>
    <li class="active">Records of Action Plan</li>
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
                    <?php if ($canSEARCH):?>
                    <button class="btn btn-success fa fa-search btn-sm pull-right lookup" style="height: 22px;width:30px;margin-top: 2px;" title="look-up" id="lookup"></button>
                    <?php endif;?>
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Records of Action Plan - <div class="btn btn-success btn-xs">Total of <?php echo number_format($total['total_action'], 0, "", ","); ?> entries</div></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <!-- <form action="#" method="get" onsubmit="return false;"> -->
                    <form method="post" onsubmit="return validate(this)">
                        <table id="DataTable" class="table table-striped table-bordered table">
                            <thead>
                                <tr>
                                  <th width="3%"><input type="checkbox" name="selectall" id="selectall"></th>
                                  <th width="3%"><input type="hidden"></th>
                                  <th width="5%">No.</th>
                                  <th width="5%">Code</th>
                                  <th width="12%">Entered Date</th>
                                  <th width="25%">Action Plan</th>
                                  <th width="20%">Project</th>
                                  <th width="20%">Department</th>
                                  <th width="25%">Assigned Audit</th>
                                  <th width="5%">Status</th>
                                  <th width="2%" style="display: none;"></th>
                                  <th width="10%" colspan='3' style="text-align: right;">
                                  <!--<button name="submit" value="duplicate" type="submit" class="btn btn-info fa fa-gear duplicate" onmouseout="dupOut(this)" title="duplicate"></button>-->
                                  <?php if ($canMULTI_DELETE):?>
                                  <!-- <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple cancel" onclick="if(!this.form.ids.checked){alert('You check atleast 1 checkbox.');return}else {$('#formsave').submit();}"/><i class="fa fa-times"></i></button>  --> 
                                  <button id="_remove" name="submit" value="multi_delete" type="submit" class="btn btn-sm btn-icon btn-circle btn-danger _remove" title="multiple cancel"/><i class="fa fa-times"></i></button>
                                  <?php endif;?>
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php $no = 1;  ?>
                                    <?php foreach ($data as $row) : ?>
                                        <tr>
                                            <td colspan='2'>
                                            <input type="checkbox" class="check_list" name="ids[]" id="check_list" value="<?php echo $row['id'];?>">
                                            <input type="hidden" class="check_list" name="ap_status[]" id="check_list" value="<?php echo $row['ap_status'];?>">
                                            </td>
                                            <!--<td style="text-align: left;"><a href="<?#php echo site_url('entry/viewActionPlan').'/'.$row['id']?>"><?#php echo $no ?></a></td> -->
                                            <td style="text-align: left;"><?php echo $no ?></td>
                                            <td style="text-align: left;"><?php echo $row['code'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['entered_date'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['action_plan'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['projectname'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['department'] ?></td>
                                            <td style="text-align: left;"><?php echo $row['auditname']?></td>
                                            <?php if ($row['ap_status'] == 2) :?>
                                            <td style="text-align: center;"><div class="btn btn-success btn-xs"><?php echo $row['apstatus']?></div></td>
                                            <?php elseif ($row['ap_status'] == 8) :?>
                                            <td style="text-align: center;"><div class="btn btn-danger btn-xs"><?php echo $row['apstatus']?></div></td>
                                            <?php elseif ($row['is_duplicate'] == 1):?>
                                            <td style="text-align: center;"><div class="btn btn-primary btn-xs">DUPLICATE</div></td>
                                            <?php else: ?>
                                            <td style="text-align: center;font-weight: bold;font-size: 14px;"><div class="btn btn-success btn-xs"><?php echo $row['apstatus']?></div></td>
                                            <?php endif; ?>

                                            <td colspan="4" style="text-align: right;font-size: 15px;">
                                            <?php if (($row['ap_status'] != 2 &&  $row['ap_status'] != 8 && $row['is_duplicate'] != 1 && $row['bc_code'] != null)) : ?>
                                                <?php if ($canEDIT): ?>
                                                <a href="<?php echo site_url('entry/editAction').'/'.$row['id'].'/'.$row['code']?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
                                                <?php endif;?>
                                                <?php if ($canDELETE) : ?>
                                                <a href="<?php echo site_url('entry/removeAction').'/'.$row['id'].'/'.$row['ap_status']?>" type="submit" title="cancel" class="btn btn-xs btn-icon btn-circle btn-danger remove"><i class="fa fa-times"></i></a>
                                                <?php endif;?>
                                            <?php elseif ($row['bc_code'] == "" || $row['bc_code'] == null) :?>
                                                <?php if ($canVIEW):?>
                                                <a href="<?php echo site_url('entry/viewuntagged').'/'.$row['id']?>" title="view" class="btn btn-xs btn-icon btn-circle btn-primary view"><i class="fa fa-folder-open"></i></a>
                                                <?php endif;?>
                                                <?php else : ?>
                                                <?php if ($canVIEW):?>
                                                <a href="<?php echo site_url('entry/viewap').'/'.$row['id'].'/'.$row['code']?>" title="view" class="btn btn-xs btn-icon btn-circle btn-primary view"><i class="fa fa-folder-open"></i></a>
                                                <?php endif;?>
                                            <?php endif; ?>
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

<div id="modal_search" title="Search Action Plan"></div>


<script type='text/javascript'>
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

$(".duplicatefrom").click(function(){

    var ans = window.confirm("Are you sure you want to duplicatefrom this Action Plan?")

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

$(function() {

    $('#modal_search').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 1200,
       show: "blind",
       hide: "explode",
       height: 450,
       modal: true,
       resizable: true
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



/*$("#select_company").change(function() {
    var $id = $("#id").val();
    $.ajax({
        url: "<?#php echo site_url('entry/listofAction')?>",
        type: 'post',
        data: {id: $id},
        success: function(response){
            $response = $.parseJSON(response);
            $("#select_company").html($response['listofAction']).dialog('open');
        }

    });
}); */



</script>
