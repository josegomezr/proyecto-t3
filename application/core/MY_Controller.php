<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
*
*/
/**
*
*/
class MY_Controller extends CI_Controller
{
   
    function __construct() {
        ini_set('display_errors', '1');
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->lang->load('gps');
        $this->load->helper('form');
        $this->load->helper('language');
    }
    function flash_validation_error($error_str) {
        $this->session->set_flashdata('error', $error_str);
        $this->session->set_flashdata('form:fields', $_POST);
        $this->session->set_flashdata('form:errors', $errors = $this->form_validation->error_array());
    }

    function flash($key, $val) {
        $this->session->set_flashdata($key, $val);
    }

    function _remap($method, $args) {
        $method = strtolower($_SERVER['REQUEST_METHOD']) . "_$method";
        return call_user_func_array(array($this, $method), $args);
    }
}

class Front_Controller extends MY_Controller
{
}

class Admin_Controller extends MY_Controller
{
    
    function __construct() {
    
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            redirect('home/index');
        }

        $this->data = array();
        $this->auth = (object) $this->session->all_userdata();
        $this->data['auth'] = $this->auth;
        $this->data['_controller'] = $this->uri->segment(2);
        $this->data['_method'] = $this->uri->segment(3);

    }
}
