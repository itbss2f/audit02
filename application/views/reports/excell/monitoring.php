<thead>
<tr>
    <b><td style= "text-align: left; font-size: 20"><?php echo $company_name ?></td></b>
    <br/><b><td style="text-align: left">REPORT TYPE - <b><td style="text-align: left"><?php echo $reportname ?><br/></b> 
    <b><td style="text-align: left; font-size: 20">DATE AS OF <b><td style="text-align: left"><?php echo date("F d, Y", strtotime($datefrom_as)); ?>    
</tr>
</thead>



<table cellpadding="0" cellspacing="0" width="80%" border="1">  
      
<thead>
  <tr>
            <?php if ($reporttype == 1) { ?>
            <th width="3%">#</th>
            <th width="3%">Bc code</th>
            <th width="25%">Business Concern</th>
            <th width="5%">Person</th>
            <th width="5%">Dept</th>
            <th width="5%">Person2</th>
            <th width="5%">Dept2</th>
            <th width="5%">Person3</th>
            <th width="5%">Dept3</th>
            <th width="5%">Project</th>
            <th width="10%">Assigned Audit</th>
            <th width="10%">Recur</th>
            <th width="10%">Issue Remarks</th>
            <th width="10%">Issue</th>
            <th width="10%">Risk</th>
            <th width="10%">Risk2</th>
            <th width="10%">Risk3</th>
            <th width="10%">Risk Rating</th>
            <th width="10%">Impact Value</th>
            <th width="10%">Impact Computation</th>
            <th width="10%">Status</th>
            <th width="6%">Data Entered</th> 
            <th width="6%">Date Tagged as Resolved</th>
            <th width="6%">Due Date</th> 
            <th width="7%">Date Revised</th>
            <th width="10%">Date Resolved</th>
            <th width="3%">Code</th>
            <th width="25%">Action Plan</th>
            <th width="5%">Person</th>
            <th width="5%">Dept</th>
            <th width="5%">Person2</th>
            <th width="5%">Dept2</th>
            <th width="10%">Assigned Audit</th>
            <th width="5%">Project</th>
            <th width="5%">Status</th>      
            <th width="6%">Date Tagged as Implemented</th>
            <th width="6%">Data Entered</th> 
            <th width="6%">Due Date</th> 
            <th width="7%">Date Revised</th>
            <th width="7%">Date Implemented</th>
  
            <?php }   ?>
               
  </tr>
</thead>


<?php 


if ($reporttype == 1 ) {
        $no = 1; $grandtotalcount = 0; 
        foreach ($dlist as $business_concern => $datarow) { ?>

                <!-- <tr>
                    <td colspan='40' style="text-align: left; font-size: 12px; color: black"><?#php echo BC.' - '.$business_concern ?></td>
                </tr> -->

        <?php 
            $result[] = array(array('text' => BC.' - '.$business_concern, 'align' => 'left', 'bold' => true, 'size' => 10));
                    $subtotal = 0;
                    foreach ($datarow as $row) { ?>

                    <tr>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $no ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['bc_code'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['business_concern'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['bc_person'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name1'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_person2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_person3'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name3'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_project_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_audit_staff_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['recur_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['issue_remarks'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_issue'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['risk1'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['risk2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['risk3'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['risk_rating'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['impact_value'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['impact_remarks'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_status'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['bc_entered_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['date_tag'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['due_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['date_revised'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['date_resolved'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['action_plan'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_dept_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['person2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_dept_name2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_audit_staff_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['status_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_tag'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_entered_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_implemented'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_revised'] ?></td>
                </tr>

                    <?php 
                        $result[] = array(array("text" => $no, 'align' => 'left'),
                                    array("text" => $row['code'], 'align' => 'left'),
                                    array("text" => $row['action_plan'], 'align' => 'left'),
                                    array("text" => $row['status_name'], 'align' => 'center'),
                                    array("text" => $row['entered_date'], 'align' => 'right'),
                                    array("text" => $row['ap_due_date'], 'align' => 'right'),
                                    array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                                    array("text" => $row['ap_date_revised'], 'align' => 'right'),
                                    array("text" => $row['ap_date_tag'], 'align' => 'right')
                                   );

                                   $no += 1; $subtotal += 1; $grandtotalcount += 1;
                    } ?>

                <tr>
                    <td colspan='25' style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black;font-weight: bold;">Subtotal Action Plans</td>
                    <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($subtotal, 2, ".", ",")  ?></td>
                </tr>

                    <?php 

                    $result[] = array(array('text' => ''),
                                array('text' => ''),
                                array('text' => 'Subtotal', 'align' => 'left', 'bold' => true),
                                array('text' => $subtotal, 'align' => 'center', 'bold' => true, 'style' => true)

                                );

                    $result[] = array();

                    
                } ?>

                 <tr>
                    <td colspan='25' style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Grandtotal Action Plans</td>
                    <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotalcount, 2, ".", ",")  ?></td>
                </tr>

                <?php 

                    $result[] = array(array('text' => ''),
                                array('text' => ''),
                                array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                                array('text' => $grandtotalcount, 'align' => 'center', 'bold' => true, 'style' => true)

                                );

            }


?>