
<?php

class Model_status extends CI_Model {

    public function removeData($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_status', $data);

        return true;
    }

    public function removeMultiData() {

        $data['is_deleted'] = 1;

        $this->db->where_in('id', $id);
        $this->db->update('ap_status', $data);

    return true;

    }

    public function getAllStatusReport() {

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatusView() {
        //for Transaction and Editing use of Action Plan

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  where status like 'AP%' and status_code NOT IN ('RDM','SUP')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatus() {
        //for Transaction and Editing use of Action Plan

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  where status like 'AP%' and status_code NOT IN ('RDM','SUP','C')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatusApEdit() {
        //for Transaction and Editing use of Action Plan

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  where status like 'AP%' and status_code NOT IN ('RDM','SUP', 'C')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatusimplement() {
        //for Transaction and Editing use of Action Plan

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  where status like 'AP%' and status_code IN ('I')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }


    public function getDataStatusforBusinessTrans() {
        //for Transaction use of Business concern

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  WHERE status_code IN ('O')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatusforBusiness() {
        //for Transaction and Editing use of Business concern

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  WHERE status_code IN ('O','R')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function getDataStatusforBusinessView() {
        //for Transaction and Editing use of Business concern

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                  FROM ap_status
                  WHERE status_code IN ('C','O','R')
                  ORDER BY id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function saveNewData($data) {

        $data['user_n']  = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status_d'] = DATE('Y-m-d h:i:s');

        $this->db->insert('ap_status', $data);

        return true;

    }

    public function saveupdateNewData($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');


        $this->db->where('id', $id);
        $this->db->update('ap_status', $data);

    return true;

    }

    public function getThisData($id) {
        //for editing

            $stmt = "SELECT id, status_code, description AS status_name ,status, user_d ,edited_d
                     FROM ap_status
                     WHERE is_deleted = 0 AND id = '$id'";

        $result = $this->db->query($stmt)->row_array();

        return $result;

    }

    public function getStatusforImplement($id) {

            $stmt = "SELECT * FROM ap_entry
            WHERE is_approved = '1' AND company = '1' AND ap_status = '$id'";

        $row = $this->db->query($stmt)->result_array();

        #print_r2($stmt); exit;

      return $row;

    }
    //To View the due for today
    public function getduestatusasoftoday($user_company) {

            $stmt = "SELECT en.id,en.code,en.action_plan,en.entered_date AS apentered_date,en.company,
            en.bc_code,en.ap_due_date,stat.status_code AS apstatus,
            CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS apfullname,
            CONCAT(assign.lastname,', ',assign.firstname,' ',SUBSTR(assign.middlename,1,1),'. ')AS assignedaudit,
            dept.name AS dept_name
            FROM ap_entry AS en
            LEFT OUTER JOIN ap_status AS stat ON stat.id = en.ap_status
            LEFT OUTER JOIN ap_users AS assign ON assign.user_id = en.ap_assigned_audit
            LEFT OUTER JOIN hr_employees AS emp ON emp.user_id = en.ap_emp
            LEFT OUTER JOIN ap_dept AS dept ON dept.id = en.ap_dept
            WHERE DATE(en.ap_due_date) <= CURDATE() AND en.ap_status = '4' AND en.company = '$user_company' AND is_approved = '0'";

        $row = $this->db->query($stmt)->result_array();

      return $row;

    }

    public function changenotyettoduestatus($user_company, $edited_n, $edited_d, $prev_date) {

            $stmt = "UPDATE ap_entry
            SET ap_status = '1', 
                prev_status = '4',
                prev_date = '$prev_date',
                edited_d = '$edited_d',
                edited_n = '$edited_n'
            WHERE DATE(ap_due_date) <= CURDATE() AND ap_status = '4' AND company = '$user_company' AND is_approved = '0'";

        $result = $this->db->query($stmt);

    return true;

    }

}
