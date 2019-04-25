<?php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
         if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel','model_user/users', 'model_employee/model_employees', 'model_companies/companies', 'model_department/departments', 'model_entry/model_entry', 'model_issue/model_issues', 'model_auth/securities', 'model_risk/model_risks', 'model_project/model_projects'));
    }

    public function userdata() {
        $data['company'] = $this->companies->getAllCompanies();   //list of All company
        $response['userdata'] = $this->load->view('users/userdata', $data, true);

        echo json_encode($response);
    }

    public function userchange() {
        $user_id = $this->session->userdata('sess_user_id');
        $data['users'] = $this->users->getUserData($user_id);  //list of Userdata
        $response['userchange'] = $this->load->view('users/userchange', $data, true);

        echo json_encode($response);
    }

    public function setuserfunction() {
        $data['user_id'] = $this->input->post('user_id');
        $data['main'] = $this->securities->getListOfMainmodules();  //list of menu
        $response['setuserfunction'] = $this->load->view('users/setuserfunction', $data, true);

        echo json_encode($response);

    }

    public function user_company_listview() {
        $mainx = $this->input->post('mainx');
        $user_id = $this->input->post('user_id');
        $data['user_id'] = $user_id;
        $data['user_company_list'] = $this->securities->main_module_list($mainx, $user_id);  //list of company that can access

        $response['user_company_listview'] = $this->load->view('users/user_company_listview', $data, true);

        echo json_encode($response);
    }

     public function setaccess() {
        $user_id = $this->input->post('user_id');
        $module_functionx = $this->input->post('module_functionx');

        $this->users->setUserCompanyAccess($user_id, $module_functionx);
    }

    public function setcompany() {
        $user_id = $this->input->post('user_id');
        $data['usercompany'] = $this->users->getUserCompanies($user_id); //list of company that user can access
        $data['companyx'] = $this->companies->getAllCompanies(); //all company
        $data['auditx'] = $this->users->getUserData($user_id); //all audit users
        $response['setcompany'] = $this->load->view('users/setcompany', $data, true);

        echo json_encode($response);
    }

    public function saveusercompany() {
        $user_id = $this->input->post('userx');
        $company_id = $this->input->post('compxid');

        $this->users->saveUserCompany($user_id, $company_id);
        redirect('user/listofUser');
    }

    public function saveUser() {
        $data['employee_id'] = mysql_real_escape_string($this->input->post('employee_id'));
        $data['firstname'] = strtoupper(mysql_real_escape_string($this->input->post('firstname')));
        $data['middlename'] = strtoupper(mysql_real_escape_string($this->input->post('middlename')));
        $data['lastname'] = strtoupper(mysql_real_escape_string($this->input->post('lastname')));
        $data['email'] = mysql_real_escape_string($this->input->post('email'));
        $data['username'] = strtolower(mysql_real_escape_string($this->input->post('username')));
        $data['userpass'] = $this->input->post('userpass');
        $data['userpass'] = $this->input->post('confirm');
        $data['expiration_date'] = mysql_real_escape_string($this->input->post('expiration_date'));
        $this->users->saveNewUser($data);

        redirect('user/listofUser');
    }

    public function editUserData() {
        $data['company'] = $this->companies->getAllCompanies();
        $user_id = $this->input->post('user_id');
        $data['data'] = $this->users->getUserData($user_id);
        $response['editUserData'] = $this->load->view('users/editUserData', $data, true);

        echo json_encode($response);
    }

    public function updateUser($user_id) {
        $data['employee_id'] = mysql_real_escape_string($this->input->post('employee_id'));
        $data['firstname'] = strtoupper(mysql_real_escape_string($this->input->post('firstname')));
        $data['middlename'] = strtoupper(mysql_real_escape_string($this->input->post('middlename')));
        $data['lastname'] = strtoupper(mysql_real_escape_string($this->input->post('lastname')));
        $data['email'] = mysql_real_escape_string($this->input->post('email'));
        $data['username'] = strtolower(mysql_real_escape_string($this->input->post('username')));
        $data['expiration_date'] = strtolower(mysql_real_escape_string($this->input->post('account_ex')));

        $this->users->saveupdateUser($data, $user_id);

        redirect('user/listofUser');

    }

    public function updatePassword() {
        $user_id = $this->input->post('user_id');
        $data['username'] = strtolower(mysql_real_escape_string($this->input->post('username')));
        $data['userpass'] = $this->input->post('userpass');
        $data['userpass'] = $this->input->post('confirm');

        $this->users->saveupdateNewUser($data, $user_id);

        redirect('auth/logout');
    }

    public function listofUser() {
        if ($post = $this->input->post()) {
             $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $user_id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->users->removeMultiData($user_id);
                }
            }
        }

        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("user/listofUser", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("user/listofUser", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("user/listofUser", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("user/listofUser", 'ADD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);

        $data['risks'] = $this->model_risks->getRiskForApproval();
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['data'] = $this->users->getUserList();
        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('users/listofUser', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function removedata($user_id) {
        $this->users->removeData(abs($user_id));
        redirect('user/listofUser');
    }
                      
}

/* Author : PAUL*/
