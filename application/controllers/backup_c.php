<?php 

class Backup_c extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        $this->load->model(array('model_backup/backup_m', 'model_companies/companies', 'model_global/globalmodel'));
    }
    
    public function index() {
    
        $user_company = $this->session->userdata('sess_company_id');

        $data = $this->backup_m->getActionPlanHistory($user_company);

        //print_r2($data) ; exit;

        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true); 
        $layout['content'] = $this->load->view('security/backup',$data, true);
        $this->load->view('welcome_index', $layout);
        
    }
    
    public function backupexecute($datefrom, $dateto, $user_company, $user_id) {

        if (!empty($datefrom))  { 

        $this->backup_m->excutebackup($datefrom, $dateto,$user_company, $user_id); 

        //$msg = "You successfully backup";

        //$this->session->set_flashdata('msg', $msg);

        } else {
            //
        }
           
    }
    
    public function generatereport($datefrom, $dateto, $user_company) {

    #set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));   
    set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

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
    $reportname = "BACK-UP ACTION PLANS";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);  
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Action Plan', 'width' => .10, 'align' => 'left'),
                array('text' => 'Status', 'width' => .04, 'align' => 'left'),  
                array('text' => 'Department', 'width' => .11, 'align' => 'left'),
                array('text' => 'Issue', 'width' => .08, 'align' => 'left'),
                array('text' => 'Project Name', 'width' => .10, 'align' => 'left'), 
                array('text' => 'Entered Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Due Date', 'width' => .05, 'align' => 'left'),
                array('text' => 'Person', 'width' => .09, 'align' => 'center'),
                array('text' => 'Remarks', 'width' => .10, 'align' => 'left'),    
                array('text' => 'Audit Staff', 'width' => .07, 'align' => 'left'),
                array('text' => 'Backup by', 'width' => .07, 'align' => 'left'),
                array('text' => 'Backup Date', 'width' => .07, 'align' => 'left'),
                );    
    
    $template = $engine->getTemplate();                         
    $template->setText($company_name, 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE FROM '.date("F d, Y", strtotime($datefrom)).' TO '. date("F d, Y", strtotime($dateto)), 10); 
    
    $template->setFields($fields);
    
    $list = $this->backup_m->getActionPlantobebackup($datefrom, $dateto,$user_company);  
    #print_r2($list) ; exit;
    
    $no = 1; 
    $grandtotalcount = 0;
                foreach($list as $row) {
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['code'].' - '.$row['action_plan'], 'align' => 'left'),
                        array('text' => $row['status_code'], 'align' => 'left'), 
                        array('text' => $row['dept_name'], 'align' => 'left'),
                        array('text' => $row['issue_name'], 'align' => 'left'),
                        array('text' => $row['project_name'], 'align' => 'left'),
                        array('text' => $row['entered_date'], 'align' => 'left'),
                        array('text' => $row['due_date'], 'align' => 'left'),
                        array('text' => $row['person'], 'align' => 'left'),
                        array('text' => $row['remarks'], 'align' => 'left'), 
                        array('text' => $row['audit_staff'], 'align' => 'left'),
                        array('text' => $row['trans_by'], 'align' => 'left'),
                        array('text' => $row['backup_date'], 'align' => 'left')
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
    
    $template->setData($result);

    $template->setPagination();

    $engine->display(); 
    
    }
    
    
}