<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model(array('model_user/users','model_companies/companies','model_auth/securities','model_log_in/login_model'));
    }

    public function login(){
        $this->load->library('Authlib');

        $data['xcompany'] = $this->companies->getAllCompanies();
        $layout['login-content'] = $this->load->view('auth/login', $data, true);
        $this->load->view('auth/login', $layout);
    }

    public function validate() {

        $data['message'] = "";

        $user_id = $this->session->set_userdata('sess_user_id');
        $username = $this->input->post('username');
        $userpass = $this->input->post('userpass');
        $company_id = $this->input->post('company_id');

        $validateUsername = $this->users->validateUserName($username);

        if (!empty($validateUsername)) {

            /* If Valid
              Auth Username */

              $validateUsernamePassword = $this->users->validateUsernamePassword($username, $userpass, $validateUsername['salt']);

              #print_r($validateUsernamePassword);die();

              if (!empty($validateUsernamePassword)) {

                  /* If Valid Username and Password */

                  $validateCompany = $this->users->validateCompany($company_id);

                  if (!empty($validateCompany)) {

                    $validateExpirationdate = $this->users->validateExpirationdate($username, $userpass, $validateUsername['salt']);

                    #print_r($validateExpirationdate);die();
                    /*Checking of Expiration Date*/

                    if (!empty($validateExpirationdate))  {

                    $session_data = array(
                       'sess_emp_id'  => $validateUsernamePassword['employee_id'],
                       'sess_user_id' => $validateUsernamePassword['user_id'],
                       'sess_username' => $validateUsernamePassword['username'],
                       'sess_email'   => $validateUsernamePassword['email'],
                       'sess_fullname' => $validateUsernamePassword['fullname'],
                       'sess_firstname' => $validateUsernamePassword['firstname'],
                       'sess_company_id' => $validateCompany['company_id'],
                       'sess_company_name'=> $validateCompany['company_name'],
                       'logged_in' => TRUE
                   );

                   $session = $this->session->set_userdata($session_data);

                    #print_r($session);die();

                   if ($this->session->userdata('logged_in')) {
                       $this->login_model->login($user_id);
                       redirect('entry');
                   }  else {
                       redirect('auth/logout');
                   }

                   } else   {
                        $this->session->set_flashdata('error_login', 'Your Password already expired');
                        redirect('auth/login');
                    }

                  } else {
                      $this->session->set_flashdata('error_login', 'You have no access to the company');
                      redirect('auth/login');
                  }

              } else {
                  $this->session->set_flashdata('error_login', 'Invalid Password');
                  redirect('auth/login');
              }

        } else {
            $this->session->set_flashdata('error_login', 'Invalid Username');
            redirect('auth/login');
        }

    }

    public function logout(){
        $this->load->library('Authlib');

        $this->session->sess_destroy();
        $this->login_model->logout();
        redirect('auth/login');
    }

    public function ajaxCompany() {
        $username = $this->input->post('username');
        $company_id = $this->securities->getCompanyForThisUsername($username);
        $response['company_id'] = $company_id;
        echo json_encode($response);

    }

}

/* End of file login.php */
/* Name: Paul */
