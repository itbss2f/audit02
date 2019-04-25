<?php
class Internal_cc extends CI_Controller {


    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel','model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_department/departments'));
        $this->load->model(array('model_internal_cc/mod_internal_cc'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('internal_cc/newdata', null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->mod_internal_cc->saveNewData($data);

        redirect('internal_cc/listofInternal_cc');

    }

    public function listofInternal_cc() {

         if ($post = $this->input->post()) {
             $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->mod_internal_cc->removeMultiData($id);
                }elseif ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("internal_cc/listofInternal_cc", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("internal_cc/listofInternal_cc", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("internal_cc/listofInternal_cc", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("internal_cc/listofInternal_cc", 'ADD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->mod_internal_cc->getTotalInternal_cc($company); // Total of listofInternal_cc

        $data['data'] = $this->mod_internal_cc->getListofInternal_cc($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('internal_cc/listofInternal_cc', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->mod_internal_cc->getThisData($id);
        $response['editdata'] = $this->load->view('internal_cc/editdata', $data, true);

        echo json_encode($response);

    }

    public function approved($id) {

        $list = $this->mod_internal_cc->getMaxCode();

        foreach($list as $row) {
            $code = $row['code'];
        }

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->mod_internal_cc->saveNewDatawithApproval($data, $id, $code);

        redirect('internal_cc/listofInternal_cc');
    }

    public function update($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->mod_internal_cc->saveupdateNewData($data, abs($id));
        redirect('internal_cc/listofInternal_cc');
    }


    public function removedata($id) {

        $this->mod_internal_cc->removeData($id);
        redirect('internal_cc/listofInternal_cc');
    }

}
