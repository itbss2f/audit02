<?php 

class Mod_recurring extends CI_Model {
    
     public function getRecurringOfActionPlans($datefrom, $reporttype, $status, $dept, $project_name ,$recur, $user_companyx) {
         
         #print_r2($recur); exit;
    
        if ($reporttype == 1) { 
            $constatus = ""; $condept = ""; $conproject_name = ""; $conrecur = ""; 
        
        if ($status != 0) {
            $constatus = "AND a.status = $status";    
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";    
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";    
        }
        
        if ($recur != 0) {
            $conrecur = "AND a.recur = $recur";
        }                                   
        
        $stmt = "SELECT a.code,a.action_plan, a.project_id, c.description AS project_name, a.risk1,d.description AS risk_name1,
                a.risk2,xx.description AS risk_name2,a.risk3,yy.description AS risk_name3,a.risk_rating,rating.description, 
                rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, a.assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, dept.code AS dept_code,  
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name,
                stat.description AS status_name,a.impact_value, a.remarks, a.status   
                FROM ap_entry AS a 
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk AS xx ON xx.id = a.risk2
                LEFT OUTER JOIN ap_risk AS yy ON yy.id = a.risk3
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                INNER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                INNER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status  
                INNER JOIN hr_departments AS dept ON dept.id = a.dept                                                                                          
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = 0 AND a.company = '$user_companyx' $constatus $condept $conproject_name $conrecur
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();
        
        #print_r2($stmt); echo '<pre>'; exit;
        
        foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;  
        }
        
    return $newresult;
    
        } else if ($reporttype == 2) { 
            $constatus = ""; $condept = ""; $conproject_name = ""; $conrecur = ""; 
        
        if ($status != 0) {
            $constatus = "AND a.status = $status";    
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";    
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";    
        }
        
        if ($recur != 0) {
            $conrecur = "AND a.recur = $recur";
        }                                   
        
        $stmt = "SELECT a.code,a.action_plan, a.project_id, c.description AS project_name, a.risk1,d.description AS risk_name1,
                a.risk2,xx.description AS risk_name2,a.risk3,yy.description AS risk_name3,a.risk_rating,rating.description, 
                rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, a.assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, dept.code AS dept_code,  
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name,
                stat.description AS status_name,a.impact_value, a.remarks, a.status   
                FROM ap_entry AS a 
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk AS xx ON xx.id = a.risk2
                LEFT OUTER JOIN ap_risk AS yy ON yy.id = a.risk3
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                INNER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                INNER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status  
                INNER JOIN hr_departments AS dept ON dept.id = a.dept                                                                                          
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = 0 AND a.company = '$user_companyx' $constatus $condept $conproject_name $conrecur
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();
        
        #print_r2($stmt); echo '<pre>'; exit;
        
        foreach ($result as $row) {
            $newresult[$row["dept_name"]][$row["status_name"]][] = $row;  
        }
        
    return $newresult;
    
        } else { 
            $constatus = ""; $condept = ""; $conproject_name = ""; $conrecur = ""; 
        
        if ($status != 0) {
            $constatus = "AND a.status = $status";    
        }
        if ($dept != 0) {
            $condept = "AND a.dept = $dept";    
        }
        if ($project_name != 0) {
            $conproject_name = "AND a.project_id = $project_name";    
        }
        
        if ($recur != 0) {
            $conrecur = "AND a.recur =  $recur";
        }                                   
        
        $stmt = "SELECT a.code,a.action_plan, a.project_id, c.description AS project_name, a.risk1,d.description AS risk_name1,
                a.risk2,xx.description AS risk_name2,a.risk3,yy.description AS risk_name3,a.risk_rating,rating.description, 
                rating.code AS rating_code,a.entered_date, a.due_date, a.date_revised, a.date_implemented, a.emp, a.assigned_audit,
                CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, dept.code AS dept_code,  
                CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name,
                stat.description AS status_name,a.impact_value, a.remarks, a.status   
                FROM ap_entry AS a 
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk AS xx ON xx.id = a.risk2
                LEFT OUTER JOIN ap_risk AS yy ON yy.id = a.risk3
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                INNER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                INNER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status  
                INNER JOIN hr_departments AS dept ON dept.id = a.dept                                                                                          
                WHERE DATE(a.entered_date) <= '$datefrom' AND a.is_deleted = 0 AND a.company = '$user_companyx' $constatus $condept $conproject_name $conrecur
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();
        
        #print_r2($stmt); echo '<pre>'; exit;
        
        foreach ($result as $row) {
            $newresult[$row["project_name"]][$row["status_name"]][] = $row;  
        }
        
    return $newresult;
    
        }
    }
    
}    
