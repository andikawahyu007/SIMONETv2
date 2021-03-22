<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Topology extends CI_Controller {
    
    const node = array();

    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('username')== null){
            redirect(site_url('login'),'refresh');
        }
        $this->load->model('Devices_Model', 'devices');
        
    }

    public function index()
    {
        $this->load->view('topology_view');
    }

    public function getNodes(){
        $data = $this->devices->getdevices();
        $top = array();
        $links = array();
        $status;
        foreach($data as $device){
            if($device['address'] == '10.10.10.1'){
                $status = 'Connected';
            }else{
                $status = $device['status'];
            }
            $temp['nodes'][] = array(
                'id' => $device['serial_number'],
                'name' => $device['identity'],
                'ip' => $device['address'],
                'platform' => $device['platform'],
                'status' => $status
            );
            $link = $this->devices->getdevicesby(array('id_device' => $device['serial_number']));
            if($link != []){
                foreach($link as $dev){
                    $temp['links'][] = array(
                        'id' => rand(),
                        'source' => $device['serial_number'],
                        'target' => $dev['serial_number']
                    );
                }
            }
        }
        $top = $temp;
        echo json_encode(array("status" => TRUE, "data" => $top));
    }

    function getLinks(){
        // $data = $this->devices->getdevicesBy(array('id_device' => $device['serial_number']));
        // $top = array();
        // $link = array();
        // foreach($data as $device){
        //     $temp[] = array(
        //         'id' => $device['serial_number'],
        //         'name' => $device['identity']
        //     );
            
        // }
        // $top['nodes'] = $top;
        echo "<pre>";
        // echo json_encode($top);
        print_r($this->node);
    }

}

/* End of file Topology.php */
