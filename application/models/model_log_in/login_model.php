<?php
class Login_model extends CI_Model
{
        function __construct() {
            parent::__construct();

        }

        public function login() {

            $data['company_id'] = $this->session->userdata('sess_company_id');
            $data['user_id'] = $this->session->userdata('sess_user_id');
            $data['logs_status'] = 'LOGIN';
            $data['audittrail'] = 'LOGIN : '.''.$this->session->userdata('sess_fullname');

            $this->db->insert('ap_auditdblogs.login_history', $data);

        return true;

        }

        public function logout() {

            $data['company_id'] = $this->session->userdata('sess_company_id');
            $data['user_id'] = $this->session->userdata('sess_user_id');
            $data['logs_status'] = 'LOGOUT';
            $data['audittrail'] = 'LOGOUT:'.' '.$this->session->userdata('sess_fullname');

            $this->db->insert('ap_auditdblogs.login_history', $data);

        return true;

        }
    }
