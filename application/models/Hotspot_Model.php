<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotspot_Model extends CI_Model {

    function pass($pass){
        $this->db->select('md5(md5(password('.$pass.'))) as password');
        $query = $this->db->get('');
        // $query = $this->db->query('Select md5(md5(password('.$pass.')))');
        return $query->row_array();
    }

    function addUserHotspot($data){
        $this->db->insert('user_hotspot', $data);
        // return $this->db->insert_id();
    }

    function getUserHotspot(){
        if($data = $this->db->get('user_hotspot')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getUserHotspotByName($name){
        $this->db->where($name);
        if($data = $this->db->get('user_hotspot')){
			return $data->row_array();
		}else{
			return false;
		}
    }

    function getUserHotspotByID($id){
        $this->db->where($id);
        if($data = $this->db->get('user_hotspot')){
			return $data->row();
		}else{
			return false;
		}
    }

    function delUserHotspot($id){
        $this->db->delete('user_hotspot',array('id' => $id));
        
    }

    function syncUserHotspot($data){
        try{
            foreach($data as $user){
                if(!isset($user['default'])){
                    $this->db->query("insert into user_hotspot(id,name,password,profile,uptime,bytes_in,bytes_out,disabled)
                    values ('".$user['.id']."','".$user['name']."','".$user['password']."','".$user['profile']."','".$user['uptime']."'
                    ,'".$user['bytes-in']."','".$user['bytes-out']."','".$user['disabled']."') 
                    ON DUPLICATE KEY UPDATE name = '".$user['name']."', password = '".$user['password']."', profile = '".$user['profile']."',
                    uptime = '".$user['uptime']."', bytes_in = '".$user['bytes-in']."', bytes_out = '".$user['bytes-out']."', disabled = '".$user['disabled']."';");
                }
            }
        }catch(Exception $e){
            return $e;
        }
    }

    function getUserProfile(){
        if($data = $this->db->get('user_profile')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getUserProfileByID($id){
        $this->db->where($id);
        if($data = $this->db->get('user_profile')){
			return $data->row();
		}else{
			return false;
		}
    }

    function addUserProfile($data){
        $this->db->insert('user_profile', $data);
        // return $this->db->insert_id();
    }
    
    function delUserProfile($id){
        $this->db->delete('user_profile',array('id' => $id));
        
    }

    function syncUserProfile($data){
        try{
            foreach($data as $profile){
                if($profile){
                    $this->db->query("insert into user_profile(id,name,session_timeout,status_autorefresh,shared_users,add_mac_cookie,rate_limit)
                    values ('".$profile['.id']."','".$profile['name']."','".$profile['session-timeout']."','".$profile['status-autorefresh']."','".$profile['shared-users']."'
                    ,'".$profile['add-mac-cookie']."','".$profile['rate-limit']."') 
                    ON DUPLICATE KEY UPDATE name = '".$profile['name']."', session_timeout = '".$profile['session-timeout']."', status_autorefresh = '".$profile['status-autorefresh']."',
                    shared_users = '".$profile['shared-users']."', add_mac_cookie = '".$profile['add-mac-cookie']."', rate_limit = '".$profile['rate-limit']."'");
                }
            }
        }catch(Exception $e){
            return false;
        }
    }
    function getMostActiveClient(){
        $query = 'SELECT * FROM user_hotspot ORDER BY bytes_out DESC LIMIT 4';
        return $this->db->query($query)->result_array();
    }

    function getMostActiveProfile(){
        $query = 'SELECT `profile`, SUM(bytes_in) as upload, SUM(bytes_out) as download FROM user_hotspot GROUP BY `profile` ORDER BY download DESC LIMIT 4';
        return $this->db->query($query)->result_array();
    }
}

/* End of file Hotspot_Model.php */
