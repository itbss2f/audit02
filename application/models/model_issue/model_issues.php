<?php


class Model_issues extends CI_Model {

    public function removeData($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_issue', $data);

    return true;
    }

   public function removeMultiData($id) {

        $data['is_deleted'] = 1;

        $this->db->where_in('id', $id);
        $this->db->update('ap_issue', $data);

    return true;
    }

    public function getTotalIssues() {
        //count total issues

        $stmt = "SELECT COUNT(*) AS total_issues
                FROM ap_issue
                WHERE is_deleted = '0' AND is_approved = '0'";

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }

    public function getIssues() {
        //issue for transaction

        $stmt = "SELECT id, `code`, description, `status`, user_n, user_d, is_deleted
                FROM ap_issue
                WHERE is_deleted = 0 AND is_approved = 0
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();

    return $result;
    }

    public function getListofIssues() {
        //list of issues for maintenance

        $stmt = "SELECT a.id, a.code, a.description, a.status, a.user_n, a.user_d, a.is_deleted, ap.username AS username
                FROM ap_issue AS a
                LEFT OUTER JOIN ap_users AS ap ON ap.user_id = a.user_n
                WHERE a.is_deleted = 0 AND a.is_approved = 0
                ORDER BY a.code ASC";

        $result = $this->db->query($stmt)->result_array();

    return $result;
    }

    /*Save new issue's for approval*/
    public function saveNewData($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = 'A';

        $data['is_approved'] = 0;

        $this->db->insert('ap_issue', $data);

    return true;
    }
    /*End*/

    /*Save new update issue's for approval*/
    public function saveupdateNewData($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_issue', $data);

    return true;

    /*End*/
    }

    public function getThisData($id) {

        $stmt = "SELECT id, `code`, description, `status`, user_n, user_d, is_deleted
                FROM ap_issue
                WHERE is_deleted = 0 AND id = '$id'";

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }

    public function getStatusByIssues($datefrom_as, $reporttype, $status, $dept, $risk, $issue, $project_name) {
        /*Status Report by issues*/

        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
        }

    return $newresult;

        }else if ($reporttype == 2) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
        }

    return $newresult;

    }else if ($reporttype == 3){
        $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['risk_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 4){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name,CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['issue_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 5){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

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
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept, dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) <= '$datefrom_as' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";
          #print_r2($stmt); exit;
        $result = $this->db->query($stmt)->result_array();

    return $result;

        }
    }
    /*End of Report*/

    public function getStatusByIssues2($datefrom, $dateto, $reporttype, $status, $dept, $risk, $issue, $project_name) {
        /*Status Report by issues*/

        if ($reporttype == 1) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['status_name']][] = $row;
        }

    return $newresult;

        }else if ($reporttype == 2) {
            $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['dept_name']][] = $row;
        }

    return $newresult;

    }else if ($reporttype == 3){
        $constatus = ""; $condept = ""; $conrisk = ""; $conproject_name = ""; $conissue = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['risk_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 4){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name,CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

        $result = $this->db->query($stmt)->result_array();
        $newresult = array();

        foreach ($result as $row) {
            $newresult[$row['issue_name']][] = $row;
        }

    return $newresult;
    }else if ($reporttype == 5){
        $constatus = ""; $condept = ""; $conrisk = ""; $conissue = ""; $conproject_name = "";

        if ($status != 0) {
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person,a.dept,dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";

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
            $constatus = "AND a.status = $status";
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
                a.remarks, a.action_plan, a.code, a.status, stat.description AS status_name, CONCAT(emp.last_name,', ',SUBSTR(emp.first_name,1,1),'. ') AS person, a.dept, dept.name AS dept_name, stat.status_code AS status_code
                FROM ap_entry AS a
                LEFT OUTER JOIN ap_issue AS b ON b.id = a.issue
                LEFT OUTER JOIN ap_project AS c ON c.id = a.project_id
                LEFT OUTER JOIN ap_risk AS d ON d.id = a.risk1
                LEFT OUTER JOIN ap_risk_rating AS rating ON rating.id = a.risk_rating
                LEFT OUTER JOIN ap_users AS audit ON audit.user_id = a.assigned_audit
                LEFT OUTER JOIN ap_status AS stat ON stat.id = a.status
                LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = a.emp
                LEFT OUTER JOIN hr_departments AS dept ON dept.id = a.dept
                WHERE a.is_deleted = 0 AND a.status NOT IN ('C') AND DATE(a.entered_date) >= '$datefrom' AND DATE(a.entered_date) <= '$dateto' $constatus $condept $conrisk $conissue $conproject_name
                ORDER BY a.entered_date ASC";
          #print_r2($stmt); exit;
        $result = $this->db->query($stmt)->result_array();

    return $result;

        }
    }

}
