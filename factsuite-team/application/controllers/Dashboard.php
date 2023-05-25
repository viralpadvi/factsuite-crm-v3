<?php

/**
 * Created 06-09-2021
 */
class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
      $this->load->database();
      $this->load->helper('url'); 
      $this->load->model('emailModel');  
      $this->load->model('smsModel');
      $this->load->model('utilModel');
      $this->load->model('DashboardModel');
    }


    function caseInventory(){
        $caseDetail['totalCase']=$this->db->get('candidate')->num_rows();
    }


}
?>