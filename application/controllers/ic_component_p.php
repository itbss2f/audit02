<?php
class Ic_component_p extends CI_Controller {


    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues','model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_department/departments'));
        $this->load->model(array('model_iccomponents_p/mod_iccomponents'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('ic_component_p/newdata', null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->mod_iccomponents->saveNewData($data);

        redirect('ic_component_p/listoficcomponents');

    }

    public function listoficcomponents() {

         if ($post = $this->input->post()) {
             $data['message'] = 'Successfully deleted!';
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->mod_iccomponents->removeMultiData($id);
                }elseif ($post['submit'] == 'multi_approved') {
                    $data['message'] = 'Multiple Approved will be Available Soon!';
                }
            }
        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("ic_component_p/listoficcomponents", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("ic_component_p/listoficcomponents", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("ic_component_p/listoficcomponents", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("ic_component_p/listoficcomponents", 'ADD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->mod_iccomponents->getTotalIccomponents($company); // Total of listofInternal_cc

        $data['data'] = $this->mod_iccomponents->getListofIccomponents($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('ic_component_p/listoficcomponents', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->mod_iccomponents->getThisData($id);
        $response['editdata'] = $this->load->view('ic_component_p/editdata', $data, true);

        echo json_encode($response);

    }

    public function update($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));

        $this->mod_iccomponents->saveNewDatawithApproval($data, abs($id));
        redirect('ic_component_p/listoficcomponents');
    }


    public function removedata($id) {

        $this->mod_iccomponents->removeData($id);
        redirect('ic_component_p/listoficcomponents');
    }

}
