<?php

class Model_entry extends CI_Model {

    public function getThissearchactioncode($myCodeExist, $company) {

          $stmt = "SELECT *
                  FROM ap_entry
                  WHERE code = '$myCodeExist' AND is_approved = '0'
                  AND is_deleted = '0' AND is_duplicate = '0'
                  AND company = '$company' AND ap_status != '2'";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt)->row_array();

    return $result;

    }

    public function getThissearchbccode($myBcExist, $company) {

          $stmt = "SELECT *
                  FROM bc_entry
                  WHERE bc_code = '$myBcExist' AND is_approved = '0'
                  AND is_deleted = '0' AND is_duplicate = '0'
                  AND company = '$company' AND bc_status != '10'";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt)->row_array();

    return $result;

    }

	public function getBC_codesofAction($code, $company) {

		
		  $stmt = "SELECT ap.id AS apids,ap.code, bc.id AS bcid,bc.bc_code AS bc_code,ap.ap_status,bc.bc_status,
                    ap.is_approved AS apis_approved, bc.is_approved AS bcis_approved
                    FROM ap_entry AS ap
                    INNER JOIN bc_entry AS bc ON ap.bc_code = bc.bc_code
                    WHERE ap.code = '$code'
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY ap.bc_code
                    ORDER BY bc.bc_code";
	
	
          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();
		  
	}

    public function getAPCodes($id, $company) {

          $stmt = "SELECT bc.id AS bcid,ap.id AS apid,ap.code, bc.bc_code,ap.ap_status,bc.bc_status,
                    ap.is_approved AS apis_approved
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.id = '$id' AND bc.is_approved NOT IN ('1')
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY apid
                    ORDER BY ap.code";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getAPCodesCount($id, $company) {

          $stmt = "SELECT COUNT(ap.id) AS apidcount,bc.id AS bcid,ap.id AS apid,ap.code, bc.bc_code,ap.ap_status,bc.bc_status,
                    ap.is_approved AS apis_approved
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.id = '$id' AND bc.is_approved NOT IN ('1')
                    AND bc.company = '$company' AND ap.company = '$company'
                    ORDER BY ap.code";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getAPCodesfa($id, $company) {

          $stmt = "SELECT ap.id AS apid,ap.code, bc.bc_code,ap.ap_status,bc.bc_status,
                    ap.is_approved AS apis_approved
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.id = '$id' AND bc.is_deleted = '0' AND bc.is_approved = '1'
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY apid
                    ORDER BY apid";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getapbycompany($company) {

          $stmt = "SELECT ap.id AS apid,ap.code, bc.bc_code
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.is_deleted = '0' AND bc.is_approved = '0'
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY apid
                    ORDER BY apid";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getbcbycompany($company) {

          $stmt = "SELECT bc.id, bc.bc_code
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.is_deleted = '0' AND bc.is_approved = '0'
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY bc.id
                    ORDER BY bc.id";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getbccodes($bc_code, $company) {

          $stmt = "SELECT ap.id AS apid,ap.code, bc.bc_code
                    FROM bc_entry AS bc
                    INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                    WHERE bc.bc_code = '$bc_code' AND bc.is_deleted = '0' AND bc.is_approved = '0'
                    AND bc.company = '$company' AND ap.company = '$company'
                    GROUP BY apid
                    ORDER BY apid";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

      return $result->result_array();

    }

    public function getCodeImport($importcode, $company) {

          $stmt = "SELECT ap.*,bc.*
                    FROM ap_entry AS ap
                    INNER JOIN bc_entry AS bc ON ap.bc_code = bc.bc_code
                    WHERE ap.status = 'A' AND ap.is_deleted = '0' AND ap.is_approved = '0'
                    AND ap.company = '$company' AND bc.company = '$company'
                    AND code = '$importcode'";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

        return $result->result_array();

    }

    public function countAll($company) {

          $stmt = "SELECT COUNT(*) AS total_action_id
                      FROM bc_entry AS bc
                      INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                      WHERE ap.is_deleted = '0' AND ap.is_approved = '0' AND bc.company = '$company'
                      ORDER BY ap.id";

          #echo "<pre>"; echo $stmt; exit;
          $result = $this->db->query($stmt);

        return $result->row();
    }

