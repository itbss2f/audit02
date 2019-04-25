
<?php 

class Authlib
{
    protected $_username = '';
    protected $_userpass = '';
    
    protected $_CI;
    protected $_model;
    
    public function __construct()
    {
        $this->_CI =& get_instance();
       
        //$this->_CI->load->model('model_auth/securities');
        
        $this->_CI->load->model("model_log_in/login_model","login");   
        
        //$this->_model =& $this->_CI->securities;
    }


}

