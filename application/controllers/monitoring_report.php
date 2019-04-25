<?php

class Monitoring_report extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }

        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/entry_report'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_risk/model_risks'));
    }

    public function index() {

        $navigation['data'] = $this->globalmodel->moduleList();
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getAuditStaff();
        $data['status'] = $this->model_status->getAllStatusReport();

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('reports/audit_monitoring_view',$data, true);
        $this->load->view('welcome_index', $layout);

    }

    public function generatereport($datefrom_as, $reporttype, $dept, $project_name, $user_company, $report_period, $allstatus) {


    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);

    set_time_limit(0);

    $reportname = "";
    if ($reporttype == 1) {
            if ($reporttype == 1) {
                $reportname = "ALL";
            }

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
        $company_name = "INQUIRER HOLDINGS INC";
    } else if ($user_company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($user_company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($user_company == 13){
        $company_name = "PRINTTOWN";
    }

        if ($reporttype == 1) {
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
        $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Code', 'width' => .03, 'align' => 'right', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .40, 'align' => 'left'),
                array('text' => 'Status', 'width' => .15, 'align' => 'center'),
                array('text' => 'Date Entered', 'width' => .07, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .07, 'align' => 'left'),
                array('text' => 'Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => 'Date Revised', 'width' => .07, 'align' => 'right'),
                array('text' => 'Date Tagged', 'width' => .07, 'align' => 'right')
                );
        }

    }

    $template = $engine->getTemplate();
    $template->setText($company_name, 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom_as)), 12);

    $template->setFields($fields);

    $list = $this->entry_report->getAllData($datefrom_as,$reporttype,$dept,$project_name,$user_company, $report_period,$allstatus);

    #print_r2($list); exit  ;

    if ($reporttype == 1 ) {
        $no = 1; $grandtotalcount = 0;
        foreach ($list as $business_concern => $datarow) {
            $result[] = array(array('text' => BC.' - '.$business_concern, 'align' => 'left', 'bold' => true, 'size' => 10));
                    $subtotal = 0;
                    foreach ($datarow as $row) {
                        $result[] = array(array("text" => $no, 'align' => 'left'),
                                    array("text" => $row['code'], 'align' => 'left'),
                                    array("text" => $row['action_plan'], 'align' => 'left'),
                                    array("text" => $row['status_name'], 'align' => 'center'),
                                    array("text" => $row['ap_entered_date'], 'align' => 'right'),
                                    array("text" => $row['ap_due_date'], 'align' => 'right'),
                                    array("text" => $row['ap_date_implemented'], 'align' => 'right'),
                                    array("text" => $row['ap_date_revised'], 'align' => 'right'),
                                    array("text" => $row['ap_date_tag'], 'align' => 'right')
                                   );

                                   $no += 1; $subtotal += 1; $grandtotalcount += 1;
                    }

                    $result[] = array(array('text' => ''),
                                array('text' => ''),
                                array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                                array('text' => $subtotal, 'align' => 'center', 'bold' => true, 'style' => true)

                                );

                    $result[] = array();

                    
                }

                    $result[] = array(array('text' => ''),
                                array('text' => ''),
                                array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                                array('text' => $grandtotalcount, 'align' => 'center', 'bold' => true, 'style' => true)

                                );

            }


    $template->setData($result);

    $template->setPagination();

    $engine->display();

    }

    public function generate_excel () {

    $datefrom_as = $this->input->get("datefrom_as");
    $report_period = $this->input->get("report_period");
    $reporttype = $this->input->get("reporttype");
    $dept = $this->input->get("dept");
    $project_name = $this->input->get("project_name");
    $user_company = $this->input->get("user_company");
    $allstar = $this->input->get("allstar");

    $data['dlist'] = $this->entry_report->getAllData($datefrom_as, $reporttype, $dept, $project_name, $user_company, $report_period, $allstar);

    #print_r2($data['dlist']) ; exit;

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
        $company_name = "INQUIRER HOLDINGS INC";
    } else if ($user_company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($user_company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($user_company == 13){
        $company_name = "PRINTTOWN";
    }

    $reportname = "";

    if ($reporttype == 1 ) {

        if ($reporttype == 1) {
            $reportname = "ALL";
        }

    }


    $data['company_name'] = $company_name;
    $data['user_company'] = $user_company;
    $data['datefrom_as'] = $datefrom_as;
    $data['reportname'] = $reportname;
    $data['reporttype'] = $reporttype;

    $html = $this->load->view('reports/excell/monitoring', $data, true);
    $filename ="Report_type_".$reportname.".xls";
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header('Content-Disposition: attachment; filename='.$filename);
    echo $html ;
    exit();

    }

}
