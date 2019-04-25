<?php 

class Risk_ratings extends CI_Model {

    public function getRates() {
        
        $stmt = "SELECT id,`code`, description, is_deleted
                FROM ap_risk_rating
                ORDER BY description ASC";
        
        $result = $this->db->query($stmt)->result_array();
        return $result;
    }
    
    public function removeData($id) {

        $data['is_deleted'] = 1;
        
        $this->db->where('id', $id);
        $this->db->update('ap_risk_rating', $data);

    return true; 
           
    }
    
    public function saveNewData($data) {
        
        $data['user_d'] = DATE('Y-m-d h:m:s');
        $data['status_d'] = DATE('Y-m-d h:m:s');

        $this->db->insert('ap_risk_rating', $data);  

    return true;
      
    }
    
    public function getThisData($id) {
         
        $stmt = "SELECT id,`code`, description, is_deleted
                FROM ap_risk_rating                                                                                                                                                                                         
                WHERE is_deleted = 0 AND id = '$id'
                ORDER BY `id` DESC"; 
        #echo "<pre>"; echo $stmt; exit;
        $result = $this->db->query($stmt)->row_array();

    return $result;
    
    }
    
    public function saveupdateNewData($data, $id) {
    
        //$data['edited_n'] = $this->session->userdata('authsess')->sess_id;
        $data['edited_d'] = DATE('Y-m-d h:m:s');
        
        
        $this->db->where('id', $id); 
        $this->db->update('ap_risk_rating', $data);
    
    return true;  
      
    }
     
}

