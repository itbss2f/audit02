<?php 

class Entry extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));                  
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies'));                                  
    }
    
    public function index() {
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$userprofile['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$layout['userprofile'] = $this->load->view('userprofile', $userprofile, true);  
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);  
        $layout['content'] = $this->load->view('userprofile', $data, true);
        $this->load->view('welcome_index', $layout); 
    }
    
    public function dashboard() {
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);  
        $layout['content'] = $this->load->view('dashboard', $data, true);
        $this->load->view('welcome_index', $layout);
        
    }
    
    public function newdata() {
        
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();  
        $data['ap_issue'] = $this->model_issues->getIssues(); 
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['emp'] = $this->model_employees->getAllEmployees($company); 
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();  
        $data['ap_risk2'] = $this->model_risks->getRisk();  
        $data['ap_risk3'] = $this->model_risks->getRisk();  
        $data['ap_project'] = $this->model_projects->getProjects(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval(); 
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);   
        $layout['content'] = $this->load->view('entry/newdata' , $data, true);    
        $this->load->view('welcome_index', $layout);
         
    }
    
    public function save() {
    
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;     
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['impact_remarks'] = $this->input->post('impact_remarks');   
        $data['impact_value'] = $this->input->post('impact_value'); 
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');             
        $data['issue_remarks'] = $this->input->post('issue_remarks');       
        $data['remarks'] = $this->input->post('remarks');       
        $data['action_plan'] = $this->input->post('action_plan');       
        $data['risk1'] = $this->input->post('risk1');       
        $data['risk2'] = $this->input->post('risk2');       
        $data['risk3'] = $this->input->post('risk3');                                    
        $data['assigned_audit'] = $this->input->post('assigned_audit');       
        $data['project_id'] = $this->input->post('project_id');       
        $data['status'] = $this->input->post('status');
        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value)); 
        }else {
            $data['impact_value'] = null;  
        }   
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d');
        }else {
            $data['date_tag'] = null; 
        }
        $due_date = $this->input->post('due_date');
         if (!empty($due_date)) {
            $data['due_date'] = date('Y-m-d', strtotime($due_date));    
        }   else {
            $data['due_date'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');        
        if (!empty($date_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($date_implemented));       
        }   else {
            $data['date_implemented'] = null;
        }
        $date_revised = $this->input->post('date_revised');
        if (!empty($date_revised)) {
            $data['date_revised'] = date('Y-m-d', strtotime($date_revised));         
        }   else {
            $data['date_revised'] = null;
        }
    
        /*save new action plan:*/   
        if ($this->input->post('save') == 'save') {
             $this->model_entry->saveNewData($data); 
            }
        redirect('entry/newdata');
    }
    
    public function saveduplicate() {
        
        $data['code'] = $this->input->post('code');
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $company = $this->session->userdata('sess_company');  
        $data['impact_remarks'] = $this->input->post('impact_remarks');   
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');             
        $data['issue_remarks'] = $this->input->post('issue_remarks');       
        $data['remarks'] = $this->input->post('remarks');       
        $data['action_plan'] = $this->input->post('action_plan');       
        $data['risk1'] = $this->input->post('risk1');       
        $data['risk2'] = $this->input->post('risk2');       
        $data['risk3'] = $this->input->post('risk3');                                    
        $data['assigned_audit'] = $this->input->post('assigned_audit');       
        $data['project_id'] = $this->input->post('project_id');       
        $data['status'] = $this->input->post('status');
        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value)); 
        }else {
            $data['impact_value'] = null;  
        }   
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d');
        }else {
            $data['date_tag'] = null; 
        }
        $due_date = $this->input->post('due_date');
         if (!empty($due_date)) {
            $data['due_date'] = date('Y-m-d', strtotime($due_date));    
        }   else {
            $data['due_date'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');        
        if (!empty($date_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($date_implemented));       
        }   else {
            $data['date_implemented'] = null;
        }
        $date_revised = $this->input->post('date_revised');
        if (!empty($date_revised)) {
            $data['date_revised'] = date('Y-m-d', strtotime($date_revised));         
        }   else {
            $data['date_revised'] = null;
        }
        
        if ($this->input->post('save') == 'duplicate'){
            $this->model_entry->saveNewDuplicate($data);
        }
        
        redirect('entry/listforApproval');
    }
    
    public function editAction($id = null) {
    
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();   
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['dept'] = $this->departments->getAllDepartment($company);  
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['emp_2'] = $this->model_employees->getAllEmployees($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();  
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects();
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval(); 
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id); 
        $data['data'] = $this->model_entry->getThisData($id); 
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/editAction' , $data, true);    
        $this->load->view('welcome_index', $layout);
        
    }
    
    public function editActionfa($id = null) {
        
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id'); 
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['dept'] = $this->departments->getAllDepartment($company);  
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['emp_2'] = $this->model_employees->getAllEmployees($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();  
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects();
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval(); 
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id); 
        $data['data'] = $this->model_entry->getThisData($id); 
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/editActionfa' , $data, true);    
        $this->load->view('welcome_index', $layout);
        
    }
    
    public function viewActionPlan($id = null) {
        
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id'); 
        $navigation['data'] = $this->globalmodel->moduleList(); 
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['dept'] = $this->departments->getAllDepartment($company);  
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['emp_2'] = $this->model_employees->getAllEmployees($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();  
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects();
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval(); 
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id); 
         
        $data['data'] = $this->model_entry->getThisData($id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true); 
        $layout['content'] = $this->load->view('entry/viewActionPlan' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    /*public function validateCode($id) {
        
        $company = $this->session->userdata('sess_company_id'); 
        
        $xlist - $this->model_entry->getActionCode($company);
        
        foreach($xlist as $row) {
            $code = $row['code'];
        }
        
        if ($row['code'] != $row['code']) {}
        
        
    }*/
    
    public function approved($id) {

        $list = $this->model_entry->getActionCode();
        
        foreach($list as $row) {
            $code = $row['code'];
            
            #print_r2($code); exit;
        }
        
        $this->model_entry->saveNewDatawithApproval($data, $id, $code); 
        
        redirect('entry/listforApproval');
    }
    
    public function listofAction() {
        
        if ($post = $this->input->post()) {
                $data['message'] = 'Successfully deleted!';  
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_entry->removeMultiData($id);
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/listofAction", 'MULTI_DELETE');            
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/listofAction", 'EDIT');                  
        $data['canDELETE'] = $this->globalmodel->moduleFunction("entry/listofAction", 'DELETE');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/listofAction", 'VIEW');
    
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();  
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id); 
        
        $data['data'] = $this->model_entry->getThisActionPlan($company, $user_id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/listofAction' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function listforApproval() {
        
        if ($post = $this->input->post()) {
            $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_entry->removeMultiData($id);
                }   elseif ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                    //$this->model_entry->approvedMultiData($id);  
                } 
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'MULTI_DELETE');            
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'MULTI_APPROVED');            
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'EDIT');                  
        $data['canDELETE'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'DELETE');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'VIEW');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'APPROVED');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry/listforApproval", 'DUPLICATE');
        
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval(); 
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id); //all total for approval
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company); // total for approval(action plan)
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id); // total action plan display. 
        
        $data['data'] = $this->model_entry->getThisEntryforApproval($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/listforApproval', $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function updateaction($id) {

        /*update for actionplan:*/
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company; 
        $data['code'] = $this->input->post('code');   
        $data['impact_remarks'] = $this->input->post('impact_remarks');   
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');             
        $data['issue_remarks'] = $this->input->post('issue_remarks');       
        $data['remarks'] = $this->input->post('remarks');       
        $data['action_plan'] = $this->input->post('action_plan');       
        $data['risk1'] = $this->input->post('risk1');       
        $data['risk2'] = $this->input->post('risk2');       
        $data['risk3'] = $this->input->post('risk3');                                    
        $data['assigned_audit'] = $this->input->post('assigned_audit');       
        $data['project_id'] = $this->input->post('project_id');       
        $data['status'] = $this->input->post('status');
        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value)); 
        }else {
            $data['impact_value'] = null;  
        }       
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d');
        }else {
            $data['date_tag'] = null; 
        }
        $due_date = $this->input->post('due_date');
        if (!empty($due_date)) {
            $data['due_date'] = date('Y-m-d', strtotime($due_date));    
        }else {
            $data['due_date'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');        
        if (!empty($date_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($date_implemented));       
        }else {
            $data['date_implemented'] = null;
        }
        $date_revised = $this->input->post('date_revised');
        if (!empty($date_revised)) {
            $data['date_revised'] = date('Y-m-d', strtotime($date_revised));         
        }else {
            $data['date_revised'] = null;
        }  

        /*save update action plan:*/  
        $this->model_entry->saveupdateNewData($data, $id);
        redirect('entry/listofAction');
    }
    
    public function updateactionfa($id) {

        /*update for actionplan for approval:*/
        $company = $this->session->userdata('sess_company_id'); 
        $data['company'] = $company;
        $data['code'] = $this->input->post('code');
        $data['impact_remarks'] = $this->input->post('impact_remarks');   
        $data['impact_value'] = $this->input->post('impact_value');
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');             
        $data['issue_remarks'] = $this->input->post('issue_remarks');       
        $data['remarks'] = $this->input->post('remarks');       
        $data['action_plan'] = $this->input->post('action_plan');       
        $data['risk1'] = $this->input->post('risk1');       
        $data['risk2'] = $this->input->post('risk2');       
        $data['risk3'] = $this->input->post('risk3');                                    
        $data['assigned_audit'] = $this->input->post('assigned_audit');       
        $data['project_id'] = $this->input->post('project_id');       
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['status'] = $this->input->post('status');
        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value)); 
        }else {
            $data['impact_value'] = null;  
        }   
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d');
        }else {
            $data['date_tag'] = null; 
        }
        $due_date = $this->input->post('due_date');
        if (!empty($due_date)) {
            $data['due_date'] = date('Y-m-d', strtotime($due_date));    
        }else {
            $data['due_date'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');        
        if (!empty($date_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($date_implemented));       
        }else {
            $data['date_implemented'] = null;
        }
        $date_revised = $this->input->post('date_revised');
        if (!empty($date_revised)) {
            $data['date_revised'] = date('Y-m-d', strtotime($date_revised));         
        }else {
            $data['date_revised'] = null;
        }  

        /*save update action plan:*/  
        $this->model_entry->saveupdateNewData($data, $id);
        redirect('entry/listforApproval');
    }
    
    public function removeApproval($id) {
        /*For Approval remove*/
        $this->model_entry->removeData($id);
        redirect('entry/listforApproval');
    }
    
    public function removeAction($id) {
        
        $this->model_entry->removeData($id);
        redirect('entry/listofAction');
    }
    
    public function duplicateOfActionPlan($id = null) {
        
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');  
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['dept'] = $this->departments->getAllDepartment($company);  
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['emp_2'] = $this->model_employees->getAllEmployees($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();  
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects();
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval();
        
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);  
        $data['data'] = $this->model_entry->getThisData($id); 
        $layout['content'] = $this->load->view('entry/duplicateOfActionPlan' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    /*public function status_of_actionplan() {
        
        $data['ap_issue'] = $this->model_issues->getIssues(); 
        $data['company'] = $this->companies->getCompanies(); 
        $data['ap_risk_rating'] = $this->risk_ratings->getRates(); 
        $data['emp'] = $this->model_employees->getEmployees(); 
        $data['dept'] = $this->departments->getDepartment();
        $data['ap_risk'] = $this->model_risks->getRisk();  
        $data['ap_project'] = $this->model_projects->getProjects(); 
        $data['ap_users'] = $this->users->getAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus(); 
        $layout['content'] = $this->load->view('entry/status_of_actionplan' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function generatereport($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name) {
        
        echo "HELLO WORLD";
        
    } */
    
    /*public function test() {
    
    $entered_date = new DateTime('2015-01-24');
    $due_date = new DateTime('2015-05-28');
    
    $diff = date_diff($entered_date, $due_date); 
      
       {
            if ($diff->days <= 30) {
                echo $diff->format('%a total days')."\n";
                //echo $diff->format('%m month, %d days');
                echo "- Not yet due";
            
            } else {
                echo $diff->format('%a total days')."\n";
                //echo $diff->format('%m month, %d days');
                echo " - Due Date";
                
            }
        }                          
    }     */
    
    public function searchofaction() {
        
        $data['ap_issue'] = $this->model_issues->getIssues(); 
        $data['ap_project'] = $this->model_projects->getProjects(); 
        $data['ap_users'] = $this->users->getAuditStaff();
        $response['searchofaction'] = $this->load->view('entry/search', $data, true); 
        echo json_encode($response);
    }
    
    public function searching() {
        
        $user_id = $this->session->userdata('sess_user_id');
        $searchkey['lookup_code'] = $this->input->post('lookup_code');
        $searchkey['lookup_action_plan'] = $this->input->post('lookup_action_plan');
        $searchkey['lookup_issue'] = $this->input->post('lookup_issue');
        $searchkey['lookup_assigned_audit'] = $this->input->post('lookup_assigned_audit');
        $searchkey['lookup_project_id'] = $this->input->post('lookup_project_id');
        
        $list['list'] = $this->model_entry->searched($searchkey, $user_id);
        $response['search_details'] = $this->load->view('entry/search_details', $list, true);
        echo json_encode($response);
    }
    
    public function ajaxDept() {
        $id = $this->input->post('id');
        $company = $this->session->userdata('sess_company_id');                     
        $emp = $this->model_employees->getEmployeesOfThisDepartment($company, $id); 
        $response['emp'] = $emp;
        echo json_encode($response);
    }  
    
     public function ajaxDept2() {
        $id = $this->input->post('id');
        $company = $this->session->userdata('sess_company_id');                     
        $emp2 = $this->model_employees->getEmployeesOfThisDepartment($company, $id);    
        $response['emp2'] = $emp2;
        echo json_encode($response);
    }
    
    public function ajaxEmployees() {
        
        $user_id = $this->input->post('user_id');     
        $company = $this->session->userdata('sess_company_id');           
        $dept = $this->departments->getDepartmentOfThisEmployees($company, $user_id); 
        $response['dept'] = $dept; 
        echo json_encode($response);        
    }
        
}





