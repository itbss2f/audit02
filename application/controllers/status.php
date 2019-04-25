<?php

class Status extends CI_Controller {


    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }

        $this->load->model(array('model_global/globalmodel','model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies'));
    }

    public function index() {

        $company = $this->session->userdata('sess_company_id');

        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('status/changeofstatus',null, true);
        $this->load->view('welcome_index', $layout);

    }

    public function newdata() {

        $response['newdata'] = $this->load->view('status/newdata' , null, true);

        echo json_encode($response);

    }

    public function save() {

        $data['status_code'] = strtoupper($this->input->post('status_code'));
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_status->saveNewData($data);
        redirect('status/listofStatus');

    }

    public function listofStatus() {

        if ($post = $this->input->post()) {
            if (isset($post['ids']) && is_array($post['ids'])) { // multiple
                $id = $post['ids'];
                if ($post['submit'] == 'multi_delete') {
                    // Multiple deleted
                    $this->model_status->removeMultiData($id);
                }
            }

            if (isset($post['remove'])) {
                $id = $post['remove'];
                if ($post){
                    //delete
                    $this->model_status->removeData($id);
                }
            }

        }
        $data['canMULTI_DELETE'] = $this->globalmodel->moduleFunction("status/listofStatus", 'MULTI_DELETE');
        $data['canEDIT'] = $this->globalmodel->moduleFunction("status/listofStatus", 'EDIT');
        $data['canDELETE'] = $this->globalmodel->moduleFunction("status/listofStatus", 'DELETE');
        $data['canADD'] = $this->globalmodel->moduleFunction("status/listofStatus", 'ADD');

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);
        //$data['issues'] = $this->model_issues->getIssueForApproval();
        $data['risks'] = $this->model_risks->getRiskForApproval();
        $data['projects'] = $this->model_projects->getTotalProjectForApproval($company);
        $data['data'] = $this->model_status->getDataStatus();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('status/listofStatus', $data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function editData() {

        $id = $this->input->post('id');
        $data['data'] = $this->model_status->getThisData($id);
        $response['editData'] = $this->load->view('status/editData', $data, true);

        echo json_encode($response);

    }

    public function update($id) {

        $data['status_code'] = strtoupper($this->input->post('status_code'));
        $data['description'] = ucfirst($this->input->post('description'));

        $this->model_status->saveupdateNewData($data, $id);

        redirect('status/listofStatus');
    }

    public function changeofstatus($user_company) {

    $edited_n = $this->session->userdata('sess_user_id');
    $edited_d = DATE('Y-m-d h:i:s');
    $prev_date = DATE('Y-m-d h:i:s');
    $company_name = "";
    if ($user_company == 1) {
        $company_name = "PHILIPPINE DAILY INQUIRER";
    } else if ($user_company == 2) {
        $company_name = "INQUIRER CATALYST MEDIA INC.";
    } else if ($user_company == 3) {
        $company_name = "HINGE INQUIRER PUBLICATION";
    } else if ($user_company == 4) {
        $company_name = "IPI MAKATI";
    } else if ($user_company == 5) {
        $company_name = "RADYO INQUIRER";
    } else if ($user_company == 6) {
        $company_name = "INQUIRER.NET";
    } else if ($user_company == 7) {
        $company_name = "DELIVERY ACCESS GROUP";
    } else if ($user_company == 8) {
        $company_name = "MEGAMOBILE INC.";
    } else if ($user_company == 9) {
        $company_name = "CEBU DAILY NEWS";
    } else if ($user_company == 10) {
        $company_name = "INQUIRER HOLDINGS INC.";
    } else if ($user_company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($user_company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($user_company == 13){
        $company_name = "PRINTTOWN";
    }

    $this->model_status->changenotyettoduestatus($user_company, $edited_n, $edited_d, $prev_date);
    redirect('status');


    }

    public function generatereport($user_company) {

    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);

    set_time_limit(0);

    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);

    $company_name = "";
    if ($user_company == 1) {
        $company_name = "PHILIPPINE DAILY INQUIRER";
    } else if ($user_company == 2) {
        $company_name = "INQUIRER CATALYST MEDIA INC.";
    } else if ($user_company == 3) {
        $company_name = "HINGE INQUIRER PUBLICATION";
    } else if ($user_company == 4) {
        $company_name = "IPI MAKATI";
    } else if ($user_company == 5) {
        $company_name = "RADYO INQUIRER";
    } else if ($user_company == 6) {
        $company_name = "INQUIRER.NET";
    } else if ($user_company == 7) {
        $company_name = "DELIVERY ACCESS GROUP";
    } else if ($user_company == 8) {
        $company_name = "MEGAMOBILE INC.";
    } else if ($user_company == 9) {
        $company_name = "CEBU DAILY NEWS";
    } else if ($user_company == 10) {
        $company_name = "INQUIRER HOLDINGS INC.";
    } else if ($user_company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($user_company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($user_company == 13){
        $company_name = "PRINTTOWN";
    }

    $reportname = "";
    $reportname = "MONITORING OF DUE DATE";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .35, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .10, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'left'),
                array('text' => 'Department', 'width' => .20, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .09, 'align' => 'center'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'left')
                );

    $template = $engine->getTemplate();
    $template->setText($company_name, 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE AS OF TODAY', 10);

    $template->setFields($fields);

    $list = $this->model_status->getduestatusasoftoday($user_company);

    $no = 1;
    $grandtotalcount = 0;
                foreach($list as $row) {
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['apentered_date'], 'align' => 'left'),
                        array('text' => $row['apstatus'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['apfullname'], 'align' => 'left'),
                        array('text' => $row['assignedaudit'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                }

    $template->setData($result);

    $template->setPagination();

    $engine->display();

    }

}
