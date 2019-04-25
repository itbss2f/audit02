<?php

class Departments extends CI_Model {

    public function getAllDepartment_old() {

        $stmt = "SELECT *
                FROM ap_dept
                ORDER BY company_id ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;
    }

    public function getAllDepartment($company) {

        $stmt = "SELECT dept.id , dept.code AS depart_code,dept.name,dept.company_id AS company, b.code AS company_code, 
                b.name AS company_name, dept.user_d AS dept_user_d, dept.user_n AS dept_user_n
                FROM ap_dept AS dept
                LEFT OUTER JOIN hr_companies AS b ON b.id = dept.company_id
                INNER JOIN ap_user_company AS uc ON dept.company_id = uc.company_id
                WHERE uc.company_id = '$company'
                GROUP BY dept.id
                ORDER BY dept.name ASC";

        $result = $this->db->query($stmt)->result_array();

        return $result;
    }

    public function getDepartmentOfThisEmployees($company, $user_id) {
         $condept = "";

        if ($user_id != "") {
            $condept = "AND c.user_id = $user_id";
        }

        $stmt = "SELECT dept.id, dept.code,dept.name,dept.company_id AS company, b.code, b.name AS company_name
                FROM ap_dept AS dept
                LEFT OUTER JOIN hr_companies AS b ON b.id = dept.company_id
                LEFT OUTER JOIN hr_employees AS c ON c.department = dept.id
                INNER JOIN ap_user_company AS uc ON dept.company_id = uc.company_id
                WHERE uc.company_id = '$company' $condept
                GROUP BY dept.name
                ORDER BY dept.name ASC";

        #echo "<pre>"; echo $stmt; exit;
        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

    public function validateDepartment($company, $dept, $code) {

        $stmt = "SELECT * FROM ap_entry
                WHERE company = '$company' AND ap_dept = '$dept' AND code = '$code' AND is_approved = 1";

        $result = $this->db->query($stmt)->result_array();
        
    return $result;

    }

    public function getTotalDepartments($company) {

        $stmt = "SELECT COUNT(*) AS total_depart FROM ap_dept
                WHERE company_id = '$company'";

        $row = $this->db->query($stmt)->row_array();
        
        return $row;

    }

    public function getThisData($id) {
         
        $stmt = "SELECT id, `code`, `name`, user_n , user_d, edited_d, edited_n, is_deleted  
                FROM ap_dept                                                                                                                                                                                        
                WHERE is_deleted = 0 AND id = '$id'
                ORDER BY id DESC"; 

        $row = $this->db->query($stmt)->row_array();

        return $row;
    
    }

    public function removedata($id) {

        $data['is_deleted'] = 1;
        
        $this->db->where('id', $id);
        $this->db->update('ap_dept', $data);

        return true; 
           
    }

    public function saveupdateNewData($data, $id) {
    
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');
        
        $this->db->where('id', $id); 
        $this->db->update('ap_dept', $data);
    
        return true;  
      
    }  

    public function saveNewData($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');


        $this->db->insert('ap_dept', $data);
    
        return true;


    }


}
