<?php if (empty($list)) : ?>
    <tr>
        <td colspan="12" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
    </tr>
<?php else : ?>
<?php foreach($list as $data) : ?>
<tr>
    <td>
    <a href="<?php echo site_url('entry/editbc').'/'.$data['id']?>" target="_blank" title="load" class="btn btn-xs btn-icon btn-circle btn-primary edit"><i class="fa fa-pencil"></i></a>
    </td>
    <td><?php echo $data['bccode'] ?></td>
    <td><?php echo $data['business_concern'] ?></td>
    <td><?php echo $data['projectcode'].' - '.$data['projectname'] ?></td>
    <td><?php echo $data['code'].' - '.$data['department'] ?></td>
    <td><?php echo $data['code'].' - '.$data['department2'] ?></td>
    <td><?php echo $data['code'].' - '.$data['department3'] ?></td>
    <td><?php echo $data['code'].' - '.$data['person'] ?></td>
    <td><?php echo $data['code'].' - '.$data['person2'] ?></td>
    <td><?php echo $data['code'].' - '.$data['person3'] ?></td>
    <td><?php echo $data['employee_id'].' - '.$data['audit_staff'] ?></td>
</tr>
<?php endforeach; ?>

<?php endif; ?>