    //Searching of Action Plan (Inquiry) Excell
    public function searchedexcell($lookup_code,$lookup_action_plan, $lookup_assigned_audit, $lookup_project_id, $lookup_dept, $lookup_person, $company) {

        $concode = ""; $conaction = ""; $conaudit = ""; $conproject = ""; $condept = ""; $condept2 = ""; $conperson = ""; $conperson2 = "";

        if ($lookup_code != '') { $concode = "AND a.code LIKE '".$lookup_code."'"; }
        if ($lookup_action_plan != '') { $conaction = "AND a.action_plan LIKE '%".$lookup_action_plan."%'"; }
        if ($lookup_assigned_audit != '') { $conaudit = "AND a.ap_assigned_audit LIKE '".$lookup_assigned_audit."'"; }
        if ($lookup_project_id != '') { $conproject = "AND a.ap_project_id LIKE '".$lookup_project_id."'"; }
        if ($lookup_dept != '') { $condept = "AND (a.ap_dept LIKE '".$lookup_dept."'"; }
        if ($lookup_dept != '') { $condept2 = "|| a.ap_dept_2 LIKE '".$lookup_dept."')"; }
        if ($lookup_person != '') { $conperson = "AND (a.ap_emp LIKE '".$lookup_person."'"; }
        if ($lookup_person != '') { $conperson2 = "|| a.ap_emp_2 LIKE '".$lookup_person."')"; }

        $stmt = "SELECT DISTINCT a.id, a.code AS action_code, a.action_plan,
                        CONCAT(person.last_name,' , ', person.first_name,' ',SUBSTR(person.middle_name,1,1),'. ') AS person, a.ap_emp,
                        CONCAT(person2.last_name,' , ', person2.first_name,' ',SUBSTR(person2.middle_name,1,1),'. ') AS person2, a.ap_emp_2,
                        CONCAT(u.lastname,' , ', u.firstname,' ',SUBSTR(u.middlename,1,1),'. ') AS audit_staff, u.employee_id,
                        CONCAT(users.lastname,' , ', users.firstname,' ',SUBSTR(users.middlename,1,1),'. ') AS user_entered,
                        proj.code AS projectcode, proj.description AS projectname, dept.code AS deptcode ,dept.name AS department,a.ap_dept,
                        dept2.name AS department2,a.ap_dept_2,ap.description AS status_name, a.ap_due_date
                        FROM ap_entry AS a
                        LEFT OUTER JOIN ap_users AS users ON users.user_id = a.user_n
                        LEFT OUTER JOIN ap_users AS u ON u.user_id = a.ap_assigned_audit
                        LEFT OUTER JOIN hr_employees AS person ON person.user_id = a.ap_emp
                        LEFT OUTER JOIN hr_employees AS person2 ON person2.user_id = a.ap_emp_2
                        LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                        LEFT OUTER JOIN ap_user_company AS uc ON uc.company_id = a.company
                        LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                        LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                        LEFT OUTER JOIN ap_status AS ap ON ap.id = a.ap_status
                        WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.is_duplicate = '0'
                        AND a.company= '$company'
                        $concode $conaction $conaudit $conproject $condept $condept2 $conperson $conperson2
                        GROUP BY a.id
                        ORDER BY a.id";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    //Searching of Action Plan (Inquiry)
    public function searched($searchkey, $company) {
        #print_r2($searchkey['lookup_code']);        exit;

        $concode = ""; $conaction = ""; $conaudit = ""; $conproject = ""; $condept = ""; $condept2 = ""; $conperson = ""; $conperson2 = "";

        if ($searchkey['lookup_code'] != '') { $concode = "AND a.code LIKE '".$searchkey['lookup_code']."'"; }
        if ($searchkey['lookup_action_plan'] != '') { $conaction = "AND a.action_plan LIKE '%".$searchkey['lookup_action_plan']."%'"; }
        if ($searchkey['lookup_assigned_audit'] != '') { $conaudit = "AND a.ap_assigned_audit LIKE '".$searchkey['lookup_assigned_audit']."'"; }
        if ($searchkey['lookup_project_id'] != '') { $conproject = "AND a.ap_project_id LIKE '".$searchkey['lookup_project_id']."'"; }
        if ($searchkey['lookup_dept'] != '') { $condept = "AND (a.ap_dept LIKE '".$searchkey['lookup_dept']."'"; }
        if ($searchkey['lookup_dept'] != '') { $condept2 = "OR a.ap_dept_2 LIKE '".$searchkey['lookup_dept']."')"; }
        if ($searchkey['lookup_person'] != '') { $conperson = "AND (a.ap_emp LIKE '".$searchkey['lookup_person']."'"; }
        if ($searchkey['lookup_person'] != '') { $conperson2 = "OR a.ap_emp_2 LIKE '".$searchkey['lookup_person']."')"; }

        $stmt = "SELECT DISTINCT a.id, a.code AS action_code, a.action_plan,
                        CONCAT(person.last_name,' , ', person.first_name,' ',SUBSTR(person.middle_name,1,1),'. ') AS person, a.ap_emp,
                        CONCAT(person2.last_name,' , ', person2.first_name,' ',SUBSTR(person2.middle_name,1,1),'. ') AS person2, a.ap_emp_2,
                        CONCAT(u.lastname,' , ', u.firstname,' ',SUBSTR(u.middlename,1,1),'. ') AS audit_staff, u.employee_id,
                        CONCAT(users.lastname,' , ', users.firstname,' ',SUBSTR(users.middlename,1,1),'. ') AS user_entered,
                        proj.code AS projectcode, proj.description AS projectname, dept.code AS deptcode ,dept.name AS department,a.ap_dept,
                        dept2.name AS department2,a.ap_dept_2
                        FROM ap_entry AS a
                        LEFT OUTER JOIN ap_users AS users ON users.user_id = a.user_n
                        LEFT OUTER JOIN ap_users AS u ON u.user_id = a.ap_assigned_audit
                        LEFT OUTER JOIN hr_employees AS person ON person.user_id = a.ap_emp
                        LEFT OUTER JOIN hr_employees AS person2 ON person2.user_id = a.ap_emp_2
                        LEFT OUTER JOIN ap_project AS proj ON proj.id = a.ap_project_id
                        LEFT OUTER JOIN ap_user_company AS uc ON uc.company_id = a.company
                        LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.ap_dept
                        LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.ap_dept_2
                        WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.is_duplicate = '0'
                        AND a.company= '$company'
                        $concode $conaction $conaudit $conproject $condept $condept2 $conperson $conperson2
                        GROUP BY a.id
                        ORDER BY a.id";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    //Searching of Business Concern (Inquiry) Excell
    public function searchedexcellbc($lookup_code,$lookup_bc, $lookup_assigned_audit, $lookup_project_id, $lookup_dept, $lookup_person, $company) {

        $concode = ""; $conbusiness = ""; $conaudit = ""; $conproject = ""; $condept = ""; $condept2 = ""; $condept3 = "";
        $conperson = "";$conperson2 = "";$conperson3 = "";

        if ($lookup_code != '') { $concode = "AND a.bc_code LIKE '".$lookup_code."'"; }
        if ($lookup_bc != '') { $conbusiness = "AND a.business_concern LIKE '%".$lookup_bc."%'"; }
        if ($lookup_assigned_audit != '') { $conaudit = "AND a.assigned_audit LIKE '".$lookup_assigned_audit."'"; }
        if ($lookup_project_id != '') { $conproject = "AND a.project_id LIKE '".$lookup_project_id."'"; }
        if ($lookup_dept != '') { $condept = "AND (a.dept LIKE '".$lookup_dept."'"; }
        if ($lookup_dept != '') { $condept2 = "|| a.dept2 LIKE '".$lookup_dept."'"; }
        if ($lookup_dept != '') { $condept3 = "|| a.dept3 LIKE '".$lookup_dept."')"; }
        if ($lookup_person != '') { $conperson = "AND (a.emp LIKE '".$lookup_person."'"; }
        if ($lookup_person != '') { $conperson2 = "|| a.emp2 LIKE '".$lookup_person."'"; }
        if ($lookup_person != '') { $conperson3 = "|| a.emp3 LIKE '".$lookup_person."')"; }

        $stmt = "SELECT DISTINCT a.id, a.bc_code AS bccode, a.business_concern,
                        a.risk1,risk1.description AS risk1_des, a.risk2,risk2.description AS risk2_des,a.risk3,risk3.description AS risk3_des,
                        CONCAT(person.last_name,' , ', person.first_name,' ',SUBSTR(person.middle_name,1,1),'. ') AS person, a.emp,
                        CONCAT(person2.last_name,' , ', person2.first_name,' ',SUBSTR(person2.middle_name,1,1),'. ') AS person2, a.emp2,
                        CONCAT(person3.last_name,' , ', person3.first_name,' ',SUBSTR(person3.middle_name,1,1),'. ') AS person3, a.emp3,
                        CONCAT(u.lastname,' , ', u.firstname,' ',SUBSTR(u.middlename,1,1),'. ') AS audit_staff,
                        CONCAT(users.lastname,' , ', users.firstname,' ',SUBSTR(users.middlename,1,1),'. ') AS user_entered,
                        proj.code AS projectcode, proj.description AS projectname, dept.code AS deptcode ,dept.name AS department, a.dept,
                        dept2.name AS department2, a.dept2, dept3.name AS department3, a.dept3, ap.description AS status_name, a.due_date
                        FROM bc_entry AS a
                        LEFT OUTER JOIN ap_users AS users ON users.user_id = a.user_n
                        LEFT OUTER JOIN ap_users AS u ON u.user_id = a.assigned_audit
                        LEFT OUTER JOIN hr_employees AS person ON person.user_id = a.emp
                        LEFT OUTER JOIN hr_employees AS person2 ON person2.user_id = a.emp2
                        LEFT OUTER JOIN hr_employees AS person3 ON person3.user_id = a.emp3
                        LEFT OUTER JOIN ap_project AS proj ON proj.id = a.project_id
                        LEFT OUTER JOIN ap_user_company AS uc ON uc.company_id = a.company
                        LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                        LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.dept2
                        LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = a.dept3
                        LEFT OUTER JOIN ap_risk AS risk1 ON risk1.id = a.risk1
                        LEFT OUTER JOIN ap_risk AS risk2 ON risk2.id = a.risk2
                        LEFT OUTER JOIN ap_risk AS risk3 ON risk3.id = a.risk3   
                        LEFT OUTER JOIN ap_status AS ap ON ap.id = a.bc_status
                        WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.is_duplicate = '0'
                        AND a.company= '$company'
                        $concode $conbusiness $conaudit $conproject $condept $condept2 $condept3 $conperson $conperson2 $conperson3
                        GROUP BY a.id
                        ORDER BY a.id";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

        return $result->result_array();


    }

    //Searching of Business Concern (Inquiry)
    public function searchedbc($searchkey, $company) {
        //print_r2($searchkey);        exit;

        $concode = ""; $conbusiness = ""; $conaudit = ""; $conproject = ""; $condept = ""; $condept2 = ""; $condept3 = "";
        $conperson = "";$conperson2 = "";$conperson3 = "";

        if ($searchkey['lookup_code'] != '') { $concode = "AND a.bc_code LIKE '".$searchkey['lookup_code']."'"; }
        if ($searchkey['lookup_bc'] != '') { $conbusiness = "AND a.business_concern LIKE '%".$searchkey['lookup_bc']."%'"; }
        if ($searchkey['lookup_assigned_audit'] != '') { $conaudit = "AND a.assigned_audit LIKE '".$searchkey['lookup_assigned_audit']."'"; }
        if ($searchkey['lookup_project_id'] != '') { $conproject = "AND a.project_id LIKE '".$searchkey['lookup_project_id']."'"; }
        if ($searchkey['lookup_dept'] != '') { $condept = "AND (a.dept LIKE '".$searchkey['lookup_dept']."'"; }
        if ($searchkey['lookup_dept'] != '') { $condept2 = "|| a.dept2 LIKE '".$searchkey['lookup_dept']."'"; }
        if ($searchkey['lookup_dept'] != '') { $condept3 = "|| a.dept3 LIKE '".$searchkey['lookup_dept']."')"; }
        if ($searchkey['lookup_person'] != '') { $conperson = "AND (a.emp LIKE '".$searchkey['lookup_person']."'"; }
        if ($searchkey['lookup_person'] != '') { $conperson2 = "|| a.emp2 LIKE '".$searchkey['lookup_person']."'"; }
        if ($searchkey['lookup_person'] != '') { $conperson3 = "|| a.emp3 LIKE '".$searchkey['lookup_person']."')"; }

        $stmt = "SELECT DISTINCT a.id, a.bc_code AS bccode, a.business_concern,
                        a.risk1,risk1.description AS risk1_des, a.risk2,risk2.description AS risk2_des,a.risk3,risk3.description AS risk3_des,
                        CONCAT(person.last_name,' , ', person.first_name,' ',SUBSTR(person.middle_name,1,1),'. ') AS person, a.emp,
                        CONCAT(person2.last_name,' , ', person2.first_name,' ',SUBSTR(person2.middle_name,1,1),'. ') AS person2, a.emp2,
                        CONCAT(person3.last_name,' , ', person3.first_name,' ',SUBSTR(person3.middle_name,1,1),'. ') AS person3, a.emp3,
                        CONCAT(u.lastname,' , ', u.firstname,' ',SUBSTR(u.middlename,1,1),'. ') AS audit_staff,
                        CONCAT(users.lastname,' , ', users.firstname,' ',SUBSTR(users.middlename,1,1),'. ') AS user_entered,
                        proj.code AS projectcode, proj.description AS projectname, dept.code AS deptcode ,dept.name AS department, a.dept,
                        dept2.name AS department2, a.dept2, dept3.name AS department3, a.dept3
                        FROM bc_entry AS a
                        LEFT OUTER JOIN ap_users AS users ON users.user_id = a.user_n
                        LEFT OUTER JOIN ap_users AS u ON u.user_id = a.assigned_audit
                        LEFT OUTER JOIN hr_employees AS person ON person.user_id = a.emp
                        LEFT OUTER JOIN hr_employees AS person2 ON person2.user_id = a.emp2
                        LEFT OUTER JOIN hr_employees AS person3 ON person3.user_id = a.emp3
                        LEFT OUTER JOIN ap_project AS proj ON proj.id = a.project_id
                        LEFT OUTER JOIN ap_user_company AS uc ON uc.company_id = a.company
                        LEFT OUTER JOIN ap_dept AS dept ON dept.id = a.dept
                        LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = a.dept2
                        LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = a.dept3
                        LEFT OUTER JOIN ap_risk AS risk1 ON risk1.id = a.risk1
                        LEFT OUTER JOIN ap_risk AS risk2 ON risk2.id = a.risk2
                        LEFT OUTER JOIN ap_risk AS risk3 ON risk3.id = a.risk3   
                        WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.is_duplicate = '0'
                        AND a.company= '$company'
                        $concode $conbusiness $conaudit $conproject $condept $condept2 $condept3 $conperson $conperson2 $conperson3
                        GROUP BY a.id
                        ORDER BY a.id";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

        return $result->result_array();

    }

    public function searchedbccode($searchkey, $company) {

        if ($searchkey['lookup_bccode'] != '') { $concode = "AND bc_code LIKE '".$searchkey['lookup_bccode']."'"; }

        $stmt = "SELECT id, bc_code, business_concern, bc_status, company
                        FROM bc_entry
                        WHERE is_deleted = 0 AND is_approved = 0
                        AND company = '$company' AND is_duplicate = '0' AND bc_status NOT IN ('10') $concode
                        GROUP BY bc_code
                        ORDER BY id
                        LIMIT 50";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    public function searchedaccode($searchkey, $company) {

        if ($searchkey['lookup_apcode'] != '') { $concode = "AND a.code LIKE '".$searchkey['lookup_apcode']."'"; }

        $stmt = "SELECT DISTINCT a.*,a.code AS action_code,users.employee_id,
                        CONCAT(users.lastname,' , ', users.firstname,' ',SUBSTR(users.middlename,1,1),'. ') AS audit_staff
                        FROM ap_entry AS a
                        LEFT OUTER JOIN ap_users AS users ON users.user_id = a.user_n
                        LEFT OUTER JOIN ap_user_company AS uc ON uc.company_id = a.company
                        WHERE a.is_deleted = 0 AND a.is_approved = 0
                        AND a.company='$company' AND a.is_duplicate = '0' AND ap_status NOT IN ('2') $concode
                        ORDER BY a.id
                        LIMIT 50";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    public function searchedcode($searchkey, $company, $bc_code) {

        if ($searchkey['lookup_apcode'] != '') { $concode = "AND a.code LIKE '".$searchkey['lookup_apcode']."'"; }
        //if ($searchkey['bc_code'] != '') { $conbccode = "AND a.bc_code NOT IN ('".$searchkey['bc_code']."')"; }

        $stmt = "SELECT a.id,a.code AS action_code, a.action_plan, a.entered_date,a.company,bc_code, a.ap_emp, a.ap_emp_2,a.ap_dept,
                  a.ap_dept_2,a.ap_impact_value, a.ap_impact_remarks,a.ap_assigned_audit,a.ap_status,a.ap_date_tag,a.ap_date_implemented,
                  a.ap_due_date, a.ap_date_revised, a.ap_project_id, a.status, a.is_approved,a.is_duplicate,a.is_deleted
                  FROM   ap_entry AS a
                  WHERE a.code NOT LIKE '(NULL)' AND a.is_deleted = 0 AND a.is_approved = 0 AND ap_status !='2'
                  AND a.company = '1' AND is_duplicate = '0' AND is_approved NOT IN ('2', '1') $concode
                  AND a.code NOT IN
                  (
                  SELECT  CODE
                  FROM    ap_entry
                  WHERE   bc_code = '$bc_code' AND company = '$company' AND ap_status !='2'
                  GROUP BY CODE
                  )";

            #echo "<pre>"; echo $stmt; exit;
            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    public function getTotalActionPlan($company) {

            $stmt = "SELECT COUNT(ap.id) AS total_action
                    FROM ap_entry AS ap
                    WHERE ap.company = '$company' AND ap.is_duplicate = '0'
                    AND ap.is_approved NOT IN ('1','3') 
                    ORDER BY ap.id";

        $row = $this->db->query($stmt);

        #echo "<pre>"; echo $stmt; exit;

    return $row->row_array();

    }

    public function getTotalBusinessConcern($company) {

            $stmt = "SELECT COUNT(bc.id) AS total_business_concern
                    FROM bc_entry AS bc
                    WHERE bc.company = '$company' AND bc.is_duplicate = '0'
                    ORDER BY bc.id";

        $row = $this->db->query($stmt);

        #echo "<pre>"; echo $stmt; exit;

    return $row->row_array();

    }


    public function getTotalActionPlanByApprover($company, $user_id) {

            $stmt = "SELECT COUNT(ap.id) AS total_actionplan
                      FROM bc_entry AS bc
                      INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                      WHERE ap.is_deleted = '0' AND ap.is_approved = '0' AND bc.approved_n = '$user_id' AND bc.company = '$company'
                      ORDER BY ap.id";

        $row = $this->db->query($stmt);

    return $row->row_array();

    }

    public function getTotalForApprovalOfBusinessConcern($company) {

            $stmt = "SELECT COUNT(bc_code) AS bcforapproval
                    FROM bc_entry
                    WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                    ORDER BY bc_code";

        $row = $this->db->query($stmt);
        #echo "<pre>"; echo $stmt; exit;

    return $row->row_array();
    }

    public function getTotalForApprovalOfActionPlan($company) {

            $stmt = "SELECT COUNT(id) AS actionforapproval
                    FROM ap_entry
                    WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                    ORDER BY id";

        $row = $this->db->query($stmt);
        #echo "<pre>"; echo $stmt; exit;

    return $row->row_array();
    }

    public function getTotalForApproval($company) {
            $stmt = "SELECT SUM(total_approval) AS total
                        FROM
                        (
                            SELECT COUNT(*) AS total_approval
                            FROM bc_entry
                            WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                            UNION ALL
                            SELECT COUNT(*) AS total_action
                            FROM ap_entry
                            WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'
                            UNION ALL
                            SELECT COUNT(*) AS total_approval
                            FROM ap_issue
                            WHERE is_deleted = '0' AND is_approved = '1'
                            UNION ALL
                            SELECT COUNT(*) AS total_approval
                            FROM ap_risk
                            WHERE is_deleted = '0' AND is_approved = '1'
                            UNION ALL
                            SELECT COUNT(*) AS total_approval
                            FROM ap_project
                            WHERE is_deleted = '0' AND is_approved = '1'

                        ) ctquery";

        $row = $this->db->query($stmt);

    return $row->row_array();
    }

    //Records of all approved audit action plan by approver for admin access only
    public function getThisActionPlanOfApprover($company) {

            $stmt = "SELECT a.*, a.ap_project_id,c.description AS project_name, stat.status_code,
                        CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname
                        FROM ap_entry AS a
                        LEFT OUTER JOIN ap_project AS c ON c.id = a.ap_project_id
                        LEFT OUTER JOIN ap_status AS stat ON a.ap_status = stat.id
                        LEFT OUTER JOIN ap_users AS au ON au.user_id = a.ap_assigned_audit
                        INNER JOIN ap_user_company AS uc ON a.approved_n = uc.user_id
                        WHERE a.is_deleted = '0' AND a.is_approved = 0 AND a.company = '$company'
                        GROUP BY a.id 
                        ORDER BY a.code ASC";

            $result = $this->db->query($stmt);

            #echo "<pre>"; echo $stmt; exit;

        return $result->result_array();

    }

    //List of all approved Audit Action Plan
    public function getThisActionPlan($company) {

            $stmt = "SELECT ap.*,stat.status_code AS apstatus,
                    CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname,
                    proj.code AS projectcode, proj.description AS projectname,dept.code AS deptcode,
                    dept.name AS department, ap.is_duplicate, ap.is_deleted
                    FROM ap_entry AS ap
                    LEFT OUTER JOIN ap_status AS stat ON stat.id = ap.ap_status
                    LEFT OUTER JOIN ap_users AS au ON au.user_id = ap.ap_assigned_audit
                    LEFT OUTER JOIN hr_companies AS b ON b.id = ap.company
                    LEFT OUTER JOIN ap_project AS proj ON proj.id = ap.ap_project_id
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = ap.ap_dept
                    WHERE is_duplicate = 0 AND ap.is_approved NOT IN ('1','3')
                    AND ap.company = '$company' AND proj.company = '1'
                    GROUP BY ap.id
                    ORDER BY ap.code ASC";

              #echo "<pre>"; echo $stmt; exit;
              $result = $this->db->query($stmt)->result_array();

        return $result;
    }

    //List of all approved Business Concern
    public function getThisBusinessConcern($company) {

            $stmt = "SELECT bc.id, bc.bc_code,bc.business_concern,bc.bc_status,bc.company,bc.entered_date,
                    bc.project_id,c.description AS project_name, stat.status_code,dept.name AS department,
                    CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname,
                    bc.is_duplicate
                    FROM bc_entry AS bc
                    LEFT OUTER JOIN ap_project AS c ON c.id  = bc.project_id
                    LEFT OUTER JOIN ap_status AS stat ON bc.bc_status = stat.id
                    LEFT OUTER JOIN ap_users AS au ON au.user_id = bc.assigned_audit
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    WHERE bc.is_approved NOT IN ('1', '3') AND bc.company = '$company'
                    AND bc.is_duplicate = '0'
                    GROUP BY bc.id
                    ORDER BY bc.bc_code ASC";

              #echo "<pre>"; echo $stmt; exit;
              $result = $this->db->query($stmt)->result_array();

        return $result;
    }
    public function getThisEntryforApprovalOfBusinessConcern($company) {

            $stmt = "SELECT bc.id, bc.bc_code, bc.business_concern AS bc_concern, bc.company, DATE(bc.entered_date) AS entered_date,DATE(bc.due_date) AS due_date, DATE(bc.date_implemented) AS date_implemented,
                    DATE(bc.date_revised) AS date_revised,bc.risk1, bc.risk2, bc.risk3, bc.risk_rating, bc.emp, bc.emp2, bc.emp3,d.description AS risk_description,bc.project_id,c.description AS project_name, bc.assigned_audit,
                    CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullnameBCI, dept.name AS departBC,
                    CONCAT(emp2.last_name,', ',emp2.first_name,' ',SUBSTR(emp2.middle_name,1,1),'. ')AS fullnameBCII, dept2.name AS departBCII,
                    CONCAT(emp3.last_name,', ',emp3.first_name,' ',SUBSTR(emp3.middle_name,1,1),'. ')AS fullnameBCIII,dept3.name AS departBCIII,
            		    CONCAT(audit.lastname,', ',audit.firstname,' ',SUBSTR(audit.middlename,1,1),'. ')AS audit,
                    bc.remarks, bc.dept,bc.bc_status, bc.issue, bc.recur,bc.is_deleted, bc.is_approved, bc.is_duplicate, bc.duplicate_n AS duplicate_name, bc.user_n,au.username AS audit_name
                    FROM bc_entry AS bc
                    LEFT OUTER JOIN ap_entry AS ap ON ap.code = bc.bc_code
                    LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = bc.emp
                    LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = bc.emp2
                    LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = bc.emp3
                    LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                    LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = bc.dept2
                    LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = bc.dept3
                    LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                    LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                    LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                    LEFT OUTER JOIN ap_risk AS e ON e.id = bc.risk1
                    LEFT OUTER JOIN ap_users AS au ON ap.user_n = au.user_id
                    LEFT OUTER JOIN ap_users AS audit ON bc.assigned_audit = audit.user_id
                    WHERE bc.is_deleted = '0' AND bc.is_approved = '1' AND bc.company = '$company'
                    GROUP BY bc.bc_code
                    ORDER BY bc.bc_code";

            $result = $this->db->query($stmt);
            #echo "<pre>"; echo $stmt; exit;

        return $result->result_array();
    }

    //List of all for approval of Audit Action Plan
    public function getThisEntryforApprovalOfAction($company) {

            $stmt = "SELECT ap.id,ap.code,ap.action_plan, b.name AS company_name,b.code AS company_code, DATE(ap.entered_date) AS entered_date,
                    DATE(ap.ap_due_date) AS due_date, DATE(ap.ap_date_implemented) AS date_implemented,
                    DATE(ap.ap_date_revised) AS date_revised, CONCAT(apemp.last_name,', ',apemp.first_name,' ',SUBSTR(apemp.middle_name,1,1),'. ')AS fullnameAPI,
                    apdept.name AS departAPI, CONCAT(apemp2.last_name,', ',apemp2.first_name,' ',SUBSTR(apemp2.middle_name,1,1),'. ')AS fullnameAPII,
                    apdept2.name AS departAPII,ap.user_n,au.username AS audit_name
                    FROM ap_entry AS ap
                    LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                    LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                    LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                    LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                    LEFT OUTER JOIN hr_companies AS b ON b.id = ap.company
                    LEFT OUTER JOIN ap_users AS au ON ap.user_n = au.user_id
                    WHERE ap.is_deleted = '0' AND ap.is_approved = '1' AND ap.company = '$company'
                    GROUP BY ap.id
                    ORDER BY ap.entered_date";

            $result = $this->db->query($stmt);
            #echo "<pre>"; echo $stmt; exit;

        return $result->result_array();
    }

    public function savenewbusinessconcern($data) {

        $data['duplicate_n']  = $this->session->userdata('sess_user_id');
        $data['duplicate_d'] = DATE('Y-m-d h:i:s');
        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = "A";

        $data['is_approved'] = 1;
        $this->db->insert('bc_entry', $data);
        #print_r2($data); exit;

        //Add Existing action Plan to this BC
        $company = $this->session->userdata('sess_company_id');
        $datax['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $datax['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $datax['code'] = $this->input->post('code');
        $datax['bc_code'] = $this->input->post('bc_code');
        $datax['action_plan'] = $this->input->post('action_plan');
        $datax['ap_dept'] = $this->input->post('ap_dept');
        $ap_dept_2 = $this->input->post('ap_dept_2');
        if (!empty($ap_dept_2)) {
           $datax['ap_dept_2'] = $ap_dept_2;
        }   else {
           $datax['ap_dept_2'] = null;
            }

        $datax['ap_emp'] = $this->input->post('ap_emp');

        $ap_emp_2 = $this->input->post('ap_emp_2');
        if (!empty($ap_emp_2)) {
           $datax['ap_emp_2'] = $ap_emp_2;
        }   else {
           $datax['ap_emp_2'] = null;
            }

        $datax['ap_impact_remarks'] = $this->input->post('ap_impact_remarks');
        $datax['ap_status'] = $this->input->post('ap_status');
        $datax['ap_assigned_audit'] = $this->input->post('ap_assigned_audit');
        $datax['ap_project_id'] = $this->input->post('ap_project_id');
        $ap_impact_value = $this->input->post('ap_impact_value');
        if (!empty($ap_impact_value)) {
           $datax['ap_impact_value'] = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
        }   else {
           $datax['ap_impact_value'] = null;
            }
        $ap_date_tag = $this->input->post('ap_date_tag');
        if (!empty($ap_date_tag)) {
           $datax['ap_date_tag'] = date('Y-m-d', strtotime($ap_date_tag));
        }   else {
           $datax['ap_date_tag'] = null;
            }
        $ap_due_date = $this->input->post('ap_due_date');
        if (!empty($ap_due_date)) {
           $datax['ap_due_date'] = date('Y-m-d', strtotime($ap_due_date));
        }   else {
           $datax['ap_due_date'] = null;
            }
        $ap_date_revised = $this->input->post('ap_date_revised');
        if (!empty($ap_date_revised)) {
           $datax['ap_date_revised'] = date('Y-m-d', strtotime($ap_date_revised));
        }   else {
           $datax['ap_date_revised'] = null;
            }
        $ap_date_implemented = $this->input->post('ap_date_implemented');
        if (!empty($ap_date_implemented)) {
           $datax['ap_date_implemented'] = date('Y-m-d', strtotime($ap_date_implemented));
        }   else {
           $datax['ap_date_implemented'] = null;
            }

        $datax['duplicatefrom'] = $this->input->post('code');
        $datax['duplicate_n']  = $this->session->userdata('sess_user_id');
        $datax['duplicate_d'] = DATE('Y-m-d h:i:s');
        $datax['user_n']  = $this->session->userdata('sess_user_id');
        $datax['user_d'] = DATE('Y-m-d h:i:s');
        $datax['is_duplicate'] = '1';
        $datax['status'] = "A";

        $datax['is_approved'] = 0;
        $this->db->insert('ap_entry', $datax);

      return true;
    }

    public function savenewadditionalbc($datax) {

        $datax['duplicatefrom'] = $this->input->post('bc_code');
        $datax['duplicate_n']  = $this->session->userdata('sess_user_id');
        $datax['duplicate_d'] = DATE('Y-m-d h:i:s');
        $datax['user_n']  = $this->session->userdata('sess_user_id');
        $datax['user_d'] = DATE('Y-m-d h:i:s');
        $datax['is_duplicate'] = '1';
        $datax['status'] = "A";

        $datax['is_approved'] = 0;
        $this->db->insert('bc_entry', $datax);

        //New Action Plan Duplicate
        $company = $this->session->userdata('sess_company_id');
        $code = $this->input->post('myCodeExist');
        $code2 = $this->input->post('myCodeExist_2');
        $code3 = $this->input->post('myCodeExist_3');
        $datax['bc_code'] = $bc_code;
        $bc_code = $this->input->post('bc_code');


          if (!empty($code) && !empty($code2) && !empty($code3)) {

              //New Action Plan Duplicate
              $company = $this->session->userdata('sess_company_id');
              $code3 = $this->input->post('myCodeExist_3');
              $datax['bc_code'] = $bc_code;
              $bc_code = $this->input->post('bc_code');

              //New BC and New Ap with Existing AP
              $stmt_insert3 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted)
                              SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted
                              FROM ap_entry
                              WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code3'  
                              AND is_duplicate = '0' AND company = '$company'";

              $this->db->query($stmt_insert3);

              $id = $this->db->insert_id();

              $updatedData3['duplicatefrom'] = $this->input->post('myCodeExist_3');
              $updatedData3['duplicate_n']  = $this->session->userdata('sess_user_id');
              $updatedData3['duplicate_d'] = DATE('Y-m-d h:i:s');
              $updatedData3['user_n']  = $this->session->userdata('sess_user_id');
              $updatedData3['user_d'] = DATE('Y-m-d h:i:s');
              $updatedData3['is_duplicate'] = 1;
              $updatedData3['status'] = "A";
              $updatedData3['bc_code'] = $bc_code;
              $this->db->where('id', $id);
              $this->db->update('ap_entry', $updatedData3);

              //New Action Plan Duplicate
              $company = $this->session->userdata('sess_company_id');
              $code2 = $this->input->post('myCodeExist_2');
              $datax['bc_code'] = $bc_code;
              $bc_code = $this->input->post('bc_code');

              //New BC and New Ap with Existing AP
              $stmt_insert2 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted)
                              SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted
                              FROM ap_entry
                              WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code2'  
                              AND is_duplicate = '0' AND company = '$company'";

              $this->db->query($stmt_insert2);

              $id = $this->db->insert_id();

              $updatedData2['duplicatefrom'] = $this->input->post('myCodeExist_2');
              $updatedData2['duplicate_n']  = $this->session->userdata('sess_user_id');
              $updatedData2['duplicate_d'] = DATE('Y-m-d h:i:s');
              $updatedData2['user_n']  = $this->session->userdata('sess_user_id');
              $updatedData2['user_d'] = DATE('Y-m-d h:i:s');
              $updatedData2['is_duplicate'] = 1;
              $updatedData2['status'] = "A";
              $updatedData2['bc_code'] = $bc_code;
              $this->db->where('id', $id);
              $this->db->update('ap_entry', $updatedData2);

              //New BC and New Ap with Existing AP
              $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted)
                              SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                              ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                              ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                              is_deleted
                              FROM ap_entry
                              WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                              AND is_duplicate = '0' AND company = '$company'";

              $this->db->query($stmt_insert);

              $id = $this->db->insert_id();

              $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
              $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
              $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
              $updatedData['user_n']  = $this->session->userdata('sess_user_id');
              $updatedData['user_d'] = DATE('Y-m-d h:i:s');
              $updatedData['is_duplicate'] = 1;
              $updatedData['status'] = "A";
              $updatedData['bc_code'] = $bc_code;
              $this->db->where('id', $id);
              $this->db->update('ap_entry', $updatedData);

              #print_r2($updatedData); exit;

              //Action Plan
              $user_n  = $this->session->userdata('sess_user_id');
              $user_d = DATE('Y-m-d h:i:s');
              $status = "FA";
              $company = $this->session->userdata('sess_company_id');
              $bc_code = $this->input->post('bc_code');
              $is_approved = 1;

              $code = $_POST['book']['code'][0];
              $action_plan = $_POST['book']['action_plan'][0];
              $ap_emp = $_POST['book']['ap_emp'][0];

              $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
              if (!empty($ap_emp_2)) {
                  $ap_emp_2 = $ap_emp_2;
              } else {
                  $ap_emp_2 = null;
              }

              $ap_dept = $_POST['book']['ap_dept'][0];

              $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
              if (!empty($ap_dept_2)) {
                  $ap_dept_2 = $ap_dept_2;
              } else {
                  $ap_dept_2 = null;
              }

              $ap_status1 = $_POST['book']['ap_status'][0];
              $ap_status2x = $_POST['book']['ap_status2'][0];
              if (!empty($ap_status1)) {
                  $ap_status1 = $ap_status1;
              } else {
                  $ap_status1 = $ap_status2x;
              }


              $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
              $ap_project_id = $_POST['book']['ap_project_id'][0];

              $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
              if (!empty($ap_impact_remarks)) {
                  $ap_impact_remarks0 = $ap_impact_remarks;
              } else {
                  $ap_impact_remarks0 = null;
              }
              $ap_impact_value = $_POST['book']['ap_impact_value'][0];
              if (!empty($ap_impact_value)) {
                  $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
              } else {
                  $ap_impact_value0 = null;
              }
              $ap_date_tag = $_POST['book']['ap_date_tag'][0];
              if (!empty($ap_date_tag)) {
                  $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
              } else {
                  $ap_date_tag0 = null;
              }
              $ap_due_date = $_POST['book']['ap_due_date'][0];
              if (!empty($ap_due_date)) {
                  $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
              } else {
                  $ap_due_date0 = null;
              }
              $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
              if (!empty($ap_date_implemented)) {
                  $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
              } else {
                  $ap_date_implemented0 = null;
              }
              $entered_date = $_POST['book']['entered_date'][0];
              if (!empty($entered_date)) {
                  $entered_date0 = date('Y-m-d', strtotime($entered_date));
              } else {
                  $entered_date0 = null;
              }

              $code2 = $_POST['book']['code'][1];
              if (!empty($code2)) {
                  $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code2 = null;
              }

              $action_plan2 = $_POST['book']['action_plan'][1];
              $ap_emp2 = $_POST['book']['ap_emp'][1];
              $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
              if (!empty($ap_emp_22)) {
                  $ap_emp_22 = $ap_emp_22;
              } else {
                  $ap_emp_22 = null;
              }

              $ap_dept2 = $_POST['book']['ap_dept'][1];
              $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
              if (!empty($ap_dept_22)) {
                  $ap_dept_22 = $ap_dept_22;
              } else {
                  $ap_dept_22 = null;
              }

              $ap_status_x1 = $_POST['book']['ap_status'][1];
              $ap_status_xx1 = $_POST['book']['ap_status'][1];
              if (!empty($ap_status_x1)) {
                  $ap_status_x1 = $ap_status_x1;
              } else {
                  $ap_status_x1 = $ap_status_xx1;
              }

              $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
              $ap_project_id2 = $_POST['book']['ap_project_id'][1];
              $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
              if (!empty($ap_impact_remarks2)) {
                  $ap_impact_remarks2x = $ap_impact_remarks2;
              } else {
                  $ap_impact_remarks2x = null;
              }
              $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
              if (!empty($ap_impact_value2)) {
                  $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
              } else {
                  $ap_impact_value2x = null;
              }
              $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
              if (!empty($ap_date_tag2)) {
                  $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
              } else {
                  $ap_date_tag2x= null;
              }
              $ap_due_date2 = $_POST['book']['ap_due_date'][1];
              if (!empty($ap_due_date2)) {
                  $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
              } else {
                  $ap_due_date2x = null;
              }
              $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
              if (!empty($ap_date_implemented2)) {
                  $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
              } else {
                  $ap_date_implemented2x = null;
              }
              $entered_date2 = $_POST['book']['entered_date'][1];
              if (!empty($entered_date2)) {
                  $entered_date2x = date('Y-m-d', strtotime($entered_date2));
              } else {
                  $entered_date2x = null;
              }

              $code3 = $_POST['book']['code'][2];
              if (!empty($code3)) {
                  $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code3 = null;
              }

              $action_plan3 = $_POST['book']['action_plan'][2];
              $ap_emp3 = $_POST['book']['ap_emp'][2];
              $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
              if (!empty($ap_emp_23)) {
                  $ap_emp_23 = $ap_emp_23;
              } else {
                  $ap_emp_23 = null;
              }
              $ap_dept3 = $_POST['book']['ap_dept'][2];
              $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
              if (!empty($ap_dept_23)) {
                  $ap_dept_23 = $ap_dept_23;
              } else {
                  $ap_dept_23 = null;
              }

              $ap_status_x2 = $_POST['book']['ap_status'][2];
              $ap_status_xx2 = $_POST['book']['ap_status'][2];
              if (!empty($ap_status_x2)) {
                  $ap_status_x2 = $ap_status_x2;
              } else {
                  $ap_status_x2 = $ap_status_xx2;
              }

              $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
              $ap_project_id3 = $_POST['book']['ap_project_id'][2];
              $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
              if (!empty($ap_impact_remarks3)) {
                  $ap_impact_remarks3x = $ap_impact_remarks3;
              } else {
                  $ap_impact_remarks3x = null;
              }
              $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
              if (!empty($ap_impact_value3)) {
                  $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
              } else {
                  $ap_impact_value3x = null;
              }
              $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
              if (!empty($ap_date_tag3)) {
                  $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
              } else {
                  $ap_date_tag3x = null;
              }
              $ap_due_date3 = $_POST['book']['ap_due_date'][2];
              if (!empty($ap_due_date3)) {
                  $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
              } else {
                  $ap_due_date3x = null;
              }
              $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
              if (!empty($ap_date_implemented3)) {
                  $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
              } else {
                  $ap_date_implemented3x = null;
              }
              $entered_date3 = $_POST['book']['entered_date'][2];
              if (!empty($entered_date3)) {
                  $entered_date3x = date('Y-m-d', strtotime($entered_date3));
              } else {
                  $entered_date3x = null;
              }
              $code4 = $_POST['book']['code'][3];
              if (!empty($code4)) {
                  $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code4 = null;
              }

              $action_plan4 = $_POST['book']['action_plan'][3];
              $ap_emp4 = $_POST['book']['ap_emp'][3];
              $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
              if (!empty($ap_emp_24)) {
                  $ap_emp_24 = $ap_emp_24;
              } else {
                  $ap_emp_24 = null;
              }
              
              $ap_dept4 = $_POST['book']['ap_dept'][3];
              $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
              if (!empty($ap_dept_24)) {
                  $ap_dept_24 = $ap_dept_24;
              } else {
                  $ap_dept_24 = null;
              }
              
              $ap_status_x3 = $_POST['book']['ap_status'][3];
              $ap_status_xx3 = $_POST['book']['ap_status'][3];
              if (!empty($ap_status_x3)) {
                  $ap_status_x3 = $ap_status_x3;
              } else {
                  $ap_status_x3 = $ap_status_xx3;
              }

              $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
              $ap_project_id4 = $_POST['book']['ap_project_id'][3];
              $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
              if (!empty($ap_impact_remarks4)) {
                  $ap_impact_remarks4x = $ap_impact_remarks4;
              } else {
                  $ap_impact_remarks4x = null;
              }
              $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
              if (!empty($ap_impact_value4)) {
                  $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
              } else {
                  $ap_impact_value4x = null;
              }
              $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
              if (!empty($ap_date_tag4)) {
                  $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
              } else {
                  $ap_date_tag4x = null;
              }
              $ap_due_date4 = $_POST['book']['ap_due_date'][3];
              if (!empty($ap_due_date4)) {
                  $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
              } else {
                  $ap_due_date4x = null;
              }
              $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
              if (!empty($ap_date_implemented4)) {
                  $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
              } else {
                  $ap_date_implemented4x = null;
              }
              $entered_date4 = $_POST['book']['entered_date'][3];
              if (!empty($entered_date4)) {
                  $entered_date4x = date('Y-m-d', strtotime($entered_date4));
              } else {
                  $entered_date4x = null;
              }
              $code5 = $_POST['book']['code'][4];
              if (!empty($code5)) {
                  $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code5 = null;
              }

              $action_plan5 = $_POST['book']['action_plan'][4];
              $ap_emp5 = $_POST['book']['ap_emp'][4];
              $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
              if (!empty($ap_emp_25)) {
                  $ap_emp_25 = $ap_emp_25;
              } else {
                  $ap_emp_25 = null;
              }

              $ap_dept5 = $_POST['book']['ap_dept'][4];
              $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
              if (!empty($ap_dept_25)) {
                  $ap_dept_25 = $ap_dept_25;
              } else {
                  $ap_dept_25 = null;
              }

              $ap_status_x4 = $_POST['book']['ap_status'][4];
              $ap_status_xx4 = $_POST['book']['ap_status'][4];
              if (!empty($ap_status_x4)) {
                  $ap_status_x4 = $ap_status_xx4;
              } else {
                  $ap_status_x4 = $ap_status_xx4;
              }

              $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
              $ap_project_id5 = $_POST['book']['ap_project_id'][4];
              $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
              if (!empty($ap_impact_remarks5)) {
                  $ap_impact_remarks5x = $ap_impact_remarks5;
              } else {
                  $ap_impact_remarks5x = null;
              }
              $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
              if (!empty($ap_impact_value5)) {
                  $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
              } else {
                  $ap_impact_value5x = null;
              }
              $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
              if (!empty($ap_date_tag5)) {
                  $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
              } else {
                  $ap_date_tag5x = null;
              }
              $ap_due_date5 = $_POST['book']['ap_due_date'][4];
              if (!empty($ap_due_date5)) {
                  $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
              } else {
                  $ap_due_date5x = null;
              }
              $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
              if (!empty($ap_date_implemented5)) {
                  $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
              } else {
                  $ap_date_implemented5x = null;
              }
              $entered_date5 = $_POST['book']['entered_date'][4];
              if (!empty($entered_date5)) {
                  $entered_date5x = date('Y-m-d', strtotime($entered_date5));
              } else {
                  $entered_date5x = null;
              }

              if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_impact_value' =>  $ap_impact_value0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        )
                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }

              else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }

              else if ($code4 == "" && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code3,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan3,
                            'ap_emp' => $ap_emp3,
                            'ap_emp_2' => $ap_emp_23,
                            'ap_dept' => $ap_dept3,
                            'ap_dept_2' => $ap_dept_23,
                            'ap_status' => $ap_status_x2,
                            'ap_assigned_audit' => $ap_assigned_audit3,
                            'ap_project_id' => $ap_project_id3,
                            'ap_impact_value' => $ap_impact_value3x,
                            'ap_impact_remarks' => $ap_impact_remarks3x,
                            'ap_date_tag' => $ap_date_tag3x,
                            'ap_due_date' => $ap_due_date3x,
                            'ap_date_implemented' => $ap_date_implemented3x,
                            'entered_date' => $entered_date3x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),

                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }
              else if ($code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code3,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan3,
                            'ap_emp' => $ap_emp3,
                            'ap_emp_2' => $ap_emp_23,
                            'ap_dept' => $ap_dept3,
                            'ap_dept_2' => $ap_dept_23,
                            'ap_status' => $ap_status_x2,
                            'ap_assigned_audit' => $ap_assigned_audit3,
                            'ap_project_id' => $ap_project_id3,
                            'ap_impact_value' => $ap_impact_value3x,
                            'ap_impact_remarks' => $ap_impact_remarks3x,
                            'ap_date_tag' => $ap_date_tag3x,
                            'ap_due_date' => $ap_due_date3x,
                            'ap_date_implemented' => $ap_date_implemented3x,
                            'entered_date' => $entered_date3x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code4,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan4,
                            'ap_emp' => $ap_emp4,
                            'ap_emp_2' => $ap_emp_24,
                            'ap_dept' => $ap_dept4,
                            'ap_dept_2' => $ap_dept_24,
                            'ap_status' => $ap_status_x3,
                            'ap_assigned_audit' => $ap_assigned_audit4,
                            'ap_project_id' => $ap_project_id4,
                            'ap_impact_value' => $ap_impact_value4x,
                            'ap_impact_remarks' => $ap_impact_remarks4x,
                            'ap_date_tag' => $ap_date_tag4x,
                            'ap_due_date' => $ap_due_date4x,
                            'ap_date_implemented' => $ap_date_implemented4x,
                            'entered_date' => $entered_date4x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),

                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }

          }

          else if (!empty($code) && !empty($code2)) {

                  //New Action Plan Duplicate
                  $company = $this->session->userdata('sess_company_id');
                  $code2 = $this->input->post('myCodeExist_2');
                  $datax['bc_code'] = $bc_code;
                  $bc_code = $this->input->post('bc_code');

                  //New BC and New Ap with Existing AP
                  $stmt_insert2 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                  ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                  ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                  is_deleted)
                                  SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                  ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                  ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                  is_deleted
                                  FROM ap_entry
                                  WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code2'  
                                  AND is_duplicate = '0' AND company = '$company'";

                  $this->db->query($stmt_insert2);

                  $id = $this->db->insert_id();

                  $updatedData2['duplicatefrom'] = $this->input->post('myCodeExist_2');
                  $updatedData2['duplicate_n']  = $this->session->userdata('sess_user_id');
                  $updatedData2['duplicate_d'] = DATE('Y-m-d h:i:s');
                  $updatedData2['user_n']  = $this->session->userdata('sess_user_id');
                  $updatedData2['user_d'] = DATE('Y-m-d h:i:s');
                  $updatedData2['is_duplicate'] = 1;
                  $updatedData2['status'] = "A";
                  $updatedData2['bc_code'] = $bc_code;
                  $this->db->where('id', $id);
                  $this->db->update('ap_entry', $updatedData2);

                  //New BC and New Ap with Existing AP
                  $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                  ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                  ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                  is_deleted)
                                  SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                  ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                  ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                  is_deleted
                                  FROM ap_entry
                                  WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                  AND is_duplicate = '0' AND company = '$company'";

                  $this->db->query($stmt_insert);

                  $id = $this->db->insert_id();

                  $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                  $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                  $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                  $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                  $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                  $updatedData['is_duplicate'] = 1;
                  $updatedData['status'] = "A";
                  $updatedData['bc_code'] = $bc_code;
                  $this->db->where('id', $id);
                  $this->db->update('ap_entry', $updatedData);

                  #print_r2($updatedData); exit;

                  //Action Plan
                  $user_n  = $this->session->userdata('sess_user_id');
                  $user_d = DATE('Y-m-d h:i:s');
                  $status = "FA";
                  $company = $this->session->userdata('sess_company_id');
                  $bc_code = $this->input->post('bc_code');
                  $is_approved = 1;

                  $code = $_POST['book']['code'][0];
                  $action_plan = $_POST['book']['action_plan'][0];
                  $ap_emp = $_POST['book']['ap_emp'][0];

                  $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                  if (!empty($ap_emp_2)) {
                      $ap_emp_2 = $ap_emp_2;
                  } else {
                      $ap_emp_2 = null;
                  }

                  $ap_dept = $_POST['book']['ap_dept'][0];

                  $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                  if (!empty($ap_dept_2)) {
                      $ap_dept_2 = $ap_dept_2;
                  } else {
                      $ap_dept_2 = null;
                  }

                  $ap_status1 = $_POST['book']['ap_status'][0];
                  $ap_status2x = $_POST['book']['ap_status2'][0];
                  if (!empty($ap_status1)) {
                      $ap_status1 = $ap_status1;
                  } else {
                      $ap_status1 = $ap_status2x;
                  }

                  $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                  $ap_project_id = $_POST['book']['ap_project_id'][0];

                  $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                  if (!empty($ap_impact_remarks)) {
                      $ap_impact_remarks0 = $ap_impact_remarks;
                  } else {
                      $ap_impact_remarks0 = null;
                  }
                  $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                  if (!empty($ap_impact_value)) {
                      $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                  } else {
                      $ap_impact_value0 = null;
                  }
                  $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                  if (!empty($ap_date_tag)) {
                      $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                  } else {
                      $ap_date_tag0 = null;
                  }
                  $ap_due_date = $_POST['book']['ap_due_date'][0];
                  if (!empty($ap_due_date)) {
                      $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                  } else {
                      $ap_due_date0 = null;
                  }
                  $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                  if (!empty($ap_date_implemented)) {
                      $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                  } else {
                      $ap_date_implemented0 = null;
                  }
                  $entered_date = $_POST['book']['entered_date'][0];
                  if (!empty($entered_date)) {
                      $entered_date0 = date('Y-m-d', strtotime($entered_date));
                  } else {
                      $entered_date0 = null;
                  }

                  $code2 = $_POST['book']['code'][1];
                  if (!empty($code2)) {
                      $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                  } else {
                      $code2 = null;
                  }

                  $action_plan2 = $_POST['book']['action_plan'][1];
                  $ap_emp2 = $_POST['book']['ap_emp'][1];
                  $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                  if (!empty($ap_emp_22)) {
                      $ap_emp_22 = $ap_emp_22;
                  } else {
                      $ap_emp_22 = null;
                  }

                  $ap_dept2 = $_POST['book']['ap_dept'][1];
                  $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                  if (!empty($ap_dept_22)) {
                      $ap_dept_22 = $ap_dept_22;
                  } else {
                      $ap_dept_22 = null;
                  }

                  $ap_status_x1 = $_POST['book']['ap_status'][1];
                  $ap_status_xx1 = $_POST['book']['ap_status'][1];
                  if (!empty($ap_status_x1)) {
                      $ap_status_x1 = $ap_status_x1;
                  } else {
                      $ap_status_x1 = $ap_status_xx1;
                  }

                  $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                  $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                  $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                  if (!empty($ap_impact_remarks2)) {
                      $ap_impact_remarks2x = $ap_impact_remarks2;
                  } else {
                      $ap_impact_remarks2x = null;
                  }
                  $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                  if (!empty($ap_impact_value2)) {
                      $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                  } else {
                      $ap_impact_value2x = null;
                  }
                  $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                  if (!empty($ap_date_tag2)) {
                      $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                  } else {
                      $ap_date_tag2x= null;
                  }
                  $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                  if (!empty($ap_due_date2)) {
                      $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                  } else {
                      $ap_due_date2x = null;
                  }
                  $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                  if (!empty($ap_date_implemented2)) {
                      $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                  } else {
                      $ap_date_implemented2x = null;
                  }
                  $entered_date2 = $_POST['book']['entered_date'][1];
                  if (!empty($entered_date2)) {
                      $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                  } else {
                      $entered_date2x = null;
                  }

                  $code3 = $_POST['book']['code'][2];
                  if (!empty($code3)) {
                      $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                  } else {
                      $code3 = null;
                  }

                  $action_plan3 = $_POST['book']['action_plan'][2];
                  $ap_emp3 = $_POST['book']['ap_emp'][2];
                  $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                  if (!empty($ap_emp_23)) {
                      $ap_emp_23 = $ap_emp_23;
                  } else {
                      $ap_emp_23 = null;
                  }
                  $ap_dept3 = $_POST['book']['ap_dept'][2];
                  $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                  if (!empty($ap_dept_23)) {
                      $ap_dept_23 = $ap_dept_23;
                  } else {
                      $ap_dept_23 = null;
                  }

                  $ap_status_x2 = $_POST['book']['ap_status'][2];
                  $ap_status_xx2 = $_POST['book']['ap_status'][2];
                  if (!empty($ap_status_x2)) {
                      $ap_status_x2 = $ap_status_x2;
                  } else {
                      $ap_status_x2 = $ap_status_xx2;
                  }

                  $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                  $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                  $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                  if (!empty($ap_impact_remarks3)) {
                      $ap_impact_remarks3x = $ap_impact_remarks3;
                  } else {
                      $ap_impact_remarks3x = null;
                  }
                  $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                  if (!empty($ap_impact_value3)) {
                      $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                  } else {
                      $ap_impact_value3x = null;
                  }
                  $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                  if (!empty($ap_date_tag3)) {
                      $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                  } else {
                      $ap_date_tag3x = null;
                  }
                  $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                  if (!empty($ap_due_date3)) {
                      $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                  } else {
                      $ap_due_date3x = null;
                  }
                  $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                  if (!empty($ap_date_implemented3)) {
                      $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                  } else {
                      $ap_date_implemented3x = null;
                  }
                  $entered_date3 = $_POST['book']['entered_date'][2];
                  if (!empty($entered_date3)) {
                      $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                  } else {
                      $entered_date3x = null;
                  }
                  $code4 = $_POST['book']['code'][3];
                  if (!empty($code4)) {
                      $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                  } else {
                      $code4 = null;
                  }

                  $action_plan4 = $_POST['book']['action_plan'][3];
                  $ap_emp4 = $_POST['book']['ap_emp'][3];
                  $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                  if (!empty($ap_emp_24)) {
                      $ap_emp_24 = $ap_emp_24;
                  } else {
                      $ap_emp_24 = null;
                  }
                  
                  $ap_dept4 = $_POST['book']['ap_dept'][3];
                  $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                  if (!empty($ap_dept_24)) {
                      $ap_dept_24 = $ap_dept_24;
                  } else {
                      $ap_dept_24 = null;
                  }
                  
                  $ap_status_x3 = $_POST['book']['ap_status'][3];
                  $ap_status_xx3 = $_POST['book']['ap_status'][3];
                  if (!empty($ap_status_x3)) {
                      $ap_status_x3 = $ap_status_x3;
                  } else {
                      $ap_status_x3 = $ap_status_xx3;
                  }

                  $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                  $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                  $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                  if (!empty($ap_impact_remarks4)) {
                      $ap_impact_remarks4x = $ap_impact_remarks4;
                  } else {
                      $ap_impact_remarks4x = null;
                  }
                  $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                  if (!empty($ap_impact_value4)) {
                      $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                  } else {
                      $ap_impact_value4x = null;
                  }
                  $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                  if (!empty($ap_date_tag4)) {
                      $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                  } else {
                      $ap_date_tag4x = null;
                  }
                  $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                  if (!empty($ap_due_date4)) {
                      $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                  } else {
                      $ap_due_date4x = null;
                  }
                  $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                  if (!empty($ap_date_implemented4)) {
                      $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                  } else {
                      $ap_date_implemented4x = null;
                  }
                  $entered_date4 = $_POST['book']['entered_date'][3];
                  if (!empty($entered_date4)) {
                      $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                  } else {
                      $entered_date4x = null;
                  }
                  $code5 = $_POST['book']['code'][4];
                  if (!empty($code5)) {
                      $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                  } else {
                      $code5 = null;
                  }

                  $action_plan5 = $_POST['book']['action_plan'][4];
                  $ap_emp5 = $_POST['book']['ap_emp'][4];
                  $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                  if (!empty($ap_emp_25)) {
                      $ap_emp_25 = $ap_emp_25;
                  } else {
                      $ap_emp_25 = null;
                  }

                  $ap_dept5 = $_POST['book']['ap_dept'][4];
                  $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                  if (!empty($ap_dept_25)) {
                      $ap_dept_25 = $ap_dept_25;
                  } else {
                      $ap_dept_25 = null;
                  }

                  $ap_status_x4 = $_POST['book']['ap_status'][4];
                  $ap_status_xx4 = $_POST['book']['ap_status'][4];
                  if (!empty($ap_status_x4)) {
                      $ap_status_x4 = $ap_status_xx4;
                  } else {
                      $ap_status_x4 = $ap_status_xx4;
                  }

                  $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                  $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                  $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                  if (!empty($ap_impact_remarks5)) {
                      $ap_impact_remarks5x = $ap_impact_remarks5;
                  } else {
                      $ap_impact_remarks5x = null;
                  }
                  $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                  if (!empty($ap_impact_value5)) {
                      $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                  } else {
                      $ap_impact_value5x = null;
                  }
                  $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                  if (!empty($ap_date_tag5)) {
                      $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                  } else {
                      $ap_date_tag5x = null;
                  }
                  $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                  if (!empty($ap_due_date5)) {
                      $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                  } else {
                      $ap_due_date5x = null;
                  }
                  $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                  if (!empty($ap_date_implemented5)) {
                      $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                  } else {
                      $ap_date_implemented5x = null;
                  }
                  $entered_date5 = $_POST['book']['entered_date'][4];
                  if (!empty($entered_date5)) {
                      $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                  } else {
                      $entered_date5x = null;
                  }

                  if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                    {
                        $insertdatax = array(
                            array(
                                'code' => $code,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan,
                                'ap_emp' => $ap_emp,
                                'ap_emp_2' => $ap_emp_2,
                                'ap_dept' => $ap_dept,
                                'ap_dept_2' => $ap_dept_2,
                                'ap_status' => $ap_status1,
                                'ap_assigned_audit' => $ap_assigned_audit,
                                'ap_project_id' => $ap_project_id,
                                'ap_impact_remarks' => $ap_impact_remarks0,
                                'ap_impact_value' =>  $ap_impact_value0,
                                'ap_date_tag' => $ap_date_tag0,
                                'ap_due_date' => $ap_due_date0,
                                'ap_date_implemented' => $ap_date_implemented0,
                                'entered_date' => $entered_date0,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            )
                          );

                        }
                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdatax) ; exit;
                  }

                  else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                    {
                        $insertdatax = array(
                            array(
                                'code' => $code,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan,
                                'ap_emp' => $ap_emp,
                                'ap_emp_2' => $ap_emp_2,
                                'ap_dept' => $ap_dept,
                                'ap_dept_2' => $ap_dept_2,
                                'ap_status' => $ap_status1,
                                'ap_assigned_audit' => $ap_assigned_audit,
                                'ap_project_id' => $ap_project_id,
                                'ap_impact_value' => $ap_impact_value0,
                                'ap_impact_remarks' => $ap_impact_remarks0,
                                'ap_date_tag' => $ap_date_tag0,
                                'ap_due_date' => $ap_due_date0,
                                'ap_date_implemented' => $ap_date_implemented0,
                                'entered_date' => $entered_date0,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code2,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan2,
                                'ap_emp' => $ap_emp2,
                                'ap_emp_2' => $ap_emp_22,
                                'ap_dept' => $ap_dept2,
                                'ap_dept_2' => $ap_dept_22,
                                'ap_status' => $ap_status_x1,
                                'ap_assigned_audit' => $ap_assigned_audit2,
                                'ap_project_id' => $ap_project_id2,
                                'ap_impact_value' => $ap_impact_value2x,
                                'ap_impact_remarks' => $ap_impact_remarks2x,
                                'ap_date_tag' => $ap_date_tag2x,
                                'ap_due_date' => $ap_due_date2x,
                                'ap_date_implemented' => $ap_date_implemented2x,
                                'entered_date' => $entered_date2x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                          );

                        }
                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdatax) ; exit;
                  }

                  else if ($code4 == "" && $code5 == "") {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                    {
                        $insertdatax = array(
                            array(
                                'code' => $code,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan,
                                'ap_emp' => $ap_emp,
                                'ap_emp_2' => $ap_emp_2,
                                'ap_dept' => $ap_dept,
                                'ap_dept_2' => $ap_dept_2,
                                'ap_status' => $ap_status1,
                                'ap_assigned_audit' => $ap_assigned_audit,
                                'ap_project_id' => $ap_project_id,
                                'ap_impact_value' => $ap_impact_value0,
                                'ap_impact_remarks' => $ap_impact_remarks0,
                                'ap_date_tag' => $ap_date_tag0,
                                'ap_due_date' => $ap_due_date0,
                                'ap_date_implemented' => $ap_date_implemented0,
                                'entered_date' => $entered_date0,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code2,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan2,
                                'ap_emp' => $ap_emp2,
                                'ap_emp_2' => $ap_emp_22,
                                'ap_dept' => $ap_dept2,
                                'ap_dept_2' => $ap_dept_22,
                                'ap_status' => $ap_status_x1,
                                'ap_assigned_audit' => $ap_assigned_audit2,
                                'ap_project_id' => $ap_project_id2,
                                'ap_impact_value' => $ap_impact_value2x,
                                'ap_impact_remarks' => $ap_impact_remarks2x,
                                'ap_date_tag' => $ap_date_tag2x,
                                'ap_due_date' => $ap_due_date2x,
                                'ap_date_implemented' => $ap_date_implemented2x,
                                'entered_date' => $entered_date2x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code3,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan3,
                                'ap_emp' => $ap_emp3,
                                'ap_emp_2' => $ap_emp_23,
                                'ap_dept' => $ap_dept3,
                                'ap_dept_2' => $ap_dept_23,
                                'ap_status' => $ap_status_x2,
                                'ap_assigned_audit' => $ap_assigned_audit3,
                                'ap_project_id' => $ap_project_id3,
                                'ap_impact_value' => $ap_impact_value3x,
                                'ap_impact_remarks' => $ap_impact_remarks3x,
                                'ap_date_tag' => $ap_date_tag3x,
                                'ap_due_date' => $ap_due_date3x,
                                'ap_date_implemented' => $ap_date_implemented3x,
                                'entered_date' => $entered_date3x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),

                          );

                        }
                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdatax) ; exit;
                  }
                  else if ($code5 == "") {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                    {
                        $insertdatax = array(
                            array(
                                'code' => $code,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan,
                                'ap_emp' => $ap_emp,
                                'ap_emp_2' => $ap_emp_2,
                                'ap_dept' => $ap_dept,
                                'ap_dept_2' => $ap_dept_2,
                                'ap_status' => $ap_status1,
                                'ap_assigned_audit' => $ap_assigned_audit,
                                'ap_project_id' => $ap_project_id,
                                'ap_impact_value' => $ap_impact_value0,
                                'ap_impact_remarks' => $ap_impact_remarks0,
                                'ap_date_tag' => $ap_date_tag0,
                                'ap_due_date' => $ap_due_date0,
                                'ap_date_implemented' => $ap_date_implemented0,
                                'entered_date' => $entered_date0,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code2,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan2,
                                'ap_emp' => $ap_emp2,
                                'ap_emp_2' => $ap_emp_22,
                                'ap_dept' => $ap_dept2,
                                'ap_dept_2' => $ap_dept_22,
                                'ap_status' => $ap_status_x1,
                                'ap_assigned_audit' => $ap_assigned_audit2,
                                'ap_project_id' => $ap_project_id2,
                                'ap_impact_value' => $ap_impact_value2x,
                                'ap_impact_remarks' => $ap_impact_remarks2x,
                                'ap_date_tag' => $ap_date_tag2x,
                                'ap_due_date' => $ap_due_date2x,
                                'ap_date_implemented' => $ap_date_implemented2x,
                                'entered_date' => $entered_date2x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code3,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan3,
                                'ap_emp' => $ap_emp3,
                                'ap_emp_2' => $ap_emp_23,
                                'ap_dept' => $ap_dept3,
                                'ap_dept_2' => $ap_dept_23,
                                'ap_status' => $ap_status_x2,
                                'ap_assigned_audit' => $ap_assigned_audit3,
                                'ap_project_id' => $ap_project_id3,
                                'ap_impact_value' => $ap_impact_value3x,
                                'ap_impact_remarks' => $ap_impact_remarks3x,
                                'ap_date_tag' => $ap_date_tag3x,
                                'ap_due_date' => $ap_due_date3x,
                                'ap_date_implemented' => $ap_date_implemented3x,
                                'entered_date' => $entered_date3x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),
                            array(
                                'code' => $code4,
                                'bc_code' => $bc_code,
                                'action_plan' => $action_plan4,
                                'ap_emp' => $ap_emp4,
                                'ap_emp_2' => $ap_emp_24,
                                'ap_dept' => $ap_dept4,
                                'ap_dept_2' => $ap_dept_24,
                                'ap_status' => $ap_status_x3,
                                'ap_assigned_audit' => $ap_assigned_audit4,
                                'ap_project_id' => $ap_project_id4,
                                'ap_impact_value' => $ap_impact_value4x,
                                'ap_impact_remarks' => $ap_impact_remarks4x,
                                'ap_date_tag' => $ap_date_tag4x,
                                'ap_due_date' => $ap_due_date4x,
                                'ap_date_implemented' => $ap_date_implemented4x,
                                'entered_date' => $entered_date4x,
                                'user_n' => $user_n,
                                'user_d' => $user_d,
                                'company' => $company,
                                'status' => $status,
                                'is_approved' => "1"
                            ),

                          );

                        }
                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdatax) ; exit;
                  } else {
                      $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                      foreach ($insertdatax as $insertdatax)
                          {
                                $insertdatax = array(
                                    array(
                                        'code' => $code,
                                        'bc_code' => $bc_code,
                                        'action_plan' => $action_plan,
                                        'ap_emp' => $ap_emp,
                                        'ap_emp_2' => $ap_emp_2,
                                        'ap_dept' => $ap_dept,
                                        'ap_dept_2' => $ap_dept_2,
                                        'ap_status' => $ap_status1,
                                        'ap_assigned_audit' => $ap_assigned_audit,
                                        'ap_project_id' => $ap_project_id,
                                        'ap_impact_value' => $ap_impact_value0,
                                        'ap_impact_remarks' => $ap_impact_remarks0,
                                        'ap_date_tag' => $ap_date_tag0,
                                        'ap_due_date' => $ap_due_date0,
                                        'ap_date_implemented' => $ap_date_implemented0,
                                        'entered_date' => $entered_date0,
                                        'user_n' => $user_n,
                                        'user_d' => $user_d,
                                        'company' => $company,
                                        'status' => $status,
                                        'is_approved' => "1"
                                    ),
                                    array(
                                        'code' => $code2,
                                        'bc_code' => $bc_code,
                                        'action_plan' => $action_plan2,
                                        'ap_emp' => $ap_emp2,
                                        'ap_emp_2' => $ap_emp_22,
                                        'ap_dept' => $ap_dept2,
                                        'ap_dept_2' => $ap_dept_22,
                                        'ap_status' => $ap_status_x1,
                                        'ap_assigned_audit' => $ap_assigned_audit2,
                                        'ap_project_id' => $ap_project_id2,
                                        'ap_impact_value' => $ap_impact_value2x,
                                        'ap_impact_remarks' => $ap_impact_remarks2x,
                                        'ap_date_tag' => $ap_date_tag2x,
                                        'ap_due_date' => $ap_due_date2x,
                                        'ap_date_implemented' => $ap_date_implemented2x,
                                        'entered_date' => $entered_date2x,
                                        'user_n' => $user_n,
                                        'user_d' => $user_d,
                                        'company' => $company,
                                        'status' => $status,
                                        'is_approved' => "1"
                                    ),
                                    array(
                                        'code' => $code3,
                                        'bc_code' => $bc_code,
                                        'action_plan' => $action_plan3,
                                        'ap_emp' => $ap_emp3,
                                        'ap_emp_2' => $ap_emp_23,
                                        'ap_dept' => $ap_dept3,
                                        'ap_dept_2' => $ap_dept_23,
                                        'ap_status' => $ap_status_x2,
                                        'ap_assigned_audit' => $ap_assigned_audit3,
                                        'ap_project_id' => $ap_project_id3,
                                        'ap_impact_value' => $ap_impact_value3x,
                                        'ap_impact_remarks' => $ap_impact_remarks3x,
                                        'ap_date_tag' => $ap_date_tag3x,
                                        'ap_due_date' => $ap_due_date3x,
                                        'ap_date_implemented' => $ap_date_implemented3x,
                                        'entered_date' => $entered_date3x,
                                        'user_n' => $user_n,
                                        'user_d' => $user_d,
                                        'company' => $company,
                                        'status' => $status,
                                        'is_approved' => "1"
                                    ),
                                    array(
                                        'code' => $code4,
                                        'bc_code' => $bc_code,
                                        'action_plan' => $action_plan4,
                                        'ap_emp' => $ap_emp4,
                                        'ap_emp_2' => $ap_emp_24,
                                        'ap_dept' => $ap_dept4,
                                        'ap_dept_2' => $ap_dept_24,
                                        'ap_status' => $ap_status_x3,
                                        'ap_assigned_audit' => $ap_assigned_audit4,
                                        'ap_project_id' => $ap_project_id4,
                                        'ap_impact_value' => $ap_impact_value4x,
                                        'ap_impact_remarks' => $ap_impact_remarks4x,
                                        'ap_date_tag' => $ap_date_tag4x,
                                        'ap_due_date' => $ap_due_date4x,
                                        'ap_date_implemented' => $ap_date_implemented4x,
                                        'entered_date' => $entered_date4x,
                                        'user_n' => $user_n,
                                        'user_d' => $user_d,
                                        'company' => $company,
                                        'status' => $status,
                                        'is_approved' => "1"
                                    ),
                                    array(
                                        'code' => $code5,
                                        'bc_code' => $bc_code,
                                        'action_plan' => $action_plan5,
                                        'ap_emp' => $ap_emp5,
                                        'ap_emp_2' => $ap_emp_25,
                                        'ap_dept' => $ap_dept5,
                                        'ap_dept_2' => $ap_dept_25,
                                        'ap_status' => $ap_status_x4,
                                        'ap_assigned_audit' => $ap_assigned_audit5,
                                        'ap_project_id' => $ap_project_id5,
                                        'ap_impact_value' => $ap_impact_value5x,
                                        'ap_impact_remarks' => $ap_impact_remarks5x,
                                        'ap_date_tag' => $ap_date_tag5x,
                                        'ap_due_date' => $ap_due_date5x,
                                        'ap_date_implemented' => $ap_date_implemented5x,
                                        'entered_date' => $entered_date5x,
                                        'user_n' => $user_n,
                                        'user_d' => $user_d,
                                        'company' => $company,
                                        'status' => $status,
                                        'is_approved' => "1"
                                    ),
                                );
                          }

                          $this->db->insert_batch('ap_entry', $insertdatax);
                          #print_r2($insertdata) ; exit;
                      }

          }

          else if (!empty($code) && !empty($code3)) {

                //New Action Plan Duplicate
                $company = $this->session->userdata('sess_company_id');
                $code3 = $this->input->post('myCodeExist_3');
                $datax['bc_code'] = $bc_code;
                $bc_code = $this->input->post('bc_code');

                //New BC and New Ap with Existing AP
                $stmt_insert3 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code3'  
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert3);

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);

                #print_r2($updatedData); exit;

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }

                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

          }

          else if (!empty($code)) {

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);

                #print_r2($updatedData); exit;

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }

                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

          }

          else {

              //Action Plan
              $user_n  = $this->session->userdata('sess_user_id');
              $user_d = DATE('Y-m-d h:i:s');
              $status = "FA";
              $company = $this->session->userdata('sess_company_id');
              $bc_code = $this->input->post('bc_code');
              $is_approved = 1;

              $code = $_POST['book']['code'][0];
              $action_plan = $_POST['book']['action_plan'][0];
              $ap_emp = $_POST['book']['ap_emp'][0];

              $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
              if (!empty($ap_emp_2)) {
                  $ap_emp_2 = $ap_emp_2;
              } else {
                  $ap_emp_2 = null;
              }

              $ap_dept = $_POST['book']['ap_dept'][0];

              $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
              if (!empty($ap_dept_2)) {
                  $ap_dept_2 = $ap_dept_2;
              } else {
                  $ap_dept_2 = null;
              }

              $ap_status1 = $_POST['book']['ap_status'][0];
              $ap_status2x = $_POST['book']['ap_status2'][0];
              if (!empty($ap_status1)) {
                  $ap_status1 = $ap_status1;
              } else {
                  $ap_status1 = $ap_status2x;
              }


              $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
              $ap_project_id = $_POST['book']['ap_project_id'][0];

              $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
              if (!empty($ap_impact_remarks)) {
                  $ap_impact_remarks0 = $ap_impact_remarks;
              } else {
                  $ap_impact_remarks0 = null;
              }
              $ap_impact_value = $_POST['book']['ap_impact_value'][0];
              if (!empty($ap_impact_value)) {
                  $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
              } else {
                  $ap_impact_value0 = null;
              }
              $ap_date_tag = $_POST['book']['ap_date_tag'][0];
              if (!empty($ap_date_tag)) {
                  $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
              } else {
                  $ap_date_tag0 = null;
              }
              $ap_due_date = $_POST['book']['ap_due_date'][0];
              if (!empty($ap_due_date)) {
                  $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
              } else {
                  $ap_due_date0 = null;
              }
              $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
              if (!empty($ap_date_implemented)) {
                  $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
              } else {
                  $ap_date_implemented0 = null;
              }
              $entered_date = $_POST['book']['entered_date'][0];
              if (!empty($entered_date)) {
                  $entered_date0 = date('Y-m-d', strtotime($entered_date));
              } else {
                  $entered_date0 = null;
              }

              $code2 = $_POST['book']['code'][1];
              if (!empty($code2)) {
                  $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code2 = null;
              }

              $action_plan2 = $_POST['book']['action_plan'][1];
              $ap_emp2 = $_POST['book']['ap_emp'][1];
              $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
              if (!empty($ap_emp_22)) {
                  $ap_emp_22 = $ap_emp_22;
              } else {
                  $ap_emp_22 = null;
              }

              $ap_dept2 = $_POST['book']['ap_dept'][1];
              $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
              if (!empty($ap_dept_22)) {
                  $ap_dept_22 = $ap_dept_22;
              } else {
                  $ap_dept_22 = null;
              }

              $ap_status_x1 = $_POST['book']['ap_status'][1];
              $ap_status_xx1 = $_POST['book']['ap_status'][1];
              if (!empty($ap_status_x1)) {
                  $ap_status_x1 = $ap_status_x1;
              } else {
                  $ap_status_x1 = $ap_status_xx1;
              }

              $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
              $ap_project_id2 = $_POST['book']['ap_project_id'][1];
              $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
              if (!empty($ap_impact_remarks2)) {
                  $ap_impact_remarks2x = $ap_impact_remarks2;
              } else {
                  $ap_impact_remarks2x = null;
              }
              $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
              if (!empty($ap_impact_value2)) {
                  $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
              } else {
                  $ap_impact_value2x = null;
              }
              $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
              if (!empty($ap_date_tag2)) {
                  $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
              } else {
                  $ap_date_tag2x= null;
              }
              $ap_due_date2 = $_POST['book']['ap_due_date'][1];
              if (!empty($ap_due_date2)) {
                  $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
              } else {
                  $ap_due_date2x = null;
              }
              $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
              if (!empty($ap_date_implemented2)) {
                  $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
              } else {
                  $ap_date_implemented2x = null;
              }
              $entered_date2 = $_POST['book']['entered_date'][1];
              if (!empty($entered_date2)) {
                  $entered_date2x = date('Y-m-d', strtotime($entered_date2));
              } else {
                  $entered_date2x = null;
              }

              $code3 = $_POST['book']['code'][2];
              if (!empty($code3)) {
                  $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code3 = null;
              }

              $action_plan3 = $_POST['book']['action_plan'][2];
              $ap_emp3 = $_POST['book']['ap_emp'][2];
              $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
              if (!empty($ap_emp_23)) {
                  $ap_emp_23 = $ap_emp_23;
              } else {
                  $ap_emp_23 = null;
              }
              $ap_dept3 = $_POST['book']['ap_dept'][2];
              $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
              if (!empty($ap_dept_23)) {
                  $ap_dept_23 = $ap_dept_23;
              } else {
                  $ap_dept_23 = null;
              }

              $ap_status_x2 = $_POST['book']['ap_status'][2];
              $ap_status_xx2 = $_POST['book']['ap_status'][2];
              if (!empty($ap_status_x2)) {
                  $ap_status_x2 = $ap_status_x2;
              } else {
                  $ap_status_x2 = $ap_status_xx2;
              }

              $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
              $ap_project_id3 = $_POST['book']['ap_project_id'][2];
              $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
              if (!empty($ap_impact_remarks3)) {
                  $ap_impact_remarks3x = $ap_impact_remarks3;
              } else {
                  $ap_impact_remarks3x = null;
              }
              $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
              if (!empty($ap_impact_value3)) {
                  $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
              } else {
                  $ap_impact_value3x = null;
              }
              $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
              if (!empty($ap_date_tag3)) {
                  $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
              } else {
                  $ap_date_tag3x = null;
              }
              $ap_due_date3 = $_POST['book']['ap_due_date'][2];
              if (!empty($ap_due_date3)) {
                  $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
              } else {
                  $ap_due_date3x = null;
              }
              $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
              if (!empty($ap_date_implemented3)) {
                  $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
              } else {
                  $ap_date_implemented3x = null;
              }
              $entered_date3 = $_POST['book']['entered_date'][2];
              if (!empty($entered_date3)) {
                  $entered_date3x = date('Y-m-d', strtotime($entered_date3));
              } else {
                  $entered_date3x = null;
              }
              $code4 = $_POST['book']['code'][3];
              if (!empty($code4)) {
                  $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code4 = null;
              }

              $action_plan4 = $_POST['book']['action_plan'][3];
              $ap_emp4 = $_POST['book']['ap_emp'][3];
              $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
              if (!empty($ap_emp_24)) {
                  $ap_emp_24 = $ap_emp_24;
              } else {
                  $ap_emp_24 = null;
              }
              
              $ap_dept4 = $_POST['book']['ap_dept'][3];
              $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
              if (!empty($ap_dept_24)) {
                  $ap_dept_24 = $ap_dept_24;
              } else {
                  $ap_dept_24 = null;
              }
              
              $ap_status_x3 = $_POST['book']['ap_status'][3];
              $ap_status_xx3 = $_POST['book']['ap_status'][3];
              if (!empty($ap_status_x3)) {
                  $ap_status_x3 = $ap_status_x3;
              } else {
                  $ap_status_x3 = $ap_status_xx3;
              }

              $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
              $ap_project_id4 = $_POST['book']['ap_project_id'][3];
              $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
              if (!empty($ap_impact_remarks4)) {
                  $ap_impact_remarks4x = $ap_impact_remarks4;
              } else {
                  $ap_impact_remarks4x = null;
              }
              $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
              if (!empty($ap_impact_value4)) {
                  $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
              } else {
                  $ap_impact_value4x = null;
              }
              $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
              if (!empty($ap_date_tag4)) {
                  $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
              } else {
                  $ap_date_tag4x = null;
              }
              $ap_due_date4 = $_POST['book']['ap_due_date'][3];
              if (!empty($ap_due_date4)) {
                  $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
              } else {
                  $ap_due_date4x = null;
              }
              $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
              if (!empty($ap_date_implemented4)) {
                  $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
              } else {
                  $ap_date_implemented4x = null;
              }
              $entered_date4 = $_POST['book']['entered_date'][3];
              if (!empty($entered_date4)) {
                  $entered_date4x = date('Y-m-d', strtotime($entered_date4));
              } else {
                  $entered_date4x = null;
              }
              $code5 = $_POST['book']['code'][4];
              if (!empty($code5)) {
                  $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
              } else {
                  $code5 = null;
              }

              $action_plan5 = $_POST['book']['action_plan'][4];
              $ap_emp5 = $_POST['book']['ap_emp'][4];
              $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
              if (!empty($ap_emp_25)) {
                  $ap_emp_25 = $ap_emp_25;
              } else {
                  $ap_emp_25 = null;
              }

              $ap_dept5 = $_POST['book']['ap_dept'][4];
              $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
              if (!empty($ap_dept_25)) {
                  $ap_dept_25 = $ap_dept_25;
              } else {
                  $ap_dept_25 = null;
              }

              $ap_status_x4 = $_POST['book']['ap_status'][4];
              $ap_status_xx4 = $_POST['book']['ap_status'][4];
              if (!empty($ap_status_x4)) {
                  $ap_status_x4 = $ap_status_xx4;
              } else {
                  $ap_status_x4 = $ap_status_xx4;
              }

              $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
              $ap_project_id5 = $_POST['book']['ap_project_id'][4];
              $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
              if (!empty($ap_impact_remarks5)) {
                  $ap_impact_remarks5x = $ap_impact_remarks5;
              } else {
                  $ap_impact_remarks5x = null;
              }
              $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
              if (!empty($ap_impact_value5)) {
                  $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
              } else {
                  $ap_impact_value5x = null;
              }
              $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
              if (!empty($ap_date_tag5)) {
                  $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
              } else {
                  $ap_date_tag5x = null;
              }
              $ap_due_date5 = $_POST['book']['ap_due_date'][4];
              if (!empty($ap_due_date5)) {
                  $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
              } else {
                  $ap_due_date5x = null;
              }
              $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
              if (!empty($ap_date_implemented5)) {
                  $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
              } else {
                  $ap_date_implemented5x = null;
              }
              $entered_date5 = $_POST['book']['entered_date'][4];
              if (!empty($entered_date5)) {
                  $entered_date5x = date('Y-m-d', strtotime($entered_date5));
              } else {
                  $entered_date5x = null;
              }

              if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_impact_value' =>  $ap_impact_value0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        )
                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }

              else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }

              else if ($code4 == "" && $code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code3,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan3,
                            'ap_emp' => $ap_emp3,
                            'ap_emp_2' => $ap_emp_23,
                            'ap_dept' => $ap_dept3,
                            'ap_dept_2' => $ap_dept_23,
                            'ap_status' => $ap_status_x2,
                            'ap_assigned_audit' => $ap_assigned_audit3,
                            'ap_project_id' => $ap_project_id3,
                            'ap_impact_value' => $ap_impact_value3x,
                            'ap_impact_remarks' => $ap_impact_remarks3x,
                            'ap_date_tag' => $ap_date_tag3x,
                            'ap_due_date' => $ap_due_date3x,
                            'ap_date_implemented' => $ap_date_implemented3x,
                            'entered_date' => $entered_date3x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),

                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              } else if ($code5 == "") {
                $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                foreach ($insertdatax as $insertdatax)
                {
                    $insertdatax = array(
                        array(
                            'code' => $code,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan,
                            'ap_emp' => $ap_emp,
                            'ap_emp_2' => $ap_emp_2,
                            'ap_dept' => $ap_dept,
                            'ap_dept_2' => $ap_dept_2,
                            'ap_status' => $ap_status1,
                            'ap_assigned_audit' => $ap_assigned_audit,
                            'ap_project_id' => $ap_project_id,
                            'ap_impact_value' => $ap_impact_value0,
                            'ap_impact_remarks' => $ap_impact_remarks0,
                            'ap_date_tag' => $ap_date_tag0,
                            'ap_due_date' => $ap_due_date0,
                            'ap_date_implemented' => $ap_date_implemented0,
                            'entered_date' => $entered_date0,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code2,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan2,
                            'ap_emp' => $ap_emp2,
                            'ap_emp_2' => $ap_emp_22,
                            'ap_dept' => $ap_dept2,
                            'ap_dept_2' => $ap_dept_22,
                            'ap_status' => $ap_status_x1,
                            'ap_assigned_audit' => $ap_assigned_audit2,
                            'ap_project_id' => $ap_project_id2,
                            'ap_impact_value' => $ap_impact_value2x,
                            'ap_impact_remarks' => $ap_impact_remarks2x,
                            'ap_date_tag' => $ap_date_tag2x,
                            'ap_due_date' => $ap_due_date2x,
                            'ap_date_implemented' => $ap_date_implemented2x,
                            'entered_date' => $entered_date2x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code3,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan3,
                            'ap_emp' => $ap_emp3,
                            'ap_emp_2' => $ap_emp_23,
                            'ap_dept' => $ap_dept3,
                            'ap_dept_2' => $ap_dept_23,
                            'ap_status' => $ap_status_x2,
                            'ap_assigned_audit' => $ap_assigned_audit3,
                            'ap_project_id' => $ap_project_id3,
                            'ap_impact_value' => $ap_impact_value3x,
                            'ap_impact_remarks' => $ap_impact_remarks3x,
                            'ap_date_tag' => $ap_date_tag3x,
                            'ap_due_date' => $ap_due_date3x,
                            'ap_date_implemented' => $ap_date_implemented3x,
                            'entered_date' => $entered_date3x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),
                        array(
                            'code' => $code4,
                            'bc_code' => $bc_code,
                            'action_plan' => $action_plan4,
                            'ap_emp' => $ap_emp4,
                            'ap_emp_2' => $ap_emp_24,
                            'ap_dept' => $ap_dept4,
                            'ap_dept_2' => $ap_dept_24,
                            'ap_status' => $ap_status_x3,
                            'ap_assigned_audit' => $ap_assigned_audit4,
                            'ap_project_id' => $ap_project_id4,
                            'ap_impact_value' => $ap_impact_value4x,
                            'ap_impact_remarks' => $ap_impact_remarks4x,
                            'ap_date_tag' => $ap_date_tag4x,
                            'ap_due_date' => $ap_due_date4x,
                            'ap_date_implemented' => $ap_date_implemented4x,
                            'entered_date' => $entered_date4x,
                            'user_n' => $user_n,
                            'user_d' => $user_d,
                            'company' => $company,
                            'status' => $status,
                            'is_approved' => "1"
                        ),

                      );

                    }
                    $this->db->insert_batch('ap_entry', $insertdatax);
                    #print_r2($insertdatax) ; exit;
              }   else {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                      {
                            $insertdatax = array(
                                array(
                                    'code' => $code,
                                    'bc_code' => $bc_code,
                                    'action_plan' => $action_plan,
                                    'ap_emp' => $ap_emp,
                                    'ap_emp_2' => $ap_emp_2,
                                    'ap_dept' => $ap_dept,
                                    'ap_dept_2' => $ap_dept_2,
                                    'ap_status' => $ap_status1,
                                    'ap_assigned_audit' => $ap_assigned_audit,
                                    'ap_project_id' => $ap_project_id,
                                    'ap_impact_value' => $ap_impact_value0,
                                    'ap_impact_remarks' => $ap_impact_remarks0,
                                    'ap_date_tag' => $ap_date_tag0,
                                    'ap_due_date' => $ap_due_date0,
                                    'ap_date_implemented' => $ap_date_implemented0,
                                    'entered_date' => $entered_date0,
                                    'user_n' => $user_n,
                                    'user_d' => $user_d,
                                    'company' => $company,
                                    'status' => $status,
                                    'is_approved' => "1"
                                ),
                                array(
                                    'code' => $code2,
                                    'bc_code' => $bc_code,
                                    'action_plan' => $action_plan2,
                                    'ap_emp' => $ap_emp2,
                                    'ap_emp_2' => $ap_emp_22,
                                    'ap_dept' => $ap_dept2,
                                    'ap_dept_2' => $ap_dept_22,
                                    'ap_status' => $ap_status_x1,
                                    'ap_assigned_audit' => $ap_assigned_audit2,
                                    'ap_project_id' => $ap_project_id2,
                                    'ap_impact_value' => $ap_impact_value2x,
                                    'ap_impact_remarks' => $ap_impact_remarks2x,
                                    'ap_date_tag' => $ap_date_tag2x,
                                    'ap_due_date' => $ap_due_date2x,
                                    'ap_date_implemented' => $ap_date_implemented2x,
                                    'entered_date' => $entered_date2x,
                                    'user_n' => $user_n,
                                    'user_d' => $user_d,
                                    'company' => $company,
                                    'status' => $status,
                                    'is_approved' => "1"
                                ),
                                array(
                                    'code' => $code3,
                                    'bc_code' => $bc_code,
                                    'action_plan' => $action_plan3,
                                    'ap_emp' => $ap_emp3,
                                    'ap_emp_2' => $ap_emp_23,
                                    'ap_dept' => $ap_dept3,
                                    'ap_dept_2' => $ap_dept_23,
                                    'ap_status' => $ap_status_x2,
                                    'ap_assigned_audit' => $ap_assigned_audit3,
                                    'ap_project_id' => $ap_project_id3,
                                    'ap_impact_value' => $ap_impact_value3x,
                                    'ap_impact_remarks' => $ap_impact_remarks3x,
                                    'ap_date_tag' => $ap_date_tag3x,
                                    'ap_due_date' => $ap_due_date3x,
                                    'ap_date_implemented' => $ap_date_implemented3x,
                                    'entered_date' => $entered_date3x,
                                    'user_n' => $user_n,
                                    'user_d' => $user_d,
                                    'company' => $company,
                                    'status' => $status,
                                    'is_approved' => "1"
                                ),
                                array(
                                    'code' => $code4,
                                    'bc_code' => $bc_code,
                                    'action_plan' => $action_plan4,
                                    'ap_emp' => $ap_emp4,
                                    'ap_emp_2' => $ap_emp_24,
                                    'ap_dept' => $ap_dept4,
                                    'ap_dept_2' => $ap_dept_24,
                                    'ap_status' => $ap_status_x3,
                                    'ap_assigned_audit' => $ap_assigned_audit4,
                                    'ap_project_id' => $ap_project_id4,
                                    'ap_impact_value' => $ap_impact_value4x,
                                    'ap_impact_remarks' => $ap_impact_remarks4x,
                                    'ap_date_tag' => $ap_date_tag4x,
                                    'ap_due_date' => $ap_due_date4x,
                                    'ap_date_implemented' => $ap_date_implemented4x,
                                    'entered_date' => $entered_date4x,
                                    'user_n' => $user_n,
                                    'user_d' => $user_d,
                                    'company' => $company,
                                    'status' => $status,
                                    'is_approved' => "1"
                                ),
                                array(
                                    'code' => $code5,
                                    'bc_code' => $bc_code,
                                    'action_plan' => $action_plan5,
                                    'ap_emp' => $ap_emp5,
                                    'ap_emp_2' => $ap_emp_25,
                                    'ap_dept' => $ap_dept5,
                                    'ap_dept_2' => $ap_dept_25,
                                    'ap_status' => $ap_status_x4,
                                    'ap_assigned_audit' => $ap_assigned_audit5,
                                    'ap_project_id' => $ap_project_id5,
                                    'ap_impact_value' => $ap_impact_value5x,
                                    'ap_impact_remarks' => $ap_impact_remarks5x,
                                    'ap_date_tag' => $ap_date_tag5x,
                                    'ap_due_date' => $ap_due_date5x,
                                    'ap_date_implemented' => $ap_date_implemented5x,
                                    'entered_date' => $entered_date5x,
                                    'user_n' => $user_n,
                                    'user_d' => $user_d,
                                    'company' => $company,
                                    'status' => $status,
                                    'is_approved' => "1"
                                ),
                            );
                      }

                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdata) ; exit;
                  }

          }

    }

    //Save for Approval of New Action Plan
    public function saveNewData($data) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = "FA";

        $data['is_approved'] = 1;
        $this->db->insert('bc_entry', $data);

        //New Action Plan Duplicate
        $company = $this->session->userdata('sess_company_id');
        $code = $this->input->post('myCodeExist');
        $code2 = $this->input->post('myCodeExist_2');
        $code3 = $this->input->post('myCodeExist_3');
        $datax['bc_code'] = $bc_code;
        $bc_code = $this->input->post('bc_code');


            if (!empty($code) && !empty($code2) && !empty($code3)) {

                //New Action Plan Duplicate
                $company = $this->session->userdata('sess_company_id');
                $code3 = $this->input->post('myCodeExist_3');
                $datax['bc_code'] = $bc_code;
                $bc_code = $this->input->post('bc_code');

                //New BC and New Ap with Existing AP
                $stmt_insert3 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code3'  
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert3);

                $id = $this->db->insert_id();

                $updatedData3['duplicatefrom'] = $this->input->post('myCodeExist_3');
                $updatedData3['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData3['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData3['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData3['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData3['is_duplicate'] = 1;
                $updatedData3['status'] = "A";
                $updatedData3['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData3);

                //New Action Plan Duplicate
                $company = $this->session->userdata('sess_company_id');
                $code2 = $this->input->post('myCodeExist_2');
                $datax['bc_code'] = $bc_code;
                $bc_code = $this->input->post('bc_code');

                //New BC and New Ap with Existing AP
                $stmt_insert2 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code2'  
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert2);

                $id = $this->db->insert_id();

                $updatedData2['duplicatefrom'] = $this->input->post('myCodeExist_2');
                $updatedData2['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData2['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData2['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData2['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData2['is_duplicate'] = 1;
                $updatedData2['status'] = "A";
                $updatedData2['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData2);

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE `code` = '$code' AND is_approved = '0' AND is_deleted = '0'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                #print_r2($stmt_insert); exit;

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);
                #print_r2($updatedData); exit;


                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }


                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }   else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

            }

            else if (!empty($code) && !empty($code2)) {

                //New Action Plan Duplicate
                $company = $this->session->userdata('sess_company_id');
                $code2 = $this->input->post('myCodeExist_2');
                $datax['bc_code'] = $bc_code;
                $bc_code = $this->input->post('bc_code');

                //New BC and New Ap with Existing AP
                $stmt_insert2 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code2'  
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert2);

                $id = $this->db->insert_id();

                $updatedData2['duplicatefrom'] = $this->input->post('myCodeExist_2');
                $updatedData2['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData2['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData2['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData2['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData2['is_duplicate'] = 1;
                $updatedData2['status'] = "A";
                $updatedData2['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData2);

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);

                #print_r2($updatedData); exit;

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }

                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

            }

            else if (!empty($code) && !empty($code3)) {

                //New Action Plan Duplicate
                $company = $this->session->userdata('sess_company_id');
                $code3 = $this->input->post('myCodeExist_3');
                $datax['bc_code'] = $bc_code;
                $bc_code = $this->input->post('bc_code');

                //New BC and New Ap with Existing AP
                $stmt_insert3 = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` = '$code3'  
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert3);

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);

                #print_r2($updatedData); exit;

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }

                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

            }

            else if (!empty($code)) {

                //New BC and New Ap with Existing AP
                $stmt_insert = "INSERT INTO ap_entry (`code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit,ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted)
                                SELECT `code`, action_plan, entered_date, company,bc_code, ap_emp, ap_emp_2,
                                ap_dept, ap_dept_2,ap_impact_value, ap_impact_remarks,ap_assigned_audit, ap_status, ap_date_tag,
                                ap_date_implemented,ap_due_date, ap_date_revised, ap_project_id, `status`, is_approved,is_duplicate,
                                is_deleted
                                FROM ap_entry
                                WHERE is_approved = '0' AND is_deleted = '0' AND `code` ='$code'
                                AND is_duplicate = '0' AND company = '$company'";

                $this->db->query($stmt_insert);

                $id = $this->db->insert_id();

                $updatedData['duplicatefrom'] = $this->input->post('myCodeExist');
                $updatedData['duplicate_n']  = $this->session->userdata('sess_user_id');
                $updatedData['duplicate_d'] = DATE('Y-m-d h:i:s');
                $updatedData['user_n']  = $this->session->userdata('sess_user_id');
                $updatedData['user_d'] = DATE('Y-m-d h:i:s');
                $updatedData['is_duplicate'] = 1;
                $updatedData['status'] = "A";
                $updatedData['bc_code'] = $bc_code;
                $this->db->where('id', $id);
                $this->db->update('ap_entry', $updatedData);

                #print_r2($updatedData); exit;

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }

                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }
                else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

            }

            else {

                //Action Plan
                $user_n  = $this->session->userdata('sess_user_id');
                $user_d = DATE('Y-m-d h:i:s');
                $status = "FA";
                $company = $this->session->userdata('sess_company_id');
                $bc_code = $this->input->post('bc_code');
                $is_approved = 1;

                $code = $_POST['book']['code'][0];
                $action_plan = $_POST['book']['action_plan'][0];
                $ap_emp = $_POST['book']['ap_emp'][0];

                $ap_emp_2 = $_POST['book']['ap_emp_2'][0];
                if (!empty($ap_emp_2)) {
                    $ap_emp_2 = $ap_emp_2;
                } else {
                    $ap_emp_2 = null;
                }

                $ap_dept = $_POST['book']['ap_dept'][0];

                $ap_dept_2 = $_POST['book']['ap_dept_2'][0];
                if (!empty($ap_dept_2)) {
                    $ap_dept_2 = $ap_dept_2;
                } else {
                    $ap_dept_2 = null;
                }

                $ap_status1 = $_POST['book']['ap_status'][0];
                $ap_status2x = $_POST['book']['ap_status2'][0];
                if (!empty($ap_status1)) {
                    $ap_status1 = $ap_status1;
                } else {
                    $ap_status1 = $ap_status2x;
                }


                $ap_assigned_audit = $_POST['book']['ap_assigned_audit'][0];
                $ap_project_id = $_POST['book']['ap_project_id'][0];

                $ap_impact_remarks = $_POST['book']['ap_impact_remarks'][0];
                if (!empty($ap_impact_remarks)) {
                    $ap_impact_remarks0 = $ap_impact_remarks;
                } else {
                    $ap_impact_remarks0 = null;
                }
                $ap_impact_value = $_POST['book']['ap_impact_value'][0];
                if (!empty($ap_impact_value)) {
                    $ap_impact_value0 = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
                } else {
                    $ap_impact_value0 = null;
                }
                $ap_date_tag = $_POST['book']['ap_date_tag'][0];
                if (!empty($ap_date_tag)) {
                    $ap_date_tag0 = date('Y-m-d', strtotime($ap_date_tag));
                } else {
                    $ap_date_tag0 = null;
                }
                $ap_due_date = $_POST['book']['ap_due_date'][0];
                if (!empty($ap_due_date)) {
                    $ap_due_date0 =  date('Y-m-d', strtotime($ap_due_date));
                } else {
                    $ap_due_date0 = null;
                }
                $ap_date_implemented = $_POST['book']['ap_date_implemented'][0];
                if (!empty($ap_date_implemented)) {
                    $ap_date_implemented0 = date('Y-m-d', strtotime($ap_date_implemented));
                } else {
                    $ap_date_implemented0 = null;
                }
                $entered_date = $_POST['book']['entered_date'][0];
                if (!empty($entered_date)) {
                    $entered_date0 = date('Y-m-d', strtotime($entered_date));
                } else {
                    $entered_date0 = null;
                }

                $code2 = $_POST['book']['code'][1];
                if (!empty($code2)) {
                    $code2 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code2 = null;
                }

                $action_plan2 = $_POST['book']['action_plan'][1];
                $ap_emp2 = $_POST['book']['ap_emp'][1];
                $ap_emp_22 = $_POST['book']['ap_emp_2'][1];
                if (!empty($ap_emp_22)) {
                    $ap_emp_22 = $ap_emp_22;
                } else {
                    $ap_emp_22 = null;
                }

                $ap_dept2 = $_POST['book']['ap_dept'][1];
                $ap_dept_22 = $_POST['book']['ap_dept_2'][1];
                if (!empty($ap_dept_22)) {
                    $ap_dept_22 = $ap_dept_22;
                } else {
                    $ap_dept_22 = null;
                }

                $ap_status_x1 = $_POST['book']['ap_status'][1];
                $ap_status_xx1 = $_POST['book']['ap_status'][1];
                if (!empty($ap_status_x1)) {
                    $ap_status_x1 = $ap_status_x1;
                } else {
                    $ap_status_x1 = $ap_status_xx1;
                }

                $ap_assigned_audit2 = $_POST['book']['ap_assigned_audit'][1];
                $ap_project_id2 = $_POST['book']['ap_project_id'][1];
                $ap_impact_remarks2 = $_POST['book']['ap_impact_remarks'][1];
                if (!empty($ap_impact_remarks2)) {
                    $ap_impact_remarks2x = $ap_impact_remarks2;
                } else {
                    $ap_impact_remarks2x = null;
                }
                $ap_impact_value2 = $_POST['book']['ap_impact_value'][1];
                if (!empty($ap_impact_value2)) {
                    $ap_impact_value2x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value2));
                } else {
                    $ap_impact_value2x = null;
                }
                $ap_date_tag2 = $_POST['book']['ap_date_tag'][1];
                if (!empty($ap_date_tag2)) {
                    $ap_date_tag2x = date('Y-m-d', strtotime($ap_date_tag2));
                } else {
                    $ap_date_tag2x= null;
                }
                $ap_due_date2 = $_POST['book']['ap_due_date'][1];
                if (!empty($ap_due_date2)) {
                    $ap_due_date2x = date('Y-m-d', strtotime($ap_due_date2));
                } else {
                    $ap_due_date2x = null;
                }
                $ap_date_implemented2 = $_POST['book']['ap_date_implemented'][1];
                if (!empty($ap_date_implemented2)) {
                    $ap_date_implemented2x = date('Y-m-d', strtotime($ap_date_implemented2));
                } else {
                    $ap_date_implemented2x = null;
                }
                $entered_date2 = $_POST['book']['entered_date'][1];
                if (!empty($entered_date2)) {
                    $entered_date2x = date('Y-m-d', strtotime($entered_date2));
                } else {
                    $entered_date2x = null;
                }

                $code3 = $_POST['book']['code'][2];
                if (!empty($code3)) {
                    $code3 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code3 = null;
                }

                $action_plan3 = $_POST['book']['action_plan'][2];
                $ap_emp3 = $_POST['book']['ap_emp'][2];
                $ap_emp_23 = $_POST['book']['ap_emp_2'][2];
                if (!empty($ap_emp_23)) {
                    $ap_emp_23 = $ap_emp_23;
                } else {
                    $ap_emp_23 = null;
                }
                $ap_dept3 = $_POST['book']['ap_dept'][2];
                $ap_dept_23 = $_POST['book']['ap_dept_2'][2];
                if (!empty($ap_dept_23)) {
                    $ap_dept_23 = $ap_dept_23;
                } else {
                    $ap_dept_23 = null;
                }

                $ap_status_x2 = $_POST['book']['ap_status'][2];
                $ap_status_xx2 = $_POST['book']['ap_status'][2];
                if (!empty($ap_status_x2)) {
                    $ap_status_x2 = $ap_status_x2;
                } else {
                    $ap_status_x2 = $ap_status_xx2;
                }

                $ap_assigned_audit3 = $_POST['book']['ap_assigned_audit'][2];
                $ap_project_id3 = $_POST['book']['ap_project_id'][2];
                $ap_impact_remarks3 = $_POST['book']['ap_impact_remarks'][2];
                if (!empty($ap_impact_remarks3)) {
                    $ap_impact_remarks3x = $ap_impact_remarks3;
                } else {
                    $ap_impact_remarks3x = null;
                }
                $ap_impact_value3 = $_POST['book']['ap_impact_value'][2];
                if (!empty($ap_impact_value3)) {
                    $ap_impact_value3x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value3));
                } else {
                    $ap_impact_value3x = null;
                }
                $ap_date_tag3 = $_POST['book']['ap_date_tag'][2];
                if (!empty($ap_date_tag3)) {
                    $ap_date_tag3x = date('Y-m-d', strtotime($ap_date_tag3));
                } else {
                    $ap_date_tag3x = null;
                }
                $ap_due_date3 = $_POST['book']['ap_due_date'][2];
                if (!empty($ap_due_date3)) {
                    $ap_due_date3x = date('Y-m-d', strtotime($ap_due_date3));
                } else {
                    $ap_due_date3x = null;
                }
                $ap_date_implemented3 = $_POST['book']['ap_date_implemented'][2];
                if (!empty($ap_date_implemented3)) {
                    $ap_date_implemented3x = date('Y-m-d', strtotime($ap_date_implemented3));
                } else {
                    $ap_date_implemented3x = null;
                }
                $entered_date3 = $_POST['book']['entered_date'][2];
                if (!empty($entered_date3)) {
                    $entered_date3x = date('Y-m-d', strtotime($entered_date3));
                } else {
                    $entered_date3x = null;
                }
                $code4 = $_POST['book']['code'][3];
                if (!empty($code4)) {
                    $code4 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code4 = null;
                }

                $action_plan4 = $_POST['book']['action_plan'][3];
                $ap_emp4 = $_POST['book']['ap_emp'][3];
                $ap_emp_24 = $_POST['book']['ap_emp_2'][3];
                if (!empty($ap_emp_24)) {
                    $ap_emp_24 = $ap_emp_24;
                } else {
                    $ap_emp_24 = null;
                }
                
                $ap_dept4 = $_POST['book']['ap_dept'][3];
                $ap_dept_24 = $_POST['book']['ap_dept_2'][3];
                if (!empty($ap_dept_24)) {
                    $ap_dept_24 = $ap_dept_24;
                } else {
                    $ap_dept_24 = null;
                }
                
                $ap_status_x3 = $_POST['book']['ap_status'][3];
                $ap_status_xx3 = $_POST['book']['ap_status'][3];
                if (!empty($ap_status_x3)) {
                    $ap_status_x3 = $ap_status_x3;
                } else {
                    $ap_status_x3 = $ap_status_xx3;
                }

                $ap_assigned_audit4 = $_POST['book']['ap_assigned_audit'][3];
                $ap_project_id4 = $_POST['book']['ap_project_id'][3];
                $ap_impact_remarks4 = $_POST['book']['ap_impact_remarks'][3];
                if (!empty($ap_impact_remarks4)) {
                    $ap_impact_remarks4x = $ap_impact_remarks4;
                } else {
                    $ap_impact_remarks4x = null;
                }
                $ap_impact_value4 = $_POST['book']['ap_impact_value'][3];
                if (!empty($ap_impact_value4)) {
                    $ap_impact_value4x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value4));
                } else {
                    $ap_impact_value4x = null;
                }
                $ap_date_tag4 = $_POST['book']['ap_date_tag'][3];
                if (!empty($ap_date_tag4)) {
                    $ap_date_tag4x = date('Y-m-d', strtotime($ap_date_tag4));
                } else {
                    $ap_date_tag4x = null;
                }
                $ap_due_date4 = $_POST['book']['ap_due_date'][3];
                if (!empty($ap_due_date4)) {
                    $ap_due_date4x = date('Y-m-d', strtotime($ap_due_date4));
                } else {
                    $ap_due_date4x = null;
                }
                $ap_date_implemented4 = $_POST['book']['ap_date_implemented'][3];
                if (!empty($ap_date_implemented4)) {
                    $ap_date_implemented4x = date('Y-m-d', strtotime($ap_date_implemented4));
                } else {
                    $ap_date_implemented4x = null;
                }
                $entered_date4 = $_POST['book']['entered_date'][3];
                if (!empty($entered_date4)) {
                    $entered_date4x = date('Y-m-d', strtotime($entered_date4));
                } else {
                    $entered_date4x = null;
                }
                $code5 = $_POST['book']['code'][4];
                if (!empty($code5)) {
                    $code5 = "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4);
                } else {
                    $code5 = null;
                }

                $action_plan5 = $_POST['book']['action_plan'][4];
                $ap_emp5 = $_POST['book']['ap_emp'][4];
                $ap_emp_25 = $_POST['book']['ap_emp_2'][4];
                if (!empty($ap_emp_25)) {
                    $ap_emp_25 = $ap_emp_25;
                } else {
                    $ap_emp_25 = null;
                }

                $ap_dept5 = $_POST['book']['ap_dept'][4];
                $ap_dept_25 = $_POST['book']['ap_dept_2'][4];
                if (!empty($ap_dept_25)) {
                    $ap_dept_25 = $ap_dept_25;
                } else {
                    $ap_dept_25 = null;
                }

                $ap_status_x4 = $_POST['book']['ap_status'][4];
                $ap_status_xx4 = $_POST['book']['ap_status'][4];
                if (!empty($ap_status_x4)) {
                    $ap_status_x4 = $ap_status_xx4;
                } else {
                    $ap_status_x4 = $ap_status_xx4;
                }

                $ap_assigned_audit5 = $_POST['book']['ap_assigned_audit'][4];
                $ap_project_id5 = $_POST['book']['ap_project_id'][4];
                $ap_impact_remarks5 = $_POST['book']['ap_impact_remarks'][4];
                if (!empty($ap_impact_remarks5)) {
                    $ap_impact_remarks5x = $ap_impact_remarks5;
                } else {
                    $ap_impact_remarks5x = null;
                }
                $ap_impact_value5 = $_POST['book']['ap_impact_value'][4];
                if (!empty($ap_impact_value5)) {
                    $ap_impact_value5x = intval(preg_replace('/[^\d.]/', '', $ap_impact_value5));
                } else {
                    $ap_impact_value5x = null;
                }
                $ap_date_tag5 = $_POST['book']['ap_date_tag'][4];
                if (!empty($ap_date_tag5)) {
                    $ap_date_tag5x = date('Y-m-d', strtotime($ap_date_tag5));
                } else {
                    $ap_date_tag5x = null;
                }
                $ap_due_date5 = $_POST['book']['ap_due_date'][4];
                if (!empty($ap_due_date5)) {
                    $ap_due_date5x = date('Y-m-d', strtotime($ap_due_date5));
                } else {
                    $ap_due_date5x = null;
                }
                $ap_date_implemented5 = $_POST['book']['ap_date_implemented'][4];
                if (!empty($ap_date_implemented5)) {
                    $ap_date_implemented5x = date('Y-m-d', strtotime($ap_date_implemented5));
                } else {
                    $ap_date_implemented5x = null;
                }
                $entered_date5 = $_POST['book']['entered_date'][4];
                if (!empty($entered_date5)) {
                    $entered_date5x = date('Y-m-d', strtotime($entered_date5));
                } else {
                    $entered_date5x = null;
                }

                if ($code2 == "" && $code3 == "" && $code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_impact_value' =>  $ap_impact_value0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          )
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code3 == "" && $code4 == ""  && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }

                else if ($code4 == "" && $code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                } else if ($code5 == "") {
                  $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                  foreach ($insertdatax as $insertdatax)
                  {
                      $insertdatax = array(
                          array(
                              'code' => $code,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan,
                              'ap_emp' => $ap_emp,
                              'ap_emp_2' => $ap_emp_2,
                              'ap_dept' => $ap_dept,
                              'ap_dept_2' => $ap_dept_2,
                              'ap_status' => $ap_status1,
                              'ap_assigned_audit' => $ap_assigned_audit,
                              'ap_project_id' => $ap_project_id,
                              'ap_impact_value' => $ap_impact_value0,
                              'ap_impact_remarks' => $ap_impact_remarks0,
                              'ap_date_tag' => $ap_date_tag0,
                              'ap_due_date' => $ap_due_date0,
                              'ap_date_implemented' => $ap_date_implemented0,
                              'entered_date' => $entered_date0,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code2,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan2,
                              'ap_emp' => $ap_emp2,
                              'ap_emp_2' => $ap_emp_22,
                              'ap_dept' => $ap_dept2,
                              'ap_dept_2' => $ap_dept_22,
                              'ap_status' => $ap_status_x1,
                              'ap_assigned_audit' => $ap_assigned_audit2,
                              'ap_project_id' => $ap_project_id2,
                              'ap_impact_value' => $ap_impact_value2x,
                              'ap_impact_remarks' => $ap_impact_remarks2x,
                              'ap_date_tag' => $ap_date_tag2x,
                              'ap_due_date' => $ap_due_date2x,
                              'ap_date_implemented' => $ap_date_implemented2x,
                              'entered_date' => $entered_date2x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code3,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan3,
                              'ap_emp' => $ap_emp3,
                              'ap_emp_2' => $ap_emp_23,
                              'ap_dept' => $ap_dept3,
                              'ap_dept_2' => $ap_dept_23,
                              'ap_status' => $ap_status_x2,
                              'ap_assigned_audit' => $ap_assigned_audit3,
                              'ap_project_id' => $ap_project_id3,
                              'ap_impact_value' => $ap_impact_value3x,
                              'ap_impact_remarks' => $ap_impact_remarks3x,
                              'ap_date_tag' => $ap_date_tag3x,
                              'ap_due_date' => $ap_due_date3x,
                              'ap_date_implemented' => $ap_date_implemented3x,
                              'entered_date' => $entered_date3x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),
                          array(
                              'code' => $code4,
                              'bc_code' => $bc_code,
                              'action_plan' => $action_plan4,
                              'ap_emp' => $ap_emp4,
                              'ap_emp_2' => $ap_emp_24,
                              'ap_dept' => $ap_dept4,
                              'ap_dept_2' => $ap_dept_24,
                              'ap_status' => $ap_status_x3,
                              'ap_assigned_audit' => $ap_assigned_audit4,
                              'ap_project_id' => $ap_project_id4,
                              'ap_impact_value' => $ap_impact_value4x,
                              'ap_impact_remarks' => $ap_impact_remarks4x,
                              'ap_date_tag' => $ap_date_tag4x,
                              'ap_due_date' => $ap_due_date4x,
                              'ap_date_implemented' => $ap_date_implemented4x,
                              'entered_date' => $entered_date4x,
                              'user_n' => $user_n,
                              'user_d' => $user_d,
                              'company' => $company,
                              'status' => $status,
                              'is_approved' => "1"
                          ),

                        );

                      }
                      $this->db->insert_batch('ap_entry', $insertdatax);
                      #print_r2($insertdatax) ; exit;
                }   else {
                    $insertdatax = is_array($insertdatax) ? $insertdatax : array($insertdatax);
                    foreach ($insertdatax as $insertdatax)
                        {
                              $insertdatax = array(
                                  array(
                                      'code' => $code,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan,
                                      'ap_emp' => $ap_emp,
                                      'ap_emp_2' => $ap_emp_2,
                                      'ap_dept' => $ap_dept,
                                      'ap_dept_2' => $ap_dept_2,
                                      'ap_status' => $ap_status1,
                                      'ap_assigned_audit' => $ap_assigned_audit,
                                      'ap_project_id' => $ap_project_id,
                                      'ap_impact_value' => $ap_impact_value0,
                                      'ap_impact_remarks' => $ap_impact_remarks0,
                                      'ap_date_tag' => $ap_date_tag0,
                                      'ap_due_date' => $ap_due_date0,
                                      'ap_date_implemented' => $ap_date_implemented0,
                                      'entered_date' => $entered_date0,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code2,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan2,
                                      'ap_emp' => $ap_emp2,
                                      'ap_emp_2' => $ap_emp_22,
                                      'ap_dept' => $ap_dept2,
                                      'ap_dept_2' => $ap_dept_22,
                                      'ap_status' => $ap_status_x1,
                                      'ap_assigned_audit' => $ap_assigned_audit2,
                                      'ap_project_id' => $ap_project_id2,
                                      'ap_impact_value' => $ap_impact_value2x,
                                      'ap_impact_remarks' => $ap_impact_remarks2x,
                                      'ap_date_tag' => $ap_date_tag2x,
                                      'ap_due_date' => $ap_due_date2x,
                                      'ap_date_implemented' => $ap_date_implemented2x,
                                      'entered_date' => $entered_date2x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code3,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan3,
                                      'ap_emp' => $ap_emp3,
                                      'ap_emp_2' => $ap_emp_23,
                                      'ap_dept' => $ap_dept3,
                                      'ap_dept_2' => $ap_dept_23,
                                      'ap_status' => $ap_status_x2,
                                      'ap_assigned_audit' => $ap_assigned_audit3,
                                      'ap_project_id' => $ap_project_id3,
                                      'ap_impact_value' => $ap_impact_value3x,
                                      'ap_impact_remarks' => $ap_impact_remarks3x,
                                      'ap_date_tag' => $ap_date_tag3x,
                                      'ap_due_date' => $ap_due_date3x,
                                      'ap_date_implemented' => $ap_date_implemented3x,
                                      'entered_date' => $entered_date3x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code4,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan4,
                                      'ap_emp' => $ap_emp4,
                                      'ap_emp_2' => $ap_emp_24,
                                      'ap_dept' => $ap_dept4,
                                      'ap_dept_2' => $ap_dept_24,
                                      'ap_status' => $ap_status_x3,
                                      'ap_assigned_audit' => $ap_assigned_audit4,
                                      'ap_project_id' => $ap_project_id4,
                                      'ap_impact_value' => $ap_impact_value4x,
                                      'ap_impact_remarks' => $ap_impact_remarks4x,
                                      'ap_date_tag' => $ap_date_tag4x,
                                      'ap_due_date' => $ap_due_date4x,
                                      'ap_date_implemented' => $ap_date_implemented4x,
                                      'entered_date' => $entered_date4x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                                  array(
                                      'code' => $code5,
                                      'bc_code' => $bc_code,
                                      'action_plan' => $action_plan5,
                                      'ap_emp' => $ap_emp5,
                                      'ap_emp_2' => $ap_emp_25,
                                      'ap_dept' => $ap_dept5,
                                      'ap_dept_2' => $ap_dept_25,
                                      'ap_status' => $ap_status_x4,
                                      'ap_assigned_audit' => $ap_assigned_audit5,
                                      'ap_project_id' => $ap_project_id5,
                                      'ap_impact_value' => $ap_impact_value5x,
                                      'ap_impact_remarks' => $ap_impact_remarks5x,
                                      'ap_date_tag' => $ap_date_tag5x,
                                      'ap_due_date' => $ap_due_date5x,
                                      'ap_date_implemented' => $ap_date_implemented5x,
                                      'entered_date' => $entered_date5x,
                                      'user_n' => $user_n,
                                      'user_d' => $user_d,
                                      'company' => $company,
                                      'status' => $status,
                                      'is_approved' => "1"
                                  ),
                              );
                        }

                        $this->db->insert_batch('ap_entry', $insertdatax);
                        #print_r2($insertdata) ; exit;
                    }

            }
    }

    //Get Last Action Plan Code:
    public function getActionCode($company) {

        $stmt = "SELECT id, MAX(CODE) AS codex
                FROM ap_entry
                WHERE is_duplicate = '0' AND is_approved IN ('2', '0') AND company = '$company'";

        $result = $this->db->query($stmt)->result_array();

        #echo "<pre>"; echo $stmt; exit;
      return $result;
    }

    //Get last Business Code:
    public function getBusinessCode($company) {

        $stmt = "SELECT id ,MAX(bc_code) AS bccode
                FROM bc_entry
                WHERE is_duplicate = '0' AND is_approved IN ('2', '0') AND company = '$company'";

        $result = $this->db->query($stmt)->result_array();

        #echo "<pre>"; echo $stmt; exit;
      return $result;
    }

    /*Query for editing of business concern*/
    public function getThisDataBusinessConcern($id, $company) {

        $stmt = "SELECT ap.id AS apid,bc.id AS bcid,bc.*,ap.*, DATE(bc.entered_date) AS bc_entered_date,
                  DATE(ap.entered_date) AS ap_entered_date, b.name AS company_name, bc.is_approved AS bcis_approved,
                  ap.is_approved AS ap_is_approved
                  FROM bc_entry AS bc
                  INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                  LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = bc.emp
                  LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = bc.emp2
                  LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = bc.emp3
                  LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                  LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = bc.dept2
                  LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = bc.dept3
                  LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                  LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                  LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                  LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                  LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                  LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                  LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                  LEFT OUTER JOIN ap_risk AS e ON e.id = bc.risk1
                  LEFT OUTER JOIN ap_users AS au ON ap.user_n = au.user_id
                  LEFT OUTER JOIN ap_users AS audit ON bc.assigned_audit = audit.user_id
                  WHERE bc.id = '$id' AND bc.company = '$company'
                  AND ap.company = '$company'
                  GROUP BY ap.id
                  ORDER BY ap.ap_status!= 2 DESC";

        #echo "<pre>"; echo $stmt; exit;
        $row = $this->db->query($stmt)->row_array();
    return $row;

    }

    //Editing of Business concern for Approval
    public function getThisDataBusinessConcernforApproval($id, $company) {

        $stmt = "SELECT bc.id AS bcid,bc.*, ap.*, DATE(bc.entered_date) AS bc_entered_date,
                  DATE(ap.entered_date) AS ap_entered_date, b.name AS company_name
                  FROM bc_entry AS bc
                  INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                  LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = bc.emp
                  LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = bc.emp2
                  LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = bc.emp3
                  LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                  LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = bc.dept2
                  LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = bc.dept3
                  LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                  LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                  LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                  LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                  LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                  LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                  LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                  LEFT OUTER JOIN ap_risk AS e ON e.id = bc.risk1
                  LEFT OUTER JOIN ap_users AS au ON ap.user_n = au.user_id
                  LEFT OUTER JOIN ap_users AS audit ON bc.assigned_audit = audit.user_id
                  WHERE bc.id = '$id' AND bc.is_deleted = '0' AND bc.is_approved = '1' AND bc.company = '$company'
                  GROUP BY bc.bc_code
                  ORDER BY ap.ap_status";

        #echo "<pre>"; echo $stmt; exit;
        $row = $this->db->query($stmt)->row_array();

      return $row;
    }

    public function getThisDataViewAp($id, $company) {

        $stmt = "SELECT ap_entry.*, b.name AS company_name
                  FROM ap_entry
                  LEFT OUTER JOIN hr_companies AS b ON b.id = ap_entry.company
                  WHERE ap_entry.id = '$id'
                  AND ap_entry.company = '$company'
                  ORDER BY ap_entry.id";

        #echo "<pre>"; echo $stmt; exit;
        $row = $this->db->query($stmt)->row_array();

    return $row;

    }

    public function getThisDataofActionPlan($id, $company) {

        $stmt = "SELECT ap.id AS apid,ap.code AS ap_code, ap.*,b.name AS company_name,
                  CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname,
                  DATE(ap.entered_date) AS ap_entered_date
                  FROM ap_entry AS ap
                  LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                  LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                  LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                  LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                  LEFT OUTER JOIN hr_companies AS b ON b.id = ap.company
                  LEFT OUTER JOIN ap_project AS c ON c.id = ap.ap_project_id
                  LEFT OUTER JOIN ap_users AS au ON au.user_id = ap.ap_assigned_audit
                  WHERE ap.id = '$id' AND ap.company = '$company'
                  ORDER BY ap.id";

        #echo "<pre>"; echo $stmt; exit;
        $row = $this->db->query($stmt)->row_array();

    return $row;

    }

    /*Query for editing of audit action plan*/
    public function getThisData($id, $company) {

        $stmt = "SELECT bc.is_deleted AS bcisdeleted,bc.id AS bcid,bc.is_approved AS bcis_approved,ap.id AS apid,
                  ap.code AS ap_code,bc.*, ap.*, b.name AS company_name,
                  CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname,
                  DATE(bc.entered_date) AS bc_entered_date,
                  DATE(ap.entered_date) AS ap_entered_date
                  FROM bc_entry AS bc
                  INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                  LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = bc.emp
                  LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = bc.emp2
                  LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = bc.emp3
                  LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                  LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = bc.dept2
                  LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = bc.dept3
                  LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                  LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                  LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                  LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                  LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                  LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                  LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                  LEFT OUTER JOIN ap_risk AS e ON e.id = bc.risk1
                  LEFT OUTER JOIN ap_users AS au ON ap.ap_assigned_audit = au.user_id
                  LEFT OUTER JOIN ap_users AS audit ON bc.assigned_audit = audit.user_id
                  WHERE ap.id = '$id'
                  AND ap.company = '$company' AND bc.company = '$company'
                  GROUP BY bc.bc_code
                  ORDER BY ap.id";

          #echo "<pre>"; echo $stmt; exit;
          $row = $this->db->query($stmt)->row_array();

      return $row;
    }

    public function getThisDataforApproval($id, $company) {

        $stmt = "SELECT bc.id AS bcid,bc.is_approved AS bcis_approved,bc.*, ap.*,  b.name AS company_name,
                  CONCAT(au.lastname,', ',au.firstname,' ',SUBSTR(au.middlename,1,1),'. ')AS auditname,
                  DATE(bc.entered_date) AS bc_entered_date,
                  DATE(ap.entered_date) AS ap_entered_date
                  FROM bc_entry AS bc
                  INNER JOIN ap_entry AS ap ON bc.bc_code = ap.bc_code
                  LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = bc.emp
                  LEFT OUTER JOIN hr_employees AS emp2 ON emp2.user_id = bc.emp2
                  LEFT OUTER JOIN hr_employees AS emp3 ON emp3.user_id = bc.emp3
                  LEFT OUTER JOIN ap_dept AS dept ON dept.id = bc.dept
                  LEFT OUTER JOIN ap_dept AS dept2 ON dept2.id = bc.dept2
                  LEFT OUTER JOIN ap_dept AS dept3 ON dept3.id = bc.dept3
                  LEFT OUTER JOIN hr_employees AS apemp ON apemp.user_id = ap.ap_emp
                  LEFT OUTER JOIN hr_employees AS apemp2 ON apemp2.user_id = ap.ap_emp_2
                  LEFT OUTER JOIN ap_dept AS apdept ON apdept.id = ap.ap_dept
                  LEFT OUTER JOIN ap_dept AS apdept2 ON apdept2.id = ap.ap_dept_2
                  LEFT OUTER JOIN hr_companies AS b ON b.id = bc.company
                  LEFT OUTER JOIN ap_project AS c ON c.id = bc.project_id
                  LEFT OUTER JOIN ap_risk_rating AS d ON d.id = bc.risk_rating
                  LEFT OUTER JOIN ap_risk AS e ON e.id = bc.risk1
                  LEFT OUTER JOIN ap_users AS au ON ap.ap_assigned_audit = au.user_id
                  LEFT OUTER JOIN ap_users AS audit ON bc.assigned_audit = audit.user_id
                  WHERE ap.id = '$id' AND ap.is_deleted = '0' AND ap.is_approved = '1' AND ap.company = '$company'
                  GROUP BY bc.bc_code
                  ORDER BY ap.id";

          #echo "<pre>"; echo $stmt; exit;
          $row = $this->db->query($stmt)->row_array();

      return $row;
    }

    //Save Updated Business Concern Entry
    public function saveupdateBcEntry($data, $bcid, $bc_status) {

      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['edited_n'] = $this->session->userdata('sess_user_id');
      $data['edited_d'] = DATE('Y-m-d h:m:s');
      $data['prev_status'] =  $bc_status;
      $data['prev_date'] = DATE('Y-m-d h:m:s');

      $this->db->where('id', $bcid);
      $this->db->update('bc_entry', $data);

    return true;
    }

    public function saveupdateBcforApproval($data, $bcid) {

      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['edited_n'] = $this->session->userdata('sess_user_id');
      $data['edited_d'] = DATE('Y-m-d h:m:s');
      $data['status'] = 'FA';

      $this->db->where('id', $bcid);
      $this->db->update('bc_entry', $data);

      return true;
    }

    //Save Updated Action Plan Entry
    public function saveupdateActionEntry($data, $id, $code, $ap_status) {
  
      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['edited_n'] = $this->session->userdata('sess_user_id');
      $data['edited_d'] = DATE('Y-m-d h:m:s');
      $data['prev_status'] =  $ap_status;
      $data['prev_date'] = DATE('Y-m-d h:m:s');

      $this->db->where('id',$id);
      //$this->db->where('code',$code);

      $this->db->update('ap_entry', $data);

      #print_r2($data); exit;

      return true;
    }

    public function saveupdateActionforApproval($data, $id) {

      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['edited_n'] = $this->session->userdata('sess_user_id');
      $data['edited_d'] = DATE('Y-m-d h:m:s');
      $data['status'] = 'FA';

      $this->db->where('id', $id);
      $this->db->update('ap_entry', $data);

      return true;
    }

    //For Inquiry Additional Action Plan.
    public function saveadditionalactioncodeforbc($data) {

        $data['duplicatefrom'] = $this->input->post('code');
        $data['duplicate_n']  = $this->session->userdata('sess_user_id');
        $data['duplicate_d'] = DATE('Y-m-d h:i:s');
        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['is_duplicate'] = '1';
        $data['status'] = "A";

        $data['is_approved'] = 0;
        $this->db->insert('ap_entry', $data);
      return true;

    }

    public function saveNewDuplicate($data) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['duplicate_n'] = $this->session->userdata('sess_user_id');
        $data['duplicate_d'] = DATE('Y-m-d h:m:s');
        $data['is_approved'] = 1;
        $data['is_duplicate'] = 1;

        $this->db->insert('ap_entry', $data);

    return true;
    }

    //Save approved action plan
    public function saveNewDatawithApproval($id, $codex) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['approved_n'] = $this->session->userdata('sess_user_id');
        $data['approved_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = "A";
        $data['is_approved'] = 0;

        $lastcode = $codex + 1;
        $data['code'] = str_pad($lastcode, 3, STR_PAD_RIGHT);
        //$data['code'] = str_pad($lastcode, 5, "0", STR_PAD_LEFT);

        $this->db->where_in('id', $id);
        $this->db->update('ap_entry', $data);

        #print_r2($data); exit();
      return true;

    }

    //Save approved business concern:
    public function saveNewDatawithApprovalBc($id, $bccode, $bc_codeold) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['approved_n'] = $this->session->userdata('sess_user_id');
        $data['approved_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = "A";
        $data['is_approved'] = 0;

        $lastcode = $bccode + 1;
        $data['bc_code'] = str_pad($lastcode,5, "0", STR_PAD_LEFT);

        $this->db->where_in('id', $id);
        $this->db->update('bc_entry', $data);

        $updatedData['bc_code'] = $data['bc_code'];

        $this->db->where('bc_code', $bc_codeold);
        $this->db->update('ap_entry', $updatedData);

        #print_r2($data); exit();
      return true;

    }

    public function removeMultiData($id, $ap_status) {
        print_r2( $ap_status) ; exit;

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['deleted_n'] = $this->session->userdata('sess_user_id');
        $data['deleted_d'] = DATE('Y-m-d h:i:s');
        $data['prev_status'] =  $ap_status;
        $data['prev_date'] = DATE('Y-m-d h:m:s');
        $data['is_approved'] = 2;
        $data['is_deleted'] = 1;
        $data['ap_status'] = 8;
        $data['status'] = "C";
        $this->db->where_in('id', $id);
        // $this->db->where_in('ap_status', $ap_status);
        $this->db->update('ap_entry', $data);

        // $data['prev_status'] =  $ap_status;
        // $updatedData['prev_status'] = $ap_status;

        // $this->db->where_in('ap_status', $ap_status);
        // $this->db->update('ap_entry', $data);

        return true;
    }

    public function removeMultiDataBc () {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['deleted_n'] = $this->session->userdata('sess_user_id');
        $data['deleted_d'] = DATE('Y-m-d h:i:s');
        $data['prev_status'] =  $ap_status;
        $data['prev_date'] = DATE('Y-m-d h:m:s');
        $data['is_approved'] = 2;
        $data['is_deleted'] = 1;
        $data['bc_status'] = 8;
        $data['status'] = "C";

        $this->db->where_in('id', $id);
        $this->db->update('bc_entry', $data);

        return true;

    }

    public function removeDataAp($id, $ap_status) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['deleted_n'] = $this->session->userdata('sess_user_id');
        $data['deleted_d'] = DATE('Y-m-d h:i:s');
        $data['prev_status'] =  $ap_status;
        $data['prev_date'] = DATE('Y-m-d h:m:s');
        $data['is_approved'] = 2;
        $data['is_deleted'] = 1;
        $data['ap_status'] = 8;
        $data['status'] = "C";

        $this->db->where('id', $id);
        $this->db->update('ap_entry', $data);

        return true;
    }
    public function removeDataBc($id, $bc_status) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['deleted_n'] = $this->session->userdata('sess_user_id');
        $data['deleted_d'] = DATE('Y-m-d h:i:s');
        $data['prev_status'] =  $bc_status;
        $data['prev_date'] = DATE('Y-m-d h:m:s');
        $data['is_approved'] = 2;
        $data['is_deleted'] = 1;
        $data['bc_status'] = 8;
        $data['status'] = "C";

        $this->db->where('id', $id);
        $this->db->update('bc_entry', $data);

        return true;
    }

    public function removetagging($apid) {

      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['bc_code'] = null;
      $data['is_deleted'] = 0;

      $this->db->where('id', $apid);
      $this->db->update('ap_entry', $data);

      return true;

    }
	
	//Business Concern removetagged* not use*
	public function removebctagging($apids) {

      $data['user_n']  = $this->session->userdata('sess_user_id');
      $data['user_d'] = DATE('Y-m-d h:i:s');
      $data['bc_code'] = null;
      $data['is_deleted'] = 0;

      $this->db->where('id', $apids);
      $this->db->update('ap_entry', $data);

      return true;

    }

    public function disapprovedap($id) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['approved_n'] = $this->session->userdata('sess_user_id');
        $data['approved_d'] = DATE('Y-m-d h:i:s');
        $data['is_approved'] = '3'; //disapproved

        $this->db->where('id', $id);
        $this->db->update('ap_entry', $data);

        return true;
    }

    public function disapprovedbc($id) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['approved_n'] = $this->session->userdata('sess_user_id');
        $data['approved_d'] = DATE('Y-m-d h:i:s');
        $data['is_approved'] = '3'; //disapproved

        $this->db->where('id', $id);
        $this->db->update('bc_entry', $data);

        return true;
    }

    public function insertnewbctothisactioncode($data,$id) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:m:s');

        $this->db->where('id', $id);
        $this->db->update('ap_entry', $data);

        return true;


    }

}
