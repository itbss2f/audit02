<?php

class Model_employees extends CI_Model {

    public function getPersonResponsible2($user_id, $department, $company) {
        $conuser = "";
        if ($user_id != "") {
            $conuser = "AND emp.user_id != $user_id";
        }
        $stmt = "SELECT emp.user_id,
                    emp.company_id,
                    emp.code AS emp_code,
                    c.name AS `position`,
                    CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname,
                    emp.email,
                    emp.position,
                    emp.division,
                    emp.department AS dept,
                    emp.status AS emp_status,
                    d.name AS company,
                    b.name AS department_name
                FROM hr_employees AS emp
                LEFT OUTER JOIN ap_dept AS b ON b.id = emp.department
                LEFT OUTER JOIN hr_positions AS c ON c.id = emp.position
                LEFT OUTER JOIN hr_companies AS d ON d.id = emp.company_id
                INNER JOIN ap_user_company AS uc ON emp.company_id = uc.company_id
                WHERE STATUS IN ('2','3') AND uc.company_id = '$company'
                AND emp.department = $department $conuser
                GROUP BY fullname
                ORDER BY fullname ASC";

        $result = $this->db->query($stmt)->result_array();

      return $result;
    }

    public function getEmployeesOfThisDepartment($company, $id) {
        $condept = "";
        if ($id != "") {
            $condept = "AND emp.department = $id";
        }
        $stmt = "SELECT emp.user_id,
                    emp.company_id,
                    emp.code AS emp_code,
                    c.name AS `position`,
                    CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname,
                    emp.email,
                    emp.position,
                    emp.division,
                    emp.department AS dept,
                    emp.status AS emp_status,
                    d.name AS company,
                    b.name AS department_name
                FROM hr_employees AS emp
                LEFT OUTER JOIN ap_dept AS b ON b.id = emp.department
                LEFT OUTER JOIN hr_positions AS c ON c.id = emp.position
                LEFT OUTER JOIN hr_companies AS d ON d.id = emp.company_id
                INNER JOIN ap_user_company AS uc ON emp.company_id = uc.company_id
                WHERE STATUS IN ('2','3') AND uc.company_id = '$company' $condept
                GROUP BY fullname
                ORDER BY fullname ASC";

        $result = $this->db->query($stmt);
        #print_r2($stmt); exit;

      return $result->result_array();
    }
    //Employees per company
    public function getAllEmployees($company) {

        $stmt = "SELECT emp.user_id,
                    emp.company_id,
                    emp.code AS emp_code,
                    c.name AS `position`,
                    CONCAT(emp.last_name,', ',emp.first_name,' ',SUBSTR(emp.middle_name,1,1),'. ')AS fullname,
                    emp.email,
                    emp.position,
                    emp.division,
                    emp.department AS dept,
                    emp.status AS emp_status,
                    d.name AS company,
                    b.name AS department_name
                FROM hr_employees AS emp
                LEFT OUTER JOIN ap_dept AS b ON b.id = emp.department
                LEFT OUTER JOIN hr_positions AS c ON c.id = emp.position
                LEFT OUTER JOIN hr_companies AS d ON d.id = emp.company_id
                LEFT OUTER JOIN ap_user_company AS uc ON emp.company_id = uc.company_id
                WHERE uc.company_id = '$company' AND STATUS IN ('2','3')
                GROUP BY fullname
                ORDER BY fullname ASC";

        $result = $this->db->query($stmt);
        #print_r2($stmt); exit;

      return $result->result_array();

    }

   public function getEmployees_old() {

        $stmt = "SELECT user_id, code AS emp_code,
                CONCAT(last_name,', ',first_name,' ',SUBSTR(middle_name,1,1),'. ')AS fullname, company_id
                FROM hr_employees
                WHERE user_id NOT IN ('NULL','0')
                ORDER BY fullname ASC";

        $result = $this->db->query($stmt);

      return $result->result_array();

    }

}
