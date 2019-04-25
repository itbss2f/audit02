<?php

class Backup_m extends CI_Model {
    
    public function backup_view($datefrom, $dateto, $user_company) {
            
            $stmt = "SELECT a.code, b.name AS company_name, a.backup_date 
                    FROM ap_entry_history AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company 
                    WHERE DATE(backup_date) >= '$datefrom' AND DATE(backup_date) <= '$dateto' AND company = '$user_company' 
                    ORDER BY backup_date DESC";        
            
            $result = $this->db->query($stmt)->result_array();
            
        return $result;
    }

    public function getActionPlanHistory($user_company) {

            $stmt = "SELECT a.id, a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.ap_due_date) AS due_date, 
                    DATE(a.ap_date_implemented) AS date_implemented, 
                    DATE(a.ap_date_revised) AS date_revised,
                    CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person ,a.status,a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name, a.ap_impact_remarks, ap_impact_value,a.ap_dept,
                    w.description AS status_name, w.status_code, a.is_deleted,dept.name AS dept_name, CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, a.trans_datefrom, a.trans_dateto              
                    FROM ap_entry AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company 
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit  
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.status                    
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept 
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp                                                                                          
                    WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND a.company = '$user_company'  
                    GROUP BY a.code
                    ORDER BY a.entered_date ASC";

            #echo "<pre>"; echo $stmt; exit;

            $result = $this->db->query($stmt)->result_array();
        return $result;
    }
    
    
    public function getActionPlantobebackup($datefrom, $dateto, $user_company) {
        /*Retrieve of Action Plan to be backup*/
                        
            $stmt = "SELECT a.id,a.code ,b.code AS company_code, b.name AS company_name, DATE(a.entered_date) AS entered_date, a.action_plan , DATE(a.ap_due_date) AS due_date, 
                    DATE(a.ap_date_implemented) AS date_implemented, 
                    DATE(a.ap_date_revised) AS date_revised,
                    CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person ,a.status,a.ap_emp, a.ap_emp_2, a.ap_project_id ,c.description AS project_name, a.ap_impact_remarks, 
                    a.ap_impact_value,a.ap_dept, w.description AS status_name, w.status_code, a.is_deleted,dept.name AS dept_name, 
                    CONCAT(audit.lastname,', ',SUBSTR(audit.firstname,1,1),'. ') AS audit_staff, a.backup_date, a.trans_by,
                    CONCAT(users.lastname,', ',SUBSTR(users.firstname,1,1),'. ') AS trans_by
                    FROM ap_entry_history AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company 
                    LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                    LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.ap_assigned_audit  
                    LEFT OUTER JOIN ap_users AS users ON users.user_id = a.trans_by  
                    LEFT OUTER JOIN ap_status AS w ON w.id = a.status                    
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept 
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.ap_emp                                                                                          
                    WHERE DATE(trans_dateto) >= '$datefrom' AND DATE(trans_datefrom) <= '$dateto'
                    AND a.is_deleted = 0 AND a.status NOT IN ('C') AND a.company = '$user_company'  
                    GROUP BY a.code
                    ORDER BY a.entered_date ASC";
                    
            #echo "<pre>"; echo $stmt; exit; 
            $result = $this->db->query($stmt)->result_array();
        return $result;  
    }                                                                                
    
    public function excutebackup($datefrom, $dateto, $user_company, $user_id) { 
            #echo $user_id ; exit;
            //delete if already back-up the same month. 
            $stmt_delete = "DELETE FROM ap_entry_history WHERE DATE(trans_datefrom) = '$datefrom' AND DATE(trans_dateto) = '$dateto' AND company = '$user_company'";
            $this->db->query($stmt_delete);

            //Insert the back up month. 
            $stmt = "INSERT INTO ap_entry_history
                    SELECT a.id,a.code,a.action_plan,a.entered_date,a.company,a.bc_code,a.ap_emp,a.ap_dept,a.ap_emp_2,
                    a.ap_dept_2, a.ap_assigned_audit, a.ap_project_id,a.ap_status, a.ap_date_tag,a.ap_due_date,
                    a.ap_date_revised, a.ap_date_implemented, a.ap_impact_value, a.ap_impact_remarks, a.prev_status,
                    a.prev_date,a.user_n, a.user_d, a.edited_n, a.edited_d, a.deleted_n, a.deleted_d, a.duplicate_n,
                    a.duplicate_d,a.duplicatefrom,a.duplicateto, a.approved_n, a.approved_d,
                    a.status, trans_datefrom,trans_dateto, trans_by,a.is_approved, a.is_duplicate, a.is_deleted,NOW('backup_date') AS backup_date
                    FROM ap_entry AS a
                    WHERE a.company = '$user_company' AND a.status = 'A'
                    AND NOT EXISTS(SELECT * FROM ap_entry_history 
                    WHERE DATE(trans_datefrom) >= '$datefrom' AND DATE(trans_dateto) <= '$dateto' AND a.company = '$user_company' AND trans_datefrom = '$datefrom')";

            #echo "<pre>"; echo $stmt; exit;
            $this->db->query($stmt);

            $stmt2 = "UPDATE ap_entry_history
            SET trans_datefrom = '$datefrom', 
                trans_dateto = '$dateto',
                trans_by = '$user_id'
            WHERE DATE(trans_datefrom) IS NULL AND DATE(trans_dateto) IS NULL AND company = '$user_company'";

            #echo "<pre>"; echo $stmt2; exit;
            $result = $this->db->query($stmt2);

        return true;

            //  //Validate user expiration date
            // if (empty($today)) {
            //     $updatedata['trans_datefrom']  = $datefrom;
            //     $updatedata['trans_dateto']  = $dateto;

            //     $this->db->where('id', $row['id']);
            //     $this->db->update('ap_entry_history', $updatedata);
            //     return 0;
            // } else {
            //     return $row;
            // }
        
            // $datax['trans_datefrom']  = $datefrom;
            // $datax['trans_dateto']  = $dateto;

            // $this->db->where_in('backup_date', $datax['backup_date']);
            // $this->db->update('ap_entry_history', $datax);
      
            // return true;
        

        //     #echo "<pre>"; echo $stmt; exit;
        //     $result = $this->db->query($stmt);
        // return $result;       
    }
    
    public function getBackupReport($datefrom, $dateto, $user_company) {
        
            $stmt = "SELECT a.code, b.name AS company_name, 
                    CONCAT(c.lastname,', ',c.firstname,' ',SUBSTR(c.middlename,1,1),'. ') AS Fullname ,a.backup_date
                    FROM ap_entry_history AS a
                    LEFT OUTER JOIN hr_companies AS b ON b.id = a.company
                    LEFT OUTER JOIN ap_users AS c ON c.user_id = a.user_n 
                    WHERE DATE(a.backup_date) >= '$datefrom' AND DATE(a.backup_date) <= '$dateto' AND a.company = '$user_company' 
                    GROUP BY backup_date ASC";
                    
            #echo "<pre>" ; echo $stmt; exit;
            $result = $this->db->query($stmt)->result_array();
            
        return $result;
    }
} 
