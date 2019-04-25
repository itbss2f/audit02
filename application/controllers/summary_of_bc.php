<?php

class Summary_of_bc extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_entry/entry_summary_bc'));
    }

    public function index() {

        $navigation['data'] = $this->globalmodel->moduleList();
        $user_id = $this->session->userdata('sess_user_id');
        $company = $this->session->userdata('sess_company_id');
        $data['ap_issue'] = $this->model_issues->getIssues();
        //$data['user_company'] = $this->companies->getCompaniesForThisUser($user_id);
        $data['ap_risk_rating'] = $this->risk_ratings->getRates();
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();
        $data['ap_project'] = $this->model_projects->getProjects($company);
        $data['ap_users'] = $this->users->getAuditStaff();
        $data['bc_status'] = $this->model_status->getDataStatusforBusinessView();
        //$data['ap_status'] = $this->model_status->getDataStatusView();

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('reports/summaryofbc',$data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function generatereport($datefrom_as, $reporttype, $bc_status, $dept, $project_name, $user_company, $report_period) {


        set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
        #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

        ini_set('memory_limit', -1);

        set_time_limit(0);

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
        } else {
            $company_name = "PRINTTOWN";
        }

        $statusname = "";
        if($bc_status == 9) {
            $statusname = "OUTSTANDING";
        } else if($bc_status == 10) {
            $statusname = "RESOLVED";
        } else if ($bc_status == 8) {
            $statusname = "CANCELLED";
        }

        $reportname = "";
        if (($reporttype == 1) && ($bc_status == 9)) {
        $reportname = "SUMMARY OF BUSINESS CONCERN";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .20, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Added', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Resolved', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Cancelled', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Ending Balance', 'width' => .10, 'align' => 'right')
                    );
        } 
        else if (($reporttype == 1) && ($bc_status == 10))  {
        $reportname = "SUMMARY OF BUSINESS CONCERN";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .25, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From Outstanding', 'width' => .12, 'align' => 'right'),
                    array('text' => 'Ending Balance', 'width' => .10, 'align' => 'right')
                    );

        }
        else if (($reporttype == 1) && ($bc_status == 8))  {
        $reportname = "SUMMARY OF BUSINESS CONCERN";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .30, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From Outstanding', 'width' => .15, 'align' => 'right'),
                    array('text' => 'Ending Balance', 'width' => .10, 'align' => 'right')
                    );

        }
    
        $template = $engine->getTemplate();
        $template->setText($company_name, 10);
        $template->setText('REPORT TYPE - '.$reportname, 10);
        $template->setText('STATUS - '.$statusname, 10);
        $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom_as)), 10);

        $template->setFields($fields);

        $list = $this->entry_summary_bc->getSummaryOfBusinessConcern($datefrom_as, $reporttype, $bc_status, $dept, $project_name, $user_company, $report_period);
        #print_r2($list) ; exit;
        $no = 1;

        if ($reporttype == 1 && $report_period == 1 && $bc_status == 9) {
            $added = 0; $resolved= 0; $tocancelled = 0; $begin = 0; $ending = 0;
            $grandtotaladded = 0; $grandtotalresolved = 0; $grandtotaltocancelled = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0;
                foreach ($list as $row) {
                    $add = $row['added'];
                    $total = $row['beginning'];
                    $begin = $total;
                    $added = $add;
                    $t1 = $begin + $resolved;
                    $t2 = $tocancelled + $added;
                    $ending = $t1 + $t2;
                    $resolved = $row['resolved'];
                    $tocancelled = $row['tocancelled'];
               
             
                $result[] = array(array("text" => $no, 'align' => 'left'),
                            array("text" => $row['dept_name'], 'align' => 'left'),
                            array("text" => $begin, 'align' => 'right'),
                            array("text" => $added, 'align' => 'right'),
                            array("text" => $resolved, 'align' => 'right'),
                            array("text" => $tocancelled, 'align' => 'right'),
                            array("text" => $ending, 'align' => 'right')
                           );

                           $no += 1;
                           $grandtotalbegin += $begin; $grandtotalending += $ending; $grandtotaladded += $added;
                           $grandtotalresolved += $resolved; $grandtotaltocancelled += $tocancelled;
                           

                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbegin, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaladded, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalresolved, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltocancelled, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );

        }

        else if ($reporttype == 1 && $report_period == 1 && $bc_status == 10) {
            $newproject = 0; $outstanding= 0; $begin = 0; $ending = 0;
            $grandtotalnewproject = 0; $grandtotaloutstanding = 0; $grandtotalbegin = 0; $grandtotalending = 0;
                   foreach ($list as $row) {
                    $newproj = $row['newproj'];
                    $total = $row['beginning'];
                    $out = $row['outstanding'];
                    $begin = $total;
                    $newproject = $newproj;
                    $outstanding = $out;
                    $t1 = $begin + $newproject;
                    $ending = $t1 + $outstanding;

                $result[] = array(array("text" => $no, 'align' => 'left'),
                            array("text" => $row['dept_name'], 'align' => 'left'),
                            array("text" => $begin, 'align' => 'right'),
                            array("text" => $newproject, 'align' => 'right'),
                            array("text" => $outstanding, 'align' => 'right'),
                            array("text" => $ending, 'align' => 'right')
                           );

                           $no += 1;
                           $grandtotalbegin += $begin; $grandtotalending += $ending; $grandtotalnewproject += $newproject;
                           $grandtotaloutstanding += $outstanding;

                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbegin, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaloutstanding, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );

        } 

        else if ($reporttype == 1 && $report_period == 1 && $bc_status == 8) {
            $outstanding= 0; $begin = 0; $ending = 0;
            $grandtotaloutstanding = 0; $grandtotalbegin = 0; $grandtotalending = 0;
                   foreach ($list as $row) {
                    $out = $row['outstanding'];
                    $total = $row['beginning'];
                    $begin = $total;
                    $outstanding = $out;
                    $ending = $begin + $outstanding;
            

                $result[] = array(array("text" => $no, 'align' => 'left'),
                            array("text" => $row['dept_name'], 'align' => 'left'),
                            array("text" => $begin, 'align' => 'right'),
                            array("text" => $outstanding, 'align' => 'right'),
                            array("text" => $ending, 'align' => 'right')
                           );

                           $no += 1;
                           $grandtotalbegin += $begin; $grandtotalending += $ending; $grandtotaloutstanding += $outstanding;
                        

                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbegin, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaloutstanding, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );

        } 


        $template->setData($result);

        $template->setPagination();

        $engine->display();

        }

}
