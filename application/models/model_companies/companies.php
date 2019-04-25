<?php

class Companies extends CI_Model {

    public function getAllCompanies() {

        $stmt = "SELECT id, code, name
                FROM hr_companies
                WHERE id NOT LIKE '8'
                ORDER BY id";

        $result = $this->db->query($stmt)->result_array();

    return $result;
    }

    public function getCompaniesForThisUser($user_id) {

        $stmt = "SELECT a.id, a.code, a.name, b.user_id, c.lastname
                FROM hr_companies AS a
                INNER JOIN ap_user_company AS b ON a.id = b.company_id
                LEFT OUTER JOIN ap_users AS c ON c.user_id = b.user_id
                WHERE b.user_id = '$user_id' AND a.id NOT LIKE '8'
                ORDER BY a.id";

        $result = $this->db->query($stmt)->result_array();

    return $result;


    }
}
