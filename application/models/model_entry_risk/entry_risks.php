<?php

class Entry_risks extends CI_Model {
    
    public function saveNewAcceptedRiskData($data) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s'); 

        //$randomstring = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //$numbers = rand(10000000, 99999999); 
        //$prefix = "FA";
        //$data['code'] = $prefix.''.$numbers.''.$randomstring;
        $this->db->insert('ap_accept_risk', $data);
        
        return true;   
    }
    
    public function getThisDataforAcceptedRisks($id, $company) {
        
        $stmt = "SELECT a.id, a.code, b.name AS company_name, a.company, DATE(a.entered_date) AS entered_date, DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented, 
            DATE(a.date_revised) AS date_revised, DATE(a.date_tag) AS date_tag, risk1, risk2, risk3, risk_rating, a.emp, a.emp2, project_id, assigned_audit, dept,remarks,a.status,a.prev_status, 
            action_plan ,issue,issue_remarks, is_deleted, prev_status, recur, impact_remarks, impact_value, CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname
            FROM ap_accept_risk AS a
            LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
            LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp                                                                                                                                                                                             
            WHERE a.id = '$id' AND company = '$company'"; 
                
    #echo "<pre>"; echo $stmt; exit;  
    $row = $this->db->query($stmt)->row_array();
            
    return $row;        
    }
    
    /*public function getThisEntry_RisksforApproval($company, $user_id) {
        
            $stmt = "SELECT a.id, a.code, a.company, b.name AS company_name,b.code AS company_code, DATE(a.entered_date) AS entered_date, a.action_plan, DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented,
                    DATE(a.date_revised) AS date_revised,a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description , a.emp, CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname, 
                    a.emp2, a.project_id,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,a.status, a.issue, a.recur, a.is_deleted, a.is_approved, is_duplicate, duplicate_n AS duplicate_name, a.user_n,  
                    au.username AS audit_name 
                    FROM ap_accept_risk AS a
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company 
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id  
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_risk AS e ON e.id = a.risk1  
                    LEFT OUTER JOIN ap_users AS au ON a.user_n = au.user_id    
                    WHERE a.is_deleted = '0' AND a.is_approved = 1 AND a.company = '$company' AND au.user_id = '$user_id'
                    GROUP BY a.id
                    ORDER BY a.code";    

            $result = $this->db->query($stmt);  
      
        return $result->result_array(); 
    }*/
    
    public function getThisEntry_Risks($company, $user_id) {
        
            $stmt = "SELECT a.id, a.code, a.company, b.name AS company_name,b.code AS company_code, DATE(a.entered_date) AS entered_date, a.action_plan, DATE(a.due_date) AS due_date, DATE(a.date_implemented) AS date_implemented,
                    DATE(a.date_revised) AS date_revised,a.risk1, a.risk2, a.risk3, a.risk_rating, d.description AS risk_description , a.emp, CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname, 
                    a.emp2, a.project_id,c.description AS project_name, a.assigned_audit, a.remarks, a.dept,a.status, a.issue, a.recur, a.is_deleted, a.is_approved, is_duplicate, duplicate_n AS duplicate_name, a.user_n,  
                    au.username AS audit_name 
                    FROM ap_accept_risk AS a
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company 
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id  
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = a.risk_rating
                    LEFT OUTER JOIN ap_risk AS e ON e.id = a.risk1  
                    LEFT OUTER JOIN ap_users AS au ON a.user_n = au.user_id    
                    WHERE a.is_deleted = '0' AND a.is_approved = 0 AND a.company = '$company' AND au.user_id = '$user_id'
                    GROUP BY a.id
                    ORDER BY a.code";    

            $result = $this->db->query($stmt);  
      
        return $result->result_array(); 
    }
    
    public function getTotalForApprovalOfActionPlan($company) {
        
            $stmt = "SELECT COUNT(id) AS approval 
                    FROM ap_accept_risk
                    WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                    ORDER BY id";
        
        $row = $this->db->query($stmt);
        
    return $row->row_array();     
             
    }
    
    public function getTotalActionPlan($company) {
        //total
        
            $stmt = "SELECT COUNT(id) AS total_action 
                    FROM ap_accept_risk
                    WHERE is_deleted = '0' AND is_approved = '0' AND company = '$company'
                    ORDER BY id";
            
        $row = $this->db->query($stmt);
        
        #echo "<pre>"; echo $stmt; exit;    
        
    return $row->row_array();  
          
    }
    
    /*public function getTotalForApprovalOfActionPlan($company) {
        //total_approval
        
            $stmt = "SELECT COUNT(id) AS approval 
                    FROM ap_accept_risk
                    WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                    ORDER BY id";
        
        $row = $this->db->query($stmt);
        
        #echo "<pre>"; echo $stmt; exit;
        
    return $row->row_array();     
             
    }*/
    
    /*public function getTotalActionPlanByApprover($company, $user_id) {
        //xtotal
        
            $stmt = "SELECT COUNT(id) AS total_actionplan 
                    FROM ap_accept_risk
                    WHERE is_deleted = '0' AND is_approved = '0' AND company = '$company' AND approved_n = '$user_id'
                    ORDER BY id";
            
        $row = $this->db->query($stmt);
        
    return $row->row_array();        
        
    } */
    
    
}