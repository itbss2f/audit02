<?php 

class Company extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        } 
        $this->load->model(array('model_user/users','model_companies/companies'));
        
    }
    
    public function index() {
        
        $this->load->view('auth/companies');
    }
            
        
}    