<?php if (empty($dlist)) : ?>
    <tr>
        <td colspan="6" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
    </tr>
<?php else : ?>
<?php foreach($dlist as $data) : ?>
<tr>
    <td>
    <a href="<?php echo site_url('entry/addnewbcexistingap').'/'.$data['id']?>" target="_blank" title="duplicate" class="btn btn-xs btn-icon btn-circle btn-primary duplicate"><i class="fa fa-copy"></i></a>
    </td>
    <td><?php echo $data['action_code'] ?></td>
    <td><?php echo $data['action_plan'] ?></td>
    <td><input type="hidden" value="<?php echo $data['id'] ?>"></button></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
