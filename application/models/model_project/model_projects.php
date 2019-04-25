
<?php

class Model_projects extends CI_Model {

    public function removeData($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_project', $data);

    return true;
    }

    public function removeMultiData($id) {

        $data['is_deleted'] = 1;

        $this->db->where_in('id', $id);
        $this->db->update('ap_project', $data);

    return true;
    }

    public function getTotalProjectForApproval($company) {
        //count projects for approval

        $stmt = "SELECT COUNT(*) AS projects
                FROM ap_project
                WHERE is_deleted = '0' AND is_approved = '1' AND company = '$company'";

        #echo $stmt ; exit;

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }

    public function getTotalProjects($company) {
        //count of total projects

        $stmt = "SELECT COUNT(*) AS total_projects
                FROM ap_project
                WHERE is_deleted = '0' AND is_approved = '0' AND company = '$company'";

        $row = $this->db->query($stmt);

    return $row->row_array();

    }

    public function getProjects($company) {
        //projects for transaction

        $stmt = "SELECT id,`code`, company, description, date_release, edited_d, user_n, user_d , `status`,is_deleted
                FROM ap_project
                WHERE is_deleted = 0 AND is_approved = 0 AND company = '$company'
                ORDER BY description ASC";

        $result = $this->db->query($stmt);

    return $result->result_array();

    }

     public function saveNewProjectDatawithApproval($data, $id) {
    /*Save new project's by approver*/

        $data['status'] = 'A';
        $data['is_approved'] = 0;

        $this->db->where('id', $id);
        $this->db->update('ap_project', $data);

        #echo print_r2($data); exit;

    return true;
    /*End*/
    }

    public function getListofProjects($company) {
        //list of projects

        $stmt = "SELECT a.*, ap.username AS username
                FROM ap_project AS a
                LEFT OUTER JOIN ap_users AS ap ON ap.user_id = a.user_n
                WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.company = '$company'
                ORDER BY a.id ASC";

        $result = $this->db->query($stmt);

    return $result->result_array();
    }

    public function getListofProjectsForApproval($company) {
        //list of project for approval

        $stmt = "SELECT id,`code`, company, description, date_release, edited_d, user_n, user_d , `status`,is_deleted
                FROM ap_project
                WHERE is_deleted = 0 AND is_approved = 1 AND company = '$company'
                ORDER BY id ASC";

        $result = $this->db->query($stmt);

    return $result->result_array();

    }

    public function getThisProjectforApproval($id) {

        $stmt = "SELECT id, `code`,company, description, impact, date_release ,edited_d, user_n, user_d ,status, is_deleted
                FROM ap_project
                WHERE is_deleted = 0 AND is_approved = '1' AND id = '$id'
                ORDER BY id DESC";

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }

    public function getThisData($id) {
        //for editing

        $stmt = "SELECT id, `code`,company, description, impact, date_release ,edited_d, user_n, user_d ,status, is_deleted
                FROM ap_project
                WHERE is_deleted = 0 AND id = '$id'
                ORDER BY id DESC";
        #echo "<pre>"; echo $stmt; exit;
        $row = $this->db->query($stmt)->row_array();

    return $row;
    }

    public function saveNewData($data) {

        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:m:s');
        $data['status_d'] = DATE('Y-m-d h:m:s');

        $randomstring = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = rand(10000000, 99999999);
        $prefix = "FA";
        $data['code'] = $prefix . $numbers . $randomstring;
        $data['is_approved'] = 1;


        $this->db->insert('ap_project', $data);

    return true;

    }

    public function saveupdateNewData($data, $id) {

        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_project', $data);

    return true;

    }

    public function disapproved($id) {

        $data['is_approved'] = 2;

        $this->db->where('id', $id);
        $this->db->where('ap_project', $data);

    return true;

    }

    public function getProjectCurrentData($company, $id) {

        $stmt = "SELECT a.*, ap.username AS username
                FROM ap_project AS a
                LEFT OUTER JOIN ap_users AS ap ON ap.user_id = a.user_n
                WHERE a.is_deleted = 0 AND a.is_approved = 0 AND a.company = '$company' AND id = '$id'
                ORDER BY a.id ASC";


        $result = $this->db->query($stmt)->row_array();
        return $result;
    }

    public function getFileAttachmentofProjectData($company, $id) {
        
        $stmt = "SELECT a.*, b.username
                FROM proj_dataupload AS a
                LEFT OUTER JOIN ap_users AS b ON b.user_id = a.uploadby
                WHERE a.projectid = '$id' AND a.is_deleted = 0 AND a.company = '$company' 
                ORDER BY a.id ASC";
        
          $result = $this->db->query($stmt)->result_array(); 
        
        return $result;

    }

    public function getFileattachmentofProjectDataUpload($company, $id) {
        
        $stmt = "SELECT a.*, b.username
                FROM proj_dataupload AS a
                LEFT OUTER JOIN ap_users AS b ON b.user_id = a.uploadby
                WHERE a.id = '$id' AND a.is_deleted = 0 AND a.company = '$company'
                ORDER BY a.id ASC";
        
        $result = $this->db->query($stmt)->row_array();  
        
        return $result;

    }

    public function saveDataUpload($data){

        $data['company'] = $this->session->userdata('sess_company_id');  
        $data['uploadby'] = $this->session->userdata('sess_user_id');
        $data['uploaddate'] = DATE('Y-m-d h:i:s');
        $data['reuploadby'] = $this->session->userdata('sess_user_id');
        $data['reuploaddate'] = DATE('Y-m-d h:i:s');       
         
        $this->db->insert('proj_dataupload', $data);  
        
    return true;  
    
    }

    public function removeupload($id) {
        
        $data['is_deleted'] = 1;
        
        $this->db->where('id', $id);            
        $this->db->update('proj_dataupload', $data);
        
    return true;        
        
    }

}
