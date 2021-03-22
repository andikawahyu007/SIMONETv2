<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Devices_Model extends CI_Model {

    function addDevice($data){
        $this->db->insert('devices', $data);
    }

    function setDevice($data){
        // $this->db->where('serial_number', $data['serial_number']);
        $this->db->where('id', $data['id']);
        $this->db->update('devices', $data);
    }

    function getDevices(){
        $this->db->order_by('identity', 'asc');
        if($data = $this->db->get('devices')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getDevicesBy($id){
        $this->db->where($id);
        if($data = $this->db->get('devices')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getDevice($id){
        $this->db->where($id);
        if($data = $this->db->get('devices')){
			return $data->row_array();
		}else{
			return false;
		}
    }

    function getLinks($id){
        $this->db->select('id');
        $this->db->where($id);
        if($data = $this->db->get('devices')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function countDeviceByStatus($filter){
        $this->db->like('platform', $filter['platform']);
        if($filter['status'] != null){
            $this->db->where('status',$filter['status']);
        }
        if($data = $this->db->get('devices')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getIPDevices(){
        $this->db->select('address');
        // $this->db->where('platform','MikroTik');
        // $this->db->or_where('platform','MikroTik Switch');
        $_ip = array();
        if($data = $this->db->get('devices')){
            $result = $data->result_array();
			foreach($result as $ip){
                $_ip[] = $ip['address'];
            }
            return $_ip;
		}else{
			return false;
		}
    }

    function syncDataDevice($identity,$device){
        try{
            // foreach($data as $device){
            if($device['platform'] == "MikroTik"){
                $this->db->where('serial_number', $identity['serial']);
                $this->db->update('devices', array('uptime' => $device['uptime'], 'version' => $device['version'], 
                'model' => $device['model'], 'platform' => $device['platform'], 'identity' => $identity['identity']));
            }elseif($device['platform'] == "UniFi"){
                $this->db->where('serial_number', $identity['serial']);
                $this->db->update('devices', array('address' => $device['address'],'uptime' => $device['uptime'], 'version' => $device['version'], 
                'model' => $device['model'], 'platform' => $device['platform'], 'identity' => $identity['identity']));
            }
        }catch(Exception $e){
            return $e;
        }
    }

    function getLocation(){
        if($data = $this->db->get('device_location')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getUserRouter($id){
        $this->db->where($id);
        if($data = $this->db->get('devices_user')){
			return $data->row_array();
		}else{
			return false;
		}
    }

    function getLastesROS(){
        $this->db->where(array('id' => '1'));
        if($data = $this->db->get('devices_configuration')){
            $result = $data->result_array();
            return $result[0]['script'];
        }else{
            return false;
        }
    }

    function getInterfaces($id){
        $this->db->where($id);
        if($data = $this->db->get('device_interfaces')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function setInterface($serial,$id,$data){
        $this->db->where('serial_number', $serial);
        $this->db->where('id_interface', $id);
        $this->db->update('device_interfaces', $data);
    }

    function syncInterfaces($data,$serial_number){
        try{
            if(isset($data['platform'])){
                $this->db->query("insert into device_interfaces(id_interface,name,address,mac_address,serial_number,rx_byte,tx_byte)
                values ('1','eth0','".$data['address']."','".$data['mac']."','".$serial_number."','".$data['rx_bytes']."','".$data['tx_bytes']."') 
                ON DUPLICATE KEY UPDATE id_interface = '1', name = 'eth0', address = '".$data['address']."', mac_address = '".$data['mac']."', serial_number = '".$serial_number."', rx_byte = '".$data['rx_bytes']."', tx_byte = '".$data['tx_bytes']."'");
            }else{
                foreach($data as $interface){
                    if(!isset($interface['default'])){
                        $this->db->query("insert into device_interfaces(id_interface,name,mac_address,serial_number,rx_byte,tx_byte)
                        values ('".$interface['.id']."','".$interface['name']."','".$interface['mac-address']."','".$serial_number."','".$interface['rx-byte']."','".$interface['tx-byte']."') 
                        ON DUPLICATE KEY UPDATE id_interface = '".$interface['.id']."', name = '".$interface['name']."', mac_address = '".$interface['mac-address']."', serial_number = '".$serial_number."', rx_byte = '".$interface['rx-byte']."', tx_byte = '".$interface['tx-byte']."'");
                    }
                }
            }
        }catch(Exception $e){
            return $e;
        }
    }

    function updateDataUniFi($data){
        $this->db->where('serial_number', $data['serial_number']);
        $this->db->update('devices', array('address' => $data['address'], 'version' => $data['version'], 'uptime' => $data['uptime'], 'identity' => $data['identity']));
    }

    function updateIP($data){
        $this->db->where('serial_number', $data['serial']);
        $this->db->where('name', $data['name']);
        $this->db->update('device_interfaces', array('address' => $data['address']));
    }

    function updateStatus($where,$data){
        $this->db->where($where);
        $this->db->update('devices', $data);
    }

    function delDevice($serial){
        if ($this->db->delete('devices',$serial)){
            return true;
        }else{
            return false;
        }
    }


    function delInterfaces($serial){
        if($this->db->delete('device_interfaces',$serial)){
            return true;
        }else{
            return false;
        }
    }

     
}

/* End of file Devices_Model.php */
