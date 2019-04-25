<?php

class Risk extends CI_Controller {


    public function __construct() {

        parent::__construct();
        $this->load->model(array('model_global/globalmodel','model_risk/model_risks', 'model_entry/model_entry', 'model_issue/model_issues', 'model_project/model_projects', 'model_department/departments'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('risk/newdata' , null, true);

        echo json_encode($response);

    }

    public function save() {

        //$data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_risks->saveNewData($data);
        redirect('risk/listofrisk');
    }

    public function listofrisk() {

         if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_risks->removeMultiData($id);
                }
            }

        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("risk/listofrisk", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("risk/listofrisk", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("risk/listofrisk", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("risk/listofrisk", 'ADD');             


        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_risks->getTotalRisk();
        $data['data'] = $this->model_risks->getListofRisks();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('risk/listofrisk', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function listforApproval() {

         if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_risks->removeMultiData($id);
                }
            }

        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("risk/listforApproval", 'MULTI_DELETE');
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("risk/listforApproval", 'MULTI_APPROVED');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("risk/listforApproval", 'EDIT');
        $data['canDISAPPROVED'] = $this->globalmodel->moduleFunction("risk/listforApproval", 'DISAPPROVED');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("risk/listforApproval", 'APPROVED');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_risks->getTotalRisk();
        $data['totalforApprove_risk'] = $this->model_risks->getTotalRiskForApproval();
        $data['data'] = $this->model_risks->getListforApproval();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('risk/listforApproval', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function viewrisk() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_risks->getThisDataForApproval($id);
        $response['viewrisk'] = $this->load->view('risk/viewrisk', $data, true);

        echo json_encode($response);
    }

    public function approved($id) {

        $list = $this->model_risks->getMaxRiskCode();

        foreach($list as $row) {
            $code = $row['code'];
        }

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_risks->saveNewDatawithApproval($data, $id, $code);

        redirect('risk/listforApproval');
    }

    public function editdatafa() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_risks->getThisDataForApproval($id);
        $response['editdatafa'] = $this->load->view('risk/editdatafa', $data, true);

        echo json_encode($response);

    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_risks->getThisData($id);
        $response['editdata'] = $this->load->view('risk/editdata', $data, true);

        echo json_encode($response);

    }

    public function update($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_risks->saveupdateNewData($data, $id);

        redirect('risk/listofrisk');
    }

    public function updatefa($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_risks->saveupdateNewData($data, abs($id));
        redirect('risk/listforApproval');

    }

    public function removedata($id) {

        $this->model_risks->removedata($id);
        redirect('risk/listofrisk');
    }

    public function disapproved($id) {
        /*For Disapproved*/
        $this->model_risks->disapproved($id);
        redirect('risk/listofrisk');
    }

}



?>
