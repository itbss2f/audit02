<?php

class Summary_of_actionplan extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_entry/entry_summary', 'model_entry/entry_report'));
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
        $data['ap_status'] = $this->model_status->getDataStatusView();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('reports/summaryofactionplan',$data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function generatereport($datefrom_as, $reporttype, $status, $dept, $project_name, $user_company, $report_period, $report_period2) {

        set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
        #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

        ini_set('memory_limit', -1);

        set_time_limit(0);

        /*if ($row['stat'] == 'beginning') {
            $newdate = date('2017-10-01');
        } else {
            $newdate = date('Y-m-d', strtotime('-1 months', strtotime($datefrom_as)));
        }*/

        $newdate = date('Y-m-d', strtotime('-1 months', strtotime($datefrom_as)));
        

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
        if($status == 1) {
            $statusname = "DUE FOR IMPLEMENTATION";
        } else if($status == 2) {
            $statusname = "IMPLEMENTATION";
        } else if($status == 3) {
            $statusname = "WITH LIMITATIONS";
        } else if($status == 4) {
            $statusname = "NOT YET DUE";
        } else if($status == 5) {
            $statusname = "ACCEPTED RISK";
        } else if($status == 6) {
            $statusname = "REVISED DATE";
        } else if($status == 7) {
            $statusname = "SUPERSEDED";
        } else if($status == 8) {
            $statusname = "CANCEL";
        } else {
            $statusname = "ALL";
        }

        $reportname = "";
        if (($reporttype == 1) && ($status == 1)) {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .13, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .09, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .09, 'align' => 'right'),
                    array('text' => 'From NYD', 'width' => .09, 'align' => 'right'),
                    array('text' => 'From ARisk', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To Implemented', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To W/Limit', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To ARisk', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Cancelled', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .10, 'align' => 'right')
                    );
        } 
        else if (($reporttype == 1) && ($status == 2))  {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .10, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .10, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .14, 'align' => 'right'),
                    array('text' => 'From NYD', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From Due for Implement', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From W/Limit', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From Acceptedrisk', 'width' => .12, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .10, 'align' => 'right')
                    );

        }
        else if (($reporttype == 1) && ($status == 3))  {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .15, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .10, 'align' => 'right'),
                    array('text' => 'From Due for Implement', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From NYD', 'width' => .12, 'align' => 'right'),
                    array('text' => 'To Cancelled', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Imp', 'width' => .07, 'align' => 'right'),
                    array('text' => 'To Due', 'width' => .07, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .07, 'align' => 'right')
                    );

        }
        else if (($reporttype == 1) && ($status == 4))  {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .20, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .10, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Due', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Implemented', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To W/Limit', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To ARisk', 'width' => .09, 'align' => 'right'),
                    array('text' => 'To Cancelled', 'width' => .09, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .09, 'align' => 'right')
                    );

        }

        else if (($reporttype == 1) && ($status == 5))  {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .18, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From Due', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From NYD', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Implemented', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Due', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .10, 'align' => 'right')
                    );

        }
        else if (($reporttype == 1) && ($status == 8))  {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Department', 'width' => .25, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From Due for Implementation', 'width' => .15, 'align' => 'right'),
                    array('text' => 'From Not Yet Due', 'width' => .12, 'align' => 'right'),
                    array('text' => 'From With Limitations', 'width' => .12, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .12, 'align' => 'right')
                    );

        }
        else if($reporttype == 2) {
        $reportname = "SUMMARY OF ACTION PLANS DETAILED";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                        array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                        array('text' => 'Department', 'width' => .25, 'align' => 'left'),
                        array('text' => 'Beginning', 'width' => .08, 'align' => 'right'),
                        array('text' => 'From New Projects', 'width' => .10, 'align' => 'right'),
                        array('text' => 'From NYD', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To Implemented', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To W/Limit', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To Cancelled', 'width' => .10, 'align' => 'right'),
                        array('text' => 'Ending', 'width' => .10, 'align' => 'right')
                        );

        }

        $template = $engine->getTemplate();
        $template->setText($company_name, 10);
        $template->setText('REPORT TYPE - '.$reportname, 10);
        $template->setText('STATUS - '.$statusname, 10);
        $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom_as)), 10);

        $template->setFields($fields);


        $list = $this->entry_summary->getSummaryOfActionPlanReports($datefrom_as, $newdate, $reporttype, $status, $dept, $project_name, $user_company, $report_period,$report_period2);

        $list2 = $this->entry_report->getStatusOfActionPlanReportperdepartment($datefrom_as,$newdate, 6, $status, 0, 0, 0, 0, $user_company, 0);
        #print_r2($list2) ; exit;

        #print_r2($list) ; exit;
        $no = 1;

        if ($reporttype == 1 && $report_period == 1 && $status == 1) {
            $totalbegin = 0; $newproject = 0; $toimplemented= 0;$nydue = 0; $begin = 0; $ending = 0; $tolimit = 0; $tocancelled = 0;
            $grandtotalnewproject = 0; $grandtotalimplemented = 0; $grandtotalnydue = 0; $grandtotalbegin = 0; $grandtotalending = 0; 
            $grandtotalcount = 0; $grandtotaltolimit = 0; $grandtotaltocancelled = 0; $grandtotalbegin2 = 0; $ending2 = 0; $grandtotaltoacceptedrisk = 0; 
            $grandtotaltoacceptedrisk2 = 0; $grandtotalbegin22 = 0; $grandtotalnewproject2 = 0; $grandtotalnydue2 = 0; $grandtotaltoimplemented2 = 0; 
            $grandtotaltolimit2 = 0; $grandtotaltocancelled2 = 0; $grandtotalacceptedrisk = 0; $grandtotalbegin0 = 0; $ending3;
            $grandtotalnewproject22 = 0;
            //$grandtotalnewprojectfinal = 0; $grandtotalnyduefinal = 0; $grandtotaltoimplementedfinal = 0; $grandtotaltolimitfinal = 0; $grandtotaltocancelledfinal = 0;
            
            if ($report_period2 == 1) {

                foreach ($list2 as $row) {

                        if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                            array("text" => $row['dept_name'], 'align' => 'left'),
                                            array("text" => $row['beginning'], 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right')
                                           );

                                            $no += 1;

                        }

                        else if ($row['stat'] == 'newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }      

                        else if ($row['stat'] == 'nyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }     

                        else if ($row['stat'] == 'fromacceptedrisk') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }     

                        else if ($row['stat'] == 'imp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }   

                        else if ($row['stat'] == 'limit') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }  

                        else if ($row['stat'] == 'toacceptedrisk') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }       

                        else if ($row['stat'] == 'tocancelled') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                        }      

                } 

                foreach ($list as $row) {

                        if ($row['stat'] == 'beginning2') {

                                        $grandtotalbegin2 += $row['beginning']; 
                        }     

                        if ($row['stat'] == 'beginning0') {

                                        $grandtotalbegin0 += $row['beginning']; 
                        } 

                        else if ($row['stat'] == 'newproj2') {

                                    $grandtotalnewproject2 += $row['beginning']; 

                        }  

                        //IF NEWPROJ TO DIFF STATUS
                        else if ($row['stat'] == 'newproj22') {

                                    $grandtotalnewproject22 += $row['beginning']; 

                        }       
                        

                        else if ($row['stat'] == 'nyd2') {

                                    $grandtotalnydue2 += $row['beginning']; 

                        }    

                        else if ($row['stat'] == 'fromacceptedrisk2') {

                                    $grandtotalacceptedrisk2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'imp2') {

                                    $grandtotaltoimplemented2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit2') {

                                    $grandtotaltolimit2 += $row['beginning']; 

                        }  

                        else if ($row['stat'] == 'toacceptedrisk2') {

                                    $grandtotaltoacceptedrisk2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'tocancelled2') {

                                    $grandtotaltocancelled2 += $row['beginning']; 

                        }  

                        if ($row['stat'] == 'beginning') {

                                    $grandtotalbegin += $row['beginning']; 
                            
                        }

                        else if ($row['stat'] == 'newproj') {


                                    $grandtotalnewproject += $row['beginning']; 
                        }      

                        else if ($row['stat'] == 'nyd') {

                                    $grandtotalnydue += $row['beginning']; 

                        }    

                        else if ($row['stat'] == 'fromacceptedrisk') {

                                    $grandtotalacceptedrisk += $row['beginning']; 

                        }    

                        else if ($row['stat'] == 'imp') {

                                    $grandtotaltoimplemented += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit') {


                                    $grandtotaltolimit += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'toacceptedrisk') {


                                    $grandtotaltoacceptedrisk += $row['beginning']; 

                        }    

                        else if ($row['stat'] == 'tocancelled') {


                                    $grandtotaltocancelled += $row['beginning']; 

                        }      
                            //History

                            $grandtotalnewprojectfinal = $grandtotalnewproject2 + $grandtotalnewproject22;

                            $ending3 =  $grandtotalbegin - $grandtotalbegin0;

                            $ending =  $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled + $grandtotaltoacceptedrisk;
                            $grandtotalbeginfinal = $grandtotalbegin2 + $grandtotalnewproject + $grandtotalnydue + $grandtotalacceptedrisk - $ending;
                            $grandtotalbegin2 = $grandtotalbegin + $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled + $grandtotaltoacceptedrisk;

                            $ending2 = $grandtotaltoimplemented2 + $grandtotaltolimit2 + $grandtotaltocancelled2 + $grandtotaltoacceptedrisk2;
                            $grandtotalending = $grandtotalbeginfinal + $grandtotalnewproject2 + $grandtotalnydue2 + $grandtotalacceptedrisk2 + $grandtotaltoimplemented2 + $grandtotaltolimit2 + $grandtotaltocancelled2 + $grandtotaltoacceptedrisk2 - $ending2 - $ending3;


                }  

                    $result[] = array();
                    $result[] = array(array('text' => ''),
                                array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                                array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotalnewprojectfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotalnydue2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotalacceptedrisk2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotaltoimplemented2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotaltolimit2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotaltoacceptedrisk2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotaltocancelled2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                              ); 
            }

            /*else if ($report_period2 == 2) {

                foreach ($list as $row) {

                        if ($row['stat'] == 'beginning2') {

                                $result[] = array(array("text" => $no, 'align' => 'left'),
                                            array("text" => $row['dept_name'], 'align' => 'left'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right')
                                           );

                                        $no += 1;

                                        $grandtotalbegin22 += $row['beginning']; 
                        }     

                        else if ($row['stat'] == 'newproj2') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnewproject2 += $row['beginning']; 

                        }      

                        else if ($row['stat'] == 'nyd2') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnydue2 += $row['beginning']; 

                        }     

                        else if ($row['stat'] == 'imp2') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltoimplemented2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit2') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltolimit2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'tocancelled2') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltocancelled2 += $row['beginning']; 

                        }  

                        if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                        array("text" => $row['dept_name'], 'align' => 'left'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $no += 1;

                                    $grandtotalbegin += $row['beginning']; 
                        }

                        else if ($row['stat'] == 'newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnewproject += $row['beginning']; 
                        }      

                        else if ($row['stat'] == 'nyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnydue += $row['beginning']; 

                        }     

                        else if ($row['stat'] == 'imp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltoimplemented += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltolimit += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'tocancelled') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltocancelled += $row['beginning']; 
                        }            
                            
                                $ending =  $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled;
                                $grandtotalending = $grandtotalbegin2 + $grandtotalnewproject + $grandtotalnydue - $ending;
                                $grandtotalbegin2 = $grandtotalbegin + $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled;  

                }
                            $result[] = array();
                            $result[] = array(array('text' => ''),
                                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                                        array('text' => number_format($grandtotalbegin2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotalnewproject, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotalnydue, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotaltoimplemented, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotaltolimit, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotaltocancelled, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                                        array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                                      ); 
            }*/
                       
        }

        else if ($reporttype == 1 && $report_period == 1 && $status == 2) {
            $totalbegin = 0; $newproject = 0; $dueforimplement= 0;$nydue = 0; $begin = 0; $ending = 0; $grandtotalfromacceptedrisk = 0;
            $grandtotalnewproject = 0; $grandtotalimplemented = 0; $grandtotalnydue = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0;
            $grandtotaldueforimplement = 0; $grandtotaltolimit = 0; $grandtotalbegin2 = 0; $ending2 = 0; $grandtotalbegin22 = 0; $grandtotalnewproject2 = 0; 
            $grandtotalnydue2 = 0; $grandtotaldueforimplement2 = 0; $grandtotaltolimit2 = 0; $grandtotalfromacceptedrisk2 = 0;

            if ($report_period2 == 1) {

                foreach ($list2 as $row) {

                    if ($row['stat'] == 'beginning') {

                                $result[] = array(array("text" => $no, 'align' => 'left'),
                                            array("text" => $row['dept_name'], 'align' => 'left'),
                                            array("text" => $row['beginning'], 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right'),
                                            array("text" => '', 'align' => 'right')
                                           );

                                        $no += 1;

                                        $grandtotalbegin += $row['beginning']; 
                        }     

                        else if ($row['stat'] == 'newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnewproject += $row['beginning']; 

                        }      

                        else if ($row['stat'] == 'nyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnydue += $row['beginning']; 

                        }     

                        else if ($row['stat'] == 'dueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaldueforimplement += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltolimit += $row['beginning']; 

                        }  

                        else if ($row['stat'] == 'fromacceptedrisk') {

                            $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalfromacceptedrisk += $row['beginning']; 

                        }
                    

                }

                foreach ($list as $row) {

                        if ($row['stat'] == 'beginning2') {

                                    $grandtotalbegin22 += $row['beginning']; 
                        }     

                        else if ($row['stat'] == 'newproj2') {

                                    $grandtotalnewproject2 += $row['beginning']; 

                        }      

                        else if ($row['stat'] == 'nyd2') {


                                    $grandtotalnydue2 += $row['beginning']; 

                        }     

                        else if ($row['stat'] == 'dueforimp2') {


                                    $grandtotaldueforimplement2 += $row['beginning']; 

                        }   

                        else if ($row['stat'] == 'limit2') {

                        
                                    $grandtotaltolimit2 += $row['beginning']; 

                        }

                        else if ($row['stat'] == 'fromacceptedrisk2') {


                                    $grandtotalfromacceptedrisk2 += $row['beginning']; 

                        }

                        //$grandtotalending = $grandtotalbegin + $grandtotalnewproject + $grandtotalnydue + $grandtotaldueforimplement + $grandtotaltolimit + $grandtotalfromacceptedrisk;
                  

                        $ending =  $grandtotalnewproject + $grandtotalnydue + $grandtotaldueforimplement + $grandtotaltolimit + $grandtotalfromacceptedrisk;
                        $grandtotalbegin22 = $grandtotalbegin;
                        $grandtotalbeginfinal = $grandtotalbegin22 + $grandtotalnewproject + $grandtotalnydue + $grandtotaldueforimplement + $grandtotaltolimit + $grandtotalfromacceptedrisk - $ending;
                        $ending2 = $grandtotalnydue2 + $grandtotaldueforimplement2 + $grandtotaltolimit2 + $grandtotalfromacceptedrisk2;
                        $grandtotalending = $grandtotalbeginfinal + $grandtotalnewproject2 + $grandtotalnydue2 + $grandtotaldueforimplement2 + $grandtotaltolimit2 + $grandtotalfromacceptedrisk2 - $ending2;


                }  

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnydue2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaldueforimplement2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltolimit2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalfromacceptedrisk2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );
            }

        } 

        else if ($reporttype == 1 && $report_period == 1 && $status == 3) {
            $totalbegin = 0; $dueforimplement= 0; $nydue = 0; $begin = 0; $ending = 0; $tocancelled = 0; $newproject = 0;
            $grandtotaldueforimplement = 0; $grandtotalnydue = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0; $grandtotaltocancelled = 0;
            $grandtotaltodueforimp = 0; $grandtotaltoimplemented = 0; $grandtotaltocancelled = 0; $grandtotalbeginfinal = 0; 
            $grandtotalbegin2 = 0; $grandtotalnewproject2 = 0; $grandtotaldueforimplement2 = 0; $grandtotalnydue2 = 0; $grandtotaltocancelled2 = 0;
            $grandtotaltoimplemented2 = 0; $grandtotaltodueforimp2 = 0;

            if ($report_period2 == 1) {

                foreach ($list2 as $row) {
                    
                    if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                        array("text" => $row['dept_name'], 'align' => 'left'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $no += 1;

                                    $grandtotalbegin += $row['beginning']; 

                    }

                    else if ($row['stat'] == 'newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnewproject += $row['beginning']; 
                    }    

                    else if ($row['stat'] == 'dueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaldueforimplement += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'nyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnydue += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'tocancelled') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltocancelled += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'to_imp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltoimplemented += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'to_dueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltodueforimp += $row['beginning']; 
                    } 

                }

                foreach ($list as $row) {

                    if ($row['stat'] == 'beginning2') {

                                    $grandtotalbegin2 += $row['beginning']; 

                    }

                    else if ($row['stat'] == 'newproj2') {


                                    $grandtotalnewproject2 += $row['beginning']; 
                    }    

                    else if ($row['stat'] == 'dueforimp2') {

                                    $grandtotaldueforimplement2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'nyd2') {

                                    $grandtotalnydue2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'tocancelled2') {

                                    $grandtotaltocancelled2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'to_imp2') {

                                    $grandtotaltoimplemented2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'to_dueforimp2') {

                                    $grandtotaltodueforimp2 += $row['beginning']; 
                    } 




                    $ending =  $grandtotaltocancelled + $grandtotaltoimplemented + $grandtotaltodueforimp;

                    $ending2 = $grandtotalnewproject2 + $grandtotaldueforimplement2 + $grandtotalnydue2;

                    $grandtotalbeginfinal = $grandtotalbegin + $grandtotalnewproject2 + $grandtotaldueforimplement2 + $grandtotalnydue2 - $ending2;

                    $grandtotalending = $grandtotalbeginfinal + $grandtotalnewproject2 + $grandtotalnydue2 + $grandtotaldueforimplement2 - $grandtotaltocancelled2 - $grandtotaltoimplemented2 - $grandtotaltodueforimp2;



                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaldueforimplement2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnydue2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltocancelled2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltoimplemented2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltodueforimp2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );
            }

        } 

        else if ($reporttype == 1 && $report_period == 1 && $status == 4) {
            $totalbegin = 0; $newproject = 0; $dueforimplement= 0; $tolimit = 0; $begin = 0; $ending = 0; $tocancelled = 0; $toimplemented = 0;
            $grandtotalnewproject = 0; $grandtotalimplemented = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0; $grandtotaltocancelled = 0;
            $grandtotaltolimit = 0; $grandtotaldueforimplement = 0; $grandtotalbeginfinal = 0; $grandtotalnewproject2 = 0; $grandtotalbegin2 = 0; $ending2 = 0;
            $grandtotalnewproject = 0; $grandtotaldueforimplement2 = 0; $grandtotaltoimplemented2 = 0; $grandtotaltoacceptedrisk = 0; $grandtotaltoacceptedrisk2 = 0;
            $grandtotaltolimit2 = 0; $grandtotaltocancelled2 = 0;

            if ($report_period2 == 1) {

                foreach ($list2 as $row) {

                    if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                        array("text" => $row['dept_name'], 'align' => 'left'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $no += 1;

                                    $grandtotalbegin += $row['beginning']; 

                    }

                    else if ($row['stat'] == 'to_newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnewproject += $row['beginning']; 
                    }    

                    else if ($row['stat'] == 'to_dueforimplement') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaldueforimplement += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'imp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltoimplemented += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'tolimit') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltolimit += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'toacceptedrisk') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltoacceptedrisk += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'tocancelled') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltocancelled += $row['beginning']; 
                    } 

                }

                foreach ($list as $row) {

                    if ($row['stat'] == 'beginning2') {

                                    $grandtotalbegin2 += $row['beginning']; 
                    }

                    else if ($row['stat'] == 'to_newproj2') {

                                    $grandtotalnewproject2 += $row['beginning']; 
                    }    

                    else if ($row['stat'] == 'to_dueforimplement2') {

                                    $grandtotaldueforimplement2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'imp2') {

                                    $grandtotaltoimplemented2 += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'tolimit2') {

                                    $grandtotaltolimit2 += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'toacceptedrisk2') {


                                    $grandtotaltoacceptedrisk2 += $row['beginning']; 

                    }    

                    else if ($row['stat'] == 'tocancelled2') {

                                    $grandtotaltocancelled2 += $row['beginning']; 
                    }      
 
                    #formula 
                    #NYD Ending = begin + from newproj - (todueforimplement + toimplemented + towithlimit + tocancelled).

                    //$ending = $grandtotaldueforimplement + $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled;
                    //$grandtotalending = $grandtotalbegin + $grandtotalnewproject - $ending; 


                    $ending =  $grandtotaldueforimplement + $grandtotaltoimplemented + $grandtotaltolimit + $grandtotaltocancelled;

                    $grandtotalbegin2 = $grandtotalbegin ;

                    $ending2 = $grandtotalnewproject2 + $grandtotaldueforimplement2 + $grandtotaltoimplemented2 + $grandtotaltolimit2 + $grandtotaltocancelled2;

                    $grandtotalbeginfinal = $grandtotalbegin2;
                    
                    $grandtotalending = $grandtotalbeginfinal + $grandtotalnewproject2 - $grandtotaldueforimplement2 - $grandtotaltoimplemented2 - $grandtotaltolimit2 - $grandtotaltocancelled2 - $grandtotaltoacceptedrisk2 + $grandtotaltoimplemented2 + $grandtotaltolimit2 + $grandtotaltocancelled2 + $grandtotaltoacceptedrisk2;


                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaldueforimplement2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltoimplemented2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltolimit2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltoacceptedrisk2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltocancelled2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );
            }

        } 

        else if ($reporttype == 1 && $report_period == 1 && $status == 5) {
            $totalbegins = 0; $newproject = 0; $dueforimplement= 0; $begins = 0; $begin = 0; $ending = 0; $toimplemented = 0; $to_dueforimp = 0; $nydue = 0;
            $grandtotalnewproject = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0; $grandtotaldueforimplement = 0; $grandtotalnydue = 0; 
            $grandtotaltoimplemented = 0; $grandtotaltodueforimp = 0; $grandtotalbegin2 = 0; $grandtotalbeginfinal = 0;
            $grandtotaltodueforimp2 = 0; $grandtotaltoimplemented = 0; $grandtotalnewproject2 = 0; $grandtotaldueforimplement2 = 0; $grandtotalnydue2 = 0; $ending2 = 0;

            if ($report_period2 == 1) {

                foreach ($list2 as $row) {
                    
                    if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                        array("text" => $row['dept_name'], 'align' => 'left'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $no += 1;

                                   $grandtotalbegin += $row['beginning']; 

                    }  

                    else if ($row['stat'] == 'newproj') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    //$grandtotalnewproject2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'fromdueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    //$grandtotaldueforimplement += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'fromnyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    //$grandtotalnydue += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'to_imp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    //$grandtotaltoimplemented += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'to_dueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    //$grandtotaltodueforimp += $row['beginning']; 
                    }  

                }
           
                foreach ($list as $row) {


                    if ($row['stat'] == 'beginning2') {

                                    $grandtotalbegin2 += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'newproj2') {

                                    $grandtotalnewproject2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'fromdueforimp2') {

                                    $grandtotaldueforimplement2 += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'fromnyd2') {

                                    $grandtotalnydue2 += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'to_imp2') {

                                    $grandtotaltoimplemented2 += $row['beginning']; 
                    }     

                    else if ($row['stat'] == 'to_dueforimp2') {

                                    $grandtotaltodueforimp2 += $row['beginning']; 
                    }    

                
                    $ending = $grandtotaltoimplemented + $grandtotaltodueforimp + $grandtotaltoimplemented2 + $grandtotaltodueforimp2; 

                    $grandtotalbegin2 = $grandtotalbegin + $grandtotalnewproject + $grandtotaldueforimplement + $grandtotalnydue;

                    $ending2 = $grandtotalnewproject2 + $grandtotaldueforimplement2 + $grandtotalnydue2;

                    $grandtotalbeginfinal = $grandtotalbegin2 + $grandtotaltoimplemented + $grandtotaltodueforimp + $grandtotaltoimplemented2 + $grandtotaltodueforimp2;

                    $grandtotalending = $grandtotalbeginfinal + $grandtotalnewproject2 + $grandtotaldueforimplement2 + $grandtotalnydue2  - $grandtotaltoimplemented2 - $grandtotaltodueforimp2 - $grandtotaldueforimplement2 - $grandtotalnydue2  - $grandtotaltoimplemented2 - $grandtotaltodueforimp2 + $grandtotaltoimplemented2 + $grandtotaltodueforimp2;


                }
            

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaldueforimplement2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnydue2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltoimplemented2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltodueforimp2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );
            }

        } 

        else if ($reporttype == 1 && $report_period == 1 && $status == 8) {
            $totalbegin = 0; $dueforimplement= 0; $tolimit = 0; $begin = 0; $ending = 0; $nydue = 0;
            $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0; $grandtotalbeginfinal = 0;
            $grandtotalbegin2 = 0; $grandtotaldueforimplement = 0; $grandtotalnydue =0; $grandtotaltolimit = 0; 
            $grandtotaldueforimplement2 = 0; $grandtotalnydue2 = 0; $grandtotaltolimit2 = 0;


            if ($report_period2 == 1) {

                foreach ($list2 as $row) {

                     if ($row['stat'] == 'beginning') {

                            $result[] = array(array("text" => $no, 'align' => 'left'),
                                        array("text" => $row['dept_name'], 'align' => 'left'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $no += 1;

                                    $grandtotalbegin += $row['beginning']; 

                    }  

                    else if ($row['stat'] == 'dueforimp') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaldueforimplement += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'nyd') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotalnydue += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'tolimit') {

                             $result[] = array(array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'left'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => '', 'align' => 'right'),
                                        array("text" => $row['beginning'], 'align' => 'right'),
                                        array("text" => '', 'align' => 'right')
                                       );

                                    $grandtotaltolimit += $row['beginning']; 
                    }  

                }
                   
                foreach ($list as $row) {     

                    if ($row['stat'] == 'beginning2') {

                                    $grandtotalbegin2 += $row['beginning']; 

                    }  
                    else if ($row['stat'] == 'dueforimp2') {

                                    $grandtotaldueforimplement2 += $row['beginning']; 
                    } 

                    else if ($row['stat'] == 'nyd2') {

                                    $grandtotalnydue2 += $row['beginning']; 
                    }  

                    else if ($row['stat'] == 'tolimit2') {

                                    $grandtotaltolimit2 += $row['beginning']; 
                    }   

                    $grandtotalbegin2 = $grandtotalbegin + $grandtotaldueforimplement2 + $grandtotalnydue2 + $grandtotaltolimit2;

                    $grandtotalbeginfinal = $grandtotalbegin2;

                    $grandtotalending = $grandtotalbegin2 + $grandtotaldueforimplement + $grandtotalnydue + $grandtotaltolimit - $grandtotaldueforimplement2 - $grandtotalnydue2 - $grandtotaltolimit2;

                }

                $result[] = array();
                $result[] = array(array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbeginfinal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaldueforimplement2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnydue2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotaltolimit2, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );
            }


        }


        else if ($reporttype == 2 && $report_period == 2) {
                    $no = 1; $newproject = 0; $implemented = 0; $nydue = 0; $begin = 0; $ending = 0;
                    $grandtotalnewproject = 0; $grandtotalimplemented = 0; $grandtotalnydue = 0; $grandtotalwlimit = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtotalcount = 0;
                    foreach ($list as $row) {
                    $total = $row['total'];

                    $begin = $total;

                    $ending = $begin + $due_for_implement + $nydue;

                    $result[] = array(array("text" => $no, 'align' => 'left'), );


                    }

        }

        $template->setData($result);

        $template->setPagination();

        $engine->display();

    }

