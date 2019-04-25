<?php 

class Model_risks extends CI_Model {
    
    public function getRisksForRisk2z($idx, $id2, $id1) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id NOT IN ('$idx', '$id2', '$id1') 
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();
            
    return $result;
          
    }
    
    public function getRiskForRisk1z($idx, $xrisks) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id != '$idx' AND id != '$xrisks'
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();
            
    return $result;
        
    }
    
    public function getRisksForRisk3x($id, $id1, $id3) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id NOT IN ('$id', '$id1', '$id3')
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();
            
    return $result;
        
    }
    
    public function getRiskForRisk1x($id, $risks) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id != '$id' AND id != '$risks'
                ORDER BY description ASC";
                
                #print_r2($stmt); exit;

        $result = $this->db->query($stmt)->result_array();
            
    return $result;
        
    }
    
    public function getRiskForRisk3($id, $risks) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id != '$id' AND id != '$risks'
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();
            
    return $result;

    }
    
    public function getRisksForRisk2($id) {
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0 AND id != '$id' 
                ORDER BY description ASC";

        $result = $this->db->query($stmt)->result_array();
        
            
    return $result;                
        
    }
    
    public function removedata($id) {

        $data['is_deleted'] = 1;
        
        $this->db->where('id', $id);
        $this->db->update('ap_risk', $data);

    return true; 
           
    }
    
    public function disapproved($id) {
        
        $data['is_approved'] = 2;
        
        $this->db->where('id', $id);
        $this->db->update('ap_risk', $data);

    return true; 
        
        
    }
    
    public function removeMultiData($id){
        
        $data['is_deleted'] = 1;
        
        $this->db->where_in('id', $id);
        $this->db->update('ap_risk', $data);

    return true;
        
    }
    
    public function getRiskForApproval() {
        //count for risk of approval
    
        $stmt = "SELECT COUNT(*) AS risks 
                FROM ap_risk
                WHERE is_deleted = '0' AND is_approved = '1'"; 
                
        $row = $this->db->query($stmt)->row_array();
            
    return $row;            
    }
    
    public function getTotalRisk() {
        //count for total risk
        
        $stmt = "SELECT COUNT(*) AS total_risk 
                FROM ap_risk
                WHERE is_deleted = '0' AND is_approved = '0'";
        
        $row = $this->db->query($stmt)->row_array();
    
    return $row;
        
    }
    
    public function getTotalRiskForApproval() {
        
        $stmt = "SELECT COUNT(*) AS totalforApprove_risk 
                FROM ap_risk
                WHERE is_deleted = '0' AND is_approved = '1'";
        $row = $this->db->query($stmt)->row_array();
            
    return $row;                    
    }
    
    public function getRisk() {
        //use for transaction
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted
                FROM ap_risk
                WHERE is_deleted = 0
                ORDER BY description ASC";
                
        #echo "<pre>"; echo $stmt; exit; 
        $result = $this->db->query($stmt)->result_array();
        
    return $result;
        
    }
    
    public function getListforApproval() {
        //list for approval
        
        $stmt = "SELECT id, `code`, description, `status`, user_n ,user_d, edited_d, edited_n, is_deleted, is_approved
                FROM ap_risk
                WHERE is_deleted = 0 AND is_approved = 1
                ORDER BY id ASC";
                
        #echo "<pre>"; echo $stmt; exit; 
        $result = $this->db->query($stmt)->result_array();
        
    return $result;
        
        
    }        
    
    public function getListofRisks() {
        //lisk of risk
        
        $stmt = "SELECT a.*, ap.username AS username 
                FROM ap_risk AS a
                LEFT OUTER JOIN ap_users AS ap ON ap.user_id = a.user_n 
                WHERE a.is_deleted = 0 AND a.is_approved = 0 
                ORDER BY a.id ASC";
                
        #echo "<pre>"; echo $stmt; exit; 
        $result = $this->db->query($stmt)->result_array();
        
    return $result;
        
    }
    
    public function saveNewData($data) {
        
        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['status_d'] = DATE('Y-m-d h:i:s');
        $data['status'] = 'A'; 
        $data['user_d'] = DATE('Y-m-d h:i:s');
        
        $randomstring = '123456789'; 
        $data['code'] = substr(str_shuffle(str_repeat($randomstring,5)),0,75); 
        
        $data['is_approved'] = 1;

        $this->db->insert('ap_risk', $data);  

    return true;
      
    }
    
    public function getMaxRiskCode() {
        
        $stmt = "SELECT MAX(CODE) AS code
                FROM ap_risk
                WHERE is_approved = 0"; 
                  
        $result = $this->db->query($stmt)->result_array();

    #echo "<pre>"; echo $stmt; exit;
    return $result;        
    }
    
    public function getThisData($id) {
        //approved data
         
        $stmt = "SELECT id, `code`, description, `status`, user_n , user_d, edited_d, edited_n, is_deleted  
                FROM ap_risk                                                                                                                                                                                         
                WHERE is_deleted = 0 AND is_approved = 0 AND id = '$id'
                ORDER BY id DESC"; 

        $row = $this->db->query($stmt)->row_array();

    return $row;
    
    }
    
    public function getThisDataForApproval($id) {
        //for approval data 
        
         $stmt = "SELECT id, `code`, description, `status`, user_n , user_d, edited_d, edited_n, is_deleted  
                FROM ap_risk                                                                                                                                                                                         
                WHERE is_deleted = 0 AND is_approved = 1 AND id = '$id'
                ORDER BY id DESC"; 

        $row = $this->db->query($stmt)->row_array();

    return $row;
        
    }
    
    public function saveupdateNewData($data, $id) {
    
        $data['edited_n'] = $this->session->userdata('sess_user_id');
        $data['edited_d'] = DATE('Y-m-d h:i:s');
        
        
        $this->db->where('id', $id); 
        $this->db->update('ap_risk', $data);
    
    return true;  
      
    } 
    
    public function saveNewDatawithApproval($data, $id, $code) {
    /*Save new risk's with approval by:*/
        
        $data['user_n'] = $this->session->userdata('sess_user_id');
        $data['status_d'] = DATE('Y-m-d h:i:s');
        $data['user_d'] = DATE('Y-m-d h:i:s');
        
        $lastcode = $code + 1;
        $data['code'] = str_pad($lastcode,3,"0", STR_PAD_LEFT); 
  
        $data['is_approved'] = 0;

        $this->db->where('id', $id);
        $this->db->update('ap_risk', $data);

    return true;
    
    /*End*/          
    }
    
    
}

