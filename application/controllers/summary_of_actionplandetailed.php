<?php


class Summary_of_actionplandetailed extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }

        $this->load->model(array('model_global/globalmodel','model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/entry_report', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies'));
    }

    public function index() {

        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $data['ap_issue'] = $this->model_issues->getIssues();
        $data['company'] = $this->companies->getAllCompanies();
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getAuditStaff();
        $data['ap_status'] = $this->model_status->getDataStatusView();

        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('reports/summaryofactionplandetailed', $data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function generatereport($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company, $recur) {

    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);

    set_time_limit(0);

    $company_name = "";
    if ($user_company == 0) {
        $company_name = "ALL";
    } else if ($user_company == 1) {
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
    } else {
        $company_name = "PRINTTOWN";
    }

    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);

    $reportname = "";
    if ($reporttype == 1) {
    $reportname = "STATUS OF ACTION PLANS BY STATUS";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Department', 'width' => .12, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .08, 'align' => 'left'),
                array('text' => '', 'width' => .02, 'align' => 'left'),
                array('text' => 'Issue', 'width' => .10, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .12, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .08, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .05, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .08, 'align' => 'left'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'left')
                );
    } else if ($reporttype == 2) {
    $reportname = "STATUS OF ACTION PLANS BY DEPARTMENT";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Status', 'width' => .04, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .08, 'align' => 'left'),
                array('text' => '', 'width' => .02, 'align' => 'left'),
                array('text' => 'Issue', 'width' => .12, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .12, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .10, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .05, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .10, 'align' => 'right'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'right')
                );
    } else if ($reporttype == 3) {
    $reportname = "STATUS OF ACTION PLANS BY RISK";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'left'),
                array('text' => 'Department', 'width' => .10, 'align' => 'left'),
                array('text' => 'Issue', 'width' => .12, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .12, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .10, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .05, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .08, 'align' => 'right'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'right')
                );
    } else if ($reporttype == 4) {
    $reportname = "STATUS OF ACTION PLANS BY ISSUE";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'left'),
                array('text' => 'Department', 'width' => .10, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .09, 'align' => 'left'),
                array('text' => '', 'width' => .02, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .12, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .10, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .05, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .08, 'align' => 'right'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'right')
                );
    } else if ($reporttype == 5) {
    $reportname = "STATUS OF ACTION PLANS BY PROJECT NAME";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'left'),
                array('text' => 'Department', 'width' => .10, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .09, 'align' => 'left'),
                array('text' => '', 'width' => .02, 'align' => 'left'),
                array('text' => 'Issue', 'width' => .12, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .10, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .05, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .08, 'align' => 'right'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'right')
                );
    } else {
    $reportname = "ALL";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Status', 'width' => .04, 'align' => 'left'),
                array('text' => 'Department', 'width' => .15, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .09, 'align' => 'left'),
                array('text' => '', 'width' => .02, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .10, 'align' => 'left'),
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .09, 'align' => 'center'),
                array('text' => 'Aging', 'width' => .06, 'align' => 'center', 'bold' => true),
                array('text' => 'Remarks', 'width' => .08, 'align' => 'left'),
                array('text' => 'Audit Staff', 'width' => .05, 'align' => 'left')
                );
    }

    $template = $engine->getTemplate();
    $template->setText('PHILIPPINE DAILY INQUIRER, INC.', 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom)), 12);

    $template->setFields($fields);

    $list = $this->entry_report->getStatusOfActionPlanReports($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company, $recur);

    $no = 1;
    if ($reporttype == 1) {
        $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($list as $status  => $datax) {
                $result[] = array(array('text' => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array();
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    } else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                }

                $result[] = array(
                    array('text' => $no,  'align' => 'center'),
                    array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                    array('text' => $row['dept_name'], 'align' => 'left'),
                    array('text' => $row['risk_name'], 'align' => 'left'),
                    array('text' => '-  '.$row['rating_code'], 'align' => 'left'),
                    array('text' => $row['issue_name'], 'align' => 'left'),
                    array('text' => $row['project_name'], 'align' => 'left'),
                    array('text' => $row['entered_date'], 'align' => 'left'),
                    array('text' => $row['ap_due_date'], 'align' => 'left'),
                    array('text' => $row['person'], 'align' => 'left'),
                    array('text' => $aging, 'align' => 'center' , 'bold' => true),
                    array('text' => $row['remarks'], 'align' => 'left'),
                    array('text' => $row['audit_staff'], 'align' => 'left')
                );
                $no +=1;  $grandtotalcount += 1;
            }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           } else if ($reporttype == 2) {
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($list as $dept  => $datax) {
                $result[] = array(array('text' => 'DEPARTMENT'.' - '.$dept, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array();
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    }
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'left'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'left'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;
                }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           } else if ($reporttype == 3) {
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($list as $risk  => $datax) {
                $result[] = array(array('text' => 'RISK'.' - '.$risk, 'align' => 'left', 'bold' => true, 'size' => 10));
                $result[] = array();
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    }
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else if ($reporttype == 4) {
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($list as $issue  => $datax) {
                $result[] = array(array('text' => 'ISSUE'.' - '.$issue, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    }
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else if ($reporttype == 5) {
            $no = 1;
            $subtotal = 0; $grandtotalcount = 0; $aging = 0;
            foreach ($list as $project_name  => $datax) {
                $result[] = array(array('text' => 'PROJECT NAME'.' - '.$project_name, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    }
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'right'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'right'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Subtotal', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($subtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

                $result[] = array();
             }

                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );


           } else {
            $no = 1;
            $grandtotalcount = 0; $aging = 0;
                foreach($list as $row) {
                    $datetoday = new DateTime($datefrom);
                    $duedate = new DateTime($row['ap_due_date']);
                    $diff = date_diff($datetoday, $duedate);

                    if ($duedate >= $datetoday) {
                        $aging = 0;
                    }  else if ($diff->days >= 0) {
                        $aging = $diff->format('%a days')."\n";
                    }
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'),
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['risk_name'], 'align' => 'left'),
                        array('text' => '-  '.$row['rating_code'], 'align' => 'right'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['ap_due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),
                        array('text' => $aging, 'align' => 'center' , 'bold' => true),
                        array('text' => $row['remarks'], 'align' => 'left'),
                        array('text' => $row['audit_staff'], 'align' => 'left')
                    );
                    $no +=1;  $grandtotalcount += 1;

                }

                $result[] = array();
                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 10),
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );

           }

    $template->setData($result);

    $template->setPagination();

    $engine->display();

    }

    public function generate_excel() {

    $datefrom = $this->input->get("datefrom");
    $reporttype = $this->input->get("reporttype");
    $status = $this->input->get("status");
    $dept = $this->input->get("dept");
    $risk = $this->input->get("risk");
    $issue = $this->input->get("issue");
    $project_name = $this->input->get("project_name");
    $user_company = $this->input->get("user_company");
    $recur = $this->input->get("recur");

    $data['dlist'] = $this->entry_report->getStatusOfActionPlanReports($datefrom, $reporttype, $status, $dept, $risk, $issue, $project_name, $user_company, $recur);

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


    if ($reporttype == 1) {
        $reportname = "STATUS OF ACTION PLANS BY STATUS";
    } elseif ($reporttype == 2) {
        $reportname = "STATUS OF ACTION PLANS BY DEPARTMENT";
    } elseif ($reporttype == 3) {
        $reportname = "STATUS OF ACTION PLANS BY RISK";
    } elseif ($reporttype == 4) {
        $reportname = "STATUS OF ACTION PLANS BY ISSUE";
    } elseif ($reporttype == 5) {
        $reportname = "STATUS OF ACTION PLANS BY PROJECT NAME";
    } else {
        $reportname = "ALL";
    }


    $data['company_name'] = $company_name;
    $data['user_company'] = $user_company;
    $data['datefrom'] = $datefrom;
    $data['reportname'] = $reportname;
    $data['reporttype'] = $reporttype;

    $html = $this->load->view('reports/excell/summaryofactiondetailed', $data, true);
    $filename ="Report_type_".$reportname.".xls";
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header('Content-Disposition: attachment; filename='.$filename);
    echo $html ;
    exit();

    }

}
