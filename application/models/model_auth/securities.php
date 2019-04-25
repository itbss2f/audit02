<?php

class Securities extends CI_Model {

    public function getCompanyForThisUsername($username) {

        $stmt = "SELECT au.user_id, auc.company_id, hc.name
                FROM ap_users AS au
                INNER JOIN ap_user_company AS auc ON au.user_id = auc.user_id
                INNER JOIN hr_companies AS hc ON auc.company_id = hc.id
                WHERE au.username = '$username' AND auc.company_id != '8'
                ORDER BY company_id";

        $result = $this->db->query($stmt)->result_array();

    return $result;

    }

    public function getListOfMainmodules() {

        $stmt = "SELECT id, name, description, `order`
                FROM ap_main
                WHERE is_deleted = 0
                ORDER BY `order`";

        $row = $this->db->query($stmt)->result_array();

        return $row;
    }

    public function getListOfModules() {

        $stmt = "SELECT a.id, a.main_modules_id,a.name, a.description, a.segment_path, main.name AS module_name
                FROM ap_modules AS a
                LEFT OUTER JOIN ap_main AS main ON main.id = a.main_modules_id
                WHERE a.is_deleted = 0
                ORDER BY a.id";

        $result = $this->db->query($stmt)->result_array();

        return $result;

    }

     public function getAllFunction() {

        $stmt = "SELECT id, name, description
                FROM ap_functions
                WHERE is_deleted = 0";

        $row = $this->db->query($stmt)->result_array();

        return $row;
    }

    public function getThismainmodule($id) {

        $stmt = "SELECT id, name, description
                FROM ap_main
                WHERE is_deleted = 0 AND id = '$id'
                ORDER BY order";

        $row = $this->db->query($stmt)->row_array();

        return $row;

    }

    public function getThismodule($id){

        $stmt = "SELECT a.id, a.main_modules_id,a.name, a.description, a.segment_path, main.name AS module_name
                FROM ap_modules AS a
                LEFT OUTER JOIN ap_main AS main ON main.id = a.main_modules_id
                WHERE a.is_deleted = 0 AND a.id = '$id'
                ORDER BY a.id";

        $row = $this->db->query($stmt)->row_array();

        return $row;

    }

    public function getThisFunctions($id) {

        $stmt = "SELECT id, name, description
                FROM ap_functions
                WHERE is_deleted = 0 AND id = '$id'";

        $row = $this->db->query($stmt)->row_array();

        return $row;
    }

    public function getSpecificModuleFunction($id) {
        //select specific module

        $stmt = "SELECT a.module_id, a.function_id
                FROM ap_module_functions AS a
                WHERE a.module_id = '$id'";

        $result = $this->db->query($stmt)->result_array();

        $newresult = array();

        foreach ($result as $row) :
            $newresult[$row['function_id']][] = $row;
        endforeach;
        return $newresult;


    }

    public function main_module_list($mainx, $user_id) {

        $stmt = "SELECT a.id AS moduleid, a.name AS modulename, a.id AS moduleid, c.name AS functionname ,
                c.id AS functionid, IFNULL(umf.id, 999999) AS useraccess, umf.*
                FROM ap_modules AS a
                INNER JOIN ap_module_functions AS b ON a.id = b.module_id
                INNER JOIN ap_functions AS c ON b.function_id = c.id
                LEFT OUTER JOIN user_module_functions AS umf ON (umf.user_id = '$user_id' AND umf.module_id = a.id AND umf.function_id = c.id)
                WHERE a.main_modules_id = '$mainx' AND a.is_deleted = 0 GROUP BY a.id, c.id
                ORDER BY a.id";

        $result = $this->db->query($stmt)->result_array();
        #print_r2($result); exit;

        $newresult = array();

        foreach ($result as $row) :
            $newresult[$row['modulename']][] = $row;
        endforeach;
        return $newresult;
    }

    public function saveFunctionModule($module_id, $functions) {
        // Delete all function of $module_id;
        //and save function that set in module;

        $stmt_delete = "DELETE FROM ap_module_functions WHERE module_id = $module_id";
        $this->db->query($stmt_delete);

        for ($x = 0; $x < count($functions); $x++ ) {
            $data['module_id'] = $module_id;
            $data['function_id'] = $functions[$x];
            $data['user_n'] = $this->session->userdata('sess_user_id');
            $data['user_d'] = DATE('Y-m-d h:i:s');
            $data['edited_n'] = $this->session->userdata('sess_user_id');
            $data['edited_d'] = DATE('Y-m-d h:i:s');

            $this->db->insert('ap_module_functions', $data);
        }
    return true;

    }

    public function savenewmainmodule($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');

        $this->db->insert('ap_main', $data);

    return true;
    }

    public function savenewfunction($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');

        $this->db->insert('ap_functions', $data);

    return true;

    }

    public function savenewmodule($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');

        $this->db->insert('ap_modules', $data);

    return true;


    }

    public function saveupdatemainmodule($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_main', $data);

    return true;
    }

    public function saveupdatemodule($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_modules', $data);

    return true;

    }

    public function saveupdatefunctionmodule($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_functions', $data);

    return true;

    }

    public function removemainmodule($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_main', $data);

    return true;
    }

    public function removemodule($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_modules', $data);

    return true;
    }

    public function removefunction($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_functions', $data);

    return true;
    }

    /*public function authactivitylog($userid, $activity) {

        $data['user_id'] = $userid;
        $data['activity'] = $activity;
        if ($activity == 'LOGOUT') {
            $data['remarks'] = 'User Logout';
        } else if ($activity == 'LOGIN') {
            $data['remarks'] = 'User Login';
        } else if ($activity == 'LOGINFAILED') {
            $data['remarks'] = 'User Login Attempt Failed!.';
        }

        $this->db->insert('ap_auditdblogs.activitylogs', $data);
    }*/


}
