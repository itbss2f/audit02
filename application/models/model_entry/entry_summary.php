<?php

class Entry_summary extends CI_Model {

    public function getSummaryOfActionPlanReports($datefrom_as, $newdate, $reporttype, $status, $dept, $project_name, $user_company) {
        /*Summary of Action Plan*/

        //Due for Implementation
        if ($reporttype == 1 && $status == 1) {

          $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = "";

          if ($status != 0) {
          $constatus = "AND a.ap_status = '$status'";
          }

          if ($dept != 0) {
          $condept = "AND a.ap_dept = $dept";
          }
          if ($project_name != 0) {
          $conproject_name = "AND a.ap_project_id = $project_name";
          }
          if ($user_company != 0) {
          $concompany = "AND a.company = '$user_company'";
          }

            //Due For Implementation
          $stmt = "SELECT 
                    COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- DISTINCT(IF(a.prev_status IS NULL || a.prev_status =2, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning,
                    -- SUM(DATE(a.entered_date) > '2018-07-01' AND DATE(a.entered_date) <= '2018-07-31') AS newproj,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (1) AND a.prev_status IS NULL  
                    AND a.trans_dateto = '$datefrom_as' 
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    COUNT(DISTINCT(a.code), a.code) AS beginning0, 'beginning0' AS stat,
                    -- DISTINCT(IF(a.prev_status IS NULL || a.prev_status =2, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning,
                    -- SUM(DATE(a.entered_date) > '2018-07-01' AND DATE(a.entered_date) <= '2018-07-31') AS newproj,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (1) AND a.prev_status IS NULL  
                    -- AND a.trans_dateto = '$datefrom_as'  
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$newdate' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1, 2, 3, 4, 8) 
                    AND a.company = '$user_company' AND a.prev_status IS NULL $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 5 AND a.ap_status = 1, '1', '0')) AS fromacceptedrisk, 'fromacceptedrisk' AS stat,
                    -- SUM(DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS fromacceptedrisk, 'fromacceptedrisk' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION 
                    SELECT 
                    SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp, 'imp' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (2)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit, 'limit' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit, 'limit' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    AND a.prev_status = 3 AND a.ap_status = 3
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 1 AND a.ap_status = 5, '1', '0')) AS toacceptedrisk, 'toacceptedrisk' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (5)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (8)
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company' 
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    COUNT(DISTINCT(a.code), a.code) AS beginning2, 'beginning2' AS stat,
                    -- COUNT(DISTINCT(DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '1','0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (1) 
                    -- AND a.prev_status IS NULL 
                    AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj2, 'newproj2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1, 2, 3, 4, 8) 
                    AND a.company = '$user_company' AND a.prev_status IS NULL $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj22, 'newproj22' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (1, 2, 3, 5, 8) 
                    AND a.company = '$user_company' AND a.prev_status = '1' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 4 AND a.ap_status = 1
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION 
                    SELECT 
                    SUM(DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS fromacceptedrisk2, 'fromacceptedrisk2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = '5' AND a.ap_status = '1'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_imp, 'imp2' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp, 'imp2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 1 AND a.ap_status = 2
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit2, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 1 AND a.ap_status = 3
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit2, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 1 AND a.ap_status = 3
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS toacceptedrisk2, 'toacceptedrisk2' AS stat,
                    -- SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 1 AND a.ap_status = 5
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tocancelled2, 'tocancelled2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled2, 'tocancelled2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 1 AND a.ap_status = 8
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company' 
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

               #echo "<pre>"; echo $stmt; exit;
               $result = $this->db->query($stmt)->result_array();
               return $result;
          }    

        //Implementation
        elseif ($reporttype == 1 && $status == 2) {

          $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = "";

          if ($status != 0) {
           $constatus = "AND a.ap_status = '$status'";
          }
          if ($dept != 0) {
           $condept = "AND a.ap_dept = $dept";
          }
          if ($project_name != 0) {
           $conproject_name = "AND a.ap_project_id = $project_name";
          }
          if ($user_company != 0) {
           $concompany = "AND a.company = '$user_company'";
          }

          $stmt = "SELECT 
                    SUM(IF (a.ap_status = 2 AND a.prev_status IS NULL, DATE(a.entered_date) <= '2017-10-01', '0')) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '2018-09-30') AS newproj,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '2018-09-30', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01' AND a.is_deleted = '0' 
                    -- AND a.ap_status = 2 AND a.prev_status IS NULL
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '2018-09-30') AS newproj,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '2018-09-30', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$newdate' AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    AND a.ap_status IN ('2') AND a.prev_status IS NULL    
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 4, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT
                    SUM(IF (a.prev_status = 5 AND a.ap_status = 2, '1', '0')) AS fromacceptedrisk, 'fromacceptedrisk' AS stat,
                    -- SUM(IF (a.prev_status = 4, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$newdate'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.ap_status = '2'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept, a.code
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 3 AND a.ap_status = 2
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
                    -- SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit, 'limit' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.is_approved NOT IN ('1','3') 
                    AND a.ap_status IN (2)
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.ap_status = 2 AND a.prev_status IS NULL,DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '0')) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning2, 'beginning2' AS stat,
                    a.entered_date, a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status = '2' AND a.prev_status IS NULL 
                    AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj2, 'newproj2' AS stat,
                    a.entered_date, a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3')  
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    AND a.ap_status = '2' AND a.prev_status IS NULL
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                    -- DATE(a.prev_date) <= '$newdate'
                    AND a.prev_status = 4 AND a.ap_status = 2
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    -- AND a.ap_status IN (1)
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT
                    SUM(IF (a.prev_status = 5 AND a.ap_status = 2, '1', '0')) AS fromacceptedrisk2, 'fromacceptedrisk2' AS stat,
                    -- SUM(IF (a.prev_status = 4, '1', '0')) AS nyd, 'nyd' AS stat,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                    -- DATE(a.prev_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS dueforimp2, 'dueforimp2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                    -- DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.ap_status = '2' AND a.prev_status = '1'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept, a.code
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.prev_status = 3 AND a.ap_status = 2
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.entered_date,a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.ap_status = 2
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

               #echo "<pre>"; echo $stmt; exit;
               $result = $this->db->query($stmt)->result_array();
               return $result;
          

          } 

        //With Limitations
        elseif ($reporttype == 1 && $status == 3) {

          $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

          if ($status != 0) {
           $constatus = "AND a.ap_status = '$status'";
          }
          if ($dept != 0) {
           $condept = "AND a.ap_dept = $dept";
          }
          if ($project_name != 0) {
           $conproject_name = "AND a.ap_project_id = $project_name";
          }
          if ($user_company != 0) {
           $concompany = "AND a.company = '$user_company'";
          }

          $stmt = "SELECT 
                    COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '$datefrom_as', '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 , IFNULL(DATE(a.ap_date_tag) <= '$datefrom_as', '0'), '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '$datefrom_as', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' AND a.prev_status IS NULL  $constatus $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-07-31', '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 , IFNULL(DATE(a.ap_date_tag) <= '2018-07-31', '0'), '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4 , DATE(a.edited_d) <= '2018-07-31', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.prev_status IS NULL 
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj, 'newproj' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.prev_status IS NULL $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    AND a.prev_status = 3 AND a.prev_status = '1'   
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd, 'nyd' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company' AND a.prev_status = 3
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 2,'1', '0')) AS to_imp, 'to_imp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company' AND a.prev_status = 3
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 1,'1', '0')) AS to_dueforimp, 'to_dueforimp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company' AND a.prev_status = 3
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status IS NULL AND a.ap_status = 3, '1', '0')) AS beginning2,  'beginning2' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning2, 'beginning2' AS stat,
                    -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '$datefrom_as', '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 , IFNULL(DATE(a.ap_date_tag) <= '$datefrom_as', '0'), '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '$datefrom_as', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' $condept $conproject_name
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status IS NULL AND a.ap_status = 3, '1', '0')) AS beginning2,  'beginning2' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning2, 'beginning2' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj,
                    -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-07-31', '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 , IFNULL(DATE(a.ap_date_tag) <= '2018-07-31', '0'), '0')) AS dueforimp,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4 , DATE(a.edited_d) <= '2018-07-31', '0')) AS nyd, 
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status IS NULL AND a.ap_status = 3, '1', '0')) AS newproj2,  'newproj2' AS stat,
                    -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj2, 'newproj2' AS stat,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp2, 'dueforimp2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3, '1', '0')) AS dueforimp2, 'dueforimp2' AS stat,
                    -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                    -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    AND a.prev_status = 3
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled2, 'tocancelled2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 2,'1', '0')) AS to_imp2, 'to_imp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company' 
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 1,'1', '0')) AS to_dueforimp2, 'to_dueforimp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

               #echo "<pre>"; echo $stmt; exit;
               $result = $this->db->query($stmt)->result_array();
               return $result;
          } 

        //NYD
        elseif ($reporttype == 1 && $status == 4) {
            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

            if ($status != 0) {
                $constatus = "AND a.ap_status = '$status'";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }
            if ($user_company != 0) {
                $concompany = "AND a.company = '$user_company'";
            }

            $stmt = "SELECT
                    SUM(IF(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '1', '0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.ap_status = '1' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '1'   
                    AND c.company = '1'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND a.trans_dateto = '$datefrom_as'
                    AND a.ap_status = 1 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    /*SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL AND a.ap_status = 4, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND a.ap_status = 1  
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS beginning, 'beginning' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND a.trans_dateto = '$datefrom_as'
                    AND a.ap_status = 1 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept*/
                    UNION
                    SELECT 
                    SUM(IF(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '1', '0')) AS to_newproj, 'to_newproj' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS to_newproj, 'to_newproj' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE a.ap_status = '4' 
                    AND a.prev_status IS NULL
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name    
                    AND c.company = '$user_company'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as', '1', '0')) AS to_dueforimplement2, 'to_dueforimplement2' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '2017-10-01' AND DATE(a.prev_date) <= '$datefrom_as'
                    AND a.ap_status = '1' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS to_imp, 'imp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.ap_status = '2' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 3,'1', '0')) AS tolimit, 'tolimit' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.ap_status = '3' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 5,'1', '0')) AS toacceptedrisk, 'toacceptedrisk' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as'  
                    AND a.ap_status = '5' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.ap_status = '8' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL AND a.ap_status = 4, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND a.ap_status = 1  
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND a.trans_dateto = '$datefrom_as'
                    AND a.ap_status = 1 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status IS NULL AND a.ap_status = 4,'1', '0')) AS to_newproj2, 'to_newproj2' AS stat,
                    -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_newproj2, 'to_newproj2' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    -- AND a.ap_status = '1' 
                    -- AND a.prev_status IS NULL
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name    
                    AND c.company = '$user_company'
                    GROUP BY a.code 
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4,'1', '0')) AS to_newproj2, 'to_newproj2' AS stat,
                    -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_newproj2, 'to_newproj2' AS stat,
                    -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    -- AND a.ap_status = '1' 
                    -- AND a.prev_status IS NULL
                    AND a.ap_status = '1'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name    
                    AND c.company = '$user_company'
                    GROUP BY a.code AND a.ap_dept, a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as', '1', '0')) AS to_dueforimplement2, 'to_dueforimplement2' AS stat,
                    -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) > '2017-10-01' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.ap_status = '1' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS to_imp2, 'imp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.ap_status = '2' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 3,'1', '0')) AS tolimit2, 'tolimit2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.ap_status = '3' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 5,'1', '0')) AS toacceptedrisk2, 'toacceptedrisk2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    AND a.ap_status = '5' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 4 AND a.ap_status = 8,'1', '0')) AS tocancelled2, 'tocancelled2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    AND a.ap_status = '8' AND a.prev_status = '4'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();
            return $result;
          } 

        //Accepted Risk
        elseif ($reporttype == 1 && $status == 5) {
          $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

          if ($status != 0) {
           $constatus = "AND a.ap_status = '$status'";
          }
          if ($dept != 0) {
           $condept = "AND a.ap_dept = $dept";
          }
          if ($project_name != 0) {
           $conproject_name = "AND a.ap_project_id = $project_name";
          }
          if ($user_company != 0) {
           $concompany = "AND a.company = '$user_company'";
          }

          $stmt = "SELECT 
                    SUM(IF (a.ap_status = 5 and a.prev_status IS NULL, DATE(a.entered_date) <= '2017-10-01', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL AND a.ap_status = 5, '1', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.ap_status = 5 and a.prev_status IS NULL, DATE(a.entered_date) <= '2017-10-01', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL AND a.ap_status = 5, '1', '0')) AS beginning, 'beginning' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '2017-10-01' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.trans_dateto = '$datefrom_as'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.ap_status = '5',DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS newproj, 'newproj' AS stat, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= 'newdate' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' 
                    AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = '5',DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS newproj, 'newproj' AS stat, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= 'newdate'  
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' 
                    -- AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 1, DATE(a.prev_date) <= '$newdate', '0')) AS fromdueforimp,  'fromdueforimp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept, a.code
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4, DATE(a.prev_date) <= '$newdate', '0')) AS fromnyd,  'fromnyd' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 5, DATE(a.prev_date) <= '$newdate', '0')) AS to_imp, 'to_imp' AS stat,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '$datefrom_as', '0')) AS nyd, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '2'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 5, DATE(a.prev_date) <= '$newdate', '0')) AS to_dueforimp, 'to_dueforimp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) <= '$newdate' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '1'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status is NULL AND a.ap_status = 5, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status is NULL AND a.ap_status = 5, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '0')) AS beginning2, 'beginning2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5' AND a.trans_dateto = '$datefrom_as'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.ap_status = '5', DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '0')) AS newproj2, 'newproj2' AS stat, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' 
                    AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = '5',DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '0')) AS newproj2, 'newproj2' AS stat, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' 
                    -- AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 1, DATE(a.prev_date) <= '$datefrom_as', '0')) AS fromdueforimp2,  'fromdueforimp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept, a.code
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4, DATE(a.prev_date) <= '$datefrom_as', '0')) AS fromnyd2,  'fromnyd2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '5'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 5, DATE(a.prev_date) <= '$datefrom_as', '0')) AS to_imp2, 'to_imp2' AS stat,
                    -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '$datefrom_as', '0')) AS nyd, 
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '2'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 5, DATE(a.prev_date) <= '$datefrom_as', '0')) AS to_dueforimp2, 'to_dueforimp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                    AND a.is_deleted = '0'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND a.ap_status = '1'
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

               #echo "<pre>"; echo $stmt; exit;
               $result = $this->db->query($stmt)->result_array();

          return $result;
        } 

        //Cancelled
        elseif ($reporttype == 1 && $status == 8) {

            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; $condeleted = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = '$status'";
                }

            // if ($status == 8) {
            //     $condeleted = "AND a.is_deleted = '1'";
            // } else {
            //     $condeleted = "AND a.is_deleted = '0'";
            // }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
                }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
                }
            if ($user_company != 0) {
                $concompany = "AND a.company = '$user_company'";
            }

            $stmt = "SELECT 
                    SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 and a.ap_status = 8, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 8, '1', '0')) AS nyd, 'nyd' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tolimit, 'tolimit' as stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) <= '$datefrom_as'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $constatus $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status IS NULL AND a.ap_status = 8, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning2, 'beginning2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry_history AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.trans_dateto = '$datefrom_as'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status IS NULL AND a.ap_status = 8, '1', '0')) AS beginning2, 'beginning2' AS stat,
                    -- SUM(IF (a.prev_status IS NULL, DATE(a.entered_date) >= '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '0')) AS beginning2, 'beginning2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 1 and a.ap_status = 8, '1', '0')) AS dueforimp2, 'dueforimp2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF (a.prev_status = 4 AND a.ap_status = 8, '1', '0')) AS nyd2, 'nyd2' AS stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    UNION
                    SELECT 
                    SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tolimit2, 'tolimit2' as stat,
                    a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    DATE(a.entered_date) AS entered_date,
                    DATE(a.ap_due_date) AS ap_due_date,
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_revised) AS ap_date_revised,  
                    bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name,
                    a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted,a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                    AND a.company = '$user_company' $condept $conproject_name 
                    AND c.company = '$user_company'
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();
            return $result;
        } 
    }

    public function getSummaryOfActionPlanReports2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company) {
        /*Summary of Action Plan*/

        if ($reporttype == 1) {

            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = "";

            if ($status != "") {
                $constatus = "AND a.ap_status = '$status'";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }
            if ($user_company != 0) {
                $concompany = "AND a.company = '$user_company'";
            }

            $stmt = "SELECT COUNT(a.id) AS total,a.ap_status,a.prev_status ,a.prev_date,dept.name AS dept_name,b.code AS company_code, b.name AS comp_name,
        		    DATE(a.ap_date_tag) AS ap_date_tag,
        		    DATE(a.entered_date) AS entered_date, a.action_plan,
                    DATE(a.ap_due_date) AS due_date,DATE(a.ap_date_implemented) AS date_implemented,
                    DATE(a.ap_date_revised) AS date_revised, bc.risk1, bc.risk2, bc.risk3, bc.risk_rating, d.description AS risk_description,
                    a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name, a.ap_assigned_audit, bc.remarks, a.ap_dept,w.description AS status_name,
                    w.status_code AS status_code, e.description AS issue_name,dept.code AS dept_code, a.ap_status,a.is_deleted, a.is_duplicate, bc.is_duplicate
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    WHERE DATE(a.ap_due_date) >= '$datefrom' AND DATE(a.ap_due_date) <= '$dateto'
                    AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                    AND a.company = '$user_company' AND c.company = '$user_company' $constatus $condept $conproject_name
                    GROUP BY a.ap_dept
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            return $result;
        }
    }

}
