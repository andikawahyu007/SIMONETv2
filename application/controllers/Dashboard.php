<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')== null){
            redirect(site_url('login'),'refresh');
        }
        $this->load->model('Dashboard_Model', 'dashboard');
        
        $this->load->model('Statistic_Model', 'statistic');
        $this->load->model('Hotspot_Model', 'hotspot');
        $this->load->model('Devices_Model', 'devices');
        date_default_timezone_set('Asia/Jakarta');
        
    }
    
    public function index(){
        // if($this->session->userdata('role')==='adm'){    
            $this->load->view('dashboard_view'); 
        // }
    }

    public function dashboard1(){
        $this->load->view('dashboard_view');
    }

    public function dashboard2(){
        $this->load->view('dashboard_view2');
    }

    //this function for get data interfaces from databases Mysql
    function interface()
    {
        date_default_timezone_set('Asia/Jakarta');
        $ether = $this->input->post('iface');
        $graphs = $this->statistic->getTrafficDashboard($ether);
        $row = array (
            'tx' => array(), 
			'rx' => array(), 
			// 'point' => array() 
        );
        foreach($graphs as $graph){
            $row['tx'][] = [strtotime($graph->time)*1000,round($graph->tx)];
			$row['rx'][] = [strtotime($graph->time)*1000,round($graph->rx)];
        }
        echo json_encode($row);
    }

    function total(){
        $data = array(
            'router' => count($this->devices->countDeviceByStatus(array('platform' => 'MikroTik', 'status' => 'Connected'))),
            'allrouter' => count($this->devices->countDeviceByStatus(array('platform' => 'MikroTik', 'status' => null))),
            'ap' => count($this->devices->countDeviceByStatus(array('platform' => 'UniFi', 'status' => 'Connected'))),
            'allap' => count($this->devices->countDeviceByStatus(array('platform' => 'UniFi', 'status' => null))),
            'connect' => count($this->countConnect()),
            'login' => count($this->countLogin())
        );
        echo json_encode(array("status" => TRUE, "data" => $data));
    }

    function countLogin(){
        // function untuk menghitung user yang sudah melakukan login
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect("10.10.10.1",$user['username'],$user['password'])){
                $api->write('/ip/hotspot/active/print');
                $read = $api->read();
                $api->disconnect();
                return $read;       
            }
        }catch(Exeption $error){
            return $error;
        }
    }

    function countConnect(){
        // function untuk menghitung user yang terhubung ke jaringan
        try{
            $api = $this->routerosapi;
            $user = $this->devices->getUserRouter(array('id' => '1111'));
            $api->port = $user['port'];
            if($api->connect("10.10.10.1",$user['username'],$user['password'])){
                $api->write('/ip/hotspot/host/print');
                $read = $api->read();
                $api->disconnect();
                return $read;       
            }
        }catch(Exeption $error){
            return $error;
        }
    }

    function readNotification(){
        //function untuk merubah status notifikasi ke terbaca
        $data = $this->dashboard->readNotification();
        echo json_encode(array("status" => TRUE));
    }

    function clearNotification(){
        // function untuk menghapus semua notifikasi
        $data = $this->dashboard->clearNotification();
        echo json_encode(array("status" => TRUE));
    }

    function getNotification(){
        // funtion untuk mengambil data notifikasi dari database
        $data = $this->dashboard->getNotification();
        date_default_timezone_set('Asia/Jakarta');
        $time = time();
        $_data = array();
        $date;
        foreach($data as $r){
            $date = $time - strtotime($r['time']);
            $r['time'] = $this->time_since($date);
            // $r['aksi'] = "<a href='#tabAddAdmin' data-toggle='tab' data-aksi='editAdmin' data-id='".$r['id']."'><i class='fa fa-pencil-square-o'></i></a>
            // <a href='javascript:;' data-toggle='tab' data-aksi='hapusAdmin' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
            $_data[] = $r;
        }
        // echo "<pre>";
        // print_r($_data);
        echo json_encode(array("status" => TRUE, "data" => $_data));
    }

// fitur setting
    function getAdmins(){
        // function untuk mengambil data admin dari database => fitur setting
        $data = $this->dashboard->getAdmins();
        foreach($data as $r){
            $r['aksi'] = "<a href='#tabAddAdmin' data-toggle='tab' data-aksi='editAdmin' data-id='".$r['id']."'><i class='fa fa-pencil-square-o'></i></a>
            <a href='javascript:;' data-toggle='tab' data-aksi='hapusAdmin' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
            $_data[] = $r;
        }
        // echo "<pre>";
        // print_r($_data);
        echo json_encode(array("status" => TRUE, "data" => $_data));
    }

    function getAdminByID(){
        // funtion untuk mengambil data admin berdasarkan id
        $id = $this->input->post('id');
        $data = $this->dashboard->getAdminbyID($id);
        echo json_encode(array("status" => TRUE, "data" => $data));
    }

    function setAdmin(){
        // funtion untuk merubah data admin 
        $id = $this->input->post('idAdmin');
        $pass = $this->input->post('passwordAdmin');
        if($this->input->post('passwordAdmin')!=''){
            $data = array(
                'username' => $this->input->post('userAdmin'),
                'password' => md5($pass),
                'email' => $this->input->post('emailAdmin'),
                'role' => $this->input->post('roleAdmin'),
            );
        }else{
            $data = array(
                'username' => $this->input->post('userAdmin'),
                'email' => $this->input->post('emailAdmin'),
                'role' => $this->input->post('roleAdmin'),
            );
        }
        if($this->dashboard->setAdmin($id,$data)){
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
    }

    function addAdmin(){
        // funtion untuk menambah data admin
        $data = array(
            'username' => $this->input->post('userAdmin'),
            'password' => $this->input->post('passwordAdmin'),
            'email' => $this->input->post('emailAdmin'),
            'role' => $this->input->post('roleAdmin')
        );
        if($this->dashboard->addAdmin($data)){
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
        
    }

    function delAdmin(){
        // funtion untuk menghapus user admin
        $id = $this->input->post('id');
        if($this->dashboard->delAdmin($id)){
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
    }

    function getDeviceAuth(){
        $data = $this->dashboard->getDeviceAuth();
        foreach($data as $r){
            $r['aksi'] = "<a href='javascript:;' data-aksi='editAuth' data-id='".$r['id']."'><i class='fa fa-pencil-square-o'></i></a>
            <a href='javascript:;' data-aksi='hapusAuth' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
            $_data[] = $r;
        }
        echo json_encode(array("status" => TRUE, "data" => $_data));
    }

    function getTemplateConfig(){
        $data = $this->dashboard->getTemplateConfig();
        foreach($data as $r){
            $r['aksi'] = "<a href='javascript:;' data-aksi='editConfig' data-id='".$r['id']."'><i class='fa fa-pencil-square-o'></i></a>
            <a href='javascript:;' data-aksi='hapusConfig' data-id='".$r['id']."' style='color : rgb(218,86,80)'><i class='fa fa-trash-o'></i></a>";
            $_data[] = $r;
        }
        echo json_encode(array("status" => TRUE, "data" => $_data));
    }

    //function tambahan

    function time_since($since) {
        // function untuk merubah tanggal menjadi string 
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
            array(1 , 'second')
        );
    
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }
    
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print.' ago';
    }
    
}

/* End of file Controllername.php */
