<?php

class Entry_summary_bc extends CI_Model {

    public function getSummaryOfBusinessConcern($datefrom_as, $reporttype, $bc_status, $dept, $project_name, $user_company) {
        /*Summary of Action Plan*/


        if ($reporttype == 1 && $bc_status == 9) {

            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

            if ($bc_status != 0) {
                $constatus = "AND bc.bc_status = '$bc_status'";
                }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
                }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
                }
            if ($user_company != 0) {
                $concompany = "AND bc.company = '$user_company'";
            }

            $stmt = "SELECT 
                    SUM(IF(bc.prev_status IS NULL || bc.bc_status = 9, DATE(bc.entered_date) >= '2017-10-01' AND DATE(bc.entered_date) <= '2017-10-31', '0')) AS beginning,
                    SUM(IF(DATE(bc.entered_date) > '2017-10-31', DATE(bc.entered_date) <= '$datefrom_as', '0')) AS added,
                    SUM(IF(bc.prev_status = 9, DATE(bc.date_tag) <= '$datefrom_as', '0')) AS resolved,
                    SUM(IF(bc.prev_status = 8 AND bc.bc_status = 9,'1', '0')) AS tocancelled,
                    bc.bc_code,bc.business_concern,bc.bc_status,bc.prev_status, bc.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(bc.date_tag) AS date_tag,
                    DATE(bc.entered_date) AS entered_date,
                    DATE(bc.due_date) AS due_date,
                    DATE(bc.date_implemented) AS date_implemented,
                    DATE(bc.date_revised) AS date_revised, bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, bc.emp, bc.emp2, bc.emp3,bc.project_id ,c.description AS project_name,
                    bc.assigned_audit, bc.remarks, bc.dept,bc.dept2,bc.dept3,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, bc.bc_status,a.is_deleted
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS a ON a.bc_code = bc.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE DATE(bc.due_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND c.company = '$user_company' $constatus $condept $conproject_name
                    GROUP BY bc.dept
                    ORDER BY dept_name ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();
            return $result;
        }    
        
        else if ($reporttype == 1 && $bc_status == 10) {

            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

            if ($bc_status != 0) {
                $constatus = "AND bc.bc_status = '$bc_status'";
                }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
                }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
                }
            if ($user_company != 0) {
                $concompany = "AND bc.company = '$user_company'";
            }

            $stmt = "SELECT 
                    SUM(IF(bc.bc_status = 10, DATE(bc.entered_date) >= '2017-10-01' AND DATE(bc.entered_date) <= '2017-10-31', '0')) AS beginning,
                    SUM(DATE(bc.entered_date) > '2017-10-31' AND DATE(bc.entered_date) <= '$datefrom_as') AS newproj,
                    SUM(IF(bc.prev_status = 9 AND bc.bc_status = 10,'1', '0')) AS outstanding,
                    bc.bc_code,bc.business_concern,bc.bc_status,bc.prev_status, bc.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(bc.date_tag) AS date_tag,
                    DATE(bc.entered_date) AS entered_date,
                    DATE(bc.due_date) AS due_date,
                    DATE(bc.date_implemented) AS date_implemented,
                    DATE(bc.date_revised) AS date_revised, bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, bc.emp, bc.emp2, bc.emp3,bc.project_id ,c.description AS project_name,
                    bc.assigned_audit, bc.remarks, bc.dept,bc.dept2,bc.dept3,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, bc.bc_status,a.is_deleted
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS a ON a.bc_code = bc.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE DATE(bc.due_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND c.company = '$user_company' $condept $conproject_name
                    GROUP BY bc.dept
                    ORDER BY dept_name ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();
            return $result;
        }  

        else if ($reporttype == 1 && $bc_status == 8) {

            $constatus = ""; $condept = ""; $conproject_name = ""; $concompany = ""; $condate = ""; 

            if ($bc_status != 0) {
                $constatus = "AND bc.bc_status = '$bc_status'";
                }
            if ($dept != 0) {
                $condept = "AND bc.dept = $dept";
                }
            if ($project_name != 0) {
                $conproject_name = "AND bc.project_id = $project_name";
                }
            if ($user_company != 0) {
                $concompany = "AND bc.company = '$user_company'";
            }

            $stmt = "SELECT 
                    SUM(IF(bc.bc_status = 8, DATE(bc.entered_date) >= '2017-10-01' AND DATE(bc.entered_date) <= '2017-10-31', '0')) AS beginning,
                    SUM(IF(bc.prev_status = 9 AND bc.bc_status = 8,'1', '0')) AS outstanding,
                    bc.bc_code,bc.business_concern,bc.bc_status,bc.prev_status, bc.prev_date,dept.name AS dept_name,b.code AS company_code, 
                    b.name AS comp_name,
                    DATE(bc.date_tag) AS date_tag,
                    DATE(bc.entered_date) AS entered_date,
                    DATE(bc.due_date) AS due_date,
                    DATE(bc.date_implemented) AS date_implemented,
                    DATE(bc.date_revised) AS date_revised, bc.risk1, bc.risk2, bc.risk3, bc.risk_rating,
                    d.description AS risk_description, bc.emp, bc.emp2, bc.emp3,bc.project_id ,c.description AS project_name,
                    bc.assigned_audit, bc.remarks, bc.dept,bc.dept2,bc.dept3,w.description AS status_name,w.status_code AS status_code,
                    e.description AS issue_name,dept.code AS dept_code, bc.bc_status,a.is_deleted
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS a ON a.bc_code = bc.bc_code
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_issue AS e ON e.id = bc.issue
                    LEFT OUTER JOIN ap_status AS w ON w.id = bc.bc_status
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE DATE(bc.due_date) <= '$datefrom_as' 
                    AND bc.company = '$user_company' AND c.company = '$user_company' $constatus $condept $conproject_name
                    GROUP BY bc.dept
                    ORDER BY dept_name ASC";

                #echo "<pre>"; echo $stmt; exit;
                $result = $this->db->query($stmt)->result_array();
            return $result;
        }
    }

}
