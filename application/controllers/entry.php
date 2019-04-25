<?php

class Entry extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies'));
        $this->load->model(array('model_internal_cc/mod_internal_cc', 'model_iccomponents_p/mod_iccomponents'));
    }

    public function index() {
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $userprofile['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['xtotal'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $layout['userprofile'] = $this->load->view('userprofile', $userprofile, true);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('userprofile', $data, true);
        $this->load->view('welcome_index', $layout);
    }
    public function test(){
        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/view/test', null, true);
        $this->load->view('welcome_index', $layout);
    }

    public function testimport() {

        $company = $this->session->userdata('sess_company_id');
        $importcode = $this->input->post('importcode');
        //$bc_code = $this->input->post('bc_code');
        $data = $this->model_entry->getCodeImport($importcode, $company);
        #print_r2($data); exit;

        if (empty($importcode)) {
            $response['invalid'] = true;
          } else {
            if ($data['code'] == $importcode) {
                $response['invalid'] = true;
            } else {
                $response['tagged'] = $importcode;
            }
        }
        echo json_encode($response);
    }

    public function dashboard() {
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $userprofile['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_entry->getTotalActionPlan($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);
        $layout['userprofile'] = $this->load->view('userprofile', $userprofile, true);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('dashboard', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function newbusinessconcern()  {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //for action_plan
        $data['issue'] = $this->model_issues->getIssues();
        $data['risk_rating'] = $this->risk_ratings->getRates();
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['risk'] = $this->model_risks->getRisk();
        $data['risk2'] = $this->model_risks->getRisk();
        $data['risk3'] = $this->model_risks->getRisk();
        $data['project'] = $this->model_projects->getProjects($company);
        $data['users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();
    

        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        //$data['issues'] = $this->model_issues->getIssueForApproval($company);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/add/newbusinessconcern' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function newactionplan() {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //for action_plan
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();

        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        //$data['issues'] = $this->model_issues->getIssueForApproval($company);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/add/newactionplan' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    
    public function ajaxsearchkey_2() { 

        $company = $this->session->userdata('sess_company_id');
        $myCodeExist = $this->input->post('myCodeExist_3');

        //Validation if empty ($myCodeExist_2)
        $response['valid'] = true;
        if (empty($myCodeExist)) {
            $response['invalid'] = false;
        } else if ($myCodeExist == "") {
            $response['invalid'] = false;
        }

        $apdetails = $this->model_entry->getThissearchactioncode($myCodeExist, $company);

        $response['apdetails'] = $apdetails;

        echo json_encode($response);

    }

    public function ajaxsearchkey() {

        $company = $this->session->userdata('sess_company_id');
        $myCodeExist = $this->input->post('myCodeExist_2');

        //Validation if empty ($myCodeExist_2)
        $response['valid'] = true;
        if (empty($myCodeExist)) {
            $response['invalid'] = false;
        } else if ($myCodeExist == "") {
            $response['invalid'] = false;
        }

        $apdetails = $this->model_entry->getThissearchactioncode($myCodeExist, $company);

        $response['apdetails'] = $apdetails;

        echo json_encode($response);

    }

    public function searchkey() {

        $company = $this->session->userdata('sess_company_id');
        $myCodeExist = $this->input->post('myCodeExist');

        //Validation if empty ($myCodeExist)
        $response['valid'] = true;
        if (empty($myCodeExist)) {
            $response['invalid'] = false;
        } else if ($myCodeExist == "") {
            $response['invalid'] = false;
        }

        $apdetails = $this->model_entry->getThissearchactioncode($myCodeExist, $company);

        $response['apdetails'] = $apdetails;

        echo json_encode($response);

    }

    public function newdata() {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();

        //for action_plan
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['ap_status2'] = $this->model_status->getDataStatusimplement();
        //for business concern
        //$data['bc_status'] = $this->model_status->getDataStatusforBusinessTrans();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        //$data['issues'] = $this->model_issues->getIssueForApproval($company);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields

        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/add/newdata' , $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function savebusinessconcern() {
        //Save Existing Ap to New Bc
        //Business Concern Tab
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code');
        $data['business_concern'] = $this->input->post('business_concern');
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');
        $dept2 = $this->input->post('dept2');
        if (!empty($dept2)) {
            $data['dept2'] =  $dept2;
        } else {
            $data['dept2'] = null;
        }

        $dept3 = $this->input->post('dept3');
        if (!empty($dept3)) {
            $data['dept3'] =  $dept3;
        } else {
            $ $data['dept3'] = null;
        }

        $data['emp'] = $this->input->post('emp');

        $emp2 = $this->input->post('emp2');
        if (!empty($emp2)) {
            $data['emp2'] =  $emp2;
        } else {
            $data['emp2'] = null;
        }

        $emp3 = $this->input->post('emp3');
        if (!empty($emp3)) {
            $data['emp3'] =  $emp3;
        } else {
            $ $data['emp3'] = null;
        }

        $data['remarks'] = $this->input->post('remarks');
        $data['internal_cc'] = $this->input->post('internal_cc');
        $data['iccomponent'] = $this->input->post('iccomponent');
        $data['risk1'] = $this->input->post('risk1');
        $data['risk2'] = $this->input->post('risk2');
        $data['risk3'] = $this->input->post('risk3');
        $data['assigned_audit'] = $this->input->post('assigned_audit');
        $data['project_id'] = $this->input->post('project_id');
        $data['bc_status'] = $this->input->post('bc_status');
        $data['impact_remarks'] = $this->input->post('impact_remarks');

        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value));
        }else {
            $data['impact_value'] = null;
        }
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d', strtotime($date_tag));
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

        $this->model_entry->savenewbusinessconcern($data);
        redirect('entry/newdata');
    }

    public function savenewaction() {
        //Entry for Existing BC to New Ap.

        //Business Concern Tab
        $company = $this->session->userdata('sess_company_id');
        $datax['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $datax['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $datax['bc_code'] = $this->input->post('bc_code');
        $datax['business_concern'] = $this->input->post('business_concern');
        $datax['recur'] = $this->input->post('recur');
        $datax['issue'] = $this->input->post('issue');
        $datax['risk_rating'] = $this->input->post('risk_rating');
        $datax['dept'] = $this->input->post('dept');
        $dept2 = $this->input->post('dept2');
        if (!empty($dept2)) {
            $datax['dept2'] = $dept2;
        } else {
            $datax['dept2'] = null;
        }

        $dept3 = $this->input->post('dept3');
        if (!empty($dept3)) {
            $datax['dept3'] = $dept3;
        } else {
            $datax['dept3'] = null;
        }

        $datax['emp'] = $this->input->post('emp');
        $emp2 = $this->input->post('emp2');
        if (!empty($emp2)) {
            $datax['emp2'] = $emp2;
        } else {
            $datax['emp2'] = null;
        }

        $emp3 = $this->input->post('emp3');
        if (!empty($emp3)) {
            $datax['emp3'] = $emp3;
        } else {
            $datax['emp3'] = null;
        }

        $datax['remarks'] = $this->input->post('remarks');
        $datax['internal_cc'] = $this->input->post('internal_cc');
        $datax['iccomponent'] = $this->input->post('iccomponent');
        $datax['risk1'] = $this->input->post('risk1');
        $datax['risk2'] = $this->input->post('risk2');
        $datax['risk3'] = $this->input->post('risk3');
        $datax['assigned_audit'] = $this->input->post('assigned_audit');
        $datax['project_id'] = $this->input->post('project_id');
        $datax['bc_status'] = $this->input->post('bc_status');
        $datax['impact_remarks'] = $this->input->post('impact_remarks');

        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $datax['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value));
        }else {
            $datax['impact_value'] = null;
        }
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $datax['date_tag'] = date('Y-m-d', strtotime($date_tag));
        }else {
            $datax['date_tag'] = null;
        }
        $due_date = $this->input->post('due_date');
         if (!empty($due_date)) {
            $datax['due_date'] = date('Y-m-d', strtotime($due_date));
        }   else {
            $datax['due_date'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');
        if (!empty($date_implemented)) {
            $datax['date_implemented'] = date('Y-m-d', strtotime($date_implemented));
        }   else {
            $datax['date_implemented'] = null;
        }

        $date_revised = $this->input->post('date_revised');
        if (!empty($date_revised)) {
            $datax['date_revised'] = date('Y-m-d', strtotime($date_revised));
        }   else {
            $datax['date_revised'] = null;
        }

        $this->model_entry->savenewadditionalbc($datax);

        #print_r2($data); exit;
        redirect('entry/newdata');

    }

    public function save() {

        //Business Concern Tab
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code');
        $data['business_concern'] = $this->input->post('business_concern');
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');

        $data['dept'] = $this->input->post('dept');
        $dept2 = $this->input->post('dept2');
        if (!empty($dept2)) {
            $data['dept2'] =  $dept2;
        } else {
            $data['dept2'] = null;
        }

        $dept3 = $this->input->post('dept3');
        if (!empty($dept3)) {
            $data['dept3'] =  $dept3;
        } else {
            $ $data['dept3'] = null;
        }

        $data['emp'] = $this->input->post('emp');

        $emp2 = $this->input->post('emp2');
        if (!empty($emp2)) {
            $data['emp2'] =  $emp2;
        } else {
            $data['emp2'] = null;
        }

        $emp3 = $this->input->post('emp3');
        if (!empty($emp3)) {
            $data['emp3'] =  $emp3;
        } else {
            $ $data['emp3'] = null;
        }

        $data['remarks'] = $this->input->post('remarks');


        $data['risk1'] = $this->input->post('risk1');
        $data['risk2'] = $this->input->post('risk2');
        $data['risk3'] = $this->input->post('risk3');

        $data['internal_cc'] = $this->input->post('internal_cc');
        $data['iccomponent'] = $this->input->post('iccomponent');

        $data['assigned_audit'] = $this->input->post('assigned_audit');
        $data['project_id'] = $this->input->post('project_id');
        $data['bc_status'] = $this->input->post('bc_status');

        $impact_remarks = $this->input->post('impact_remarks');
        if (!empty($impact_remarks)) {
            $data['impact_remarks'] = $impact_remarks;
        } else {
            $data['impact_remarks'] = null;
        }
        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value));
        }else {
            $data['impact_value'] = null;
        }
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d', strtotime($date_tag));
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

        $this->model_entry->saveNewData($data);
        #print_r2($data); exit;

        redirect('entry/newdata');

    }

    //Add This Action Plan to Business
    public function updateactioncode() {

        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['code'] = $this->input->post('code');
        $data['bc_code'] = $this->input->post('bc_code');
        $data['action_plan'] = $this->input->post('action_plan');
        $data['ap_dept'] = $this->input->post('ap_dept');
        $ap_dept_2 = $this->input->post('ap_dept_2');
        if (!empty($ap_dept_2)) {
            $data['ap_dept_2'] =  $ap_dept_2;
        } else {
            $data['ap_dept_2'] = null;
        }

        $data['ap_emp'] = $this->input->post('ap_emp');
        $ap_emp_2 = $this->input->post('ap_emp_2');
        if (!empty($ap_emp_2)) {
            $data['ap_emp_2'] =  $ap_emp_2;
        } else {
            $data['ap_emp_2'] = null;
        }
  
        $data['ap_impact_remarks'] = $this->input->post('ap_impact_remarks');
        $data['ap_status'] = $this->input->post('ap_status');
        $data['ap_assigned_audit'] = $this->input->post('ap_assigned_audit');
        $data['ap_project_id'] = $this->input->post('ap_project_id');
        $data['ap_impact_value'] = $this->input->post('ap_impact_value');
        $ap_impact_value = $this->input->post('ap_impact_value');
        if (!empty($ap_impact_value)) {
           $data['ap_impact_value'] = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
        }else {
           $data['ap_impact_value'] = null;
        }
        $ap_date_tag = $this->input->post('ap_date_tag');
        if (!empty($ap_date_tag)) {
           $data['ap_date_tag'] = date('Y-m-d', strtotime($ap_date_tag));
        }else {
           $data['ap_date_tag'] = null;
        }
        $ap_due_date = $this->input->post('ap_due_date');
        if (!empty($ap_due_date)) {
           $data['ap_due_date'] = date('Y-m-d', strtotime($ap_due_date));
        }else {
           $data['ap_due_date'] = null;
        }
        $ap_date_revised = $this->input->post('ap_date_revised');
        if (!empty($ap_date_revised)) {
           $data['ap_date_revised'] = date('Y-m-d', strtotime($ap_date_revised));
        }else {
           $data['ap_date_revised'] = null;
        }
        $ap_date_implemented = $this->input->post('ap_date_implemented');
        if (!empty($ap_date_implemented)) {
           $data['ap_date_implemented'] = date('Y-m-d', strtotime($ap_date_implemented));
        }else {
           $data['ap_date_implemented'] = null;
        }

        $this->model_entry->saveadditionalactioncodeforbc($data);
        redirect('entry/businessconcern');
    }

    public function updatebcfa($bcid) {
        //Business Concern Tab
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code');
        $data['business_concern'] = $this->input->post('business_concern');
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');
        $dept2 = $this->input->post('dept2');
        if (!empty($dept2)) {
            $data['dept2'] =  $dept2;
        } else {
            $data['dept2'] = null;
        }

        $dept3 = $this->input->post('dept3');
        if (!empty($dept3)) {
            $data['dept3'] =  $dept3;
        } else {
            $ $data['dept3'] = null;
        }

        $data['emp'] = $this->input->post('emp');

        $emp2 = $this->input->post('emp2');
        if (!empty($emp2)) {
            $data['emp2'] =  $emp2;
        } else {
            $data['emp2'] = null;
        }

        $emp3 = $this->input->post('emp3');
        if (!empty($emp3)) {
            $data['emp3'] =  $emp3;
        } else {
            $ $data['emp3'] = null;
        }
        $data['remarks'] = $this->input->post('remarks');
        $data['internal_cc'] = $this->input->post('internal_cc');
        $data['iccomponent'] = $this->input->post('iccomponent');
        $data['risk1'] = $this->input->post('risk1');
        $data['risk2'] = $this->input->post('risk2');
        $data['risk3'] = $this->input->post('risk3');
        $data['assigned_audit'] = $this->input->post('assigned_audit');
        $data['project_id'] = $this->input->post('project_id');
        $data['bc_status'] = $this->input->post('bc_status');
        $data['impact_remarks'] = $this->input->post('impact_remarks');

        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
           $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value));
        }else {
           $data['impact_value'] = null;
        }
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
           $data['date_tag'] = date('Y-m-d', strtotime($date_tag));
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

        $this->model_entry->saveupdateBcforApproval($data, $bcid);
        redirect('entry/businessconcernforapproval');
    }

    public function updateactionfa($id) {

        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code');
        $data['code'] = $this->input->post('code');
        $data['action_plan'] = $this->input->post('action_plan');
        $data['ap_dept'] = $this->input->post('ap_dept');
        $ap_dept_2 = $this->input->post('ap_dept_2');
        if (!empty($ap_dept_2)) {
            $data['ap_dept_2'] =  $ap_dept_2;
        } else {
            $data['ap_dept_2'] = null;
        }

        $data['ap_emp'] = $this->input->post('ap_emp');
        $ap_emp_2 = $this->input->post('ap_emp_2');
        if (!empty($ap_emp_2)) {
            $data['ap_emp_2'] =  $ap_emp_2;
        } else {
            $data['ap_emp_2'] = null;
        }

        $data['ap_impact_remarks'] = $this->input->post('ap_impact_remarks');
        $data['ap_status'] = $this->input->post('ap_status');
        $data['ap_assigned_audit'] = $this->input->post('ap_assigned_audit');
        $data['ap_project_id'] = $this->input->post('ap_project_id');
        $data['ap_impact_value'] = $this->input->post('ap_impact_value');
        $ap_impact_value = $this->input->post('ap_impact_value');
        if (!empty($ap_impact_value)) {
           $data['ap_impact_value'] = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
        }else {
           $data['ap_impact_value'] = null;
        }
        $ap_date_tag = $this->input->post('ap_date_tag');
        if (!empty($ap_date_tag)) {
           $data['ap_date_tag'] = date('Y-m-d', strtotime($ap_date_tag));
        }else {
           $data['ap_date_tag'] = null;
        }
        $ap_due_date = $this->input->post('ap_due_date');
        if (!empty($ap_due_date)) {
           $data['ap_due_date'] = date('Y-m-d', strtotime($ap_due_date));
        }else {
           $data['ap_due_date'] = null;
        }
        $ap_date_revised = $this->input->post('ap_date_revised');
        if (!empty($ap_date_revised)) {
           $data['ap_date_revised'] = date('Y-m-d', strtotime($ap_date_revised));
        }else {
           $data['ap_date_revised'] = null;
        }
        $ap_date_implemented = $this->input->post('ap_date_implemented');
        if (!empty($ap_date_implemented)) {
           $data['ap_date_implemented'] = date('Y-m-d', strtotime($ap_date_implemented));
        }else {
           $data['ap_date_implemented'] = null;
        }

        $this->model_entry->saveupdateActionforApproval($data, $id);
        #print_r2($data); exit;
        redirect('entry/actionplanforapproval');
    }

    public function updatebc($bcid, $bc_status) {

        //Business Concern Tab
        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['bc_code'] = $this->input->post('bc_code');
        $data['business_concern'] = $this->input->post('business_concern');
        $data['recur'] = $this->input->post('recur');
        $data['issue'] = $this->input->post('issue');
        $data['risk_rating'] = $this->input->post('risk_rating');
        $data['dept'] = $this->input->post('dept');
        $dept2 = $this->input->post('dept2');
        if (!empty($dept2)) {
            $data['dept2'] =  $dept2;
        } else {
            $data['dept2'] = null;
        }

        $dept3 = $this->input->post('dept3');
        if (!empty($dept3)) {
            $data['dept3'] =  $dept3;
        } else {
            $ $data['dept3'] = null;
        }

        $data['emp'] = $this->input->post('emp');

        $emp2 = $this->input->post('emp2');
        if (!empty($emp2)) {
            $data['emp2'] =  $emp2;
        } else {
            $data['emp2'] = null;
        }

        $emp3 = $this->input->post('emp3');
        if (!empty($emp3)) {
            $data['emp3'] =  $emp3;
        } else {
            $ $data['emp3'] = null;
        }
        $data['remarks'] = $this->input->post('remarks');
        $data['internal_cc'] = $this->input->post('internal_cc');
        $data['iccomponent'] = $this->input->post('iccomponent');
        $data['risk1'] = $this->input->post('risk1');
        $data['risk2'] = $this->input->post('risk2');
        $data['risk3'] = $this->input->post('risk3');
        $data['assigned_audit'] = $this->input->post('assigned_audit');
        $data['project_id'] = $this->input->post('project_id');
        $data['bc_status'] = $this->input->post('bc_status');
        $data['impact_remarks'] = $this->input->post('impact_remarks');

        $impact_value = $this->input->post('impact_value');
        if (!empty($impact_value)) {
            $data['impact_value'] = intval(preg_replace('/[^\d.]/', '', $impact_value));
        }else {
            $data['impact_value'] = null;
        }
        $date_tag = $this->input->post('date_tag');
        if (!empty($date_tag)) {
            $data['date_tag'] = date('Y-m-d', strtotime($date_tag));
        }else {
            $data['date_tag'] = null;
        }
        $due_date = $this->input->post('due_date');
         if (!empty($due_date)) {
            $data['due_date'] =  date('Y-m-d', strtotime($due_date));
        }   else {
            $data['due_date'] = null;
        }
        $date_revised = $this->input->post('date_revised');
         if (!empty($date_revised)) {
            $data['date_revised'] =  date('Y-m-d', strtotime($date_revised));
        }   else {
            $data['date_revised'] = null;
        }
        $date_implemented = $this->input->post('date_implemented');
        if (!empty($date_implemented)) {
            $data['date_implemented'] = date('Y-m-d', strtotime($date_implemented));
        }   else {
            $data['date_implemented'] = null;
        }

        $this->model_entry->saveupdateBcEntry($data, $bcid, $bc_status);

        redirect('entry/businessconcern');

    }

    //Insert new bc_code for null action plan
    public function updatenewbccode($id = null) {

        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        $data['code'] = $this->input->post('code');
        $data['bc_code'] = $this->input->post('bc_code');
        $data['action_plan'] = $this->input->post('action_plan');
        $data['ap_dept'] = $this->input->post('ap_dept');
        $ap_dept_2 = $this->input->post('ap_dept_2');
        if (!empty($ap_dept_2)) {
            $data['ap_dept_2'] =  $ap_dept_2;
        } else {
            $data['ap_dept_2'] = null;
        }

        $data['ap_emp'] = $this->input->post('ap_emp');
        $data['ap_emp_2'] = $this->input->post('ap_emp_2');

        $ap_emp_2 = $this->input->post('ap_emp_2');
        if (!empty($ap_emp_2)) {
            $data['ap_emp_2'] =  $ap_emp_2;
        } else {
            $data['ap_emp_2'] = null;
        }

        $data['ap_impact_remarks'] = $this->input->post('ap_impact_remarks');
        $data['ap_status'] = $this->input->post('ap_status');
        $data['ap_assigned_audit'] = $this->input->post('ap_assigned_audit');
        $data['ap_project_id'] = $this->input->post('ap_project_id');
        $data['ap_impact_value'] = $this->input->post('ap_impact_value');
        $ap_impact_value = $this->input->post('ap_impact_value');
        if (!empty($ap_impact_value)) {
           $data['ap_impact_value'] = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
        }else {
           $data['ap_impact_value'] = null;
        }
        $ap_date_tag = $this->input->post('ap_date_tag');
        if (!empty($ap_date_tag)) {
           $data['ap_date_tag'] = date('Y-m-d', strtotime($ap_date_tag));
        }else {
           $data['ap_date_tag'] = null;
        }
        $ap_due_date = $this->input->post('ap_due_date');
        if (!empty($ap_due_date)) {
           $data['ap_due_date'] = date('Y-m-d', strtotime($ap_due_date));
        }else {
           $data['ap_due_date'] = null;
        }
        $ap_date_revised = $this->input->post('ap_date_revised');
        if (!empty($ap_date_revised)) {
           $data['ap_date_revised'] = date('Y-m-d', strtotime($ap_date_revised));
        }else {
           $data['ap_date_revised'] = null;
        }
        $ap_date_implemented = $this->input->post('ap_date_implemented');
        if (!empty($ap_date_implemented)) {
           $data['ap_date_implemented'] = date('Y-m-d', strtotime($ap_date_implemented));
        }else {
           $data['ap_date_implemented'] = null;
        }

        $this->model_entry->insertnewbctothisactioncode($data, $id);
        redirect('entry/businessconcern');

    }

    public function updateaction($id, $code, $ap_status) {

        $company = $this->session->userdata('sess_company_id');
        $data['company'] = $company;
        $entered_date = $this->input->post('entered_date');
        $data['entered_date'] = date('Y-m-d', strtotime($entered_date));
        //$data['bc_code'] = $this->input->post('bc_code');
        $data['code'] = $this->input->post('code');
        $data['action_plan'] = $this->input->post('action_plan');
        $data['ap_dept'] = $this->input->post('ap_dept');

        $ap_dept_2 = $this->input->post('ap_dept_2');
        if (!empty($ap_dept_2)) {
            $data['ap_dept_2'] =  $ap_dept_2;
        } else {
            $data['ap_dept_2'] = null;
        }

        $data['ap_emp'] = $this->input->post('ap_emp');
        
        $ap_emp_2 = $this->input->post('ap_emp_2');
        if (!empty($ap_emp_2)) {
            $data['ap_emp_2'] =  $ap_emp_2;
        } else {
            $data['ap_emp_2'] = null;
        }

        $data['ap_impact_remarks'] = $this->input->post('ap_impact_remarks');
        $data['ap_status'] = $this->input->post('ap_status');
        $data['ap_assigned_audit'] = $this->input->post('ap_assigned_audit');
        $data['ap_project_id'] = $this->input->post('ap_project_id');
        //$data['ap_impact_value'] = $this->input->post('ap_impact_value');
        $ap_impact_value = $this->input->post('ap_impact_value');
        if (!empty($ap_impact_value)) {
           $data['ap_impact_value'] = intval(preg_replace('/[^\d.]/', '', $ap_impact_value));
        }else {
           $data['ap_impact_value'] = null;
        }
        $ap_date_tag = $this->input->post('ap_date_tag');
        if (!empty($ap_date_tag)) {
           $data['ap_date_tag'] = date('Y-m-d', strtotime($ap_date_tag));
        }else {
           $data['ap_date_tag'] = null;
        }

        $ap_due_date = $this->input->post('ap_due_date');
        if (empty($ap_due_date)) {
            $data['ap_due_date'] = null;
        } else {
            $data['ap_due_date'] = date('Y-m-d', strtotime($ap_due_date));
        }
        
        $ap_date_revised = $this->input->post('ap_date_revised');

        if (!empty($ap_date_revised)) {
           $data['ap_date_revised'] = date('Y-m-d', strtotime($ap_date_revised));
        }else {
           $data['ap_date_revised'] = null;
        }
        $ap_date_implemented = $this->input->post('ap_date_implemented');
        if (!empty($ap_date_implemented)) {
           $data['ap_date_implemented'] = date('Y-m-d', strtotime($ap_date_implemented));
        }else {
           $data['ap_date_implemented'] = null;
        }

        $this->model_entry->saveupdateActionEntry($data, $id, $code, $ap_status);
        #print_r2($data) ; exit;
        redirect('entry/actionplan');
    }


    //View bc concern
    public function viewbc($id = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //To Link the Array codes of AP per Business Concern.
        $data['apcodes'] = $this->model_entry->getAPCodes($id, $company);
        $data['apcodescount'] = $this->model_entry->getAPCodesCount($id, $company);
        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusinessView();  //business concern status
        $data['bc_oldusers'] = $this->users->getAuditStaff();
        $data['bc_internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['bc_iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields
        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['data'] = $this->model_entry->getThisDataBusinessConcern($id, $company);

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/view/viewbc' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    //Edit for Business Concern
    public function editbc($id = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //To Link the Array codes of AP per Business Concern.
        $data['apcodes'] = $this->model_entry->getAPCodes($id, $company);
        $data['apcodescount'] = $this->model_entry->getAPCodesCount($id, $company);

        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status
        $data['bc_status2'] = $this->model_status->getDataStatusforBusinessTrans();
        
        $data['bc_oldusers'] = $this->users->getAuditStaff();
        $data['bc_internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['bc_iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();
        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['data'] = $this->model_entry->getThisDataBusinessConcern($id, $company);

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/edit/editbc' , $data, true);
        $this->load->view('welcome_index', $layout);

    }
    //Edit for Business Concern for Approval
    public function editbcfa($id = null) {
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //To Link the Array codes of AP per Business Concern.
        $data['apcodes'] = $this->model_entry->getAPCodesfa($id, $company);
        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['bc_iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields

        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataBusinessConcernforApproval($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/edit/editbcfa' , $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function testing() {

        $bc_code = $this->input->post('bc_code');
        $lookup_apcode = $this->input->post('lookup_apcode');

        if (empty($lookup_apcode)) {
              $response['invalid'] = true;
        } else {
              $data['data'] = $bc_code;
          }

        echo json_encode($response);
    }

    public function addnewapexistingbc($id = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_oldusers'] = $this->users->getAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status
        $data['bc_internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['bc_iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields


        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();
        $data['ap_status2'] = $this->model_status->getDataStatusimplement();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataBusinessConcern($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/add/additionalbc' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function addnewbcexistingap($id = null) {
        //Entry For Existing BC to New Ap.

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status
        $data['bc_status2'] = $this->model_status->getDataStatusforBusinessTrans();

        $data['bc_internal_cc'] = $this->mod_internal_cc->getListofInternal_cc($company);// new fields
        $data['bc_iccomponents'] = $this->mod_iccomponents->getListofIccomponents($company);// new fields

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisData($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/add/additionalap' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function insertnewbccodetothisaction($id = null, $bc_code = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['bc_code'] = $bc_code;

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataofActionPlan($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/tagging/insertnewbccodeforthisaction' , $data, true);
        $this->load->view('welcome_index', $layout);


    }

    public function addnewactionplanforthisbccode($id = null, $bc_code = null)  {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();

        $data['bc_code'] = $bc_code;
        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatus();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataofActionPlan($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/tagging/addaddtionalactioncodeforbc' , $data, true);
        $this->load->view('welcome_index', $layout);
     
    }

    public function viewuntagged($id = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatusView();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataViewAp($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/view/viewapuntagged' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function viewap($id = null, $code = null) {

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        
        $data['bc_codes'] = $this->model_entry->getBC_codesofAction($code, $company);

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatusView();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataViewAp($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/view/viewap' , $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function editAction($id = null, $code= null) {
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
		$data['bc_codes'] = $this->model_entry->getBC_codesofAction($code, $company);
		#print_r2($data['bc_codes']); exit;
        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatusApEdit();
        //$data['ap_status2'] = $this->model_status->getDataStatusimplement();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisData($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/edit/editAction' , $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function editActionfa($id = null) {
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();

        //FOR BUSINESS CONCERN DROPDOWN
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_2'] = $this->departments->getAllDepartment_old();
        $data['bc_dept_3'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_2'] = $this->model_employees->getEmployees_old();
        $data['bc_emp_3'] = $this->model_employees->getEmployees_old();
        $data['bc_issues'] = $this->model_issues->getIssues();
        $data['bc_risk'] = $this->model_risks->getRisk();
        $data['bc_risk2'] = $this->model_risks->getRisk();
        $data['bc_risk3'] = $this->model_risks->getRisk();
        $data['bc_risk_rating'] = $this->risk_ratings->getRates();
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getNewAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusiness();  //business concern status

        //FOR ACTION PLAN DROPDOWN
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_dept_2'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $data['ap_emp_2'] = $this->model_employees->getEmployees_old();
        $data['ap_issues'] = $this->model_issues->getIssues();
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_risk2'] = $this->model_risks->getRisk();
        $data['ap_risk3'] = $this->model_risks->getRisk();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getNewAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatusApEdit();

        //For Dashboards total
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);

        $data['data'] = $this->model_entry->getThisDataforApproval($id, $company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/edit/editActionfa' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function approved($id, $code) {

        $company = $this->session->userdata('sess_company_id');
        $list = $this->model_entry->getActionCode($company);

        foreach($list as $row) {
            $codex = $row['codex'];
        }

        $data['data'] = $this->model_entry->saveNewDatawithApproval($id, $codex);

        redirect('entry/actionplanforapproval');
    }

    public function approvedbc($id, $bc_code) {

        $bc_codeold = $bc_code;
        $company = $this->session->userdata('sess_company_id');
        $list = $this->model_entry->getBusinessCode($company);

        foreach($list as $row) {
            $bccode = $row['bccode'];
        }

        $data['data'] = $this->model_entry->saveNewDatawithApprovalBc($id, $bccode, $bc_codeold);

        redirect('entry/businessconcernforapproval');

    }

    public function listOfActionPlanApproved() {
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

        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/listOfActionPlanApproved", 'VIEW');
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);

        $data['data'] = $this->model_entry->getThisActionPlanOfApprover($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/listOfActionPlanApproved' , $data, true);
        $this->load->view('welcome_index', $layout);

    }

    //Business Concern Approved
    public function businessconcern() {
        if ($post = $this->input->post()) {
                $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                $bc_status = $post['bc_status'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_entry->removeMultiDataBc($id, $bc_status);
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'DELETE');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'VIEW');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'DUPLICATE');
        $data['canSEARCH'] = $this->globalmodel->moduleFunction("entry/businessconcern", 'SEARCH');

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total_bc'] = $this->model_entry->getTotalBusinessConcern($company);
        $data['total'] = $this->model_entry->getTotalActionPlan($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);

        $data['data'] = $this->model_entry->getThisBusinessConcern($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/businessconcern' , $data, true);
        $this->load->view('welcome_index', $layout);
      }

    //Action Plan Approved
    public function actionplan() {
        if ($post = $this->input->post()) {
                $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                $ap_status = $post['ap_status'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_entry->removeMultiData($id, $ap_status);
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/actionplan", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/actionplan", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("entry/actionplan", 'DELETE');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/actionplan", 'VIEW');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry/actionplan", 'DUPLICATE');
        $data['canSEARCH'] = $this->globalmodel->moduleFunction("entry/actionplan", 'SEARCH');

        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['ap_oldusers'] = $this->users->getAuditStaff();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_entry->getTotalActionPlan($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);

        $data['data'] = $this->model_entry->getThisActionPlan($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/actionplan' , $data, true);
        $this->load->view('welcome_index', $layout);
    }

    //Action Plan for Approval
    public function ActionPlanForApproval() {

        if ($post = $this->input->post()) {
            $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                 $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_entry->removeMultiData($id);
                }   else if ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                    //$this->model_entry->approvedMultiData($id);
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'MULTI_DELETE');
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'MULTI_APPROVED');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'EDIT');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'VIEW');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'APPROVED');
        $data['canDISAPPROVED'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'DISAPPROVED');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry/ActionPlanForApproval", 'DUPLICATE');
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id); //all total for approval
        $data['actionforapproval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company); // total for approval(action plan)
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id); // total action plan display.

        $data['data'] = $this->model_entry->getThisEntryforApprovalOfAction($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/actionplanforapproval', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    //Business Concern for Approval
    public function BusinessConcernForApproval() {
        if ($post = $this->input->post()) {
            $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                 $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    //$this->model_entry->removeMultiData($id);
                }   else if ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                    //$this->model_entry->approvedMultiData($id);
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'MULTI_DELETE');
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'MULTI_APPROVED');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'EDIT');
        $data['canVIEW'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'VIEW');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'APPROVED');
        $data['canDISAPPROVED'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'DISAPPROVED');
        $data['canDUPLICATE'] = $this->globalmodel->moduleFunction("entry/BusinessConcernForApproval", 'DUPLICATE');
        $company = $this->session->userdata('sess_company_id');
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['xtotal'] = $this->model_entry->getTotalActionPlanByApprover($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id); //all total for approval
        $data['bcforapproval'] = $this->model_entry->getTotalForApprovalOfBusinessConcern($company); // total for approval(action plan)
        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id); // total action plan display.

        $data['data'] = $this->model_entry->getThisEntryforApprovalOfBusinessConcern($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('entry/businessconcernforapproval', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function disapprovedap($id) {
        $this->model_entry->disapprovedap($id);
        redirect('entry/actionplanforapproval');
    }

    public function disapprovedbc($id){
        $this->model_entry->disapprovedbc($id);
        redirect('entry/businessconcernforapproval');
    }

    public function removeAction($id, $ap_status) {
        #echo $ap_status ; exit;
        $this->model_entry->removeDataAp($id, $ap_status);
        redirect('entry/actionplan');
    }

    public function removebc($id, $bc_status) {
        $this->model_entry->removeDataBc($id, $bc_status);
        redirect('entry/businessconcern');
    }

    public function removetagging($apid, $bcid) {
        $this->model_entry->removetagging($apid);
        redirect('entry/editbc/'.$bcid);
    }
	

    public function searchofaction() {
        $company = $this->session->userdata('sess_company_id');
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getAuditStaff();
        $data['ap_dept'] = $this->departments->getAllDepartment_old();
        $data['ap_emp'] = $this->model_employees->getEmployees_old();
        $response['searchofaction'] = $this->load->view('entry/search', $data, true);
        echo json_encode($response);
    }

    public function searchofbusiness() {

        $company = $this->session->userdata('sess_company_id');
        $data['bc_project'] = $this->model_projects->getProjects($company);
        $data['bc_users'] = $this->users->getAuditStaff();
        $data['bc_dept'] = $this->departments->getAllDepartment_old();
        $data['bc_emp'] = $this->model_employees->getEmployees_old();
        $response['searchofbusiness'] = $this->load->view('entry/searchbc', $data, true);
        echo json_encode($response);

    }

    public function searchofactioncode() {
        $company = $this->session->userdata('sess_company_id');
        $bc_code = $this->input->post('bc_code');
        $datax['data'] = $this->model_entry->getbccodes($bc_code, $company);
        $response['searchofactioncode'] = $this->load->view('entry/searchcode',$datax, true);
        echo json_encode($response);
    }

    public function addtionalap() {
        $company = $this->session->userdata('sess_company_id');
        $data['data'] = $this->model_entry->getbcbycompany($company);
        $response['addtionalap'] = $this->load->view('entry/add/searchbccode',$data, true);
        echo json_encode($response);
    }

    public function searchingforbusinesscode() {
        $company = $this->session->userdata('sess_company_id');
        $searchkey['lookup_bccode'] = $this->input->post('lookup_bccode');
        $dlist['dlist'] = $this->model_entry->searchedbccode($searchkey,$company);
        $response['search_bcdetails'] = $this->load->view('entry/add/search_bcdetails', $dlist, true);
        echo json_encode($response);
    }

    public function addtionalbc() {
        $company = $this->session->userdata('sess_company_id');
        $data['data'] = $this->model_entry->getapbycompany($company);
        $response['addtionalbc'] = $this->load->view('entry/add/searchactioncode',$data, true);
        echo json_encode($response);
    }

    public function searchingforactioncode() {
        $company = $this->session->userdata('sess_company_id');
        $searchkey['lookup_apcode'] = $this->input->post('lookup_apcode');
        $dlist['dlist'] = $this->model_entry->searchedaccode($searchkey,$company);
        $response['search_acdetails'] = $this->load->view('entry/add/search_acdetails', $dlist, true);
        echo json_encode($response);
    }

    public function searching() {
        $company = $this->session->userdata('sess_company_id');
        $searchkey['lookup_code'] = $this->input->post('lookup_code');
        $searchkey['lookup_action_plan'] = $this->input->post('lookup_action_plan');
        $searchkey['lookup_assigned_audit'] = $this->input->post('lookup_assigned_audit');
        $searchkey['lookup_project_id'] = $this->input->post('lookup_project_id');
        $searchkey['lookup_dept'] = $this->input->post('lookup_dept');
        //$searchkey['lookup_dept2'] = $this->input->post('lookup_dept2');
        $searchkey['lookup_person'] = $this->input->post('lookup_person');
        //$searchkey['lookup_person2'] = $this->input->post('lookup_person2');

        $list['list'] = $this->model_entry->searched($searchkey, $company);
        $response['search_details'] = $this->load->view('entry/search_details', $list, true);
        echo json_encode($response);
    }

    public function searchingbc() {
      $company = $this->session->userdata('sess_company_id');
      $searchkey['lookup_code'] = $this->input->post('lookup_code');
      $searchkey['lookup_bc'] = $this->input->post('lookup_bc');
      $searchkey['lookup_assigned_audit'] = $this->input->post('lookup_assigned_audit');
      $searchkey['lookup_project_id'] = $this->input->post('lookup_project_id');
      $searchkey['lookup_dept'] = $this->input->post('lookup_dept');
      //$searchkey['lookup_dept2'] = $this->input->post('lookup_dept2');
      //$searchkey['lookup_dept3'] = $this->input->post('lookup_dept3');
      $searchkey['lookup_person'] = $this->input->post('lookup_person');
      //$searchkey['lookup_person2'] = $this->input->post('lookup_person2');
      //$searchkey['lookup_person3'] = $this->input->post('lookup_person3');

      $list['list'] = $this->model_entry->searchedbc($searchkey, $company);
      $response['search_detailsbc'] = $this->load->view('entry/search_detailsbc', $list, true);
      echo json_encode($response);
    }

    public function searchingforcode() {
        $company = $this->session->userdata('sess_company_id');
        $bc_code = $this->input->post('bc_code');
        $searchkey['bc_code'] = $this->input->post('bc_code');
        $searchkey['lookup_apcode'] = $this->input->post('lookup_apcode');
        $list['list'] = $this->model_entry->searchedcode($searchkey,$company, $bc_code);
        $list['bc_code'] = $bc_code;

        #echo $list['bc_code']; exit;

        $response['search_detailscode'] = $this->load->view('entry/search_detailscode', $list, true);
        echo json_encode($response);
    }

    public function ajaxgetapRisk1() {
        $id = $this->input->post('id');
        $ap_risk2 = $this->model_risks->getRisksForRisk2($id);
        $ap_risks = $ap_risk2[0]['id'];
        $response['ap_risk3'] = $this->model_risks->getRiskForRisk3($id, $ap_risks);
        $response['ap_risk2'] = $ap_risk2;
        echo json_encode($response);
    }

    public function ajaxgetapRisk2() {
        $id = $this->input->post('id');
        $id1 = $this->input->post('id1');
        $id3 = $this->input->post('id3');
        $ap_risk3 = $this->model_risks->getRisksForRisk3x($id, $id1, $id3);
        $ap_risks = $ap_risk3[0]['id'];
        $response['ap_risk1'] = $this->model_risks->getRiskForRisk1x($id, $ap_risks);
        $response['ap_risk3'] = $ap_risk3;
        echo json_encode($response);
    }

    public function ajaxgetRisk1() {
        $id = $this->input->post('id');
        $risk2 = $this->model_risks->getRisksForRisk2($id);
        $risks = $risk2[0]['id'];
        $response['risk3'] = $this->model_risks->getRiskForRisk3($id, $risks);
        $response['risk2'] = $risk2;
        echo json_encode($response);
    }

    public function ajaxgetRisk2() {
        $id = $this->input->post('id');
        $id1 = $this->input->post('id1');
        $id3 = $this->input->post('id3');
        $risk3 = $this->model_risks->getRisksForRisk3x($id, $id1, $id3);
        $risks = $risk3[0]['id'];
        $response['risk1'] = $this->model_risks->getRiskForRisk1x($id, $risks);
        $response['risk3'] = $risk3;
        echo json_encode($response);
    }

   /* public function ajaxgetRisk3() {
        $idx = $this->input->post('id');
        $id2 = $this->input->post('id2');
        $id1 = $this->input->post('id1');
        $xrisk2 = $this->model_risks->getRisksForRisk2z($idx, $id2, $id1);
        $xrisks = $xrisk2[0]['id'];
        $response['risk1'] = $this->model_risks->getRiskForRisk1z($idx, $xrisks);
        $response['risk2'] = $xrisk2;
        echo json_encode($response);
    } */


    //BC validation for Status and Datepicker
    public function ajaxstatus() {
        $id = $this->input->post('id');
        $bc_status = $this->model_status->getThisData($id);
        $response['date_implemented'] = $bc_status;

        echo json_encode($response);
    }

    //AP1 Validation for Status and Datepicker.
    public function ap_ajaxstatus() {
        $id = $this->input->post('id');
        $ap_status = $this->model_status->getThisData($id);
        $response['ap_status'] = $ap_status;
        echo json_encode($response);
    }

    //AP1 Validation for Status and Datepicker for additionalbc.
    public function ap_ajaxstatusbc() {
        $id = $this->input->post('id');
        $ap_status = $this->model_status->getThisData($id);
        $response['ap_date_implemented_b'] = $ap_status;
        echo json_encode($response);
    }
    //END

/*    //AP2 Validation for Status and Datepicker
    public function ap_ajaxstatusx() {
        $id = $this->input->post('id');
        $ap_status_x1 = $this->model_status->getThisData($id);
        $response['ap_date_implementedx'] = $ap_status_x1;

        echo json_encode($response);
    }*/
    //END


    /*public function validateDepartment($data) {

    if (!empty($this->validateDepartment)) {
        foreach ($data as $key => $value) {
           $_POST[$key] = $value; }
           $this->load->library('form_validation');
           $this->form_validation->set_rules($this->validate);
           return $this->form_validation->run(); }
    else
        {
            return TRUE;
        }
    }*/

}
