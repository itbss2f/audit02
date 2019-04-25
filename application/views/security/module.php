<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('security/module')?>">Home</a></li>
    <li class="active">Security</li>
    <li class="active">Module</li>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
                <h4 class="panel-title" style="margin-top: 5px;">Module</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No.</th>
                                    <th width="3%">Id.</th>
                                    <th width="15%">Main Module</th>
                                    <th width="20%">Module</th>
                                    <th width="20%">Description</th>
                                    <th width="20%">Path</th>
                                    <th width="5%" style="display: none;"></th>
                                    <th width="10%" colspan="4" style="text-align: right;">
                                    <?php if ($canADD) :?>
                                    <button name="add" type="button" class="btn btn-sm btn-icon btn-circle btn-success addmodule"><i class="fa fa-plus"></i></button>
                                    <?php endif;?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php $no = 1;  ?>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td style="text-align: left;" ><?php echo $no ?></td>
                                        <td style="text-align: left;" ><?php echo $row['id'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['module_name'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['name'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['description'] ?></td>
                                        <td style="text-align: left;" ><?php echo $row['segment_path'] ?></td>
                                        <td colspan="4" style="font-size: 15px;text-align: right;">
                                        <?php if ($canEDIT):?>
                                        <a id="<?php echo $row['id'] ?>" title="edit" class="btn btn-xs btn-icon btn-circle btn-primary editmodule"><i class="fa fa-pencil"></i></a>
                                        <?php endif;?>
                                        <?php if ($canSET_FUNCTIONS):?>
                                        <a id="<?php echo $row['id'] ?>" title="Set function" class="btn btn-xs btn-icon btn-circle btn-warning set"><i class="fa fa-map-marker"></i></a>
                                        <?php endif;?>
                                        <?php if ($canDELETE):?>
                                        <a href="<?php echo site_url('security/removemodule').'/'.$row['id']?>" title="cancel" class="btn btn-xs btn-icon btn-circle btn-danger removemodule"><i class="fa fa-times"></i></a>
                                        <?php endif;?>
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

<div id="modal_addmodule" title="Add Module"></div>
<div id="modal_editmodule" title="Edit Module"></div>
<div id="modal_setfunctionmodx" title="Set Function"></div>

<script>


$(function() {
    $('#modal_addmodule').dialog({
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

    $('.addmodule').click(function() {
        $.ajax({
          url: "<?php echo site_url('security/addmodule') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_addmodule").html($response['addmodule']).dialog('open');
              }
           });
        });
        return false;
});

$(function() {
    $('#modal_editmodule').dialog({
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

    $('.editmodule').click(function() {
        var $id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('security/editmodule') ?>",
          type: "post",
          data: {id: $id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_editmodule").html($response['editmodule']).dialog('open');
              }
           });
        });
        return false;
});

$(function() {
    $('#modal_setfunctionmodx').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 400,
       show: "blind",
       hide: "explode",
       height: 'auto',
       modal: true,
       resizable: false
    });

    $('.set').click(function() {
        var $id = $(this).attr('id');
        $.ajax({
          url: "<?php echo site_url('security/setfunctionmod') ?>",
          type: "post",
          data: {id: $id},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_setfunctionmodx").html($response['setfunctionmod']).dialog('open');
              }
           });
        });
    return false;
});

$(".removemodule").click(function() {
    var ans = confirm("Are you sure you want to remove this Module?");

    if (ans) {

        window.alert('Successfully removed');
        return true;
    }
    else {
        return false;
    }
});

</script>
