<?php

class Searching extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/logout');
        }
        $this->load->model(array('model_global/globalmodel', 'model_issue/model_issues', 'model_department/departments', 'model_risk_rating/risk_ratings', 'model_entry/entry_report', 'model_entry/model_entry'));
        $this->load->model(array('model_project/model_projects', 'model_user/users', 'model_status/model_status', 'model_employee/model_employees', 'model_companies/companies', 'model_risk/model_risks'));
    }


    public function search_excel_action() {

    $company = $this->session->userdata('sess_company_id');

    $lookup_code = $this->input->get("lookup_code");
    $lookup_action_plan = $this->input->get("lookup_action_plan");
    $lookup_assigned_audit = $this->input->get("lookup_assigned_audit");
    $lookup_project_id = $this->input->get("lookup_project_id");
    $lookup_dept = $this->input->get("lookup_dept");
    $lookup_person = $this->input->get("lookup_person");

    //print_r2($lookup_code); exit;

    $list['list'] = $this->model_entry->searchedexcell($lookup_code,$lookup_action_plan, $lookup_assigned_audit, $lookup_project_id, $lookup_dept, $lookup_person, $company);

    #print_r2($data['data']); exit;

    $company_name = "";
    if ($company == 1) {
        $company_name = "PHILIPPINE DAILY INQUIRER";
    } else if ($company == 2) {
        $company_name = "INQUIRER CATALYST MEDIA INC.";
    } else if ($company == 3) {
        $company_name = "HINGE INQUIRER PUBLICATION";
    } else if ($company == 4) {
        $company_name = "IPI MAKATI";
    } else if ($company == 5) {
        $company_name = "RADYO INQUIRER";
    } else if ($company == 6) {
        $company_name = "INQUIRER.NET";
    } else if ($company == 7) {
        $company_name = "DELIVERY ACCESS GROUP";
    } else if ($company == 8) {
        $company_name = "MEGAMOBILE INC.";
    } else if ($company == 9) {
        $company_name = "CEBU DAILY NEWS";
    } else if ($company == 10) {
        $company_name = "INQUIRER HOLDINGS INC";
    } else if ($company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($company == 13){
        $company_name = "PRINTTOWN";
    }


    $reportname = "ACTION PLAN";
     

    $list['company_name'] = $company_name;
    $list['lookup_code'] = $lookup_code;
    $list['reportname'] = $reportname;
    $list['reporttype'] = $reporttype;
    $html = $this->load->view('reports/excell/searched_action', $list, true);
    $filename ="REPORT_TYPE_".$reportname.".xls";
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename='.$filename);
    echo $html ;
    exit();


    }

public function search_excel_bc() {

    $company = $this->session->userdata('sess_company_id');

    $lookup_code = $this->input->get("lookup_code");
    $lookup_bc = $this->input->get("lookup_bc");
    $lookup_assigned_audit = $this->input->get("lookup_assigned_audit");
    $lookup_project_id = $this->input->get("lookup_project_id");
    $lookup_dept = $this->input->get("lookup_dept");
    $lookup_person = $this->input->get("lookup_person");

    //print_r2($lookup_code); exit;

    $list['list'] = $this->model_entry->searchedexcellbc($lookup_code,$lookup_bc, $lookup_assigned_audit, $lookup_project_id, $lookup_dept, $lookup_person, $company);

    $company_name = "";
    if ($company == 1) {
        $company_name = "PHILIPPINE DAILY INQUIRER";
    } else if ($company == 2) {
        $company_name = "INQUIRER CATALYST MEDIA INC.";
    } else if ($company == 3) {
        $company_name = "HINGE INQUIRER PUBLICATION";
    } else if ($company == 4) {
        $company_name = "IPI MAKATI";
    } else if ($company == 5) {
        $company_name = "RADYO INQUIRER";
    } else if ($company == 6) {
        $company_name = "INQUIRER.NET";
    } else if ($company == 7) {
        $company_name = "DELIVERY ACCESS GROUP";
    } else if ($company == 8) {
        $company_name = "MEGAMOBILE INC.";
    } else if ($company == 9) {
        $company_name = "CEBU DAILY NEWS";
    } else if ($company == 10) {
        $company_name = "INQUIRER HOLDINGS INC";
    } else if ($company == 11) {
        $company_name = "CONSULTANTS/CONTRACTUALS";
    } else if ($company == 12) {
        $company_name = "INQUIRER GROUP OF COMPANIES";
    } else if ($company == 13){
        $company_name = "PRINTTOWN";
    }

    $reportname = "BUSINESS CONCERN";
     

    $list['company_name'] = $company_name;
    $list['lookup_code'] = $lookup_code;
    $list['reportname'] = $reportname;
    $list['reporttype'] = $reporttype;
    $html = $this->load->view('reports/excell/searched_bc', $list, true);
    $filename ="REPORT_TYPE_".$reportname.".xls";
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename='.$filename);
    echo $html ;
    exit();






    }
}
