<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_Model extends CI_Model {

    function getLog(){
        $this->db->order_by('DeviceReportedTime', 'desc');
        $this->db->limit(2000);
        if($data = $this->db->get('SystemEvents')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function getLogModal(){
        $this->db->order_by('DeviceReportedTime', 'desc');
        $this->db->limit(500);
        if($data = $this->db->get('SystemEvents')){
			return $data->result_array();
		}else{
			return false;
		}
    }

    function insertLogActivity($data){
        $this->db->insert('SystemEvents', $data);
        return $this->db->insert_id();
    }

}

/* End of file Log_Model.php */
