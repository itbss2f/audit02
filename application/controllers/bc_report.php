<?php

class Bc_report extends CI_Controller {

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
        //$data['ap_status'] = $this->model_status->getDataStatus();
        $data['bc_status'] = $this->model_status->getDataStatusforBusinessView();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true);
        $layout['content'] = $this->load->view('reports/aging_of_businessconcern',$data, true);
        $this->load->view('welcome_index', $layout);
    }

    public function generatereport($datefrom_as, $reporttype, $bc_status, $dept, $project_name, $report_period, $user_company) {

    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);

    set_time_limit(0);

    $reportname = "";
    if ($reporttype == 1 || $reporttype == 2 || $reporttype == 3 || $reporttype == 4 ) {
            if ($reporttype == 1) {
                $reportname = "ALL";
            } else if ($reporttype == 2) {
                $reportname = "AGING BY DEPARTMENT";
            } else if ($reporttype == 3){
                $reportname = "AGING BY STATUS";
            } else {
                $reportname = "AGING BY COMPANY";
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

    if ($reporttype == 2) {
    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Business Concern', 'width' => .30, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'center'),
                array('text' => 'Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => '180Days', 'width' => .07, 'align' => 'right'),
                array('text' => '360Days', 'width' => .07, 'align' => 'right'),
                array('text' => '1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Over1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Total', 'width' => .05, 'align' => 'left')
                );
    } else {
    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Business Concern', 'width' => .30, 'align' => 'left'),
                array('text' => 'Status', 'width' => .10, 'align' => 'center'),
                array('text' => 'Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => '180Days', 'width' => .07, 'align' => 'right'),
                array('text' => '360Days', 'width' => .07, 'align' => 'right'),
                array('text' => '1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Over1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Total', 'width' => .05, 'align' => 'left')
                );

        }

    }

    $template = $engine->getTemplate();
    $template->setText($company_name, 12);
    $template->setText('BUSINESS CONCERN REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom_as)), 12);

    $template->setFields($fields);

    $list = $this->entry_report->getReportByStatusofbusinessconcern($datefrom_as, $reporttype, $status, $dept, $project_name, $user_company, $report_period);

    #print_r2($list); exit  ;

    $no = 1;
    if ($reporttype == 1 ) {
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
            foreach ($list as $row) {
                $datetoday = new DateTime($datefrom_as);
                $entered_date = new DateTime($row['entered_date']);
                $diff = date_diff($datetoday, $entered_date);
                $exemt = $row['implement'];

                if ($diff->days >= 0 && $diff->days <= 180 && $exemt != 0) {
                    $day180 =+1;
                    $total180 += $day180;
                } 
                else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360 && $exemt != 0) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080 && $exemt != 0) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['bc_code'].' - '.$row['business_concern'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    } else if ($reporttype == 2) {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $dept => $datarow) {
            $result[] = array(array('text' => $dept, 'align' => 'left', 'bold' => true, 'size' => 10));
            $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);
                    $exemt = $row['implement'];

                if ($diff->days >= 0 && $diff->days <= 180 && $exemt != 0) {
                    $day180 =+1;
                    $total180 += $day180;
                } 
                else {
                    $day180 = null;
                }
                if ($diff->days >= 181 && $diff->days <= 360 && $exemt != 0) {
                    $day360 =+1;
                    $total360 += $day360;
                } 
                else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080 && $exemt != 0) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } 
                else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['bc_code'].' - '.$row['business_concern'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    }else if ($reporttype == 3) {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $status => $datarow) {
            $result[] = array(array('text' => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));
            $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);
                    $exemt = $row['implement'];

                if ($diff->days >= 0 && $diff->days <= 180 && $exemt != 0) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360 && $exemt != 0) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080 && $exemt != 0) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['bc_code'].' - '.$row['business_concern'], 'align' => 'left'),
                        array("text" => $row['dept_name'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    } else {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $company_code => $datarow) {
            $result[] = array(array('text' => 'COMPANY'.' - '.$company_code, 'align' => 'left', 'bold' => true, 'size' => 10));
                    $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom_as);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);
                    $exemt = $row['implement'];

                if ($diff->days >= 0 && $diff->days <= 180 && $exemt != 0) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360 && $exemt != 0) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080 && $exemt != 0) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['bc_code'].' - '.$row['business_concern'], 'align' => 'left'),
                        array("text" => $row['status_name'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    }

    $template->setData($result);

    $template->setPagination();

    $engine->display();

    }

    public function generatereport2($datefrom, $dateto, $reporttype, $bc_status, $dept, $project_name, $user_company, $report_period) {

    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);

    set_time_limit(0);

    $reportname = "";
    if ($reporttype == 1 || $reporttype == 2 || $reporttype == 3 || $reporttype == 4 ) {
            if ($reporttype == 1) {
                $reportname = "ALL";
            } else if ($reporttype == 2) {
                $reportname = "AGING BY DEPARTMENT";
            } else if ($reporttype == 3){
                $reportname = "AGING BY STATUS";
            } else {
                $reportname = "AGING BY COMPANY";
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

    if ($reporttype == 2) {
    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .30, 'align' => 'left'),
                array('text' => 'Status', 'width' => .03, 'align' => 'center'),
                array('text' => 'Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => '180Days', 'width' => .07, 'align' => 'right'),
                array('text' => '360Days', 'width' => .07, 'align' => 'right'),
                array('text' => '1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Over1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Total', 'width' => .05, 'align' => 'left')
                );
    } else {
    $this->load->library('Crystal', null, 'Crystal');
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .30, 'align' => 'left'),
                array('text' => 'Status', 'width' => .10, 'align' => 'center'),
                array('text' => 'Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .06, 'align' => 'left'),
                array('text' => 'Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => '180Days', 'width' => .07, 'align' => 'right'),
                array('text' => '360Days', 'width' => .07, 'align' => 'right'),
                array('text' => '1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Over1080Days', 'width' => .08, 'align' => 'right'),
                array('text' => 'Total', 'width' => .05, 'align' => 'left')
                );
          }

    }

    $template = $engine->getTemplate();
    $template->setText($company_name, 12);
    $template->setText('BUSINESS CONCERN REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE FROM '.date("F d, Y", strtotime($datefrom)).' TO '.date("F d, Y", strtotime($dateto)), 12);

    $template->setFields($fields);

    $list = $this->entry_report->getReportByStatusofbusinessconcern2($datefrom, $dateto, $reporttype, $status, $dept, $project_name, $user_company, $report_period);

    #echo $user_company; exit;

    #print_r2($list); exit  ;

    $no = 1;
    if ($reporttype == 1 ) {
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
            foreach ($list as $row) {
                $datetoday = new DateTime($datefrom);
                $entered_date = new DateTime($row['entered_date']);
                $diff = date_diff($datetoday, $entered_date);

                if ($diff->days >= 0 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['dept_name'], 'align' => 'left'),
                        array("text" => $row['status_code'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    } else if ($reporttype == 2) {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $dept => $datarow) {
            $result[] = array(array('text' => $dept, 'align' => 'left', 'bold' => true, 'size' => 10));
            $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);

                if ($diff->days >= 0 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['dept_name'], 'align' => 'left'),
                        array("text" => $row['status_code'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    }else if ($reporttype == 3) {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $status => $datarow) {
            $result[] = array(array('text' => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));
            $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);

                if ($diff->days >= 0 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['dept_name'], 'align' => 'left'),
                        array("text" => $row['status_code'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    } else {
        $no = 1;
        $day180 = 0; $day360 = 0; $day1080 = 0; $day1081 = 0;
        $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0;
        $grandtotal180 = 0; $grandtotal360 = 0; $grandtotal1080 = 0; $grandtotal1081 = 0; $grandtotalcount = 0;
        foreach ($list as $company_code => $datarow) {
            $result[] = array(array('text' => 'COMPANY'.' - '.$company_code, 'align' => 'left', 'bold' => true, 'size' => 10));
                    $total180 = 0; $total360 = 0; $total1080 = 0; $total1081 = 0; $subtotal = 0;
                foreach ($datarow as $row) {
                    $datetoday = new DateTime($datefrom);
                    $entered_date = new DateTime($row['entered_date']);
                    $diff = date_diff($datetoday, $entered_date);

                if ($diff->days >= 0 && $diff->days <= 180) {
                    $day180 =+1;
                    $total180 += $day180;
                } else {
                    $day180 = null;
                }

                if ($diff->days >= 181 && $diff->days <= 360) {
                    $day360 =+1;
                    $total360 += $day360;
                } else {
                    $day360 = null;
                }

                if ($diff->days >= 361 && $diff->days <= 1080) {
                    $day1080 =+1;
                    $total1080 += $day1080;
                } else {
                    $day1080 = null;
                }

                if ($diff->days >= 1081 ) {
                        $day1081 =+1;
                        $total1081 += $day1081;
                    } else {
                        $day1081 = null;
                }

            $grandtotal180 += $day180; $grandtotal360 += $day360; $grandtotal1080 += $day1080; $grandtotal1081 += $day1081;

            $result[] = array(array("text" => $no, 'align' => 'left'),
                        array("text" => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array("text" => $row['dept_name'], 'align' => 'left'),
                        array("text" => $row['status_code'], 'align' => 'left'),
                        array("text" => $row['entered_date'], 'align' => 'left'),
                        array("text" => $row['due_date'], 'align' => 'left'),
                        array("text" => $row['date_implemented'], 'align' => 'left'),
                        array("text" => $day180, 'align' => 'right'),
                        array("text" => $day360, 'align' => 'right'),
                        array("text" => $day1080, 'align' => 'right'),
                        array("text" => $day1081, 'align' => 'right')
                       );

                       $no += 1; $subtotal += 1; $grandtotalcount += 1;
            }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Subtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($total180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($total1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($subtotal, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

            $result[] = array();

        }

            $result[] = array(array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => ''),
                        array('text' => 'Grandtotal', 'align' => 'right', 'bold' => true),
                        array('text' => number_format($grandtotal180, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal360, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1080, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotal1081, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true),
                        array('text' => number_format($grandtotalcount, 2, '.', ','), 'align' => 'right', 'bold' => true, 'style' => true)
                      );

    }



    $template->setData($result);

    $template->setPagination();

    $engine->display();

    }
}
