<?php 

class Risk_rating extends CI_Controller {
    
     
    public function __construct() {
        
        parent::__construct();
        //$this->sess = $this->authlib->validate(); 
        $this->load->model(array('model_risk_rating/risk_ratings'));                  
    }
    
    public function newdata() {
        
        $data['ap_risk_rating'] = $this->risk_ratings->getRates(); 
        
        $layout['content'] = $this->load->view('risk_rating/newdata' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function save() {
    
        $data['code'] = $this->input->post('code');  
        $data['description'] = $this->input->post('description');  

        $this->risk_ratings->saveNewData($data);

        redirect('risk_rating/newdata');
    }
    
    public function listofrisk_rating() { 
        
        $data['data'] = $this->risk_ratings->getRates();
        $layout['content'] = $this->load->view('risk_rating/listofrisk_rating', $data, true);
        $this->load->view('welcome_index', $layout); 
    }
    
    public function editdata($id = null) { 
        
        $data['data'] = $this->risk_ratings->getThisData($id); 
        $layout['content'] = $this->load->view('risk_rating/editdata', $data, true);
        $this->load->view('welcome_index', $layout);       
        
    }
    
    public function update($id) {
        
        $data['code'] = $this->input->post('code');
        $data['description'] = $this->input->post('description');
        
        $this->risk_ratings->saveupdateNewData($data, $id);
        
        redirect('risk_rating/newdata');  
    }
    
    public function removedata($id) {
        
        $this->risk_ratings->removeData($id);
         
        redirect('risk/newdata');
    }
    
}   





?> 
