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
            <?php if ($reporttype == 1 || $reporttype == 2 || $reporttype == 3 || $reporttype == 4) { ?>
            <th width="3%">#</th>
            <th width="3%">Code</th>
            <th width="25%">Action Plan</th>
            <th width="5%">Person1</th>
            <th width="5%">Dept</th>
            <th width="5%">Person2</th>
            <th width="5%">Dept2</th>
            <th width="10%">Assigned Audit</th>
            <th width="5%">Project</th>
            <th width="5%">Status</th>      
            <th width="6%">Date Tagged as Implemented</th>
            <th width="6%">Data Entered</th> 
            <th width="6%">Due Date</th> 
            <th width="7%">Date Implemented</th>
            <th width="7%">Date Revised</th>
            <th width="7%">90Days</th>
            <th width="7%">180Days</th>
            <th width="7%">360Days</th>
            <th width="8%">1080Days</th>
            <th width="8%">Over1080Days</th>
            <th width="6%">Total</th>
            <?php }   ?>
               
  </tr>
</thead>


<?php 
    if ($reporttype == 1 ) {
    	$no = 1;
        $day90 = 0; $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal90 = 0; $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
            foreach ($dlist as $row) {

                $datetoday = new DateTime($datefrom_as);
                $duedate = new DateTime($row['ap_due_date']);
                $diff = date_diff($datetoday, $duedate);
                #print_r2($diff); exit;

                if ($diff->days >= 0 && $diff->days <= 90) {
                    $day90 =+1;
                    $total90 += $day90;
                } else {
                    $day90 = null;
                }

                if ($diff->days >= 91 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }



            $grandtotal90 += $day90; $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            ?>

				<tr>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $no ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['action_plan'] ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $row['person2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['audit_staff_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['status_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_tag'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_implemented'] ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_revised'] ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day90 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day180 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day360 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1080 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1081 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"></td>
				</tr>

            <?php 

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'right'),
                        array("text" => $row['entered_date'], 'align' => 'right'),
                        array("text" => $row['ap_due_date'], 'align' => 'right'),
                        array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                        array("text" => $day90, 'align' => 'right'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       ); ?>

            <?php 

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }
            ?>

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
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Grandtotal</td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal90, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal180, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal360, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1080, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1081, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
				</tr>


            <?php 
            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );
			?>

			<?php 

    } else if ($reporttype == 2) {
        $no = 1;
        $day90 = 0; $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal90 = 0; $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($dlist as $dept => $datarow) { ?>

        <tr>
            <td style="text-align: left; font-size: 12px; color: black"><?php echo $dept ?></td>
        </tr>

        <?php 
            $result[] = array(array('text' => $dept, 'align' => 'left', 'bold' => true, 'size' => 10)); ?>

            <?php 
            $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                if ($diff->days >= 0 && $diff->days <= 90) {
                    $day90 =+1;
                    $total90 += $day90;
                } else {
                    $day90 = null;
                }

                if ($diff->days >= 91 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal90 += $day90; $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;
            ?>

				<tr>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $no ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
					<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['action_plan'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                    <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['person2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name2'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['audit_staff_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['status_name'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_tag'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_implemented'] ?></td>
                    <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_revised'] ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day90 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day180 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day360 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1080 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1081 ?></td>
					<td style="text-align: center; font-size: 12px; color: black"></td>
				</tr>

            <?php
            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'right'),
                        array("text" => $row['entered_date'], 'align' => 'right'),
                        array("text" => $row['ap_due_date'], 'align' => 'right'),
                        array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                        array("text" => $day90, 'align' => 'right'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            ?>

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
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Subtotal</td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total90, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total180, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total360, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1080, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1081, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
				</tr>

            <?php
            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right'),
                        array('text' => number_format($total90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }
        ?>

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
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
				<td style="text-align: left; font-size: 12px; color: black"></td>
				<td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Grandtotal</td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal90, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal180, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal360, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1080, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1081, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
			</tr>

        <?php

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right'),
                        array('text' => number_format($grandtotal90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      ); 
	?>

	<?php

    } else if ($reporttype == 3) {
        $no = 1;
        $day90 = 0; $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal90 = 0; $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($dlist as $ap_project => $datarow) { ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"><?php echo $ap_project ?></td>
            </tr>

        <?php 
            $result[] = array(array('text' => $ap_project, 'align' => 'left', 'bold' => true, 'size' => 10));
            ?>

            <?php
            $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                if ($diff->days >= 0 && $diff->days <= 90) {
                    $day90 =+1;
                    $total90 += $day90;
                } else {
                    $day90 = null;
                }

                if ($diff->days >= 91 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal90 += $day90; $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;
            ?>

                    <tr>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $no ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['action_plan'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['person2'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name2'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['audit_staff_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['status_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_tag'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_implemented'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_revised'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $day90 ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $day180 ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $day360 ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $day1080 ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $day1081 ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"></td>
                    </tr>

            <?php
            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'], 'align' => 'left'),
                        array("text" => $row['action_plan'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'right'),
                        array("text" => $row['entered_date'], 'align' => 'right'),
                        array("text" => $row['ap_due_date'], 'align' => 'right'),
                        array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                        array("text" => $day90, 'align' => 'right'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }
            ?>

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
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Subtotal</td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total90, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total180, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total360, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1080, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1081, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
                    </tr>

            <?php 
            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right'),
                        array('text' => number_format($total90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }
        ?>

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
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: left; font-size: 12px; color: black"></td>
                        <td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Grandtotal</td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal90, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal180, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal360, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1080, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1081, 2, '.', ',')  ?></td>
                        <td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
                    </tr>


        <?php

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right'),
                        array('text' => number_format($grandtotal90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

       ?> 
       <?php

    } else {
        $no = 1;
        $day90 = 0; $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal90 = 0; $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($dlist as $company_code => $datarow) { ?>

            <tr>
                <td style="text-align: left; font-size: 12px; color: black"><?php echo $company_code ?></td>
            </tr>

            $result[] = array(array('text' => 'COMPANY'.' - '.$company_code, 'align' => 'left', 'bold' => true, 'size' => 10)); ?>

            <?php
                $total90 = 0; $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                if ($diff->days >= 0 && $diff->days <= 90) {
                    $day90 =+1;
                    $total90 += $day90;
                } else {
                    $day90 = null;
                }

                if ($diff->days >= 91 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal90 += $day90; $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;
            ?>

					<tr>
						<td style="text-align: left; font-size: 12px; color: black"><?php echo $no ?></td>
						<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['code'] ?></td>
						<td style="text-align: left; font-size: 12px; color: black"><?php echo $row['action_plan'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['person'] ?></td>
                        <td style="text-align: left; font-size: 12px; color: black"><?php echo $row['dept_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['person2'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['dept_name2'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['audit_staff_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['project_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['status_name'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_tag'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['entered_date'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_due_date'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_implemented'] ?></td>
                        <td style="text-align: center; font-size: 12px; color: black"><?php echo $row['ap_date_revised'] ?></td>
						<td style="text-align: center; font-size: 12px; color: black"><?php echo $day90 ?></td>
						<td style="text-align: center; font-size: 12px; color: black"><?php echo $day180 ?></td>
						<td style="text-align: center; font-size: 12px; color: black"><?php echo $day360 ?></td>
						<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1080 ?></td>
						<td style="text-align: center; font-size: 12px; color: black"><?php echo $day1081 ?></td>
						<td style="text-align: center; font-size: 12px; color: black"></td>
					</tr>


            <?php
            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'right'),
                        array("text" => $row['entered_date'], 'align' => 'right'),
                        array("text" => $row['ap_due_date'], 'align' => 'right'),
                        array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                        array("text" => $day90, 'align' => 'right'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            ?>


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
                    <td style="text-align: left; font-size: 12px; color: black"></td>
                    <td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: left; font-size: 12px; color: black"></td>
					<td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Subtotal</td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total90, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total180, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total360, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1080, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($total1081, 2, '.', ',')  ?></td>
					<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($subtotal, 2, '.', ',')  ?></td>
				</tr>

            <?php
            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right'),
                        array('text' => number_format($total90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true));

            $result[] = array();

        }
        ?>

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
                <td style="text-align: left; font-size: 12px; color: black"></td>
                <td style="text-align: left; font-size: 12px; color: black"></td>
				<td style="text-align: left; font-size: 12px; color: black"></td>
				<td style="text-align: right; font-size: 12px; color: black;font-weight: bold;">Grandtotal</td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal90, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal180, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal360, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1080, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotal1081, 2, '.', ',')  ?></td>
				<td style="text-align: center; font-size: 12px; color: black;font-weight: bold;"><?php echo number_format($grandtotalcount, 2, '.', ',')  ?></td>
			</tr>

        <?php

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right'),
                        array('text' => number_format($grandtotal90, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    }


?>
