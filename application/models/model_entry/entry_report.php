<?php

class Entry_report extends CI_Model {

    public function getStatusOfActionPlanReportperdepartment($datefrom_as,$newdate, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company, $recur) {

        if ($status == 1) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_dateto = '$datefrom_as'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning0, 'beginning0' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj, 'newproj' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                AND a.ap_status IN (1, 2, 3, 5, 8)
                AND a.company = '$user_company' AND a.prev_status IS NULL $constatus $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS nyd, 'nyd' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                SUM(DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS fromacceptedrisk, 'fromacceptedrisk' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS w ON w.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE a.prev_status = '1' AND a.ap_status = '5'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                -- AND a.ap_status IN (1)
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_imp, 'imp' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS toacceptedrisk, 'toacceptedrisk' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tocancelled, 'tocancelled' AS stat,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tocancelled, 'tocancelled' AS stat,
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
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
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

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }

        else if ($status == 2) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$newdate'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj, 'newproj' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3')  
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                AND a.ap_status = '2' AND a.prev_status IS NULL
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS nyd, 'nyd' AS stat,
                -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS nyd2, 'nyd2' AS stat,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd2, 'nyd2' AS stat,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 1, '1', '0')) AS nyd, 'nyd' AS stat,
                -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
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
                SUM(IF (a.prev_status = 5 AND a.ap_status = 2, '1', '0')) AS fromacceptedrisk, 'fromacceptedrisk' AS stat,
                -- SUM(IF (a.prev_status = 4, '1', '0')) AS nyd, 'nyd' AS stat,
                -- SUM(IF (a.prev_status = 1, DATE(a.ap_date_tag) <= '2018-09-30', '0')) AS dueforimp,
                -- SUM(IF (a.prev_status = 1, DATE(a.entered_date) <= '2018-09-30', '0')) AS dueforimp,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as'
                -- DATE(a.prev_date) <= '$datefrom_as'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
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
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE a.prev_status = 3 AND a.ap_status = 2
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS tolimit, 'limit' AS stat,
                -- SUM(IF(a.prev_status = 3, '1', '0')) AS tolimit2, 'limit2' AS stat,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE a.ap_status = 2
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                ORDER BY dept_name ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }

        else if ($status == 3) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                SUM(IF(a.ap_status = '3', DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat, 
                -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.prev_status IS NULL
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$newdate'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.ap_status = '3', DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status IS NULL AND a.ap_status = 3, '1', '0')) AS newproj,  'newproj' AS stat,
                -- SUM(DATE(a.entered_date) > '$newdate' AND DATE(a.entered_date) <= '$datefrom_as') AS newproj2, 'newproj2' AS stat,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                -- SUM(IF(a.prev_status = 1 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 1 AND a.ap_status = 3, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 3, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                -- SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd,
                -- SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                AND a.prev_status = 3 AND a.prev_status = '1'   
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.prev_status = 4 AND a.ap_status = 3, '1', '0')) AS nyd, 'nyd' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 3 AND a.ap_status = 2,'1', '0')) AS to_imp, 'to_imp' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company' 
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 3 AND a.ap_status = 1,'1', '0')) AS to_dueforimp2, 'to_dueforimp2' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                e.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                ORDER BY dept_name ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }

        else if ($status == 4) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                SUM(IF(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate', '1', '0')) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) > '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.ap_status = '1' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '1'   
                AND c.company = '1'
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.ap_status = 4, '1', '0')) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                /*SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$newdate'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.ap_status = 4, '1', '0')) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept*/
                UNION
                SELECT 
                SUM(IF(a.prev_status IS NULL AND a.ap_status = 4,'1', '0')) AS to_newproj, 'to_newproj' AS stat,
                -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_newproj2, 'to_newproj2' AS stat,
                -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
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
                SUM(IF(a.prev_status = '4' ,'1', '0')) AS to_newproj, 'to_newproj' AS stat,
                -- SUM(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as') AS to_newproj2, 'to_newproj2' AS stat,
                -- SUM(DATE(a.entered_date) > '2017-10-01' AND DATE(a.entered_date) <= '$newdate') AS newproj, 'newproj' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                -- AND a.ap_status = '1' 
                -- AND a.prev_status IS NULL
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name    
                AND c.company = '$user_company'
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as', '1', '0')) AS to_dueforimplement, 'to_dueforimplement' AS stat,
                -- SUM(IF (a.prev_status = 1 AND a.ap_status = 2, '1', '0')) AS to_imp,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) > '2017-10-01' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.ap_status = '1' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.code
                UNION
                SELECT 
                SUM(IF (a.prev_status = 4 AND a.ap_status = 2, '1', '0')) AS to_imp, 'imp' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.ap_status = '2' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 4 AND a.ap_status = 3,'1', '0')) AS tolimit, 'tolimit' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.ap_status = '3' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 4 AND a.ap_status = 5,'1', '0')) AS toacceptedrisk, 'toacceptedrisk' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                AND a.ap_status = '5' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 4 AND a.ap_status = 8,'1', '0')) AS tocancelled, 'tocancelled' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'  
                AND a.ap_status = '8' AND a.prev_status = '4'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' AND a.is_approved NOT IN ('1','3') 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                ORDER BY dept_name ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }

        else if ($status == 5) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                SUM(IF (a.ap_status = 5 AND a.prev_status IS NULL, DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$newdate'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.ap_status = 5 AND a.prev_status IS NULL, DATE(a.entered_date) <= '$newdate', '0')) AS beginning, 'beginning' AS stat,
                -- COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.ap_status = '5', DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as', '0')) AS newproj, 'newproj' AS stat, 
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' 
                AND c.company = '$user_company'
                -- DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = '5',DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as', '0')) AS newproj, 'newproj' AS stat, 
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' 
                AND c.company = '$user_company'
                -- DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.prev_status = 1, DATE(a.prev_date) <= '$datefrom_as', '0')) AS fromdueforimp,  'fromdueforimp' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND a.ap_status = '5'
                AND c.company = '$user_company'
                GROUP BY a.ap_dept, a.code
                UNION
                SELECT 
                SUM(IF (a.prev_status = 4, DATE(a.prev_date) <= '$datefrom_as', '0')) AS fromnyd,  'fromnyd' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND a.ap_status = '5'
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 5, DATE(a.prev_date) <= '$datefrom_as', '0')) AS to_imp, 'to_imp' AS stat,
                -- SUM(IF (a.prev_status = 4, DATE(a.edited_d) <= '$datefrom_as', '0')) AS nyd, 
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND a.ap_status = '2'
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.prev_status = 5, DATE(a.prev_date) <= '$datefrom_as', '0')) AS to_dueforimp, 'to_dueforimp' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.prev_date) >= '$newdate' AND DATE(a.prev_date) <= '$datefrom_as' 
                AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND a.ap_status = '1'
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                ORDER BY dept_name ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }

        else if ($status == 8) {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$newdate'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                COUNT(DISTINCT(a.code), a.code) AS beginning, 'beginning' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$newdate' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name
                GROUP BY a.code AND a.ap_dept, a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 1 and a.ap_status = 8, '1', '0')) AS dueforimp, 'dueforimp' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF (a.prev_status = 4 AND a.ap_status = 8, '1', '0')) AS nyd, 'nyd' AS stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                UNION
                SELECT 
                SUM(IF(a.prev_status = 3 AND a.ap_status = 8,'1', '0')) AS tolimit, 'tolimit' as stat,
                a.code,a.action_plan,a.ap_status,a.prev_status, a.prev_date,dept.name AS dept_name,bb.code AS company_code, 
                bb.name AS comp_name,
                DATE(a.ap_date_tag) AS ap_date_tag,
                DATE(a.entered_date) AS entered_date,
                DATE(a.ap_due_date) AS ap_due_date,
                DATE(a.ap_date_implemented) AS ap_date_implemented,
                DATE(a.ap_date_revised) AS ap_date_revised, 
                bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                d.description AS risk_description, a.ap_emp, a.ap_emp_2, a.ap_project_id,
                a.ap_assigned_audit, bc.remarks, a.ap_dept,stat.description AS status_name,stat.status_code AS status_code,
                b.description AS issue_name,dept.code AS dept_code,a.is_deleted, a.is_duplicate
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN hr_companies AS bb ON bb.id = a.company
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) >= '$newdate' AND DATE(a.entered_date) <= '$datefrom_as' 
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' $condept $conproject_name 
                AND c.company = '$user_company'
                GROUP BY a.ap_dept
                ORDER BY dept_name ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;

        }
    }

    public function getReportByStatus($datefrom_as, $reporttype, $dept, $project_name, $report_period, $user_company) {
        /*Aging of Action Plan Reports*/

        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.bc_code,a.ap_emp,
                    CONCAT(emp.last_name,' , ', emp.first_name,' ',' ',SUBSTR(emp.middle_name,1,1),'. ') AS person, a.ap_emp_2,
                    CONCAT(emp2.last_name,' , ', emp2.first_name,' ',' ',SUBSTR(emp2.middle_name,1,1),'. ') AS person2,
                    a.ap_dept,dept.name AS dept_name,a.ap_dept_2,dept2.name AS dept_name2, a.ap_project_id, proj.description AS project_name,
                    DATE(a.entered_date) AS entered_date, 
                    DATE(a.ap_due_date) AS ap_due_date, 
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_tag) AS ap_date_tag, 
                    a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff_name,a.ap_impact_remarks,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp  
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = a.ap_emp_2  
                    WHERE DATE(a.entered_date) <= '$datefrom_as' AND stat.status_code IN ('D')
                    AND a.company = '$user_company' AND proj.company = '$user_company' AND a.bc_code IS NOT NULL 
                    AND b.is_approved = '0' AND a.is_approved = '0' 
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0' $condept $conproject_name
                    GROUP BY a.id
                    ORDER BY a.entered_date ASC";

                    #echo "<pre>"; echo $stmt; exit;
                    $result = $this->db->query($stmt)->result_array();

                return $result;
        }  

        else if ($reporttype == 2) {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.bc_code,a.ap_emp,
                    CONCAT(emp.last_name,' , ', emp.first_name,' ',' ',SUBSTR(emp.middle_name,1,1),'. ') AS person, a.ap_emp_2,
                    CONCAT(emp2.last_name,' , ', emp2.first_name,' ',' ',SUBSTR(emp2.middle_name,1,1),'. ') AS person2,
                    a.ap_dept,dept.name AS dept_name,a.ap_dept_2,dept2.name AS dept_name2, a.ap_project_id, proj.description AS project_name,
                    DATE(a.entered_date) AS entered_date, 
                    DATE(a.ap_due_date) AS ap_due_date, 
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_tag) AS ap_date_tag, 
                    a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff_name,a.ap_impact_remarks,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp  
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = a.ap_emp_2  
                    WHERE DATE(a.entered_date) <= '$datefrom_as' AND stat.status_code IN ('D')
                    AND a.company = '$user_company' AND proj.company = '$user_company' AND a.bc_code IS NOT NULL 
                    AND b.is_approved = '0' AND a.is_approved = '0'
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0' $condept $conproject_name
                    GROUP BY a.id
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['dept_name']][] = $row;
            }

            return $newresult;
        } 

        else if ($reporttype == 3)  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.bc_code,a.ap_emp,
                    CONCAT(emp.last_name,' , ', emp.first_name,' ',' ',SUBSTR(emp.middle_name,1,1),'. ') AS person, a.ap_emp_2,
                    CONCAT(emp2.last_name,' , ', emp2.first_name,' ',' ',SUBSTR(emp2.middle_name,1,1),'. ') AS person2,
                    a.ap_dept,dept.name AS dept_name,a.ap_dept_2,dept2.name AS dept_name2, a.ap_project_id, proj.description AS project_name,
                    DATE(a.entered_date) AS entered_date, 
                    DATE(a.ap_due_date) AS ap_due_date, 
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_tag) AS ap_date_tag,
                    a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff_name,a.ap_impact_remarks,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp  
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = a.ap_emp_2  
                    WHERE DATE(a.entered_date) <= '$datefrom_as' AND stat.status_code IN ('D')
                    AND a.company = '$user_company' AND proj.company = '$user_company' AND a.bc_code IS NOT NULL 
                    AND b.is_approved = '0' AND a.is_approved = '0'
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0' $condept $conproject_name
                    GROUP BY a.id
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['project_name']][] = $row;
            }

            return $newresult;
        } 

        else  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.bc_code,a.ap_emp,
                    CONCAT(emp.last_name,' , ', emp.first_name,' ',' ',SUBSTR(emp.middle_name,1,1),'. ') AS person, a.ap_emp_2,
                    CONCAT(emp2.last_name,' , ', emp2.first_name,' ',' ',SUBSTR(emp2.middle_name,1,1),'. ') AS person2,
                    a.ap_dept,dept.name AS dept_name,a.ap_dept_2,dept2.name AS dept_name2, a.ap_project_id, proj.description AS project_name,
                    DATE(a.entered_date) AS entered_date, 
                    DATE(a.ap_due_date) AS ap_due_date, 
                    DATE(a.ap_date_revised) AS ap_date_revised, 
                    DATE(a.ap_date_implemented) AS ap_date_implemented,
                    DATE(a.ap_date_tag) AS ap_date_tag, 
                    a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff_name,a.ap_impact_remarks,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp  
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = a.ap_emp_2
                    WHERE DATE(a.entered_date) <= '$datefrom_as' AND stat.status_code IN ('D')
                    AND a.company = '$user_company' AND proj.company = '$user_company' AND a.bc_code IS NOT NULL 
                    AND b.is_approved = '0' AND a.is_approved = '0'
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0' $condept $conproject_name
                    GROUP BY a.id
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['company_code']][] = $row;
            }
            return $newresult;
        }
    }

    public function getReportByStatus2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company) {
        /*Aging of Action Plan Reports Date from to*/

        if ($reporttype == 1)   {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

                $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.ap_dept,dept.name AS dept_name, a.ap_project_id, proj.description AS project_name,
                        a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, a.ap_assigned_audit AS audit_staff,
                        CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                        a.ap_status, stat.description AS status_name, stat.status_code
                        FROM ap_entry AS a
                        INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                        LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                        LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                        LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                        LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                        LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                        WHERE DATE(a.ap_due_date) <= '$datefrom' AND DATE(a.ap_due_date) <= '$dateto'
                        AND a.company = '$user_company' AND proj.company = '$user_company' 
                        AND a.is_duplicate = '0' AND b.is_duplicate = '0'
                        AND a.bc_code IS NOT NULL AND b.is_approved = '0' $constatus $condept $conproject_name
                        GROUP BY a.bc_code
                        ORDER BY a.entered_date ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();

                return $result;
        }  

        else if ($reporttype == 2)   {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.ap_dept,dept.name AS dept_name, a.ap_project_id, proj.description AS project_name,
                    a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    WHERE DATE(a.ap_due_date) <= '$datefrom' AND DATE(a.ap_due_date) <= '$dateto'
                    AND a.company = '$user_company' AND proj.company = '$user_company' 
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0'
                    AND a.bc_code IS NOT NULL AND b.is_approved = '0' $constatus $condept $conproject_name
                    GROUP BY a.bc_code
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['dept_name']][] = $row;
            }

            return $newresult;
        } 

        else if ($reporttype == 3)  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.ap_dept,dept.name AS dept_name, a.ap_project_id, proj.description AS project_name,
                    a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    WHERE DATE(a.ap_due_date) <= '$datefrom' AND DATE(a.ap_due_date) <= '$dateto'
                    AND a.company = '$user_company' AND proj.company = '$user_company' 
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0'
                    AND a.bc_code IS NOT NULL AND b.is_approved = '0' $constatus $condept $conproject_name
                    GROUP BY a.bc_code
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['status_name']][] = $row;
            }

            return $newresult;
        } 

        else  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,a.ap_dept,dept.name AS dept_name, a.ap_project_id, proj.description AS project_name,
                    a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, a.ap_assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                    a.ap_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    WHERE DATE(a.ap_due_date) <= '$datefrom' AND DATE(a.ap_due_date) <= '$dateto'
                    AND a.company = '$user_company' AND proj.company = '$user_company' 
                    AND a.is_duplicate = '0' AND b.is_duplicate = '0'
                    AND a.bc_code IS NOT NULL AND b.is_approved = '0' $constatus $condept $conproject_name
                    GROUP BY a.bc_code
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['company_code']][] = $row;
            }

            return $newresult;
        }
    }

    public function getStatusOfActionPlanReports($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company, $recur) {
      //Summary Action Plan(Detailed)
        //Status
        if ($reporttype == 1) {
                $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }
            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                --AND a.ap_status IN (1,2) 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                ) AS z
                GROUP BY z.code
                ORDER BY z.code ASC";

            #echo '<pre>'; print_r($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['status_name']][] = $row;
            }

            return $newresult;
        }   
        //Department
        else if ($reporttype == 2)  {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }
            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                -- AND a.ap_status IN (1,2) 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                ) AS z
                GROUP BY z.code
                ORDER BY z.code ASC";

            $result = $this->db->query($stmt)->result_array();
            #echo '<pre>'; print_r($stmt); exit;
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['dept_name']][] = $row;
            }

            return $newresult;
        }
        //Risks
        else if ($reporttype == 3)  {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }
            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                -- AND a.ap_status IN (1,2) 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit AS audit_staff,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                ) AS z
                GROUP BY z.code
                ORDER BY z.code ASC";

            #echo "<pre>" ; echo $stmt ; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['risk_name']][] = $row;
            }

            return $newresult;
        }
        //Issue
        else if ($reporttype == 4)  {

            $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = ""; $conrecur = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }
            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                -- AND a.ap_status IN (1,2) 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit AS audit_staff,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3')    $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                ) AS z
                GROUP BY z.code
                ORDER BY z.code ASC";

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['issue_name']][] = $row;
            }

            return $newresult;
        }
        //Project Name
        else if ($reporttype == 5)  {

            $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = ""; $conrecur = "";

            if ($status != 0) {
                $constatus = "AND a.ap_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }
            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }
            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                -- AND a.ap_status IN (1,2) 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit AS audit_staff,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = '0'
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0'
                AND a.company = '$user_company' 
                AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3')   $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code
                ) AS z
                GROUP BY z.code
                ORDER BY z.code AS";


            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
                $newresult[$row['project_name']][] = $row;
            }

            return $newresult;
        }

        //All
        else {

            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = ""; $conrecur = ""; $condeleted;

            if ($status != 0) {
                if ($status == 1) {
                    $constatus = "AND a.ap_status IN (1)";
                }  else {
                    $constatus = "AND a.ap_status = $status";
                } 
            }

            if ($status == 8) {
                $condeleted = "AND a.is_deleted = '1'";
            } elseif($status != 1 && $status != 0) {
                $condeleted = "AND a.is_deleted = '0'";
            }

            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
            }

            if($risk != 0) {
                $conrisk = "AND bc.risk1 = $risk";
            }

            if($issue != 0) {
                $conissue = "AND bc.issue = $issue";
            }

            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
            }

            if ($recur != 0) {
                $conrecur = "AND bc.recur = $recur";
            }

            $stmt = "SELECT *, z.dept_name
                FROM (
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry_history AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company' AND a.trans_datefrom = '$datefrom'
                AND a.is_approved NOT IN ('1','3')  $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code 
                UNION
                SELECT a.code,a.action_plan,bc.issue, b.code AS issue_code,b.description AS issue_name, a.ap_project_id, c.description AS project_name, bc.risk1, d.description AS risk_name,
                bc.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented, a.ap_emp, assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, bc.remarks, a.ap_status, stat.description AS status_name,
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.ap_dept, dept.name AS dept_name, stat.status_code AS status_code, bc.recur AS recurring
                FROM ap_entry AS a
                INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                INNER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                WHERE DATE(a.entered_date) <= '$datefrom' $condeleted
                AND a.is_duplicate = '0' AND bc.is_duplicate = '0' 
                AND a.company = '$user_company' AND c.company = '$user_company'
                AND a.is_approved NOT IN ('1','3') $constatus $condept $conrisk $conissue $conproject_name $conrecur
                GROUP BY a.code 
                ) AS z
                GROUP BY z.code
                ORDER BY z.code ASC";

            #print_r2($stmt); exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;
        }
    }

    public function getReportByStatusofbusinessconcern($datefrom_as, $reporttype, $dept, $project_name, $report_period, $user_company) {
        /*Aging of Business Reports*/

        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
            }

            $stmt = "SELECT bc.id,bc.bc_code,bc.business_concern,xx.code AS company_code,bc.dept,dept.name AS dept_name,bc.issue,
                    b.description AS issue_name, b.code AS issue_code, bc.project_id, bc.risk1, d.description AS risk_name,bc.risk_rating,
                    rating.description, rating.code AS rating_code, bc.entered_date, bc.due_date, bc.date_revised, bc.date_implemented, 
                    bc.emp, bc.assigned_audit AS audit_staff, CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, 
                    bc.remarks, bc.bc_status,a.action_plan, a.code, stat.description AS status_name, stat.status_code,
                    IF(bc.bc_status = 10,'0','1') AS implement
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code 
                    LEFT OUTER JOIN ap_issue AS b ON b.id = bc.issue
                    LEFT OUTER JOIN ap_risk AS d ON d.id = bc.risk1
                    LEFT OUTER JOIN ap_risk AS d2 ON d.id = bc.risk2
                    LEFT OUTER JOIN ap_risk AS d3 ON d.id = bc.risk3
                    LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = bc.risk_rating
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = bc.assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = bc.company
                    WHERE bc.is_deleted = 0 AND bc.is_approved = '0' AND a.is_approved = '0' $constatus $condept $conproject_name
                    AND stat.status_code IN('O','R') AND DATE(bc.entered_date) <= '$datefrom_as' 
                    AND a.company = '$user_company' AND bc.company = '$user_company'
                    ORDER BY bc.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            return $result;
        }  
        else if ($reporttype == 2) {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND bc.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
            }

            $stmt = "SELECT bc.id, bc.bc_code,bc.business_concern,b.code AS company_code, b.name AS company_name, DATE(bc.entered_date) AS entered_date, 
                    a.action_plan,DATE(bc.due_date) AS due_date,DATE(bc.date_implemented) AS date_implemented, DATE(bc.date_revised) AS date_revised,
                    bc.remarks, bc.dept,bc.bc_status, bc.risk1, bc.risk2, bc.risk3, bc.risk_rating, d.description AS risk_description, bc.emp, 
                    bc.emp2, bc.assigned_audit,stat.description AS status_name,stat.status_code, e.description AS issue_name,dept.name AS dept_name,
                    bc.is_deleted, IF(bc.bc_status = 10,'0','1') AS implement
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code 
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE bc.is_deleted = 0 AND bc.is_approved = '0' AND a.is_approved = '0' $constatus $condept $conproject_name
                    AND stat.status_code IN('O','R') AND DATE(bc.entered_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND a.company = '$user_company'
                    ORDER BY bc.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
            }

            return $newresult;
        } 

        else if ($reporttype == 3)  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND bc.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
            }

            $stmt = "SELECT bc.id, bc.bc_code, bc.business_concern,b.code AS company_code, b.name AS company_name, DATE(bc.entered_date) AS entered_date, a.action_plan,
                    DATE(bc.due_date) AS due_date, DATE(bc.date_implemented) AS date_implemented, DATE(bc.date_revised) AS date_revised,
                    bc.bc_status,bc.risk1, bc.risk2, bc.risk3, bc.risk_rating, d.description AS risk_description, bc.emp, bc.emp2, 
                    bc.assigned_audit, bc.remarks, bc.dept,stat.description AS status_name,stat.status_code, e.description AS issue_name,
                    dept.name AS dept_name, bc.is_deleted, IF(bc.bc_status = 10,'0','1') AS implement
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE bc.is_deleted = 0 AND bc.is_approved = '0' AND a.is_approved = '0' $constatus $condept $conproject_name
                    AND stat.status_code IN('O','R') AND DATE(bc.entered_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND a.company = '$user_company'
                    ORDER BY bc.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
            }

            return $newresult;
        } 

        else  {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND bc.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
            }

            $stmt = "SELECT bc.id, bc.bc_code,bc.business_concern, b.code AS company_code, b.name AS company_name, DATE(bc.entered_date) AS entered_date, a.action_plan, 
                    DATE(bc.due_date) AS due_date, DATE(bc.date_implemented) AS date_implemented, DATE(bc.date_revised) AS date_revised,
                    bc.bc_status,bc.risk1, bc.risk2, bc.risk3, bc.risk_rating, d.description AS risk_description, bc.emp, bc.emp2, bc.assigned_audit,
                    bc.remarks, bc.dept,stat.description AS status_name,stat.status_code, e.description AS issue_name,dept.name AS dept_name, 
                    bc.is_deleted, IF(bc.bc_status = 10,'0','1') AS implement
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS bc ON bc.bc_code = a.bc_code 
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE bc.is_deleted = 0 AND bc.is_approved = '0' AND a.is_approved = '0' $constatus $condept $conproject_name
                    AND stat.status_code IN('O','R') AND DATE(bc.entered_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND a.company = '$user_company'
                    ORDER BY bc.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['company_code']][] = $row;
            }

            return $newresult;
        }
    }

    public function getReportByStatusofbusinessconcern2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company, $report_period) {
        /*Aging of Business Reports*/
        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id,x.code AS company_code,a.dept,dept.name AS dept_name,a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, a.risk1, d.description AS risk_name,
                    a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, stat.status_code
                    FROM ap_entry AS a
                    LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                    LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                    LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    LEFT OUTER JOIN hr_companies AS x ON x.id = a.company
                    WHERE a.is_deleted = 0 AND a.is_approved = '0' AND stat.status_code IN('O','R') 
                    AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();

            return $result;
        }  

        else if ($reporttype == 2) {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan,
                    DATE(a.due_date) AS due_date,DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,
                    a.remarks, a.dept,a.bc_status, a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2, a.assigned_audit,
                    stat.description AS status_name,stat.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.is_approved = '0' AND stat.status_code IN('O','R') 
                    AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
            }

            return $newresult;
        } 

        else if ($reporttype == 3)  {

            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan,
                    DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,
                    a.bc_status,a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2, a.assigned_audit, a.remarks, a.dept,
                    stat.description AS status_name,stat.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.is_approved = '0' AND stat.status_code IN('O','R') 
                    AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
            }

            return $newresult;
        } 

        else  {
            $constatus = ""; $condept = ""; $conproject_name = "";

            if ($status != 0) {
                $constatus = "AND a.bc_status = $status";
            }
            if ($dept != 0) {
                $condept = "AND a.dept = $dept";
            }
            if ($project_name != 0) {
                $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,
                    a.bc_status,a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2, a.assigned_audit, a.remarks, a.dept,
                    stat.description AS status_name,stat.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.is_approved = '0' AND stat.status_code IN('O','R') 
                    AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name $concompany
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['company_code']][] = $row;
            }

            return $newresult;
        }
    }

    /*public function getReportByStatus($datefrom_as, $reporttype, $status, $dept, $project_name, $report_period, $user_company) {

        if ($reporttype == 1) {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id,x.code AS company_code,a.dept,dept.name AS dept_name,a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                    a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                    a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, stat.status_code,CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person
                    FROM ap_entry AS a
                    LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                    LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    LEFT OUTER JOIN hr_companies AS x ON x.id = a.company
                    WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
        return $result;


    }  else if ($reporttype == 2) {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
            }

    return $newresult;

        } else if ($reporttype == 3)  {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
            }

    return $newresult;

        } else  {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' AND a.company = '$user_company'
                    $constatus $condept $conproject_name $concompany
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['company_code']][] = $row;
            }

    return $newresult;
        }
    }

    public function getReportByStatus2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company) {


        if ($reporttype == 1) {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2, a.project_id ,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name, w.status_code, e.description AS issue_name, a.is_deleted,dept.name AS dept_name
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
        return $result;


    }  else if ($reporttype == 2) {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
            }

    return $newresult;

        } else if ($reporttype == 3)  {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
            }

    return $newresult;

        } else  {
        $constatus = ""; $condept = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
            }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
            }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
            }

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, DATE(a.date_revised) AS date_revised,a.bc_status,
                    a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description, a.emp, a.emp2,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,
                    w.description AS status_name,w.status_code, e.description AS issue_name,dept.name AS dept_name, a.is_deleted
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = a.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                    WHERE a.is_deleted = 0 AND a.bc_status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' AND a.company = '$user_company'
                    $constatus $condept $conproject_name
                    ORDER BY dept_name ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['company_code']][] = $row;
            }

    return $newresult;
        }
    }

    public function getStatusOfActionPlanReports($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company) {

        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
        if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";

        $result = $this->db->query($stmt)->result_array();

        #echo '<pre>'; print_r($stmt); exit;

        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
        }

    return $newresult;

        } else if ($reporttype == 2) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
        if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";

        $result = $this->db->query($stmt)->result_array();
        #echo '<pre>'; print_r($stmt); exit;
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
        }

    return $newresult;

    }else if ($reporttype == 3){
        $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
        if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";

        #echo "<pre>" ; echo $stmt ; exit;

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['risk_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 4){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
        if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name,CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['issue_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 5){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
        if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['project_name']][] = $row;
        }

    return $newresult;
    }
    else {

        $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.bc_status = $status";
        }
         if ($dept != 0) {
            $condept = "AND a.dept = $dept";
        }
         if($risk != 0) {
            $conrisk = "AND a.risk1 = $risk";
        }
        if($issue != 0) {
            $conissue = "AND a.issue = $issue";
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";
        }

        $stmt = "SELECT a.issue,b.description AS issue_name, b.code AS issue_code, a.project_id, c.description AS project_name, a.risk1, d.description AS risk_name,
                a.risk_rating,rating.description, rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, assigned_audit AS audit_staff,CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff,
                a.remarks, a.action_plan, a.code, a.bc_status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept, dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.bc_status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND stat.status_code NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom' AND a.company = '$user_company'
                $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY dept_name ASC";
          #print_r2($stmt); exit;
        $result = $this->db->query($stmt)->result_array();

    return $result;

        }
    }*/

    public function getAllData($datefrom_as, $reporttype, $dept, $project_name, $report_period, $user_company, $allstatus) {
        
        if ($reporttype == 1) {
        $constatus = ""; $condept = ""; $conproject_name = "";

            if ($allstatus != 0) {
                $constatus = "AND a.ap_status = $allstatus";
                }
            if ($dept != 0) {
                $condept = "AND a.ap_dept = $dept";
                }
            if ($project_name != 0) {
                $conproject_name = "AND a.ap_project_id = $project_name";
                }

            $stmt = "SELECT a.id,xx.code AS company_code,a.action_plan, a.code,b.id AS bcid,b.bc_code,b.business_concern,a.ap_emp,
                    CONCAT(ap_emp.last_name,' , ',ap_emp.first_name,' ',' ',SUBSTR(ap_emp.middle_name,1,1),'. ') AS person, a.ap_emp_2,
                    CONCAT(ap_emp_2.last_name,' , ', ap_emp_2.first_name,' ',' ',SUBSTR(ap_emp_2.middle_name,1,1),'. ') AS person2,a.ap_dept,
                    ap_dept.name AS ap_dept_name,a.ap_dept_2,ap_dept_2.name AS ap_dept_name2, a.ap_project_id, ap_proj.description AS project_name,
                    a.entered_date AS ap_entered_date, a.ap_due_date, a.ap_date_revised, a.ap_date_implemented,DATE(a.ap_date_tag) AS ap_date_tag, a.ap_assigned_audit,
                    CONCAT(ap_audit.lastname,', ',SUBSTR(ap_audit.firstname,1,1),'. ') AS ap_audit_staff_name,a.ap_impact_remarks,a.ap_status, stat.description AS status_name, 
                    stat.status_code, b.emp,
                    CONCAT(emp.last_name,' , ',emp.first_name,' ',' ',SUBSTR(emp.middle_name,1,1),'. ') AS bc_person,
                    CONCAT(emp2.last_name,' , ',emp2.first_name,' ',' ',SUBSTR(emp2.middle_name,1,1),'. ') AS bc_person2,
                    CONCAT(emp3.last_name,' , ',emp3.first_name,' ',' ',SUBSTR(emp3.middle_name,1,1),'. ') AS bc_person3,
                    b.dept,dept.name AS dept_name1, b.dept2,dept2.name AS dept_name2, b.dept3,dept3.name AS dept_name3,
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS bc_audit_staff_name,b.recur,rec.description AS recur_name,b.remarks AS issue_remarks,
                    proj.description AS bc_project_name,b.assigned_audit,b.issue,c.description AS bc_issue,b.risk1,risk1.description AS risk1, b.risk2, risk2.description AS risk2,
                    risk3,risk3.description AS risk3, rating.description AS risk_rating,b.impact_value,b.impact_remarks,d.description AS bc_status,b.entered_date AS bc_entered_date,
                    b.date_tag,b.due_date, b.date_revised, b.date_implemented AS date_resolved              
                    FROM ap_entry AS a
                    INNER JOIN bc_entry AS b ON b.bc_code = a.bc_code
                    LEFT OUTER JOIN ap_issue AS c ON c.id = b.issue  
                    LEFT OUTER JOIN ap_status AS d ON d.id = b.bc_status                                     
                    LEFT OUTER JOIN ap_project AS ap_proj ON ap_proj.id = a.ap_project_id
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = b.project_id
                    LEFT OUTER JOIN ap_users AS ap_audit ON ap_audit.user_id = a.ap_assigned_audit
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = b.assigned_audit
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = a.ap_status
                    LEFT OUTER JOIN ap_dept AS ap_dept ON ap_dept.id = a.ap_dept
                    LEFT OUTER JOIN ap_dept AS ap_dept_2 ON ap_dept_2.id = a.ap_dept_2
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = b.dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = b.dept2
                    LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = b.dept3
                    LEFT OUTER JOIN hr_companies AS xx ON xx.id = a.company
                    LEFT OUTER JOIN hr_employees AS ap_emp ON ap_emp.user_id = a.ap_emp  
                    LEFT OUTER JOIN hr_employees AS ap_emp_2 ON ap_emp_2.user_id = a.ap_emp_2
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = b.emp
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = b.emp2
                    LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = b.emp3
                    LEFT OUTER JOIN ap_recur AS rec ON rec.id = b.recur 
                    LEFT OUTER JOIN ap_risk AS risk1 ON risk1.id = b.risk1   
                    LEFT OUTER JOIN ap_risk AS risk2 ON risk2.id = b.risk2 
                    LEFT OUTER JOIN ap_risk AS risk3 ON risk3.id = b.risk3  
                    LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = b.risk_rating 
                    WHERE DATE(a.entered_date) <= '$datefrom_as' AND a.bc_code IS NOT NULL 
                    AND a.company = '$user_company' AND ap_proj.company = '$user_company' 
                    AND b.is_approved = '0' AND a.is_approved = '0' $constatus $condept $conproject_name
                    GROUP BY a.id
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();

            $newresult = array();

            foreach ($result as $row) {
            $newresult[$row['bc_code'].' - '.$row['business_concern']][] = $row;
        
            }

        return $newresult;
        }


    }

}