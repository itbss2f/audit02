<thead>
<tr>
    <b><td style= "text-align: left; font-size: 20"><?php echo $company_name ?></td></b>
    <br/><b><td style="text-align: left">REPORT TYPE - <b><td style="text-align: left"><?php echo $reportname ?><br/></b> 
    <b><td style="text-align: left; font-size: 20">DATE <b><td style="text-align: left"><?php echo date("F d, Y"); ?>   
                                                                                                         
</tr>
</thead>



<table cellpadding="0" cellspacing="0" width="80%" border="1">  
      
<thead>
  <tr>
            
            <th width="3%">#</th>
            <th width="3%">Code</th>
            <th width="25%">Business Concern</th>
            <th width="5%">Status</th>      
            <th width="5%">Due Date</th>      
            <th width="10%">Project</th>      
            <th width="10%">Department</th>
            <th width="10%">DepartmentII</th> 
            <th width="10%">DepartmentIII</th> 
            <th width="10%">Person</th>
            <th width="10%">PersonII</th>
            <th width="10%">PersonIII</th>
            <th width="15%">Assigned Audit</th>
               
  </tr>
</thead>


<?php if (empty($list)) :  ?>

    <tr>
        <td colspan="12" style="text-align: center; color: red; font-size: 20px;">No Record Found</td>
    </tr>
<?php else : ?>


<?php foreach($list as $data) : 
 $no += 1;

?>
<tr>
    <td style="text-align: center;"><?php echo $no ?></td>
    <td style="text-align: center;"><?php echo $data['bccode'] ?></td> 
    <td><?php echo $data['business_concern'] ?></td>
    <td><?php echo $data['status_name'] ?></td>
    <td style="text-align: center;"><?php echo $data['due_date'] ?></td>
    <td><?php echo $data['projectname'] ?></td>
    <td><?php echo $data['department'] ?></td>
    <td><?php echo $data['department2'] ?></td>
    <td><?php echo $data['department3'] ?></td>
    <td><?php echo $data['person'] ?></td>
    <td><?php echo $data['person2'] ?></td>
    <td><?php echo $data['person3'] ?></td>
    <td><?php echo $data['employee_id'].'  '.$data['audit_staff'] ?></td>
</tr>

<?php endforeach; ?>

<?php endif; ?>






