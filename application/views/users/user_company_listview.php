<?php 
foreach ($user_company_list as $x => $user_company_list) : ?>
<tr>
    <td><strong><?php echo $x ?></strong></td>
    <td>
        <ul class="the-icons clearfix">
            <?php 
            foreach ($user_company_list as $list) : 
            $check = "checked = 'checked'";    
            if ($list['useraccess'] == 999999 ) :
                $check = "";   
            endif;
            ?>
            <li><label class="checkbox inline font12"><input type="checkbox" class="functioncheckbox" <?php echo $check ?> value="<?php echo $list['moduleid'].'&'.$list['functionid'] ?>"><?php echo $list['functionname'] ?></label></li>
            <?php
            endforeach;
            ?>
        </ul>
    </td>
</tr>        
<?php
endforeach;
?>

<script>
$(".functioncheckbox").one("click", function() {     
    var $module_functionx = $(this).val();
    var $user_id = "<?php echo $user_id ?>";
    $.ajax({
        url: "<?php echo site_url('user/setaccess') ?>",
        type: "post",
        data: {module_functionx: $module_functionx, user_id: $user_id},
        success: function(response) {

        }
    });
});
</script>
