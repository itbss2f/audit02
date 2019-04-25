<?php 

class Entry_risk extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));                  
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies','model_entry_risk/entry_risks'));                                  
    }
    
    public function dashboard() {
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);  
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id); 
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);  
        $layout['content'] = $this->load->view('dashboard', $data, true);
        $this->load->view('welcome_index', $layout);
    }
    
    public function new_entry() {
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
        $data['ap_project'] = $this->model_projects->getProjects($company); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_statusX'] = $this->model_status->getDataStatusLimit(); //without revised,supersed,cancel
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['issues'] = $this->model_issues->getIssueForApproval($company); 
        $data['risks'] = $this->model_risks->getRiskForApproval(); 
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);   
        $layout['content'] = $this->load->view('entry_risk/new_entry' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }
    
    public function savenewacceptedrisk() {
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;     
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code'); 
        $data['business_concern'] = $this->input->post('business_concern'); 
        $data['bc_status'] = $this->input->post('bc_status');  
        $data['code'] = $this->input->post('code');       
        $data['action_plan'] = $this->input->post('action_plan');       
        $data['impact_remarks'] = $this->input->post('impact_remarks');
        $data['remarks'] = $this->input->post('remarks');    
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');                              
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
        
        $xdate_implemented = $this->input->post('date_implemented');        
        if (!empty($xdate_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($xdate_implemented));   
        }   else {
            $data['date_implemented'] = null;
        }
    
        /*save new action plan:*/   
       
        $this->entry_risks->saveNewAcceptedRiskData($data);
    
        redirect('entry_risk/new_entry');
    }
    
    public function updateaction($id) {

        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company; 
        $data['bc_code'] = $this->input->post('bc_code'); 
        $data['business_concern'] = $this->input->post('business_concern'); 
        $data['bc_status'] = $this->input->post('bc_status');  
        $data['code'] = $this->input->post('code');       
        $data['action_plan'] = $this->input->post('action_plan');   
        $data['impact_remarks'] = $this->input->post('impact_remarks');   
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');    
        $data['emp'] = $this->input->post('emp');             
        $data['emp2'] = $this->input->post('emp2');                   
        $data['remarks'] = $this->input->post('remarks');             
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
 
        $this->entry_risks->saveupdateAcceptedRiskData($data, $id);
        redirect('entry_risk/listofAcceptedRisk');
    }
    
    
    /*public function editAcceptedRisksfa($id = null) {
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
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company); 
        //$data['total_approval'] = $this->entry_risks->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->entry_risks->getTotalForApprovalOfActionPlan($company, $user_id);
         
        $data['data'] = $this->entry_risks->getThisDataforAcceptedRisks($id, $company);  
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry_risk/editAcceptedRisksfa' , $data, true);    
        $this->load->view('welcome_index', $layout);
    }  */
    
    public function editAcceptedRisks($id = null) {
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
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff(); 
        $data['ap_users'] = $this->users->getNewAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company); 
        //$data['total_approval'] = $this->entry_risks->getTotalForApproval($company, $user_id);
        $data['approval'] = $this->entry_risks->getTotalForApprovalOfActionPlan($company, $user_id);
         
        $data['data'] = $this->entry_risks->getThisDataforAcceptedRisks($id, $company);  
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry_risk/editAcceptedRisks' , $data, true);    
        $this->load->view('welcome_index', $layout);
    } 
    
    public function listofAcceptedRisk() {
        if ($post = $this->input->post()) {
            $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                 $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->entry_risks->removeMultiData($id);
                }   else if ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                    //$this->model_entry->approvedMultiData($id);  
                } 
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry_risk/listofAcceptedRisk", 'MULTI_DELETE');                       
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry_risk/listofAcceptedRisk", 'EDIT');                  
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry_risk/listofAcceptedRisk", 'VIEW');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("entry_risk/listofAcceptedRisk", 'DELETE');  
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry_risk/listofAcceptedRisk", 'DUPLICATE');
        
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company); 
        
        $data['approval'] = $this->entry_risks->getTotalForApprovalOfActionPlan($company); // total for approval(action plan)
        $data['total'] = $this->entry_risks->getTotalActionPlan($company, $user_id); // total action plan display. 
        
        $data['data'] = $this->entry_risks->getThisEntry_Risks($company, $user_id); 
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry_risk/listofAcceptedRisk', $data, true);    
        $this->load->view('welcome_index', $layout);
        
        
    } 
    
    public function listforApproval() {
        if ($post = $this->input->post()) {
            $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                 $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->entry_risks->removeMultiData($id);
                }   else if ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                    //$this->model_entry->approvedMultiData($id);  
                } 
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'MULTI_DELETE');            
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'MULTI_APPROVED');            
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'EDIT');                  
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'VIEW');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'APPROVED');
        $data['canDISAPPROVED'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'DISAPPROVED');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry_risk/listforApproval", 'DUPLICATE');
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['issues'] = $this->model_issues->getIssueForApproval(); 
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company); 
        
        //$data['xtotal'] = $this->entry_risks->getTotalActionPlanByApprover($company, $user_id);
        //$data['total_approval'] = $this->entry_risks->getTotalForApproval($company, $user_id); //all total for approval
        $data['approval'] = $this->entry_risks->getTotalForApprovalOfActionPlan($company); // total for approval(action plan)
        $data['total'] = $this->entry_risks->getTotalActionPlan($company, $user_id); // total action plan display. 
        
        $data['data'] = $this->entry_risks->getThisEntry_RisksforApproval($company, $user_id); 
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry_risk/listforApproval', $data, true);    
        $this->load->view('welcome_index', $layout);
    }
}