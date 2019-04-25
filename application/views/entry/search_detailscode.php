<?php if (empty($list)) : ?>
    <tr>
        <td colspan="6" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
    </tr>
<?php else : ?>

<?php foreach($list as $data) : ?>
		
<tr>
    <?php if ($data['bc_code'] == null) :?>
    <td><a href="<?php echo site_url('entry/insertnewbccodetothisaction').'/'.$data['id'].'/'.$bc_code?>" target="_blank" title="duplicate" class="btn btn-xs btn-icon btn-circle btn-primary duplicate"><i class="fa fa-copy"></i></a></td>
    <?php else: ?>
    <td><a href="<?php echo site_url('entry/addnewactionplanforthisbccode').'/'.$data['id'].'/'.$bc_code?>" target="_blank" title="duplicate" class="btn btn-xs btn-icon btn-circle btn-primary duplicate"><i class="fa fa-copy"></i></a></td>
    <?php endif; ?>
    <td><?php echo $data['action_code'] ?></td>
    <td><?php echo $data['action_plan'] ?></td>
    <td><input type="hidden" value="<?php echo $data['id'] ?>"></button></td>
</tr>

<?php foreach($bc_code as $dlist => $bc_code) : ?>

<?php endforeach; ?>

<?php endforeach; ?>
<?php endif; ?>




