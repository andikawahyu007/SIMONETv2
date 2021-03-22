<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interfaces extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')=== null){
            redirect('login');
        }
        $this->load->model('Devices_Model','devices');
    }
    
    public function index()
    {
        $this->load->view('interfaces_view');
    }

    function interfacesJSON(){
        // function untuk mengget semua data user hotspot dari database
        $api = $this->routerosapi;
        $user = $this->devices->getUserRouter(array('id' => '1111'));
        $api->port = $user['port'];
        $_read = array();
        if($api->connect("10.10.10.1",$user['username'],$user['password'])){
            $api->write('/interface/print');
            $data = $api->read();
            $api->disconnect();
            foreach($data as $r){
                if(isset($r['mac-address'])){
                    if($r['running']== 'true'){
                        $r['icon'] = '<span style="color: #39cc64"><i class="ti ti-link"></i></span>';
                    }else{
                        $r['icon'] = '<span style="color: #f03a3e"><i class="ti ti-unlink"></i></span>';
                    }
                    $r['tx-byte'] = byte_format($r['tx-byte']); 
                    $r['rx-byte'] = byte_format($r['rx-byte']); 
            
                    $_data[] = $r;
                }
            }
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $_data,
        );
        echo json_encode($output);
    }

    function getInterfaceChart(){
        $ip = '10.10.10.1';
        date_default_timezone_set('Asia/Jakarta');
        $interface = $this->input->post('iface');
        // $interface = 'E2-WAN-MyRepBPro100';
        $user = $this->devices->getUserRouter(array('id' => '1111'));
        try{
            $api = $this->routerosapi;
            $api->port=$user['port'];
            if($api->connect($ip,$user['username'],$user['password'])){
             	$api->write("/interface/monitor-traffic",false);
                $api->write("=interface=".$interface,false);  
                $api->write("=once=",true);
                $READ = $api->read(false);
                $ARRAY = $api->parseResponse($READ);
                if(count($ARRAY)>0){  
                    $rx = $ARRAY[0]["rx-bits-per-second"];
                    $tx = $ARRAY[0]["tx-bits-per-second"];
                    $rows['tx'][] = $tx;
                    $rows['rx'][] = $rx;
                    $rows['point'][] = date("h:i:s");
                }else{  
                    echo $ARRAY['!trap'][0]['message'];	 
                }
                $result = $rows;
                $api->disconnect();
                echo json_encode(array('data' => $result, 'interface' => $interface));
            }
        }catch(exeption $e){

        }
    }

}

/* End of file Interfaces.php */
