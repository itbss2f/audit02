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
            <?php if ($reporttype == 1) { ?>
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="12%">Department</th>
            <th width="8%">Risk Assessment</th>      
            <th width="2%"></th>      
            <th width="10%">Issue</th>      
            <th width="12%">Project Name</th>
            <th width="05%">Entered Date</th> 
            <th width="05%">Due Date</th> 
            <th width="08%">Person</th>
            <th width="05%">Aging</th>
            <th width="08%">Remarks</th>
            <th width="05%">Audit Staff</th>
            <?php } elseif ($reporttype == 2) { ?>
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="04%">Status</th>
            <th width="8%">Risk Assessment</th>      
            <th width="2%"></th>      
            <th width="10%">Issue</th>      
            <th width="12%">Project Name</th>
            <th width="05%">Entered Date</th> 
            <th width="05%">Due Date</th> 
            <th width="08%">Person</th>
            <th width="05%">Aging</th>
            <th width="08%">Remarks</th>
            <th width="05%">Audit Staff</th>
            <?php } elseif ($reporttype == 3) { ?>
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="03%">Status</th>
            <th width="10%">Department</th>      
            <th width="12%">Issue</th>      
            <th width="12%">Project Name</th>      
            <th width="05%">Entered Date</th>
            <th width="05%">Due Date</th> 
            <th width="05%">Person</th> 
            <th width="08%">Aging</th>
            <th width="05%">Remarks</th>
            <th width="08%">Audit Staff</th>
            <?php } elseif ($reporttype == 4) { ?>
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="03%">Status</th>
            <th width="10%">Department</th>      
            <th width="09%">Risk Assessment</th>      
            <th width="02%"></th>      
            <th width="12%">Project Name</th>      
            <th width="05%">Entered Date</th>
            <th width="05%">Due Date</th> 
            <th width="10%">Person</th> 
            <th width="05%">Aging</th>
            <th width="08%">Remarks</th>
            <th width="05%">Audit Staff</th>
            <?php } elseif ($reporttype == 5) { ?>
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="03%">Status</th>
            <th width="10%">Department</th>      
            <th width="09%">Risk Assessment</th>      
            <th width="02%"></th>      
            <th width="12%">Issue</th>      
            <th width="05%">Entered Date</th>
            <th width="05%">Due Date</th> 
            <th width="10%">Person</th> 
            <th width="05%">Aging</th>
            <th width="08%">Remarks</th>
            <th width="05%">Audit Staff</th>
            <?php } else { ?> 
            <th width="3%">#</th>
            <th width="15%">Action Plan</th>
            <th width="03%">Status</th>
            <th width="10%">Department</th>      
            <th width="09%">Risk Assessment</th>      
            <th width="02%"></th>      
            <th width="12%">Project Name</th>      
            <th width="05%">Entered Date</th>
            <th width="05%">Due Date</th> 
            <th width="10%">Person</th> 
            <th width="05%">Aging</th>
            <th width="08%">Remarks</th>
            <th width="05%">Audit Staff</th>
            <?php  } ?>

</thead>


<?php 

