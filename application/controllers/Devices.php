<?php

defined('BASEPATH') OR exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'third_party/phpseclib');
include(APPPATH . '/third_party/phpseclib/Net/SSH2.php');

require_once('application/libraries/Client.php');
require_once('application/libraries/ZukoLibs.php');
class Devices extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')=== null){
            redirect('login');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Devices_Model','devices');
        $this->load->model('Mikrotik_Model','Mikrotik');
        $this->load->model('Log_Model', 'log_event');   
    }
    

    public function index()
    {
        //$data['discovery'] = $this->discoveryDevices();
        //$data['unifiDevices'] = $this->getUnifiDevices();
        $data['location'] = $this->getLocation();
        $this->load->view('devices_view',$data);
        
    }

    public function detailDevice()
    {
        // function untuk menampilkan halaman detail user hotspot 
        $serial = $this->input->post('serial');
        $data = $this->devices->getdevice(array('serial_number'=> $serial));
        $data['location'] = $this->getLocation();
        $data['list_devices'] = $this->devices->getdevices();
        $data['last_ros'] = $this->devices->getLastesROS();
        $data['subdevices'] = $this->devices->getdevicesby(array('id_device' => $serial));
        if($data['status'] == 'Connected' && $data['platform']=="MikroTik"){
            $this->syncIdentitiesMikroTik($data['address'],$serial);
        }elseif($data['platform'] == "UniFi"){
            $this->syncIdentitiesUniFi($serial);
        }
        // echo "<pre>";
        // print_r($data['list_devices']);
        $this->load->view('device_detail_view',$data);
        
    }

    function getDevicesByPlatform(){
        $data = $this->devices->getdevicesby(array('platform' => 'MikroTik'));
        foreach($data as $device){
            $r['id'] = $device['id'];
            $r['text'] = $device['identity'];
            $devices[] = $r;
        }
        echo json_encode($devices);

    }

    function devicesJSON(){
        // funtion untuk mengget semua data user profile dari database
        $data = $this->devices->getdevices();
        $_data = array();
            foreach($data as $r){
                if($r['id'] != '1'){
                    $r['address'] = '<span style="color: #03a9f4">'.$r['address'].'</span>';
                    if (($r['status'] == 'Connected' || $r['status'] == 'Unstable') && $r['uptime']==null && $r['platform']=='UniFi') {
                        $r['status'] = '<span class="badge" style="color: #f03a3e; background-color: transparent; border: 1px solid">Disconnected</span>';
                    }elseif($r['status'] == 'Connected'){
                        $r['status'] = '<span class="badge" style="color: #39cc64; background-color: transparent; border: 1px solid">Connected</span>';
                    }elseif ($r['status'] == 'Disconnected') {
                        $r['status'] = '<span class="badge" style="color: #f03a3e; background-color: transparent; border: 1px solid">Disconnected</span>';
                    }elseif ($r['status'] == 'Reboot') {
                        $r['status'] = '<span class="badge" style="color: #ffdb1a; background-color: transparent; border: 1px solid">Reboot </span>';
                    }elseif ($r['status'] == 'Unstable') {
                        $r['status'] = '<span class="badge" style="color: #ffdb1a; background-color: transparent; border: 1px solid">Unstable </span>';
                    }
                    
                    if($r['platform'] == "UniFi"){
                        $r['img'] = '<img src="'.base_url('assets/img/unifi.ico').'" style="width: 30px">';
                    }elseif($r['platform'] == "UniFi Switch"){
                        $r['img'] = '<img src="'.base_url('assets/img/UnifiSwitch.ico').'" style="width: 30px">';
                    }elseif($r['platform'] == "MikroTik" || $r['platform'] == "MikroTik Switch"){
                        $r['img'] = '<img src="'.base_url('assets/img/rb.ico').'" style="width: 30px">';
                    }else{
                        $r['img'] = null;
                    }
                    $_data[] = $r;
                }
            }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $_data,
        );
        echo json_encode($output);
    }

    function addDevice(){
        $data = array(
            'serial_number' => $this->input->post('serial'),
            'address' => $this->input->post('address4'),
            'platform' => $this->input->post('platform'),
            'id_location' => $this->input->post('location')
        );
        $this->devices->addDevice($data);
        $log = array(
            'Message' => ' New Device '.$data['identity'].' added by '.$this->session->userdata('username'),
            'SysLogTag' => 'system,simonet',
            'ReceivedAt' => date("Y-m-d H:i:s"),
            'DeviceReportedTime' => date("Y-m-d H:i:s"),
            'FromHost' => 'SIMONETapp'
        );
        $this->log_event->insertLogActivity($log);
        echo json_encode(array("status" => TRUE));
    }

    function addDeviceByDiscovery(){
        if($this->input->post('platform') == "UniFi" || $this->input->post('platform') == "UniFi Switch"){
            $data = array(
                'address' => $this->input->post('address'),
                'mac_address' => $this->input->post('mac_address'),
                'serial_number' => $this->input->post('serial'),
                'identity' => $this->input->post('identity'),
                'version' => $this->input->post('version'),
                'uptime' => $this->input->post('uptime'),
                'model' => $this->input->post('model'),
                'platform' => $this->input->post('platform'),
                'status' => $this->input->post('status')
            );
        }else{
            $data = array(
                'address' => $this->input->post('address'),
                'mac_address' => $this->input->post('mac_address'),
                'serial_number' => strtoupper($this->random_strings(3)),
                'identity' => $this->input->post('identity'),
                'version' => $this->input->post('version'),
                'uptime' => $this->input->post('uptime'),
                'model' => $this->input->post('board'),
                'platform' => $this->input->post('platform'),
                'status' => $this->input->post('status')
            );
        }
        $log = array(
            'Message' => ' New Device '.$data['identity'].' added by '.$this->session->userdata('username'),
            'SysLogTag' => 'system,simonet',
            'ReceivedAt' => date("Y-m-d H:i:s"),
            'DeviceReportedTime' => date("Y-m-d H:i:s"),
            'FromHost' => 'SIMONETapp'
        );
        $this->log_event->insertLogActivity($log);
        $this->devices->addDevice($data);
        echo json_encode(array("status" => TRUE, "data" => $data));
    }

    function discoveryDevices(){
        $user = $this->devices->getUserRouter(array('id' => '1111'));
        try{
            $api = $this->routerosapi;
            $api->port=$user['port'];
            if($api->connect('10.10.10.1',$user['username'],$user['password'])){
                $api->write('/ip/neighbor/print');
                $read = $api->read();
                $api->disconnect();
                $ip = $this->devices->getIPDevices();
                foreach($read as $r){
                    if(isset($r['address']) && ($r['platform']=='MikroTik')){
                        if(!in_array($r['address'], $ip)){
                            $r['id'] = $r['.id'];
                            $version = explode('.',$r['version']);
                            if($version[0] == '1'){
                                $r['platform'] = "MikroTik Switch";
                            }
                            $r['aksi'] = "<a href='javascript:;' data-aksi='discovery' data-identity='".$r['identity']."' data-uptime='".$r['uptime']."' data-board='".$r['board']."' data-version='".$r['version']."' data-address='".$r['address']."' data-mac_address='".$r['mac-address']."' data-platform='".$r['platform']."' data-status='Connected'><i class='fa fa-plus'></i></a>";
                            $_data[] = $r;
                        }
                    } 
                }    
                // return $_data;
                
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "data" => $_data,
                    );
                echo json_encode($output);            
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function setDevice(){
        // function untuk merubah data user hotspot dan menyimpannya ke mikrotik
        $device = $this->devices->getDevice(array('id' => $this->input->post('id')));
        if($device['platform'] == 'MikroTik'){
            $user = $this->devices->getUserRouter(array('id' => '2222'));
            $data = array(
                'id' => $this->input->post('id'),
                'identity' => $this->input->post('identity'),
                'serial_number' => $this->input->post('serial'),
                'address' => $this->input->post('address'),
                'id_device' => $this->input->post('masterdevice'),
                'id_location' => $this->input->post('location')  
            );
            if($device['status'] == 'Connected' && ($data['identity'] != $device['identity'])){
                try{
                    $api = $this->routerosapi;
                    $api->port = 8728;
                    if($api->connect($data['address'],$user['username'],$user['password'])){
                        $api->write('/system/identity/set',false);
                        $api->write('=name='.$data['identity']);
                        $write = $api->read();
                        $api->disconnect();
                        $this->session->set_flashdata('detail_device', '<div class="alert alert-dismissable alert-success">
                            <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Data Device '.$device['identity'].' Berhasil Dirubah
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </div>');
                        $log = array(
                            'Message' =>  'Device '.$data['identity'].' changed by '.$this->session->userdata('username'),
                            'SysLogTag' => 'system,simonet',
                            'ReceivedAt' => date("Y-m-d H:i:s"),
                            'DeviceReportedTime' => date("Y-m-d H:i:s"),
                            'FromHost' => 'SIMONETapp'
                        );
                        $this->log_event->insertLogActivity($log);
                        $this->devices->setDevice($data);
                        echo json_encode(array("status" => TRUE, "msg" => 'identity, another data has been changed'));
                    }else{
                        echo json_encode(array("status" => FALSE, "error" => 'connect to this device'));
                    }    
                }catch(exeption $e){
                    echo json_encode(array("status" => FALSE, "error" => $e));
                }
            }else{
                $data = array(
                    'id' => $this->input->post('id'),
                    'serial_number' => $this->input->post('serial'),
                    'address' => $this->input->post('address'),
                    'id_device' => $this->input->post('masterdevice'),
                    'id_location' => $this->input->post('location')  
                );
                $log = array(
                    'Message' =>  'Device '.$device['identity'].' changed by '.$this->session->userdata('username'),
                    'SysLogTag' => 'system,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log);
                $this->devices->setDevice($data);
                $this->session->set_flashdata('devices', '<div class="alert alert-dismissable alert-success">
                    <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Data Device '.$device['identity'].' Berhasil Dirubah
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>');
                if($device['serial_number'] != $this->input->post('serial')){
                    echo json_encode(array("status" => TRUE, "serialChange" => true));
                }else{
                    echo json_encode(array("status" => TRUE, "serialChange" => false));
                }
                
            }
        }else{
            $data = array(
                'id' => $this->input->post('id'),
                'serial_number' => $this->input->post('serial'),
                'address' => $this->input->post('address'),
                'id_device' => $this->input->post('masterdevice'),
                'id_location' => $this->input->post('location')  
            );
            $log = array(
                'Message' =>  'Device '.$device['identity'].' changed by '.$this->session->userdata('username'),
                'SysLogTag' => 'system,simonet',
                'ReceivedAt' => date("Y-m-d H:i:s"),
                'DeviceReportedTime' => date("Y-m-d H:i:s"),
                'FromHost' => 'SIMONETapp'
            );
            $this->log_event->insertLogActivity($log);
            $this->devices->setDevice($data);
            $this->session->set_flashdata('detail_device', '<div class="alert alert-dismissable alert-success">
                <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Data Device '.$device['identity'].' Berhasil Dirubah
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>');
        
            echo json_encode(array("status" => TRUE));
        }
    }

    function syncIdentitiesMikroTik($ip,$serial){
        // funtion untuk mensyncronise data dari mikrotik ke database
        // $data = $this->devices->getdevices();
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/system/resource/print');
                $read = $api->read();
                $api->write('/system/routerboard/print');
                $board = $api->read();
                $api->disconnect();
                $_array = array_merge_recursive($read[0],$board[0]);
                $identity['identity'] = $this->getIdentity($ip);
                $identity['serial'] = $serial;
                if($identity['identity']!='error'){
                    $this->devices->syncdatadevice($identity,$_array);
                }
                // echo "<pre>";
                // print_r($_array);
                // echo json_encode(array("status" => TRUE));
            }else{
                // echo json_encode(array("status" => FALSE, "msg" => 'Gagal terhubung ke Router'.$device['address']));
            }
        }catch(Exeption $error){
            // echo json_encode(array("status" => FALSE, "msg" => $error));
        }
    }

    function cekDevice(){
        // funtion untuk menyimpan data user hotspot ke mikrotik
        $data = $this->devices->getdevices();
        try{
            $connect = 0; $disconnect =0;
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect("10.10.10.1",$user['username'],$user['password'])){
                $api->write('/ping',false);
                $api->write('=address=192.168.10.7',false);
                $api->write('=count=5',false);
                $api->write('=interval=0.3');
                $read = $api->read();
                $api->disconnect();
                foreach($read as $result){
                    if($result['packet-loss']>=1 || isset($result['status'])){
                        $disconnect++;
                    }else if($result['packet-loss']==0){
                        $connect++;
                    }
                }
                echo "<pre>";
                echo "Connect =".$connect." disconnect =".$disconnect;
                print_r($read);
            }else{
                echo "jancok";
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function cekOSUpdate(){
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect('10.10.10.32',$user['username'],$user['password'])){
                $comm = $api->comm('/system/package/update/');
                // $read = $api->read();
                // $api->disconnect();
                // return $read[0]['name'];
                print_r($comm);
            }
        }catch(Exeption $error){
            // return 'error';
        }
    }

    function getIdentity($ip){
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/system/identity/print');
                $read = $api->read();
                $api->disconnect();
                return $read[0]['name'];
            }
        }catch(Exeption $error){
            return 'error';
        }
    }

    function getInterfacesJSON($serial){
        // $id = $this->input->post('id');
        // function untuk mengget semua data user hotspot dari database
        $data = $this->devices->getinterfaces(array('serial_number' => $serial));
        $_data = array();
        foreach($data as $r){
            $r['tx_byte'] = byte_format($r['tx_byte']); 
            $r['rx_byte'] = byte_format($r['rx_byte']); 
            // $r['aksi'] = "<a href='javascript:;' data-aksi='hapus' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
            $_data[] = $r;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $_data,
        );
        echo json_encode($output);
    }

    function getInterfacesAPI(){
        $ip = $this->input->post('ip');
        $serial = $this->input->post('serial');
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/interface/print');
                $read = $api->read();
                $api->disconnect();
                $mac=array();
                $same = 0;
                foreach($read as $result){
                    if(in_array($result['mac-address'], $mac)){
                        $same++;
                        $result['mac-address'] = $result['mac-address'].':0'.$same;
                    
                    }else{
                        $mac[] = $result['mac-address'];
                    }
                    $_read[]=$result;
                }
                $this->devices->syncinterfaces($_read,$serial);
                echo json_encode(array("status" => TRUE, "data" => $_read));
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function getIP(){
        $serial = $this->input->post('serial');
        $ip = $this->input->post('ip');
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/ip/address/print');
                $read = $api->read();
                $api->disconnect();
                foreach($read as $interface){
                    if($interface['disabled'] == 'false'){
                        $_data['address'] = $interface['address'];
                        $_data['name'] = $interface['actual-interface'];
                        $_data['serial'] = $serial;
                        $this->devices->updateIP($_data);
                    }
                }
                echo json_encode(array("status" => TRUE));
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function getResource(){
        $ip = $this->input->post('ip');
        if($ip == '10.10.10.1'){
            $user = $this->devices->getUserRouter(array('id' => '1111'));
        }else{
            $user = $this->devices->getUserRouter(array('id' => '2222'));
        }
        
        try{
            $api = $this->routerosapi;
            $api->port=$user['port'];
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/system/resource/print');
                $resource = $api->read();
                $api->write('/system/healt/print');
                $healt = $api->read();
                $api->disconnect();
                if($healt[0] != null){
                    if($ip == '10.10.10.1'){
                        $healt[0]['voltage'] = $healt[0]['cpu-temperature'].'˚C';
                    }else{
                        $healt[0]['voltage'] = $healt[0]['voltage'].'v';
                    }
                    $healt[0]['temperature'] = $healt[0]['temperature'].'˚C';
                    $_array = array_merge_recursive($resource[0],$healt[0]);
                    echo json_encode(array("status" => TRUE, "data" => $_array));
                }else{
                    $healt[0]['voltage'] = '';
                    $healt[0]['temperature'] = '';
                    $_array = array_merge_recursive($resource[0],$healt[0]);
                    echo json_encode(array("status" => TRUE, "data" => $_array));
                }  
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function setInterface($ip){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $serial = $this->input->post('serial');
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port=$user['port'];
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/interface/set',false);
                $api->write('=.id='.$id,false);
                $api->write('=name='.$name);
                $write = $api->read();
                $api->write('/interface/print');
                $read = $api->read();
                $api->disconnect();
                $this->devices->setInterface($serial, $id, array('name' => $name));
                $log = array(
                    'Message' =>  'Device interface changed by '.$this->session->userdata('username'),
                    'SysLogTag' => 'system,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log);
                echo json_encode(array("status" => TRUE, "msg" => $id." ".$name));
            }else{
                echo json_encode(array("status" => FALSE, "msg" => "gagal merubah nama interface"));
            }    
        }catch(exeption $e){
            echo $e;
        }
    }

    function getInterfaceChart(){
        // $ip = '10.10.10.3';
        date_default_timezone_set('Asia/Jakarta');
        $ip = $this->input->post('ip');
        $interface = $this->input->post('iface');
        // $interface = 'ether1';
        $user = $this->devices->getUserRouter(array('id' => '2222'));
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

    function reboot(){
        $ip = $this->input->post('ip');
        $identity = $this->input->post('identity');
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->comm('/system/reboot');
                $api->disconnect();
                $this->devices->updateStatus(array('address' => $ip),array('status' => 'Reboot'));
                $this->session->set_flashdata('devices', '<div class="alert alert-dismissable alert-success">
                <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Reboot Device '.$identity.' Berhasil!!
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>');
                $log = array(
                    'Message' =>  'Device '.$identity.' rebooted by '.$this->session->userdata('username'),
                    'SysLogTag' => 'devices,system,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log);
                $log1 = array(
                    'Message' =>  'Device '.$identity.' was rebooted',
                    'SysLogTag' => 'devices,device-reboot,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log1);
                echo json_encode(array("status" => TRUE));
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function delDevice(){
        // funtion menghapus data user hotspot di mikrotik dan database
        $serial = $this->input->post('serial');
        $identity = $this->input->post('identity');
        if($this->devices->delDevice(array('serial_number' => $serial))){
            if($this->devices->delInterfaces(array('serial_number' => $serial))){
                $this->session->set_flashdata('devices', '<div class="alert alert-dismissable alert-success">
                <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Menghapus Device '.$identity.' Berhasil !!
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>');
                $log = array(
                    'Message' =>  'Device '.$identity.' deleted by '.$this->session->userdata('username'),
                    'SysLogTag' => 'system,simonet',
                    'ReceivedAt' => date("Y-m-d H:i:s"),
                    'DeviceReportedTime' => date("Y-m-d H:i:s"),
                    'FromHost' => 'SIMONETapp'
                );
                $this->log_event->insertLogActivity($log);
                echo json_encode(array("status" => TRUE));
            }
        }else{
            echo json_encode(array("status" => FALSE));
        }
        
    }

    function cekMikroTik(){
        // $ip = $this->input->post('ip');
        $ip = '10.10.10.14';
        // $mac = '00:0C:42:E5:0D:C6';
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = 8728;
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/system/healt/print');
                $read = $api->read();
                $api->disconnect();
                echo json_encode(array("status" => ($read[0]==null)));
            }elseif($api->connect($mac,$user['username'],$user['password'])){
                echo "gae MAC";
                $api->disconnect();
            }else{
                echo "gak kenek";
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function downloadMikroTikOS(){
        $ip = $this->input->post('ip');
        $user = $this->devices->getUserRouter(array('id' => '2222'));
        try{
            $api = $this->routerosapi;
            $api->port = $user['port'];
            if($api->connect($ip,$user['username'],$user['password'])){
                $api->write('/system/package/update/download');
                $read = $api->read();
                foreach($read as $r){
                    if(isset($r['status'])){
                        $api->disconnect();
                        $status = $r['status'];
                    }else{
                        $api->disconnect();
                        $status = $r[0]['message'];
                        echo json_encode(array("status" => TRUE, "message" => $status));
                        die();
                    }
                }
                echo json_encode(array("status" => TRUE, "message" => $status));
                die();
                $api->disconnect();
            }else{
                echo json_encode(array("status" => FALSE, "message" => "gagal terhubung ke router"));
            }
        }catch(Exeption $error){
            echo json_encode(array("status" => FALSE));
        }
    }

    function setDefaultConfigMikroTik(){
        $ip = $this->input->post('ip');
        $ssh = new Net_SSH2($ip);
		if(!$ssh->login('admin', '')) {
            exit('Login Failed');
            echo json_encode(array("status" => FALSE, "ip" => $ip));
		}else{
            $config = $this->db->query("select * from devices_configuration");
            $cfg = $config->result_array(); 
            foreach ($cfg as $key) {
                if($key['id']!='1'){
                    try {
                        $ssh->exec($key['script']);
                    } catch (Exception $e) {
                        echo $e;
                    }
                }
            }
            echo json_encode(array("status" => TRUE, "ip" => $ip));
        }
    }

// UNIFI 
    function getUnifiDevices(){
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        // $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $aps_array        = $unifi_connection->list_devices();  
        $ip = $this->devices->getIPDevices();     
        // $_ap= array();
        foreach($aps_array as $ap){
            if(isset($ap->name)){
                if(!in_array($ap->ip, $ip)){
                    $_ap['id'] = $ap->device_id;
                    $_ap['address'] = $ap->ip;
                    $_ap['identity'] = $ap->name;
                    $_ap['serial'] = $ap->serial;
                    $_ap['version'] = $ap->version;
                    $_ap['model'] = $ap->model;
                    if($ap->model == 'US8P60'){
                        $_ap['platform'] = 'UniFi Switch';
                    }else{
                        $_ap['platform'] = 'UniFi';
                    }$_ap['mac'] = $ap->mac;
                    if(isset($ap->uptime)){
                        $_ap['uptime'] = $this->time_elapsed_B($ap->uptime); 
                    }else{
                        $_ap['uptime'] = null;    
                    }
                    if(isset($ap->rx_bytes)){
                        // $_ap['last_version'] = $ap->upgrade_to_firmware;
                        $_ap['tx_bytes'] = $ap->tx_bytes;
                        $_ap['rx_bytes'] = $ap->rx_bytes;
                    }else{
                        // $_ap['last_version'] = null;
                        $_ap['tx_bytes'] = null;
                        $_ap['rx_bytes'] = null; 
                    }
                    $_ap['aksi'] = "<a href='javascript:;' data-aksi='unifi' data-serial='".$_ap['serial']."' data-identity='".$_ap['identity']."' data-uptime='".$_ap['uptime']."' data-model='".$ap->model."' data-version='".$_ap['version']."' data-address='".$_ap['address']."' data-platform='".$_ap['platform']."' data-mac='".$_ap['mac']."' data-tx='".$_ap['tx_bytes']."' data-rx='".$_ap['rx_bytes']."' data-status='Connected'><i class='fa fa-plus'></i></a>";
                    $_aps_array[] = $_ap;
                }
            }
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $_aps_array,
            );
        echo json_encode($output);
        // echo "<pre>";
        // print_r($_aps_array);
        // print_r($ip);
    }

    function syncIdentitiesUniFi($serial){
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        // $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $aps_array        = $unifi_connection->list_devices();  
        foreach($aps_array as $ap){
            if($ap->serial == $serial){
                $_ap['id'] = $ap->device_id;
                $_ap['address'] = $ap->ip;
                $_ap['identity'] = $ap->name;
                $_ap['serial_number'] = $ap->serial;
                $_ap['version'] = $ap->version;
                $_ap['model'] = $ap->model;
                if($ap->model == 'US8P60'){
                    $_ap['platform'] = 'UniFi Switch';
                }else{
                    $_ap['platform'] = 'UniFi';
                }
                $_ap['mac'] = $ap->mac;
                if(isset($ap->uptime)){
                    $_ap['uptime'] = $this->time_elapsed_B($ap->uptime); 
                }else{
                    $_ap['uptime'] = null;    
                }
                if(isset($ap->rx_bytes)){
                    // $_ap['last_version'] = $ap->upgrade_to_firmware;
                    $_ap['tx_bytes'] = $ap->tx_bytes;
                    $_ap['rx_bytes'] = $ap->rx_bytes;
                }else{
                    // $_ap['last_version'] = null;
                    $_ap['tx_bytes'] = null;
                    $_ap['rx_bytes'] = null;
                }
                $identity['identity'] = $ap->name;
                $identity['serial'] = $ap->serial;
                $this->devices->syncdatadevice($identity,$_ap);
                $this->devices->syncinterfaces($_ap,$ap->serial);
                // echo json_encode(array("status" => TRUE));
            }
        }
    }

    function updateOSUniFi(){
        $mac = '04:18:d6:cc:21:90';
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        // $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $results = $unifi_connection->upgrade_device($mac);
        if($results == false){
            echo json_encode(array("status" => FALSE, "msg" => $results));
        }else{
            echo json_encode(array("status" => TRUE, "msg" => $results));
        }
    }

    function syncIPUniFiAll(){
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        // $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $aps_array        = $unifi_connection->list_devices();  
        foreach($aps_array as $ap){
            if(isset($ap->name)){
                $_ap['address'] = $ap->ip;
                $_ap['identity'] = $ap->name;
                if(isset($ap->uptime)){
                    $_ap['uptime'] = $this->time_elapsed_B($ap->uptime); 
                }else{
                    $_ap['uptime'] = null;    
                }
                $_ap['version'] = $ap->version;
                $_ap['serial_number'] = $ap->serial;
                $this->devices->updateDataUniFi($_ap);
            }
        }
        echo json_encode(array("status" => TRUE));
    }

    function upgradeAllUniFi(){
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $results = $unifi_connection->start_rolling_upgrade();
        $unifis = $this->devices->getDevicesBy(array('platform' => 'UniFi'));
        if($results == false){
            echo json_encode(array("status" => FALSE, "msg" => $results));
        }else{
            // foreach($unifis as $unifi){
            //     $this->devices->updateStatus(array('serial_number' => $unifi['serial_number']), array('status' => 'Upgrading..'));
            // }
            echo json_encode(array("status" => TRUE, "msg" => $results));
        }
    }

    function rebootUniFi(){
        // $mac = '80:2a:a8:c6:09:e8';
        $mac = $this->input->post('mac');
        $identity = $this->input->post('identity');
        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://10.10.10.115:8443', 'default', '5.10.25');
        // $set_debug_mode   = $unifi_connection->set_debug(true);
        $loginresults     = $unifi_connection->login();
        $results = $unifi_connection->restart_ap($mac);
        if($results == false){
            echo json_encode(array("status" => FALSE, "msg" => $results));
        }else{
            $log = array(
                'Message' =>  'Device '.$identity.' rebooted by '.$this->session->userdata('username'),
                'SysLogTag' => 'system,simonet',
                'ReceivedAt' => date("Y-m-d H:i:s"),
                'DeviceReportedTime' => date("Y-m-d H:i:s"),
                'FromHost' => 'SIMONETapp'
            );
            $this->log_event->insertLogActivity($log);
            $log1 = array(
                'Message' =>  'Device '.$identity.' was rebooted',
                'SysLogTag' => 'devices,device-reboot,simonet',
                'ReceivedAt' => date("Y-m-d H:i:s"),
                'DeviceReportedTime' => date("Y-m-d H:i:s"),
                'FromHost' => 'SIMONETapp'
            );
            $this->log_event->insertLogActivity($log1);
            $this->devices->updateStatus(array('mac_address' => $mac),array('status' => 'Reboot'));
            $this->session->set_flashdata('devices', '<div class="alert alert-dismissable alert-success">
            <i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> Reboot Device '.$identity.' Berhasil!!
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>');
            echo json_encode(array("status" => TRUE, "msg" => $results));
        }
    }

    function getLocation(){
        $zuko = new ZukoLibs;
        $output = $zuko->connect();
        $token = $output['data']['session_token'];
        $par = array(
            'filter' => array(),
            'limit' => 150,
            'offset' => 0,
        );

        $location = $zuko->get_ruang($token,$par);
        return $location;

    }

    function time_elapsed_B($secs){
        $bit = array(
            'y'        => $secs / 31556926 % 12,
            'w'        => $secs / 604800 % 52,
            'd'        => $secs / 86400 % 7,
            'h'        => $secs / 3600 % 24,
            'm'    => $secs / 60 % 60,
            's'    => $secs % 60
            );
           
        foreach($bit as $k => $v){
            if($v > 1)$ret[] = $v . $k;
            if($v == 1)$ret[] = $v . $k;
            }
        array_splice($ret, count($ret)-1, 0);
        // $ret[] = 'ago.';
       
        return join('', $ret);
        }
    
    
    function random_strings($length_of_string) { 
    
        // md5 the timestamps and returns substring 
        // of specified length 
        return substr(md5(time()), 0, $length_of_string); 
    } 

    
}

/* End of file Devices.php */
