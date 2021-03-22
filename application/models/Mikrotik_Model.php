<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mikrotik_Model extends CI_Model {

    function connect($connect=''){
        try{
            if(isset($connect)){
                $query = $this->db->query("select * from configuration where id='11111'");
                $user = $query->row_array();
                return $this->routerosapi->connect('10.10.10.1',$user['username'],$user['password'],$user['port']);
            }else{
                return $this->routerosapi->connect($connect['ip'],$connect['username'],$connect['password'],$connect['port']);
            }
        }catch(Exception $error){
            return $error;
        }
        
    }

}

/* End of file Mikrotik_Model.php */
