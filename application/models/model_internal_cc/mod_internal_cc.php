<?php


class Mod_internal_cc extends CI_Model {


    public function getListofInternal_cc($company) {
    //for maintenance

        $stmt = "SELECT * 
                FROM ap_internal_cc
                WHERE is_approved = '0' AND is_deleted = '0' AND company = '$company'";

        $result = $this->db->query($stmt)->result_array();

    return $result;
    }


    public function getThisData($id) {
    //for maintenance

        $stmt = "SELECT * 
                FROM ap_internal_cc
                WHERE is_approved = '0' AND is_deleted = '0' AND id = '$id'";

        $result = $this->db->query($stmt)->row_array();

    return $result;
    }

    public function getTotalInternal_cc($company) {
    //count total 

        $stmt = "SELECT COUNT(*) AS total_internal_cc
                FROM ap_internal_cc
                WHERE is_deleted = '0' AND is_approved = '0'";

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }
    

    public function removeData($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_internal_cc', $data);

    return true;
    }

    public function disapproved($id) {

        $data['is_approved'] = '3'; //disapproved

        $this->db->where('id', $id);
        $this->db->update('ap_internal_cc', $data);

    return true;
    }

    /*Save new update for approval*/
    public function saveupdateNewData($data, $id) {

        $data['company'] = $this->session->userdata('sess_company_id');
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_internal_cc', $data);

    return true;

    /*End*/
    }

   public function saveNewData($data, $id, $code) {

        $data['company'] = $this->session->userdata('sess_company_id');
        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = 'A';

        $data['is_approved'] = 0;

        $this->db->insert('ap_internal_cc', $data);

    return true;

    }

}
