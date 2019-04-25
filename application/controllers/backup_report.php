<?php 

class Backup_report extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');         
        }
        $this->load->model(array('model_backup/backup_m', 'model_companies/companies', 'model_global/globalmodel'));
    }
    
    public function index() {
    
        $company = $this->session->userdata('sess_company_id');

        $navigation['data'] = $this->globalmodel->moduleList();
        $layout['navigation'] = $this->load->view('navigation', $navigation, true); 
        $layout['content'] = $this->load->view('reports/backup_v',null, true);
        $this->load->view('welcome_index', $layout);
        
    }
    
    public function generatereport($datefrom, $dateto, $user_company) {

    set_include_path(implode(PATH_SEPARATOR, array('D:/Programs/xampp/htdocs/zend/library')));   
    #set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '/var/www/zend/library')));

    ini_set('memory_limit', -1);
    
    set_time_limit(0);
    
    $this->load->library('Crystal', null, 'Crystal'); 
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LETTER);
    
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
    $reportname = "BACK-UP REPORT";
    $engine = $this->Crystal->create('Zend', Crystal_Template_Zend::SIZE_LEGAL_LANDSCAPE);  
    $fields = array(
                array('text' => '#', 'width' => .03, 'align' => 'left', 'bold' => true),
                array('text' => 'Company', 'width' => .20, 'align' => 'left'),
                array('text' => 'Name', 'width' => .20, 'align' => 'left'),
                array('text' => 'Back-up Date', 'width' => .10, 'align' => 'right')
                );    
    
    $template = $engine->getTemplate();                         
    $template->setText($company_name, 12);
    $template->setText('REPORT TYPE - '.$reportname, 12);
    $template->setText('DATE FROM '.date("F d, Y", strtotime($datefrom)).' TO '. date("F d, Y", strtotime($dateto)), 10); 
    
    $template->setFields($fields);
    
    $list = $this->backup_m->getBackupReport($datefrom, $dateto, $user_company); 
    
    $no = 1; 
    $grandtotalcount = 0;
                foreach($list as $row) {
                    $result[] = array(
                        array('text' => $no,  'align' => 'center'),
                        array('text' => $row['company_name'], 'align' => 'left'), 
                        array('text' => $row['Fullname'], 'align' => 'left'), 
                        array('text' => $row['backup_date'], 'align' => 'right') 
                    );
                    $no +=1;  $grandtotalcount += 1;
                               
                } 
                                               
                $result[] = array();
                $result[] = array(
                    array('text' => '', 'align' => 'left'),
                    array('text' => '', 'align' => 'left'),
                    array('text' => 'Total # of Back-up', 'align' => 'right', 'bold' => true, 'size' => 10), 
                    array('text' => number_format($grandtotalcount, 2, ".", ","), 'align' => 'right', 'style' => true, 'size' => 10)
                );
    
    $template->setData($result);

    $template->setPagination();

    $engine->display(); 
    
    }
    
    
}