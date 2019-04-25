<?php

class Department extends CI_Controller {


    public function __construct() {

        parent::__construct();
        $this->load->model(array('model_global/globalmodel','model_department/departments','model_risk/model_risks', 'model_entry/model_entry', 'model_issue/model_issues', 'model_project/model_projects'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('department/newdata' , null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['company_id'] = $this->input->post('company_id');
        $data['code'] = $this->input->post('code');
        $data['name'] = ucfirst($this->input->post('name'));

        $this->departments->saveNewData($data);
        redirect('department/listofdepart');
    }

    public function listofdepart() {

         if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    //$this->model_risks->removeMultiData($id);
                }
            }

        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("department/listofdepart", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("department/listofdepart", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("department/listofdepart", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("department/listofdepart", 'ADD');             

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->departments->getTotalDepartments($company);

        $data['data'] = $this->departments->getAllDepartment($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('department/listofdepart', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->departments->getThisData($id);
        $response['editdata'] = $this->load->view('department/editdata', $data, true);

        echo json_encode($response);

    }

    public function update($id) {

        $data['company_id'] = $this->input->post('company_id');
        $data['code'] = $this->input->post('code');
        $data['name'] = ucfirst($this->input->post('name'));

        $this->departments->saveupdateNewData($data, $id);

        redirect('department/listofdepart');
    }


    public function removedata($id) {

        $this->departments->removedata($id);
        redirect('department/listofdepart');
    }

}



