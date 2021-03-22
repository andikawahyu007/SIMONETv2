<?php 

class Login_Model extends CI_Model{

    function login_val($username,$password){
        $this->db->where('username',$username);
        $this->db->where('password',md5($password));
        $result = $this->db->get('admin',1);
        return $result;
    }
}