/*    public function generatereport2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company, $report_period) {

        #set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
        set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

        ini_set('memory_limit', -1);

        set_time_limit(0);

        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL);

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
            $company_name = "INQUIRER GROUP OF COMPANIES";
        } else if ($user_company == 11) {
            $company_name = "CONSULTANTS/CONTRACTUALS";
        } else if ($user_company == 12) {
            $company_name = "INQUIRER GROUP OF COMPANIES";
        } else {
            $company_name = "PRINTTOWN";
        }

        $statusname = "";
        if($status == 1) {
            $statusname = "DUE FOR IMPLEMENTATION";
        } else if($status == 2) {
            $statusname = "IMPLEMENTATION";
        } else if($status == 3) {
            $statusname = "WITH LIMITATIONS";
        } else if($status == 4) {
            $statusname = "NOT YET DUE";
        } else if($status == 5) {
            $statusname = "PENDING";
        } else if($status == 6) {
            $statusname = "REVISED DATE";
        } else if($status == 7) {
            $statusname = "SUPERSEDED";
        } else if($status == 8) {
            $statusname = "CANCEL";
        } else {
            $statusname = "ALL";
          }

        $reportname = "";
        if ($reporttype == 1 && $report_period == 2) {
        $reportname = "SUMMARY OF ACTION PLANS";
        $this->load->library('Crystal', null, 'Crystal');
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                    array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                    array('text' => 'Company', 'width' => .05, 'align' => 'left'),
                    array('text' => 'Department', 'width' => .25, 'align' => 'left'),
                    array('text' => 'Beginning', 'width' => .08, 'align' => 'right'),
                    array('text' => 'From New Projects', 'width' => .10, 'align' => 'right'),
                    array('text' => 'From NYD', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Implemented', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To W/Limit', 'width' => .10, 'align' => 'right'),
                    array('text' => 'To Cancelled', 'width' => .10, 'align' => 'right'),
                    array('text' => 'Ending', 'width' => .08, 'align' => 'right')
                    );
        }
        else if($reporttype == 2 && $report_period == 2) {
        $reportname = "SUMMARY OF ACTION PLANS DETAILED";
        $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER_LANDSCAPE);
        $fields = array(
                        array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                        array('text' => 'Company', 'width' => .05, 'align' => 'left'),
                        array('text' => 'Department', 'width' => .25, 'align' => 'left'),
                        array('text' => 'Beginning', 'width' => .08, 'align' => 'right'),
                        array('text' => 'From New Projects', 'width' => .10, 'align' => 'right'),
                        array('text' => 'From NYD', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To Implemented', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To W/Limit', 'width' => .10, 'align' => 'right'),
                        array('text' => 'To Cancelled', 'width' => .10, 'align' => 'right'),
                        array('text' => 'Ending', 'width' => .08, 'align' => 'right')
                        );

        }

        $template = $engine->getTemplate();
        $template->setText($company_name, 10);
        $template->setText('REPORT TYPE - '.$reportname, 10);
        $template->setText('STATUS - '.$statusname, 10);
        $template->setText('DATE FROM '.date("F d, Y", strtotime($datefrom)).' TO '.date("F d, Y", strtotime($dateto)), 10);

        $template->setFields($fields);

        $list = $this->entry_summary->getSummaryOfActionPlanReports2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company, $report_period);

        #print_r2($list) ; exit;

        $no = 1;
        if ($reporttype == 1 && $report_period == 2) {
            $newproject = 0; $implemented = 0; $nydue = 0; $wlimit = 0; $begin = 0; $ending = 0; $tocancelled = 0;
            $grandtotalnewproject = 0; $grandtotalimplemented = 0; $grandtotalnydue = 0; $grandtotalwlimit = 0; $grandtotalbegin = 0; $grandtotalending = 0; $grandtocancelled = 0; $grandtotalcount = 0;
                foreach ($list as $row) {
                  $total = $row['total'];
                  $newproject = $total;
                  $ending = $begin + $nydue;
                  $nydue = $row['prev_status'] == 4;
                  $implemented =$row['ap_status']== 2;
                  $tolimit = $row['ap_status'] == 3;
                  $tocancelled = $row['ap_status'] == 8;

                $result[] = array(array("text" => $no, 'align' => 'left'),
                            array("text" => $row['company_code'], 'align' => 'left'),
                            array("text" => $row['dept_name'], 'align' => 'left'),
                            array("text" => $begin, 'align' => 'right'),
                            array("text" => $newproject, 'align' => 'right'),
                            array("text" => $nydue, 'align' => 'right'),
                            array("text" => $implemented, 'align' => 'right'),
                            array("text" => $wlimit, 'align' => 'right'),
                            array("text" => $tocancelled, 'align' => 'right'),
                            array("text" => $ending, 'align' => 'right')
                           );

                           $no += 1;
                           $grandtotalbegin += $begin; $grandtotalending += $ending; $grandtotalnewproject += $newproject; $grandtocancelled += $tocancelled;
                           $grandtotalimplemented += $implemented; $grandtotalnydue += $nydue; $grandtotalwlimit += $wlimit;

                }

                $result[] = array(array('text' => ''),
                            array('text' => ''),
                            array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                            array('text' => number_format($grandtotalbegin, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnewproject, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalnydue, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalimplemented, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalwlimit, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtocancelled, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                            array('text' => number_format($grandtotalending, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                          );

        }

        $template->setData($result);

        $template->setPagination();

        $engine->display();

        }*/

 }
