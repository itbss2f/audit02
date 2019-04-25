
<?php

class users extends CI_Model {

    public function removeData($user_id) {

        $data['is_deleted'] = 1;

        $this->db->where('user_id', $user_id);
        $this->db->update('ap_users', $data);

        return true;
    }

    public function getUserCompanies($user_id) {

        $stmt = "SELECT user_id, company_id, user_n
                FROM ap_user_company
                WHERE user_id = '$user_id'";

        $result = $this->db->query($stmt)->result_array();

        $newresult = array();

        foreach ($result as $row) :
            $newresult[$row['company_id']][] = $row;
        endforeach;
        return $newresult;

    }

    public function saveUserCompany($user_id, $company_id) {

        $stmt_delete = "DELETE FROM ap_user_company WHERE user_id = '$user_id'";
        $this->db->query($stmt_delete);

        for ($x = 0; $x < count($company_id); $x++ ){
            $data['user_id'] = $user_id;
            $data['company_id'] = $company_id[$x];
            $data['user_n'] = $this->session->userdata('sess_user_id');
            $data['user_d'] = DATE('Y-m-d h:i:s');
            $data['edited_n'] = $this->session->userdata('sess_user_id');
            $data['edited_d'] = DATE('Y-m-d h:i:s');

            $this->db->insert('ap_user_company', $data);
        }
    return true;

    }

    public function setUserCompanyAccess($user_id, $module_functionx) {

        $explode = explode("&",$module_functionx);

        $stmt = "select * from user_module_functions where user_id = '$user_id' and module_id = '$explode[0]' and function_id = '$explode[1]'";

        $result = $this->db->query($stmt)->row_array();

        if (!empty($result)) {
            $stmt_delete = "delete from user_module_functions where user_id = '$user_id' and module_id = '$explode[0]' and function_id = '$explode[1]'";
            $this->db->query($stmt_delete);
        } else {
            $data['user_id'] = $user_id;
            $data['module_id'] = $explode[0];
            $data['function_id'] = $explode[1];
            //echo "pasok";
            //print_r($data); exit;

            $this->db->insert('user_module_functions', $data);
        }
    return true;

    }

    public function removeMultiData($user_id) {

        $data['is_deleted'] = 1;

        $this->db->where_in('user_id', $user_id);
        $this->db->update('ap_users', $data);

        return true;
    }

    public function getUserData($user_id) {

        $stmt = "SELECT user_id,
                        employee_id,
                        lastname,
                        firstname,
                        middlename,
                        username,
                        CONCAT(lastname,' , ', firstname,' ',SUBSTR(middlename,1,1),'. ') AS fullname,
                        salt,
                        email,
                        expiration_date,
                        is_deleted
                  FROM ap_users
                  WHERE is_deleted = '0' AND user_id = '$user_id'
                  ORDER BY user_id DESC";
         #echo "<pre>"; echo $stmt; exit;

        $row = $this->db->query($stmt)->row_array();

    return $row;

    }

    public function getUserList() {
        //all audit staff:

            $stmt = "SELECT user_id,
                            employee_id,
                            username,
                            userpass,
                            CONCAT(lastname,' , ', firstname,' ',SUBSTR(middlename,1,1),'. ') AS audit_staff,
                            email
                      FROM ap_users
                      WHERE is_deleted = '0'
                      ORDER BY user_id ASC";

            $result = $this->db->query($stmt);
            #echo '<pre>' echo $stmt ; exit;

        return $result->result_array();

    }

    public function getAuditStaff() {
        //all staff
            $stmt = "SELECT u.user_id,
                            u.employee_id,
                            u.username,
                            u.userpass,
                            CONCAT(e.last_name,' , ', e.first_name,' ',SUBSTR(e.middle_name,1,1),'. ') AS audit_staff,
                            e.email,
                            c.name AS department,
                            e.status
                      FROM ap_users AS u
                      LEFT OUTER JOIN hr_employees e ON e.code = u.employee_id
                      LEFT OUTER JOIN ap_dept c ON c.id = e.department
                      WHERE `status` IS NOT NULL
                      ORDER BY audit_staff ASC";

            $result = $this->db->query($stmt);

    return $result->result_array();

    }

    public function getNewAuditStaff() {
        //filter audit staff

        $stmt = "SELECT u.user_id,
                        u.employee_id,
                        u.username,
                        u.userpass,
                        CONCAT(e.last_name,' , ', e.first_name,' ',SUBSTR(e.middle_name,1,1),'. ') AS audit_staff,
                        e.email,
                        c.name AS department,
                        e.status
                  FROM ap_users AS u
                  LEFT OUTER JOIN hr_employees e ON e.code = u.employee_id
                  LEFT OUTER JOIN ap_dept c ON c.id = e.department
                  WHERE u.is_deleted = '0' AND department = '2014' AND STATUS IN ('2','3')
                  ORDER BY audit_staff ASC";

                  #echo "<pre>"; echo $stmt; exit;

        $result = $this->db->query($stmt);

    return $result->result_array();
    }


