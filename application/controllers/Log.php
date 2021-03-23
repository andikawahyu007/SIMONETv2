<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')== null){
            redirect(site_url('login'),'refresh');
        }
        $this->load->model('Log_Model', 'log_event');
    }
    
    public function index(){
        $this->load->view('log_view');
    }

    function logEventJSON(){
        // function untuk mengget semua data user hotspot dari database
        $data = $this->log_event->getLog();
        $eventLog = array();
        foreach($data as $log){
            if($log['SysLogTag'] == 'devices,device-up,simonet' || $log['SysLogTag'] == 'devices,device-down,simonet' || $log['SysLogTag'] == 'devices,simonet'){
                $log['Message'] = '<i class="ti ti-harddrive"></i> '.$log['Message'];
            }else if($log['SysLogTag'] == 'system,simonet'){
                $log['Message'] = '<i class="ti ti-user"></i> '.$log['Message'];
            }
            $eventLog[] = $log;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $eventLog,
        );
        echo json_encode($output);
    }

}

/* End of file Log.php */
