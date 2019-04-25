<?php


class Mod_iccomponents extends CI_Model {


    public function getListofIccomponents($company) {
        //for maintenance

        $stmt = "SELECT * 
                FROM ap_iccomponent_p
                WHERE is_approved = '0' AND is_deleted = '0' AND company = '$company'";

        $result = $this->db->query($stmt)->result_array();

    return $result; 
    }

    public function getThisData($id) {
        //for maintenance

        $stmt = "SELECT * 
                FROM ap_iccomponent_p
                WHERE is_approved = '0' AND is_deleted = '0' AND id = '$id'";

        $result = $this->db->query($stmt)->row_array();

    return $result;
    }


    public function getTotalIccomponents($company) {
    //count total 

        $stmt = "SELECT COUNT(*) AS total_iccomponents
                FROM ap_iccomponent_p
                WHERE is_deleted = '0' AND is_approved = '0'";

        $row = $this->db->query($stmt)->row_array();

    return $row;
    }


    public function removeData($id) {

        $data['is_deleted'] = 1;

        $this->db->where('id', $id);
        $this->db->update('ap_iccomponent_p', $data);

    return true;
    }


    /*Save new for approval*/
    public function saveNewData($data) {

        $data['company'] = $this->session->userdata('sess_company_id');
        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        $data['status_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = 'A';

        $data['is_approved'] = 0;

        $this->db->insert('ap_iccomponent_p', $data);

    return true;
    }
    /*End*/

    /*Save new update for approval*/
    public function saveupdateNewData($data, $id) {

        $data['company'] = $this->session->userdata('sess_company_id');
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');

        $this->db->where('id', $id);
        $this->db->update('ap_iccomponent_p', $data);

    return true;

    /*End*/
    }


}
