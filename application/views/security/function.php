<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('security/functions')?>">Home</a></li>
    <li class="active">Security</li>
    <li class="active">Function</li>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Function</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post">
                        <table id="DataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No.</th>
                                    <th width="5%">Id</th>
                                    <th width="15%">Name</th>
                                    <th width="30%">Description</th>
                                    <th width="5%" style="display: none;"></th>
                                    <th width="8%" colspan="3" style="text-align: right;">
                                    <button name="add" type="button" title="add" class="btn btn-sm btn-icon btn-circle btn-success addfunction"><i class="fa fa-plus"></i></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php $no = 1;  ?>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td style="text-align: left;" ><?php echo $no ?></td>
                                        <td style="text-align: left;" ><?php echo $row['id'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['name'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['description'] ?></td>
                                        <td colspan="2" style="font-size: 15px;text-align: right;">
                                        <a id="<?php echo $row['id'] ?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary editfunction"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo site_url('security/removefunction').'/'.$row['id']?>" title="cancel" class="btn btn-xs btn-icon btn-circle btn-danger removefunction"><i class="fa fa-times"></i></a>
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

<div id="modal_editfunctionmodule" title="Edit Function Module"></div>
<div id="modal_addfunctionmodule" title="Add Function Module"></div>

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
    $('#modal_editfunctionmodule').dialog({
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

    $('.editfunction').click(function() {
        var $id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('security/editfunctionmodule') ?>",
          type: "post",
          data: {id: $id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_editfunctionmodule").html($response['editfunctionmodule']).dialog('open');
              }
           });
        });
        return false;
});

$(function() {
    $('#modal_addfunctionmodule').dialog({
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

    $('.addfunction').click(function() {
        $.ajax({
          url: "<?php echo site_url('security/addfunctionmodule') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_addfunctionmodule").html($response['addfunctionmodule']).dialog('open');
              }
           });
        });
        return false;
});

$(".removefunction").click(function() {
    var ans = confirm("Are you sure you want to remove this Function Module?");

    if (ans) {

        window.alert('Successfully removed');
        return true;
    }
    else {
        return false;
    }
});

</script>