$no = 1;
    if ($reporttype == 1) { 
        $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($dlist as $status  => $datax) { ?>

                <tr>
                    <td colspan='13' style="text-align: left; font-size: 12px; color: black;font-weight: bold"><?php echo 'STATUS'.' - '.$status ?></td>
                </tr>

            <?php 
                $result[] = array(array('text' => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array(); 
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    } else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                } ?>

                <tr>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['risk_name'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo '-  '.$row['rating_code'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['issue_name'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                </tr>

                <?php 

                $result[] = array(
                    array('text' => $no,  'align' => 'center'),
                    array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                    array('text' => $row['dept_name'], 'align' => 'left'),
                    array('text' => $row['risk_name'], 'align' => 'left'),
                    array('text' => '-  '.$row['rating_code'], 'align' => 'left'),
                    array('text' => $row['issue_name'], 'align' => 'left'),
                    array('text' => $row['project_name'], 'align' => 'left'),
                    array('text' => $row['entered_date'], 'align' => 'left'),
                    array('text' => $row['ap_due_date'], 'align' => 'left'),
                    array('text' => $row['person'], 'align' => 'left'),
                    array('text' => $aging, 'align' => 'center' , 'bold' => true),
                    array('text' => $row['remarks'], 'align' => 'left'),
                    array('text' => $row['audit_staff'], 'align' => 'left')
                );
                $no +=1;  $grandtotalcount += 1;
            } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Subtotal</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
            </tr>

            <?php 

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
            </tr>

             <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           } else if ($reporttype == 2) { ?>

           <?php
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($dlist as $dept  => $datax) { ?>

                <tr>
                    <td colspan='13' style="text-align: left; font-size: 12px; color: black;font-weight: bold"><?php echo 'DEPARTMENT'.' - '.$dept ?></td>
                </tr>

            <?php
                $result[] = array(array('text' => 'DEPARTMENT'.' - '.$dept, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array();
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    } ?>

                    <tr>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['status_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['risk_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo '-  '.$row['rating_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['issue_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                    </tr>

                    <?php
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'left'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'left'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;
                } ?>

                <tr>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Subtotal</td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
                </tr>

                <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
            </tr>

             <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           } else if ($reporttype == 3) { ?>

           <?php
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($dlist as $risk  => $datax) { ?>

            <tr>
                <td colspan='12' style="text-align: left; font-size: 12px; color: black;font-weight: bold"><?php echo 'RISK'.' - '.$risk ?></td>
            </tr>

            <?php
                $result[] = array(array('text' => 'RISK'.' - '.$risk, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array();
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    } ?>

                    <tr>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['status_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['issue_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                    </tr>

                    <?php
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                } ?>

                <tr>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Subtotal</td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
                </tr>

                <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
            } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
            </tr>

             <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else if ($reporttype == 4) { ?>

           <?php
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($dlist as $issue  => $datax) { ?>

            <tr>
                <td colspan='13' style="text-align: left; font-size: 12px; color: black;font-weight: bold"><?php echo 'ISSUE'.' - '.$issue ?></td>
            </tr>

            <?php
                $result[] = array(array('text' => 'ISSUE'.' - '.$issue, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    } ?>

                    <tr>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['status_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['risk_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo '-  '.$row['rating_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                    </tr>

                    <?php
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                } ?>

                <tr>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Subtotal</td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
                </tr>

                <?php

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
            } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
            </tr>

             <?php
                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else if ($reporttype == 5) { ?>

           <?php
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($dlist as $project_name  => $datax) { ?>

            <tr>
                <td colspan='13' style="text-align: left; font-size: 12px; color: black;font-weight: bold"><?php echo 'PROJECT NAME'.' - '.$project_name ?></td>
            </tr>

            <?php 
                $result[] = array(array('text' => 'PROJECT NAME'.' - '.$project_name, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    } ?>

                    <tr>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'].' - '.$row['action_plan'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['status_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['risk_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo '-  '.$row['rating_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['issue_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                    </tr>

                <?php 
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                } ?>

                <tr>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Subtotal</td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
                </tr>

                <?php 

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
            } ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
            </tr>

             <?php 

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else { ?>

           <?php 
            $no = 1;
            $grandtotalcount = 0; $aging = 0;
                foreach($dlist as $row) {
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    } ?>

                    <tr>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'].' - '.$row['action_plan'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['status_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['risk_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo '-  '.$row['rating_code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $aging ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['remarks'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['audit_staff'] ?></td>
                    </tr>

                    <?php 
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'left'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                } ?>

                <tr>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold">Total # of Action Plans</td>
                    <td style="text-align: right; font-size: 12px; color: black;font-weight: bold"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
                </tr>

                <?php 

                $result[] = array();
                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           }  


?>
