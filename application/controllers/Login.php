<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Login_Model','login');
        $this->load->model('Log_Model','log_event');
        date_default_timezone_set('Asia/Jakarta');
    }
    
	public function index()
	{
        if($this->session->userdata('username')!= null){
            redirect('dashboard');
        }
        $this->load->view('login_view');
    }
    
    public function auth(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cek = $this->login->login_val($username,$password);
        if($cek->num_rows() > 0){
            $data = $cek->row_array();
            $id = $data['id'];
            $username = $data['username'];
            $email = $data['email'];
            $role = $data['role'];
            $sessdata = array(
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'address' => $this->input->ip_address()
            );
            $this->session->set_userdata($sessdata);

            // if($role === 'adm'){
                $log = array(
                    'Message' =>  'user '.$this->session->userdata('username').' logged in from '.$this->session->userdata('address'),
                    'SysLogTag' => 'system,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log);
                redirect('dashboard');
            // }
        }else{
            $log = array(
                'Message' => 'login failure for user '.$this->session->userdata('username'),
                'SysLogTag' => 'system,error,simonet',
                'ReceivedAt' => date("Y-m-d H:i:s"),
                'DeviceReportedTime' => date("Y-m-d H:i:s"),
                'FromHost' => 'SIMONETapp'
            );
            $this->log_event->insertLogActivity($log);
            $this->session->set_flashdata('login', '<div class="alert alert-dismissable alert-danger">
            <i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong> Username atau Password Salah!! Silahkan coba lagi.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>');
            redirect('login');
        }
    }
    
    function logout(){
        $log = array(
            'Message' =>  'user '.$this->session->userdata('username').' logged out from '.$this->session->userdata('address'),
            'SysLogTag' => 'system,error,simonet',
            'ReceivedAt' => date("Y-m-d H:i:s"),
            'DeviceReportedTime' => date("Y-m-d H:i:s"),
            'FromHost' => 'SIMONETapp'
        );
        $this->log_event->insertLogActivity($log);
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        redirect(site_url('login'));
        
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
