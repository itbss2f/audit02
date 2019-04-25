<?php

class Project extends CI_Controller {


    public function __construct() {

        parent::__construct();
        //$this->sess = $this->authlib->validate();
        $this->load->model(array('model_global/globalmodel','model_project/model_projects', 'model_entry/model_entry','model_issue/model_issues', 'model_risk/model_risks', 'model_department/departments'));
    }

    public function newdata() {

        $response['newdata'] = $this->load->view('project/newdata' , null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));
        $date_release = $this->input->post('date_release');
        $data['date_release'] = date('Y-m-d', strtotime($date_release));
        $data['impact'] = $this->input->post('impact');
        $data['company'] = $this->input->post('company');

        $this->model_projects->saveNewData($data);
        redirect('project/listofproject');
    }

    public function listofProject() {

        if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_projects->removeMultiData($id);
                }
            }

        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("project/listofProject", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("project/listofProject", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("project/listofProject", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("project/listofProject", 'ADD');
        $data['canUPLOAD'] = $this->globalmodel->moduleFunction("project/listofProject", 'UPLOAD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_projects->getTotalProjects($company); //total of all projects that already approved
        
        $data['data'] = $this->model_projects->getListofProjects($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('project/listofProject', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function listforApprovalProject() {

        if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_projects->removeMultiData($id);
                }
            }

        }

        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("project/listforApprovalProject", 'MULTI_DELETE');
        $data['canMULTI_APPROVED'] = $this->globalmodel->moduleFunction("project/listforApprovalProject", 'MULTI_APPROVED');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("project/listforApprovalProject", 'EDIT');
        $data['canDISAPPROVED'] = $this->globalmodel->moduleFunction("project/listforApprovalProject", 'DISAPPROVED');
        $data['canAPPROVED'] = $this->globalmodel->moduleFunction("project/listforApprovalProject", 'APPROVED');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company); //total of all project for approval
        
        $data['data'] = $this->model_projects->getListofProjectsForApproval($company);
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('project/listforApprovalProject', $data, true);
        $this->load->view('welcome_index', $layout);


    }

    public function viewdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_projects->getThisProjectforApproval($id);
        $response['viewproject'] = $this->load->view('project/viewdata', $data, true);

        echo json_encode($response);

    }

    public function editdata() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_projects->getThisData($id);
        $response['editdata'] = $this->load->view('project/editdata', $data, true);

        echo json_encode($response);

    }

    public function editdatafa() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_projects->getThisProjectforApproval($id);
        $response['editdatafa'] = $this->load->view('project/editdatafa', $data, true);

        echo json_encode($response);

    }

    public function update($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));
        $data['date_release'] = $this->input->post('date_release');
        $data['impact'] = $this->input->post('impact');
        $data['company'] = $this->input->post('company');
        $this->model_projects->saveupdateNewData($data, $id);

        redirect('project/listofproject');
    }

    public function updatefaProj($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));
        $data['date_release'] = $this->input->post('date_release');
        $data['impact'] = $this->input->post('impact');
        $data['company'] = $this->input->post('company');

        $this->model_projects->saveupdateNewData($data, $id);

        redirect('project/listforApprovalProject');
    }

    public function approvedProject($id) {

        $data['code'] = $this->input->post('code');
        $data['description'] = ucfirst($this->input->post('description'));
        $data['date_release'] = $this->input->post('date_release');
        $data['impact'] = $this->input->post('impact');
        $this->model_projects->saveNewProjectDatawithApproval($data, $id);

        redirect('project/listofProject');
    }

    public function removedata($id) {

        $this->model_projects->removeData($id);
        redirect('project/listofProject');
    }

    public function disapproved($id) {

        $this->model_projects->disapproved(abs($id));
        redirect('project/listforApprovalProject');
    }

    public function uploadprojectdata($id) {

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        $data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['total'] = $this->model_projects->getTotalProjects($company); //total of all projects that already approved

        $data['infodata'] = $this->model_projects->getProjectCurrentData($company, $id);

        $data['list'] = $this->model_projects->getFileAttachmentofProjectData($company, $id);

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('project/upload/uploaddata', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function uploading() {

        $projectid = $this->input->post('projectid');

        //ini_set('memory_limit', '-1');
        //ini_set('upload_max_filesize', '64M');

        //$config['upload_path'] = '/var/www/audit/projectattachment/';
        $config['upload_path'] = 'C:/xampp/htdocs/audit/uploading';
        $config['allowed_types'] = 'gif|jpg|png|doc|xlsx|pdf|csv|xml|txt|ppt|xls';
        $config['max_size']    = '2048000'; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->helper('inflector');
        $file_name = $projectid.'_'.Date('mdyhis').'_'.underscore($_FILES['userfile']['name']);
        $config['file_name'] = $file_name;
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile')) {
         
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('project/upload/error', $error); 

         }
        else
        {

            $data['projectid'] = $this->input->post('projectid');

            $file = $this->upload->data();

            $this->upload->initialize($config);
            $fileData = $this->upload->data();

            $data['filename'] = $file['file_name'];
            $data['filetype'] = $file['file_ext'];

            $this->model_projects->saveDataUpload($data);

            redirect('project/uploadprojectdata/'.$data['projectid']);

        }

    }

    public function viewprojectdatafile($id = null) {

        $company = $this->session->userdata('sess_company_id');

        $data['file'] = $this->model_projects->getFileattachmentofProjectDataUpload($company, $id);

        $this->load->view('project/upload/loadprojectfile', $data);

    }


    public function removeDataUpload($id, $projectid) {
        //Customer Uploading

        $this->model_projects->removeupload(abs($id));

        redirect('project/uploadprojectdata/'.$projectid);

    }

}


?>
