<?php

defined('BASEPATH') OR exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'third_party/phpseclib');
include(APPPATH . '/third_party/phpseclib/Net/SSH2.php');

require_once('application/libraries/Client.php');
require_once('application/libraries/ZukoLibs.php');

class Hotspot extends CI_Controller {

public $ip_router = "10.10.10.1";
public $ip_unifi = "10.10.10.43";
    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')=== null){
            redirect('login');
        }
        $this->load->model('Hotspot_Model','hotspot');
        $this->load->model('Devices_Model','devices');
    }
    

    public function index()
    {
        $a = $this->hotspot->pass('12345');
        print_r($a);
    }

    public function userHotspot(){
        // function untuk menampilkan halaman user hotspot
        $data['profile'] = $data = $this->hotspot->getuserprofile();
        $this->load->view('user_hotspot_view',$data);
    }

    public function userHotspotDetail()
    {
        // function untuk menampilkan halaman detail user hotspot 
        $name = $this->input->post('name');
        $user = $this->hotspot->getuserhotspotbyname(array('name'=> $name));
        $data1['profile_all'] = $data = $this->hotspot->getuserprofile();
        $data = array_merge($user,$data1);
        $this->load->view('user_hotspot_detail_view',$data);
        
    }

    function userHotspotJSON(){
        // function untuk mengget semua data user hotspot dari database
        $api = $this->routerosapi;
        $user = $this->devices->getUserRouter(array('id' => '1111'));
        $api->port = $user['port'];
        $_read = array();
        if($api->connect($this->ip_router,$user['username'],$user['password'])){
            $api->write('/ip/hotspot/user/print');
            $data = $api->read();
            $api->disconnect();
            foreach($data as $r){
                if($r['name']!='default-trial'){
                    $r['password'] = '************************';
                    $r['bytes_in'] = byte_format($r['bytes-in']); 
                    $r['bytes_out'] = byte_format($r['bytes-out']); 
                    if($this->session->userdata('role')==='adm'){    
                        $r['aksi'] = "<a href='javascript:;' data-aksi='edit' data-id='".$r['.id']."'><i class='fa fa-pencil-square-o'></i></a>
                        <a href='javascript:;' data-aksi='hapus' data-id='".$r['.id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
                    }else{
                        $r['aksi'] = '';
                    }
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

    function addUserHotspot(){
        // funtion untuk menyimpan data user hotspot ke mikrotik
        $pass = $this->hotspot->pass("'".$this->input->post('password')."'");
        $data = array(
            // 'id' => strtoupper($this->random_strings(8)),
            'name' => $this->input->post('name'),
            'password' => $pass['password'],
            'profile' => $this->input->post('profile')
        );
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/add',false);
			    $api->write('=name='.$data['name'], false );
			    $api->write('=password='.$data['password'], false );
			    $api->write('=profile='.$data['profile'] );
                $write = $api->read();
                $api->disconnect();
                // $this->hotspot->addUserHotspot($data);
                echo json_encode(array("status" => TRUE, "data" => $data));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function getUserHotspotByID(){
        // function untuk mengget data user hotspot by id
        $id = $this->input->post('id');
        $data = $this->hotspot->getuserhotspotbyid(array('id'=> '*'.$id));
        if($data){
            echo json_encode($data);
        }
    }

    function setUserhotspot(){
        // function untuk merubah data user hotspot dan menyimpannya ke mikrotik
        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'password' => $this->input->post('password'),
            'profile' => $this->input->post('profile')  
        );
        $pass = $this->hotspot->pass("'".$data['password']."'");
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/set',false);
			    $api->write('=.id='.$data['id'],false);
			    $api->write('=name='.$data['name'], false );
			    $api->write('=password='.$pass['password'], false );
			    $api->write('=profile='.$data['profile']);
                $write = $api->read();
                $api->disconnect();
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function delUserHotspot(){
        // funtion menghapus data user hotspot di mikrotik dan database
        $id = $this->input->post('id');
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/remove',false);
			    $api->write('=.id='.$id);
                $write = $api->read();
                $api->disconnect();
                $this->hotspot->deluserhotspot($id);
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function syncUserHotspot(){
        // function untuk mensyncronise data dari mikrotik ke database
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/print');
                $read = $api->read();
                $api->disconnect();        
                $this->hotspot->syncUserHotspot($read);  
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(Exeption $error){
            return $error;
        }
    }

    // FITUR USER PROFILE 
    public function userProfile(){
        // funtion untuk menampilkan halaman user profile
        $this->load->view('user_profile_view');
    }

    function userProfileJSON(){
        // funtion untuk mengget semua data user profile dari database
        $data = $this->hotspot->getuserprofile();
        $_data = array();
            foreach($data as $r){
                if($this->session->userdata('role')==='adm'){    
                    $r['aksi'] = "<a href='javascript:;' data-aksi='edit' data-id='".$r['id']."'><i class='fa fa-pencil-square-o'></i></a>
                    <a href='javascript:;' data-aksi='hapus' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
                }else{
                    $r['aksi'] = '';
                }
                $_data[] = $r;
            }
        $output = array(
            "draw" => $this->input->post('draw'),
            "data" => $_data,
        );
        echo json_encode($output);
    }

    function getUserProfileByID(){
        // funtion untuk mengget data user profile by id
        $id = $this->input->post('id');
        $data = $this->hotspot->getuserprofilebyid(array('id'=> $id));
        if($data){
            echo json_encode($data);
        }
    }

    function setUserProfile(){
        // funtion untuk merubah data user profile di mikrotik
        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'session_timeout' => $this->input->post('session'),
            'status_autorefresh' => $this->input->post('status'),
            'shared_users' => $this->input->post('shared'),
            'add_mac_cookie' => $this->input->post('cookie'),
            'rate_limit' => $this->input->post('limit')
        );
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/profile/set',false);
			    $api->write('=.id='.$data['id'],false);
			    $api->write('=name='.$data['name'], false );
			    $api->write('=session-timeout='.$data['session_timeout'], false );
			    $api->write('=status-autorefresh='.$data['status_autorefresh'], false );
			    $api->write('=shared-users='.$data['shared_users'], false );
			    $api->write('=add-mac-cookie='.$data['add_mac_cookie'], false );
			    $api->write('=rate-limit='.$data['rate_limit']);
                $write = $api->read();
                $api->disconnect();
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function addUserProfile(){
        // funtion untuk menambah data user profile di mikrotik 
        $data = array(
            'name' => $this->input->post('name'),
            'session_timeout' => $this->input->post('session'),
            'status_autorefresh' => $this->input->post('status'),
            'shared_users' => $this->input->post('shared'),
            'add_mac_cookie' => $this->input->post('cookie'),
            'rate_limit' => $this->input->post('limit')
        );
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/profile/add',false);
			    $api->write('=name='.$data['name'], false );
			    $api->write('=session-timeout='.$data['session_timeout'], false );
			    $api->write('=status-autorefresh='.$data['status_autorefresh'], false );
			    $api->write('=shared-users='.$data['shared_users'], false );
			    $api->write('=add-mac-cookie='.$data['add_mac_cookie'], false );
			    $api->write('=rate-limit='.$data['rate_limit']);
                $write = $api->read();
                $api->disconnect();
                echo json_encode(array("status" => TRUE, "data" => $data));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function delUserProfile(){
        // funtion untuk menghapust user profile di mikrotik dan database
        $id = $this->input->post('id');
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/profile/remove',false);
			    $api->write('=.id='.$id);
                $write = $api->read();
                $api->disconnect();
                $this->hotspot->deluserprofile($id);
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }

    function syncUserProfile(){
        // funtion untuk mensyncronise data dari mikrotik ke database
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/user/profile/print');
                $read = $api->read();
                $api->disconnect();
                $this->hotspot->syncUserProfile($read); 
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE));
            }
        }catch(Exeption $error){
            return $error;
        }
    }

    // FITUR USER ACTIVE

    public function userActive(){
        // function untuk menampilkan halaman user active
        $this->load->view('user_aktif_view');
    }

    public function userTrack(){
        // function untuk menampilkan halaman lokasi user
        $this->load->view('user_track_view');
    }


    function userActiveJSON(){
        // function untuk mengget semua data user active dari Mikrotik
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            $_read = array();
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/active/print');
                $read = $api->read();
                $api->disconnect();
                foreach($read as $r){
                    $r['id'] = $r['.id'];
                    $r['bytes-in'] = byte_format($r['bytes-in']); 
                    $r['bytes-out'] = byte_format($r['bytes-out']);     
                    $r['aksi'] = "<a href='javascript:;' data-aksi='hapus' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
                    $_read[] = $r;
                }        
            }
            $output = array(
                // "draw" => $this->input->post('draw'),
                "data" => $_read,
            );
            echo json_encode($output);       
        }catch(Exeption $error){
            return $error;
        }
    }

    function userTrackJSON(){
        // function untuk mengget semua data lokas user active dari UNIFI
        $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            $_read = array();
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/active/print');
                $read = $api->read();
                $api->disconnect();
                foreach($read as $r){
                    $_read[$r["mac-address"]] = $r;
                }        
            }
            $user_aktif = array(
                // "draw" => $this->input->post('draw'),
                "data" => $_read,
            );
            

        $user = $this->devices->getUserRouter(array('id' => '3333'));
        $unifi_connection = new UniFi_API\Client($user['username'], $user['password'], 'https://114.4.32.190:8443', '3pp0jtfi', '5.13.32');
        $set_debug_mode   = $unifi_connection->set_debug(false);
        $loginresults     = $unifi_connection->login();
        $aps_array        = $unifi_connection->list_clients();
        $device           = $unifi_connection->list_devices();
        
        $_devices = array();
        foreach($device as $d){
            $_devices[$d->mac] = $d;
        }

        // echo json_encode($d);

        $_aps_array = [];

        // foreach($devices as $dvc){
        //     if ()
        // }

        foreach($aps_array as $aps){
            // print_r($aps);
            // print_r($_aps_array);
            $aps->hostname = "";
            if (isset($aps->mac) && isset($_read[strtoupper($aps->mac)]))
                $aps->hostname = $_read[strtoupper($aps->mac)]["user"];
                $aps->mac = strtoupper($aps->mac);
            if (isset($aps->ap_mac) && isset($_devices[$aps->ap_mac]))
                $aps->ap_mac = $_devices[$aps->ap_mac]->name;
            $_aps_array[] = $aps;
        }

        // echo json_encode($_read);
        echo json_encode($_aps_array);
        // echo json_encode($user_aktif);
        // echo(json_encode($aps_array));

        // var_dump($unifi_connection->is_loggedin);
        // print_r($unifi_connection);
        // print_r($loginresults);
        // var_dump($aps_array);
    }

    function delUserActive(){
        // funtion untuk menghapus user active di mikrotik
        $id = $this->input->post('id');
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect($this->ip_router,$user['username'],$user['password'])){
                $api->write('/ip/hotspot/active/remove',false);
			    $api->write('=.id='.$id);
                $write = $api->read();
                $api->disconnect();
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => TRUE));
            }
        }catch(exeption $e){
            echo $e;
        }
    }
    function random_strings($length_of_string) { 
    
        // md5 the timestamps and returns substring 
        // of specified length 
        return substr(md5(time()), 0, $length_of_string); 
    } 
}

/* End of file Hotspot.php */