    public function saveNewUser($data) {

        /* Once User Inserted get Id */

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['expiration_date'] = date('Y-m-d', strtotime("+365 days"));
        $data['user_d'] = DATE('Y-m-d h:m:s');

        $this->db->insert('ap_users', $data);

        $user_id = $this->db->insert_id();

        $randomstring = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $salt = $user_id.''.substr(str_shuffle(str_repeat($randomstring,5)),0,75);


        $updatedData['salt'] = md5($salt);
        $encryptpass = md5($updatedData['salt'].'+'.$data['userpass']); //salt+userpass encrypted
        $updatedData['userpass'] = $encryptpass;

        $this->db->where('user_id', $user_id);
        $this->db->update('ap_users', $updatedData);

    return true;
    }

    public function saveupdateNewUser($data, $user_id) {

        $user_id = $this->session->userdata('sess_user_id');
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:m:s');

        $this->db->where('user_id', $user_id);
        $this->db->update('ap_users', $data);

        $randomstring = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $salt = $user_id.''.substr(str_shuffle(str_repeat($randomstring,5)),0,75);

        $updatedData['salt'] = md5($salt);
        $encryptpass = md5($updatedData['salt'].'+'.$data['userpass']); //salt+userpass encrypted
        $updatedData['userpass'] = $encryptpass;

        $this->db->where('user_id', $user_id);
        $this->db->update('ap_users', $updatedData);

        return true;

    }

    public function saveupdateUser($data, $user_id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:m:s');

        $this->db->where('user_id', $user_id);
        $this->db->update('ap_users', $data);

        return true;

    }

    public function validateCompany($company_id) {

        $stmt ="SELECT a.user_id,
                       uc.company_id,
                       b.name AS company_name,
                       employee_id,
                       username,
                       expiration_date,
                       expired,
                       salt,
                       email
                       FROM ap_users AS a
                       INNER JOIN ap_user_company AS uc ON a.user_id = uc.user_id
                       INNER JOIN hr_companies AS b ON uc.company_id = b.id
                       WHERE a.expired = 0 AND a.is_deleted = '0' AND uc.company_id = '$company_id'
                       ORDER BY a.user_id DESC";

        $row = $this->db->query($stmt)->row_array();


        return !empty($row) ? $row : 0;


    }

   /*Validate user for log-in*/
    public function validateUserName($username) {

        $stmt ="SELECT user_id,
                       employee_id,
                       username,
                       expiration_date,
                       expired,
                       salt,
                       email
                       FROM ap_users
                       WHERE username = '$username' AND is_deleted = '0'
                       ORDER BY user_id DESC";

        $row = $this->db->query($stmt)->row_array();


        return !empty($row) ? $row : 0;

    }

    public function validateUsernamePassword($username, $userpass, $salt) {

        $password = $salt.'+'.$userpass;    
        $stmt = "SELECT a.user_id,
                    employee_id,
                    uc.company_id,
                    b.name AS company_name,
                    username,
                    firstname,
                    CONCAT(lastname,', ',firstname,' ',SUBSTR(middlename,1,1),'. ')AS fullname,
                    salt,
                    email,
                    DATE(expiration_date) AS exp_date
                    FROM ap_users AS a
                    INNER JOIN ap_user_company AS uc ON a.user_id = uc.user_id
                    INNER JOIN hr_companies AS b ON uc.company_id = b.id
                    WHERE a.username = '$username' AND a.userpass = MD5('$password') AND a.is_deleted = '0'
                    ORDER BY a.user_id DESC";

                #echo "<pre>"; echo $stmt; exit;

        $row = $this->db->query($stmt)->row_array();

        return !empty($row) ? $row : 0;

    }

    /*Validate user for user maintenance*/
    public function validateUser($username) {

            $stmt ="SELECT user_id,
                       employee_id,
                       username,
                       expiration_date,
                       expired,
                       salt,
                       email
                       FROM ap_users
                       WHERE username = '$username' AND expired = 0 AND is_deleted = '0'
                       ORDER BY user_id DESC";

            $row = $this->db->query($stmt)->row_array();

        return $row;

    }

    public function validateExpirationdate ($username, $userpass, $salt) {

        $username = mysql_escape_string($username);
        $userpass = md5(mysql_escape_string($salt.'+'.$userpass));
        //$today = date('Y-m-d'); 
        $stmt ="SELECT user_id,
                CONCAT(firstname, ' ', middlename, ' ', lastname) AS fullname,
                username, expired, 
                DATE(expiration_date) AS exp_date
                FROM ap_users
                WHERE username = '".$username."' 
                AND userpass='".$userpass."' AND expired = '0' AND is_deleted = '0'
                ORDER BY user_id DESC";

        $row = $this->db->query($stmt)->row_array();

        $today = date('Y-m-d'); 
         //Validate user expiration date
        if ($today > $row['exp_date']) {
            $updatedata['expired'] = 1;
            $this->db->where('user_id', $row['user_id']);
            $this->db->update('ap_users', $updatedata);
            return 0;
        } else {
            return $row;
        }

    }

}
