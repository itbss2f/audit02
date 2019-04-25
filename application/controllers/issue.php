<?php
class Issue extends CI_Controller {


    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel','model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_department/departments'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('issue/newdata', null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_issues->saveNewData($data);

        redirect('issue/listofIssues');

    }

    public function listofissues() {

         if ($post = $this->input->post()) {
             $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_issues->removeMultiData($id);
                }elseif ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("issue/listofIssues", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("issue/listofIssues", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("issue/listofIssues", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("issue/listofIssues", 'ADD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_issues->getTotalIssues($company);
        
        $data['data'] = $this->model_issues->getListofIssues($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('issue/listofIssues', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_issues->getThisData($id);
        $response['editdata'] = $this->load->view('issue/editdata', $data, true);

        echo json_encode($response);

    }


    public function update($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_issues->saveupdateNewData($data, abs($id));
        redirect('issue/listofIssues');
    }


    public function removedata($id) {

        $this->model_issues->removeData($id);
        redirect('issue/listofIssues');
    }

}
