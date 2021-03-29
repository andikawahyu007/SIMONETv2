<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Idle extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        // $this->load->model('idle_Model', 'idlepage');
        date_default_timezone_set('Asia/Jakarta');
        
    }

    public function index(){
            $this->load->view('idlepage');    
    }
}
?>



