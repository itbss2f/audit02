<?php 

class Security extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        
        $this->load->model(array('model_global/globalmodel','model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks','model_auth/securities'));                  
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies'));                                  
    }
    
    public function mainmodule() {
        
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList(); 
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);  
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['data'] = $this->securities->getListOfMainmodules();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('security/mainmodule' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function module() {
        
        $data['canADD'] = $this->globalmodel->moduleFunction("security/module", 'ADD');            
        $data['canEDIT'] = $this->globalmodel->moduleFunction("security/module", 'EDIT');            
        $data['canDELETE'] = $this->globalmodel->moduleFunction("security/module", 'DELETE');            
        $data['canSET_FUNCTIONS'] = $this->globalmodel->moduleFunction("security/module", 'SET_FUNCTIONS');            
        
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval(); 
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);  
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);   
        $data['data'] = $this->securities->getListOfModules();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('security/module' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function functions() {
        
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);    
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['data'] = $this->securities->getAllFunction();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true); 
        $layout['content'] = $this->load->view('security/function' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }

    public function addmainmodule(){
    
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name')));   
        $data['description'] = strtoupper(mysql_real_escape_string($this->input->post('description'))); 
          
        $response['addmainmodule'] = $this->load->view('security/addmainmodule', $data, true);
        
        echo json_encode($response);
    }
    
    public function addfunctionmodule() {
        
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name')));   
        $data['description'] = strtoupper(mysql_real_escape_string($this->input->post('description'))); 
          
        $response['addfunctionmodule'] = $this->load->view('security/addfunctionmodule', $data, true);
        
        echo json_encode($response);
        
    }
    
    public function addmodule() {
        $data['main'] = $this->securities->getListOfMainmodules();
        
        $response['addmodule'] = $this->load->view('security/addmodule', $data, true); 
        
        echo json_encode($response);
        
    }
    
    public function editmainmodule(){
        
        $id = $this->input->post('id');   
        $data['data'] = $this->securities->getThismainmodule($id); 
        $response['editmainmodule'] = $this->load->view('security/editmainmodule', $data, true);
        
        echo json_encode($response);
    }
    
    public function editmodule(){
        
        $id = $this->input->post('id');
        $data['main'] = $this->securities->getListOfMainmodules();   
        $data['data'] = $this->securities->getThismodule($id); 
        $response['editmodule'] = $this->load->view('security/editmodule', $data, true);
        
        echo json_encode($response);
    }
    
    public function editfunctionmodule() {
        
        $id = $this->input->post('id');
        $data['data'] = $this->securities->getThisFunctions($id); 
        $response['editfunctionmodule'] = $this->load->view('security/editfunctionmodule', $data, true);
        
        echo json_encode($response);
    }
    
    public function removemainmodule($id) {
        
        $this->securities->removemainmodule($id);
        redirect('security/mainmodule');
    }
    public function removemodule($id) {

        $this->securities->removemodule($id);
        redirect('security/module');
    }
    
    public function removefunction($id) {
        
        $this->securities->removefunction($id);
        redirect('security/functions');

    }
    
    public function savemainmodule() {
        
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name_main')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        
        $this->securities->savenewmainmodule($data);
        redirect('security/mainmodule');  
    }
    
    public function savenewfunction() {
        
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name_function')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        
        $this->securities->savenewfunction($data);
        redirect('security/functions');  
    }
    
    public function savenewmodule() {
        
        $data['main_modules_id'] = $this->input->post('module_name');
        $data['name'] = ucfirst(strtolower($this->input->post('name')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        $data['segment_path'] = $this->input->post('path');
        
        $this->securities->savenewmodule($data);
        redirect('security/module');
    }
    
    public function updatemainmodule($id) {
        
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name_main')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        
        $this->securities->saveupdatemainmodule($data, $id);
        redirect('security/mainmodule');
    }
    
    public function updatefunctionmodule($id) {
        
        $data['name'] = strtoupper(mysql_real_escape_string($this->input->post('name')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        
        $this->securities->saveupdatefunctionmodule($data, $id);
        redirect('security/functions');
    }
    
    public function updatemodule($id) {
        
        $data['main_modules_id'] = $this->input->post('module_name');
        $data['name'] = ucfirst(strtolower($this->input->post('name')));
        $data['description'] = strtolower(mysql_real_escape_string($this->input->post('description')));
        $data['segment_path'] = $this->input->post('path');
        
        $this->securities->saveupdatemodule($data, $id);
        redirect('security/module');
    }
    
    public function setfunctionmod() {
        
        $id = $this->input->post('id');
        $data['module'] = $this->securities->getThismodule($id);//all module with this id
        $data['modfunc'] = $this->securities->getSpecificModuleFunction($id);                    
        $data['function'] = $this->securities->getAllFunction(); //all function  
        $response['setfunctionmod'] = $this->load->view('security/setfunctionmod', $data, true);
        
        echo json_encode($response);
        
    }
    
    public function savefunctionmodule() {
        //set a function in module
        $module_id = $this->input->post('_module');
        $functions = $this->input->post('funct');  
        
        $this->securities->saveFunctionModule($module_id, $functions);
        redirect('security/module');  
    }
    
}    
