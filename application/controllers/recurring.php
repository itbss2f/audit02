<?php 

class Recurring extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/model_entry', 'model_risk/model_risks'));                  
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_recurring/mod_recurring'));                                  
    }
    
    public function index() {
        
        $company = $this->session->userdata('sess_company_id'); 
        $user_id = $this->session->userdata('sess_user_id');
        $navigation['data'] = $this->globalmodel->moduleList();
        
        $data['ap_issue'] = $this->model_issues->getIssues();  
        $data['ap_risk_rating'] = $this->risk_ratings->getRates(); 
        $data['emp'] = $this->model_employees->getAllEmployees($company);
        $data['dept'] = $this->departments->getAllDepartment($company);
        $data['ap_risk'] = $this->model_risks->getRisk();  
        $data['ap_project'] = $this->model_projects->getProjects($company); 
        $data['ap_users'] = $this->users->getAuditStaff(); 
        $data['ap_status'] = $this->model_status->getDataStatus();

        $data['total'] = $this->model_entry->getTotalActionPlan($company, $user_id);
        $data['xtotal'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['approval'] = $this->model_entry->getTotalForApprovalOfActionPlan($company, $user_id);
        $data['total_approval'] = $this->model_entry->getTotalForApproval($company, $user_id);

        $layout['navigation'] = $this->load->view('navigation', $navigation, true);  
        $layout['content'] = $this->load->view('v_recurring/index', $data, true);
        $this->load->view('welcome_index', $layout); 
    }
    
    public function generatereport($datefrom, $reporttype, $status, $dept, $project_name, $recur, $user_companyx) {
    
    #set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));   
    set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);
    
    set_time_limit(0);
    
    $this->load->library('Crystal', null, 'Crystal'); 
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);
    
    $reportname = ""; 
    if ($reporttype == 1 || $reporttype == 2 || $reporttype == 3) {
        if ($reporttype == 1){
            $reportname = "ALL";   
        } elseif ($reporttype == 2){
            $reportname = "RECURRING BY DEPARTMENT";    
        } else {
            $reportname = "RECURRING BY PROJECT";
        }
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);  
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .15, 'align' => 'left'),
                array('text' => 'Project', 'width' => .13, 'align' => 'left'),
                array('text' => 'Department', 'width' => .05, 'align' => 'left'),
                array('text' => 'Risk Assessment', 'width' => .12, 'align' => 'left'),
                array('text' => 'Impact', 'width' => .07, 'align' => 'left'), 
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Revised Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Date Implemented', 'width' => .07, 'align' => 'left'),
                array('text' => 'Person', 'width' => .08, 'align' => 'center', 'bold' => true),
                array('text' => 'Audit', 'width' => .08, 'align' => 'left'),    
                array('text' => 'Remarks', 'width' => .10, 'align' => 'left')
                );
        }
        
    $template = $engine->getTemplate();                         
    $template->setText('PHILIPPINE DAILY INQUIRER, INC.', 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE AS OF '.date("F d, Y", strtotime($datefrom)), 12);
    
    $template->setFields($fields);

    $listx = $this->mod_recurring->getRecurringOfActionPlans($datefrom, $reporttype, $status, $dept, $project_name, $recur, $user_companyx);    
    
    #print_r2($listx); exit; 
    
    $no = 1;
    if ($reporttype == 1) {
        $subtotal = 0; $totalcount = 0;
            foreach ($listx as $status  => $datax) {   
                $result[] = array(array('text' => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0;
                foreach($datax as $row) {
                    $subtotal += 1;
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['dept_code'], 'align' => 'left'),
                        array('text' => $row['risk_name1'].' - '.$row['rating_code'], 'align' => 'left'),
                        array('text' => number_format($row['impact_value'], 2, ".", ","), 'align' => 'left'),
                        array('text' => $row['due_date'], 'align' => 'left'),
                        array('text' => $row['date_revised'], 'align' => 'left'),
                        array('text' => $row['date_implemented'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),      
                        array('text' => $row['audit_staff'], 'align' => 'left'),
                        array('text' => $row['remarks'], 'align' => 'left')
                    );
                    $no +=1;  $totalcount += 1;
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
                    array('text' => 'Total # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 12), 
                    array('text' => number_format($totalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 12)
                ); 
       }
       else if ($reporttype == 2) {
        $no = 1;   
        $subtotal = 0; $totalcount = 0; $grandtotal = 0; 
            foreach ($listx as $dept_name  => $datax) {   
                $result[] = array(array('text' => $dept_name, 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0; $totalcount = 0;
                foreach ($datax as $status => $datarow) {
                $result[] = array(array("text" => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));  
                $subtotal = 0;
                foreach($datarow as $row) {
                    $subtotal += 1;
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['dept_code'], 'align' => 'left'),
                        array('text' => $row['risk_name1'].' - '.$row['rating_code'], 'align' => 'left'),
                        array('text' => number_format($row['impact_value'], 2, ".", ","), 'align' => 'left'),
                        array('text' => $row['due_date'], 'align' => 'left'),
                        array('text' => $row['date_revised'], 'align' => 'left'),
                        array('text' => $row['date_implemented'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),      
                        array('text' => $row['audit_staff'], 'align' => 'left'),
                        array('text' => $row['remarks'], 'align' => 'left')
                    );
                    $no +=1;  $totalcount += 1; $grandtotal += 1;         
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
                    array('text' => number_format($totalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
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
                    array('text' => 'Grandtotal # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 12), 
                    array('text' => number_format($grandtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 12)
                );
           
       } else {
        $no = 1;   
        $subtotal = 0; $totalcount = 0; $grandtotal = 0;
            foreach ($listx as $project_name  => $datax) {   
                $result[] = array(array('text' => 'PROJECT NAME'.' - '.strtoupper($project_name), 'align' => 'left', 'bold' => true, 'size' => 10));
                $subtotal = 0; $totalcount = 0; 
                foreach ($datax as $status => $datarow) {
                $result[] = array(array("text" => 'STATUS'.' - '.$status, 'align' => 'left', 'bold' => true, 'size' => 10));  
                $subtotal = 0; 
                foreach($datarow as $row) {
                    $subtotal += 1;
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['dept_code'], 'align' => 'left'),
                        array('text' => $row['risk_name1'].' - '.$row['rating_code'], 'align' => 'left'),
                        array('text' => number_format($row['impact_value'], 2, ".", ","), 'align' => 'left'),
                        array('text' => $row['due_date'], 'align' => 'left'),
                        array('text' => $row['date_revised'], 'align' => 'left'),
                        array('text' => $row['date_implemented'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),      
                        array('text' => $row['audit_staff'], 'align' => 'left'),
                        array('text' => $row['remarks'], 'align' => 'left')
                    );
                    $no +=1;  $totalcount += 1; $grandtotal += 1;        
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
                    array('text' => number_format($totalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
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
                    array('text' => 'Grandtotal # of Action Plans', 'align' => 'right', 'bold' => true, 'size' => 12), 
                    array('text' => number_format($grandtotal, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 12)
                );    
       }

    $template->setData($result);

    $template->setPagination();

    $engine->display();
    
    }
    
        
}    