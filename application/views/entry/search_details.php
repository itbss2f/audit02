<?php if (empty($list)) : ?>
    <tr>
        <td colspan="6" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
    </tr>
<?php else : ?>
<?php foreach($list as $data) : ?>
<tr>
    <td>
    <a href="<?php echo site_url('entry/editAction').'/'.$data['id']?>" target="_blank" title="load" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
    </td>
    <td><?php echo $data['action_code'] ?></td>
    <td><?php echo $data['action_plan'] ?></td>
    <td><?php echo $data['projectcode'].' - '.$data['projectname'] ?></td>
    <td><?php echo $data['department'] ?></td>
    <td><?php echo $data['department2'] ?></td>
    <td><?php echo $data['person'] ?></td>
    <td><?php echo $data['person2'] ?></td>
    <td><?php echo $data['employee_id'].' - '.$data['audit_staff'] ?></td>
</tr>
<?php endforeach; ?>

<?php endif; ?>
